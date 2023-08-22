<?=$this->extend("user/layout/master")?>

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
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<h4 class="card-title"><?=$module?></h4>
							</div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?php echo base_url('account/'.$mr) ?>">
									<button type="button" class="btn btn-primary btn-icon-text btn-sm">
										<i class="mdi mdi-arrow-left">Back</i>                                                    
									</button>
								</a>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Select Category</label>
                                    <select class="form-control" name="category_id" id="exampleSelectGender" disabled="disabled">
                                        <option value="">--Select--</option>
                                        <?php echo $categories; ?>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand_name">Brand Name</label>
                                    <input type="text" name="brand_name" value="<?= $brand_name ?>" class="form-control" id="brand_name" readonly />
									
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Stock Name</label>
                                    <input type="text" name="title" value="<?= $title ?>" class="form-control" id="title" readonly />
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="form-group">
                                    <label for="retail_value">Retail Value</label>
                                    <input type="text" name="retail_value" value="<?= $retail_value ?>" class="form-control" id="retail_value" readonly />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sku">SKU</label>
                                    <input type="text" name="sku" value="<?= $sku ?>" class="form-control" id="sku" readonly />
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectColor">Color</label>
                                    <select class="form-control" name="color" id="exampleSelectColor" disabled="disabled">
                                        <option value="">--Select--</option>
                                            <option value="red" <?php if($color == "red"){ echo 'selected'; }?>>Red</option>
                                            <option value="green" <?php if($color == "green"){ echo 'selected'; }?>>Green</option>
                                            <option value="blue" <?php if($color == "blue"){ echo 'selected'; }?>>Blue</option>
                                            <option value="yellow" <?php if($color == "yellow"){ echo 'selected'; }?>>Yellow</option>
                                            <option value="black" <?php if($color == "black"){ echo 'selected'; }?>>Black</option>
                                            <option value="orange" <?php if($color == "orange"){ echo 'selected'; }?>>Orange</option>
                                            <option value="grey" <?php if($color == "grey"){ echo 'selected'; }?>>Grey</option>
                                            <option value="white" <?php if($color == "white"){ echo 'selected'; }?>>White</option>
                                    </select>
									
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectSize">Size</label>
                                    <select class="form-control" name="size" id="exampleSelectSize" disabled="disabled">
                                        <option value="">--Select--</option>
                                            <option value="small" <?php if($size == "small"){ echo 'selected'; }?>>Small</option>
                                            <option value="medium" <?php if($size == "medium"){ echo 'selected'; }?>>Medium</option>
                                            <option value="large"<?php if($size == "large"){ echo 'selected'; }?>>Large</option>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-4">
							  <div class="form-group">
								<label for="warehouse_arrival_date">Warehouse Arrival Date</label>
								<input type="date" class="form-control" name="warehouse_arrival_date"  value="<?php if(($warehouse_arrival_date!=0) && !empty($warehouse_arrival_date)){echo date('Y-m-d',$warehouse_arrival_date);} ?>" id="warehouse_arrival_date" autocomplete="off" readonly />
							  </div>
						   </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleTextarea1">Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" rows="3" name="description" readonly><?= $description ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 user_avatar">
                                <?php if(isset($media_src) && !empty($media_src)):?><div class="form-group">
                                        <label>Uploaded Product Image</label> <br>
                                        <img src="<?=$media_src ?>" class="img-thumbnail "> 
                                    </div>
                                <?php endif;?>
							</div>
                        </div>    
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- content-wrapper ends -->
<?= $this->endSection() ?>
<?= $this->section("script") ?>
<?=$this->endSection()?>