<?php
namespace Modules\Historical\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

Class AdminController extends BaseController{
	
	public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage Rental Historical Data";
		$this->fp = '\Modules\Historical\Views';
        $this->default_table = STOCKS_TABLE;
        $this->mr = "historical"; // Module route
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
		if(!empty($_GET['membership_id'])):
			$filtered_membership = $_GET['membership_id'];
		else:
			$filtered_membership = '';
		endif;
        
		$page_data['existing_users'] = $this->common_model->SelectDropdown(USERS_TABLE,'name','id',array($filtered_user));
		$page_data['existing_products'] = $this->common_model->SelectDropdown(PRODUCTS_TABLE,'title','id',array($filtered_product),array('user_id'=>$filtered_user));
		$page_data['existing_members'] = $this->common_model->SelectDropdown(MEMBERSHIP_TABLE,'title','id',array($filtered_membership),array('status' => 1));
        $page_data['results'] = $data;
        $page_data['module'] = $this->module;
        $page_data['modal'] = $this->common_model;
        $page_data['pagination'] = $pagination;
        $page_data['mr'] = $this->mr;
        return view($this->fp."\index", $page_data);
	}
	
	//view csv file 
	 public function csv(){
		 $page_data = [];
		 $page_data['module'] = $this->module;
         $page_data['modal'] = $this->common_model;
		 $page_data['mr'] = $this->mr;
         return view($this->fp."\csv", $page_data); 
    }
	
	//upload csv file 
	public function importCsvToDb(){
            if($file = $this->request->getFile('file')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(ROOTPATH.'uploads', $newName);
                    $file = fopen(ROOTPATH."/uploads/".$newName,"r");
                    $count = 1;
                    $numberOfFields = 4;
                    $csvArr = array();
                    $exchangedata = array();
                    while(($value = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($value);
                           if($count > 1){
                     		// Data of excel sheet
								$exchangedata[$count]['user_id'] = $value[0];
								$exchangedata[$count]['product_id'] = $value[1];
								$exchangedata[$count]['category_id'] = $value[2];
								$exchangedata[$count]['membership_id'] = $value[3];
								$exchangedata[$count]['retail_value'] = $value[4];
								$exchangedata[$count]['commission_paid'] = $value[5];
								$exchangedata[$count]['rental_income_for_partner'] = $value[6];
								$exchangedata[$count]['rental_income_for_admin'] = $value[7];
								$exchangedata[$count]['expiry_date'] = strtotime($value[8]);
								$exchangedata[$count]['currently_rented'] = $value[9];
								$exchangedata[$count]['rented_on'] = strtotime($value[10]);
								$exchangedata[$count]['created_at'] = date("Y-m-d H:i:s");
								$exchangedata[$count]['updated_at'] = date("Y-m-d H:i:s");  
						   }
                        $count++;
                    }
                    fclose($file); 
                    if(count($exchangedata))
					{
						// insert data to table 
						$insert = $this->common_model->InsertMultipleData($this->default_table,$exchangedata);
						if($insert)
						{
						    $this->session->setFlashdata('flash_message','Data successfully added.');
				         	$this->session->setFlashdata('class','success');
							return redirect()->to('admin/'.$this->mr);
							die();
						}
						else
						{
							$this->session->setFlashdata('flash_message','Something went wrong.');
					        $this->session->setFlashdata('class','danger');
						return redirect()->to('admin/'.$this->mr);
						die();
						}
					}
					else
					{
						$this->session->setFlashdata('flash_message','There is no data in file.');
						$this->session->setFlashdata('class','danger');
						return redirect()->to('admin/'.$this->mr);
						die();
					}
				}
            }else{
                session()->setFlashdata('message', 'CSV file coud not be imported.');
                session()->setFlashdata('alert-class', 'alert-danger');
            }
       
        	return redirect()->to('admin/'.$this->mr);       
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
	
	
	//addition of stocks
	public function add()
	{
		$page_data =[];
		
		$user_id = $this->request->getVar('user_id',FILTER_VALIDATE_INT);
		$product_id = $this->request->getVar('product_id',FILTER_VALIDATE_INT);
		$membership_id = $this->request->getVar('membership_id',FILTER_VALIDATE_INT);
		
		if($this->request->getVar('s')):
			$retail_value = $this->request->getPost('retail_value',FILTER_VALIDATE_FLOAT);
			$membership_amount = $this->request->getPost('membership_amount',FILTER_VALIDATE_FLOAT);
			$commission_paid = $this->request->getPost('commission_paid',FILTER_VALIDATE_FLOAT);
			$rental_income_for_partner = $this->request->getPost('rental_income_for_partner',FILTER_VALIDATE_FLOAT);
			$rental_income_for_admin = $this->request->getPost('rental_income_for_admin',FILTER_VALIDATE_FLOAT);
			$expiry_date = $this->request->getPost('expiry_date',FILTER_SANITIZE_STRING);
			//$rented_items = $this->request->getPost('rented_items',FILTER_VALIDATE_FLOAT);
			//$number_of_rotations = $this->request->getPost('number_of_rotations',FILTER_VALIDATE_FLOAT);
			$item_rented_by_males = $this->request->getPost('item_rented_by_males',FILTER_VALIDATE_FLOAT);
			$item_rented_by_females = $this->request->getPost('item_rented_by_females',FILTER_VALIDATE_FLOAT);
			$item_rented_by_others = $this->request->getPost('item_rented_by_others',FILTER_VALIDATE_FLOAT);
			$gross_margin = $this->request->getPost('gross_margin',FILTER_VALIDATE_FLOAT);
			$rented_on = $this->request->getPost('rented_on',FILTER_SANITIZE_STRING);
			$currently_rented = $this->request->getPost('currently_rented',FILTER_SANITIZE_STRING);
			
		
			//rules
			$rules = [
					'user_id' => ['label' => 'User', 'rules' => 'trim|required|numeric'],
					'product_id' => ['label' => 'Product', 'rules' => 'trim|required|numeric'],
					'membership_amount' => ['label' => 'Membership amount', 'rules' => 'trim|required|numeric'],
					'retail_value' => ['label' => 'Retail value', 'rules' => 'trim|required|numeric'],
					'commission_paid' => ['label' => 'Comission paid', 'rules' => 'trim|required|numeric|min_length[1]|less_than[101]'],
					'rental_income_for_partner' => ['label'=>'Rental income for partner', 'rules' => 'trim|required|numeric'],
					'rental_income_for_admin' => ['label'=>'Rental income for admin', 'rules' => 'trim|required|numeric'],
					'rented_on' => ['label'=>'Rented on date', 'rules' => 'trim|required'],
				];
			
			if($this->validate($rules)):
				$rental_income_for_partner = ($commission_paid/100)*$membership_amount;
				$rental_income_for_admin = $membership_amount-$rental_income_for_partner;
				$category_id = $this->common_model->GetSingleValue(PRODUCTS_TABLE,'category_id',array('id'=>$product_id));
				
				$stock_category = 0;
				if(!empty($category_id)):
					$stock_category = $category_id;
				endif;
				
				$data = [
							'user_id' => $user_id,
							'product_id' => $product_id,
							'category_id' => $stock_category,
							'membership_id' => $membership_id,
							'retail_value' => $retail_value,
							'membership_amount' => $membership_amount,
							'commission_paid' => $commission_paid,
							'rental_income_for_partner' => $rental_income_for_partner,
							'rental_income_for_admin' => $rental_income_for_admin,
							'expiry_date' => strtotime($expiry_date),
							//'rented_items' => $rented_items,
							'currently_rented' => $currently_rented,
							//'number_of_rotations' => $number_of_rotations,
							'item_rented_by_males' => $item_rented_by_males,
							'item_rented_by_females' => $item_rented_by_females,
							'item_rented_by_others' => $item_rented_by_others,
							'gross_margin' => $gross_margin,
							'rented_on' => strtotime($rented_on),
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
				$page_data['errors'] = $this->validator->getErrors();
			endif;
		endif;
		$users = $this->common_model->SelectDropdown(USERS_TABLE,'name','id',array($user_id),array('status'=>1));
		$products = $this->common_model->SelectDropdown(PRODUCTS_TABLE,'title','id',array($product_id),array('user_id'=>$user_id),'retail_value');
		$memberships = $this->common_model->SelectDropdown(MEMBERSHIP_TABLE,'title','id',array($membership_id),array('status'=>1),'discount');

		$page_data['users'] = $users;
		$page_data['memberships'] = $memberships;
		$page_data['products'] = $products;
		$page_data['module'] = $this->module.' : Add';
		$page_data['mr'] = $this->mr;
		return view($this->fp.'/add',$page_data);
	}
	
	//editing of stocks
	public function edit($id)
	{
		$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));

		if(!empty($page_data)):

			$user_id = $page_data['user_id'];
			$product_id = $page_data['product_id'];
			$membership_id = $page_data['membership_id'];

			//on submitting 
			if($this->request->getVar('s')):
				$user_id = $this->request->getVar('user_id',FILTER_VALIDATE_INT);
				$product_id = $this->request->getVar('product_id',FILTER_VALIDATE_INT);
				$membership_id = $this->request->getVar('membership_id',FILTER_VALIDATE_INT);
				$retail_value = $this->request->getPost('retail_value',FILTER_VALIDATE_FLOAT);
				$membership_amount = $this->request->getPost('membership_amount',FILTER_VALIDATE_FLOAT);
				$commission_paid = $this->request->getPost('commission_paid',FILTER_VALIDATE_FLOAT);
				$rental_income_for_partner = $this->request->getPost('rental_income_for_partner',FILTER_VALIDATE_FLOAT);
				$rental_income_for_admin = $this->request->getPost('rental_income_for_admin',FILTER_VALIDATE_FLOAT);
				$expiry_date = $this->request->getPost('expiry_date',FILTER_SANITIZE_STRING);
			  //$rented_items = $this->request->getPost('rented_items',FILTER_VALIDATE_FLOAT);
			  //$number_of_rotations = $this->request->getPost('number_of_rotations',FILTER_VALIDATE_FLOAT);
				$item_rented_by_males = $this->request->getPost('item_rented_by_males',FILTER_VALIDATE_FLOAT);
				$item_rented_by_females = $this->request->getPost('item_rented_by_females',FILTER_VALIDATE_FLOAT);
				$item_rented_by_others = $this->request->getPost('item_rented_by_others',FILTER_VALIDATE_FLOAT);
				$gross_margin = $this->request->getPost('gross_margin',FILTER_VALIDATE_FLOAT);
				$rented_on = $this->request->getPost('rented_on',FILTER_SANITIZE_STRING);
				$currently_rented = $this->request->getPost('currently_rented',FILTER_SANITIZE_STRING);
				if($expiry_date < $rented_on){
					$this->session->setFlashdata('flash_expiry','Expiry date must be less than Rented on date!.');
					return redirect()->to('admin/'.$this->mr.'/edit/'.$id);
					die();
				}

				//rules
				$rules = [
						'user_id' => ['label' => 'User', 'rules' => 'trim|required|numeric'],
						'product_id' => ['label' => 'Product', 'rules' => 'trim|required|numeric'],
						'retail_value' => ['label' => 'Retail value', 'rules' => 'trim|required|numeric'],
						'membership_amount' => ['label' => 'Membership amount', 'rules' => 'trim|required|numeric'],
						'commission_paid' => ['label' => 'Comission paid', 'rules' => 'trim|required|numeric|min_length[1]|less_than[101]'],
						'rental_income_for_partner' => ['label'=>'Rental income for partner', 'rules' => 'trim|required|numeric'],
						'rental_income_for_admin' => ['label'=>'Rental income for admin', 'rules' => 'trim|required|numeric'],
						'rented_on' => ['label'=>'Rented on date', 'rules' => 'trim|required'],
						//'expiry_date' => ['label'=>'Expiry date', 'rules' => 'trim|required'],
					];
				
				if($this->validate($rules)):
					$rental_income_for_partner = ($commission_paid/100)*$membership_amount;
					$rental_income_for_admin = $membership_amount-$rental_income_for_partner;
					$category_id = $this->common_model->GetSingleValue(PRODUCTS_TABLE,'category_id',array('id'=>$product_id));
					
					$stock_category = 0;
					if(!empty($category_id)):
						$stock_category = $category_id;
					endif;
					
					$data = [
								'user_id' => $user_id,
								'product_id' => $product_id,
								'category_id' => $stock_category,
								'membership_id' => $membership_id,
								'retail_value' => $retail_value,
								'membership_amount' => $membership_amount,
								'commission_paid' => $commission_paid,
								'rental_income_for_partner' => $rental_income_for_partner,
								'rental_income_for_admin' => $rental_income_for_admin,
								'expiry_date' => strtotime($expiry_date),
								//'rented_items' => $rented_items,
								'currently_rented' => $currently_rented,
								//'number_of_rotations' => $number_of_rotations,
								'item_rented_by_males' => $item_rented_by_males,
								'item_rented_by_females' => $item_rented_by_females,
								'item_rented_by_others' => $item_rented_by_others,
								'gross_margin' => $gross_margin,
								'rented_on' => strtotime($rented_on),
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
			$memberships = $this->common_model->SelectDropdown(MEMBERSHIP_TABLE,'title','id',array($membership_id),array('status'=>1),'discount');
			$page_data['memberships'] = $memberships;
			$page_data['users'] = $this->common_model->SelectDropdown(USERS_TABLE,'name','id',array($user_id));
			$page_data['products'] =  $this->common_model->SelectDropdown(PRODUCTS_TABLE,'title','id',array($product_id),array('user_id'=>$user_id),'retail_value');
			$page_data['module'] = $this->module.' : Edit';
			$page_data['mr'] = $this->mr;
			return view($this->fp.'/edit',$page_data);
		else:
		  $this->session->setFlashdata('flash_message','No data exist related.');
		  $this->session->setFlashdata('class','danger');
		  return redirect()->to('admin/'.$this->mr);
		endif;
	}
	
		//ajax get member ship amount
	public function getMembershipAmount()
	{
		if($this->request->isAJAX())
		{
			$html = "";
			$membership_id = $this->request->getPost('membership_id',FILTER_SANITIZE_STRING);
			if(!empty($membership_id)):
			$amount =  $this->common_model->GetSingleValue(MEMBERSHIP_TABLE,'price',array('id'=>$membership_id, 'status' => 1));
				if(!empty($amount)):
					$html = round($amount);
					$json_data['status'] = "success";
					$json_data['html'] = $html;
				else:
					$json_data['status'] = "error";
					$json_data['html'] = $html;
				endif;
			else:
				$json_data['status'] = "error";
				$json_data['html'] = $html;
			endif;
		}
		else{
				$json_data['status'] = "error";
				$json_data['html'] = $html;
		}
		echo json_encode($json_data);
		die();
	}
	//ajax
	public function getProductsOnUser()
	{
		$html ='<option value="" >--Select Product--</option>';
		if($this->request->isAJAX())
		{
			$user_id = $this->request->getPost('user_id',FILTER_SANITIZE_STRING);
			if(!empty($user_id)):
			$products = $this->common_model->SelectDropdown(PRODUCTS_TABLE,'title','id','',array('user_id'=>$user_id),'retail_value');
				if(!empty($products)):
					$html.=$products;
					$json_data['status'] = "success";
					$json_data['html'] = $html;
				else:
					$json_data['status'] = "error";
					$json_data['html'] = $html;
				endif;
			else:
				$json_data['status'] = "error";
				$json_data['html'] = $html;
			endif;
		}
		else{
				$json_data['status'] = "error";
				$json_data['html'] = $html;
		}
		echo json_encode($json_data);
		die();
	}
}
 
?>