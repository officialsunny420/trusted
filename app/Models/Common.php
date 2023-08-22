<?php
/* 
	* Author: Subhash Shipu
	* Email: provider.nexus@gmail.com
	* Skype: provider.nexus@gmail.com
 */
namespace App\Models;
use CodeIgniter\Model;

class Common extends Model
{
	protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }
	
	public function GetSingleRow($table,$where=null,$order = array('id','desc'))
	{
        $builder = $this->db->table($table);
        if(!empty($where))
        {
            $builder->where($where);
        }
        if(is_array($order))
        {
            $builder->orderBy($order[0],$order[1]);
        }
        return $builder->get()->getRowArray();
	}

	public function GetNextPreRow($table,$where=null,$type="next")
	{
		$builder = $this->db->table($table);
        if(!empty($where))
        {
            $builder->where($where);
        }
        $query = $builder->get();
        $data['next'] = $query->getNextRow('array');
        $data['pre'] = $query->getPreviousRow('array');
        return $data;
	}

    /* Function used to get table rows  */
    public function GetTableRows($table,$where=null,$order='',$limit_perpage=0,$offset=0)
    {
        $builder = $this->db->table($table);
        if(!empty($where))
        {
            $builder->where($where);
        }
        if(is_array($order))
        {
            $builder->orderBy($order[0],$order[1]);
        }
        if(!empty($limit_perpage) )
        {
            $builder->limit($limit_perpage, $offset);
        }
		
        return $builder->get()->getResultArray();
    }

    /* Function used to get single value from table */
    public function GetSingleValue($table,$select,$where)
    {
        $builder =$this->db->table($table);
      
        $builder->select($select);
        $builder->where($where);
        $builder->limit(1);
        $query = $builder->get();
        $builder->resetQuery();
        $arr = $query->getRowArray();
        if($arr)
        {
           if(empty($arr)){
                return false;
            }
            return $query->getRowArray()[$select];
        }
        else
        {
            return false;
        }
    }
	
	/* Get the selected fields from table */
	public function GetSelectedFields($table,$fields,$where=null)
	{
		$builder =$this->db->table($table);
		if(!empty($where))
		{
			 $builder->where($where);
		}
		if(!empty($fields)) 
		{
			$builder->select($fields);
		}
		$builder->orderBy('id', 'desc');
		$result = $builder->get()->getResultArray();
		return $result;
	}
	
    /* update table row */
	public function UpdateTableData($table,$data,$where)
    {
        $builder = $this->db->table($table);
        if($where)
        {
            $builder->where($where);
        }
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false ;
        }
    }

    /* insert data into table */
    public function InsertTableData($table,$data)
    {
        $builder =$this->db->table($table);
        if($builder->insert($data))
        {
            $insert_id = $this->db->insertID();
            return  $insert_id;
        }
        else 
        {
            return false ;
        }
    }
    /* insert multiple data into table */
    public function InsertMultipleData($table,$data)
    {
        $builder =$this->db->table($table);
        if($builder->insertBatch($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /* delete row  */
	public function DeleteTableData($table,$where)
    {
        $builder = $this->db->table($table);
        if($where)
        {
            $builder->where($where);
        }
        if($builder->delete())	
        {
            return true ;
        }
        else
        {
            return false ;
        }
    }

    /* Get media data */
    public function getMediaData($id){
        $json_data['media_src']='';
        $json_data['original_name']='';
        $file = $this->GetSingleRow(MEDIA_TABLE,array('id'=>$id));
		if(!empty($file)):
			$file_name = $file['name'];
			$json_data['name'] = $file['name'];
			$json_data['original_name'] = $file['original_name'];
			if(!empty($file_name)):
				if(file_exists(FCPATH."uploads/".$file_name)):
					$media_src = base_url('/uploads/'.$file_name.'');
					$json_data['media_src'] = $media_src;
				endif; 
			endif;
        endif;
        return json_encode($json_data);
    }
	
    /* Get total counts  */
    public function GetTotalCount($table,$where="")
    {
        $builder = $this->db->table($table);
        if($where)
        {
            $builder->where($where);
        }
        return $builder->countAllResults();
    }
/* FUNCTION USED TO SEND EMAIL ; */
    public function SendEmail($to, $from, $subject, $message)
    {
        $black_list = array('::1', '127.0.0.1'); // GRAB THE LOCALHOST IP ADDRESS
        if (!in_array($_SERVER['REMOTE_ADDR'], $black_list)) // CHECK IF NOT LOCALHOST
        {
            $email = \Config\Services::email();
            $email->setFrom('noreply@mytrustedtrades.com',"Trusted Trades");
            $email->setTo($to);

            $email->setSubject($subject);
            $email->setMessage($message);

            //Send mail 
            if ($email->send()) // if successfully send 
            {
                return true;
            } else {
                return false;
            }
        }
    }
    /* Select dropdown */
    public function SelectDropdown($table,$option,$field,$value=array(),$where="",$extra_field = '',$order='') // selected
    {
        $html ="";
        $builder = $this->db->table($table);
        if(!empty($where))
        {
            $builder->where($where);
        }
        if(is_array($order))
        {
            $builder->orderBy($order[0],$order[1]);
        }
        $rows = $builder->get()->getResultArray();
        foreach($rows as $row)
        {
            $selected = "";
            if(is_array($value))
            {
                if(in_array($row[$field],$value))
                {
                    $selected = "selected";
                }
            }
            $efield = '';
            if(!empty($extra_field))
            {
                $efield = $row[$extra_field];
            }
            $html .= '<option value = "'.$row[$field].'" '.$selected.' extra_field = "'.$efield.'" >'.$row[$option].'</option>';
        }
        return $html;
    }
    
}
