<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Bán hàng</h3>
		<div class="card-tools">
			<a href="./?page=sales/manage_sale" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Tạo đơn mới</a>
		</div>
	</div>
	<div class="card-body p-0 p-lg-4">
		<table class="table table-hover table-striped table-bordered">
			<colgroup>
				<col width="5%">
				<col width="20%">
				<col width="10%">
				<col width="15%">
				<col width="15%">
				<col width="15%">
			</colgroup>
			<thead>
				<tr>
					<th>#</th>
					<th>Ngày bán</th>
					<th>Số HĐ</th>
					<!-- <th>Khách hàng</th>
							<th>Hình thức TT</th> -->
					<th>Tiền</th>
					<th>Trạng thái</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				if ($_settings->userdata('type') == 3) :
					$qry = $conn->query("SELECT * FROM `sale_list` 
								WHERE deleted_flag = 0 
								AND user_id = '{$_settings->userdata('id')}'
								AND YEAR(date_created) = 2025
								ORDER BY status ASC, unix_timestamp(date_created) DESC ");
				else :
					$qry = $conn->query("SELECT * FROM `sale_list` 
								WHERE deleted_flag = 0 
								AND YEAR(date_created) = 2025
								ORDER BY date_created DESC ");
				endif;
				while ($row = $qry->fetch_assoc()) :
				?>
					<tr>
						<td class="text-center"><?php echo $i++; ?></td>
						<td>
							<p class="m-0 truncate-1"><?= date("M d, Y H:i", strtotime($row['date_updated'])) ?></p>
						</td>
						<td>
							<p class="m-0 truncate-1"><?= $row['code'] ?></p>
						</td>
						<!-- <td>
									<p class="m-0 truncate-1"><?= $row['client_name'] ?></p>
								</td>
								<td>
									<p class="m-0"><?= PAYMENT_METHOD[$row['payment_type']] ?></p>
								</td> -->
						<td class='text-right'><?= format_num($row['amount'], 0) ?></td>
						<td class="text-center">
							<?php
							if ($row['status'] == 1) {
								echo '<span class="btn btn-primary">Đã TT</span>';
							} else {
								echo '<span class="btn btn-warning">Chưa TT</span>';
							}
							?>
						</td>
						<td align="center">
							<a class="btn btn-default bg-gradient-light btn-flat btn-sm" href="?page=sales/view_details&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> <span class="d-none d-lg-inline-block">Xem</span></a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(document).ready(function() {

		$('.table').dataTable({
			columnDefs: [{
				orderable: false,
				targets: [5]
			}],
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	setTimeout(function() {
		$('#DataTables_Table_0_wrapper>.row:first-child').hide()

	}, 1000)
</script>