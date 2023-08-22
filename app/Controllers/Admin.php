<?php

namespace App\Controllers;
use App\Models\Common;

class Admin extends BaseController
{
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
                $table = ADMIN_TABLE;
                $result = $common->GetSingleRow($table,array('email' => $email, 'password' => MD5($password)))  ;
                if($result)
                {
                    $sess_array = array( 'admin_id' => $result['id'], 'admin_name' => $result['name'],'admin_email' => $result['email'],'role' => 1);
                    $this->session->set($sess_array);
                    return redirect()->to('admin/dashboard');
                }
                else
                {
                    $this->session->setFlashdata('flash_message','Invalid Username or Password.');
                    $this->session->setFlashdata('class','danger');
                }
            }
            else
            {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif;    
        echo view('admin/login',$page_data);
    }
}