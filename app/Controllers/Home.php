<?php

namespace App\Controllers;
use App\Models\Common;
use Mpdf\Mpdf;

class Home extends BaseController
{
    public function __construct()
    {
        $this->common_modal = new Common();
        $this->db =  \Config\Database::connect();
    }

    public function index()
    {
		
		

		
        $page_data=[];
		  if($this->request->getVar('s'))
		{
			$first_name = strip_tags($this->input->post('first_name'));
			$last_name = strip_tags($this->input->post('last_name'));
			$job_title = strip_tags($this->input->post('job_title'));
			$description = strip_tags($this->input->post('description'));
			$postcode = strip_tags($this->input->post('postcode'));
			$mobile = strip_tags($this->input->post('mobile'));
			$email = $this->input->post('email');
			$category_id = intval($this->input->post('category_id'));
			$sub_categories = intval($this->input->post('sub_categories'));
			$job_date = intval($this->input->post('job_date'));
			$stage = intval($this->input->post('stage'));
			$authorised = intval($this->input->post('authorised'));
			$attachments = self::upload_attachments();
			$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
			$first_name = $this->request->getVar('first_name', FILTER_SANITIZE_STRING);
            $last_name = $this->request->getVar('last_name', FILTER_SANITIZE_STRING);
            $description = $this->request->getVar('description', FILTER_SANITIZE_STRING);
			
			$avtar_file = $this->request->getVar('avtar_file', FILTER_SANITIZE_STRING);
			 
            $rules = [ 
                    'first_name' => ['first_name' => 'first_name', 'rules' => 'required'],
                    'last_name' => ['last_name' => 'last_name', 'rules' => 'required'],
                ];
            if ($this->validate($rules)) 
            {
				$time = time();
				$data = array
					(
						
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email' => $email,
						'job_title' => $job_title,
						'description' => $description,
						'postcode' => $postcode,
						'mobile' => $mobile,
						'category_id' => $category_id,
						'sub_categories' => $sub_categories,
						'job_date' => $job_date,
						'stage' => $stage,
						'authorised' => $authorised,
						'attachments' => $attachments,
						'created_on' => $time,
						'updated_on' => $time,
					);
				$insert_id = $this->common_modal->InsertTableData(LEADS_TABLE,$data);
				if($insert_id)
				{
					echo json_encode(array('status' => 'success','message' => 'Your form submited successfully.','last_id' => $insert_id)); 
					die();
				}
				else
				{
					echo json_encode(array('status' => 'error','message' => 'Something went wrong.')); 
					die();
				}	
				
				//echo json_encode($result);
				die();
			}
		//	echo json_encode(array('status' => 'error','message' => 'Something went wrong.')); 

		}
		
		$page_data['categories'] = $this->common_modal->SelectDropdown(CATEGORIES_TABLE,'title','id','',array('parent_id' => 0,'status' => '1'),'',array('title','asc'));
       // echo view('front/common/header');
        echo view('front/about',$page_data);
        //echo view('front/common/footer');
    }
	 public function privacy()
    {
        $page_data=[];
          echo view('front/privacy',$page_data);
    }
    public function terms_and_conditions()
    {
        $page_data=[];
          echo view('front/terms_and_conditions',$page_data);
    }
	public function about(){
	  
	          $page_data=[];
		  if($this->request->getVar('s'))
		{
			$first_name = strip_tags($this->input->post('first_name'));
			$last_name = strip_tags($this->input->post('last_name'));
			$job_title = strip_tags($this->input->post('job_title'));
			$description = strip_tags($this->input->post('description'));
			$postcode = strip_tags($this->input->post('postcode'));
			$mobile = strip_tags($this->input->post('mobile'));
			$email = $this->input->post('email');
			$category_id = intval($this->input->post('category_id'));
			$sub_categories = intval($this->input->post('sub_categories'));
			$job_date = intval($this->input->post('job_date'));
			$stage = intval($this->input->post('stage'));
			$authorised = intval($this->input->post('authorised'));
			$attachments = self::upload_attachments();
			$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
			$first_name = $this->request->getVar('first_name', FILTER_SANITIZE_STRING);
            $last_name = $this->request->getVar('last_name', FILTER_SANITIZE_STRING);
            $description = $this->request->getVar('description', FILTER_SANITIZE_STRING);
			
			$avtar_file = $this->request->getVar('avtar_file', FILTER_SANITIZE_STRING);
			 
            $rules = [ 
                    'first_name' => ['first_name' => 'first_name', 'rules' => 'required'],
                    'last_name' => ['last_name' => 'last_name', 'rules' => 'required'],
                ];
            if ($this->validate($rules)) 
            {
				$time = time();
				$data = array
					(
						
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email' => $email,
						'job_title' => $job_title,
						'description' => $description,
						'postcode' => $postcode,
						'mobile' => $mobile,
						'category_id' => $category_id,
						'sub_categories' => $sub_categories,
						'job_date' => $job_date,
						'stage' => $stage,
						'authorised' => $authorised,
						'attachments' => $attachments,
						'created_on' => $time,
						'updated_on' => $time,
					);
				$insert_id = $this->common_modal->InsertTableData(LEADS_TABLE,$data);
				if($insert_id)
				{
					echo json_encode(array('status' => 'success','message' => 'Your form submited successfully.','last_id' => $insert_id)); 
					die();
				}
				else
				{
					echo json_encode(array('status' => 'error','message' => 'Something went wrong.')); 
					die();
				}	
				
				//echo json_encode($result);
				die();
			}
		//	echo json_encode(array('status' => 'error','message' => 'Something went wrong.')); 

		}
		$page_data['categories'] = $this->common_modal->SelectDropdown(CATEGORIES_TABLE,'title','id','',array('parent_id' => 0,'status' => '1'),'',array('title','asc'));
		 $all_categories = $this->common_modal->GetTableRows(CATEGORIES_TABLE,array('parent_id'=> 0),array('title','asc'));
	 	$page_data['modal'] = $this->common_modal;
	 	$page_data['all_categories'] = $all_categories;
       // echo view('front/common/header');
        echo view('front/index',$page_data);
        //echo view('front/common/footer');
	}
	
	 public function addContactFormData()
    {
            $page_data=[];
			$name = $this->request->getVar('name',FILTER_SANITIZE_STRING);
            $email = $this->request->getVar('email', FILTER_SANITIZE_STRING);
            $number = $this->request->getVar('number', FILTER_SANITIZE_STRING);
			$time = time();
			$data = array
					(
						'name' => $name,
						'email' => $email,
						'number' => $number,
						'created_on' => $time,
						'updated_on' => $time,
					);
				$insert_id = $this->common_modal->InsertTableData(CONTACT_US_TABLE,$data);
				if($insert_id)
				{
					echo json_encode(array('status' => 'success','message' => 'Your form submited successfully.','last_id' => $insert_id)); 
					die();
				}
				else
				{
					echo json_encode(array('status' => 'error','message' => 'Something went wrong.')); 
					die();
				}	
				
				//echo json_encode($result);
				die();
	
    }
	 public function addFormData()
    {
          $page_data=[];
		  if($this->request->getVar('s')){
			$category_id = $this->request->getVar('category_id',FILTER_VALIDATE_INT);
            $sub_categories = $this->request->getVar('sub_categories', FILTER_VALIDATE_INT);
            $form_id = $this->request->getVar('form_id', FILTER_VALIDATE_INT);
            $description = $this->request->getVar('description', FILTER_VALIDATE_INT);
			$form_data = $this->request->getVar('section');
			$form_title = $this->common_modal->GetSingleValue(FORM_TABLE,'form_title',array('id'=>$form_id));
            $rules = [ 
                    'category_id' => ['category_id' => 'category_id', 'rules' => 'required'],
                    'sub_categories' => ['sub_categories' => 'sub_categories', 'rules' => 'required'],
                ];
            if ($this->validate($rules)) {
				$time = time();
				$data = array
					(
						'category_id' => $category_id,
						'sub_categories' => $sub_categories,
						'form_id' => $form_id,
						'form_title' => $form_title,
						'form_data' => serialize($form_data),
						'created_on' => $time,
						'updated_on' => $time,
					);
				//$insert_id = $this->common_modal->InsertTableData(LEADS_TABLE,$data);
				$insert_id = $this->common_modal->InsertTableData(LEADS_TABLE,$data);
				if($insert_id)
				{
					echo json_encode(array('status' => 'success','message' => 'Your form submited successfully.','last_id' => $insert_id)); 
					die();
				}
				else
				{
					echo json_encode(array('status' => 'error','message' => 'Something went wrong.')); 
					die();
				}	
				
				//echo json_encode($result);
				die();
			}
		//	echo json_encode(array('status' => 'error','message' => 'Something went wrong.')); 

		}
			$page_data['categories'] = $this->common_modal->SelectDropdown(CATEGORIES_TABLE,'title','id','',array('parent_id' => 0,'status' => '1'),'',array('title','asc'));
       // echo view('front/common/header');
        echo view('front/index',$page_data);
        //echo view('front/common/footer');
    }
	/* function to get sub categories on selection of category */
	public function getSubcategories(){
           
		   $parent_id = $this->request->getVar('parent_id');
		   $html = '';
		   $html_prior = '<option value="">Please select</option>';
		   $rows = $this->common_modal->GetTableRows(CATEGORIES_TABLE,array('parent_id'=>$parent_id,'status' => '1'),array('title','asc'));
		   if(isset($rows ) && !empty($rows )):
		      foreach($rows as $row):
			    $total = $this->common_modal->GetTotalCount(FORM_TABLE,array('sub_category_id' => $row['id']));
				if(!$total):
				 continue;
				endif;
				$selected = "";
				$html .= '<option value = "'.$row['id'].'" '.$selected.'  >'.$row['title'].'</option>';
              endforeach;
		    endif;
		  // $html_data = $this->common_modal->SelectDropdown(CATEGORIES_TABLE,'title','id','',array('parent_id'=>$parent_id));
			if( !empty($html))
			{
				  $html =$html_prior.$html;
				  echo json_encode(array('status' => 'success' , 'html' =>  $html)); 
			}
			else
			{
				echo json_encode(array('status' => 'error' , 'html' =>  $html_prior,));
			}
		 die();
	}
	
	
	/* function to upload multiple images */
	public function fileUpload(){
		$error=array();
        $extension=array("jpeg","jpg","png","gif");
		$ids = [];
		foreach($_FILES as $file) {
			$file_name=$file["name"];
			$name=time().$file["name"];
			$file_tmp=$file["tmp_name"];
			$ext=pathinfo($file_name,PATHINFO_EXTENSION);
			if(move_uploaded_file($file_tmp=$file["tmp_name"],"uploads/".$name)){
				$data = array
					(
						'name' => $name,
						'original_name' => $file_name,
						'used' => 1,
					);
				$insert_id = $this->common_modal->InsertTableData(MEDIA_TABLE,$data);
				$ids[] = $insert_id;
			}
		}
	        $media_id = implode(',',$ids);
		    $media_id = $media_id;
			if( !empty($media_id))
			{
				  echo json_encode(array('status' => 'success' , 'media_id' =>  $media_id)); 
			}
			else
			{
				echo json_encode(array('status' => 'error' , 'media_id' =>  $media_id,));
			}
		 die();
	}
	/* function to get  getFormData on change subcategory */
	public function getFormData(){
		    $sub_category_id = $this->request->getVar('sub_category_id');
		    $html = '';
		    $data = $this->common_modal->GetSingleRow(FORM_TABLE,array('sub_category_id'=> $sub_category_id));
			$form_id = $data['id'];
			if(isset($data) && !empty($data)){
				$form_data = unserialize($data['data']);
				$count = 1;
				foreach($form_data as $newData){
                    $field_data = '';
					if(!isset($newData['show_in_front']) || $newData['show_in_front']== '0'){
						continue;
					}
					
						//for get input field
						if(isset($newData['fields'])){
							$field_count = 1;
							foreach($newData['fields'] as $field){
								
								$class_required = '';
								$attr_multiple = '';
								if($field['is_required'] == '1'){
									$class_required = 'required_star';
								}
						     $field_type_text = field_types($field['type']);
							 if($field['type'] == '4'){
									$attr_multiple = 'multiple';
									 $field_data .= '<div class="col-lg-6 col-md-6">
														 <div class="form-group">
														<label class="'.$class_required.'" for="fname">'.$field['label'].'</label><br>
														<input type="'.$field_type_text.'" class="form-control" is_required="'.$field['is_required'].'"  name="section['.$count.'][fields]['.$field_count.']['.$field['name'].'][]" value="" multiple >
														<input type="hidden" class="form-control file_ids"   name="section['.$count.'][fields]['.$field_count.'][file_ids]" value="" >
												 <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >
												  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >
												   <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >
												    <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][type]" value="'.$field['type'].'" >
													   </div>
													 </div>';
								}
							    $i = 0;
						       //for text 
						 	    if($field['type'] == '1' || $field['type'] == '3'  || $field['type'] == '5' || $field['type'] == '9' || $field['type'] == '10' || $field['type'] == '11' || $field['type'] == '12'):
								     $post_code = "";
								     $phone_number = "";
								     $name_valid = "";
								     $readonly = "";
                                     if($field['type'] == '12'):
									   $phone_number = "phone_number";
									    $field_type_text = "number";
									 endif; 
									 if($field['type'] == '10'):
									   $name_valid = "first_name";
									  // $name_valid_id = $name_valid."_".$field_count;
									   $field_type_text = "text";
									 endif; 
									  if($field['type'] == '11'):
									   $name_valid = "last_name";
									   //$name_valid_id = $name_valid."_".$field_count;
									   $field_type_text = "text";
									 endif; 
								     if($field['type'] == '9'):
									    $post_code = "postcode";
									    $readonly = "readonly";
									    $field_type_text = "text";
									    $field_data .= '<div class="col-lg-12 address_lookup"><label class="'.$class_required.' " for="fname">'.$field['label'].'</label><br><div id="postcode_lookup"></div></div>';
									 endif; 
									 if($field['type'] != '9'):
									 $field_data .= '<div class="col-lg-6 col-md-6">
														 <div class="form-group">
														<label class="'.$class_required.' " for="fname">'.$field['label'].'</label><br>
														<input type="'.$field_type_text.'" class="form-control '.$phone_number.' '.$name_valid.' " is_required="'.$field['is_required'].'"  name="section['.$count.'][fields]['.$field_count.'][name]" value="" id="'.$post_code.'" '.$readonly.'>
													  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >
													    <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][type]" value="'.$field['type'].'" >
													   </div>
													 </div>';
									else:
									   $field_data .= '<div class="col-lg-6 col-md-6">
														 <div class="form-group">
														<input type="'.$field_type_text.'" class="form-control '.$phone_number.' '.$name_valid.' " is_required="'.$field['is_required'].'"  name="section['.$count.'][fields]['.$field_count.'][name]" value="" id="'.$post_code.'" '.$readonly.' placeholder="PostCode">
													  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >
													    <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][type]" value="'.$field['type'].'" >
													   </div>
													 </div>';
									endif;
								//for select
								elseif($field['type'] == '7'):
								      $value = $field['field_value'];
									  $values = explode(',',$value);
									  $option = '';
									  foreach($values as $value){
										  if(empty($value)){
												   continue;
										  }
										  $option .= '<option value="'.$value.'" extra_field="">'.$value.'</option>';
									  }
									  if(empty($option)){
										 continue;
									  }
									  $field_data .=  '<div class="col-lg-12 col-md-12">
														  <div class="form-group">
														  <label class="'.$class_required.'" for="fname">'.$field['label'].'</label><br>
														   <select class="form-control valid" is_required="'.$field['is_required'].'" name="section['.$count.'][fields]['.$field_count.'][name]"  aria-invalid="false">
																<option value="">Please select</option>
																'.$option.'
															</select>
															  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >
															    <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][type]" value="'.$field['type'].'" >
													     </div>
													    </div>';
							   //for text area					
							   elseif($field['type'] == '8'):
							          $is_required = '';
							          if($field['is_required'] == '1'):
									    $is_required = 'required';
									  endif;
									 $field_data .= '<div class="col-lg-6 col-md-6">
														 <div class="form-group">
														<label class="'.$class_required.'" for="fname">'.$field['label'].'</label><br>
														<textarea id="w3review" class="form-control w3textarea" is_required="'.$field['is_required'].'"  name="section['.$count.'][fields]['.$field_count.'][name]" rows="4" cols="50" '.$is_required.' ></textarea>
														  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >
														    <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][type]" value="'.$field['type'].'" >
													   </div>
													 </div>';
								//for radio
								elseif($field['type'] == '6'):
									          $value = $field['field_value'];
											  $values = explode(',',$value);
											  $field_data .= '<div class="col-lg-12 col-md-12 main_label"> <label class="'.$class_required.'" for="fname">'.$field['label'].'</label></div>  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][type]" value="'.$field['type'].'" >';
											  foreach($values as $value){
											  if(empty($value)){
												   continue;
											   }
											  $checked = '';
											  if($i == 0){
												  //$checked = 'checked=checked';
											  }
											  $field_data .=  '<div class="col-lg-6 col-md-6">
																 <div class="form-group">
																   <div class="radio-fields">
																	<input type="radio" name="section['.$count.'][fields]['.$field_count.'][name]"   value="'.$value.'"   is_required="'.$field['is_required'].'">
																	<div class="custom-radio">
																		<span>'.$value.'</span>
																	</div>
																	 </div>
																 </div>
																</div>';
											  $i++;
											 }
											 $field_data .=  '<div class="col-lg-12 col-md-12 main_label_parent">
																</div>';
								elseif($field['type'] == '2'):
								              $value = $field['field_value'];
											  $values = explode(',',$value);
											  $field_data .= '<div class="col-lg-12 col-md-12 main_label"> <label class="'.$class_required.'" for="fname">'.$field['label'].'</label></div>  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][label]" value="'.$field['label'].'" >  <input type="hidden" class="form-control label"   name="section['.$count.'][fields]['.$field_count.'][type]" value="'.$field['type'].'" >';
											  $i = 0;
											  foreach($values as $value){
											   if(empty($value)){
												   continue;
											   }
											  $checked = '';
											  if($i == 0){
												//$checked = 'checked=checked';
											  }
											  $field_data .= '<div class="col-lg-6 col-md-6">
																 <div class="form-group multi-checklist">
																  <input type="checkbox" name="section['.$count.'][fields]['.$field_count.'][name]"   value="'.$value.'" is_required="'.$field['is_required'].'" '.$checked.'>
                                                                    <label for="vehicle3"> '.$value.'</label><br>
																 </div>
															  </div>';
											  $i++;
											 }
											 $field_data .=  '<div class="col-lg-12 col-md-12 main_label_parent">
																</div>';
								endif; 
								
								

								$field_count++;
							}
						
						}
						$title = strtolower(clean($newData['title'],""));
						if($title ==   "contactdetails"):
						  $newData['sub_title'] = "To ensure that we can offer you three complimentary quotes from reliable local tradespeople, kindly ensure that all of your information is correct. Otherwise, they may be unable to get in touch with you. We appreciate your inquiry!";
						endif;
						$html .= '<section class="page remove_section contact-main-section" style="width: 100%; height: 100%; position: relative; display: none;">
									<h6>'.$newData['title'].'</h6>
									<label class="contact-sub-title" for="fname">'.$newData['sub_title'].'</label>
									<label class="contact-sub-title" for="fname">'.$title.'</label>
									<div class="row">
									  '.$field_data.'
									</div>
									<div class="buttons">
										<button type="button" class="page-prev btn btn-danger">Prev</button>
										<button type="button" class="page-next btn btn-primary">Next</button>
									</div>
									<input type="hidden" class="form-control section_title"   name="section['.$count.'][title]" value="'.$newData['title'].'" >
									<input type="hidden" class="form-control section_sub_title"   name="section['.$count.'][sub_title]" value="'.$newData['sub_title'].'" >
								</section>';
					$count++;
					//
					//echo $newData['title'];
				}
				  echo json_encode(array('status' => 'success' , 'html' =>  $html,'form_id' => $form_id)); 
			}
			else
			{
				echo json_encode(array('status' => 'error' , 'html' =>  $html));
			} 
		// die();
	}
	
	
		public function success()
	{
		$last_id = $this->request->getVar('last_id');;
		$data = $this->common_modal->GetSingleRow(LEADS_TABLE,array('id' => $last_id));
		if(!$data)
		{
			return redirect()->to('/');
			die();
		} 
		 echo view('front/thank_you',$data);
		//$this->load->view('front/thank_you', $data);
	}
}
