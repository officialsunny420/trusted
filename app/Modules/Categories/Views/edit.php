<?=$this->extend("admin/layout/master")?>

<?=$this->section('style')?>
<style>
	.existing_user_avatar img {
		display: block;
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
                    <?php endif ?> -->
                    <?php echo form_open('',array('class'=>'forms-sample'),array('s'=>'ok')); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <input type="text" name="title" value="<?= $title ?>" class="form-control" id="title" placeholder="Title" />
									<?php if(!empty($errors['title'])): ?>
									 <p class="error"><?= $errors['title']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Select Parent Category</label>
                                    <select class="form-control" name="parent_id" id="exampleSelectGender" >
                                        <option value="">--None--</option>
										  <?=$categories?>
                                     </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" rows="3" name="description"><?=$description ?></textarea>
                                </div>
                            </div>
							<!--<div class="col-md-3 user_avatar">
								<div class="form-group">
									<label>Category Image</label>
									<input type="file" name="avtar" class="file-upload-default" />
									<input type="hidden" name="avtar_file" class="file" value="<?=$media_id?>"/>
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
							</div>
							<?php if(isset($category_pic_src)):?>
							<div class="col-md-3 existing_user_avatar">
								<div class="form-group">
								    <label>Category Picture</label> 
									<img src="<?=$category_pic_src ?>" alt="<?=$title ?>" width="100" height="100"> 
								</div>
							</div>
							<?php endif;?>-->
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