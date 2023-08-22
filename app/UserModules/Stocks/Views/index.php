<?=$this->extend("user/layout/master")?>

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
									<label for="user_id">Stock Name</label>
									<input type="text" class="form-control form-control-sm" name="title" value="<?php if(!empty($_GET['title'])){ echo $_GET['title'];} ?>" id="title" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="category_id">Category</label>
									<select class="form-control form-control-sm" name="category_id" id="category_id">
									  <option value="" >--Select Category--</option>
									  <?php echo $existing_categories;?>
									</select>
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
							<div class="col-md-3" style="margin-top: 28px;">
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-icon-text btn-sm">
									   <i class="ti-reload btn-icon-prepend"></i>                                                     
									  Filter
									</button>
									<a href="<?php echo base_url('account/'.$mr) ?>"><button type="button" class="btn btn-warning btn-icon-text btn-sm">
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
                                    <th>Stock Name</th>
                                    <th>SKU</th>
                                    <th>Brand Name</th>
                                    <th>Number Of Rotation</th>
                                    <th>Category</th>
									<th>Description</th>
                                    <th>Status</th>
                                    <th>Rental Income</th>
                                    <th>Income/Retail value</th>
                                    <th>Warehouse Arrival</th>
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
                                        $media_src = json_decode($model->getMediaData($result['media_id']))->media_src;
                                        ?> 
                                        <tr>
                                            <td><a href="<?php echo $media_src ?>" target="_blank"><img class="img-fluid img-thumbnail" src="<?php if(!empty($media_src)){ echo $media_src; } else {echo "https://via.placeholder.com/60//fff?text=".ucfirst(substr($result['title'] , 0 , 1 ));} ?>"></a> <?php echo ucfirst($result['title']) ?></td>
                                            <td><?php echo ($result['sku']) ?></td>
                                            <td><?php echo ($result['brand_name']) ?></td>
											<td><a href="<?php echo base_url('account/historical/?product_id='.$result['id']) ?>" ><?php echo ($result['product_rotation']) ?></a></td>
                                            <td><?php echo $model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=>$result['category_id'])); ?></td>
											<?php if (strlen($result['description']) > 10):?>
											<td class="descri"><span class="description"><?php echo substr($result['description'], 0, 7) . '...'; ?></span> <span class="full_description" description="<?php echo $result['description'] ?>"><a href="#">View more</a></span>
                                               </td>
											<?php else:?>
											<td ><?php echo $result['description'] ?></td>
											<?php endif;?>
											<td><input class="check_category_status" value="<?=$result['status'] ?>" type="checkbox" <?php if($result['status']==1){echo 'checked';};?> disabled="disabled" ></label></td>
											<td><?php echo round($result['total_rental_income']); ?></td>
											<td><?php echo round($result['division']); ?></td>
											<td><?php if(($result['warehouse_arrival_date']!=0) && !empty($result['warehouse_arrival_date'])){echo date('d-m-Y',$result['warehouse_arrival_date']); } else { echo "Not Vailaible"; }?></td>
                                            <td>
                                                <a href="<?php echo base_url('account/'.$mr.'/view/'.$result['id']) ?>" ><label class="badge badge-success"><i class="mdi mdi-eye"></i> View</label></a>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?=$this->endSection()?>