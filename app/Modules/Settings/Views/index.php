<?=$this->extend("admin/layout/master")?>
<?= $this->section("style") ?>
<style>
.settings_admin_slider li {
    width: 33%;
    float: left;
    display: inline-block;
}
.settings_admin_slider li img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.settings_admin_slider li {
    width: 33%;
    float: left;
    display: inline-block;
    margin-right: 15px;
    position: relative;
    margin-bottom: 30px;
}
.favor_in_span {
	color:red;
	font-size: 0.875rem;
}
.settings_admin_slider li span.close {
    position: absolute;
    right: 5px;
    top: 5px;
    opacity: 1;
}
.settings_admin_slider li i {
    color: #4b49ac;
    opacity: 1;
}
.settings_admin_slider li span.close:hover i{
 color: red;
}
</style>
<?= $this->endSection() ?>
<?=$this->section("content")?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?= $module ?></h4>
					<p class="card-description"></p>
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
                            <div class="form-group">
                                <label for="imageUpload">Slider Images<span class="favor_in_span"> (Images size should be 975*320)</span></label>
						        <div id="imageUpload" name="files"class="dropzone"></div>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
				<!-- if slider images exist -->
				<?php if(isset($slider_img_src)):?>
				<div class="settings_admin_slider card-body">
					<h4 class="card-title">Slider Images</h4>
					<ul>
						<?php foreach($slider_img_src as $k=>$src): ?>
							<li>
								<img src="<?= $src['src'] ?>">
								<span data-id="<?= $src['id'] ?>" class="close"><i class="mdi mdi-delete"></i></span>
							</li>
						<?php endforeach;?>
					</ul>
				</div>
				<?php endif;?>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

<?=$this->endSection()?>
<?= $this->section("script") ?>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Dropzone Js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script>
	Dropzone.autoDiscover = false;
	$("#imageUpload").dropzone({
		url: "<?php echo base_url('admin/upload') ?>",
		addRemoveLinks : true,
		maxFilesize: 5,
		dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
		dictResponseError: 'Error uploading file!',
		success : function(file, response){
		   var response = JSON.parse(response);
		   $('form').append('<input type="hidden" name="attachment_ids[]" class="attachment_ids" value="'+response+'">');
		   file.previewElement.getElementsByClassName("dz-remove")[0].setAttribute("data-id",response);
		},
		removedfile: function(file) {
				var id =  file.previewElement.getElementsByClassName("dz-remove")[0].getAttribute("data-id");
				$.ajax ({
					type : "post",
					url : "<?php echo base_url('admin/remove_upload_images') ?>",
					data: {id:id},
					success:function(response){
						$("input.attachment_ids").each(function(){
							var exist_val = $(this).val();
							if(exist_val==id)
							{
								$(this).remove();
							}
						})                      
					}
				});  
					var _ref;
					//return (_ref = file.previewElement.parentElement.parentElement.closest("form#myform")) != null ? _ref.remove() : void 0;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
			}
		
	});
	
	//on deleting images
	$(document).on('click','span.close',function(e){
		var self = $(this);
		var data_id = self.data('id');
		if(data_id!='')
		{
			var data = {id: data_id};
			swal({
			  title: "Are you sure to delete?",
			  text: "Deleted image will not recover!!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				$.ajax({
				url: "<?php echo base_url('admin/settings/delete_image') ?>",
				type: "POST",
				data: data,
				dataType: "json",
				enctype: 'multipart/form-data',
				}).done(function(resp) {
					if(resp.status=="success")
					{
						swal("Image successfully deleted!", {
						  icon: "success",
						});
						self.parents("li").remove();   
					}
					else
					{
						swal("Image has not been deleted!");
					}
				});
			  } else {
				swal("Image has not been deleted!");
			  }
			});
		}
		return false;
	})

</script>
<?=$this->endSection()?>
