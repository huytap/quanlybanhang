<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Danh sách món</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Tạo mới</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Ngày tạo</th>
						<th>Danh mục</th>
						<th>Món</th>
						<th>Giá</th>
						<th>Trạng thái</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$sql = "SELECT p.*, c.name as `category` 
					from `product_list` p 
					inner join category_list c on p.category_id = c.id 
					where p.delete_flag = 0 order by c.`name`,p.`name` asc ";

					$qry = $conn->query($sql);
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['category'] ?></td>
							<td><?php echo $row['name'] ?></td>
							<td class="text-right">
								<?php 
								// //$query = $conn->query("SELECT `price`, a.name from `product_attributes` pa left join attributes a on pa.attribute_id=a.id where product_id='".$row['id']."' and pa.delete_flag=0");
								// if ($query->num_rows > 0) {
								// 	while($check = $query->fetch_assoc()){
								// 		$attrPrice = $check['price'];
								// 		echo $check['name'].': '. number_format($check['price']);
								// 		echo '<br/>';
								// 	}
								// }else{
								// 	echo format_num($row['price'], 0);
								// }
								echo number_format($row['price']);
								// if($row['upsize'] > 0){
								// 	$query = $conn->query("SELECT `price` from `attributes` where `type`=0 and `delete_flag`=0");
								// 	if ($query->num_rows > 0) {
								// 		echo format_num($row['price']);
								// 	}
								// }
								?>
							</td>
							<td class="text-center">
								<?php if ($row['status'] == 1) : ?>
									<span class="badge badge-success px-3 rounded-pill">Hoạt động</span>
								<?php else : ?>
									<span class="badge badge-danger px-3 rounded-pill">Ẩn</span>
								<?php endif; ?>
							</td>
							<td align="center">
								<button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Xem</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Sửa</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Xóa</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Bạn có chắc chắn muốn xóa món này không?", "delete_product", [$(this).attr('data-id')])
		})
		$('#create_new').click(function() {
			uni_modal("<i class='fa fa-plus'></i> Tạo mới", "products/manage_product.php")
		})
		$('.view_data').click(function() {
			uni_modal("<i class='fa fa-bars'></i> Chi tiết", "products/view_product.php?id=" + $(this).attr('data-id'))
		})
		$('.edit_data').click(function() {
			uni_modal("<i class='fa fa-edit'></i> Cập nhật", "products/manage_product.php?id=" + $(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [{
				orderable: false,
				targets: [6]
			}],
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})

	function delete_product($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_product",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An error occured.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occured.", 'error');
					end_loader();
				}
			}
		})
	}
</script>