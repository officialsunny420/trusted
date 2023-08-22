<?php
namespace Modules\Categories\Controllers;
use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage categories";
        $this->mr = "categories"; // Module route
        $this->fp = '\Modules\Categories\Views';
        $this->default_table = CATEGORIES_TABLE;

    }
    public function index()
    {
         $page_data = [];
		$where = array();
		
		//filter
		$where = $this->filter_query($where);
		$where = implode(' AND ', $where);

		//pagination
		$per_page = PER_PAGE_LIMIT;
        $offset = (int)$this->request->getVar('page') ? ($this->request->getVar('page')-1)*$per_page : 0;
        $total = $this->common_model->GetTotalCount($this->default_table,$where);
        $data = $this->common_model->GetTableRows($this->default_table,$where,'',$per_page,$offset);

        $pagination = false;
        if($per_page < $total):
          $pager = \Config\Services::pager();
          $pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 
        endif;  
        $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($this->request->getVar('id')),array('parent_id' => 0));
        $page_data['results'] = $data;
        $page_data['module'] = $this->module;
        $page_data['pagination'] = $pagination;
		$page_data['mr'] = $this->mr;
        $page_data['model'] = $this->common_model;
        return view($this->fp."\index", $page_data);
    }
	
	//filter query
	public function filter_query($where = [])
	{
        if(count($_GET)){
            $db = db_connect();
            $fields = $db->getFieldNames($this->default_table);
            foreach($_GET as $key => $value)
            {
                if(!in_array($key,$fields)){ continue; }
                $value = strip_tags($value);
                if($key <> "from" && $key <> "to")
                {
                    if($key == "title")
                    {
                        $value = trim($value);
                        if($value <> "")
                        {
                            $value = $db->escapeLikeString($value);
                            $where[] = "  $key LIKE '%$value%'   ";
                        }
                    }
                    else
                    {
                        if($value <> "")
                        {
                          $sub_cat = ""; 
                          if($key == 'id'){
                               $sub_cat = " or parent_id = $value"; 
                               }
                            $value = $db->escape($value);
                            $where[] = "  $key = $value $sub_cat ";
                        }
                    }
                }
            }
        }
		return $where; 
	}
	
	//addition of category
    public function add()
    {
        $page_data = [];
		$page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array(),array('status' => 1,'parent_id' => 0));
        if($this->request->getVar('s')):
            $title = $this->request->getVar('title', FILTER_SANITIZE_STRING);
            $description = $this->request->getVar('description', FILTER_SANITIZE_STRING);
            $parent_id = $this->request->getVar('parent_id', FILTER_SANITIZE_STRING);
			
			$avtar_file = $this->request->getVar('avtar_file', FILTER_SANITIZE_STRING);
			 
            $rules = [ 
                    'title' => ['label' => 'Title', 'rules' => 'required'],
                ];
            if ($this->validate($rules)) 
            {
                $data = array(
                    'title' => $title,
                    'parent_id' => $parent_id,
                    'description' => $description,
                );
				
				//if avtar file gets upload
				if($avtar_file)
				{
					$data['media_id'] = $avtar_file;
				}
				
                $insert_id = $this->common_model->InsertTableData($this->default_table,$data);
                if($insert_id)
                {
					$slug = slug($title.' '.$insert_id);
                    $slug_update= $this->common_model->UpdateTableData($this->default_table,array('slug' => $slug),array('id'=>$insert_id));
					
                    $this->session->setFlashdata('flash_message','Data successfully added.');
                    $this->session->setFlashdata('class','success');
                    return redirect()->to('admin/'.$this->mr);
                }
                else
                {
                    $this->session->setFlashdata('flash_message','Something is went wrong please try again.');
                    $this->session->setFlashdata('class','danger');
                }
            }
            else
            {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif; 
        $page_data['module'] = $this->module.' : Add';
		$page_data['mr'] = $this->mr;
        return view($this->fp."\add", $page_data);
    }
	
	public function edit($id)
	{
		$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
		
		if(!empty($page_data)):
		
			//get category picture
		    if(!empty($page_data['media_id'])):
			$file_name = $this->common_model->GetSingleValue(MEDIA_TABLE,('name'),array('id'=>$page_data['media_id']));
				if(!empty($file_name)):
					if(file_exists(FCPATH."uploads/".$file_name)):
						$category_pic_src = base_url('/uploads/'.$file_name.'');
						$page_data['category_pic_src'] = $category_pic_src;
					endif; 
				endif;
			endif;
			
		    if($this->request->getVar('s')):
            $title = $this->request->getVar('title', FILTER_SANITIZE_STRING);
            $description = $this->request->getVar('description', FILTER_SANITIZE_STRING);
			$avtar_file = $this->request->getVar('avtar_file', FILTER_SANITIZE_STRING);
			$parent_id = $this->request->getVar('parent_id', FILTER_SANITIZE_STRING);
            $rules = [ 
                    'title' => ['label' => 'Title', 'rules' => 'required'],
                ];
            if ($this->validate($rules)) 
            {
				$slug = slug($title.' '.$id);
                $data = array(
                    'title' => $title,
                    'description' => $description,
                    'parent_id' => $parent_id,
					'slug' => $slug
                );
				
				//if avtar file gets upload
				if($avtar_file)
				{
					$data['media_id'] = $avtar_file;
				}
				
                $update_id = $this->common_model->UpdateTableData($this->default_table,$data,array('id'=>$id));
                if($update_id)
                {
                    $this->session->setFlashdata('flash_message','Data successfully edited.');
                    $this->session->setFlashdata('class','success');
                    return redirect()->to('admin/'.$this->mr);
                }
                else
                {
                    $this->session->setFlashdata('flash_message','Something is went wrong please try again.');
                    $this->session->setFlashdata('class','danger');
                }
            }
            else
            {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif;
		    $page_data['module'] = $this->module.' : Edit';
            $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($page_data['parent_id']),array('parent_id' => 0));
			$page_data['mr'] = $this->mr;
            return view($this->fp."/edit", $page_data);
		else:
			$this->session->setFlashdata('flash_message','Data not exist.');
            $this->session->setFlashdata('class','danger');
			return redirect()->to('admin/'.$this->mr);
		endif;
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
