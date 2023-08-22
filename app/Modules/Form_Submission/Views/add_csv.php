<?=$this->extend("admin/layout/master")?>

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select class="form-control" name="category_id" id="category_id" >
                                        <option value="">--Select--</option>
										  <?=$categories?>
                                     </select>
									<?php if(!empty($errors['category_id'])): ?>
									 <p class="error"><?= $errors['category_id']?></p>
									<?php endif;?>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Select  Sub Category</label>
                                    <select class="form-control" name="sub_categories" id="sub_categories" >
                                        <option value="">--Select--</option>
										  <?=$sub_categories?>
                                     </select>
                                     <?php if(!empty($errors['sub_categories'])): ?>
									 <p class="error"><?= $errors['sub_categories']?></p>
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
/* On select of category_id */
$(document).on("change","#category_id",function(){
	var parent_id = $(this).val();
	if(parent_id!="")
    {
		$.ajax({
			type: "POST",
			
			url: "<?php echo base_url('admin/submissions/get-subcategories');?>",
			data: "parent_id="+parent_id,
			dataType: "json",
			success: function(result){
				if(result.status=="success")
				{
					$('#sub_categories').html(result.html);
				}
				else
				{
					$('#sub_categories').html(result.html);
				}
			}
		});
	}
	else{
		$('#sub_categories').html('<option value="">Please select</option>');
	}
	
});
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