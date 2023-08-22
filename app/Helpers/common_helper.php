<?php
/* 
Author: Subhash Shipu
Email: provider.nexus@gmail.com
Website: https://www.nexustechies.com
*/
	function check_isset($key,$array)
	{
		$value = "";
		if(isset($array[$key]))
		{
			$value = $array[$key];
		}
		return $value;
	}
	
	function check_checkbox($first,$second)
	{
		$checked= "";
		if($first == $second) { $checked="checked"; }
		return $checked;
	}
	
	function selected_select($first,$second)
	{
		$selected= "";
		if($first == $second) { $selected="selected"; }
		return $selected;
	}
	
    function header_csv($selected = '',$text = ''){
	$array = [
		'date_created' => ['label' => 'Date Created', 'key' => '1'],
		'category' => ['label' => 'Category', 'key' => '2'],
		'sub_category' => ['label' => 'Sub Category', 'key' => '3'],
		'whenwouldyoulikethejobtostart' => ['label' => 'Job Start Date', 'key' => '4'],
		'developmentstage' => ['label' => 'Development Stage', 'key' => '5'],
		'firstname' => ['label' => 'First Name', 'key' => '6'],
		'lastname' => ['label' => 'Surname', 'key' => '7'],
		'email' => ['label' => 'Email', 'key' => '8'],
		'emailallcommunicationswillbesenthere' => ['label' => 'Email', 'key' => '8'],
		'mobilenumberpreferred' => ['label' => 'Mobile Number', 'key' => '9'],
		'mobile' => ['label' => 'Mobile Number', 'key' => '9'],
		'address' => ['label' => 'Address ', 'key' => '10'],
		'address2' => ['label' => 'Address 2', 'key' => '10'],
		'town' => ['label' => 'Town', 'key' => '11'],
		'country' => ['label' => 'Country', 'key' => '12'],
		'postcode' => ['label' => 'Postcode', 'key' => '13'],
		'country' => ['label' => 'Budget', 'key' => '14'],
		'descriptionofworks' => ['label' => 'Description of Works', 'key' => '15'],
	];

	if ($selected != "") {
		if (isset($array[$selected])) :
			return $array[$selected];
		else :
			return '';
		endif;
	} else {
		return $array;
	}
}
	function hear_about_from($selected=""){
		$array = array(
			'1' => 'Newspaper',
			'2' => 'Leaflet',
			'3' => 'Friend',
			'4' => 'Google',
			'5' => 'A19 road banner',
			'6' => 'Facebook',
			'7' => 'Instagram',
			'8' => 'Twitter',
			'9' => 'Other',
		);
		if(!empty($selected)){
			return $array[$selected];
		}
		else{
			return $array;
		}
	}
	
	//for field_types
	function field_types($selected=""){
		$array = array(
			'1' => 'text',
			'2' => 'checkbox',
			'3' => 'email',
			'4' => 'file',
			'5' => 'number',
			'6' => 'radio',
			'7' => 'select',
			'8' => 'textarea',
			'9' => 'postcode',
			'10' => 'firstnametype',
			'11' => 'lastnametype',
			'12' => 'phonenumber',
			'13' => 'Other',
		);
		if(!empty($selected)){
			return $array[$selected];
		}
		else{
		  return $array[1];
		}
	}
	//
	//for size
	function size_types($selected=""){
		$array = array(
			'1' => 'Small',
			'2' => 'Medium',
			'3' => 'Large',
			'4' => 'Other',
		);
		if(!empty($selected)){
			return $array[$selected];
		}
		else{
			return $array;
		}
		
	}
	/* clean url  */
	function clean($string,$symbol="-") 
	{
	   $string = str_replace(' ', $symbol, $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		
	   return preg_replace('/-+/', $symbol, strtolower($string)); // Replaces multiple hyphens with single one.
	}
	/* clean clean_header  */
	function clean_header($string,$symbol="") 
	{
	   $string = str_replace(' ', $symbol, $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		
	   return preg_replace('/-+/', $symbol, strtolower($string)); // Replaces multiple hyphens with single one.
	}
	function acronym( $string = '' ) {
		$words = explode(' ', $string);
		if ( ! $words ) {
			return false;
		}
		$result = '';
		foreach ( $words as $word ) $result .= $word[0];
		return strtoupper( $result );
	}
	
	function slug($string, $spaceRepl = "-")
	{
		$string = str_replace("&", "and", $string);
		$string = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
		$string = strtolower($string);
		$string = preg_replace("/[ ]+/", " ", $string);
		$string = str_replace(" ", $spaceRepl, $string);
		return $string;
	}
	function format_number($n, $point='.', $sep=',') {
		if ($n < 0) {
			return 0;
		}
	
		if ($n < 10000) {
			return number_format($n, 0, $point, $sep);
		}
	
		$d = $n < 1000000 ? 1000 : 1000000;
	
		$f = round($n / $d, 1);
	
		return number_format($f, $f - intval($f) ? 1 : 0, $point, $sep) . ($d == 1000 ? 'k' : 'M');
	
	}
	
	
	/* Get currency code */
	function get_currency_code($currency="aed")
	{
		$currency_code = "";
		if($currency="aed")
		{
			$currency_code = "&#x62f;&#x2e;&#x625;";
		}
		return $currency_code;
	}
	
	function _p($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	function time_ago_days($expirationDate)
	{
		$toDay = strtotime(date('Y-m-d H:i:s'));
		$difference = abs($toDay - $expirationDate);
		$days = floor($difference / 86400);
		$hours = floor(($difference - $days * 86400) / 3600);
		$minutes = floor(($difference - $days * 86400 - $hours * 3600) / 60);
		$seconds = floor($difference - $days * 86400 - $hours * 3600 - $minutes * 60);

		//echo "{$days} days {$hours} hours {$minutes} minutes {$seconds} seconds";
		if($days > 0){
			return "{$days} days {$hours} hours ago";
		}
		if($hours > 0)
		{
			return "{$hours} hours {$minutes} minutes ago";
		}
		if($hours < 1){
			return "{$minutes} minutes ago";
		}

	}
	
	/* Time ago  */
	function Timeago( $time )
	{
		$time_difference = time() - $time;

		if( $time_difference < 1 ) { return 'less than 1 second ago'; }
		$condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
					30 * 24 * 60 * 60       =>  'month',
					24 * 60 * 60            =>  'day',
					60 * 60                 =>  'hour',
					60                      =>  'minute',
					1                       =>  'second'
		);

		foreach( $condition as $secs => $str )
		{
			$d = $time_difference / $secs;

			if( $d >= 1 )
			{
				$t = round( $d );
				return  $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
			}
		}
	}
	
	/* Get file mime type */
	function get_file_type($filename) {
		if(empty($filename))
		{
			return "";
		}
		$mime_types = array(

			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',

			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',

			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',

			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',

			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',

			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);
		$explode = explode('.',$filename);
		$ext = strtolower(array_pop($explode));
		
		if (array_key_exists($ext, $mime_types)) {
			return $mime_types[$ext];
		}
		elseif (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$mimetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			return $mimetype;
		}
		else {
			return 'application/octet-stream';
		}	
	}

	function number_format_without_zeroindecimal($number, $maxdecimal=2, $dec_point='.', $thousands_sep=','){
		if($dec_point==$thousands_sep){
			trigger_error('2 parameters for ' . __METHOD__ . '() have the same value, that is "' . $dec_point . '" for $dec_point and $thousands_sep', E_USER_WARNING);
			// It corresponds "PHP Warning:  Wrong parameter count for number_format()", which occurs when you use $dec_point without $thousands_sep to number_format().
		}
		$decimals = strlen(substr(strrchr(round($number,$maxdecimal), "."), 1));
	
		return number_format($number, $decimals, $dec_point, $thousands_sep);
	}
	
	function money_format_india($amount=1000.00) {
		setlocale(LC_MONETARY, 'en_IN');
		$amount = money_format('%!i', $amount);
		return $amount;	
	}

	if ( ! function_exists( 'money_format' ) ) {

		function money_format($format, $number)
		{
			$regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
					  '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
			if (setlocale(LC_MONETARY, 0) == 'C') {
				setlocale(LC_MONETARY, '');
			}
			$locale = localeconv();
			preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
			foreach ($matches as $fmatch) {
				$value = floatval($number);
				$flags = array(
					'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
								   $match[1] : ' ',
					'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
					'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
								   $match[0] : '+',
					'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
					'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
				);
				$width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
				$left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
				$right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
				$conversion = $fmatch[5];
		
				$positive = true;
				if ($value < 0) {
					$positive = false;
					$value  *= -1;
				}
				$letter = $positive ? 'p' : 'n';
		
				$prefix = $suffix = $cprefix = $csuffix = $signal = '';
		
				$signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
				switch (true) {
					case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
						$prefix = $signal;
						break;
					case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
						$suffix = $signal;
						break;
					case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
						$cprefix = $signal;
						break;
					case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
						$csuffix = $signal;
						break;
					case $flags['usesignal'] == '(':
					case $locale["{$letter}_sign_posn"] == 0:
						$prefix = '(';
						$suffix = ')';
						break;
				}
				if (!$flags['nosimbol']) {
					$currency = $cprefix .
								($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
								$csuffix;
				} else {
					$currency = '';
				}
				$space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';
		
				$value = number_format($value, $right, $locale['mon_decimal_point'],
						 $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
				$value = @explode($locale['mon_decimal_point'], $value);
		
				$n = strlen($prefix) + strlen($currency) + strlen($value[0]);
				if ($left > 0 && $left > $n) {
					$value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
				}
				$value = implode($locale['mon_decimal_point'], $value);
				if ($locale["{$letter}_cs_precedes"]) {
					$value = $prefix . $currency . $space . $value . $suffix;
				} else {
					$value = $prefix . $value . $space . $currency . $suffix;
				}
				if ($width > 0) {
					$value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
							 STR_PAD_RIGHT : STR_PAD_LEFT);
				}
		
				$format = str_replace($fmatch[0], $value, $format);
			}
			return $format;
		  }
		}
	
	function random_password($length=8) {
		$alphabet = "abcdefghijklmnopqrstuwxyz0123456789@#$";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	
	function secure_string( $string, $action = 'e' ) {
		$secret_key = '123654zxcvbnm';
		$secret_iv = 'qazxswedc!@#$#@!';
	 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
		if( $action == 'e' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'd' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
		return $output;
	}


	//  functions only for this website 

	function meta_data($data=array()){
		
	}
	
	
	// get profile media data
	function getProfileMediaData($id)
	{
		$json_data['logged_in_user_name'] ='';
		$json_data['media_src']='';
        $json_data['original_name']='';
		$db = \Config\Database::connect();
		
		//users table 
		$user_builder = $db->table('tbl_users');
		$user_output = $user_builder->where('id',$id)->select('media_id,name')->get();
		
		//if not empty users table data
		if(!empty($user_output->getRowArray())):   
		
			$json_data['logged_in_user_name'] = $user_output->getRowArray()['name']; //get current user name
			$profile_media_id = $user_output->getRowArray()['media_id']; //get users's media id from users 
			
			//placeholder image 
		    $json_data['media_src'] = "https://via.placeholder.com/60//fff?text=".ucfirst(substr($user_output->getRowArray()['name'] , 0 , 1 ));
			
			//media table
			$builder = $db->table('tbl_media');
			$output = $builder->where('id',$profile_media_id)->select('name,original_name')->get();
			
			$file = $output->getRowArray();
		    
			//if media data is not empty
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
		
		endif;
		
		
        return json_encode($json_data);
	}
