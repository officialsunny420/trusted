<?php

namespace Modules\Users\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
   
    public $common_model = '';
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage Partners";
		$this->fp = '\Modules\Users\Views';
        $this->default_table = USERS_TABLE;
        $this->mr = "users"; // Module route
        

    }
    public function index()
    {
        $page_data = [];
        $where = array();
		$where = $this->filter_query($where);
		$where = implode(' AND ', $where);

        $per_page = PER_PAGE_LIMIT;
        $offset = (int)$this->request->getVar('page') ? ($this->request->getVar('page')-1)*$per_page : 0;
        $total = $this->common_model->GetTotalCount($this->default_table,$where);
        $data = $this->common_model->GetTableRows($this->default_table,$where,'',$per_page,$offset);

        $pagination = false;
        if($per_page < $total):
          $pager = \Config\Services::pager();
          $pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 
        endif;  
        
        $page_data['results'] = $data;
        $page_data['module'] = $this->module;
        $page_data['modal'] = $this->common_model;
        $page_data['pagination'] = $pagination;
        $page_data['mr'] = $this->mr;
        return view($this->fp."\index", $page_data);
    }

    public function filter_query($where = [],$table="")
	{
        if(!empty($table)){
			$table = $table;
			$name = "title";
		}
		else{
		   $table = $this->default_table;
		   $name = "name";
		}
        if(count($_GET)){
            $db = db_connect();
            $fields = $db->getFieldNames($table);
            foreach($_GET as $key => $value)
            {
                if(!in_array($key,$fields)){ continue; }
                 $value = strip_tags($value);
                if($key <> "from" && $key <> "to")
                {
                    if($key == $name)
                    {
                        $value = trim($value);
                        if($value <> ""){
                            $value = $db->escapeLikeString($value);
                            $where[] = "  $key LIKE '%$value%'   ";
                        }
                    }
                    else
                    {
                        if($value <> "")
                        {
                            $value = $db->escape($value);
                            $where[] = "  $key = $value   ";
                        }
                    }
                }
            }
			
        }
		return $where; 
	}

    public function add()
    {
		$page_data = [];
		$country_id = $this->request->getVar('country_id', FILTER_VALIDATE_INT);
		//on submitting 
		if($this->request->getVar('s')):
			$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$phone = $this->request->getPost('phone',FILTER_VALIDATE_INT);
			$media_id = $this->request->getPost('avtar_file',FILTER_VALIDATE_INT);
			$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
			$company_name = $this->request->getPost('company_name',FILTER_SANITIZE_STRING);
			$company_address = $this->request->getPost('company_address',FILTER_SANITIZE_STRING);
			$iban = $this->request->getPost('iban',FILTER_SANITIZE_STRING);
			$vat = $this->request->getPost('vat',FILTER_SANITIZE_STRING);
			$chamber_of_commerce = $this->request->getPost('chamber_of_commerce',FILTER_SANITIZE_STRING);
			$rules = [ 
					'country_id' => ['label' => 'Country', 'rules' => 'trim|required|numeric'],
					'name' => ['label' => 'Name', 'rules' => 'trim|required'],
					'company_name' => ['label' => 'Company name', 'rules' => 'trim|required'],
					'company_address' => ['label' => 'Company address', 'rules' => 'trim|required'],
					'vat' => ['label' => 'VAT', 'rules' => 'trim|required'],
					'chamber_of_commerce' => ['label' => 'Chamber of commerce', 'rules' => 'trim|required'],
					'iban' => ['label' => 'IBAN', 'rules' => 'trim|required'],
					'email' => ['label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique['.USERS_TABLE.'.email]'],
					'phone' => ['label' => 'Phone', 'rules' => 'trim|required|numeric'],
					'avtar_file' => ['label' => 'Profile Picture', 'rules' => 'trim|required|numeric'],
                ];
			
			if($this->validate($rules)):
				$data = [
							'country_id' => $country_id,
							'name' => $name,
							'email' => $email,
							'password' => md5('123456'),
							'phone' => $phone,
							'description' => $description,
							'status' => 1,
							'media_id' => $media_id,
							'company_address' => $company_address,
							'company_name' => $company_name,
							'iban' => $iban,
							'vat' => $vat,
							'chamber_of_commerce' => $chamber_of_commerce,
							'updated_at' => date("Y-m-d H:i:s")
						];
				$insert_id = $this->common_model->InsertTableData($this->default_table,$data);
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
			else:
                $page_data["errors"] = $this->validator->getErrors();
			endif;
		
		endif;
		
		$page_data['countries'] = $this->common_model->SelectDropdown(COUNTRIES_TABLE,'name','id',array($country_id));
		$page_data['module'] = $this->module.' : Add';
		$page_data['mr'] = $this->mr;
		return view($this->fp.'/add',$page_data);
    }

    public function document($user_id)
    {	
	    $exist_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$user_id));
		if(empty($exist_data)){
			  $this->session->setFlashdata('flash_message','No data exist related.');
			  $this->session->setFlashdata('class','danger');
			  return redirect()->to('admin/'.$this->mr);
			  die();
		}
	    $page_data = [];
		$table = DOCUMENTS_TABLE;
	    $where[] = 'user_id = '.$user_id;
		$where = $this->filter_query($where,$table);
		$where = implode(' AND ', $where);
        $per_page = 10;
        $offset = (int)$this->request->getVar('page') ? ($this->request->getVar('page')-1)*$per_page : 0;
        $total = $this->common_model->GetTotalCount(DOCUMENTS_TABLE,$where);
        $data = $this->common_model->GetTableRows(DOCUMENTS_TABLE,$where,'',$per_page,$offset);
        $data = $this->common_model->GetTableRows(DOCUMENTS_TABLE,$where,'',$per_page,$offset);
        $pagination = false;
        if($per_page < $total):
          $pager = \Config\Services::pager();
          $pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 
        endif;  
			//on submitting 
			if($this->request->getVar('s')):
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);
				$type = $this->request->getPost('type',FILTER_VALIDATE_INT);
				$media_id = $this->request->getPost('avtar_file',FILTER_VALIDATE_INT);

				$rules = [ 
						'title' => ['label' => 'Title', 'rules' => 'trim|required'],
						'type' => ['label' => 'Type', 'rules' => 'trim|required|numeric'],
						'avtar_file' => ['label' => 'Document', 'rules' => 'trim|required|numeric'],
					];
				
				if($this->validate($rules)):
					$data = [
								'user_id' => $user_id,
								'title' => $title,
								'type' => $type,
								'media_id' => $media_id,
								'created_at' => date("Y-m-d H:i:s"),
								'updated_at' => date("Y-m-d H:i:s")
							];
					$insert_id = $this->common_model->InsertTableData(DOCUMENTS_TABLE,$data);
					if($insert_id)
					{
					    $this->session->setFlashdata('flash_message','Document successfully added.');
						$this->session->setFlashdata('class','success');
						return redirect()->to('admin/users/document/'.$user_id);
					}
					else
					{
						$this->session->setFlashdata('flash_message','Something is went wrong please try again.');
						$this->session->setFlashdata('class','danger');
					}
				else:
					$page_data["errors"] = $this->validator->getErrors();
				endif;
			endif;
			  $page_data['results'] = $data;
			  $page_data['user_name'] = $exist_data['name'];
			  $page_data['user_id'] = $user_id;
			  $page_data['modal'] = $this->common_model;
			  $page_data['pagination'] = $pagination;
			  $page_data['mr'] = $this->mr;
			  $page_data['module'] = $this->module.' : Edit';
		      return view($this->fp.'/document',$page_data);
    }
	
	
	//document update
	public function edit($id)
    {	
		$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
		
		
		if(!empty($page_data)):
			$country = $page_data['country_id'];
			//get profile picture
			if(!empty($page_data['media_id'])):
			$file_name = $this->common_model->GetSingleValue(MEDIA_TABLE,('name'),array('id'=>$page_data['media_id']));
				//profile
				if(!empty($file_name)):
					if(file_exists(FCPATH."uploads/".$file_name)):
						$profile_pic_src = base_url('/uploads/'.$file_name.'');
						$page_data['profile_pic_src'] = $profile_pic_src;
					endif; 
				endif;
			endif;
			
			//on submitting 
			if($this->request->getVar('s')):
				$country = $this->request->getVar('country_id', FILTER_VALIDATE_INT);
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$phone = $this->request->getPost('phone',FILTER_VALIDATE_INT);
				$media_id = $this->request->getPost('avtar_file',FILTER_VALIDATE_INT);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$company_name = $this->request->getPost('company_name',FILTER_SANITIZE_STRING);
			    $company_address = $this->request->getPost('company_address',FILTER_SANITIZE_STRING);
			    $iban = $this->request->getPost('iban',FILTER_SANITIZE_STRING);
				$vat = $this->request->getPost('vat',FILTER_SANITIZE_STRING);
			    $chamber_of_commerce = $this->request->getPost('chamber_of_commerce',FILTER_SANITIZE_STRING);
				if($email != $page_data['email']) {
				   $is_unique =  '|is_unique['.USERS_TABLE.'.email]';
				} else {
				   $is_unique =  '';
				}

				$rules = [ 
						'country_id' => ['label' => 'Country', 'rules' => 'trim|required|numeric'],
						'name' => ['label' => 'Name', 'rules' => 'trim|required'],
						'email' => ['label' => 'Email', 'rules' => 'trim|required|valid_email'.$is_unique],
						'phone' => ['label' => 'Phone', 'rules' => 'trim|required|numeric'],
						'avtar_file' => ['label' => 'Profile Picture', 'rules' => 'trim|required|numeric'],
						'company_name' => ['label' => 'Company name', 'rules' => 'trim|required'],
					    'company_address' => ['label' => 'Company address', 'rules' => 'trim|required'],
					    'iban' => ['label' => 'IBAN', 'rules' => 'trim|required'],
                        'vat' => ['label' => 'VAT', 'rules' => 'trim|required'],
					    'chamber_of_commerce' => ['label' => 'Chamber of commerce', 'rules' => 'trim|required'],
					];
				
				if($this->validate($rules)):
					$data = [
								'country_id' => $country,
								'name' => $name,
								'email' => $email,
								'password' => md5('123456'),
								'phone' => $phone,
								'description' => $description,
								'status' => 1,
								'media_id' => $media_id,
								'company_name' => $company_name,
							    'company_address' => $company_address,
							    'iban' => $iban,
							    'vat' => $vat,
							    'chamber_of_commerce' => $chamber_of_commerce,
								'updated_at' => date("Y-m-d H:i:s")
							];
					
					$update_id = $this->common_model->UpdateTableData($this->default_table,$data,array('id'=>$id));
					if($update_id)
					{
						$this->session->setFlashdata('flash_message','Data successfully updated.');
						$this->session->setFlashdata('class','success');
						return redirect()->to('admin/'.$this->mr);
					}
					else
					{
						$this->session->setFlashdata('flash_message','Something is went wrong please try again.');
						$this->session->setFlashdata('class','danger');
					}
				else:
					$page_data["errors"] = $this->validator->getErrors();
				endif;
			
			endif;
			
			$page_data['countries'] = $this->common_model->SelectDropdown(COUNTRIES_TABLE,'name','id',array($country));
			$page_data['module'] = $this->module.' : Edit';
			$page_data['mr'] = $this->mr;
			return view($this->fp.'/edit',$page_data);
		else:
		  $this->session->setFlashdata('flash_message','No data exist related.');
		  $this->session->setFlashdata('class','danger');
		  return redirect()->to('admin/'.$this->mr);
		endif;
    }
	
    //for color
      public function color_types($selected="")
	{
		die('sd');
				$arr = array(
					'red' => 'Red',
					'blue' => 'Blue',
					'green' => 'Green',
					'yellow' => 'Yellow',
					'black' => 'Black',
					'white' => 'Phite',
					'pink' => 'Pink',
					'gray' => 'Gray',
					'orange' => 'Orange',
				);
				if(!empty($selected)):
					return $arr[$selected];
				else:
					return $arr;
				endif;
			}
	//Delete user
	public function deleteUser()
	{
		if($this->request->isAJAX()){
			if(!empty($this->request->getPost('id'))):
				$id = $this->request->getPost('id',FILTER_SANITIZE_STRING);
				
				$row = $this->common_model->GetSingleRow($this->default_table,array('id' => $id));
				
				$delete = $this->common_model->DeleteTableData($this->default_table,array('id'=>$id));
				if($delete):
				   $data = array
					(
						'tbl' => $this->default_table,
						'data' => serialize($row),
						'created_at'=> time(),
					);
					$this->common_model->InsertTableData('tbl_deleted_data',$data);
				    $json_data['status'] = 'success';
				else:
					$json_data['status'] = 'error';
				endif;
			else:
			        $json_data['status'] = 'error';
			endif;
		}
		else
		{
			$json_data['status'] = 'error';
		}
		echo json_encode($json_data);
		die();
	}
	
	//Delete document
	public function deleteDocument()
	{
		if($this->request->isAJAX()){
			if(!empty($this->request->getPost('id'))):
				$id = $this->request->getPost('id',FILTER_SANITIZE_STRING);
				
				$row = $this->common_model->GetSingleRow(DOCUMENTS_TABLE,array('id' => $id));
				
				$delete = $this->common_model->DeleteTableData(DOCUMENTS_TABLE,array('id'=>$id));
				if($delete):
				   $data = array
					(
						'tbl' => $this->default_table,
						'data' => serialize($row),
						'created_at'=> time(),
					);
					$this->common_model->InsertTableData('tbl_deleted_data',$data);
				    $json_data['status'] = 'success';
				else:
					$json_data['status'] = 'error';
				endif;
			else:
			        $json_data['status'] = 'error';
			endif;
		}
		else
		{
			$json_data['status'] = 'error';
		}
		echo json_encode($json_data);
		die();
	}
	//change status
	public function changeStatus()
	{
		if($this->request->getPost('id'))
		{
			$id = $this->request->getPost('id',FILTER_SANITIZE_STRING);
			$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
			
			$update_id = $this->common_model->UpdateTableData($this->default_table,array('status'=>$status),array('id'=>$id));
			
			if(!empty($update_id)):
			  $status_value = $this->common_model->GetSinglevalue($this->default_table,'status',array('id'=>$id));
			  $json_data['status'] = 'success';
			  $json_data['status_value'] = $status_value;
			else:
			    $json_data['status'] = 'error';
			endif;
		}
		else
		{
			$json_data['status'] = 'error';
		}
		echo json_encode($json_data);
		die();
	}
}
