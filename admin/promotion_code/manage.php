<?php

require_once('../../config.php');
$has_attribute = 0;
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `promotion_code` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="container-fluid">
	<form action="" id="promotion-form">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="name" class="control-label">Tên chương trình</label>
			<input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="code" class="control-label d-block">Mã giảm</label>
			<input type="text" style="width: 79%;" name="code" id="code" class="form-control pt-0 d-inline-block form-control-sm rounded-0" value="<?php echo isset($code) ? $code : ''; ?>" required />
			<button type="button" style="width: 20%;" class="d-inline-block btn btn-primary" onclick="makeCode()">Tạo mã</button>
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Mô tả</label>
			<textarea type="text" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="type" class="control-label">Hình thức giảm giảm</label>
			<select name="type" id="type" class="form-control form-control-sm rounded-0" required>
				<option value="">Chọn hình thức giảm</option>
				<?php foreach(PROMOTION_TYPE as $k => $v){
					if($k == $type){
						echo '<option selected="selected" value="'.$k.'">'.$v.'</option>';
					}else{
						echo '<option value="'.$k.'">'.$v.'</option>';
					}
				}?>
			</select>
		</div>
		<div class="form-group <?php if($type == '2') echo ''; else echo 'd-none';?>" id="product_type_list">
			<label for="product_type" class="control-label">Loại sản phẩm tặng kèm</label>
			<select name="product_type" id="product_type" class="form-control form-control-sm rounded-0" required>
				<option value="">Chọn loại sản phẩm tặng kèm</option>
				<?php
				foreach(PRODUCT_GIFT as $k => $v){
					if($k == $product_type){
						echo '<option selected="selected" value="'.$k.'">'.$v.'</option>';
					}else{
						echo '<option value="'.$k.'">'.$v.'</option>';
					}
				}?>
			</select>
		</div>
		<div class="form-group <?php if($type == '2' && $product_type == '1') echo ''; else echo 'd-none';?>" id="product_list">
			<label for="product_ids" class="control-label d-block">Sản phẩm tặng kèm</label>
			<?php
			$pIds = explode(',', $product_ids);
			$pSql = "SELECT `id`, `name`
						FROM `product_list`
						WHERE `delete_flag`=0
						ORDER BY category_id";
			$pQry = $conn->query($pSql);
			if ($pQry->num_rows > 0) {
				while ($row = $pQry->fetch_assoc()) :
					$checked='';
					if(in_array($row['id'], $pIds)){
						$checked='checked="checked"';
					}
					?>
					<div class="form-check-inline">
						<label class="form-check-label">
							<input <?=$checked;?> type="checkbox" class="form-check-input" value="<?=$row['id'];?>"> <?=$row['name'];?>
						</label>
					</div>
					<?php
				endwhile;
			}
			?>
		</div>
		<div class="form-group">
			<label for="discount" class="control-label">Giá trị giảm</label>
			<input type="number" name="discount" id="discount" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($discount) ? $discount : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="min_amount" class="control-label">Áp dụng cho đơn hàng giá trị tối thiểu</label>
			<input type="number" name="min_amount" id="min_amount" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($discount) ? $discount : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="quantity" class="control-label">Số lượng mã giảm</label>
			<input type="number" name="quantity" id="quantity" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($quantity) ? $quantity : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="" class="control-label">Áp dụng</label>
			<div class="row">
				<div class="col-6">
					<label for="">Từ ngày</label>
					<input type="date" name="from_date" id="from_date" class="form-control form-control-sm rounded-0 text-right" placeholder="Từ ngày" value="<?php echo isset($from_date) ? $from_date : ''; ?>" required />
				</div>
				<div class="col-6">
					<label for="">Tới ngày</label>
					<input type="date" name="to_date" id="to_date" class="form-control form-control-sm rounded-0 text-right" placeholder="Tới ngày" value="<?php echo isset($to_date) ? $to_date : ''; ?>" required />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Trạng thái</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Hoạt động</option>
				<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Ẩn</option>
			</select>
		</div>
	</form>
</div>
<script>
	$(document).ready(function() {
		$('#uni_modal').on('shown.bs.modal', function() {
			$('#category_id').select2({
				placeholder: "Please select here",
				width: '100%',
				dropdownParent: $('#uni_modal'),
				containerCssClass: 'form-control form-control-sm rounded-0'
			})
		})
		$('#promotion-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_promotion",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				error: err => {
					console.log(err)
					alert_toast("An error occured", 'error');
					end_loader();
				},
				success: function(resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						location.reload()
					} else if (resp.status == 'failed' && !!resp.msg) {
						var el = $('<div>')
						el.addClass("alert alert-danger err-msg").text(resp.msg)
						_this.prepend(el)
						el.show('slow')
						$("html, body,.modal").scrollTop(0);
						end_loader()
					} else {
						alert_toast("An error occured", 'error');
						end_loader();
					}
				}
			})
		})
		
		$('#type').change(function(){
			if($('#type').val() == 2){
				$('#product_type_list').removeClass('d-none')
			}else{
				$('#product_type_list').addClass('d-none')
			}
		})
		
		$('#product_type').change(function(){
			if($(this).val() == 1){
				$('#product_list').removeClass('d-none')
			}else{
				$('#product_list').addClass('d-none')
			}
		})
	})

	function makeCode() {
		let result = '';
		const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		const charactersLength = 8;
		let counter = 0;
		while (counter < charactersLength) {
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
			counter += 1;
		}
		$('#code').val(result)
		return result;
	}
</script>