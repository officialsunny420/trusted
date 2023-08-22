<?=$this->extend("admin/layout/master")?>

<?=$this->section("content")?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Contact Us</h4>
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
					<!-- Search form -->
					<form action="" >
						 <div class="row">
						    <div class="col-md-3">
								<div class="form-group">
									<label for="user_id">Name</label>
									<input type="text" class="form-control form-control-sm" name="name" value="<?php if(!empty($_GET['name'])){ echo $_GET['name'];} ?>" id="name" autocomplete="off" />
								</div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Email</label>
                                   <input type="text" class="form-control form-control-sm" name="email" value="<?php if(!empty($_GET['email'])){ echo $_GET['email'];} ?>" id="email" autocomplete="off" />
                                </div>
                            </div>
							<div class="col-md-3" style="margin-top: 28px;">
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-icon-text btn-sm">
									   <i class="ti-reload btn-icon-prepend"></i>                                                     
									  Filter
									</button>
									<a href="<?php echo base_url('admin/'.$mr.'/contact_us') ?>"><button type="button" class="btn btn-warning btn-icon-text btn-sm">
									  <i class="ti-reload btn-icon-prepend"></i>                                                    
									  Reset
									</button></a>
								</div>
							</div>
						</div>
					</form>
					<!-- End of search form -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Number</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results): ?>
                                    <?php foreach($results as $result): 
                                        ?> 
                                        <tr>
                                            <td><?php echo ucfirst($result['name']) ?></td>
                                            <td><?php echo ucfirst($result['email']) ?></td>
                                            <td><?php echo ucfirst($result['number']) ?></td>
								
                                           
                                            <td><?php if($result['created_on']):  echo date('d-M-Y',$result['created_on']); endif; ?></td>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

/* $(document).on('click','.show',function(e){
 $(this).closest('td').find('.full_description').removeClass('d-none');
 $(this).closest('td').find('.description').addClass('d-none');
}); 

$(document).on('click','.show_less',function(e){
 $(this).closest('td').find('.full_description').addClass('d-none');
 $(this).closest('td').find('.description').removeClass('d-none');
}); */
 //on checking status of category
  $(document).on('change','.check_category_status',function(e){
	    var self = $(this);
		var data_id = $(this).data('id');
		var current_val = $(this).val();
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
			var text_for_swal = "Are you sure to inactive this category?";
		}
		else{
			var text_for_swal = "Are you sure to active this category??";
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
            url: "<?php echo base_url('admin/categories/change_status') ?>",
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
   $(document).on('click','.delete',function(e){
	  event.preventDefault(e);
	    var self = $(this);
		var data_id = $(this).data('id');
		var url = $(this).attr('url');
		var current_val = $(this).val();
		var data = {id: data_id};
		console.log(data);
        swal({
		  title: "Are you sure?",
		  text: 'You want to delete it?',
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			$.ajax({
            url: url,
            type: "POST",
            data: data,
			dataType: "json",
            enctype: 'multipart/form-data',
			}).done(function(resp) {
				if(resp.status=="success")
				{
					//self.val(resp.status_value);
					swal("Row successfully deleted!", {
					  icon: "success",
					});
					self.parents('tr').remove();
				}
				else
				{
					swal("Something went wrong!");
				}
			});
		  } else {
			//swal("Status has not been changed!");
		  }
		});
        return false;
  });
  </script>
  <?=$this->endSection()?>