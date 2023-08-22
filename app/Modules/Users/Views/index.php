<?=$this->extend("admin/layout/master")?>

<?=$this->section("content")?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $module ?></h4>
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
					<form action="" >
						 <div class="row">
						    <div class="col-md-3">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" class="form-control form-control-sm" name="name" value="<?php if(isset($_GET['name'])){ echo $_GET['name'];}?>" id="name" autocomplete="off" />
									</div>
							</div>
							<div class="col-md-3" style="margin-top: 33px;;">
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-icon-text btn-sm">
									   <i class="ti-reload btn-icon-prepend"></i>                                                     
									  Filter
									</button>
									<a href="<?php echo base_url('admin/'.$mr) ?>"><button type="button" class="btn btn-warning btn-icon-text btn-sm">
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Document</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results): ?>
                                    <?php foreach($results as $result): 
                                        $status = "Inactive";
                                        $status_cls = "danger";
                                        if($result['status']==1):
                                            $status = "Active";
                                            $status_cls = "success";
                                        endif;
                                        ?>
                                        <tr>
                                            <td><?php echo ucfirst($result['name']) ?></td>
                                            <td><?php echo $result['email'] ?></td>
                                            <td><input class="check_user_status" value="<?=$result['status'] ?>" type="checkbox" <?php if($result['status']==1){echo 'checked';};?> data-id="<?=$result['id'] ?>" data-url="<?php echo base_url('admin/'.$mr.'/change_status') ?>"></label></td>
											<td><a href="<?php echo base_url('admin/'.$mr.'/document/'.$result['id']) ?>" ><label class="badge badge-success"><i class="mdi mdi-eyedropper"></i> Document</label></a></td>
                                            <td><?php echo date('d-M-Y',strtotime($result['created_at'])); ?></td>
											<td>
												<a href="<?php echo base_url('admin/'.$mr.'/edit/'.$result['id']) ?>" ><label class="badge badge-success"><i class="mdi mdi-eyedropper"></i> Edit</label></a>
												<a class="delete_user" href="#" data-id="<?=$result['id']?>" data-url="<?php echo base_url('admin/'.$mr.'/delete_user') ?>" ><label class="badge badge-success"><i class="mdi mdi-delete"></i> Delete</label></a>
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
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

<?=$this->endSection()?>
<?= $this->section("script") ?>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  //on checking status of user
  $(document).on('change','.check_user_status',function(e){
	    var self = $(this);
		var data_id = $(this).data('id');
		var current_val = $(this).val();
		var data_url = $(this).data('url');
        if($(this).is(':checked'))
		{
			var data = {status: 1 ,id: data_id};
		}
		else
		{
			var data = {status: 0 ,id: data_id};
		}
		
		if(current_val==1)
		{
			var text_for_swal = "Are you sure to inactive this user??";
		}
		else{
			var text_for_swal = "Are you sure to active this user??";
		}
		console.log(data);
        swal({
		  title: "Are you sure?",
		  text: text_for_swal,
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
					self.val(resp.status_value);
					swal("Data successfully updated!", {
					  icon: "success",
					});
				}
				else
				{
					swal("Status has not been changed!");
				}
			});
		  } else {
			swal("Status has not been changed!");
		  }
		});
        return false;
  });
  
  //on deleting
   $(document).on('click','.delete_user',function(e){
	   e.preventDefault();
	   var self = $(this);
	   var data_id = $(this).data('id');
       var data = {id: data_id};
	   var data_url = $(this).data('url');
	   swal({
		  title: "Are you sure to delete?",
		  text: "Deleted user will not recover!!",
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
					swal("User successfully deleted!", {
					  icon: "success",
					});
					self.parents("tr").remove();   
				}
				else
				{
					swal("User has not been deleted!");
				}
			});
		  } else {
			swal("User has not been deleted!");
		  }
		});
        return false;
   });
</script>
<?=$this->endSection()?>
