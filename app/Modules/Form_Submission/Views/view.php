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
        <div class="col-12 grid-margin stretch-card submission-table">
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
                        <div class="row">
							<div class="col-lg-12">
							<h4 class="card-title">Submission Details</h4>
						</div>
						<?php $data = unserialize($form_data);
						    if(isset($data) && count($data) > 0):
									foreach($data as $result):
									   if(isset($result['title']) && !empty($result['title'])):
									      echo ' 
												<div class="col-lg-12">
												<h5 class="title">'.$result['title'].'</h5>
											</div>';
									   endif;
									    if(isset($result['sub_title']) && !empty($result['sub_title'])):
									      echo ' 
												<div class="col-lg-12">
												<h5 class="sub_title">'.$result['sub_title'].'</h5>
											</div>';
									   endif;
									   foreach($result['fields'] as $fields):
									         if(isset($fields['label']) && isset($fields['name'])):
											?>
												 <div class="col-lg-6 submission-label">
													<label><?php if(isset($fields['label'])): echo $fields['label']; endif;?></label>
													<p><?php if(isset($fields['name'])): echo $fields['name']; endif;?></p>
												 </div>
												   
							   <?php      endif;
							              if(isset($fields['label']) && isset($fields['file_ids']) &&  $fields['type'] == '4'):
										      $images = explode(',',$fields['file_ids']);
											?>
											     <div class="col-lg-12">
													<h4>Attachments</h4>
												 </div>
												 <div class="col-lg-12">
													<label><?php if(isset($fields['label'])): echo $fields['label']; endif;?></label>
												 </div>
										<?php foreach($images as $key ):
										     $image = $model->GetSingleValue(MEDIA_TABLE,'name',array('id' => $key));
											 $display_image = base_url('uploads/'.$image);
											 ?>
												 <div class="col-lg-4">
													<p><?php if(isset($image) && !empty($image)): echo '<img src="'.$display_image.'" alt="Girl in a jacket" width="300" height="300">'; endif;?></p>
												 </div>  
							   <?php          endforeach;
							             endif;
							           endforeach;
							        endforeach;
					   endif; ?>
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