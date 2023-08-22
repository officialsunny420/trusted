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
					<!-- Search form -->
					<form action="" >
						 <div class="row">
						    <div class="col-md-3">
								<div class="form-group">
									<label for="user_id">Category</label>
									<input type="text" class="form-control form-control-sm" name="title" value="<?php if(!empty($_GET['title'])){ echo $_GET['title'];} ?>" id="title" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="rented_on">Status</label>
									<select class="form-control form-control-sm" name="status" id="status">
									  <option value="" >--Select--</option>
									  <option value="1" <?php if(isset($_GET['status']) && $_GET['status'] == "1"){ echo 'selected';}?> >Active</option>
									  <option value="0" <?php if(isset($_GET['status']) && $_GET['status'] == "0"){ echo 'selected';}?> >Inactive</option>
									</select>
								</div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Select Category</label>
                                    <select class="form-control" name="id" id="exampleSelectGender" >
                                        <option value="">--Select--</option>
										  <?=$categories?>
                                     </select>
                                </div>
                            </div>
							<div class="col-md-3" style="margin-top: 28px;">
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
					<!-- End of search form -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Parent Category</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Status</th>
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
										if($result['parent_id']==0){
											$pc_text = "None";
										}
										else{
                                            $pc_text = $model->GetSingleValue(CATEGORIES_TABLE,'title',array('id' => $result['parent_id']));
										}

                                        ?> 
                                        <tr>
                                            <td><?php echo ucfirst($result['title']) ?></td>
                                            <td><?php echo ucfirst($pc_text) ?></td>
											<?php if (strlen($result['description']) > 10):?>
											<td class="descri"><span class="description"><?php echo substr($result['description'], 0, 7) . '...'; ?></span> <span class="full_description d-none"><?php echo $result['description'] ?></span>
                                               </td>
                                                   
											<?php else:?>
											<td ><?php echo $result['description'] ?></td>
											<?php endif;?>
                                           
                                            <td><?php echo date('d-M-Y',strtotime($result['created_at'])); ?></td>
                                            <td><input class="check_category_status" value="<?=$result['status'] ?>" type="checkbox" <?php if($result['status']==1){echo 'checked';};?> data-id="<?=$result['id'] ?>"></label></td>
											<td><a href="<?php echo base_url('admin/categories/edit/'.$result['id']) ?>" ><label class="badge badge-success"><i class="mdi mdi-eyedropper"></i> Edit</label></a></td>
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
  </script>
  <?=$this->endSection()?>