<?php

require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `promotion` where id = '{$_GET['id']}' ");
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
			<label for="description" class="control-label">Mô tả</label>
			<textarea type="text" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="discount_type" class="control-label">Hình thức giảm giảm</label>
			<select name="discount_type" id="discount_type" class="form-control form-control-sm rounded-0" required>
				<option value="">Chọn hình thức giảm</option>
				<?php foreach(PROMOTION_TYPE as $k => $v){
					if(isset($discount_type) && $k == $discount_type){
						echo '<option selected="selected" value="'.$k.'">'.$v.'</option>';
					}else{
						echo '<option value="'.$k.'">'.$v.'</option>';
					}
				}?>
			</select>
		</div>
		<div class="form-group">
			<label for="category_apply" class="control-label">Danh mục sản phẩm áp dụng</label>
			<br>
			<?php
				$qry_cate = $conn->query("SELECT `id`, `name` from `category_list` where delete_flag=0");
				if ($qry_cate->num_rows > 0) {
					$cate=[];
					if(isset($category_apply))
					$cate = json_decode($category_apply, true);
					while ($row = $qry_cate->fetch_assoc()) :
						echo '<div class="form-check-inline">
								<label class="form-check-label">';
						if(in_array($row['id'], $cate)){
							echo '<input type="checkbox" class="form-check-input" name="category_apply[]" checked="checked" value="'.$row['id'].'">';
						}else{
							echo '<input type="checkbox" class="form-check-input" name="category_apply[]" value="'.$row['id'].'">';
						}
						echo $row['name'].'</label></div>';
					endwhile;
				} 
			?>
		</div>
		<div class="form-group <?php if(isset($discount_type) && $discount_type == 'PRODUCT') echo ''; else echo 'd-none';?>" id="product_type_list">
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
		<div class="form-group <?php if(isset($discount_type) && $discount_type == 'PRODUCT' && isset($product_type) && $product_type == 'LIST') echo ''; else echo 'd-none';?>" id="product_list">
			<label for="product_ids" id="lblProduct" class="control-label<?php if(isset($discount_type) && $discount_type == 'PRODUCT' && isset($product_type) && $product_type == 'LIST') echo ''; else echo 'd-none';?>">Sản phẩm áp dụng</lable>
			<label for="product_ids" id="lblOther" class="control-label <?php if(isset($discount_type) && $discount_type != 'PRODUCT') echo ''; else echo 'd-none';?>">Sản phẩm tặng kèm</label>
			<?php
			$pIds = array();
			if(isset($product_ids))
				$pIds = json_decode($product_ids, true);
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
							<input name="product_ids[]" <?=$checked;?> type="checkbox" class="form-check-input" value="<?=$row['id'];?>"><?=$row['name'];?>
						</label>
					</div>
					<?php
				endwhile;
			}
			?>
		</div>
		<div class="form-group d-none" id="discount_value">
			<label for="discount" class="control-label">Giá trị giảm</label>
			<input type="number" name="discount" id="discount" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($discount) ? $discount : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="min_amount" class="control-label">Áp dụng cho đơn hàng giá trị tối thiểu</label>
			<input type="number" name="min_amount" id="min_amount" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($min_amount) ? $min_amount : ''; ?>" required />
		</div>
		<div id="quantity_product" class="<?php if(isset($discount_type) && $discount_type == 'PRODUCT') echo '';else echo 'd-none';?>">
			<div class="form-group">
				<label for="buy" class="control-label">Số lượng mua</label>
				<input type="number" name="buy" id="buy" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($buy) ? $buy : ''; ?>" required />
			</div>
			<div class="form-group">
				<label for="gift" class="control-label">Số lượng tặng</label>
				<input type="number" name="gift" id="gift" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($gift) ? $gift : ''; ?>" required />
			</div>
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
		
		$('#discount_type').change(function(){
			if($(this).val() == 'PRODUCT'){
				$('#product_type_list').removeClass('d-none')
				$('#discount_value').addClass('d-none')
				$('#quantity_product').removeClass('d-none')
				$('#lblProduct').removeClass('d-none')
				$('#lblOther').addClass('d-none')
			}else{
				$('#product_type_list').addClass('d-none')
				$('#discount_value').removeClass('d-none')
				$('#quantity_product').addClass('d-none')
				$('#lblOther').removeClass('d-none')
				$('#lblProduct').addClass('d-none')
			}
		})
		
		$('#product_type').change(function(){
			if($(this).val() == 'LIST'){
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