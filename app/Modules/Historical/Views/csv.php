<?= $this->extend("admin/layout/master") ?>

<?= $this->section("style") ?>
<style>
	.action {
		margin-top: 35px;
	}

	a.remove_row {
		font-size: 35px;
	}

	.favor_in_span {
		color: red;
		font-size: 0.875rem;
	}
</style>
<?= $this->endSection() ?>
<?= $this->section("content") ?>
<div class="content-wrapper">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					 <div class="row">
						<div class="col-lg-6">
							<h4 class="card-title"><?=$module?></h4>
						</div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?php echo base_url('admin/'.$mr) ?>">
								<button type="button" class="btn btn-primary btn-icon-text btn-sm">
									<i class="mdi mdi-arrow-left">Back</i>                                                    
								</button>
							</a>
						</div>
					</div>
					    <div class="mt-2">
                    <?php if (session()->has('message')){ ?>
                        <div class="alert <?=session()->getFlashdata('alert-class') ?>">
                            <?=session()->getFlashdata('message') ?>
                        </div>
                    <?php } ?>

                    <?php $validation = \Config\Services::validation(); ?>
                </div>  
                <form action="<?=base_url('admin/'.$mr.'/importcsv')?>" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <div class="mb-3">
                            <input type="file" name="file" class="form-control" id="file">
                        </div>                     
                    </div>
                    <div class="d-grid">
                        <input type="submit" name="submit" value="Upload" class="btn btn-dark" />
                    </div>
                </form>
            </div>
			</div>
		</div>
	</div>
</div>
<!-- content-wrapper ends -->
<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<script>
	//on keyup calculate precentage
	$(document).on('keyup', '#retail_value', function(e) {
		calculate_rental_income();
	})

	$(document).on('keyup', '#commission_paid', function(e) {
		calculate_rental_income();
	})

	$(document).on('change','#membership_id',function(){
		var commission = $(this).find('option:selected').attr('extra_field');
		$('#commission_paid').val(commission);
		calculate_rental_income();
	})

	function calculate_rental_income() {
		var retail_value_integer = $('#retail_value').val();
		var comission_earned_integer = $('#commission_paid').val();
		var rental_income = 0;
		var rental_income_for_admin = 0;

		if (($.isNumeric(comission_earned_integer)) && ($.isNumeric(retail_value_integer))) 
		{
			
			var cei = parseFloat(comission_earned_integer);
			var rvi = parseFloat(retail_value_integer);
			rental_income = (cei / 100) * rvi;

			rental_income_for_admin = retail_value_integer-rental_income;

			$("#rental_income_for_partner").val(rental_income);
			$("#rental_income_for_admin").val(rental_income_for_admin);
		} else {
			$("#rental_income_for_partner").val(rental_income);
			$("#rental_income_for_admin").val(rental_income_for_admin);
		}
	}

	//on changing select tag of user
	$(document).on("change", "#user_id", function(e) {
		var user_id = $(this).val();
		var self = $(this);
		if (user_id != '') {
			var data = {
				user_id: user_id
			}
			$.ajax({
				url: "<?php echo base_url('admin/stocks/get_products'); ?>",
				type: "POST",
				data: data,
				dataType: "json",
				enctype: "multipart/form-data",
			}).done(function(resp) {
				if (resp.status == "success") {
					$("#product_id").html(resp.html);
				} else {
					$("#product_id").html(resp.html);
				}
			});
		}
	});
</script>
<?= $this->endSection() ?>