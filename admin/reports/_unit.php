<table class="table table-hover table-striped table-bordered" id="report-list">
    <colgroup>
        <col width="5%">
        <col width="20%">
        <col width="30%">
        <col width="25%">
    </colgroup>
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">Ngày bán</th>
            <th colspan="2">Số lượng</th>
            <th rowspan="2">Tổng tiền</th>
        </tr>
        <tr>
            <th>Size M</th>
            <th>Size L</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        $totalQty = 0;
        $i = 1;
        $where = "";
        //if($unit == 2)
        if ($user_id > 0) {
            $where .= " and `user_id` = '{$user_id}' ";
        }
        // if($payment_type != '' && $payment_type != 'all'){
        //     $where .= " and payment_type = '{$payment_type}'";
        // }
        if($category_id > 0){
            $where .= " and `category_id` = '{$category_id}' ";
        }
        $sql = "SELECT SUM(sp.price) amount, sum(sp.qty) qty, date(s.date_created) date_created
                FROM `sale_list` as s
                LEFT JOIN users as u on s.user_id=u.id
                LEFT JOIN sale_products sp on sp.sale_id=s.id
                LEFT JOIN product_list pl ON pl.id=sp.product_id";
        if($category_id > 0){
            $sql .= " LEFT JOIN category_list c on c.id=pl.category_id";
        }
        $sql .= " where unit='{$unit}' and s.deleted_flag=0 and date(s.date_created) between '{$date}' and '{$date_to}' {$where}
                GROUP BY date(s.date_created), pl.unit";
        if ($user_id > 0) {
            $sql .= ", '{$user_id}'";
        }
        $sql .= " order by unix_timestamp(s.date_created) desc ";
        $qry = $conn->query($sql);
        if($qry->num_rows > 0)
        while ($row = $qry->fetch_assoc()) :
            $total += $row['amount'];
            $totalQty += $row['qty'];
        ?>
            <tr>
                <td class="text-center"><?php echo $i++; ?></td>
                <td>
                    <p class="m-0"><?= date("d/m/Y", strtotime($row['date_created'])) ?></p>
                </td>
                <td class='text-right'><?= number_format($row['qty'], 0) ?></td>
                <td class='text-right'><?= number_format($row['amount'], 0) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-center">Tổng</th>
            <th class="text-right"><?= number_format($totalQty, 0) ?></th>
            <th class="text-right"><?= number_format($total, 0) ?></th>
        </tr>
    </tfoot>
</table>