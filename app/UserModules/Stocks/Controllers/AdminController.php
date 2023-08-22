<?php

namespace UserModules\Stocks\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage Stock";
        $this->mr = "stocks"; // Module route
        $this->fp = '\UserModules\Stocks\Views';
        $this->default_table = PRODUCTS_TABLE;

    }
    public function index()
    {
		$user_id = $_SESSION['user_id'];
        $page_data = [];
		$where = array("user_id=".$_SESSION['user_id']."");
		
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
				$total_rental_income_val = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where product_id = '$pro_id' and user_id='' ");
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
				$total_rotation = $this->common_model->GetTotalCount(STOCKS_TABLE,array('product_id'=>$pro_id,'user_id'=>$user_id));
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
	
	
	public function view($id)
	{
		$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id,'user_id'=>$_SESSION['user_id']));
        if(!$page_data){
            $this->session->setFlashdata('flash_message','Data not exist.');
            $this->session->setFlashdata('class','danger');
			return redirect()->to('account/'.$this->mr);
            die();
        }
        $category_id = $page_data['category_id'];
        $user_id = $page_data['user_id'];
        $media_src = json_decode($this->common_model->getMediaData($page_data['media_id']))->media_src;
		
		$page_data['mr'] = $this->mr;
        $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($category_id),array('status' => 1));
        $page_data['module'] = $this->module.' : View';
        $page_data['media_src'] = $media_src;
        return view($this->fp."/view", $page_data);
	}
	
}
