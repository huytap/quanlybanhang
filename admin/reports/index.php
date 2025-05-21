<?php
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date("Y-m-d");
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
$payment_type = isset($_GET['payment_type']) ? $_GET['payment_type'] : 'all';
$unit = isset($_GET['unit']) ? $_GET['unit'] : '';
if ($_settings->userdata('type') == 3) {
    $user_id = $_settings->userdata('id');
}
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline rounded-0 card-navy">
    <!-- <div class="card-header">
        <h3 class="card-title">Báo cáo</h3>
    </div> -->
    <div class="card-body">
        <div class="container-fluid">
            <fieldset class="border px-2 mb-2 ,x-2">
                <legend class="w-auto px-2">Filter</legend>
                <form id="filter-form" action="">
                    <div class="row align-items-end">
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="date">Từ ngày</label>
                                <input type="date" name="date" value="<?= $date ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="date_to">Đến ngày</label>
                                <input type="date" name="date_to" value="<?= $date_to ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>
                        <?php if ($_settings->userdata('type') != 3) : ?>
                            <div class="col-lg-1 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="user_id">Nhân viên</label>
                                    <select name="user_id" class="form-control form-control-sm" required>
                                        <option value="0" <?= $user_id == 0 ? 'selected' : '' ?>>Tất cả</option>
                                        <?php
                                        $qry = $conn->query("SELECT *, concat(firstname, ' ', lastname) as `name` from users order by `name` asc");
                                        while ($row = $qry->fetch_assoc()) :
                                        ?>
                                            <option value="<?= $row['id'] ?>" <?= $user_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="category_id">Danh mục</label>
                                <select name="category_id" class="form-control form-control-sm">
                                    <option value="0" <?= $category_id == 0 ? 'selected' : '' ?>>Tất cả</option>
                                    <?php
                                    $qry2 = $conn->query("SELECT * from category_list order by `name` asc");
                                    while ($row2 = $qry2->fetch_assoc()) :
                                    ?>
                                        <option value="<?= $row2['id'] ?>" <?= $category_id == $row2['id'] ? 'selected' : '' ?>><?= $row2['name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="unit">Đơn vị</label>
                                <select name="unit" id="unit" class="form-control form-control-sm rounded-0">
                                    <option value="" <?= !isset($category_id) ? "selected" : "" ?>>Tất cả</option>
                                    <?php
                                    foreach(UNIT as $uk => $uv) :
                                    ?>
                                        <option value="<?= $uk ?>" <?php echo isset($unit) && $unit == $uk ? 'selected' : '' ?>><?= $uv ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="product_id">Thực đơn</label>
                                <select name="product_id" class="form-control form-control-sm">
                                    <option value="all">Tất cả</option>
                                    <?php
                                    $qry = $conn->query("SELECT `id`,`name` from product_list where delete_flag=0 order by `name` asc");
                                    while ($row = $qry->fetch_assoc()) :
                                    ?>
                                        <option value="<?= $row['id'] ?>" <?= $product_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="payment_type">Hình thức TT</label>
                                <select name="payment_type" class="form-control form-control-sm">
                                    <option value="all">Tất cả</option>
                                    <?php
                                    foreach(PAYMENT_METHOD as $k => $p) :
                                    ?>
                                        <option value="<?= $k ?>" <?php if($payment_type == $k) echo 'selected="selected"'; ?>><?= $p ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-primary rounded-0 btn-sm"><i class="fa fa-filter"></i> Lọc</button>
                                <button class="btn btn-light border rounded-0 btn-sm" type="button" id="print"><i class="fa fa-print"></i> In HĐ</button>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>
            <div class="container-fluid" id="printout">
                <?php 
                if($unit){
                    include_once("_unit.php");
                }else{
                    include_once("_not_unit.php");
                }
                ?>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <style>
        html,
        body {
            background: unset !important;
            min-height: unset !important
        }
    </style>
    <div class="d-flex w-100">
        <div class="col-2 text-center">
        </div>
        <div class="col-8 text-center" style="line-height:.9em">
            <h4 class="text-center m-0"><?= $_settings->info('name') ?></h4>
            <h3 class="text-center m-0"><b>Daily Sales Report</b></h3>
            <h5 class="text-center m-0"><b>as of</b></h5>
            <h3 class="text-center m-0"><b><?= date("F d, Y", strtotime($date)) ?></b></h3>
        </div>
    </div>
    <hr>
</noscript>
<script>
    $(document).ready(function() {
        $('[name="user_id"]').select2({
            placeholder: 'Please Select User Here',
            width: '100%',
            containerCssClass: 'form-control form-control-sm rounded-0'
        })
        $('#filter-form').submit(function(e) {
            e.preventDefault()
            location.href = "./?page=reports&" + $(this).serialize()
        })
        $('#report-list td,#report-list th').addClass('py-1 px-2 align-middle')
        $('#print').click(function() {
            var head = $('head').clone()
            var p = $($('#printout').html()).clone()
            var phead = $($('noscript#print-header').html()).clone()
            var el = $('<div class="container-fluid">')
            head.find('title').text("Daily Sales Report-Print View")
            el.append(phead)
            el.append(p)
            el.find('.bg-gradient-navy').css({
                'background': '#001f3f linear-gradient(180deg, #26415c, #001f3f) repeat-x !important',
                'color': '#fff'
            })
            el.find('.bg-gradient-secondary').css({
                'background': '#6c757d linear-gradient(180deg, #828a91, #6c757d) repeat-x !important',
                'color': '#fff'
            })
            el.find('tr.bg-gradient-navy').attr('style', "color:#000")
            el.find('tr.bg-gradient-secondary').attr('style', "color:#000")
            start_loader();
            var nw = window.open("", "_blank", "width=1000, height=900")
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
    })
</script>