<?=$this->extend("user/layout/master")?>

<?=$this->section('style')?>
<style>
.favor_in_span {
		color:red;
		font-size: 0.875rem;
	}	
</style>
<?= $this->endSection() ?>

<?=$this->section("content")?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?=$module?></h4>
                    <?php 
                        if(session()->getFlashdata('flash_message'))
                        { ?>
                            <div class="alert alert-<?php echo session()->getFlashdata('class'); ?>" style="display: block;">
                                <button class="close" data-close="alert"></button>
                                <span> <?php echo session()->getFlashdata('flash_message'); ?> </span>
                            </div>
                            <?php
                        }
                    ?>
                    <?php echo form_open('',array('class'=>'forms-sample','autocomplete'=>'off'),array('s'=>'ok')); ?>
                        <div class="row">
							<div class="col-md-12">
								<h4>Profile Detail</h4>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="<?= $name ?>" class="form-control" id="name" />
									<?php if(!empty($errors['name'])): ?>
									 <p class="error"><?= $errors['name']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" value="<?= $email ?>" class="form-control" id="email" />
									<?php if(!empty($errors['name'])): ?>
									 <p class="error"><?= $errors['name']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" value="" class="form-control" id="password" autocomplete="new-password"/>
									<?php if(!empty($errors['name'])): ?>
									 <p class="error"><?= $errors['name']?></p>
									<?php endif;?>
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" value="<?= $phone ?>" class="form-control" id="phone" />
									<?php if(!empty($errors['phone'])): ?>
									 <p class="error"><?= $errors['phone']?></p>
									<?php endif;?>
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" rows="3" name="description"><?= $description ?></textarea>
									<?php if(!empty($errors['description'])): ?>
									 <p class="error"><?= $errors['description']?></p>
									<?php endif;?>
                                </div>
                            </div>
							<div class="col-md-4 user_avatar">
								<div class="form-group">
									<label>Profile Picture</label>
									<input type="file" name="avtar" class="file-upload-default" id="imgInp" />
									<input type="hidden" name="avtar_file" class="file" value="<?=$media_id?>" />
									<div class="input-group col-xs-12">
										<input type="text" class="form-control file-upload-info" disabled="" />
										<span class="input-group-append">
											<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
										</span>
									</div>
									<?php if(!empty($errors['avtar_file'])): ?>
									    <p class="error"><?= $errors['avtar_file']?></p>
									<?php endif;?>
								</div>
                                <?php if(isset($media_src) && !empty($media_src)):?><div class="form-group">
                                        <label>Uploaded Profile Picture</label> <br>
                                        <img src="<?=$media_src ?>" class="img-thumbnail" id="blah"> 
                                    </div>
                                <?php endif;?>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-12">
								<h4>Company Detail</h4>
								<hr>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="company_name">Business name<span class="favor_in_span">*</span></label>
									<input type="text" class="form-control" name="company_name" value="<?=$company_name?>" id="company_name" autocomplete="off" />
									<?php if(!empty($errors['company_name'])): ?>
									 <p class="error"><?= $errors['company_name']?></p>
									<?php endif;?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail3">Company address</label>
									<input type="text" class="form-control" name="company_address" value="<?=$company_address?>" id="exampleInputEmail3" autocomplete="off" />
									<?php if(!empty($errors['company_address'])): ?>
									 <p class="error"><?= $errors['company_address']?></p>
									<?php endif;?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="phone">IBAN</label>
									<input type="number" class="form-control" name="iban" value="<?=$iban?>" id="iban" autocomplete="off" />
									<?php if(!empty($errors['iban'])): ?>
									 <p class="error"><?= $errors['iban']?></p>
									<?php endif;?>
								</div>
							</div>
                            <div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail3">VAT</label>
									<input type="text" class="form-control" name="vat" value="<?=$vat?>" id="exampleInputEmail3" autocomplete="off" />
									<?php if(!empty($errors['vat'])): ?>
									 <p class="error"><?= $errors['vat']?></p>
									<?php endif;?>
								</div>
							</div>
                            <div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail3">Chamber of commerce</label>
									<input type="text" class="form-control" name="chamber_of_commerce" value="<?=$chamber_of_commerce?>" id="exampleInputEmail3" autocomplete="off" />
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
$(document).on('change', '.user_avatar .file-upload-default', function(e) {
        var self = $(this);
        var data = new FormData();
        data.append('file', e.target.files[0]);
        $.ajax({
            url: "<?php echo base_url('account/upload') ?>",
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
	imgInp.onchange = evt => {
	  const [file] = imgInp.files
	  if (file) {
		blah.src = URL.createObjectURL(file)
	  }
	}
</script>
<?=$this->endSection()?>