<?php

namespace Modules\Form_Submission\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage submissions";
        $this->mr = "submissions"; // Module route
        $this->fp = '\Modules\Form_Submission\Views';
        $this->default_table = LEADS_TABLE;

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
        $data = $this->common_model->GetTableRows($this->default_table,$where,array('id','desc'),$per_page,$offset);

        $pagination = false;
        if($per_page < $total):
          $pager = \Config\Services::pager();
          $pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 
        endif;  
        $page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array($this->request->getVar('category_id')),array('status' => 1,'parent_id' => 0));
        $page_data['results'] = $data;
        $page_data['module'] = $this->module;
        $page_data['pagination'] = $pagination;
		$page_data['mr'] = $this->mr;
        $page_data['model'] = $this->common_model;
        return view($this->fp."\index", $page_data);
    }
	
	    public function contact_us()
    {
         $page_data = [];
		 $where = array();
		
		//filter
		$where = $this->contact_us_filter_query($where);
		$where = implode(' AND ', $where);

		//pagination
		$per_page = PER_PAGE_LIMIT;
        $offset = (int)$this->request->getVar('page') ? ($this->request->getVar('page')-1)*$per_page : 0;
        $total = $this->common_model->GetTotalCount($this->default_table,$where);
        $data = $this->common_model->GetTableRows(CONTACT_US_TABLE,$where,array('id','desc'),$per_page,$offset);

        $pagination = false;
        if($per_page < $total):
          $pager = \Config\Services::pager();
          $pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 
        endif;  
        $page_data['results'] = $data;
        $page_data['module'] = $this->module;
        $page_data['pagination'] = $pagination;
		$page_data['mr'] = $this->mr;
        $page_data['model'] = $this->common_model;
        return view($this->fp."\contact_us", $page_data);
    }
    	public function contact_us_filter_query($where = [])
	{
        if(count($_GET)){
            $db = db_connect();
            $fields = $db->getFieldNames(CONTACT_US_TABLE);
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
                           $where[] = " $key = $value"; 
                        }
                    }
                }
            }
        }
		return $where; 
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
	 public function export()
    {
        $page_data = [];
		$page_data['categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array(),array('status' => 1,'parent_id' => 0));
		$page_data['sub_categories'] = $this->common_model->SelectDropdown(CATEGORIES_TABLE,'title','id',array(),array('status' => 1,'parent_id >' => 0));
         if($this->request->getVar('s')):
            $category_id = $this->request->getVar('category_id', FILTER_SANITIZE_STRING);
            $sub_categories = $this->request->getVar('sub_categories', FILTER_SANITIZE_STRING);
           
            $rules = [ 
                    'category_id' => ['label' => 'Category', 'rules' => 'required'],
                    'sub_categories' => ['label' => 'Sub category', 'rules' => 'required'],
                ];
            if ($this->validate($rules)){
            		   // file name 
            		   $resultData = $this->common_model->GetSelectedFields($this->default_table,'id,form_title,form_data,category_id,sub_categories,',
            		   array('category_id' => $category_id,'sub_categories' => $sub_categories));
                     if(isset($resultData) && !empty($resultData)):
            		  $filename = 'Leads'.date('Ymd').'.csv'; 
            		   header("Content-Description: File Transfer"); 
            		   header("Content-Disposition: attachment; filename=$filename"); 
            		   header("Content-Type: application/csv; ");
            		   // file creation 
            		   $file = fopen('php://output', 'w');
            		  // $header = array("ID","Form Title"); 
            		 //  fputcsv($file, $header);
            		    $header_count = 1;
            		  
            		    foreach ($resultData as $result){ 
            		        $value = [];
            		        if($header_count == 1){
                    		   $header[] = 'Form title';
                    		   $header[] = 'Category';
                    		   $header[] = 'Sub category';
                    		}
            		        $category_name = $this->common_model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=>$result['category_id']));
            		    	$sub_category_name = $this->common_model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=>$result['sub_categories']));
                             $value[] = $result['form_title'];
            		         $value[] = $category_name;
            		         $value[] = $sub_category_name;
            		         $data = unserialize($result['form_data']);
            		         //	_p($data);
            		         
                			 if(isset($data) && count($data) > 0):
                    			 foreach($data as $result):
                    			      if(isset($result) && count($result) > 0):
                					    foreach($result['fields'] as $fields):
                					         if(isset($fields['label']) && $header_count ==1):
                						        $header[] = $fields['label'];
                						      
                						     endif;
                						     if(isset($fields['name'])):
                						        $value[] = $fields['name'];
                						     endif;
                					    endforeach;	
                					 endif;
                					 
                			    endforeach;
                			 endif;
                		if($header_count == 1){
                		   fputcsv($file, $header); 
                		}
            			fputcsv($file,$value); 
            		    $header_count++;
            			} 
            			
            		   fclose($file); 
            		   exit; 
            		  else:
            		         $this->session->setFlashdata('flash_message','No result found.');
                             $this->session->setFlashdata('class','danger');
            		  endif; 
		  
            }
            else
            {
                $page_data["errors"] = $this->validator->getErrors();
            }
	  	endif;  
	  	$page_data['module'] = $this->module.' : Export CSV';
		$page_data['mr'] = $this->mr;
         return view($this->fp."\add_csv", $page_data);
           $this->session->setFlashdata('flash_message','');
           $this->session->setFlashdata('class','');
      
    }
    public function exportall()
    {

         $resultData = $this->common_model->GetSelectedFields($this->default_table,'id,form_title,form_data,category_id,sub_categories,created_on',array());
		 
         $filter_data = [];
		 $new_count = 1;
		 if($resultData):
            foreach($resultData as $newresult):
			    $new_count++;
				$filter_data[$newresult['sub_categories']][$new_count] = $newresult;
			endforeach;
         endif;		 
	
		$spreadsheet = new Spreadsheet();
		//$sheet = $spreadsheet->getActiveSheet(1);
		//$sheet = $spreadsheet->getActiveSheet();


		//First sheet
			//$sheet = $spreadsheet->getActiveSheet();

			//Start adding next sheets
			$i=0;
			$col=1;
			$row=1;
			$count=1;
			$header_count = 1;
			 $sheet = $spreadsheet->createSheet(0);
			 if($filter_data):
				foreach($filter_data as $key => $result):
				   if($result):
				  
					  $col=1;
					  //$row=1;
					  //Setting index when creating
					  /*  if($i == 0){
					  
					  } */
					  $i++;
					 
					  //$header_count = 1;
					  /* $category_name = $this->common_model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=> $key));
					 
					 // 
					 if($category_name){
						// $category_name = substr($category_name,0,30); 
					  }else{
						// $category_name = "Sheet $i";   
					  } */
					 // $sheet->setCellValueByColumnAndRow(1, $row, $category_name);
					  //$row++;
					 // $category_name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $category_name);
					//$sheet = $spreadsheet->createSheet($i); //Setting index when creating
				    foreach($result as $new_result):
					 $values = [];
					 $header = [];
					 $label_header_count = 16;
					  if($header_count == 1){
					   $header[1] = 'Date Created';
					   $header[2] = 'Category';
					   $header[3] = 'Sub Category';
					   
					}
					$category_name = $this->common_model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=> $new_result['category_id']));
					$subcategory_name = $this->common_model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=> $new_result['sub_categories']));
				
					    $created_on ='';
						if($new_result['created_on']):
						   $created_on = date('d-M-Y h:i a',$new_result['created_on']);
						     $values[1] = $created_on;
						  else:
							 $values[1] = "N/A";
						  endif;
						  $values[2] = $category_name;
						  $values[3] = $subcategory_name;
					    $data = unserialize($new_result['form_data']);
						
                			 if(isset($data) && count($data) > 0):
                    			 foreach($data as $csv_result):
                    			      if(isset($csv_result) && count($csv_result) > 0):
                					    foreach($csv_result['fields'] as $fields):
                					         if(isset($fields['label'])):
											    $field_value = "N/A";
											    if(isset($fields['name'])):
											     $field_value = $fields['name'];
											    endif;
                						       // $header[] = clean($fields['label']);
                						        $label = clean_header($fields['label']);
												$labels = header_csv($label);
												if(isset($labels['label'])):
												 $header[$labels['key']] = $labels['label'];
												 $values[$labels['key']] = $field_value;
												else:
												   //$header[$label_header_count] = $fields['label'];
												  // $values[$label_header_count] = $field_value;
												  // $label_header_count++;
												endif;
                						     endif;
											    /* $field_label = "";
											    if(isset($fields['label'])):
												 $field_label = $fields['label'];
												endif;
											    $field_value = "N/A";
											    if(isset($fields['name'])):
											     $field_value = $fields['name'];
											    endif;
                						       // $header[] = clean($fields['label']);
                						        $label = clean_header($field_label);
												$labels = header_csv($label);
												if(isset($labels['label'])):
												// $header[$labels['key']] = $labels['label'];
												 $values[$labels['key']] = $field_value;
												else:
												  // $header[$label_header_count] = $field_label;
												   $values[$label_header_count] = $field_value;
												   $label_header_count++;
												endif; */
                						     /* if(isset($fields['name'])):
                						       // $value[] = $fields['name'];
												//$sheet->setCellValueByColumnAndRow($col, $row, $fields['name']);
												//$col++;
                						     endif; */
                					    endforeach;	
                					 endif;
                			    endforeach;
                			 endif;
							
							    $header_csv = header_csv();
							 	if($header_csv && $header_count == 1):
								
								 $col = 1;
								 foreach($header_csv as $header_data):
									$sheet->setCellValueByColumnAndRow($header_data['key'], $row, $header_data['label']);
									$col++;
								 endforeach;
								 $row++;
								 $header_count++;
								endif;
								  if(isset($values) && is_array($values)):
									 $col = 1;
									 foreach($values as $key => $value):
									     $exitskeys = array_search($key, array_column($header_csv, 'key'));
										 $sheet->setCellValueByColumnAndRow($key,$row,$value);
										$col++;
									 endforeach;
								  $row++;
								endif;  
								
					endforeach;
				   endif;
				   $count++;
				    //$sheet->setCellValueByColumnAndRow(1, $row, "");
					//$row++;
					//$filter_data[$newresult['category_id']][$new_count] = $newresult;
				endforeach;
			 endif;
			
			//// die();
			 // die();
			//die();
			 $sheet->setTitle("All Leads");
			 $spreadsheet->setActiveSheetIndex(0);
			/* while ($i < 7) {
				
             if($i < 7){
				 
			
			  // Add new sheet
			    $sheet = $spreadsheet->createSheet($i); //Setting index when creating
                $sheet->setCellValueByColumnAndRow($col, $row, "SD".$i);
				$col++;
			  //Write cells
			 /*  $sheet->setCellValue('A1', 'Hello'.$i)->
			  setCellValue('B2', 'world!');
			  
			  $sheet->setCellValue('H1', 'Hello')
						   ->setCellValue('D2', 'world!'); */
					/* }
			  // Rename sheet
			  $sheet->setTitle("First TAb $i");

			  $i++;
			} */
		$sheet = $spreadsheet->getActiveSheet(1);
		$writer = new Xlsx($spreadsheet);
        $file = 'leads'.time().'.xlsx';
		$writer->save($file);
		
		// define file $mime type here
		ob_end_clean(); // this is solution
		header('Content-Description: File Transfer');
		header('Content-Type: xlsx');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		readfile($file);		 
		die('');
        
    }
	public function exportCategories()
    {
		 $resultData = $this->common_model->GetTableRows(CATEGORIES_TABLE,array('parent_id'=> 0),array('id','desc'));
         $filter_data = [];
		 $new_count = 1;
		 $spreadsheet = new Spreadsheet();
			$i=0;
			$col=1;
			$row=1;
			$count=1;
			$sheet = $spreadsheet->createSheet($i); 
			 if($resultData):
				 $col=1;
				 $sheet->setCellValueByColumnAndRow($col, $row, 'Categories');
				 $sheet->setCellValueByColumnAndRow(2, $row, 'Sub Categories');
				 $row++;				 
				foreach($resultData as $key => $result):
				     $col=1;
				     $sheet->setCellValueByColumnAndRow($col, $row, $result['title']);
				     $col++;
				     $row++;
				     $subcategoryData = $this->common_model->GetTableRows(CATEGORIES_TABLE,array('parent_id'=> $result['id']),array('id','desc'));
				     if($subcategoryData):
					   $col = 2;
				       foreach($subcategoryData as $new_result):
				        $sheet->setCellValueByColumnAndRow($col, $row, $new_result['title']);
						$row++;
					    //$col++;
					   endforeach;
					   $row++;
				     endif;
				endforeach;
			 endif;
		$sheet->setTitle("Categories");
		$spreadsheet->setActiveSheetIndex(0);
		$sheet = $spreadsheet->getActiveSheet(1);
		$writer = new Xlsx($spreadsheet);
        $file = 'categories'.time().'.xlsx';
		$writer->save($file);
		
		// define file $mime type here
		ob_end_clean(); // this is solution
		header('Content-Description: File Transfer');
		header('Content-Type: xlsx');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		readfile($file);		 
		die('');
        
    }
    public function exportSingle($id)
    {
		   // file name 
		   $resultData = $this->common_model->GetSelectedFields($this->default_table,'id,form_title,form_data,category_id,sub_categories,',
		   array('id' => $id));
		   	
         if(isset($resultData) && !empty($resultData)):
            
		   $filename = 'Leads'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // file creation 
		   $file = fopen('php://output', 'w');
		  // $header = array("ID","Form Title"); 
		 //  fputcsv($file, $header);
		    $header_count = 1;
		  
		    foreach ($resultData as $result){ 
		        $value = [];
		        if($header_count == 1){
        		   $header[] = 'Form title';
        		   $header[] = 'Category';
        		   $header[] = 'Sub category';
        		}
		        $category_name = $this->common_model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=>$result['category_id']));
		    	$sub_category_name = $this->common_model->GetSingleValue(CATEGORIES_TABLE,'title',array('id'=>$result['sub_categories']));
                 $value[] = $result['form_title'];
		         $value[] = $category_name;
		         $value[] = $sub_category_name;
		         $data = unserialize($result['form_data']);
		         //	_p($data);
		         
    			 if(isset($data) && count($data) > 0):
        			 foreach($data as $result):
        			      if(isset($result) && count($result) > 0):
    					    foreach($result['fields'] as $fields):
    					         if(isset($fields['label']) && $header_count ==1):
    						        $header[] = $fields['label'];
    						      
    						     endif;
    						     if(isset($fields['name'])):
    						        $value[] = $fields['name'];
    						     endif;
    					    endforeach;	
    					 endif;
    					 
    			    endforeach;
    			 endif;
    		if($header_count == 1){
    		   fputcsv($file, $header); 
    		}
			fputcsv($file,$value); 
		    $header_count++;
			} 
			
		   fclose($file); 
		   exit; 
		endif;  
      
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
			 $page_data['model'] = $this->common_model;
            return view($this->fp."/view", $page_data);
		else:
			$this->session->setFlashdata('flash_message','Data not exist.');
            $this->session->setFlashdata('class','danger');
			return redirect()->to('admin/'.$this->mr);
		endif;
	}
	/* function to get sub categories on selection of category */
	public function getSubcategories(){
		   $parent_id = $this->request->getVar('parent_id');
		   $html = '';
		   $html_prior = '<option value="">Please select</option>';
		   $rows = $this->common_model->GetTableRows(CATEGORIES_TABLE,array('parent_id'=>$parent_id,'status' => '1'),array('title','asc'));
		   if(isset($rows ) && !empty($rows )):
		      foreach($rows as $row):
			    $total = $this->common_model->GetTotalCount(FORM_TABLE,array('sub_category_id' => $row['id']));
				if(!$total):
				 continue;
				endif;
				$selected = "";
				$html .= '<option value = "'.$row['id'].'" '.$selected.'  >'.$row['title'].'</option>';
              endforeach;
		    endif;
		  // $html_data = $this->common_modal->SelectDropdown(CATEGORIES_TABLE,'title','id','',array('parent_id'=>$parent_id));
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
