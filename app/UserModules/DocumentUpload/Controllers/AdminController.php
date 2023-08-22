<?php 
namespace UserModules\DocumentUpload\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController{
	
	//prior function
	public function __construct(){
		$this->common_model = new Common();
        $this->module = "Document Upload";
        $this->mr = "documents"; // Module route
        $this->fp = '\UserModules\DocumentUpload\Views';
        $this->default_table = DOCUMENTS_TABLE;
	}
	
	public function index()
    {	
	
		$user_id = $_SESSION['user_id'];
	    $exist_data = $this->common_model->GetSingleRow(USERS_TABLE,array('id'=>$user_id));
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
						return redirect()->to('account/documents/');
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
			  $page_data['module'] = $this->module.' : View';
		      return view($this->fp.'/document',$page_data);
    }
	
	public function filter_query($where = [],$table="")
	{
        $table = $this->default_table;
        if(count($_GET)){
            $db = db_connect();
            $fields = $db->getFieldNames($table);
            foreach($_GET as $key => $value)
            {
                if(!in_array($key,$fields)){ continue; }
                 $value = strip_tags($value);
                if($key <> "from" && $key <> "to")
                {
                    if($key == 'title')
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
}
?>