<?php

namespace UserModules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
	public function __construct()
	{
		$this->common_modal = new Common();
	}
	public function index()
	{
		$category_id = $this->request->getVar('category_id', FILTER_SANITIZE_STRING);
		$comission = 0;
		$user_id = $_SESSION['user_id'];
		$total_products = $this->common_modal->GetTotalCount(PRODUCTS_TABLE, array('user_id' => $_SESSION['user_id']));
		$total_stocks = $this->common_modal->GetTotalCount(STOCKS_TABLE, array('user_id' => $_SESSION['user_id']));

		$page_data['total_products'] = $total_products;
		$page_data['total_stocks'] = $total_stocks;

		$db = db_connect();
		$commission_sum = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where user_id = '$user_id'");
		if (!empty($commission_sum->getRowArray()['SUM(rental_income_for_partner)'])) :
			$comission = $commission_sum->getRowArray()['SUM(rental_income_for_partner)'];
		endif;


		//get top 10 products
		$top_ten_products_query = $db->query("SELECT DISTINCT product_id, (SELECT round(SUM(rental_income_for_partner),2) from tbl_stocks ts WHERE ts.product_id = tbl_stocks.product_id and user_id = '$user_id') as rental_income  FROM tbl_stocks where user_id = '$user_id' ORDER by rental_income desc limit 10;");
		$rows = $top_ten_products_query->getResultArray();	
		$page_data['categories'] = $this->common_modal->SelectDropdown(CATEGORIES_TABLE,'title','id',array($category_id),array('status' => 1,'parent_id'=>0));
		$page_data['comission_earned'] = round($comission);
		$page_data['top_ten_results'] = $rows;
		$page_data['model'] = $this->common_modal;
		echo view("\UserModules\Dashboard\Views\index", $page_data);
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('user');
	}

	public function upload()
	{
		$insert_id = 0;
		if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
			$file = $this->request->getFile('file');
			if (!$file->isValid()) {
				throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
			}
			$new_name = $file->getRandomName();
			$original_name = $file->getClientName();
			$type = $file->getClientMimeType();
			if ($file->isValid() && !$file->hasMoved()) {
				if ($file->move(ROOTPATH . 'uploads', $new_name)) {
					$data = array(
						'name' => $new_name,
						'original_name	' => $original_name,
						'mime_types	' => $type,
						'used	' => '0',
					);
					$insert_id = $this->common_modal->InsertTableData(MEDIA_TABLE, $data);
				}
			}
		}
		echo $insert_id;
	}


	//remove upload images during removal in dropzone 
	public function remove_upload_images()
	{
		if ($this->request->getPost('id')) {
			$id = $this->request->getPost('id');
			$row = $this->common_modal->GetSingleRow(MEDIA_TABLE, array('id' => $id));
			$filename = $row['name'];

			$upload_dir = dirname(APPPATH) . "/uploads";

			$file_to_delete = $upload_dir . '/' . $filename;

			$delete = $this->common_modal->DeleteTableData(MEDIA_TABLE, array('id' => $id));
			if ($delete) {
				//unlink files
				unlink($file_to_delete);
			}
			$json_data['status'] = "success";
		} else {
			$json_data['status'] = 'error';
		}
		echo json_encode($json_data);
		die();
	}

	//calculate current year retail values
	public function claculateRetailValue()
	{
		if ($this->request->isAJAX()) {
			$user_id = $_SESSION['user_id'];
			$retail_month = [];
			$retail_values = [];
			$category_id = $this->request->getVar('category', FILTER_SANITIZE_STRING);
			$db = db_connect();

			if ($_GET['data_to_be_filtered'] == "yearly") :
				for ($m = 1; $m <= 12; $m++) {
					$start_date = strtotime('01-' . $m . '-' . date('Y'));
					$end_date = strtotime(date("t-m-Y", $start_date));
					if(!empty($category_id)):
						$retail_value = $db->query("SELECT SUM(retail_value) FROM tbl_stocks where rented_on between '$start_date' and '$end_date' AND user_id = '$user_id' AND category_id='$category_id' ");
					else:
						$retail_value = $db->query("SELECT SUM(retail_value) FROM tbl_stocks where rented_on between '$start_date' and '$end_date' AND user_id = '$user_id'");
					endif;

					if (!empty($retail_value->getRowArray()['SUM(retail_value)'])) :
						$retail_values[] = $retail_value->getRowArray()['SUM(retail_value)'];
					else :
						$retail_values[] = 0;
					endif;
					$retail_month[] = date('M', $start_date);
				}
			elseif ($_GET['data_to_be_filtered'] == "monthly") :
				$end_date = strtotime(date("t-m-Y"));
				$start_date = $month = strtotime(date("01-m-Y", $end_date));
				while ($month <= $end_date) {
					$month_start_date = strtotime(date('01-m-Y', $month));
					$month_end_date = strtotime(date('t-m-Y', $month_start_date));

					$retail_value = $db->query("SELECT SUM(retail_value) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($retail_value->getRowArray()['SUM(retail_value)'])) :
						$retail_values[] = $retail_value->getRowArray()['SUM(retail_value)'];
					else :
						$retail_values[] = 0;
					endif;

					$retail_month[] = date('d', $month);
					$month = strtotime("+1 day", $month);
				}
			elseif($_GET['data_to_be_filtered'] =="previous-quarterly"): 
					$end_date = strtotime(get_dates_of_quarter('previous')['end']->format('d-m-Y'));
					$start_date =$month  = strtotime(get_dates_of_quarter('previous')['start']->format('d-m-Y'));

				while ($month <= $end_date) {
					$month_start_date = strtotime(date('01-m-Y', $month));
					$month_end_date = strtotime(date('t-m-Y', $month_start_date));

					$retail_value = $db->query("SELECT SUM(retail_value) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($retail_value->getRowArray()['SUM(retail_value)'])) :
						$retail_values[] = $retail_value->getRowArray()['SUM(retail_value)'];
					else :
						$retail_values[] = 0;
					endif;

					$retail_month[] = date('M', $month);
					$month = strtotime("+1 month", $month);
				}
			elseif($_GET['data_to_be_filtered'] =="current-quarterly"): 
					$end_date = strtotime(get_dates_of_quarter('current')['end']->format('d-m-Y'));
					$start_date =$month  = strtotime(get_dates_of_quarter('current')['start']->format('d-m-Y'));

				while ($month <= $end_date) {
					$month_start_date = strtotime(date('01-m-Y', $month));
					$month_end_date = strtotime(date('t-m-Y', $month_start_date));

					$retail_value = $db->query("SELECT SUM(retail_value) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($retail_value->getRowArray()['SUM(retail_value)'])) :
						$retail_values[] = $retail_value->getRowArray()['SUM(retail_value)'];
					else :
						$retail_values[] = 0;
					endif;

					$retail_month[] = date('M', $month);
					$month = strtotime("+1 month", $month);
				}
			endif;

			$json_data['retail_month'] = $retail_month;
			$json_data['retail_values'] = $retail_values;
			$json_data['status'] = "success";
		}
		echo json_encode($json_data);
		die();
	}

	//calculate current year income rental value
	public function claculateRentalTransaction()
	{
		if ($this->request->isAJAX()) {
			$user_id = $_SESSION['user_id'];
			$rental_month = [];
			$rental_values_admin = [];
			$rental_values_partners = [];
			$category_id = $this->request->getVar('category', FILTER_SANITIZE_STRING);
			
			
			$db = db_connect();
			if ($_GET['data_to_be_filtered'] == "yearly") :
				for ($m = 1; $m <= 12; $m++) {
					$start_date = strtotime('01-' . $m . '-' . date('Y'));
					$end_date = strtotime(date("t-m-Y", $start_date));

					$rental_value_admin = $db->query("SELECT SUM(rental_income_for_admin) FROM tbl_stocks where rented_on between '$start_date' and '$end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)'])) :
						$rental_values_admin[] = round($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)']);
					else :
						$rental_values_admin[] = 0;
					endif;
					if(!empty($category_id)):
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$start_date' and '$end_date' AND user_id = '$user_id' and category_id='$category_id' ");
					else:
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$start_date' and '$end_date' AND user_id = '$user_id'");
					endif;
					//$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$start_date' and '$end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)'])) :
						$rental_values_partners[] = round($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)']);
					else :
						$rental_values_partners[] = 0;
					endif;

					$rental_month[] = date('M', $start_date);
				}
			elseif ($_GET['data_to_be_filtered'] == "monthly") :
				$end_date = strtotime(date("t-m-Y"));
				$start_date = $month = strtotime(date("01-m-Y", $end_date));
				while ($month <= $end_date) {
					$month_start_date = strtotime(date('01-m-Y', $month));
					$month_end_date = strtotime(date('t-m-Y', $month_start_date));

					$rental_value_admin = $db->query("SELECT SUM(rental_income_for_admin) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)'])) :
						$rental_values_admin[] = round($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)']);
					else :
						$rental_values_admin[] = 0;
					endif;

					if(!empty($category_id)):
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id' and category_id='$category_id' ");
					else:
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					endif;
					//$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)'])) :
						$rental_values_partners[] = round($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)']);
					else :
						$rental_values_partners[] = 0;
					endif;

					$rental_month[] = date('d', $month);
					$month = strtotime("+1 day", $month);
				}
			elseif($_GET['data_to_be_filtered'] =="previous-quarterly"): 
					$end_date = strtotime(get_dates_of_quarter('previous')['end']->format('d-m-Y'));
					$start_date =$month  = strtotime(get_dates_of_quarter('previous')['start']->format('d-m-Y'));

				while ($month <= $end_date) {
					$month_start_date = strtotime(date('01-m-Y', $month));
					$month_end_date = strtotime(date('t-m-Y', $month_start_date));

					$rental_value_admin = $db->query("SELECT SUM(rental_income_for_admin) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)'])) :
						$rental_values_admin[] = round($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)']);
					else :
						$rental_values_admin[] = 0;
					endif;

					if(!empty($category_id)):
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id' and category_id='$category_id' ");
					else:
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					endif;

					//$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)'])) :
						$rental_values_partners[] = round($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)']);
					else :
						$rental_values_partners[] = 0;
					endif;

					$rental_month[] = date('M', $month);
					$month = strtotime("+1 month", $month);
				}
			elseif($_GET['data_to_be_filtered'] =="current-quarterly"): 
					$end_date = strtotime(get_dates_of_quarter('current')['end']->format('d-m-Y'));
					$start_date =$month  = strtotime(get_dates_of_quarter('current')['start']->format('d-m-Y'));

				while ($month <= $end_date) {
					$month_start_date = strtotime(date('01-m-Y', $month));
					$month_end_date = strtotime(date('t-m-Y', $month_start_date));

					$rental_value_admin = $db->query("SELECT SUM(rental_income_for_admin) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)'])) :
						$rental_values_admin[] = round($rental_value_admin->getRowArray()['SUM(rental_income_for_admin)']);
					else :
						$rental_values_admin[] = 0;
					endif;

					if(!empty($category_id)):
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id' and category_id='$category_id' ");
					else:
						$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					endif;

					//$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where rented_on between '$month_start_date' and '$month_end_date' AND user_id = '$user_id'");
					if (!empty($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)'])) :
						$rental_values_partners[] = round($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)']);
					else :
						$rental_values_partners[] = 0;
					endif;

					$rental_month[] = date('M', $month);
					$month = strtotime("+1 month", $month);
				}
			endif;

			$json_data['rental_month'] = $rental_month;
			$json_data['rental_values_admin'] = $rental_values_admin;
			$json_data['rental_values_partners'] = $rental_values_partners;
			$json_data['status'] = "success";
		}
		echo json_encode($json_data);
		die();
	}


//calculate category  data
	public function CalculateCategoryPie()
	{
		if ($this->request->isAJAX()) {
			$user_id = $_SESSION['user_id'];
			$category_name = [];
			$rental_income = [];
			$percentage = [];
			$total_members = 0;
            $db = db_connect();
			$categories = $this->common_modal->GetTableRows(CATEGORIES_TABLE, array('status' => 1));
			if (count($categories)) :
				foreach ($categories as $key => $category) :
					$category_name[] = ucfirst($category['title']);
					$category_id = $category['id'];
					$rental_value_partner = $db->query("SELECT SUM(rental_income_for_partner) FROM tbl_stocks where  user_id = '$user_id' and category_id='$category_id'");
					$rental_income_amount = round($rental_value_partner->getRowArray()['SUM(rental_income_for_partner)']);
					$rental_income[] = $rental_income_amount;
				    endforeach;
				 if (count($rental_income)) :
					$total_rental_income = round(array_sum($rental_income));
				endif;

				$json_data['rental_income'] = $rental_income;
				$json_data['category_name'] = $category_name;
				$json_data['total_rental_income'] = round($total_rental_income);
				$json_data['status'] = "success";
			else :
				$json_data['status'] = "error";
			endif;
		}
		echo json_encode($json_data);
		die();
	}
	
	//calculate membership data
	public function CalculateMembershipPie()
	{
		if ($this->request->isAJAX()) {
			$user_id = $_SESSION['user_id'];
			$members = [];
			$membership_plan_name = [];
			$total_members = 0;
			if ($_GET['data_to_be_filtered'] == "yearly") :
				$start_date = strtotime(date('01-m-Y', strtotime('first day of january this year')));
				$end_date = strtotime(date("t-m-Y", strtotime('last day of december this year')));
			elseif ($_GET['data_to_be_filtered'] == "monthly") :
				$end_date = strtotime(date("t-m-Y"));
				$start_date = $month = strtotime(date("01-m-Y", $end_date));
			elseif ($_GET['data_to_be_filtered'] == "previous-quarterly") :
				$end_date = strtotime(get_dates_of_quarter('previous')['end']->format('d-m-Y'));
				$start_date =$month  = strtotime(get_dates_of_quarter('previous')['start']->format('d-m-Y'));
			elseif($_GET['data_to_be_filtered'] =="current-quarterly"): 
				$end_date = strtotime(get_dates_of_quarter('current')['end']->format('d-m-Y'));
				$start_date =$month  = strtotime(get_dates_of_quarter('current')['start']->format('d-m-Y'));
			endif;

			$memberships = $this->common_modal->GetTableRows(MEMBERSHIP_TABLE, array('status' => 1));

			if (count($memberships)) :
				foreach ($memberships as $key => $membership) :
					$membership_plan_name[] = ucfirst($membership['title']);
					$m_id = $membership['id'];
					$members[] = $this->common_modal->GetTotalCount(STOCKS_TABLE, "(rented_on between '$start_date' and '$end_date') and membership_id = '$m_id'  ");
				endforeach;

				if (count($members)) :
					$total_members = array_sum($members);
				endif;

				$json_data['members'] = $members;
				$json_data['membership_plan_name'] = $membership_plan_name;
				$json_data['total_members'] = $total_members;
				$json_data['status'] = "success";
			else :
				$json_data['status'] = "error";
			endif;
		}
		echo json_encode($json_data);
		die();
	}
}
