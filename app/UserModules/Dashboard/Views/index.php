<?= $this->extend("user/layout/master") ?>
<?= $this->section("style") ?>
<style>
    .tile_partner {
        font-size: 12px;
    }
</style>
<?= $this->endSection("style") ?>
<?= $this->section("content") ?>
<style>
div#sales-legend {
    display: none;
}
</style>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-6 col-xl-6 mb-4 mb-xl-0">
                    <form>
                        <div class="row">
                            <div class="col-4">
                                <p class="font-weight-bold">Filter data by:</p>
                                <select class="col-md-12" name="data-type">
                                    <option value="yearly" <?php if (isset($_GET['data-type'])) {
                                                                if ($_GET['data-type'] == "yearly") {
                                                                    echo "selected";
                                                                }
                                                            }; ?>>Current Year</option>
                                    <option value="previous-quarterly" <?php if (isset($_GET['data-type'])) {
                                                                    if ($_GET['data-type'] == "previous-quarterly") {
                                                                        echo "selected";
                                                                    }
                                                                }; ?>>Previous Quarter</option>
									<option value="current-quarterly" <?php if (isset($_GET['data-type'])) {
                                                                    if ($_GET['data-type'] == "current-quarterly") {
                                                                        echo "selected";
                                                                    }
                                                                }; ?>>Current Quarter</option>
                                    <!--<option value="monthly" <?php if (isset($_GET['data-type'])) {
                                                                    if ($_GET['data-type'] == "monthly") {
                                                                        echo "selected";
                                                                    }
                                                                }; ?>>Current Month</option>!-->
                                    <select>
                            </div>
                            <div class="col-4">
                                <p class="font-weight-bold invisible">Category</p>
                                <select class="col-md-12" name="category_id">
                                    <option value="">--Category--</option>
                                    <?php echo $categories; ?>
                                    <select>
                            </div>
                            <div class="col-4">
                                <p class="font-weight-bold invisible">Buttons</p>
                                <div class="">
                                    <button type="submit" class="btn btn-success btn-icon-text btn-sm">Filter</button>
                                    <a href="<?php echo base_url('account/dashboard'); ?>"><button type="button" class="btn btn-warning btn-icon-text btn-sm">Reset</button></a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-6 col-xl-6 mb-4 mb-xl-0 text-right">
                    <h3 class="font-weight-bold">Welcome <?php echo session()->get('user_name') ?></h3>
                    <h6 class="font-weight-normal mb-0">All systems are running smoothly!</span></h6>
                </div>

            </div>
        </div>
    </div>
    <!-- Graphs-->
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="card-title">Your Rental Income</p>
                    </div>
                    <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                    <canvas id="sales-chart"></canvas>
                </div>
            </div>
        </div>
        <!--pie adjustment -->
        <div class="col-md-6 grid-margin stretch-card ">
            <div class="card position-relative">
                <div class="card-body">
                    <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-12 col-xl-6 d-flex flex-column justify-content-start">
                                        <div class="ml-xl-4 mt-3">
                                            <p class="card-title">Category Reports</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-9">
                                        <div class="row">
                                            <div class="col-md-12 mt-3">
                                                <canvas id="south-america-chart"></canvas>
                                                <div id="south-america-legend"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 mb-lg-0 transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4 tile_partner">Total Stocks</p>
                            <p class="fs-30 mb-2"><?= $total_products ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4 tile_partner">Total Rentals</p>
                            <p class="fs-30 mb-2"><?= $total_stocks ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4 transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4 tile_partner">Commission Earned</p>
                            <p class="fs-30 mb-2">€<?php echo number_format($comission_earned, 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-responsive">
                <p>Top 10 Rented Products</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Stock  Name</th>
                            <th>SKU</th>
                            <th>Brand Name</th>
                            <th>Number Of Rotations</th>
                            <th>Rental income</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($top_ten_results) :  ?>
                            <?php foreach ($top_ten_results as $row) :
								$user_id =$_SESSION['user_id'];
                                $result = $model->GetSingleRow(PRODUCTS_TABLE, array('id' => $row['product_id']));
                                //rotation of product
                                $total_rotation = $model->GetTotalCount(STOCKS_TABLE, array('product_id' => $row['product_id'],'user_id'=>$user_id));
								if (!empty($total_rotation)) :
                                    $product_rotation  = $total_rotation;
                                else :
                                    $product_rotation = 0;
                                endif;
                                $media_src = json_decode($model->getMediaData($result['media_id']))->media_src;
                            ?>
                                <tr>
                                    <td><a href="<?php echo $media_src ?>" target="_blank"><img class="img-fluid img-thumbnail" src="<?php if (!empty($media_src)) {
                                                                                                                                            echo $media_src;
                                                                                                                                        } else {
                                                                                                                                            echo "https://via.placeholder.com/60//fff?text=" . ucfirst(substr($result['title'], 0, 1));
                                                                                                                                        } ?>"></a> <?php echo ucfirst($result['title']) ?></td>
                                    <td><?php echo ($result['sku']) ?></td>

                                    <td><?php echo ($result['brand_name']) ?></td>
                                    <td><?php echo ($product_rotation) ?></td>
                                    <td>€<?php echo number_format($row['rental_income'], 2, ',', '.') ?></td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td>
                                    <p>Data not found.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
<?= $this->endSection() ?>
<?= $this->section("script") ?>
<script>
    //Get params
    var data_to_be_filtered = "yearly";
    var category = "";
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };

    if (getUrlParameter('data-type') != false) {
        data_to_be_filtered = getUrlParameter('data-type');
    }
    if (getUrlParameter('category_id') != false) {
        category = getUrlParameter('category_id');
    }
    //on change filter data
    $(document).on('change', '.filter_charts_data', function() {
        var data_filter_type = $(this).val();
        if (data_filter_type != '') {
            var url = window.location.pathname;
            var redirect_url = url + '?data-type=' + data_filter_type;
            window.location.href = redirect_url;
        }

    })
    //Retail value
    $(document).ready(function() {
        var data = {
            data_to_be_filtered: data_to_be_filtered,
            category: category
        };
        $.ajax({
            url: "<?php echo base_url('account/claculate_retail_value'); ?>",
            type: "GET",
            data: data,
            dataType: "json",
        }).done(function(resp) {
            if (resp.status == "success") {
                var label_arr = JSON.parse(JSON.stringify(resp.retail_month));
                var retail_values = JSON.parse(JSON.stringify(resp.retail_values));
                claculateRetailValue(label_arr, retail_values);
            } else {
                console.log(resp);
            }
        });

    });
    //Income Rental Value
    $(document).ready(function() {
        var data = {
            data_to_be_filtered: data_to_be_filtered,
            category: category
        };
        $.ajax({
            url: "<?php echo base_url('account/claculate_rental_transaction'); ?>",
            type: "GET",
            data: data,
            dataType: "json",
        }).done(function(resp) {
            if (resp.status == "success") {
                var label_arr = JSON.parse(JSON.stringify(resp.rental_month));
                var admin_monthly_value = JSON.parse(JSON.stringify(resp.rental_values_admin));
                var partner_monthly_value = JSON.parse(JSON.stringify(resp.rental_values_partners));
                claculatePartnerRentalTransaction(label_arr, partner_monthly_value);
            } else {
                console.log(resp);
            }
        });
    });

    //Calculate Pie of  ategory_pie 
    $(document).ready(function() {
        var data = "";
        $.ajax({
            url: "<?php echo base_url('account/calculate_category_pie'); ?>",
            type: "GET",
            data: data,
            dataType: "json",
        }).done(function(resp) {
            if (resp.status == "success") {
                var label_arr = JSON.parse(JSON.stringify(resp.category_name));
                var rental_income = JSON.parse(JSON.stringify(resp.rental_income));
                var total_rental_income = resp.total_rental_income;
                console.log(label_arr);
                CalculateCategoryPie(label_arr, rental_income, total_rental_income);
            } else {
                console.log(resp);
            }
        });
    });
    //Calculate Pie of memebership 
    /* $(document).ready(function(){
    	
    	var data = {data_to_be_filtered: data_to_be_filtered};
    	$.ajax({
    		url:"<?php echo base_url('account/claculate_membership_pie'); ?>",
    		type:"GET",
    		data: data,
    		dataType: "json",
    	}).done(function (resp) {
    		if (resp.status == "success") {
    			var label_arr = JSON.parse(JSON.stringify(resp.membership_plan_name));
    			var members = JSON.parse(JSON.stringify(resp.members));
    			var total_members = resp.total_members;
    			console.log(label_arr);
    			alert(total_members)
    			CalculateMembershipPie(label_arr,members,total_members);
    		} else {
    			 console.log(resp);
    		}
    	});
    }); */
</script>
<?= $this->endSection() ?>