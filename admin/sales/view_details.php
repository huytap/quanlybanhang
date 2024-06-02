<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `sale_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
        if (isset($user_id) && is_numeric($user_id)) {
            $user = $conn->query("SELECT concat(firstname,' ', lastname) as `name` FROM `users` where id = '{$user_id}' ");
            if ($user->num_rows > 0) {
                $user_name = $user->fetch_array()['name'];
            }
        }
    } else {
        echo '<script> alert("Unknown sale\'s ID."); location.replace("./?page=sales"); </script>';
    }
} else {
    echo '<script> alert("sale\'s ID is required to access the page."); location.replace("./?page=sales"); </script>';
}
$tem_html = '';
?>
<div class="content py-3">
    <div class="card card-outline card-navy rounded-0 shadow">
        <div class="card-header">
            <h4 class="card-title">Số HĐ: <b><?= isset($code) ? $code : "" ?></b></h4>
            <div class="card-tools">
                <a href="./?page=sales" class="btn btn-default border btn-sm"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                    <div id="printout">
                        <div class="receipt-content">
                            <div class="d-flex invoice-no">
                                <div class="col-6">
                                    <b>Số HĐ:</b> <?= isset($code) ? $code : "" ?>
                                </div>
                                <div class="col-6">
                                    <b>Ngày:</b> <?= isset($date_created) ? date("d/m/Y h:i", strtotime($date_created)) : "" ?>
                                </div>
                            </div>
                            <div class="d-flex invoice-no">
                                <div class="col-sm-6">
                                    <b>Khách hàng:</b> <?php echo $client_name;?>
                                </div>
                                <div class="col-sm-6">
                                    <b>SĐT:</b> <?= isset($phone_number) ? $phone_number : "" ?>
                                </div>
                            </div>
                            <?php if(isset($time_shipping)){?>
                                <div class="col-sm-12">
                                    <b>Giao:</b> <?= $time_shipping ?>
                                </div>
                            <?php }?>
                            <div class="mb-2"></div>
                            <h6 class="d-flex border-bottom border-dark pb-1">
                                <div class="col-8">Thực đơn</div>
                                <div class="col-1 text-center">SL</div>
                                <div class="col-3 text-center">Thành tiền</div>
                            </h6>
                            <?php if (isset($id)) : ?>
                                <?php
                                $sql = "SELECT sp.*, s.code, pr.name as pr_name, p.name as `product`, s.promotion_id, sp.attribute_id, c.has_print_tem
                                    FROM `sale_products` sp 
                                    left join `sale_list` s on s.id=sp.sale_id
                                    inner join `product_list` p on sp.product_id =p.id 
                                    left join `category_list` c on c.id=p.category_id
                                    left join `promotion` pr on pr.id=s.promotion_id
                                    where sp.sale_id = '{$id}'";
                                $sp_query = $conn->query($sql);
                                $promotion_name = '';
                                $stt = 1;
                                $arrayTemp = [];
                                $totalQty = $totalSummary = 0;
                                if($sp_query->num_rows > 0)
                                //$sp_query = $conn->query("SELECT sp.*, p.name as `product` FROM `sale_products` sp inner join `product_list` p on sp.product_id =p.id where sp.sale_id = '{$id}'");
                                while ($row = $sp_query->fetch_assoc()) :
                                    $promotion_name = $row['pr_name'];
                                    $totalSummary += $row['qty'];
                                    if($row['has_print_tem'] == 1){
                                        $totalQty += $row['qty'];
                                        //$tem_html .= '<h6>'.$row['product'].'</h6>';
                                        $arrayTemp[$stt] = [
                                            'name' => $row['product'],
                                            'code' => $row['code'],
                                            'price' => number_format($row['price'], 0),
                                            'quantity' => $row['qty']
                                        ];
                                    }
                                ?>
                                    <div class="d-flex border-bottom border-dark mb-1 pb-1">
                                        <div class="col-8" style="line-height:.9em">
                                            <p class="m-0"><?= $row['product'] ?></p>
                                            <?php
                                            $attrStr = '';
                                            if ($row['attribute_id'] != '') {
                                                echo '<i style="display:block;font-size:11px;" class="attribute_name">';
                                                $attr_query = "SELECT `name` FROM `attributes` where id in({$row['attribute_id']}) AND delete_flag=0";
                                                $q = $conn->query($attr_query);
                                                $r = 0;
                                                // if($q->num_rows){
                                                //     $tem_html .= '<i style="display:block;font-size:11px;">';
                                                // }
                                                while ($row2 = $q->fetch_assoc()) :
                                                    $tem_html .= $row2['name']; 
                                                    $attrStr .= $row2['name'];
                                                    echo $row2['name'];
                                                    if ($r < $q->num_rows - 1) {
                                                        //$tem_html .= ', ';
                                                        $attrStr .= ', ';
                                                        echo ', ';
                                                    }
                                                    $r++;
                                                endwhile;
                                                $arrayTemp[$stt]['attribute'] = $attrStr;
                                                echo  '</i>';
                                                // if($q->num_rows){
                                                //     $tem_html .= '</i>';
                                                // }
                                            }
                                            ?>
                                            <p class="m-0"><small>x <?= number_format($row['price'], 0) ?></small></p>
                                        </div>
                                        <div class="col-1 text-center"><?= $row['qty'] ?></div>
                                        <div class="col-3 text-right"><?= number_format($row['price'] * $row['qty']) ?></div>
                                    </div>
                                <?php 
                                //$tem_html .= '<p>Số HĐ: '.$row['code'] . ' - #'. $stt .'/' .$row['totalQty'].'</p>';
                                $stt++;
                            endwhile; 
                            ?>
                            <?php endif; ?>
                            <h6 class="d-flex border-dark" style="font-size: 18px">
                                <div class="col-8 text-bold">Tổng cộng</div>
                                <div class="col-1 text-bold text-center"><?= isset($totalSummary) ? format_num($totalSummary, 0) : 0 ?></div>
                                <div class="col-3 text-bold text-right"><?= isset($amount) ? format_num($amount, 0) : 0 ?></div>
                            </h6>
                            <div class="d-flex border-dark  text-bold" style="font-size: 18px;border-top:1px solid #000;">
                                <div class="col-7">
                                    <?php
                                    $payment_type = isset($payment_type) ? $payment_type : 0;
                                    echo PAYMENT_METHOD[$payment_type];
                                    ?>
                                </div>
                                <div class="col-5 text-right">
                                <?= isset($amount) ? format_num($amount, 0) : 0 ?>
                                </div>
                            </div>
                            <?php if ($status == '1') { ?>
                                <div class="d-flex">
                                    <div class="col-5">Khách trả</div>
                                    <div class="col-7 text-right"><?= isset($tendered) ? format_num($tendered, 0) : 0 ?></div>
                                </div>
                                <?php
                                    $payment_type = isset($payment_type) ? $payment_type : 0;
                                    if($payment_type == 1){
                                    ?>
                                    <div class="d-flex">
                                        <div class="col-4">Tiền thừa</div>
                                        <div class="col-8 text-right"><?= isset($amount) && isset($tendered) ? format_num($tendered - $amount, 0) : 0 ?></div>
                                    </div>
                                <?php }?>
                                <?php //if ($payment_type > 1) : ?>
                                    <!-- <h6 class="d-flex">
                                        <div class="col-4">Số tham chiếu</div>
                                        <div class="col-8 text-right"><?= isset($payment_code) ? $payment_code : "" ?></div>
                                    </h6> -->
                                <?php //endif; ?>
                            <?php } ?>
                            <?php if ($promotion_name) : ?>
                                <div id="notes" class="d-flex font-italic">
                                    <!-- <div class="col-4">Ghi chú:</div> -->
                                    <div class="col-12"><?php echo $promotion_name; ?></div>
                                </div>
                            <?php endif; ?>
                            <!-- <div class="d-flex border-dark mb-2">
                                <div class="col-4">Trạng thái:</div>
                                <div class="col-8 text-right">
                                    <?php
                                    if ($status != '1') {
                                        echo '<span class="btn p-0 btn-warning">Chưa thanh toán</span>';
                                    } else {
                                        echo '<span class="btn p-0 btn-primary">Đã thanh toán</span>';
                                    } ?>
                                </div>
                            </div> -->
                            <!-- <div class="text-bold text-center">Cảm ơn Quý khách - Hẹn gặp lại!</div> -->
                        </div>                        
                    </div>
                    <?php if ($status != '1') { ?>
                        <form method="post" id="sale-form">
                            <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                            <input type="hidden" name="amount" value="<?= isset($amount) ? $amount : 0 ?>">
                            <div class="d-flex w-100 align-items-center">
                                <div class="col-4">Khách trả:</div>
                                <div class="col-8">
                                    <input type="text" pattern="[0-9\.]*$" class="form-control form-control-lg rounded-0 text-right" id="tendered" name="tendered" value="" required />
                                </div>
                            </div>
                            <div class="d-flex w-100 align-items-center">
                                <div class="col-4">Tiền thừa:</div>
                                <div class="col-8">
                                    <input type="text" pattern="[0-9\.]*$" class="form-control form-control-lg rounded-0 text-right" id="change" value="<?= isset($amount) && isset($tendered) ? format_num($tendered - $amount, 0) : '0' ?>" readonly />
                                </div>
                            </div>
                            <div class="d-flex w-100 align-items-center">
                                <div class="col-4">Phương thức thanh toán:</div>
                                <div class="col-8">
                                    <select name="payment_type" id="payment_type" class="form-control rounded-0" required="required">
                                        <option value="">Chọn hình thức thanh toán</option>
                                        <?php
                                        foreach (PAYMENT_METHOD as $k => $p) {
                                            echo '<option value="' . $k . '"' . (isset($payment_type) && $payment_type == $k ? "selected" : "") . '>' . $p . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="no_receive_change" style="display: <?php if (isset($tendered) && $tendered > 0) echo 'block';
                                                                        else echo 'none'; ?>">
                                <input type="text" id="payment_code" class="form-control form-control-sm rounded-0 d-none" name="payment_code" value="<?= isset($payment_code) ? $payment_code : "" ?>" placeholder="Số tham chiếu">
                                <input type="checkbox" name="" id=""> Không lấy tiền thừa
                            </div>
                            <div class="col-12 mt-3 text-right">
                                <button type="submit" class="btn btn-primary">Xác nhận</button>
                            </div>
                        </form>
                    <?php
                    } ?>
                    <div class="d-flex">
                        <div class="col-4">Khách đặt</div>
                        <div class="col-8 text-right">
                            <?php
                            $order_type = isset($order_type) ? $order_type : 0;
                            echo DRINK[$order_type];
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row justify-content-center">
                <?php
                $today = date('Y-m-d');
                if ($today <= $date_created && $_settings->userdata('type') == 1) { ?>
                    <a class="btn btn-primary bg-gradient-primary border col-lg-3 col-md-4 col-sm-12 col-xs-12 rounded-pill" href="./?page=sales/manage_sale&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                <?php } ?>
                <button class="btn btn-light bg-gradient-light border col-lg-3 col-md-4 col-sm-12 col-xs-12 rounded-pill" id="print"><i class="fa fa-print"></i> In đơn</button>
                <?php if($totalQty > 0){?>
                    <button class="btn btn-light bg-gradient-light border col-lg-3 col-md-4 col-sm-12 col-xs-12 rounded-pill" id="print_tem"><i class="fa fa-print"></i> In tem</button>
                <?php
                }
                if ($today <= $date_created && $_settings->userdata('type') == 1) { ?>
                    <button class="btn btn-danger bg-gradient-danger border col-lg-3 col-md-4 col-sm-12 col-xs-12 rounded-pill" id="delete_sale" type="button"><i class="fa fa-trash"></i> Hủy đơn</button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <style>
        html,
        body {
            background: unset !important;
            min-height: unset !important;
            font-family: Arial, sans-serif;
            color: #000;
            font-size: 1rem !important;
            margin-top: 1rem;
        }

        i {
            font-size: 1rem !important;
        }

        /* .container-fluid {
            width: 100% !important;
        } */

        .receipt-header,
        .receipt-content {
            width: 100mm;
        }

        h4 {
            font-size: 30px;
            font-weight: bold;
        }

        h3 {
            font-size: 20px;
            font-weight: bold;
        }

        .btn-primary {
            color: #000;
            background-color: #fff;
            border-color: #fff;
        }
        @page {
            size:portrait;
            margin: 7px;
            padding:0;
        }
        .btn.btn-warning{
            background-color: transparent;
            color:#000;
            border-radius: 0;
            border:0;
            padding:0
        }
    </style>
    <div class="d-flex receipt-header">
        <div class="col-12 text-center">
            <h4 class="tex-center"><?= $_settings->info('name') ?></h4>
            <p class="tex-center mb-0"><?= $_settings->info('short_name') ?></p>
            <p class="tex-center mb-0">ĐT: 0344 384 234</p>
            <h3 class="tex-center mt-1">HÓA ĐƠN THANH TOÁN</h3>
        </div>
    </div>
</noscript>
<noscript id="print-header2">
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
        }
        .receipt-header{
            width: 67mm;
        }
        .print-content{
            height: 35mm;
            border: 2px solid #000;
            border-radius: 5px;
            padding: 5px;
        }
        .product-info{
            height: 22mm;
            overflow: hidden;            
        }
        h6{
            font-weight: bold;
            font-size: 17px;
            padding:0;
            margin:0;
            text-transform: uppercase;
        }
        @page {
            size: landscape;
            margin: 7px;
            padding:0;
        }
        .brand{
            font-weight: bold;
            font-size: 13px;
        }
        .breakpage{
            page-break-after: always;
            padding-top: 7px;
            margin-top: 7px;
        } 
        .attribute{
            border-bottom: 1px dashed #000;
        }
       
        
        /* @media print { 
            .breakpage {page-break-before: always;} 
        }  */
    </style>
    <div class="receipt-header">
        <?php
        foreach($arrayTemp as $key => $temp){
            for($i=0;$i<$temp['quantity'];$i++){
            ?>
            <div class="print-content">
                <div class="product-info">
                    <h6><?= $temp['name'];?></h6>
                    <div class="attribute">
                        <?php if(isset($temp['attribute'])){?>
                            <div style="display:block;font-size:15px;"><?php echo $temp['attribute'];?></div>
                        <?php }?>
                    </div>
                </div>
                <div class="brand"">
                    <div style="width: 70%;display: inline-block;">No.<?=$temp['code'] . ' #'. ($key+$i) .'/' .$totalQty;?></div><div style="display: inline-block;width: 30%; text-align:right;"><?php echo $temp['price'];?></div>
                    SKUN- 0344 384 234
                </div>
            </div>
            <?php
            }
        } 
        ?>
    </div>
    <div class="breakpage"></div>
</noscript>
<script>
    $(function() {
        if ($('#tendered').length) {
            $('#tendered').focus()
        }
        $('#print').click(function() {
            var head = $('head').clone()
            var p = $($('#printout').html()).clone()
            var phead = $($('noscript#print-header').html()).clone()
            var el = $('<div>')
            head.find('title').text("In hóa đơn")
            el.append(phead)
            el.append(p)
            // el.find('.bg-gradient-navy').css({
            //     'background': '#001f3f linear-gradient(180deg, #26415c, #001f3f) repeat-x !important',
            //     'color': '#fff'
            // })
            // el.find('.bg-gradient-secondary').css({
            //     'background': '#6c757d linear-gradient(180deg, #828a91, #6c757d) repeat-x !important',
            //     'color': '#fff'
            // })
            // el.find('tr.bg-gradient-navy').attr('style', "color:#000")
            // el.find('tr.bg-gradient-secondary').attr('style', "color:#000")
            start_loader();
            var nw = window.open("", "_blank", "width=500")
            nw.document.querySelector('head').innerHTML = head.prop('outerHTML')
            nw.document.querySelector('body').innerHTML = el.prop('outerHTML')
            nw.document.close()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                    location.href = '<?php echo base_url ;?>/admin/?page=sales/index'
                }, 300)
            }, 500)
        })
        $('#print_tem').click(function() {
            var head = $('head').clone()
            var phead = $($('noscript#print-header2').html()).clone()
            var el = $('<div>')
            head.find('title').text("In hóa đơn")
            el.append(phead)
            start_loader();
            var nw = window.open("", "_blank", "width=280")
            nw.document.querySelector('head').innerHTML = head.prop('outerHTML')
            nw.document.querySelector('body').innerHTML = el.prop('outerHTML')
            nw.document.close()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 300)
            }, 500)
        })
        $('#delete_sale').click(function() {
            _conf("Bạn có chắc chắn muốn hủy đơn này không?", "delete_sale", [])
        })
    })

    function delete_sale($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_sale",
            method: "POST",
            data: {
                id: '<?= isset($id) ? $id : "" ?>'
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.replace('./?page=sales');
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        })
    }
    $('#tendered').on('input', function() {
        calc_change()
    })

    function calc_change() {
        var amount = $('[name="amount"]').val()
        var tendered = $('[name="tendered"]').val()
        amount = amount > 0 ? amount : 0;
        tendered = tendered > 0 ? tendered : 0;
        var change = parseFloat(tendered) - parseFloat(amount)
        if (change > 0) {
            $('#no_receive_change').show()
        } else {
            $('#no_receive_change').hide()
        }
        $('#change').val(parseFloat(change).toLocaleString('en-US'))
    }
    $('#sale-form').submit(function(e) {
        e.preventDefault();
        var _this = $(this)
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_sale",
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
                    location.href = "./?page=sales/view_details&id=" + resp.sid
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
</script>