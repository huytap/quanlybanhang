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
    } else {
        echo '<script> alert("Unknown Sale\'s ID."); location.replace("./?page=sales"); </script>';
    }
}
?>
<style>
    #sales-panel {
        height: 70vh;
    }

    #panel-left,
    #item-list {
        background: rgb(255 255 255 / 17%);
    }

    #item-list {
        height: 60%;
    }
    .card-body{
        font-weight: 700;
    }
    .quantity{
        position: relative;
    }
    .quantity .btn{
        position: absolute;
        top: 0;
        height: 100%;
        border-radius: 0;
        background-color: #000;
    }
    .quantity .btn-plus{
        right: 0;
    }
    .btn-minus{
        left: 0;
    }
    .btn-plus{
        right:0;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-outline rounded-0 shadow blur">
            <div class="card-header">
                <h5 class="card-title"><?= isset($id) ? "Cập nhật " . $code . " Sale" : "Đơn mới" ?></h5>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="sale-form">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                        <input type="hidden" name="amount" value="<?= isset($amount) ? $amount : '' ?>">
                        <div class="row">                            
                        <?php 
                        $today = date('Y-m-d');
                        $sqlPromo = "SELECT * 
                            FROM `promotion` 
                            WHERE delete_flag = 0 and `status` = 1 and `from_date`<='{$today}' and `to_date`>='{$today}'
                            order by `from_date` asc";
                        $promotion = $conn->query($sqlPromo);
                        $promotion_name = '';
                        $promotion_id = 0;
                        if($promotion->num_rows){?>
                            <div class="w-100 mt-2 d-flex">
                                <div class="col-12">
                                    <label for="client_name" class="control-label">Chương trình KM đang được áp dụng: </label>
                                    <span class="text-red">
                                    <?php                                         
                                        while ($row = $promotion->fetch_assoc()) {
                                            if($row['discount_type'] == 'PRODUCT'){
                                            ?>
                                                <input data='<?=json_encode($row);?>' type="hidden" product_type="<?=$row['product_type'];?>" 
                                                name="promotion_id" class="promo" id="promotion_id" 
                                                value="<?=$row['id'];?>"
                                                > 
                                                <label for="promotion_id"><?php echo $row['name'];?></label>
                                            <?php 
                                            }
                                        }
                                    ?>
                                    </span>
                                </div>
                            </div>
                        <?php }?>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="client_name" class="control-label">Khách hàng</label>
                                    <input type="text" placeholder="" name="client_name" id="client_name" class="form-control form-control-sm rounded-0" value="<?= isset($client_name) ? $client_name : "Guest" ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="phone_number" class="control-label">SĐT</label>
                                    <input type="text" placeholder="" name="phone_number" id="client_name" class="form-control form-control-sm rounded-0">
                                </div>
                            </div>
                        </div>
                        <div class="border rounded-0 shadow bg-gradient-navy px-1 py-1" id="sales-panel">
                            <div class="d-flex h-100 w-100">
                                <div class="col-8 px-0 h-100" id="panel-left">
                                    <div class="card card-primary bg-transparent border-0 h-100 card-tabs rounded-0">
                                        <div class="card-header bg-gradient-dark p-0 pt-1">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <?php
                                                $has_active = false;
                                                $category = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1  order by `name` asc");
                                                $product = $conn->query("SELECT * FROM `product_list` where delete_flag = 0 and `status` = 1  order by `name` asc");
                                                $prod_arr = [];
                                                while ($row = $product->fetch_array()) {
                                                    $prod_arr[$row['category_id']][] = $row;
                                                }
                                                $cat_arr = array_column($category->fetch_all(MYSQLI_ASSOC), 'name', 'id');
                                                foreach ($cat_arr as $k => $v) :
                                                ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link <?= (!$has_active) ? 'active' : '' ?>" id="custom-tabs-one-home-tab" data-toggle="pill" href="#cat-tab-<?= $k ?>" role="tab" aria-controls="cat-tab-<?= $k ?>" aria-selected="<?= (!$has_active) ? 'true' : 'false' ?>"><?= $v ?></a>
                                                    </li>
                                                <?php
                                                    $has_active = true;
                                                endforeach;
                                                ?>

                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <?php
                                                $has_active = false;
                                                foreach ($cat_arr as $k => $v) :
                                                ?>
                                                    <div class="tab-pane fade <?= (!$has_active) ? 'active show' : '' ?>" id="cat-tab-<?= $k ?>" role="tabpanel" aria-labelledby="cat-tab-<?= $k ?>-tab">
                                                        <div class="row">
                                                            <?php if (isset($prod_arr[$k])) : ?>
                                                                <?php foreach ($prod_arr[$k] as $row) : 
                                                                    $query = $conn->query("SELECT a.id, `price`, a.name from `product_attributes` pa left join attributes a on pa.attribute_id=a.id where product_id='".$row['id']."' and pa.delete_flag=0");
                                                                    ?>
                                                                    <div class=" col-lg-3 col-md-4 col-sm-12 col-xs-12 px-2 py-3">
                                                                        <div class="card text-dark text-decoration-none">
                                                                            <div class="card-body text-center">
                                                                                <div class="text-uppercase menu-name mb-2"><?= $row['name'] ?></div>
                                                                                <button data-upsize="<?=$row["upsize"];?>" menu-name="<?= $row['name'] ?>" type="button" data-price="<?= $row['price'] ?>" data-id="<?= $row['id'] ?>" class="btn btn-primary prod-item"><span class="fa fa-plus"></span></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php
                                                    $has_active = true;
                                                endforeach;
                                                ?>

                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                <div class="col-4 h-60">
                                    <table class="table table-bordered table-striped mb-0">
                                        <colgroup>
                                            <col width="35%">
                                            <col width="30%">
                                            <col width="25%">
                                            <col width="10%">
                                        </colgroup>
                                        <thead>
                                            <tr class="bg-gradient-navy-dark">
                                                <th class="text-center px-2 py-1">Thực đơn</th>
                                                <th class="text-center px-2 py-1">Số lượng</th>
                                                <th class="text-center px-2 py-1">Thành tiền</th>
                                                <th class="text-center px-2 py-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr></tr>
                                        </tbody>
                                    </table>
                                    <div id="item-list" class="overflow-auto">
                                        <table class="table table-bordered table-striped" id="product-list">
                                            <colgroup>
                                                <col width="35%">
                                                <col width="30%">
                                                <col width="25%">
                                                <col width="10%">
                                            </colgroup>
                                            <tbody>
                                                <?php if (isset($id)) : ?>
                                                    <?php
                                                    $sql = "SELECT sp.*, pr.name as pr_name, p.name as `product`, s.promotion_id, a.name as `atrribute`
                                                        FROM `sale_products` sp 
                                                        left join `sale_list` s on s.id=sp.sale_id
                                                        inner join `product_list` p on sp.product_id =p.id 
                                                        left join `attributes` a on a.id=sp.attribute_id
                                                        left join `promotion` pr on pr.id=s.promotion_id
                                                        where sp.sale_id = '{$id}'";
                                                    $sp_query = $conn->query($sql);
                                                    while ($row = $sp_query->fetch_assoc()) :
                                                        $promotion_name = $row['pr_name'];
                                                    ?>
                                                        <tr <?php if($row['promotion_id']>0 && $row['price'] <= 0) echo 'promotion="true"';?>>
                                                            <td class="px-2 py-1 align-middle" style="line-height:.9em">
                                                                <p class="product_name m-0 truncate-1"><?= $row['product'] ?></p>
                                                                <?php
                                                                if($row['attribute_id'] != ''){
                                                                    echo '<i style="display:block;font-size:11px;" class="attribute_name">';
                                                                    $attr_query = "SELECT `name` FROM `attributes` where id in({$row['attribute_id']}) AND delete_flag=0";
                                                                    $q = $conn->query($attr_query);
                                                                    $r = 0;
                                                                    while ($row2 = $q->fetch_assoc()) :
                                                                        echo $row2['name'];
                                                                        if($r < $q->num_rows - 1){
                                                                            echo ', ';
                                                                        }
                                                                        $r++;
                                                                    endwhile; 
                                                                    echo  '</i>';
                                                                } 
                                                                ?>
                                                                <p class="m-0"><small class="product_price">x <?= format_num($row['price']) ?></small></p>
                                                            </td>
                                                            <td class="px-2 py-1 align-middle">
                                                                <input type="hidden" name="product_id[]" value="<?= $row['product_id'] ?>">
                                                                <input type="hidden" name="product_price[]" value="<?= $row['price'] ?>">
                                                                <input type="hidden" name="attribute_id[]" value="<?= $row['attribute_id'] ?>">
                                                                <div class="quantity text-center">
                                                                <?php if($row['promotion_id']>0 && $row['price'] <= 0){
                                                                        echo '<span>'.$row['qty'].'</span>';
                                                                        echo '<input type="hidden" class="form-control form-control-sm rounded-0 text-center" min="0" name="product_qty[]" value="'.$row['qty'].'" required>';
                                                                    }else{?>
                                                                        <button type="button" class="btn btn-primary btn-minus"> 
                                                                            <span class="fa fa-minus"></span>
                                                                        </button>
                                                                        <input style="padding-left: 20px;" type="number" class="form-control form-control-sm rounded-0 text-center" min="0" name="product_qty[]" value="<?= $row['qty'] ?>" required>
                                                                        <button type="button" class="btn btn-primary btn-plus"> 
                                                                            <span class="fa fa-plus"></span>
                                                                        </button>
                                                                        <?php }?>
                                                                </div>
                                                            </td>
                                                            <td class="px-2 py-1 align-middle text-right product_total">
                                                                <?= format_num($row['price'] * $row['qty']) ?>
                                                            </td>
                                                            <td class="px-2 py-1 align-middle text-center">
                                                                <?php 
                                                                if($row['price']>0){?>
                                                                    <button class="btn btn-outline-danger border-0 btn-sm rounded-0 rem-product p-1" type="button"><i class="fa fa-times"></i></button>
                                                                <?php }?>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="notes" class="<?php if(!$promotion_name) echo 'd-none';?>">
                                        <div class="alert alert-danger ">
                                            <?php echo $promotion_name;?>
                                        </div>
                                    </div>
                                    <div class="text-light w-100 mt-1 d-flex" id="summary">
                                        <div class="col-auto">Tổng tiền:</div>
                                        <div class="col-auto flex-shrink-1 flex-grow-1 truncate-1 text-right" id="amount"><?= isset($amount) ? format_num($amount, 0) : '0.00' ?></div>
                                    </div>
                                    <!-- <div class="d-flex w-100 align-items-center">
                                        <div class="col-4">Đã nhận:</div>
                                        <div class="col-8">
                                            <input type="text" pattern="[0-9\.]*$" class="form-control form-control-lg rounded-0 text-right" id="tendered" name="tendered" value="<?= isset($tendered) ? str_replace(",", "", number_format($tendered)) : '0' ?>" required />
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
                                                <option value="1" <?= isset($payment_type) && $payment_type == 1 ? "selected" : "" ?>>Tiền mặt</option>
                                                <option value="2" <?= isset($payment_type) && $payment_type == 2 ? "selected" : "" ?>>Chuyển khoản</option>
                                                <option value="3" <?= isset($payment_type) && $payment_type == 3 ? "selected" : "" ?>>Credit Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="no_receive_change" style="display: <?php if(isset($tendered) && $tendered > 0) echo 'block';else echo 'none';?>">
                                        <input type="text" id="payment_code" class="form-control form-control-sm rounded-0 d-none" name="payment_code" value="<?= isset($payment_code) ? $payment_code : "" ?>" placeholder="Số tham chiếu">
                                        <input type="checkbox" name="" id=""> Không lấy tiền thừa
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer py-2 text-right">
                <!-- <button class="btn btn-primary rounded-0" form="sale-form">Lưu tạm</button> -->
                <button class="btn btn-primary rounded-0" form="sale-form">Lưu & Thanh toán</button>
                <?php if (!isset($id)) : ?>
                    <a class="btn btn-default border rounded-0" href="./?page=sales">Hủy</a>
                <?php else : ?>
                    <a class="btn btn-default border rounded-0" href="./?page=sales/view_details&id=<?= $id ?>">Hủy</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<noscript id="product-clone">
    <tr>
        <td class="px-2 py-1 align-middle" style="line-height:.9em">
            <p class="m-0 truncate-1">
                <span class="product_name">Cafe</span>
            </p>
            <i style="display:block;font-size:11px;" class="attribute_name"></i>
            <p class="m-0"><small class="product_price">x 20,000đ</small></p>
        </td>
        <td class="px-2 py-1 align-middle">
            <input type="hidden" name="product_id[]">
            <input type="hidden" name="product_price[]">
            <input type="hidden" name="attribute_id[]">
            <div class="quantity text-center">
                <button type="button" class="btn btn-primary btn-minus"> 
                    <span class="fa fa-minus"></span>
                </button>
                <input style="padding-left: 20px;" type="number" class="form-control form-control-sm rounded-0 text-center" min="1" name="product_qty[]" value="1" required>
                <button type="button" class="btn btn-primary btn-plus"> 
                    <span class="fa fa-plus"></span>
                </button>
            </div>
        </td>
        <td class="px-2 py-1 align-middle text-right product_total"></td>
        <td class="px-2 py-1 align-middle text-center"><button class="btn btn-outline-danger border-0 btn-sm rounded-0 rem-product p-1" type="button"><i class="fa fa-times"></i></button></td>
    </tr>
</noscript>
<script>
    function calc_change() {
        var amount = $('[name="amount"]').val()
        var tendered = $('[name="tendered"]').val()
        amount = amount > 0 ? amount : 0;
        tendered = tendered > 0 ? tendered : 0;
        var change = parseFloat(tendered) - parseFloat(amount)
        if(change> 0){
            $('#no_receive_change').show()
        }else{
            $('#no_receive_change').hide()
        }
        $('#change').val(parseFloat(change).toLocaleString('en-US'))
    }

    function calc_total_amount() {
        var total = 0;
        $('#product-list tbody tr').each(function() {
            var qty = $(this).find('[name="product_qty[]"]').val()
            qty = qty > 0 ? qty : 0
            total += (parseFloat($(this).find('[name="product_price[]"]').val()) * parseFloat(qty))
        })
        $('[name="amount"]').val(parseFloat(total))
        $('#amount').text(parseFloat(total).toLocaleString('vi-VN'))
        calc_change()
    }

    function calc_product() {
        var total = 0;

        $('#product-list tbody tr').each(function() {
            var qty = $(this).find('[name="product_qty[]"]').val()
            qty = qty > 0 ? qty : 0
            total += (parseFloat($(this).find('[name="product_price[]"]').val()) * parseFloat(qty))
        })
        $('#product_total').text(parseFloat(total).toLocaleString('vi-VN'))
        calc_total_amount()
    }
    $(function() {
        $('body').addClass('sidebar-collapse')
        $('#payment_type').change(function() {
            var type = $(this).val()
            if (type == 1) {
                $('#payment_code').addClass('d-none').attr('required', false)
            } else {
                $('#payment_code').removeClass('d-none').attr('required', true)
            }
        })
        $('#product-list tbody tr').each(function(i, tr) {
            $(tr).find('.rem-product').click(function(){
                if (confirm("Bạn có chắc chăn muốn xóa món " + ($(tr).find('.product_name').text()) + " không?") === true) {
                    if($(tr).next().attr('promotion') == 'true'){
                        $(tr).next().remove()
                    }
                    $(tr).remove()
                    calc_product()
                }
            })
            $(tr).find('.btn-plus').click(function(){
                changeQty(tr, 'plus')
            })
            $(tr).find('.btn-minus').click(function(){
                changeQty(tr, 'minus')
            })
            $(tr).find('[name="product_qty[]"]').on('input change', function() {
                changeQty(tr, 'change')
            })
        })
        $('#tendered').on('input', function() {
            calc_change()
        })
        $('#submit').click(function(){
            $('#uni_modal').modal('hide')
            var id = $('#productId').val()
            var price = $('#totalCart').attr('data-total_price')
            var name = $('#productName').val() 
            var attribute_id = attribute_name = ''
            if($('#attrName').val()){
                attribute_name = $('#attrName').val()
                attribute_id = $('#productAttrId').val()
            }
            var tr = $($('noscript#product-clone').html()).clone()
            tr.find('input[name="product_id[]"]').val(id)
            tr.find('input[name="product_price[]"]').val(price)
            tr.find('input[name="attribute_id[]"]').val(attribute_id)
            tr.find('.product_name').html(name)
            tr.find('.attribute_name').html(attribute_name)
            tr.find('.product_price').text('x ' + parseFloat(price).toLocaleString())
            tr.find('.product_total').text(parseFloat(price).toLocaleString())
            $('#product-list tbody').append(tr)
            calc_product()
            checkPromo(id, name, attribute_name, attribute_id)
            tr.find('.rem-product').click(function() {
                if (confirm("Bạn có chắc chăn muốn xóa món " + name + " không?") === true) {
                    tr.remove()
                    calc_product()
                }
            })
            tr.find('.btn-plus').click(function(){
                change(tr, 'plus')
            })
            tr.find('.btn-minus').click(function(){
                change(tr, 'minus')
            })
            tr.find('[name="product_qty[]"]').on('input change', function() {
                change(tr, 'change')

            })
        })
        $('.prod-item').click(function() {
            var id = $(this).attr('data-id')
            var price = $(this).attr('data-price')
            var name = $(this).attr('menu-name').trim()
            var upsize = $(this).attr('data-upsize');
            if(upsize > 0){
                uni_modal("Thêm món mới", "sales/select_menu.php?id=" + id +"&price="+price+"&upsize="+upsize+"&name=" + name, 'modal-sm');
                return false;
            }
            if ($('#product-list tbody tr input[name="product_id[]"][value="' + id + '"]').length > 0) {
                // var t = $('#product-list tbody tr input[name="product_id[]"][value="' + id + '"]').closest('div')
                // var pQty = $(t).find('[name="product_qty[]"]').val()
                // pQty ++
                // $(t).find('[name="product_qty[]"]').val(pQty)
                // //alert("Thực đơn đã có trong danh sách")
                // var total = parseFloat(pQty) * parseFloat(price)
                // $(t).find('.product_total').text(parseFloat(total).toLocaleString())
                // calc_product()
                alert('Nhấn dấu + để thêm số lượng')
                return false;
            }
            var tr = $($('noscript#product-clone').html()).clone()
            tr.find('input[name="product_id[]"]').val(id)
            tr.find('input[name="product_price[]"]').val(price)
            tr.find('.product_name').text(name)
            tr.find('.product_price').text('x ' + parseFloat(price).toLocaleString())
            tr.find('.product_total').text(parseFloat(price).toLocaleString())
            $('#product-list tbody').append(tr)
            calc_product()
            
            checkPromo(id, name)
            tr.find('.rem-product').click(function() {
                if (confirm("Bạn có chắc chăn muốn xóa món " + name + " không?") === true) {
                    if($(tr).next().attr('promotion') == 'true'){
                        $(tr).next().remove()
                    }
                    tr.remove()
                    calc_product()
                }
            })
            tr.find('.btn-plus').click(function(){
                changeQty(tr, 'plus')
            })
            tr.find('.btn-minus').click(function(){
                changeQty(tr, 'minus')
            })
            tr.find('[name="product_qty[]"]').on('input change', function() {
                changeQty(tr, 'change')
            })
        })
        $('#sale-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            if ($('#product-list').find('tbody').find('tr').length)
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
            else {
                end_loader();
                alert('Vui lòng chọn món')
            }
        })

        function changeQty(tr, type){
            var qty = parseFloat($(tr).find('[name="product_qty[]"]').val())
            var price = $(tr).find('[name="product_price[]"]').val()
            if(type == 'minus'){
                qty -= 1
                if(qty < 0){
                    qty = 0;
                }
            }else if(type == 'plus'){
                qty += 1
            }
            
            if($('#promotion_id').length){
                var promotion = $('#promotion_id').attr('data');
                promotion = JSON.parse(promotion)
                if(promotion['discount_type'] == 'PRODUCT'){
                    if(promotion['product_type'] == 'SAME'){
                        var buy = promotion['buy']
                        var gift = promotion['gift']
                        var qtyPr = Math.floor(qty/buy)
                        if(qtyPr>=0){
                            $(tr).next().find('.quantity span').text(qtyPr)
                            $(tr).next().find('.quantity input').val(qtyPr)
                        }
                    }
                }
            }
            
            $(tr).parent().find('[name="product_qty[]"]').val(qty)
            var total = parseFloat(qty) * parseFloat(price)
            $(tr).find('.product_total').text(parseFloat(total).toLocaleString())
            calc_product()
        }
        
        function checkPromo(id, name, attr="", attribute_id=""){
            if($('#promotion_id').length){
                var promotion = $('#promotion_id').attr('data');
                promotion = JSON.parse(promotion)
                if(promotion['discount_type'] == 'PRODUCT'){
                    if(promotion['product_type'] == 'SAME'){
                        var trPromo = $($('noscript#product-clone').html()).clone()
                        trPromo.find('td:last-child').find('button').remove()
                        trPromo.find('input[name="product_id[]"]').val(id)
                        trPromo.find('input[name="product_price[]"]').val(0)
                        trPromo.find('.product_name').text(name)
                        trPromo.find('.attribute_name').html(attr)
                        trPromo.find('input[name="attribute_id[]"]').val(attribute_id)
                        trPromo.find('.product_price').text('x ' + 0)
                        trPromo.find('.product_total').text(0)
                        trPromo.attr('promotion', true)
                        $('#product-list tbody').append(trPromo)
                        calc_product()
                        trPromo.find('.quantity').html('<span>1</span><input type="hidden" class="form-control form-control-sm rounded-0 text-center" min="0" name="product_qty[]" value="1" required>')
                        $('#notes .alert').html(promotion['name'])
                        $('#notes').removeClass('d-none')
                    }
                }
            }
        }
    })
</script>