<?php
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline rounded-0 card-navy">
    <div class="card-body">
        <div class="container-fluid">
            <!-- <fieldset class="border px-2 mb-2 ,x-2">
                <legend class="w-auto px-2">Filter</legend>
                <form id="filter-form" action="">
                    <div class="row align-items-end">
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="date">Năm</label>
                                <select id="year" name="year" class="form-control form-control-sm rounded-0">
                                    <option value="2024" <?php if ($year == 2024) echo 'selected'; ?>>2024</option>
                                    <option value="2025" <?php if ($year == 2025) echo 'selected'; ?>>2025</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-primary rounded-0 btn-sm"><i class="fa fa-filter"></i> Lọc</button>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset> -->
            <div class="container-fluid" id="printout">
                <?php
                $sql = "SELECT 
                        cl.id AS category_id,
                        cl.name AS category_name,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 1 THEN sp.qty * sp.price ELSE 0 END), 0) AS month1,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 2 THEN sp.qty * sp.price ELSE 0 END), 0) AS month2,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 3 THEN sp.qty * sp.price ELSE 0 END), 0) AS month3,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 4 THEN sp.qty * sp.price ELSE 0 END), 0) AS month4,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 5 THEN sp.qty * sp.price ELSE 0 END), 0) AS month5,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 6 THEN sp.qty * sp.price ELSE 0 END), 0) AS month6,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 7 THEN sp.qty * sp.price ELSE 0 END), 0) AS month7,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 8 THEN sp.qty * sp.price ELSE 0 END), 0) AS month8,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 9 THEN sp.qty * sp.price ELSE 0 END), 0) AS month9,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 10 THEN sp.qty * sp.price ELSE 0 END), 0) AS month10,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 11 THEN sp.qty * sp.price ELSE 0 END), 0) AS month11,
                        COALESCE(SUM(CASE WHEN MONTH(sl.date_created) = 12 THEN sp.qty * sp.price ELSE 0 END), 0) AS month12
                    FROM 
                        category_list cl
                    LEFT JOIN 
                        product_list pl ON cl.id = pl.category_id
                    LEFT JOIN 
                        sale_products sp ON pl.id = sp.product_id
                    LEFT JOIN 
                        sale_list sl ON sp.sale_id = sl.id
                    WHERE 
                        YEAR(sl.date_created) = $year AND sl.deleted_flag = 0 and cl.delete_flag = 0
                    GROUP BY 
                        cl.id, cl.name
                    ORDER BY 
                        cl.name;";

                ?>
            </div>
        </div>
    </div>
    <table class="table table-hover table-striped table-bordered" id="report-list">
        <thead>
            <tr>
                <th>Danh mục</th>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    echo "<th>Tháng $i</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $results = $conn->query($sql);
            $totals = array_fill(1, 12, 0); // Khởi tạo mảng tổng từ tháng 1 đến 12
            ?>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $monthValue = $row["month$i"];
                        $totals[$i] += $monthValue;
                        echo "<td>" . number_format($monthValue, 0, ',', '.') . "</td>";
                    }
                    ?>
                </tr>
            <?php endforeach; ?>
        <tfoot>
            <tr>
                <th class="text-center">Tổng tiền</th>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    echo '<th class="text-right">' . number_format($totals[$i], 0, ',', '.') . '</th>';
                }
                ?>
            </tr>
        </tfoot>

        </tbody>
    </table>
</div>
<script>
    $('#filter-form').submit(function(e) {
        e.preventDefault()
        location.href = "./?page=reports/report_month&" + $(this).serialize()
    })
</script>