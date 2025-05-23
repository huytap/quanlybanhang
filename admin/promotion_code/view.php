<?php

require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT p.*, c.name as `category` from `product_list` p inner join category_list c on p.category_id = c.id where p.id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>
<div class="container-fluid">
    <dl>
        <dt class="text-muted">Danh mục</dt>
        <dd class="pl-4"><?= isset($category) ? $category : "" ?></dd>
        <dt class="text-muted">Món</dt>
        <dd class="pl-4"><?= isset($name) ? $name : "" ?></dd>
        <dt class="text-muted">Mô tả</dt>
        <dd class="pl-4"><?= isset($description) ? $description : '' ?></dd>
        <dt class="text-muted">Giá</dt>
        <dd class="pl-4"><?= isset($price) ? format_num($price) : '' ?></dd>
        <dt class="text-muted">Trạng thái</dt>
        <dd class="pl-4">
            <?php if ($status == 1) : ?>
                <span class="badge badge-success px-3 rounded-pill">Hoạt động</span>
            <?php else : ?>
                <span class="badge badge-danger px-3 rounded-pill">Ẩn</span>
            <?php endif; ?>
        </dd>
    </dl>
    <div class="clear-fix my-3"></div>
    <div class="text-right">
        <button class="btn btn-sm btn-dark bg-gradient-dark btn-flat" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Đóng</button>
    </div>
</div>