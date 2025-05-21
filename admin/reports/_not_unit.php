<table class="table table-hover table-striped table-bordered" id="report-list">
    <colgroup>
        <col width="5%">
        <col width="20%">
        <col width="20%">
        <col width="25%">
        <col width="15%">
        <col width="15%">
    </colgroup>
    <thead>
        <tr>
            <th>#</th>
            <th>Ngày bán</th>
            <th>Số HĐ</th>
            <th>Khách hàng</th>
            <th>Hình thức TT</th>
            <th>Nhân viên</th>
            <th>Tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        $i = 1;
        $where = "";
        if ($user_id > 0) {
            $where .= " and `user_id` = '{$user_id}' ";
        }
        if ($payment_type != '' && $payment_type != 'all') {
            $where .= " and payment_type = '{$payment_type}'";
        }

        
        $group_by = '';
        if($category_id > 0){
            $sql = "SELECT sum(s.price*s.qty) as amount, sl.date_updated , sl.date_created, sl.code, sl.client_name, payment_type, concat(u.firstname, ' ', u.lastname) as `fullname` 
            FROM `sale_products` as s
            JOIN sale_list sl ON sl.id=s.sale_id
            LEFT JOIN users as u on sl.user_id=u.id
            JOIN product_list p ON p.id=s.product_id
            JOIN category_list c ON c.id=p.category_id
            where sl.deleted_flag=0 and date(sl.date_created) between '{$date}' and '{$date_to}' and c.id='{$category_id}' {$where}
            group by  sl.date_updated , sl.date_created, sl.code, sl.client_name, payment_type, u.firstname, u.lastname";
        }else{
            $sql = "SELECT s.amount, s.date_updated , s.date_created, s.code, s.client_name, payment_type, concat(u.firstname, ' ', u.lastname) as `fullname` 
            FROM `sale_list` as s
            LEFT JOIN users as u on s.user_id=u.id
            where s.deleted_flag=0 and date(s.date_created) between '{$date}' and '{$date_to}' {$where}
            order by unix_timestamp(s.date_updated) desc ";
        }
        //$users_qry = $conn->query("SELECT id, concat(firstname, ' ', lastname) as `name` FROM `users` where id in (SELECT user_id FROM `sale_list` where date(date_created) = '{$date}' {$where}) ");
        //$user_arr = array_column($users_qry->fetch_all(MYSQLI_ASSOC), 'name', 'id');
        // $user_arr = [];
        // while ($rowu = $users_qry->fetch_assoc()) {
        //     $user_arr[$rowu['id']] = $rowu['name'];
        // }

        $qry = $conn->query($sql);
        if ($qry->num_rows > 0)
            while ($row = $qry->fetch_assoc()) :
                $total += $row['amount'];
        ?>
            <tr>
                <td class="text-center"><?php echo $i++; ?></td>
                <td>
                    <p class="m-0"><?= date("d/m/Y H:i", strtotime($row['date_updated'])) ?></p>
                </td>
                <td>
                    <p class="m-0"><?= $row['code'] ?></p>
                </td>
                <td>
                    <p class="m-0"><?= $row['client_name'] ?></p>
                </td>
                <td>
                    <p class="m-0"><?= PAYMENT_METHOD[$row['payment_type']] ?></p>
                </td>
                <td class=''><?= $row['fullname'] ?></td>
                <td class='text-right'><?= number_format($row['amount'], 0) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" class="text-center">Tổng tiền</th>
            <th class="text-right"><?= number_format($total, 0) ?></th>
        </tr>
    </tfoot>
</table>