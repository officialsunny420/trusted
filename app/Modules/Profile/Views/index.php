<?=$this->extend("admin/layout/master")?>

<?=$this->section('style')?>
<style>
	
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
                    <?php echo form_open('',array('class'=>'forms-sample'),array('s'=>'ok')); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <input type="text" name="name" value="<?= $name ?>" class="form-control" id="name" />
									<?php if(!empty($errors['name'])): ?>
									 <p class="error"><?= $errors['name']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Email</label>
                                    <input type="text" name="email" value="<?= $email ?>" class="form-control" id="email" />
									<?php if(!empty($errors['name'])): ?>
									 <p class="error"><?= $errors['name']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" />
									<?php if(!empty($errors['name'])): ?>
									 <p class="error"><?= $errors['name']?></p>
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