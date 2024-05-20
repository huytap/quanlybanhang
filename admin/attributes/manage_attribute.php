<?php

require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `attributes` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="container-fluid">
	<form action="" id="attribute-form">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="name" class="control-label">Tên</label>
			<input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Tên</label>
			<select name="type" class="form-control form-control">
				<?php
				foreach(ATTR as $key => $attr){
					if($key == $type){
						echo '<option selected="selected" value="'.$key.'">'.$attr.'</option>';
					}else{
						echo '<option value="'.$key.'">'.$attr.'</option>';
					}
				} 
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Giá</label>
			<input type="text" name="price" id="price" class="form-control form-control-sm rounded-0" value="<?php echo isset($price) ? $price : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Mô tả</label>
			<textarea type="text" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
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
		$('#attribute-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_attribute",
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
						$("html, body").animate({
							scrollTop: _this.closest('.card').offset().top
						}, "fast");
						end_loader()
					} else {
						alert_toast("An error occured", 'error');
						end_loader();
						console.log(resp)
					}
				}
			})
		})

	})
</script>