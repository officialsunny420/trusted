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
									<label for="product_id">Stock</label>
									<select class="form-control form-control-sm" name="product_id" id="product_id">
									  <option value="" >--Select Stock--</option>
									  <?php echo $existing_products;?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
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
                                    <th>S No.</th>
                                    <th>Stock</th>
                                    <th>Rental Income</th>
                                    <th>Rented On</th>
									<th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results): ?>
                                    <?php foreach($results as $key=>$result): 
									   $product_name = $modal->GetSingleValue(PRODUCTS_TABLE,'title',array('id'=>$result['product_id']));
									   
									?>
                                        <tr>
                                            <td><?=$key+1 ?></td>
                                            <td><?php if(!empty($product_name)){ echo $product_name;}?></td>
                                            <td><?=$result['rental_income_for_partner'] ?></td>
                                            <td><?php echo date('d-M-Y',$result['rented_on']); ?></td>
                                            <td><?php echo date('d-M-Y',$result['expiry_date']); ?></td>
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
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<?=$this->endSection()?>
