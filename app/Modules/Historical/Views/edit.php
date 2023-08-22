<?= $this->extend("admin/layout/master") ?>

<?= $this->section("style") ?>
<style>
	.action {
		margin-top: 35px;
	}

	a.remove_row {
		font-size: 35px;
	}

	.existing_user_avatar img {
		display: block;
	}

	.existing_banner_avatar img {
		display: block;
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
					<!--<?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger errors">
                            <?php foreach ($errors as $field => $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>-->
					<?php echo form_open_multipart('', array('class' => 'forms-sample'), array('s' => 'ok')); ?>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="user_id">Partner<span class="favor_in_span">*</span></label>
								<select class="form-control" name="user_id" id="user_id">
									<option value="">--Select Partner--</option>
									<?php echo $users; ?>
								</select>
								<?php if (!empty($errors['user_id'])) : ?>
									<p class="error"><?= $errors['user_id'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="product_id">Product<span class="favor_in_span">*</span></label>
								<select class="form-control" name="product_id" id="product_id">
									<option value="">--Select Product--</option>
									<?php echo $products; ?>
								</select>
								<?php if (!empty($errors['product_id'])) : ?>
									<p class="error"><?= $errors['product_id'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="membership_id">Membership<span class="favor_in_span">*</span></label>
								<select class="form-control" name="membership_id" id="membership_id">
									<option value="">--Select Membership--</option>
									<?php echo $memberships; ?>
								</select>
								<?php if (!empty($errors['membership_id'])) : ?>
									<p class="error"><?= $errors['membership_id'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="membership_amount">Membership amount<span class="favor_in_span">*</span></label>
								<input type="text" class="form-control" name="membership_amount" value="<?php echo $membership_amount ?>" id="membership_amount" autocomplete="off" />
								<?php if (!empty($errors['membership_amount'])) : ?>
									<p class="error"><?= $errors['membership_amount'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="commission_paid">Commission Paid<span class="favor_in_span">*</span></label>
								<input type="text" class="form-control" name="commission_paid" value="<?php echo $commission_paid ?>" id="commission_paid" autocomplete="off" />
								<?php if (!empty($errors['commission_paid'])) : ?>
									<p class="error"><?= $errors['commission_paid'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="rental_income_for_partner">Rental Income for partner<span class="favor_in_span">*</span></label>
								<input type="text" class="form-control" name="rental_income_for_partner" value="<?php echo $rental_income_for_partner ?>" id="rental_income_for_partner" autocomplete="off" readonly />
								<?php if (!empty($errors['rental_income_for_partner'])) : ?>
									<p class="error"><?= $errors['rental_income_for_partner'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="rental_income_for_admin">Rental Income for admin<span class="favor_in_span">*</span></label>
								<input type="text" class="form-control" name="rental_income_for_admin" value="<?php echo $rental_income_for_admin ?>" id="rental_income_for_admin" autocomplete="off" readonly />
								<?php if (!empty($errors['rental_income_for_admin'])) : ?>
									<p class="error"><?= $errors['rental_income_for_admin'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="rented_on">Rented On<span class="favor_in_span">*</span></label>
								<input type="date" class="form-control" name="rented_on" value="<?php echo date('Y-m-d',$rented_on) ?>" id="rented_on" autocomplete="off" />
								<?php if (!empty($errors['rented_on'])) : ?>
									<p class="error"><?= $errors['rented_on'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="expiry_date">Expiry Date<span class="favor_in_span">*</span></label>
								<input type="date" class="form-control" name="expiry_date"  value="<?php echo date('Y-m-d',$expiry_date) ?>" id="expiry_date" autocomplete="off" />
								 <?php 
								     $message = "";
									if(session()->getFlashdata('flash_expiry'))
									{ $message = '<p class="error">Expiry date must be less than Rented on date!.</p>';
								       ?>
									<?php }?>
								 <span class="expiry_date_error"><?=$message?></span>
								 <?php if (!empty($errors['item_rented_by_males'])) : ?>
								<p class="error"><?= $errors['item_rented_by_males'] ?></p>
								<?php endif; ?>
								<?php if (!empty($errors['expiry_date'])) : ?>
									<p class="error"><?= $errors['expiry_date'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<!--<div class="col-md-3">
							<div class="form-group">
								<label for="rented_items">Rented Items</label>
								<input type="text" class="form-control" name="rented_items" value="<?php echo $rented_items ?>" id="rented_items" autocomplete="off" />
								<?php if (!empty($errors['rented_items'])) : ?>
									<p class="error"><?= $errors['rented_items'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="number_of_rotations">Number Of Rotations</label>
								<input type="text" class="form-control" name="number_of_rotations" value="<?php echo $number_of_rotations ?>" id="number_of_rotations" autocomplete="off" />
								<?php if (!empty($errors['number_of_rotations'])) : ?>
									<p class="error"><?= $errors['number_of_rotations'] ?></p>
								<?php endif; ?>
							</div>
						</div>-->
						<div class="col-md-3">
							<div class="form-group">
								<label for="currently_rented">Currently Rented<span class="favor_in_span">*</span></label>
								<select class="form-control" name="currently_rented" id="currently_rented">
									<option value="1" <?php if ($currently_rented == 1) {
															echo "selected";
														} ?>>Yes</option>
									<option value="0" <?php if ($currently_rented == 0) {
															echo "selected";
														} ?>>No</option>
								</select>
								<?php if (!empty($errors['currently_rented'])) : ?>
									<p class="error"><?= $errors['currently_rented'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<!--
						<div class="col-md-3">
							<div class="form-group">
								<label for="item_rented_by_males">Item Rented By Males</label>
								<input type="text" class="form-control" name="item_rented_by_males" value="<?php echo set_value('item_rented_by_males') ?>" id="item_rented_by_males" autocomplete="off" />
								<?php if (!empty($errors['item_rented_by_males'])) : ?>
								<p class="error"><?= $errors['item_rented_by_males'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="item_rented_by_females">Item Rented By Females</label>
								<input type="text" class="form-control" name="item_rented_by_females" value="<?php echo set_value('item_rented_by_females') ?>" id="item_rented_by_females" autocomplete="off" />
								<?php if (!empty($errors['item_rented_by_females'])) : ?>
								<p class="error"><?= $errors['item_rented_by_females'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="item_rented_by_others">Item Rented By Others</label>
								<input type="text" class="form-control" name="item_rented_by_others" value="<?php echo set_value('item_rented_by_others') ?>" id="item_rented_by_others" autocomplete="off" />
								<?php if (!empty($errors['item_rented_by_others'])) : ?>
								<p class="error"><?= $errors['item_rented_by_others'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="gross_margin">Gross Margin</label>
								<input type="text" class="form-control" name="gross_margin" value="<?php echo set_value('gross_margin') ?>" id="gross_margin" autocomplete="off" />
								<?php if (!empty($errors['gross_margin'])) : ?>
								<p class="error"><?= $errors['gross_margin'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						--->
						<input type="hidden" class="form-control" name="retail_value" value="<?php echo $retail_value ?>" id="retail_value"/>
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-primary mr-2">Submit</button>
						</div>
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
  $(document).on('change', '#expiry_date', function(e) {
    var rented_on = document.getElementById("rented_on").value;
    var expiry_date = document.getElementById("expiry_date").value;
	$('.expiry_date_error').html('');
    var x = new Date(rented_on);
    var y = new Date(expiry_date);
    if (x > y) {
		$('.expiry_date_error').html('<p class="error">Expiry date must be less than Rented on date!.</p>');
        return false;
    }
	
	});
	//on keyup calculate precentage
	$(document).on('keyup', '#membership_amount', function(e) {
		calculate_rental_income();
	})

	$(document).on('keyup', '#commission_paid', function(e) {
		calculate_rental_income();
	})
	$(document).on('change','#product_id',function(){
		 let retail_value = $(this).find('option:selected').attr('extra_field');
		 $('#retail_value').val(retail_value);
	});
	/* $(document).on('change', '#membership_id', function() {
		var commission = $(this).find('option:selected').attr('extra_field');
		$('#commission_paid').val(commission);
		calculate_rental_income();
	}) */
	
	$(document).on('change','#membership_id',function(){
			$("#membership_amount").val(0);
			var commission = $(this).find('option:selected').attr('extra_field');
			var membership_id = $(this).val();
			var self = $(this);
			if (membership_id != '') {
				var data = {
					membership_id: membership_id
				}
				$.ajax({
					url: "<?php echo base_url('admin/'.$mr.'/get_membership_amount'); ?>",
					type: "POST",
					data: data,
					dataType: "json",
					enctype: "multipart/form-data",
				}).done(function(resp) {
					if (resp.status == "success") {
						$("#membership_amount").val(resp.html);
					} else {
						
					}
				});
			}
				setTimeout(function() {
						$('#commission_paid').val(commission);
						calculate_rental_income();
				}, 2000);
			
		})

	function calculate_rental_income() {
		var retail_value_integer = $('#membership_amount').val();
		var comission_earned_integer = $('#commission_paid').val();
		var rental_income = 0;
		var rental_income_for_admin = 0;

		if (($.isNumeric(comission_earned_integer)) && ($.isNumeric(retail_value_integer))) {

			var cei = parseFloat(comission_earned_integer);
			var rvi = parseFloat(retail_value_integer);
			rental_income = (cei / 100) * rvi;

			rental_income_for_admin = retail_value_integer - rental_income;

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
				url: "<?php echo base_url('admin/'.$mr.'/get_products'); ?>",
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