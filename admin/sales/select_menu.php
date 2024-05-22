<?php 
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $product_id = $_GET['id'];
    ?>
    <h3><?php echo $_GET['name'];?></h3>
    <div class="price text-red mb-2"><b><?php echo number_format($_GET['price']);?>đ</b></div>
    <?php 
    if(isset($_GET['upsize']) && $_GET['upsize'] > 0){
        foreach(ATTR as $K => $V){?>
            <div class="bg-info p-2 mb-3"><?php echo $V;?></div>
            <?php
            $sql = "SELECT id, `price`, `name`,`type`
                    from attributes
                    where delete_flag=0 and type='{$K}'
                    order by price";
            $qry = $conn->query($sql);
            if ($qry->num_rows > 0) { 
                while($res = $qry->fetch_assoc()){?>
                    <div class="row mt-1 mb-1">
                        <div class="col-10">
                            <b class="attr-name"><?php echo $res['name'];?></b> - 
                            <?php echo number_format($res['price']);?>đ
                        </div>
                        <div class="col-2 d-flex">
                            <?php
                            if($res['type'] == 0){
                                if(!$res['price']){
                                    $checked='checked="checked"';
                                }else{
                                    $checked='';
                                }
                            ?>
                                <input data-name="<?php echo $res['name'];?>" data-price="<?=$res['price'];?>" <?=$checked;?> class="checkbox chose-size" type="checkbox" name="extra[0]" value="<?php echo $res['id'];?>">
                            <?php 
                            }else{?>
                                <input data-name="<?php echo $res['name'];?>" data-price="<?=$res['price'];?>" class="checkbox choose-topping" type="checkbox" name="extra[<?php echo $res['type'];?>][]" value="<?php echo $res['id'];?>">
                            <?php 
                            }
                            ?>
                        </div>
                    </div>
            <?php         
                }   
            }
        }
        ?>
    <?php
    }
}
?>
<input type="hidden" id="productAttrId">
<input type="hidden" id="productId" value="<?= $_GET['id'] ?>">
<input type="hidden" id="productName" value="<?= $_GET['name'] ?>">
<input type="hidden" id="attrName" value="">
<div class="bg-red mt-2 white-color text-center p-2 font-weight-bold">Tổng: <span id="totalCart" data-total_price="<?= $_GET['price']; ?>" data-total="<?= $_GET['price']; ?>"><?= number_format($_GET['price']) ?></span>đ</div>
<script>
    $('.chose-size').change(function(){
        $('.chose-size').not(this).prop('checked', false);
    })
    var arrAttr = [$('.bg-info').next().find('.chose-size').val()]
    var attrName = [$('.bg-info').next().find('.chose-size').attr('data-name')]
    $('#productAttrId').val(arrAttr.join(','))
    $('#attrName').val(attrName.join(','))
    $('.checkbox').change(function(){
        var total = 0;
        arrAttr = []
        attrName = []
        $('.checkbox').each(function(a, cb){
            var v = $(cb).val()
            if(cb.checked){
                arrAttr.push(v)
                total += parseFloat($(cb).attr('data-price'))
                attrName.push($(cb).attr('data-name'))
            }else{
                var index = $.inArray(v, arrAttr);
                if (index !== -1) {
                    arrAttr.splice(index, 1);
                    attrName.splice(index, 1)
                }
            }
        })
        var attr = arrAttr.join(",")
        var stringAttrName = attrName.join(", ")
        $('#productAttrId').val(attr)
        $('#attrName').val(stringAttrName)
        var grandTotal = $('#totalCart').attr('data-total')
        total = total + parseFloat(grandTotal)
        $('#totalCart').text(total.toLocaleString())
        $('#totalCart').attr('data-total_price', total)
    })
</script>