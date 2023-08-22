<?= $this->extend("user/layout/master") ?>

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
	#overlay{	
	  position: fixed;
	  top: 0;
	  z-index: 100;
	  width: 100%;
	  height:100%;
	  display: none;
	  background: rgba(0,0,0,0.6);
	}
	.cv-spinner {
	  height: 100%;
	  display: flex;
	  justify-content: center;
	  align-items: center;  
	}
	.spinner {
	  width: 40px;
	  height: 40px;
	  border: 4px #ddd solid;
	  border-top: 4px #1e1d45 solid;
	  border-radius: 50%;
	  animation: sp-anime 0.8s infinite linear;
	}
	@keyframes sp-anime {
	  100% { 
		transform: rotate(360deg); 
	  }
	}
	.is-hide{
	  display:none;
	}
</style>
<?= $this->endSection() ?>
<?= $this->section("loader")?>
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section("content") ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<h4 class="card-title">Add your document</h4>
						</div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?php echo base_url('account/'.$mr) ?>">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Type<span class="favor_in_span">*</span></label>
                                <select class="form-control" name="type" id="type">
								  <option value="">--Select--</option>
								  <option value="1" <?php if(set_value('type') == 1 ){ echo 'selected';}?>>Contract</option>
								  <option value="2" <?php if(set_value('type') == 2 ){ echo 'selected';}?>>Catalog</option>
								</select>
								<?php if(!empty($errors['type'])): ?>
								 <p class="error"><?= $errors['type']?></p>
							    <?php endif;?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Title<span class="favor_in_span">*</span></label>
                                <input type="text" class="form-control" name="title" value="<?php echo set_value('title') ?>" id="title" autocomplete="off" />
								<?php if(!empty($errors['title'])): ?>
								 <p class="error"><?= $errors['title']?></p>
							    <?php endif;?>
                            </div>
                        </div>
						<div class="col-md-4 user_avatar">
								<div class="form-group">
									<label>Document Upload <span class="favor_in_span">*</span></label>
									<input type="file" name="avtar" class="file-upload-default" />
									<input type="hidden" name="avtar_file"  class="file"/>
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
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                    </form>
					
					<h4 class="card-title" >Your document details</h4>
					<hr>
					
					<form action="" >
						 <div class="row">
						    <div class="col-md-3">
									<div class="form-group">
										<label for="name">Title</label>
										<input type="text" class="form-control" name="title" value="<?php echo set_value('title') ?>" id="title" autocomplete="off" />
									</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="type">Type</label>
									<select class="form-control" name="type" id="type">
									  <option value="" >--Select--</option>
									  <option value="1" <?php if(isset($_GET['type']) && ($_GET['type'] == 1)){ echo 'selected';}?>>Contract</option>
									  <option value="2" <?php if(isset($_GET['type']) && ($_GET['type'] == 2)){ echo 'selected';}?>>Catalog</option>
									</select>
								</div>
							</div>
							<div class="col-md-4" style="margin-top: 33px;">
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-icon-text btn-sm">
									   <i class="ti-reload btn-icon-prepend"></i>                                                     
									  Filter
									</button>
									<a href="<?php echo base_url('admin/'.$mr.'/document/'.$user_id) ?>"><button type="button" class="btn btn-warning btn-icon-text btn-sm">
									  <i class="ti-reload btn-icon-prepend"></i>                                                    
									  Reset
									</button></a>
								</div>
							</div>
						</div>
					</form>
					 <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
									<th>File</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results): ?>
                                    <?php foreach($results as $result):
									     $type = "";
                                         if($result['type'] == 1){
											 $type = 'Contract';
										 }	
										elseif($result['type'] == 2){
											$type = 'Catalog';
										}	
										$media =  json_decode($modal->getMediaData($result['media_id']));
                                        ?>
                                        <tr>
                                            <td><?php echo ucfirst($result['title']) ?></td>
                                            <td><?php echo $type ?></td>
                                            <td><a href="<?php echo $media->media_src ?>" target="_blank"><?php echo $media->original_name; ?></a></td>
                                            <td><?php echo date('d-M-Y',strtotime($result['created_at'])); ?></td>
											<td>
												<a class="delete_document" href="#" data-id="<?=$result['id']?>" data-url="<?php echo base_url('account/'.$mr.'/delete_document') ?>" ><label class="badge badge-success"><i class="mdi mdi-delete"></i> Delete</label></a>
											</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?> 
                                    <tr>
                                        <td><p>Data not found.</p></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
					 <div class="pagination">
                        
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
<script src="<?php echo base_url('assets/common/js/custom.js') ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$(document).ajaxSend(function() {
		$("#overlay").fadeIn();　
	});
	//profile picture
    $(document).on('change', '.user_avatar .file-upload-default', function(e) {
		$('.user_avatar').find("p.error").remove();
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
			$("#overlay").fadeOut();
        });
        return false;
    });
	//on deleting
   $(document).on('click','.delete_document',function(e){
	   e.preventDefault();
	   var self = $(this);
	   var data_id = $(this).data('id');
       var data = {id: data_id};
	   var data_url = $(this).data('url');
	   swal({
		  title: "Are you sure to delete?",
		  text: "Deleted document will not recover!!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			$.ajax({
            url: data_url,
            type: "POST",
            data: data,
			dataType: "json",
            enctype: 'multipart/form-data',
			}).done(function(resp) {
				if(resp.status=="success")
				{
					swal("Document successfully deleted!", {
					  icon: "success",
					});
					self.parents("tr").remove();   
				}
				else
				{
					swal("Document has not been deleted!");
				}
			});
		  } else {
			  
				swal("Document has not been deleted!");
		  }
		});
        return false;
   });
</script>
<?= $this->endSection() ?>