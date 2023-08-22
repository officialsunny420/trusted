<?php

namespace Modules\Stocks\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage Stock";
        $this->mr = "stocks"; // Module route
        $this->fp = '\Modules\Stocks\Views';
        $this->default_table = PRODUCTS_TABLE;

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
		
		$db = db_connect();
		
		//category_id on get
		if(!empty($_GET['category_id'])):
			$filtered_category = $_GET['category_id'];
		else:
			$filtered_category = '';
		endif;
        
		
		//custom calculation
		if(count($data)):
			foreach($data as $i=>$pro_data):
				$pro_id = $pro_data['id'];
				
				//sum of rental_income_for_partner
				$total_rental_income_val = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where product_id = '$pro_id'");
				if(!empty($total_rental_income_val->getRowArray()['SUM(rental_income_for_partner)'])):
					$total_rental_income = $total_rental_income_val->getRowArray()['SUM(rental_income_for_partner)'];
				else:
					$total_rental_income =0;
				endif;
				
				//division aim of rental_income_for_partner by retail_value in stock
				$total_retail_val_in_stock = $db->query("SELECT SUM(retail_value) FROM tbl_stocks where product_id = '$pro_id'");
				if(!empty($total_retail_val_in_stock->getRowArray()['SUM(retail_value)'])):
					$total_retail_val = $total_retail_val_in_stock->getRowArray()['SUM(retail_value)'];
				else:
					$total_retail_val =0;
				endif;
				
				//rotation of product
				$total_rotation = $this->common_model->GetTotalCount(STOCKS_TABLE,array('product_id'=>$pro_id));
				if(!empty($total_rotation)):
				  $product_rotation  = $total_rotation;
				else:
					$product_rotation = 0;
				endif;
				
				//variable assign
				$data[$i]['total_rental_income'] = $total_rental_income;
				$data[$i]['total_retail_val'] = $total_retail_val;
				$data[$i]['division'] = 0;
				$data[$i]['product_rotation'] = $product_rotation;
				
				if($data[$i]['total_retail_val']>0)
				{
					$data[$i]['division'] = ($data[$i]['total_rental_income']/$data[$i]['total_retail_val']);
				}
				
			endforeach;
		endif;

		$page_data['existing_categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($filtered_category));
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
                            $value = $db->escape($value);
                            $where[] = "  $key = $value   ";
                        }
                    }
                }
            }
        }
		return $where; 
	}
	
	//product addition
    public function add()
    {
        $page_data = [];
        $category_id = $this->request->getVar('category_id', FILTER_SANITIZE_STRING);
        $user_id = $this->request->getVar('user_id', FILTER_SANITIZE_STRING);
        if($this->request->getVar('s')):
            $title = $this->request->getVar('title', FILTER_SANITIZE_STRING);
            $sku = $this->request->getVar('sku', FILTER_SANITIZE_STRING);
            $description = $this->request->getVar('description', FILTER_SANITIZE_STRING);
            $media_id = $this->request->getVar('media_id', FILTER_SANITIZE_STRING);
            $color = $this->request->getVar('color', FILTER_SANITIZE_STRING);
            $size = $this->request->getVar('size', FILTER_SANITIZE_STRING);
			$brand_name = $this->request->getVar('brand_name', FILTER_SANITIZE_STRING);
			$warehouse_arrival_date = $this->request->getPost('warehouse_arrival_date',FILTER_SANITIZE_STRING);
			$retail_value = $this->request->getPost('retail_value',FILTER_VALIDATE_FLOAT);
            
            $rules = [ 
                    'title' => ['label' => 'Product Name', 'rules' => 'required'],
                    'category_id' => ['label' => 'Category', 'rules' => 'required'],
                    'user_id' => ['label' => 'User', 'rules' => 'required'],
                    'color' => ['label' => 'Color', 'rules' => 'required'],
                    'size' => ['label' => 'Size', 'rules' => 'required'],
					'brand_name' => ['label' => 'Brand Name', 'rules' => 'required'],
					'retail_value' => ['label' => 'Retail value', 'rules' => 'trim|required|numeric'],
                ];
            if ($this->validate($rules)) 
            {
                $data = array(
                    'title' => $title,
                    'user_id' => $user_id,
                    'category_id' => $category_id,
                    'sku' => $sku,
                    'description' => $description,
                    'media_id' => $media_id,
					'warehouse_arrival_date' => strtotime($warehouse_arrival_date),
                    'color' => $color,
                    'size' => $size,
                    'brand_name' => $brand_name,
					'retail_value' => $retail_value,
                );
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
            }
            else
            {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif; 
        
        $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($category_id),array('status' => 1));
        $page_data['users'] = $this->common_model->SelectDropdown(USERS_TABLE,'name','id',array($category_id),array('status' => 1));
        $page_data['module'] = $this->module.' : Add';
		$page_data['mr'] = $this->mr;
        return view($this->fp."\add", $page_data);
    }
	
	public function edit($id)
	{
		$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
	/* 	_p($page_data);
		die(); */
        if(!$page_data){
            $this->session->setFlashdata('flash_message','Data not exist.');
            $this->session->setFlashdata('class','danger');
			return redirect()->to('admin/'.$this->mr);
            die();
        }
        $category_id = $page_data['category_id'];
        $user_id = $page_data['user_id'];
        $media_src = json_decode($this->common_model->getMediaData($page_data['media_id']))->media_src;
       
        if($this->request->getVar('s')):
            $title = $this->request->getVar('title', FILTER_SANITIZE_STRING);
            $sku = $this->request->getVar('sku', FILTER_SANITIZE_STRING);
            $description = $this->request->getVar('description', FILTER_SANITIZE_STRING);
            $category_id = $this->request->getVar('category_id', FILTER_SANITIZE_STRING);
            $user_id = $this->request->getVar('user_id', FILTER_SANITIZE_STRING);
            $media_id = $this->request->getVar('media_id', FILTER_SANITIZE_STRING);
            $color = $this->request->getVar('color', FILTER_SANITIZE_STRING);
            $size = $this->request->getVar('size', FILTER_SANITIZE_STRING);
            $brand_name = $this->request->getVar('brand_name', FILTER_SANITIZE_STRING);
			$warehouse_arrival_date = $this->request->getPost('warehouse_arrival_date',FILTER_SANITIZE_STRING);
			$retail_value = $this->request->getPost('retail_value',FILTER_VALIDATE_FLOAT);
            $rules = [ 
                'title' => ['label' => 'Product Name', 'rules' => 'required'],
                'category_id' => ['label' => 'Category', 'rules' => 'required'],
                'user_id' => ['label' => 'User', 'rules' => 'required'],
                'color' => ['label' => 'Color', 'rules' => 'required'],
                'size' => ['label' => 'Size', 'rules' => 'required'],
				'brand_name' => ['label' => 'Brand Name', 'rules' => 'required'],
				'retail_value' => ['label' => 'Retail value', 'rules' => 'trim|required|numeric'],
            ];
            if ($this->validate($rules)) 
            {
                $data = array(
                    'title' => $title,
                    'user_id' => $user_id,
                    'category_id' => $category_id,
                    'sku' => $sku,
                    'description' => $description,
                    'media_id' => $media_id,
					'warehouse_arrival_date' => strtotime($warehouse_arrival_date),
                    'color' => $color,
                    'size' => $size,
					'brand_name' => $brand_name,
					'retail_value' => $retail_value,
                );
				
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
            }
            else
            {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif;
        $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($category_id),array('status' => 1));
        $page_data['users'] = $this->common_model->SelectDropdown(USERS_TABLE,'name','id',array($user_id),array('status' => 1));
        $page_data['module'] = $this->module.' : Edit';
        $page_data['media_src'] = $media_src;
		$page_data['mr'] = $this->mr;
        return view($this->fp."/edit", $page_data);
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
