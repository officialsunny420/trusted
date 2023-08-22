<?php

namespace Modules\Settings\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
   
    public $common_model = '';
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage Settings";
		$this->fp = '\Modules\Settings\Views';
        $this->default_table = SETTINGS_TABLE;
        $this->mr = "settings"; // Module route
        

    }
    public function index()
    {
        $page_data = [];
		$slider_img_src = [];
		$tbl_data_value = $this->common_model->GetSingleValue($this->default_table,'value',array('type'=>'slider_images'));
        
		//if data existing
		if(!empty($tbl_data_value)):
			$media_ids = unserialize($tbl_data_value);
			if(count($media_ids)):
				foreach($media_ids as $i=>$id): 
				$slider_img_name = $this->common_model->GetSingleValue(MEDIA_TABLE,('name'),array('id'=>$id));
				if(file_exists(FCPATH."uploads/".$slider_img_name)):
						$slider_img_src[$i]['id'] = $id;
						$slider_img_src[$i]['src'] = base_url('/uploads/'.$slider_img_name.'');
					endif;
				endforeach;
			endif;
		endif;
		
		if(count($slider_img_src)):
		$page_data['slider_img_src'] = $slider_img_src;
		endif;
		
		if($this->request->getVar('s')):
			if(!empty($this->request->getVar('attachment_ids'))):
				
				$slider_images = $this->request->getVar('attachment_ids');
				
				//if data existing from previously
				if(!empty($tbl_data_value)):
				$existing_images = unserialize($tbl_data_value);
				$slider_images = array_merge($existing_images,$slider_images);
				endif;
				
				$data = array(
								'type' => 'slider_images',
								'value' => serialize($slider_images),
							);
							
				if(!empty($tbl_data_value)):
				$insert_id = $this->common_model->UpdateTableData($this->default_table,$data,array('type'=>'slider_images'));
				else:
				$insert_id = $this->common_model->InsertTableData($this->default_table,$data);
				endif;
				
				if($insert_id)
					{
						$this->session->setFlashdata('flash_message','Data successfully added.');
						$this->session->setFlashdata('class','success');
						return redirect()->to('admin/'.$this->mr);
					}
				else
					{
						$this->session->setFlashdata('flash_message','Something is went wrong please try again.');
						$this->session->setFlashdata('class','danger');
					}
			endif;	
		endif;	
		
        $page_data['module'] = $this->module;
        $page_data['modal'] = $this->common_model; 

        return view($this->fp."\index", $page_data);
    }
	
	
	
	//delete slider image 
	public function deleteSliderImage()
	{
		if($this->request->isAJAX()):
			if(!empty($this->request->getPost('id'))):
			
			    $del_val = $this->request->getPost('id');
			    $table_data = $this->common_model->GetSingleValue($this->default_table,'value',array('type'=>'slider_images'));
				if(!empty($table_data)):
					$image_data = unserialize($table_data);
					
					if(($key = array_search($del_val, $image_data)) !== false):
						unset($image_data[$key]);
					endif;
					
					$row = $this->common_model->GetSingleRow(MEDIA_TABLE,array('id' => $del_val));
					$filename = $row['name'];
					
					$upload_dir = dirname(APPPATH)."/uploads";
					
					$file_to_delete = $upload_dir.'/'.$filename;

					$delete = $this->common_model->DeleteTableData(MEDIA_TABLE,array('id' => $del_val));
					if($delete):
						//unlink files
						unlink($file_to_delete);
					endif;
					
					$data = array(
								'value' => serialize($image_data),
							);
					$update= $this->common_model->UpdateTableData($this->default_table,$data,array('type'=>'slider_images'));
					
					if($update):
						$json_data['status'] = "success";
					else:
						$json_data['status'] = "error";
					endif;
					
				else:
					$json_data['status'] = "error";
				endif;
				
			else:
				$json_data['status'] = "error";
			endif;
			
		else:
				$json_data['status'] = "error";
		endif;
		
		echo json_encode($json_data); 
		die();
	}

    
}
