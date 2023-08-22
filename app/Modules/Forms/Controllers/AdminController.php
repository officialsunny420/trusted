<?php



namespace Modules\Forms\Controllers;



use App\Controllers\BaseController;

use App\Models\Common;



class AdminController extends BaseController

{

    public function __construct()

    {

        $this->common_model = new Common();

        $this->module = "Manage Forms";

        $this->mr = "forms"; // Module route

        $this->fp = '\Modules\Forms\Views';

        $this->default_table = FORM_TABLE;



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

        $results = $this->common_model->GetTableRows($this->default_table,$where,array('id','desc'),$per_page,$offset);



        $pagination = false;

        if($per_page < $total):

          $pager = \Config\Services::pager();

          $pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 

        endif;  

        $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($this->request->getVar('category_id')),array('parent_id' => 0));

		

        $page_data['results'] = $results;

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

                    if($key == "title" || $key =="form_title")

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

                            $where[] = "  $key = $value ";

                        }

                    }

                }

            }

        }

		return $where; 

	}

	

	//addition of 

    public function add()

    {

        $page_data = [];

		 if($this->request->getVar('s')):

            $form_title = $this->request->getVar('form_title', FILTER_SANITIZE_STRING);

            $category_id = $this->request->getVar('category_id', FILTER_VALIDATE_INT);

            $sub_categories = $this->request->getVar('sub_categories', FILTER_VALIDATE_INT);

            $section_data = serialize($this->request->getVar('section'));

            $rules = [ 

                    'form_title' => ['label' => 'Form title', 'rules' => 'required|is_unique[tbl_form.form_title,id,{id}]'],

                    'sub_categories' => ['label' => 'Sub Category', 'rules' => 'required'],

                    'category_id' => ['label' => 'Category', 'rules' => 'required'],

                ];

            if ($this->validate($rules)) 

            {

                $data = array(

                    'form_title' => $form_title,

                    'category_id' => $category_id,

                    'sub_category_id' => $sub_categories,

                    'data' => $section_data,

                    'created_at' => time(),

                );

				

				$insert_id = $this->common_model->InsertTableData($this->default_table,$data);

                if($insert_id)

                {

					$this->session->setFlashdata('flash_message','Data successfully added.');

                    $this->session->setFlashdata('class','success');

                    return redirect()->to('admin/'.$this->mr.'/add');

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

		$page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($this->request->getVar('category_id')),array('parent_id' => 0));

		$page_data['data'] = $this->common_model->GetSingleRow(FORM_TABLE,array('category_id'=> 3));



        $page_data['module'] = $this->module.' : Add';

		$page_data['mr'] = $this->mr;

        return view($this->fp."\add", $page_data);

    }

	

	/* function to get sub categories on selection of category */

	public function getSubcategories(){

		   $parent_id = $this->request->getVar('parent_id');

		   $html = '';

		   $html_prior = '<option value="">Please select</option>';

		   $rows = $this->common_model->GetTableRows(CATEGORIES_TABLE,array('parent_id'=>$parent_id),'');

		   if(isset($rows ) && !empty($rows )):

		      foreach($rows as $row):

			    $total = $this->common_model->GetTotalCount($this->default_table,array('sub_category_id' => $row['id']));

				if($total):

				 continue;

				endif;

				$selected = "";

				$html .= '<option value = "'.$row['id'].'" '.$selected.'  >'.$row['title'].'</option>';

              endforeach;

		    endif;

			if( !empty($html))

			{

				  $html =$html_prior.$html;

				  echo json_encode(array('status' => 'success' , 'html' =>  $html)); 

			}

			else

			{

				echo json_encode(array('status' => 'error' , 'html' =>  $html_prior,));

			}

		 die();

	}

	

	public function edit($id)

	{

		$page_data['data'] = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));

		//$page_data['data'] = $this->common_model->GetSingleRow(FORM_TABLE,array('category_id'=> 3));

	

		if(!empty($page_data)):

			if($this->request->getVar('s')):

				/* _p($_POST);

		die(); */

                $form_title = $this->request->getVar('form_title', FILTER_SANITIZE_STRING);

				$category_id = $this->request->getVar('category_id', FILTER_VALIDATE_INT);

				$sub_categories = $this->request->getVar('sub_categories', FILTER_VALIDATE_INT);

				$section_data = serialize($this->request->getVar('section',FILTER_SANITIZE_STRING));

				$rules = [ 

						'form_title' => ['label' => 'Form title', 'rules' => 'required'],

						'sub_categories' => ['label' => 'Sub Category', 'rules' => 'required'],

						'category_id' => ['label' => 'Category', 'rules' => 'required'],

					];

            if ($this->validate($rules)) 

            {

                    $data = array(

							'form_title' => $form_title,

							'category_id' => $category_id,

							'sub_category_id' => $sub_categories,

							'data' => $section_data,

							'updated_at' => time(),

						);

				

				

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

            $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($page_data['data']['category_id']),array('parent_id' => 0));

			 $page_data['sub_categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($page_data['data']['sub_category_id']),array('parent_id' => $page_data['data']['category_id']));

			$page_data['mr'] = $this->mr;

            return view($this->fp."/edit", $page_data);

		else:

			$this->session->setFlashdata('flash_message','Data not exist.');

            $this->session->setFlashdata('class','danger');

			return redirect()->to('admin/'.$this->mr);

		endif;

	}

	

	// deleteRow

	public function deleteRow()

	{

		if($this->request->getPost('id'))

		{

			$id = $this->request->getPost('id',FILTER_SANITIZE_STRING);

			$delete_id = $this->common_model->DeleteTableData($this->default_table,array('id'=>$id));

			if(!empty($delete_id)):

			  $json_data['status'] = 'success';

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

		public function view($id)

	{

		$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));

		if(!empty($page_data)):

		

		    $page_data['module'] = $this->module.' : View';

           // $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array(),array('status' => 1,'parent_id' => 0));

			$page_data['mr'] = $this->mr;

            return view($this->fp."/view", $page_data);

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

