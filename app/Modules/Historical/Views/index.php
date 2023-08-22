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
						    <div class="col-md-2">
								<div class="form-group">
									<label for="user_id">Partner</label>
									<select class="form-control form-control-sm" name="user_id" id="user_id">
									  <option value="" >--Select Partner--</option>
									  <?php echo $existing_users;?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="product_id">Products</label>
									<select class="form-control form-control-sm" name="product_id" id="product_id">
									  <option value="" >--Select Product--</option>
										<?php if(!empty($_GET['product_id'])):?>
										<?php echo $existing_products;?>
										<?php endif;?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="membership_id">Members</label>
									<select class="form-control form-control-sm" name="membership_id" id="membership_id">
									  <option value="" >--Select --</option>
										<?php echo $existing_members;?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="rented_on">Rented On</label>
									<input type="date" class="form-control form-control-sm" name="rented_on" value="<?php if(!empty($_GET['rented_on'])){ echo $_GET['rented_on'];} ?>" id="rented_on" autocomplete="off" />
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
                                    <th>S No.</th>
                                    <th>Partner</th>
                                    <th>Product</th>
                                    <th>Member</th>
                                    <th>Retail Value</th>
                                    <th>Rented On</th>
                                    <th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results): ?>
                                    <?php foreach($results as $key=>$result): 
									   $user_name = $modal->GetSingleValue(USERS_TABLE,'name',array('id'=>$result['user_id']));
									   $product_name = $modal->GetSingleValue(PRODUCTS_TABLE,'title',array('id'=>$result['product_id']));
									   $member_name = $modal->GetSingleValue(MEMBERSHIP_TABLE,'title',array('id'=>$result['membership_id']));
									   
									?>
                                        <tr>
                                            <td><?=$key+1 ?></td>
                                            <td><?php if(!empty($user_name)){ echo $user_name;} ?></td>
                                            <td><?php if(!empty($product_name)){ echo $product_name;}?></td>
                                            <td><?php if(!empty($member_name)){ echo $member_name;}?></td>
                                            <td><?=$result['retail_value'] ?></td>
                                            <td><?php echo date('d-M-Y',$result['rented_on']); ?></td>
                                            <td><?php echo date('d-M-Y',$result['expiry_date']); ?></td>
											<td>
												<a href="<?php echo base_url('admin/'.$mr.'/edit/'.$result['id']) ?>" ><label class="badge badge-success"><i class="mdi mdi-eyedropper"></i> Edit</label></a>
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
  //on changing select tag of user
  $(document).on("change","#user_id",function(e){
	  var user_id = $(this).val();
	  var self = $(this);
	  if(user_id!='')
	  {
		  var data ={user_id: user_id}
		  $.ajax({
			url:"<?php echo base_url('admin/stocks/get_products');?>",
			type:"POST",
			data:data,
			dataType: "json",
			enctype: "multipart/form-data",
			}).done(function (resp){
				if(resp.status=="success")
				{
					$("#product_id").html(resp.html);
				}
				else{
					$("#product_id").html(resp.html);
				}
			});
	  }
  });
</script>
<?=$this->endSection()?>
