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
							<a href="<?php echo base_url('admin/'.$mr) ?>">
								<button type="button" class="btn btn-primary btn-icon-text btn-sm">
									<i class="mdi mdi-arrow-left">Back</i>                                                    
								</button>
							</a>
						</div>
					</div>
                   <!-- <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger errors">
                            <?php foreach ($errors as $field => $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>-->
                    <?php echo form_open_multipart('', array('class' => 'forms-sample'), array('s' => 'ok')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Partner Detail</h4>
                            <hr>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="country_id">Country<span class="favor_in_span">*</span></label>
                                <select class="form-control" name="country_id" id="country_id">
								  <option value="">--Select Country--</option>
								  <?php echo $countries; ?>
								</select>
								<?php if(!empty($errors['country_id'])): ?>
								 <p class="error"><?= $errors['country_id']?></p>
							    <?php endif;?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Name<span class="favor_in_span">*</span></label>
                                <input type="text" class="form-control" name="name" value="<?php echo set_value('name') ?>" id="name" autocomplete="off" />
								<?php if(!empty($errors['name'])): ?>
								 <p class="error"><?= $errors['name']?></p>
							    <?php endif;?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Email address<span class="favor_in_span">*</span></label>
                                <input type="email" class="form-control" name="email" value="<?php echo set_value('email') ?>" id="exampleInputEmail3" autocomplete="off" />
								<?php if(!empty($errors['email'])): ?>
								 <p class="error"><?= $errors['email']?></p>
							    <?php endif;?>
                            </div>
                        </div>
						<div class="col-md-3">
                            <div class="form-group">
                                <label for="phone">Phone<span class="favor_in_span">*</span></label>
                                <input type="text" class="form-control" name="phone" value="<?php echo set_value('phone') ?>" id="phone" autocomplete="off" />
								<?php if(!empty($errors['phone'])): ?>
								 <p class="error"><?= $errors['phone']?></p>
							    <?php endif;?>
                            </div>
                        </div>
                        
						<div class="col-md-4 user_avatar">
								<div class="form-group">
									<label>Profile Pic Upload <span class="favor_in_span">*</span></label>
									<input type="file" name="avtar" class="file-upload-default" />
									<input type="hidden" name="avtar_file" class="file"/>
									<div class="input-group col-xs-12">
										<input type="text" class="form-control file-upload-info" disabled=""/>
										<span class="input-group-append">
											<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
										</span>
									</div>
									<?php if(!empty($errors['avtar_file'])): ?>
									 <p class="error"><?= $errors['avtar_file']?></p>
									<?php endif;?>
								</div>
						</div>
						
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleTextarea1">Description</label>
                                <textarea class="form-control" name="description" id="exampleTextarea1" rows="4" autocomplete="off"><?php echo set_value('description') ?></textarea>
                            </div>
                        </div>
						
						<div class="col-md-12">
								<h4>Company Detail</h4>
								<hr>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="company_name">Business name<span class="favor_in_span">*</span></label>
									<input type="text" class="form-control" name="company_name" value="<?php echo set_value('company_name') ?>" id="company_name" autocomplete="off" />
									<?php if(!empty($errors['company_name'])): ?>
									 <p class="error"><?= $errors['company_name']?></p>
									<?php endif;?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail3">Company address<span class="favor_in_span">*</span></label>
									<input type="text" class="form-control" name="company_address" value="<?php echo set_value('company_address') ?>" id="exampleInputEmail3" autocomplete="off" />
									<?php if(!empty($errors['company_address'])): ?>
									 <p class="error"><?= $errors['company_address']?></p>
									<?php endif;?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="phone">IBAN<span class="favor_in_span">*</span></label>
									<input type="number" class="form-control" name="iban" value="<?php echo set_value('iban') ?>" id="iban" autocomplete="off" />
									<?php if(!empty($errors['iban'])): ?>
									 <p class="error"><?= $errors['iban']?></p>
									<?php endif;?>
								</div>
							</div>
                            <div class="col-md-4">
								<div class="form-group">
									<label for="phone">VAT<span class="favor_in_span">*</span></label>
									<input type="text" class="form-control" name="vat" value="<?php echo set_value('vat') ?>" id="vat" autocomplete="off" />
									<?php if(!empty($errors['vat'])): ?>
									 <p class="error"><?= $errors['vat']?></p>
									<?php endif;?>
								</div>
							</div>
                            <div class="col-md-4">
								<div class="form-group">
									<label for="phone">Chamber of commerce<span class="favor_in_span">*</span></label>
									<input type="text" class="form-control" name="chamber_of_commerce" value="<?php echo set_value('chamber_of_commerce') ?>" id="chamber_of_commerce" autocomplete="off" />
									<?php if(!empty($errors['chamber_of_commerce'])): ?>
									 <p class="error"><?= $errors['chamber_of_commerce']?></p>
									<?php endif;?>
								</div>
							</div>
						
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

	//profile picture
    $(document).on('change', '.user_avatar .file-upload-default', function(e) {
        var self = $(this);
        var data = new FormData();
        data.append('file', e.target.files[0]);
        $.ajax({
            url: "<?php echo base_url('admin/upload') ?>",
            type: "POST",
            data: data,
            enctype: 'multipart/form-data',
            processData: false, // tell jQuery not to process the data
            contentType: false // tell jQuery not to set contentType
        }).done(function(insert_id) {
            console.log(insert_id);
            self.parents('.user_avatar').find('.file').val(insert_id);
        });
        return false;
    });
</script>
<?= $this->endSection() ?>