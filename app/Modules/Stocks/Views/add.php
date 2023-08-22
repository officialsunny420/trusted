<?=$this->extend("admin/layout/master")?>
<?=$this->section('style')?>
<style>
	.favor_in_span {
		color: red;
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
                    <div class="row">
					   <div class="col-lg-6" >
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
                    <?php endif ?> -->
                    <?php echo form_open('',array('class'=>'forms-sample'),array('s'=>'ok')); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Select Partner<span class="favor_in_span">*</span></label>
                                    <select class="form-control" name="user_id" id="exampleSelectGender">
                                        <option value="">--Select--</option>
                                        <?php echo $users; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Select Category<span class="favor_in_span">*</span></label>
                                    <select class="form-control" name="category_id" id="exampleSelectGender">
                                        <option value="">--Select--</option>
                                        <?php echo $categories; ?>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand_name">Brand Name<span class="favor_in_span">*</span></label>
                                    <input type="text" name="brand_name" value="<?=set_value('brand_name') ?>" class="form-control" id="brand_name" autocomplete="off"/>
									<?php if(!empty($errors['brand_name'])): ?>
									 <p class="error"><?= $errors['brand_name']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Stock Name<span class="favor_in_span">*</span></label>
                                    <input type="text" name="title" value="<?= set_value('title') ?>" class="form-control" id="title" autocomplete="off"/>
									<?php if(!empty($errors['title'])): ?>
									 <p class="error"><?= $errors['title']?></p>
									<?php endif;?>
                                </div>
                            </div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="retail_value">Retail Value<span class="favor_in_span">*</span></label>
									<input type="text" class="form-control" name="retail_value" value="<?= set_value('retail_value') ?>" id="retail_value" autocomplete="off" />
									<?php if (!empty($errors['retail_value'])) : ?>
										<p class="error"><?= $errors['retail_value'] ?></p>
									<?php endif; ?>
								</div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sku">SKU</label>
                                    <input type="text" name="sku" value="<?= set_value('sku') ?>" class="form-control" id="sku" autocomplete="off" />
									<?php if(!empty($errors['sku'])): ?>
									 <p class="error"><?= $errors['sku']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectColor">Color<span class="favor_in_span">*</span></label>
                                     <select class="form-control" name="color" id="exampleSelectColor">
                                        <option value="">--Select--</option>
                                            <?php $color_types =color_types(); 
											 if($color_types):
												 foreach($color_types as $key => $value): ?>
													<option value="<?=$key?>" <?php if($key == set_value('color')){ echo 'selected'; }?>><?=$value?></option>
											 <?php 
												endforeach;
											 endif; ?>
                                    </select>
									<?php if(!empty($errors['color'])): ?>
									 <p class="error"><?= $errors['color']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectSize">Size<span class="favor_in_span">*</span></label>
                                     <select class="form-control" name="size" id="exampleSelectSize">
                                        <option value="">--Select--</option>
                                          <?php $size_types = size_types(); 
											 if($size_types):
												 foreach($size_types as $key => $value): ?>
													<option value="<?=$key?>" <?php if($key == set_value('size')){ echo 'selected'; }?>><?=$value?></option>
											 <?php 
												endforeach;
											 endif; ?>
                                    </select>
									<?php if(!empty($errors['size'])): ?>
									 <p class="error"><?= $errors['size']?></p>
									<?php endif;?>
                                </div>
                            </div>
							<div class="col-md-4">
							  <div class="form-group">
								<label for="warehouse_arrival_date">Warehouse Arrival Date</label>
								<input type="date" class="form-control" name="warehouse_arrival_date"   value="<?php echo set_value('warehouse_arrival_date') ?>" id="warehouse_arrival_date" autocomplete="off" />
								<?php if (!empty($errors['warehouse_arrival_date'])) : ?>
									<p class="error"><?= $errors['warehouse_arrival_date'] ?></p>
								<?php endif; ?>
							  </div>
						   </div>
                            <div class="col-md-4 user_avatar">
								<div class="form-group">
									<label>Product Image</label>
									<input type="file" name="avtar" class="file-upload-default" />
									<input type="hidden" name="media_id" class="file"/>
									<div class="input-group col-xs-12">
										<input type="text" class="form-control file-upload-info" disabled="" />
										<span class="input-group-append">
											<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
										</span>
									</div>
									<?php if(!empty($errors['media_id'])): ?>
									 <p class="error"><?= $errors['media_id']?></p>
									<?php endif;?>
								</div>
							</div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" rows="3" name="description"><?= set_value('description') ?></textarea>
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
<?=$this->endSection()?>