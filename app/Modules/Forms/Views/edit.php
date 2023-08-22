<?=$this->extend("admin/layout/master")?>

<?=$this->section("content")?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card manage-form-add">
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
                    <?php echo form_open('',array('class'=>'forms-sample'),array('s'=>'ok')); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Category<span style="color:red;">*</span></label>
                                   <select class="form-control" name="category_id" id="category_id" >
										<option selected="true" value="">Please select</option>
										  <?=$categories?>
									</select>
									<?php if(!empty($errors['category_id'])): ?>
									 <p class="error"><?= $errors['category_id']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount">Sub Category<span style="color:red;">*</span></label>
                                   	<select class="form-control" name="sub_categories" id="sub_categories" >
										<option>Please select</option>
										<?=$sub_categories?>
									</select>
									<?php if(!empty($errors['sub_categories'])): ?>
									 <p class="error"><?= $errors['sub_categories']?></p>
									<?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="form_title">Form Title<span style="color:red;">*</span></label>
                                    <input type="text" name="form_title" value="<?=$data['form_title'] ?>" class="form-control" id="form_title" />
									<?php if(!empty($errors['form_title'])): ?>
									 <p class="error"><?= $errors['form_title']?></p>
									<?php endif;?>
                                </div>
                            </div>
							<?php 		    

		        $form_id = $data['id'];
	    		if(isset($data) && !empty($data)){
				$form_data = unserialize($data['data']);
				$x = 1;
				foreach($form_data as $newData){
					
					//for checked 
					$checked = '';
					if(isset($newData['show_in_front']) && $newData['show_in_front'] == '1'):
					$checked = 'checked';
					endif;
					
					$title = '';
					if(isset($newData['title']) && !empty($newData['title'])):
					$title = $newData['title'];
					endif;
					$sub_title = '';
					if(isset($newData['sub_title']) && !empty($newData['sub_title'])):
					$sub_title = $newData['sub_title'];
					endif;
		          
							 ?>
								<div class="section">
								<div class="section-midd">
									<div class="col-md-12">
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group section-heading">
													<h4 class="card-title">Section-<?=$x?></h4>
												</div>
											</div>
											<div class="col-lg-6 text-right">
												<div class="form-group">
													<input type="checkbox" id="show_in_front" name="section[<?=$x?>][show_in_front]" <?=$checked?> value="1">
													<h5 class="card-title">Show in Front</h5>
												</div>
											</div>
										</div>
									    <div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="title"> Title</label>
													<input type="text" name="section[<?=$x?>][title]" value="<?=$title?>" class="form-control" id="title" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="sub_title">Sub Title</label>
													<input type="text" name="section[<?=$x?>][sub_title]" value="<?=$sub_title ?>" class="form-control" id="sub_title" />
												</div>
											</div>
										</div>
									</div>
									 <div class="field_section">
									 <div class="col-md-12">
									  <div class="row main_sec">
									  <?php 
									  $field_count = 0;
									  if(isset($newData['fields']) && !empty($newData['fields'])):
									      foreach($newData['fields'] as $fields):
										    $field_count++; ?>
                                     <div class="row main_field_section">
									   <div class="col-md-6">
										<div class="form-group">
											<h6 class="card-title field_count">Field - <?=$field_count?></h6>
										</div>
									   </div>
									   <div class="col-md-6 text-right">
										<span class="btn btn-danger mr-2 remove_button" field_section="<?=$x?>" field_count="<?=$field_count?>" >-Remove</span>
									   </div> 
										<div class="col-md-4">
											<div class="form-group">
												<label for="label">Question</label>
												<input type="text" name="section[<?=$x?>][fields][<?=$field_count?>][label]" placeholder="Ex: When do you want to start?" value="<?=$fields['label'] ?>" class="form-control label" id="label" />
												<input type="hidden" name="section[<?=$x?>][fields][<?=$field_count?>][name]" value="<?=$fields['name'] ?>" class="form-control name" id="name" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="sub_title">Type</label>
												<select class="form-control form-control-sm" name="section[<?=$x?>][fields][<?=$field_count?>][type]" id="type">
												   <option value="">--Select Type--</option>
												  <option value="1" <?php if($fields['type'] == '1'): echo 'selected'; endif;?>>Text</option>
												  <option value="2"<?php  if($fields['type'] == '2'): echo 'selected'; endif;?>>Checkbox</option>
												  <option value="3" <?php if($fields['type'] == '3'): echo 'selected'; endif;?>>Email</option>
												  <option value="4" <?php if($fields['type'] == '4'): echo 'selected'; endif;?>>File</option>
												  <option value="5" <?php if($fields['type'] == '5'): echo 'selected'; endif;?>>Number</option>
												  <option value="6" <?php if($fields['type'] == '6'): echo 'selected'; endif;?>>Radio</option>
												  <option value="7" <?php if($fields['type'] == '7'): echo 'selected'; endif;?>>Select</option>
												  <option value="8" <?php if($fields['type'] == '8'): echo 'selected'; endif;?>>Textarea</option>
												  <option value="9" <?php if($fields['type'] == '9'): echo 'selected'; endif;?>>Postcode</option>
												  <option value="10" <?php if($fields['type'] == '10'): echo 'selected'; endif;?>>Firstname</option>
												  <option value="11" <?php if($fields['type'] == '11'): echo 'selected'; endif;?>>Lastname</option>
												  <option value="12" <?php if($fields['type'] == '12'): echo 'selected'; endif;?>>Mobile Number</option>
												  <option value="13" <?php if($fields['type'] == '13'): echo 'selected'; endif;?>>Other</option>
												</select>
								
											</div>
										</div>
										 <div class="col-md-3">
											<div class="form-group">
												<label for="field_value"> Value</label>
												<input type="text" name="section[<?=$x?>][fields][<?=$field_count?>][field_value]" Placeholder="Ex: Today,Tomorrow,Day After" value="<?=$fields['field_value'] ?>" class="form-control " id="field_value" />
											</div>
										</div>
										<div class="col-md-2 field_wrapper">
											<div class="form-group">
												<label for="sub_title">Is Required</label>
												<select class="form-control form-control-sm" name="section[<?=$x?>][fields][<?=$field_count?>][is_required]"  id="is_required">
												   <option value="">--Select--</option>
												   <option value="1" <?php if($fields['is_required'] == '1'): echo 'selected'; endif;?>>Yes</option>
												   <option value="0" <?php if($fields['is_required'] == '0'): echo 'selected'; endif;?>>No</option>
												</select>
											</div>
										 </div>
									</div>
							   <?php endforeach;
							      endif; 
							   ?>
										</div>
									  </div>
									</div>
									<div class="col-md-12 text-right">
										<span type="text" class="btn btn-success mr-2 add_button" field_section="<?=$x?>" field_count="<?=$field_count?>" >+Add More</span>
									</div> 
									</div> 
								 </div> 
								 
						<?php   $x++;  
					} 
				}				
				
				?>
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            </div>    
                        </div>    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row d-none" id="section_field_get">
 <div class="row main_field_section">
	   <div class="col-md-6">
		<div class="form-group">
			<h6 class="card-title field_count">New Field</h6>
		</div>
	   </div>
	   <div class="col-md-6 text-right">
		<span class="btn btn-danger mr-2 remove_button" field_section="" field_count="" >-Remove</span>
	   </div> 
    <div class="col-md-4" >
     <div class="form-group">
            <label for="label"> Question</label>
            <input type="text" name="label" value=""  placeholder="Ex: When do you want to start?" class="form-control label" id="label" />
			<input type="hidden" name="name" value="" class="form-control name" id="name" />
      </div>
    </div>
	<div class="col-md-3">
        <div class="form-group">
            <label for="sub_title">Type</label>
			<select class="form-control form-control-sm type" name="type" id="type">
			  <option value="">--Select--</option>
			  <option value="1">Text</option>
			  <option value="2">Checkbox</option>
			  <option value="3">Email</option>
			  <option value="4">File</option>
			  <option value="5">Number</option>
			  <option value="6">Radio</option>
			  <option value="7">Select</option>
			  <option value="8">Textarea</option>
			</select>
        </div>
    </div>
	 <div class="col-md-3">
        <div class="form-group">
            <label for="field_value"> Value</label>
            <input type="text" name="field_value" value="" class="form-control field_value" Placeholder="Ex: Today,Tomorrow,Day After" id="field_value" />
        </div>
    </div>
	<div class="col-md-2">
        <div class="form-group">
            <label for="sub_title">Is Required</label>
			<select class="form-control form-control-sm is_required" name="is_required" id="is_required">
			   <option value="">--Select--</option>
			   <option value="1">Yes</option>
			   <option value="0" selected>No</option>
			</select>
        </div>
      </div>
    </div>
  </div>
<!-- content-wrapper ends -->
<?= $this->endSection() ?>

<?= $this->section("script") ?>

<style>

.field_section {
    width: 100%;
}
.section {
    width: 100%;
}
.text-right {
    margin: 0 0 10px 0;
}
</style>


<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<script>
$(document).on('input','.label',function() {
	let value = $(this).val();
    var replaced = value.split(' ').join('_');
	$(this).next().val(replaced.toLowerCase());
});
$(document).ready(function(){
	
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_section'); //Input field wrapper
  
    
    //Once add button is clicked
    $(addButton).click(function(){
		let field_section = $(this).attr('field_section');
		let field_count = $(this).attr('field_count');
		let count = field_count+1;
		$("#section_field_get .label").attr('name','section['+field_section+'][fields]['+count+'][label]');
		$("#section_field_get .type").attr('name','section['+field_section+'][fields]['+count+'][type]');
		$("#section_field_get .field_value").attr('name','section['+field_section+'][fields]['+count+'][field_value]');
		$("#section_field_get .is_required").attr('name','section['+field_section+'][fields]['+count+'][is_required]');
		$("#section_field_get .name").attr('name','section['+field_section+'][fields]['+count+'][name]');
		var html = $("#section_field_get").html(); //New input field html 
		$(this).parents(".section").find('.field_section .main_sec').append(html);
		count++;
        //Check maximum number of input fields
    });
    
    //Once remove button is clicked
    $(document).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parents('.main_field_section').remove(); //Remove field html
    });
});
/* On select of category_id */
$(document).on("change","#category_id",function(){
	var parent_id = $(this).val();
	if(parent_id!="")
    {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('admin/'.$mr.'/get-subcategories')?>",
			data: "parent_id="+parent_id,
			dataType: "json",
			success: function(result){
				if(result.status=="success")
				{
					$('#sub_categories').html(result.html);
				}
				else
				{
					$('#sub_categories').html(result.html);
				}
			}
		});
	}
	else{
		$('#sub_categories').html('<option value="">Please select</option>');
	}
	
});

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