<?php

namespace App\Controllers;
use App\Models\Common;

class User extends BaseController
{
	
  public function __construct()
  {
	$this->common_modal = new Common();
  }
    public function index()
    {
		
        $page_data = [];
        if($this->request->getVar('s')):
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
           
            $rules = [ 
                        'email' => ['label' => 'E-mail', 'rules' => 'required|valid_email'],
                        'password' => ['label' => 'Password', 'rules' => 'required']
                    ];

            if ($this->validate($rules)) 
            {
                $common = new Common();
                $table = USERS_TABLE;
                $result = $common->GetSingleRow($table,array('email' => $email, 'password' => MD5($password),'status'=>1))  ;
                if($result)
                {
                    $sess_array = array( 'user_id' => $result['id'], 'user_name' => $result['name'],'user_email' => $result['email'],'role' => 0);
                    $this->session->set($sess_array);
                    return redirect()->to('account/dashboard');
                }
                else
                {
                    $this->session->setFlashdata('flash_message','Invalid Username or Passwords.');
                    $this->session->setFlashdata('class','danger');
					return redirect()->to('user');
                }
            }
            else
            {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif;    
        echo view('front/login',$page_data);
     }
		
}