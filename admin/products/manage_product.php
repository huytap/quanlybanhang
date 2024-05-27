<?php

require_once('../../config.php');
$has_attribute = 0;
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT P.*, P.name as `product`, C.has_attribute from `product_list` P left join `category_list` C on P.category_id=C.id where P.id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="container-fluid">
	<form action="" id="product-form">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="category_id" class="control-label">Danh mục</label>
			<select name="category_id" id="category_id" class="form-control form-control-sm rounded-0" required>
				<option value="" disabled <?= !isset($category_id) ? "selected" : "" ?>></option>
				<?php
				$qry = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 " . (isset($id) ? " or id = '{$category_id}' " : "") . " order by `name` asc");
				while ($row = $qry->fetch_array()) :
				?>
					<option value="<?= $row['id'] ?>" <?php echo isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Món</label>
			<input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Mô tả</label>
			<textarea type="text" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Giá</label>
			<input type="number" name="price" id="price" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($price) ? $price : ''; ?>" required />
			<?php if($has_attribute == 1){?>
			<br>
			<label for="upsize" class="control-label">Up size</label>
			<input type="number" name="upsize" id="upsize" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($upsize) ? $upsize : ''; ?>" />
			<br>
			<?php 
				$qry = $conn->query("SELECT id, `name`, `price` from `attributes` where type=0 and price>0 and delete_flag=0 order by `name`desc ");
				if ($qry->num_rows > 1) {
					$i=1;
					while ($row = $qry->fetch_assoc()) :
						//kiểm tra giá
						$attrPrice = '';
						if(isset($id)){
							$query = $conn->query("SELECT `price` from `product_attributes` where product_id='".$id."' and attribute_id='".$row['id']."' and delete_flag=0");
							if ($query->num_rows > 0) {
								while($check = $query->fetch_assoc()){
									$attrPrice = $check['price'];
								}
							}
						}
						?>
						<label for=""><?php echo $row['name'];?></label>
						<input type="number" name="price[<?php echo $row['id'];?>]" id="price_<?php echo $i;?>" class="form-control form-control-sm rounded-0 text-right" value="<?php echo $attrPrice; ?>" required />
					<?php 
					$i++;
					endwhile;
				}	
			}		
			?>
		</div>		
		<div class="form-group">
			<label for="attribute_category" class="control-label">Thuộc tính áp dụng</label>
			<br>
			<?php
			$cate = json_decode($attribute_category, true);
			foreach(ATTR as $k => $n){
				echo '<div class="form-check-inline">
								<label class="form-check-label">';
				if($cate && in_array($k, $cate)){
					echo '<input type="checkbox" class="form-check-input" name="attribute_category[]" checked="checked" value="'.$k.'">';
				}else{
					echo '<input type="checkbox" class="form-check-input" name="attribute_category[]" value="'.$k.'">';
				}
				echo $n.'</label></div>';
			}
				?>
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
		$('#product-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_product",
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

	})
</script>