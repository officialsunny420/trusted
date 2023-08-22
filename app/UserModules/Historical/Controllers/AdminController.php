<?php
namespace UserModules\Historical\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

Class AdminController extends BaseController{
	
	public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage Rental Historical Data";
		$this->fp = '\UserModules\Historical\Views';
        $this->default_table = STOCKS_TABLE;
        $this->mr = "historical"; // Module route
    }
	
	
	public function index()
	{
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
		
		if(!empty($_GET['user_id'])):
			$filtered_user = $_GET['user_id'];
		else:
			$filtered_user = '';
		endif;
		
		if(!empty($_GET['product_id'])):
			$filtered_product = $_GET['product_id'];
		else:
			$filtered_product = '';
		endif;
        
		
		$page_data['existing_products'] = $this->common_model->SelectDropdown(PRODUCTS_TABLE,'title','id',array($filtered_product),array('user_id'=>$_SESSION['user_id']));
        $page_data['results'] = $data;
        $page_data['module'] = $this->module;
        $page_data['modal'] = $this->common_model;
        $page_data['pagination'] = $pagination;
        $page_data['mr'] = $this->mr;
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
                    if($key == "name")
                    {
                        $value = trim($value);
                        if($value <> "")
                        {
                            $value = $db->escapeLikeString($value);
                            $where[] = "  $key LIKE '%$value%'   ";
                        }
                    }
					elseif($key == "rented_on")
					{
						$value = strtotime($value);
						if($value <> "")
                        {
                            $value = $db->escape($value);
                            $where[] = "  $key = $value   ";
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
	
	
	//editing of stocks
	public function view($id)
	{
		$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id,'user_id'=>$_SESSION['user_id']));

		if(!empty($page_data)):
			$user_id = $page_data['user_id'];
			$product_id = $page_data['product_id'];
			$membership_id = $page_data['membership_id'];
			
			$memberships = $this->common_model->SelectDropdown(MEMBERSHIP_TABLE,'title','id',array($membership_id),array('status'=>1),'discount');
			$page_data['memberships'] = $memberships;
			$page_data['products'] =  $this->common_model->SelectDropdown(PRODUCTS_TABLE,'title','id',array($product_id),array('user_id'=>$_SESSION['user_id']));
			$page_data['module'] = $this->module.' : View';
			$page_data['mr'] = $this->mr;
			return view($this->fp.'/view',$page_data);
		else:
		  $this->session->setFlashdata('flash_message','No data exist related.');
		  $this->session->setFlashdata('class','danger');
		  return redirect()->to('account/'.$this->mr);
		endif;
	}
	
}
 
?>