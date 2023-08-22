<?php

namespace UserModules\Profile\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage profile";
        $this->mr = "profile"; // Module route
        $this->fp = '\UserModules\Profile\Views';
        $this->default_table = USERS_TABLE;

    }
    public function index()
    {
        $id = session()->get('user_id');
        $page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
       
		if(!empty($page_data)):
			$media_src = json_decode($this->common_model->getMediaData($page_data['media_id']))->media_src;
			$country = $page_data['country_id'];
			
			if($this->request->getVar('s')):
			   
                $country = $this->request->getVar('country_id', FILTER_VALIDATE_INT);
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$password = $this->request->getPost('password');
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
					];
				
				if($this->validate($rules)):
					$data = [
								'country_id' => $country,
								'name' => $name,
								'email' => $email,
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
					if(!empty($password))
					{
						$data['password'] =  md5($password);
					}
					
					$update_id = $this->common_model->UpdateTableData($this->default_table,$data,array('id'=>$id));
					if($update_id)
					{
						$this->session->setFlashdata('flash_message','Data successfully updated.');
						$this->session->setFlashdata('class','success');
						return redirect()->to('account/'.$this->mr);
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
                $page_data['module'] = $this->module;
                $page_data['media_src'] = $media_src;
                return view($this->fp."/index", $page_data);
        else:
            $this->session->setFlashdata('flash_message','Data not exist.');
            $this->session->setFlashdata('class','danger');
            return redirect()->to('account/'.$this->mr);
        endif;
    }
}
