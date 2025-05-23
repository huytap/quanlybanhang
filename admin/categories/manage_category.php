<?php

require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `category_list` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="container-fluid">
	<form action="" id="category-form">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="name" class="control-label">Tên</label>
			<input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="group_id" class="control-label">Nhóm</label>
			<select name="group_id" id="group_id" class="form-control form-control-sm rounded-0" required>
				<option value="">Chọn nhóm</option>
				<?php
				foreach(MAIN as $m => $main){
					echo '<option value="'.$m.'" '.($m == $group_id ? 'selected':'').'>'.$main.'</option>';
				} 
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Mô tả</label>
			<textarea type="text" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="has_attribute" class="control-label">Có nhiều Size</label>
			<select name="has_attribute" id="has_attribute" class="form-control form-control-sm rounded-0" required>
				<option value="1" <?php echo isset($has_attribute) && $has_attribute == 1 ? 'selected' : '' ?>>Có</option>
				<option value="0" <?php echo isset($has_attribute) && $has_attribute == 0 ? 'selected' : '' ?>>Không</option>
			</select>
		</div>
		<div class="form-group">
			<label for="has_print_tem" class="control-label">Có in tem không</label>
			<select name="has_print_tem" id="has_print_tem" class="form-control form-control-sm rounded-0" required>
				<option value="1" <?php echo isset($has_print_tem) && $has_print_tem == 1 ? 'selected' : '' ?>>Có</option>
				<option value="0" <?php echo isset($has_print_tem) && $has_print_tem == 0 ? 'selected' : '' ?>>Không</option>
			</select>
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
		$('#category-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_category",
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