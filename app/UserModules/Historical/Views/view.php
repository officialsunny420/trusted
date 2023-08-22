<?= $this->extend("user/layout/master") ?>

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
	.existing_banner_avatar img{
		display: block;
	}
	.favor_in_span {
		color:red;
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
								<a href="<?php echo base_url('account/'.$mr) ?>">
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
                    <div class="row">
							<div class="col-md-12">
								<h4>Historical Detail</h4>
								<hr>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="products">Stock</label>
									<select class="form-control" name="product_id" id="products" disabled="disabled">
									  <option value="">--Select Stock--</option>
									  <?php echo $products; ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="membership_id">Membership</label>
									<select class="form-control" name="membership_id" id="membership_id" disabled="disabled">
										<option value="">--Select Membership--</option>
										<?php echo $memberships; ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="retail_value">Retail Value</label>
									<input type="text" class="form-control" name="retail_value" value="<?=$retail_value ?>" id="retail_value" readonly autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="commission_paid">Commission Earned (%)</label>
									<input type="text" class="form-control" name="commission_paid" value="<?php echo $commission_paid ?>" id="commission_paid" readonly autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="rental_income_for_partner">Rental Income</label>
									<input type="text" class="form-control" name="rental_income_for_partner" value="<?php echo $rental_income_for_partner ?>" id="rental_income_for_partner" autocomplete="off" readonly />	
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="rented_on">Rented On</label>
									<input type="date" class="form-control" name="rented_on" value="<?php echo date('Y-m-d', $rented_on) ?>" id="rented_on" readonly autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="expiry_date">Expiry Date</label>
									<input type="date" class="form-control" name="warehouse_arrival_date" value="<?php if($expiry_date!=0){echo date('Y-m-d',$expiry_date); }?>" id="expiry_date" autocomplete="off" readonly />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="currently_rented">Currently Rented</label>
									<select class="form-control" name="currently_rented" id="currently_rented" disabled="disabled">
										<option value="1" <?php if ($currently_rented == 1) {
																echo "selected";
															} ?>>Yes</option>
										<option value="0" <?php if ($currently_rented == 0) {
																echo "selected";
															} ?>>No</option>
									</select>
								</div>
							</div>
						<div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<?= $this->endSection() ?>