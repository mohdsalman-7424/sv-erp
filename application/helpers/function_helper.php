<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('is_adminprotected')) {

    function is_adminprotected() {
        $CI = &get_instance();
        if ($CI->session->userdata('isLogin') == 'yes') {

            return true;

        } else {
            redirect('admin/auth');
        }
    }

}


if (!function_exists('_sendmailwithphpmailer_nss'))
 {
    function _sendmailwithphpmailer_nss()
	{
        $CI = &get_instance();
        $CI->load->library('sendmail');
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = ''; // secure transfer enabled REQUIRED for GMail
        $mail->Host = "";


        $mail->Port = 25; // or 587
        $mail->IsHTML(true);
		$mail->Username = "";
        $mail->Password = "";
        $mail->setFrom('', 'NSS');
        $mail->Subject = "tehs";

		$mail->Body = "hello";
		$mail->AddAddress('sham@yopmail.com');



		if($mail->Send())
		{
             return TRUE;
		}
		else
		{
			return FALSE;
		}
    }
}

if (!function_exists('product_name_varient_id')) {

    function product_name_varient_id($varient_id) {
        $CI = &get_instance();
        $CI->db->select('PRODUCT.product_name');
        $CI->db->join("tbl_product as PRODUCT",'PRODUCT.product_id=TBL_P.product_id');
        $CI->db->where('TBL_P.id',$varient_id);
        $results = $CI->db->get('tbl_product_price as TBL_P')->row();
        return $results->product_name;
    }

}

if (!function_exists('get_substitute_product_data')) {

    function get_substitute_product_data($substitute_id) {


        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id',$substitute_id);
        $CI->db->order_by('id','desc');
        $result = $CI->db->get('tbl_product_price')->row();
        $product_id = $result->product_id;
        if(!empty($product_id)){
            $CI->db->select('*');
            $CI->db->where('product_id',$product_id);
            $CI->db->order_by('product_id','desc');
            $product = $CI->db->get('tbl_product')->row();
        }
        $result->product = $product;
        return $result;
    }

}

if (!function_exists('get_status')) {

    function get_status($order_id='',$id='',$item_type='') {


        $CI = &get_instance();
        $CI->db->select('status');
        $CI->db->where('order_id',$order_id);
        $CI->db->where('basket_combo_id',$id);
        $CI->db->where('item_type',$item_type);
        $result = $CI->db->get('tbl_order_detail')->row();
        if(!empty($result)){
            return $result->status;
        }else{
            return false;
        }
    }
}


if (!function_exists('get_reason')) {

    function get_reason($order_id='',$id='',$item_type='') {


        $CI = &get_instance();
        $CI->db->select('reason');
        $CI->db->where('order_id',$order_id);
        $CI->db->where('basket_combo_id',$id);
        $CI->db->where('item_type',$item_type);
        $result = $CI->db->get('tbl_order_detail')->row();
        if(!empty($result)){
            return $result->reason;
        }else{
            return false;
        }
    }
}


if (!function_exists('get_delivery_boy_name')) {

    function get_delivery_boy_name($delivery_boy_id) {

        $CI = &get_instance();
        $CI->db->select('first_name,last_name,email,mobile_number');
        $CI->db->where('id',$delivery_boy_id);
        $results = $CI->db->get('tbl_delivery_boys')->row();
        $name = $results->first_name.' '.$results->last_name;
        if($name){
            return $name;
        }else{
            return false;
        }
    }
}

if (!function_exists('get_delivery_boy')) {

    function get_delivery_boy($delivery_boy_id) {

        $CI = &get_instance();
        $CI->db->select('first_name,last_name,email,mobile_number');
        $CI->db->where('id',$delivery_boy_id);
        return $CI->db->get('tbl_delivery_boys')->row();
    }
}

if (!function_exists('get_picker_name')) {

    function get_picker_name($delivery_boy_id) {

        $CI = &get_instance();
        $CI->db->select('first_name,last_name');
        $CI->db->where('id',$delivery_boy_id);
        $results = $CI->db->get('tbl_pickers')->row();
        $name = $results->first_name.' '.$results->last_name;
        if($name){
            return $name;
        }else{
            return false;
        }
    }
}

if (!function_exists('get_delivery_boy')) {

    function get_picker_boy($delivery_boy_id) {

        $CI = &get_instance();
        $CI->db->select('first_name,last_name,email,mobile_number');
        $CI->db->where('id',$delivery_boy_id);
        return $CI->db->get('tbl_delivery_boys')->row();
    }
}

function __get_distance($store_coordinates='', $addr_coordinates='')
{
    $km = 0.00;
    $CI = &get_instance();
    // $store_coordinates = $user_preference->store_coordinates;
    // $addr_coordinates = $user_preference->customer_coordinates;

    if(!empty($store_coordinates) && !empty($addr_coordinates))
    {
        /*get store coard*/
        $store_coordinates = explode(",", $store_coordinates);
        $lat1 = trim($store_coordinates[0]);
        $lon1 = trim($store_coordinates[1]);
        /*get store coard*/

        /*get addr coard*/
        $addr_coordinates = explode(",", $addr_coordinates);
        $lat2 = trim($addr_coordinates[0]);
        $lon2 = trim($addr_coordinates[1]);
        /*get addr coard*/

        /*calculate distance in km*/
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
        /*calculate distance in km*/
    }
    return number_format($km,2,'.','');
}

function get_distance($user_id = '')
{
    $km = 0;
    $CI = &get_instance();
    if($user_id != ''){
        $CI->load->model('User_preference');
        $user_preference = $CI->User_preference->getUserPreferences_api($user_id);
    }else{
        $user_preference = $CI->session->userdata('user_preference');
    }

    // $store_id = $user_preference->order_preference_store;
    // $addr_id = $user_preference->order_preference_address;
    $store_coordinates = isset($user_preference->store_coordinates) ? $user_preference->store_coordinates : '';
    $addr_coordinates = isset($user_preference->customer_coordinates) ? $user_preference->customer_coordinates : '';

    if(!empty($store_coordinates) && !empty($addr_coordinates))
    {
        /*get store coard*/
        $store_coordinates = explode(",", $store_coordinates);
        $lat1 = trim($store_coordinates[0]);
        $lon1 = trim($store_coordinates[1]);
        /*get store coard*/

        /*get addr coard*/
        $addr_coordinates = explode(",", $addr_coordinates);
        $lat2 = trim($addr_coordinates[0]);
        $lon2 = trim($addr_coordinates[1]);
        /*get addr coard*/

        /*calculate distance in km*/
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
        /*calculate distance in km*/
    }
    return $km;
}

function get_distance_modified($store_coordinates = '', $addr_coordinates = '')
{
    $km = 0;
    $CI = &get_instance();

    if(!empty($store_coordinates) && !empty($addr_coordinates))
    {
        /*get store coard*/
        $store_coordinates = explode(",", $store_coordinates);
        $lat1 = trim($store_coordinates[0]);
        $lon1 = trim($store_coordinates[1]);
        /*get store coard*/

        /*get addr coard*/
        $addr_coordinates = explode(",", $addr_coordinates);
        $lat2 = trim($addr_coordinates[0]);
        $lon2 = trim($addr_coordinates[1]);
        /*get addr coard*/

        /*calculate distance in km*/
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
        /*calculate distance in km*/
    }
    return $km;
}


function get_shipping_charge($distanceinkm='', $amount='')
{

	if($_SESSION['user_preference']->order_type==1)
	{
		return 0;
	}
	elseif($distanceinkm=='')
	{
		return 0;
	}
	elseif(!$amount>0)
	{
		return 0;
	}
	$CI   = & get_instance();
    $data ='';
    $shiping_charge = 0;
    $sql  = "SELECT * FROM tbl_shiping WHERE $distanceinkm BETWEEN distancefrom AND distanceto AND status = 1 ORDER BY  distancefrom ASC LIMIT 1";
    $query = $CI->db->query($sql);
    if($query->num_rows() > 0){
        $data = $query->result_array();
	    foreach ($data as $key => $value) {
	    	// pr($value);
	    	if(!empty($value['price']) && !empty($value['order_amount_from']) && !empty($value['order_amount_to']))
	    	{
		    	$order_amount_from = explode("~", $value['order_amount_from']);
		    	$order_amount_to = explode("~", $value['order_amount_to']);
	    		$prices = explode("~", $value['price']);
	    		asort($order_amount_from);
	    		asort($order_amount_to);
	    		// asort($prices);
	    		// echo "$amount";
		    	// pr($order_amount_from);
		    	// pr($order_amount_to);
		    	// pr($prices);
		    	foreach ($order_amount_from as $key => $amountfrom) {
                $no_shipping_found = false;

		    		// echo $order_amount_to[$key]."<br>";
		    		if($shiping_charge==0)
		    		{
			    		if($amount >= $amountfrom && $amount <= $order_amount_to[$key])
			    		{
			    			$shiping_charge = $prices[$key];

			    			//echo "Shiping charge: Rs.".$prices[$key]."<br>";
			    		}
                        else
                        {
                            $no_shipping_found = true;
                        }
		    		}

		    	}
	    	}
	    	else
	    	{
	    		// No relevant shiping charge found. Default shiping charge apply
	    		$shiping_charge = $CI->dbsettings->default_shipping_charge;
	    		// echo "No relevant shiping charge found!";
	    	}
	    }
    }
    else
    {
    	// No shiping charge found. Default shiping charge apply
    	$shiping_charge = $CI->dbsettings->default_shipping_charge;
    	// echo "No shiping charge found";
    }
   	// pr($no_shipping_found);die;
    $shiping_charge = $no_shipping_found?$CI->dbsettings->default_shipping_charge:$shiping_charge;
    return $shiping_charge;
}

function get_shipping_charge_backend($distanceinkm='',$amount='')
{
    // echo "-- $distanceinkm";
     //pr($_SESSION['user_preference']);
    // pr($amount);
    if($distanceinkm=='' && $distanceinkm==0)
	{
		return 0;
	}
	elseif(!$amount>0)
	{
		return 0;
	}
	$CI   = & get_instance();
    $data ='';
    $shiping_charge = 0;
    $sql  = "SELECT * FROM tbl_shiping WHERE $distanceinkm BETWEEN distancefrom AND distanceto AND status = 1 ORDER BY  distancefrom ASC LIMIT 1";
    $query = $CI->db->query($sql);
    if($query->num_rows() > 0){
        $data = $query->result_array();
	    foreach ($data as $key => $value) {
	    	// pr($value);
	    	if(!empty($value['price']) && !empty($value['order_amount_from']) && !empty($value['order_amount_to']))
	    	{
		    	$order_amount_from = explode("~", $value['order_amount_from']);
		    	$order_amount_to = explode("~", $value['order_amount_to']);
	    		$prices = explode("~", $value['price']);
	    		asort($order_amount_from);
	    		asort($order_amount_to);
	    		// asort($prices);
	    		// echo "$amount";
		    	// pr($order_amount_from);
		    	// pr($order_amount_to);
		    	// pr($prices);

		    	foreach ($order_amount_from as $key => $amountfrom) {

		    		// echo $order_amount_to[$key]."<br>";
		    		if($shiping_charge==0)
		    		{
			    		if($amount >= $amountfrom && $amount <= $order_amount_to[$key])
			    		{
			    			$shiping_charge = $prices[$key];

			    			// echo "Shiping charge: Rs.".$prices[$key]."<br>";
			    		}
		    		}
		    	}
	    	}
	    	else
	    	{
	    		// No relevant shiping charge found. Default shiping charge apply
	    		$shiping_charge = $CI->dbsettings->default_shipping_charge;
	    		// echo "No relevant shiping charge found!";
	    	}
	    }
    }
    else
    {
    	// No shiping charge found. Default shiping charge apply
    	$shiping_charge = $CI->dbsettings->default_shipping_charge;
    	// echo "No shiping charge found";
    }
   	// pr($data);die;
    return $shiping_charge;
}


function get_shipping_minimum_order($distanceinkm = '5', $amount = '501')
{
	if( empty($distanceinkm) || empty($amount))
	{
		return $CI->dbsettings->DEFAULT_MINIMUM_ORDER_AMOUNT_LIMIT;
	}

	$CI   			= & get_instance();
    $data 			= '';
    $from_amount = 0;
    $sql  			= "SELECT * FROM tbl_shiping WHERE $distanceinkm BETWEEN distancefrom AND distanceto AND status = 1 ORDER BY  distancefrom ASC LIMIT 1";
    $query 			= $CI->db->query($sql);
    if($query->num_rows() > 0){
        $data = $query->result_array();
	    foreach ($data as $key => $value) {
	    	if(!empty($value['price']) && !empty($value['order_amount_from']) && !empty($value['order_amount_to']))
	    	{
		    	$order_amount_from 	= explode("~", $value['order_amount_from']);
		    	$order_amount_to 	= explode("~", $value['order_amount_to']);
	    		$prices 			= explode("~", $value['price']);
	    		asort($order_amount_from);
	    		return current($order_amount_from);
	    	}
	    	else
	    	{
	    		$from_amount = $CI->dbsettings->DEFAULT_MINIMUM_ORDER_AMOUNT_LIMIT;
	    	}
	    }
    }
    else
    {
    	$from_amount = $CI->dbsettings->DEFAULT_MINIMUM_ORDER_AMOUNT_LIMIT;
    }
    return $from_amount;
}

//=================Captcha=========================================//
/**
 * getcaptchacode for FrontEnd
 *
 * Display Page with header and footer file
 * @access          public
 */
if (!function_exists('getcaptchacode')) {
    function getcaptchacode(){
        $CI =& get_instance();
        $CI->load->helper('captcha');
        //$listAlpha ='0123456789';//abcdefghijklmnopqrstuvwxyz0123456789
        $listAlpha ='abcdefghijklmnopqrstuvwxyz0123456789';
        $numAlpha=5;
        $captcha=substr(str_shuffle($listAlpha),0,$numAlpha);
        /*$code_captcha = array(
                         'captcha' => $captcha
                        );
        $CI->session->set_userdata('codecaptcha',$code_captcha);*/
        $path = config_item('base_url').'assets/uploads/capcha/';
        //$fontpath = config_item('base_url').'bucket/frontend/assets/fonts/TitilliumWeb-BoldItalic.ttf';
        // $fontpath = 'bucket/frontend/assets/fonts/verdana.ttf';
        $fontpath = BASEPATH.'/fonts/Verdana.ttf';
        $vals = array(
        'word'   => $captcha,
        'img_path' => './assets/uploads/capcha/',
        'img_url' => $path,
        'font_size' => 30,
        'font_path'  => $fontpath,
                    'img_width'        => '200',
                    'img_height' => '70',
                    // 'border' => 0,

                    // 'expiration' => 1800
                    // 'font_size'=>'30'
    );
        //pr($vals); die;
        $get_captcha = create_captcha($vals); //pr($get_captcha); die;
        $CI->session->set_userdata('codecaptcha',$get_captcha['word']);
        // return 1;
        return $get_captcha;
    }
}
//=================Close Captcha=========================================//

/* End of Function */
function getAllActiveCategory() {

    $CI = & get_instance();
    $sql = "SELECT id,name,url_name,parent_id FROM `tbl_categories` WHERE `tbl_categories`.`status` = 'Active' AND parent_id = 0 ORDER BY name ASC";
    $query = $CI->db->query($sql);
    $data ="";
    if($query->num_rows() > 0) {
        $data = $query->result();
    }
    $str_id = "";
    $final = [];
    foreach ($data as $key => $value) {
        $str_id .= $data[$key]->id.",";
        $sql2 = "SELECT id,name,url_name,parent_id FROM `tbl_categories` WHERE `tbl_categories`.`status` = 'Active' AND parent_id = ".$data[$key]->id." ORDER BY name ASC";
        $query2 = $CI->db->query($sql2);
        if ($query2->num_rows() > 0) {
            $final[$data[$key]->id]['cat'] = $data[$key]->name;
            $final[$data[$key]->id]['subcat'] = $query2->result();
        }
    }

    return $final;
    // pr($str_id);
    // echo "<br>";
    // pr($final);die;
    // echo implode( $data,",");die;
    // return $query->result();
}


/**
     * is_userprotected
     *
     * This function check superadminuser already login or not
     *
     * @access	public
     * @return	boolean
     */
if (!function_exists('is_userprotected')) {

    function is_userprotected() {
        $CI = &get_instance();
        if ($CI->session->userdata('isLogin') == 'yes') {

            return true;

        } else {
            redirect('/site');
        }
    }

}

/**
     * is_userprotected
     *
     * This function check function decode polymap save lang,lat in database field
     *
     * @access  public
     * @return  string
     */
if (!function_exists('decodePolyMapLatLag')) {

    function decodePolyMapLatLag($data)
    {
        $crdData = '';
        if(!empty($data)){
            $data1 = explode("|",$data);
            $crd = explode(")",$data1[0]);
            // print_r($crd);
            for ($i=0; $i < count($crd)-1; $i++) {
                $crd1 = ltrim($crd[$i],"(");
                $onebyone = explode(",",$crd1);
                $crdData .= "{lat:".$onebyone[0].",lng:".$onebyone[1]."},";
            }
            return rtrim($crdData,",");

        }else{
            return '';
        }

    }

}
/**
     * is_userprotected
     *
     * This function check function decode polymap save lang,lat in database field
     *
     * @access  public
     * @return  string
     */
if (!function_exists('getDefaultStore')) {

    function getDefaultStore()
    {
		$CI = &get_instance();
    	if($CI->cache->file->get('default_store'))
    	{
    		return $CI->cache->file->get('default_store');
    	}
        $CI->db->select('store_id,store_address');
        $CI->db->where('default_status','1');
        $results = $CI->db->get('tbl_store')->row();
        $CI->cache->file->save('default_store',$results, CACHE_EXPIRE);
        return $results;
    }

}




if (!function_exists('get_basket_list')) {

    function get_basket_list()
    {
        $CI = &get_instance();
        //$CI->db->select('store_id,store_address');
        $CI->db->where('status','1');
        $CI->db->join("manage_bucket_details MBD",'MB.id=MBD.parent_id');
        $CI->db->group_by('MB.id');
        $CI->db->order_by('MBD.basket_size','desc');

        $query = $CI->db->get('manage_bucket MB')->result();
        //return $results = $CI->db->get('tbl_store')->row();





        return $query;
    }


    }





if (!function_exists('get_about_us')) {

    function get_about_us()
    {
        $CI = &get_instance();
        if($CI->cache->file->get('tbl_cms'))
    	{
    		return $CI->cache->file->get('tbl_cms');
    	}
        $CI->db->select('*');
		$CI->db->where('id','1');
	    $results =  $CI->db->get('tbl_cms')->row()->footer_description;
	    $CI->cache->file->save('tbl_cms',$results, CACHE_EXPIRE);
	    return $results;

    }

}

if (!function_exists('get_brand')) {

    function get_brand()
    {
    	 $CI = & get_instance();
		   if($CI->cache->file->get('show_on_home_page_brand'))
	   	 {
	   		$result__ =  $CI->cache->file->get('show_on_home_page_brand');
	       	return $result__;
	     }
        $CI->db->select('brand_id,image');
        $CI->db->where('status','1');
        $CI->db->where('show_on_home_page','1');
        $CI->db->order_by('order_no','asc');
        //$CI->db->limit(6);
        $results = $CI->db->get('tbl_brand')->result();
        // pr($results);die();
        $CI->cache->file->save('show_on_home_page_brand', $results, 604800);
        return $results;

    }

}



if (!function_exists('get_social_media')) {

    function get_social_media()
    {       $where_array = array('Facebook','Twitter','GooglePlus','LinkedIn','Instagram','Copyright');

            $CI = &get_instance();
            $CI->db->select('var_name,setting_value');
            $CI->db->where_in('var_name',$where_array);
            $results = $CI->db->get('tbl_website_setting')->result();
           if($results){
            return $results;
           }else{
            return false;
           }

    }

}





/**
     *
     *
     * This function return value of specified field
     *
     * @access  public
     * @return  string
     */
if (!function_exists('getFieldValue')) {

    function getFieldValue($table,$field,$condKey,$condValue)
    {
        $CI = &get_instance();
        $CI->db->select($field);
        $CI->db->from($table);
        $CI->db->where($condKey,$condValue);
        $CI->db->limit(1);
        return $results = $CI->db->get()->row()->$field;
    }

}
/**
     *
     *
     * This function return value of specified field
     *
     * @access  public
     * @return  string
     */
if (!function_exists('get_timeslot')) {

    function get_timeslot($day_id,$store_id)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->from('tbl_timeslot');
        $CI->db->where('store',$store_id);
        $CI->db->where('day_id',$day_id);
        //$CI->db->limit(1);
        return $results = $CI->db->get()->result();
    }

}
/**
     *
     *
     * This function return value of specified field
     *
     * @access  public
     * @return  string
     */
if (!function_exists('get_day_count_according_store')) {

    function get_day_count_according_store($store_id)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->from('tbl_timeslot');
        $CI->db->group_by('day_id');
        $CI->db->where('store',$store_id);
        //$CI->db->limit(1);
        return $results = $CI->db->get()->result();
    }

}
/**
     *
     *
     * This function return value of specified field
     *
     * @access  public
     * @return  string
     */
if (!function_exists('getFieldValueByQuery')) {

    function getFieldValueByQuery($table,$field,$cond,$other='')
    {
        $CI = &get_instance();
        if($cond=="")
        {

            $sql = "SELECT $field FROM $table $other";
        }
        else
        {

            $sql = "SELECT $field FROM $table WHERE $cond $other";
        }
        return $CI->db->query($sql)->row()->$field;
    }

}
/**
     *
     *
     * This function return value of match fields
     *
     * @access  public
     * @return  string
     */
if (!function_exists('getFieldValues')) {

    function getFieldValues($table,$field,$condKey,$condValue,$activeIn=FALSE)
    {
        $CI = &get_instance();
        if($condValue=="")
        {
            return "";
        }
        if($activeIn==TRUE)
        {
            $CI = &get_instance();
            $sql = "SELECT $field FROM $table WHERE $condKey IN($condValue)";
            return $results = $CI->db->query($sql)->result();

        }
        else
        {
            $CI->db->select($field);
            $CI->db->from($table);
            $CI->db->where($condKey,$condValue);
            return $results = $CI->db->get()->result();
        }
    }

}
/**
     *
     *
     * This function return value of match fields
     *
     * @access  public
     * @return  string
     */
if (!function_exists('getRecords')) {

    function getRecords($table,$condKey,$condValue,$activeIn=FALSE)
    {
        $CI = &get_instance();
        if($activeIn==TRUE)
        {
            $CI = &get_instance();
            $sql = "SELECT * FROM $table WHERE $condKey IN($condValue)";
            return $results = $CI->db->query($sql)->result();

        }
        else
        {
            $CI->db->select();
            $CI->db->from($table);
            $CI->db->where($condKey,$condValue);
            return $results = $CI->db->get()->result();
        }
    }

}

/**
     *
     *
     * This function return value of match fields
     *
     * @access  public
     * @return  string
     */
if (!function_exists('getRecordsWithLimitedColumn')) {

    function getRecordsWithColumn($table,$columns="",$cond="",$order="",$limit="")
    {
        $CI = &get_instance();

        if($CI->cache->file->get('getRecordsWithLimitedColumn_'.$table.'_'.$columns.'_'.$cond.'_'.$order.'_'.$limit)){
            $results = $CI->cache->file->get('getRecordsWithLimitedColumn_'.$table.'_'.$columns.'_'.$cond.'_'.$order.'_'.$limit);
            return $results;
        }

        if(is_array($columns))
        {
            $columnName = [];
            foreach ($columns as $key => $value) {
                $columnName[$key] = $value.",";
            }
        }
        else
        {
            $columnName = $columns;
        }
        if($columns=="")
        {
            $columnName = "*";
        }
        $columnName = rtrim($columnName,",");
        $filter ="";
        if(is_array($cond))
        {
            $filter = implode(" AND ", $cond);
        }
        else
        {
            $filter = "AND ".$cond;
        }
        $columnName = rtrim($columnName,",");
        if(empty($filter))
        {
            $sql = "SELECT $columnName FROM $table $order $limit";
        }
        else
        {
            $sql = "SELECT $columnName FROM $table WHERE status = 'Active' $filter $order $limit";

        }
        //echo  $sql; die;
        $results = $CI->db->query($sql)->result();
        if(!empty($results)){
            foreach($results as $key_rts=>$val_rts){
                    $CI->db->select('product_id');
                    $CI->db->where('product_status','1');
                    // $CI->db->where('featured','0');
                    $CI->db->where('FIND_IN_SET('.$val_rts->id.',category_ids) !=',0);
                    $res = $CI->db->get('tbl_product')->result();
                    if(!empty($res)){
                        foreach($res as $key_res=>$val_res){
                            $CI->db->select('id');
                            $CI->db->where('unit_status','1');
                            $CI->db->where('FIND_IN_SET('.$val_res->product_id.',product_id) !=',0);
                            $res = $CI->db->get('tbl_product_price')->result();
                            if(count($res) > 0){
                                $results[$key_rts]->is_product = '1';
                            }else{
                                $results[$key_rts]->is_product = '0';
                            }
                        }
                    }else{
                        $results[$key_rts]->is_product = '0';
                    }
            }
        }
            ###############caching save starts######################

            $CI->cache->file->save('getRecordsWithLimitedColumn_'.$table.'_'.$columns.'_'.$cond.'_'.$order.'_'.$limit,$results, CACHE_EXPIRE);

            ###############caching save ends######################
        return $results;
    }
}

function getCategoryImg() {
	$CI = &get_instance();
	$CI->db->select('category_banner,url_name');
	$CI->db->where('menu_show',1);
	$CI->db->where('status','Active');
	$CI->db->order_by('sort_order','ASC');
	$CI->db->from('tbl_categories');
	$cat_data = $CI->db->get()->result_array();
	$cat_data = json_encode($cat_data);
	 return $cat_data;
}

/**
     *
     *
     * This function return total num rows of specified condition
     *
     * @access  public
     * @return  string
     */
if (!function_exists('getNumRows')) {

    function getNumRows($table,$condKey,$condValue,$find_in_set='')
    {
        if($condValue=="")
        {
            return 0;
        }
        $CI = &get_instance();
        if($find_in_set!='')
        {
            if($find_in_set=='find_in_set')
            {
                $sql = "SELECT $condKey FROM $table WHERE FIND_IN_SET($condValue,$condKey)";
            }
            elseif($find_in_set=='in')
            {
                $sql = "SELECT $condKey FROM $table WHERE $condKey IN($condValue)";
            }
            else
            {
                $sql = "SELECT $condKey FROM $table WHERE $condKey = '".$condValue."'";
            }
        }
        else
        {
            $sql = "SELECT $condKey FROM $table WHERE $condKey = '".$condValue."'";
        }
        // echo $sql;
        return $CI->db->query($sql)->num_rows();
        // $CI->db->from($table);
        // $CI->db->where_in($condKey,$condValue,FALSE);
        // return $query = $CI->db->get()->num_rows();
    }

}

/* End of Function */


/**
     * validate_admin_login
     *
     * This function check user type and redirect according
     *
     * @access	public
     * @return	boolean
     */
if (!function_exists('validate_admin_login')) {

    function validate_admin_login() {
        $CI = &get_instance();
		if ($CI->session->userdata('isLogin') == 'yes') {
					if($CI->session->userdata('user_type')==1){
					} else if($CI->session->userdata('user_type')==3){
						redirect('/admin/dashboard');
					} else {
						redirect('/account');
					}
		}

    }

}
/* End of Function */


/**
     * validate_user_login
     *
     * This function check user type and redirect according
     *
     * @access	public
     * @return	boolean
     */
if (!function_exists('validate_user_login')) {

    function validate_user_login() {
        $CI = &get_instance();
		if ($CI->session->userdata('isLogin') == 'yes') {
					if($CI->session->userdata('user_type')==4){
					} else if($CI->session->userdata('user_type')==3){
						redirect('/admin/dashboard');
					} else {
						redirect('/admin/dashboard');
					}
		}

    }

}
/* End of Function */

/**
 * @Function _layout
 * @purpose load layout page
 * @created  2 dec 2014
 */
if (!function_exists('_layout')) {

    function _layout($data = null) {
        $CI = &get_instance();
        $CI->load->view('layout', $data);
    }

}
/* End of Function */

/**
 * set_flashdata
 *
 * This function set falsh message value
 *
 * @access	public
 *
 */
if (!function_exists('set_flashdata')) {

    function set_flashdata($type, $msg) {
        $CI = &get_instance();
        $CI->session->set_flashdata($type, $msg);
    }

}
/* End of Function */

/**
 * get_flashdata
 *
 * This function give custome flash message formate
 *
 * @access	public
 * @return	html data
 */
if (!function_exists('get_flashdata')) {

    function get_flashdata() {
        $CI = &get_instance();
        $success = $CI->session->flashdata('success') ? $CI->session->flashdata('success') : '';
        $error = $CI->session->flashdata('error') ? $CI->session->flashdata('error') : '';
        $warning = $CI->session->flashdata('warning') ? $CI->session->flashdata('warning') : '';
        $msg = '';
        if ($success) {
            $msg = '<div class="alert alert-success flash-row">
                            <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>
                            ' . $success . ' </div>';
        } elseif ($error) {
            $msg = '<div class="alert alert-danger flash-row">
			<button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>
			<strong>Error!</strong> ' . $error . ' </div>';
        } elseif ($warning) {
            $msg = '<div class="alert alert-warning flash-row">
			<button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			' . $warning . '</div>';
        }
        return $msg;
    }

}
/* End of Function */

/**
 * isPostBack
 *
 * This function check request send by POST or  not
 *
 * @access	public
 * @return	html data
 */
if (!function_exists('isPostBack')) {

    function isPostBack() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            return true;
        else
            return false;
    }

}
/* End of Function */

/**
 * isGetBack
 *
 * This function check request send by GET or  not
 *
 * @access	public
 * @return	html data
 */
if (!function_exists('isGetBack')) {

    function isGetBack() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET')
            return true;
        else
            return false;
    }

}
/* End of Function */

/**
 * Current Date And Time
 *
 * This function get Current Date And Time
 *
 * @param
 * @return
 */

if (!function_exists('current_date')) {

    function current_date() {
        $dateFormat = date("Y-m-d H:i:s", time());
        $timeNdate = $dateFormat;
        return $timeNdate;
    }

}
/* End of Function */

/**
 * Date format
 *
 * This function get correct date format
 *
 * @param
 * @return
 */
if (!function_exists('correct_date')) {
        function correct_date($posted_date) {
            $postdate = str_replace('/', '-',$posted_date);
            $dateFormat = date("Y-m-d", strtotime($postdate));
            return $dateFormat;
        }

    }
/* End of Function */
/**
 * Date format
 *
 * This function chenge date format for dd/mm/yyyy
 *
 * @param
 * @return
 */
if (!function_exists('dateFormat')) {
    function dateFormat($date,$blank=false) {
        if($date!=null && $date!=NULL && $date!='0000-00-00' && $date!='0000-00-00 00:00:00' )
        {
            $date1=date_create($date);
            if(strlen($date)==19)
            {
                return date_format($date1,"d/m/Y H:i:s");
                // return date("d/m/Y h:i:s",strtotime($date));
            }
            else
            {
                return date_format($date1,"d/m/Y");
                // return date("d/m/Y",strtotime($date));
            }
            // $new_date = explode("-", $date);
            // return $new_date[2]."/".$new_date[1]."/".$new_date[0];
        }
        else
        {
            if($blank==false)
            {
                return "00-00-0000 00:00:00";
            }
            else
            {
                return ;
            }
        }
    }
}
/* End of Function */
function validateDateTime($dateStr, $format)
{
    date_default_timezone_set('UTC');
    $date = DateTime::createFromFormat($format, $dateStr);
    return $date && ($date->format($format) === $dateStr);
}
/**
 * Date format
 *
 * This function chenge date format for sql
 *
 * @param
 * @return
 */
if (!function_exists('dateFormatForSQL')) {
    function dateFormatForSQL($date) {
        if($date!=null && $date!=NULL)
        {
            if(strlen($date)==19)
            {
                $datetime = explode(" ", $date);
                $date = str_replace("-", "/", $datetime[0]);
                $new_date = explode("/", $date);
                return $new_date[2]."-".$new_date[1]."-".$new_date[0]." ".$datetime[1];
            }
            else
            {
                $date = str_replace("-", "/", $date);
                $new_date = explode("/", $date);
                return $new_date[2]."-".$new_date[1]."-".$new_date[0];

            }
        }
        else
        {
            return "";
        }
    }
}
/* End of Function */


/**
 * Featured plan end Date
 *
 * This function get featured plan end Date
 *
 * @param
 * @return
 */
if (!function_exists('featured_plan_date')) {

        function featured_plan_date($userid) {
            $CI = &get_instance();
            $CI->db->select('plan_featured_end_date');
            $CI->db->from('fs_users');
            $CI->db->where('id',$userid);
            $query = $CI->db->get();
            if($query->num_rows()>0){
                return $query->row()->plan_featured_end_date;
            } else {
                return false;
            }
        }

    }
    /* End of Function */

/**
 * Date format for view
 *
 * This function get date format for view exp: d/m/Y
 *
 * @param
 * @return
 */
if (!function_exists('view_date_format')) {
    function view_date_format($view_date) {
		if($view_date){
        $view_date = str_replace('-', '/',$view_date);
        $dateFormat = date("d/m/Y", strtotime($view_date));
			return $dateFormat;
		} else {
			return false;
		}

    }

}
/* End of Function */



/**
 * get_order_status
 *
 * This function check request send by Ajax or not
 *
 *
 * @return boolean
 */
if (!function_exists('get_order_status')) {

        function get_order_status($status_id) {
            $CI = &get_instance();
            $CI->db->select('*');
            $CI->db->from('fs_order_status');
            if($status_id==1){
                $CI->db->where('id !=',$status_id);
            } else if($status_id==2){
                $CI->db->where('id !=',1);
                $CI->db->where('id !=',$status_id);
            } else if($status_id==3){
                $CI->db->where('id !=',1);
                $CI->db->where('id !=',2);
                $CI->db->where('id !=',$status_id);
                $CI->db->where('id !=',5);
            } else if($status_id==4){
                $CI->db->where('id !=',1);
                $CI->db->where('id !=',2);
                $CI->db->where('id !=',3);
                $CI->db->where('id !=',5);
                $CI->db->where('id !=',$status_id);
            } else if($status_id==5) {
                $CI->db->where('id !=',1);
                $CI->db->where('id !=',2);
                $CI->db->where('id !=',3);
                $CI->db->where('id !=',4);
                $CI->db->where('id !=',$status_id);
            } else {
                $CI->db->where('id !=',0);
            }

            $query = $CI->db->get();
            if($query->num_rows()>0){
                return $query->result();
            } else{
                return false;
            }
        }

    }
    /* End of Function */

/**
 * Current User Info
 *
 * If user loged then returl current user info
 *
 * @access	public
 * @return	mixed	boolean or depends on what the array contains
 */
if (!function_exists('currentuserinfo')) {

    function currentuserinfo() {
        $CI = &get_instance();
        return $CI->session->userdata("userinfo");
    }

}
/* End of Function */



/**
 * uri_segment
 * this function give url segment value
 * @param int
 * @return string
 */
if (!function_exists('uri_segment')) {

    function uri_segment($val) {
        $CI = &get_instance();
        return $CI->uri->segment($val);
    }

}
/* End of Function */

/**
 * pr
 * this function print data with <pre> tag
 * @access	public
 */
if (!function_exists('pr')) {

    function pr($data = null) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}
/* End of Function */

/**
 * prd
 * this function print data with <pre> tag and die
 * @access  public
 */
if (!function_exists('prd')) {

    function prd($data = null) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';die;
    }

}
/* End of Function */

/**
 * pr
 * this function print data with <pre> tag
 * @access  public
 */
if (!function_exists('lq')) {

    function lq($data = null) {
        $CI = &get_instance();
        echo $CI->db->last_query();
    }

}
/* End of Function */



/**
 * is_ajax_post
 *
 * This function check request send by Ajax or not
 *
 *
 * @return boolean
 */
if (!function_exists('is_ajax_post')) {

    function is_ajax_post() {
        $CI = &get_instance();
        if (!$CI->input->is_ajax_request()) {
            show_error('No direct script access allowed');
            exit;
        }
    }

}
/* End of Function */



/**
 * Function to check ajax request
 *
 * @access	public
 */
if (!function_exists('is_ajax_request')) {

    function is_ajax_request() {
        $CI = &get_instance();
        if (!$CI->input->is_ajax_request()) {
            show_error('No direct script access allowed');
            exit;
        }
    }

}
/* End of Function */






/**
 * _show404
 *
 * This function show error message
 *
 *
 * @return array
 */
// if (!function_exists('_show404')) {

//     function _show404() {
//         $CI = &get_instance();
//         $data['title'] = 'Error';
//         $data['subTitle'] = 'Wrong Page';
//         $data['page'] = 'error';
//         _layout($data);
//     }

// }
/* End of Function */





/**
 * custom_encryption
 *
 * This function encryt and decrypt value on the base action value
 * @param string
 * @param string
 * @param string
 *
 * @return string
 */
if (!function_exists('custom_encryption')) {

    function custom_encryption($string, $key, $action) {  //echo die($action);
        if ($action == 'encrypt')
            return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        elseif ($action == 'decrypt')
            return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }

}
/* End of Function */


/**
 * get_topics
 *
 * This function give  captcha image
 *
 * @return html data
 *
 */
if (!function_exists('getcaptchacode')) {

    function getcaptchacode() {
        $CI = & get_instance();
        $CI->load->helper('captcha');
        $listAlpha = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $numAlpha = 5;
        $captcha = substr(str_shuffle($listAlpha), 0, $numAlpha);

        $path = config_item('base_url') . 'captcha/';
        //$fontpath = config_item('base_url').'bucket/frontend/assets/fonts/TitilliumWeb-BoldItalic.ttf';
        $fontpath = 'assets/fonts/verdana.ttf';
        $vals = array(
            'word' => $captcha,
            'img_path' => './captcha/',
            'img_url' => $path,
            //'font_path'	 => 'c:/windows/fonts/verdana.ttf',
            'font_path' => $fontpath,
            'img_width' => '159',
            'img_height' => '32',
            'border' => 0,
            'expiration' => 1800
        );
        $get_captcha = create_captcha($vals); //pr($get_captcha); die;
        $CI->session->set_userdata('codecaptcha', $get_captcha['word']);
        return $get_captcha;
    }

}
/* End of Function */

/**
 * obj_to_arr
 *
 * This function convert std object array into array
 *
 * @return array
 *
 */
if (!function_exists('obj_to_arr')) {

    function obj_to_arr($obj_arr) {
        $obj_arr = (array) $obj_arr;
        $chkey = array_keys($obj_arr);
        $chval = array_values($obj_arr);
        unset($obj_arr);
        $obj_arr = array_combine($chkey, $chval);
        return $obj_arr;
    }

}
/* End of Function */


/**
 * Id_encode
 *
 * This function to encode ID by a custom number
 * @param string
 *
 */
if (!function_exists('ID_encode')) {

    function ID_encode($id) {
        $encode_id = '';
        if ($id) {
            $encode_id = rand(1111, 9999) . (($id + 19)) . rand(1111, 9999);
        } else {
            $encode_id = '';
        }
        return $encode_id;
    }

}
/* End of function */

/**
 * Id_decode
 *
 * This function to decode ID by a custom number
 * @param string
 *
 */
if (!function_exists('ID_decode')) {

    function ID_decode($encoded_id) {
        $id = '';
        if ($encoded_id) {
            $id = substr($encoded_id, 4, strlen($encoded_id) - 8);
            $id = $id - 19;
        } else {
            $id = '';
        }
        return $id;
    }

}
/* End of function */




/**
 * _sendMailPhpMailer
 *
 * This function send mail to the given email id
 * @param string
 *
 */
if (!function_exists('_sendMailPhpMailer')) {

    function _sendMailPhpMailer($email_data) {
        $CI = &get_instance();
        $isCISendmail   =   $CI->config->item('sendmailCI');
        if($isCISendmail){// mail send by CI sendmail

            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset']  = 'iso-8859-1';
            $config['wordwrap'] = true;

            $CI->email->set_mailtype("html");
            $CI->email->initialize($config);
            $CI->email->from($email_data['from'],ucwords($email_data['sender_name']));

            if(@$email_data['to']!=''){
                $CI->email->to(@$email_data['to']);
            }

            if(@$email_data['cc']!=''){
                $CI->email->cc(@$email_data['cc']);
            }

            if(@$email_data['bcc']!=''){
                $CI->email->bcc(@$email_data['bcc']);
            }

            $i=0;
            if(@$email_data['file']!=''){
                if(is_array(@$email_data['file']) && count(@$email_data['file'])>0){
                    $arr_files   =   array();
                    $arr_files   =   @$email_data['file'];
                    $arr_files_name   =   @$email_data['file_name'];
                    foreach($arr_files as $file){
                        $CI->email->attach($file,'attachment',$arr_files_name[$i]);
                        $i++;
                    }

                }else{

                    $CI->email->attach($email_data['file'],'attachment',@$email_data['file_name']);
                }

            }

            $CI->email->subject(ucfirst($email_data['subject']));
			$data['sender_name'] 	= $email_data['sender_name'];
			$data['from'] 			= $email_data['from'];
            $data['message']    	= $email_data['message'];
            if(isset($email_data['cmp_logo'])){
                $data['cmp_logo']   =   @$email_data['cmp_logo'];
            }else{
                $data['cmp_logo']   =   @currentuserinfo()->cmp_logo;
            }

            $msg = $CI->load->view('email_template/contactus_email', $data, true);
            $CI->email->message($msg);

            if ($CI->email->send()) {
                return TRUE;
            } else {
                return FALSE;
            }

        }else{
            $CI->load->library('Sendmail');
            $mail = new PHPMailer(); // create a new object
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "";
            $mail->Password = "";

            //
            //$mail->SetFrom($email_data['from'],$email_data['sender_name'],0);
            $mail->Subject = $email_data['subject'];
            $data['sender_name']    = $email_data['sender_name'];
			$data['from'] 			= $email_data['from'];
            $data['message']        = $email_data['message'];
			$data['name'] 	        = $email_data['sender_name'];
            $data['otp'] 		    = $email_data['otp'];
            if(isset($email_data['cmp_logo'])){
                $data['cmp_logo']   =   @$email_data['cmp_logo'];
            }else{
                $data['cmp_logo']   =   @currentuserinfo()->cmp_logo;
            }

            $msg = $CI->load->view('email_template/'.$email_data['type'], $data, true);
            //echo $msg;die;
            $mail->Body = $msg;

            if (@$email_data['from']!='') {

                $mail->SetFrom(@$email_data['from'],@$email_data['sender_name'],'1');
            }

            if (@$email_data['to']!='') {
                $arr_to =   explode(',',@$email_data['to']);
                foreach($arr_to as $to){
                    $mail->AddAddress($to);
                }

            }
            if (@$email_data['cc']!='') {
                $arr_cc =   explode(',',@$email_data['cc']);
                foreach($arr_cc as $cc){
                    $mail->AddCC($cc);
                }

            }

            if(@$email_data['bcc']!='') {
                $arr_bcc =   explode(',',@$email_data['bcc']);
                foreach($arr_bcc as $bcc){
                    $mail->AddBCC($bcc);
                }
            }

            if(@$email_data['file']!='') {
                if(is_array(@$email_data['file']) && count(@$email_data['file'])>0){
                    $arr_files       =   array();
                    $arr_files_name  =   array();
                    $arr_files       =   @$email_data['file'];
                    $i=0;
                    if(is_array(@$email_data['file_name']) && count(@$email_data['file_name'])>0){
                        $arr_files_name   =   @$email_data['file_name'];
                        foreach($arr_files as $file){

                            $mail->AddAttachment($file,$arr_files_name[$i]);
                            $i++;
                        }
                    }else{
                        foreach($arr_files as $file){

                            $mail->AddAttachment($file);

                        }
                    }


                }else{
                    $CI->email->attach();
                    $mail->AddAttachment($email_data['file']);
                }

            }

            if($mail->Send()){
                return TRUE;

            }else{
                return FALSE;

            }
        }


    }
}
/* End of Function */



/**
 * _sendMailOrderConfirmPhpMailer
 *
 * This function send mail to the given email id
 * @param string
 *
 */
if (!function_exists('_sendMailOrderConfirmPhpMailer')) {

    function _sendMailOrderConfirmPhpMailer($email_data,$order_template_data) {
        $CI = &get_instance();
        $isCISendmail   =   $CI->config->item('sendmailCI');
        if($isCISendmail){// mail send by CI sendmail

            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset']  = 'iso-8859-1';
            $config['wordwrap'] = true;

            $CI->email->set_mailtype("html");
            $CI->email->initialize($config);
            $CI->email->from($email_data['from'],ucwords($email_data['sender_name']));

            if(@$email_data['to']!=''){
                $CI->email->to(@$email_data['to']);
            }

            if(@$email_data['cc']!=''){
                $CI->email->cc(@$email_data['cc']);
            }

            if(@$email_data['bcc']!=''){
                $CI->email->bcc(@$email_data['bcc']);
            }

            $i=0;
            if(@$email_data['file']!=''){
                if(is_array(@$email_data['file']) && count(@$email_data['file'])>0){
                    $arr_files   =   array();
                    $arr_files   =   @$email_data['file'];
                    $arr_files_name   =   @$email_data['file_name'];
                    foreach($arr_files as $file){
                        $CI->email->attach($file,'attachment',$arr_files_name[$i]);
                        $i++;
                    }

                }else{

                    $CI->email->attach($email_data['file'],'attachment',@$email_data['file_name']);
                }

            }

            $CI->email->subject(ucfirst($email_data['subject']));
            $data['message']    =   $email_data['message'];
			$data['order_details']   =   $order_template_data['order_details'];
			$data['cart_data']   =   $order_template_data['cart_data'];

            if(isset($email_data['cmp_logo'])){
                $data['cmp_logo']   =   @$email_data['cmp_logo'];
            }else{
                $data['cmp_logo']   =   @currentuserinfo()->cmp_logo;
            }

            $msg = $CI->load->view('email_template/email_order_template', $data, true);
            $CI->email->message($msg);

            if ($CI->email->send()) {
                return TRUE;
            } else {
                return FALSE;
            }

        }else{
            $CI->load->library('Sendmail');
            $mail = new PHPMailer(); // create a new object
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // 	authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "";
            $mail->Password = "";


            //
            //$mail->SetFrom($email_data['from'],$email_data['sender_name'],0);
            $mail->Subject = $email_data['subject'];
            $data['message'] = $email_data['message'];
			$data['order_details']   =   $order_template_data['order_details'];
			$data['cart_data']   =   $order_template_data['cart_data'];

            if(isset($email_data['cmp_logo'])){
                $data['cmp_logo']   =   @$email_data['cmp_logo'];
            }else{
                $data['cmp_logo']   =   @currentuserinfo()->cmp_logo;
            }

            $msg = $CI->load->view('email_templates/email_order_template', $data, true);
            //echo $msg;die;
            $mail->Body = $msg;

            if (@$email_data['from']!='') {

                $mail->SetFrom(@$email_data['from'],@$email_data['sender_name'],'1');
            }

            if (@$email_data['to']!='') {
                $arr_to =   explode(',',@$email_data['to']);
                foreach($arr_to as $to){
                    $mail->AddAddress($to);
                }

            }
            if (@$email_data['cc']!='') {
                $arr_cc =   explode(',',@$email_data['cc']);
                foreach($arr_cc as $cc){
                    $mail->AddCC($cc);
                }

            }

            if(@$email_data['bcc']!='') {
                $arr_bcc =   explode(',',@$email_data['bcc']);
                foreach($arr_bcc as $bcc){
                    $mail->AddBCC($bcc);
                }
            }

            if(@$email_data['file']!='') {
                if(is_array(@$email_data['file']) && count(@$email_data['file'])>0){
                    $arr_files       =   array();
                    $arr_files_name  =   array();
                    $arr_files       =   @$email_data['file'];
                    $i=0;
                    if(is_array(@$email_data['file_name']) && count(@$email_data['file_name'])>0){
                        $arr_files_name   =   @$email_data['file_name'];
                        foreach($arr_files as $file){

                            $mail->AddAttachment($file,$arr_files_name[$i]);
                            $i++;
                        }
                    }else{
                        foreach($arr_files as $file){

                            $mail->AddAttachment($file);

                        }
                    }


                }else{
                    $CI->email->attach();
                    $mail->AddAttachment($email_data['file']);
                }

            }

            if($mail->Send()){
                return TRUE;

            }else{
                return FALSE;

            }
        }


    }
}
/* End of Function */





/**
 * send mobile one time password
 * send one time password api function
 */
if (!function_exists('send_otp')) {

    function send_otp($content, $number) {
        $content = urlencode($content);
        $Url = "http://tra.smsmyntraa.com/API/WebSMS/Http/v1.0a/index.php?username=" . USERNAME . "&password=" . PASSWORD . "&sender=" . SENDERID . "&to=" . $number . "&message=" . $content . "&reqid=1&format={json|text}&route_id=Transactional&callback=&unique=0&sendondate=" . date('Y-m-d H:i:s') . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        $errmsg = curl_error($ch);
        $cInfo = curl_getinfo($ch);
        curl_close($ch);
        return $output;
    }

}


if(!function_exists('array_to_excel')) {
    function array_to_excel($data, $filename = ""){
    	if ($filename != ""){
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");
    	}

    	ob_start();
    	$flag = false;
          foreach($data as $row) {

		   /*  if(!$flag) {
              // display field/column names as first row
              echo implode("\t", array_keys($row)) . "\n";
              $flag = true;
            } */
           // array_walk($row, __NAMESPACE__ . '\cleanData');
            echo implode("\t", array_values($row)) . "\n";
          }
    }
}


    function convertNumber($number)
    {
            list($integer, $fraction) = explode(".", (string) $number);

            $output = "";

            if ($integer[0] == "-")
            {
                $output = "negative ";
                $integer    = ltrim($integer, "-");
            }
            else if ($integer[0] == "+")
            {
                $output = "positive ";
                $integer    = ltrim($integer, "+");
            }

            if ($integer[0] == "0")
            {
                $output .= "zero";
            }
            else
            {
                $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
                $group   = rtrim(chunk_split($integer, 3, " "), " ");
                $groups  = explode(" ", $group);

                $groups2 = array();
                foreach ($groups as $g)
                {
                    $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
                }

                for ($z = 0; $z < count($groups2); $z++)
                {
                    if ($groups2[$z] != "")
                    {
                        $output .= $groups2[$z] . convertGroup(11 - $z) . (
                                $z < 11
                                && !array_search('', array_slice($groups2, $z + 1, -1))
                                && $groups2[11] != ''
                                && $groups[11][0] == '0'
                                    ? " and "
                                    : ", "
                            );
                    }
                }

                $output = rtrim($output, ", ");
            }

            if ($fraction > 0)
            {
                $output .= " point";
                for ($i = 0; $i < strlen($fraction); $i++)
                {
                    $output .= " " . convertDigit($fraction[$i]);
                }
            }

            return $output;
        }

        function convertGroup($index)
        {
            switch ($index)
            {
                case 11:
                    return " decillion";
                case 10:
                    return " nonillion";
                case 9:
                    return " octillion";
                case 8:
                    return " septillion";
                case 7:
                    return " sextillion";
                case 6:
                    return " quintrillion";
                case 5:
                    return " quadrillion";
                case 4:
                    return " trillion";
                case 3:
                    return " billion";
                case 2:
                    return " million";
                case 1:
                    return " thousand";
                case 0:
                    return "";
            }
        }

        function convertThreeDigit($digit1, $digit2, $digit3)
        {
            $buffer = "";

            if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
            {
                return "";
            }

            if ($digit1 != "0")
            {
                $buffer .= convertDigit($digit1) . " hundred";
                if ($digit2 != "0" || $digit3 != "0")
                {
                    $buffer .= " and ";
                }
            }

            if ($digit2 != "0")
            {
                $buffer .= convertTwoDigit($digit2, $digit3);
            }
            else if ($digit3 != "0")
            {
                $buffer .= convertDigit($digit3);
            }

            return $buffer;
        }

        function convertTwoDigit($digit1, $digit2)
        {
            if ($digit2 == "0")
            {
                switch ($digit1)
                {
                    case "1":
                        return "ten";
                    case "2":
                        return "twenty";
                    case "3":
                        return "thirty";
                    case "4":
                        return "forty";
                    case "5":
                        return "fifty";
                    case "6":
                        return "sixty";
                    case "7":
                        return "seventy";
                    case "8":
                        return "eighty";
                    case "9":
                        return "ninety";
                }
            } else if ($digit1 == "1")
            {
                switch ($digit2)
                {
                    case "1":
                        return "eleven";
                    case "2":
                        return "twelve";
                    case "3":
                        return "thirteen";
                    case "4":
                        return "fourteen";
                    case "5":
                        return "fifteen";
                    case "6":
                        return "sixteen";
                    case "7":
                        return "seventeen";
                    case "8":
                        return "eighteen";
                    case "9":
                        return "nineteen";
                }
            } else
            {
                $temp = convertDigit($digit2);
                switch ($digit1)
                {
                    case "2":
                        return "twenty $temp";
                    case "3":
                        return "thirty $temp";
                    case "4":
                        return "forty $temp";
                    case "5":
                        return "fifty $temp";
                    case "6":
                        return "sixty $temp";
                    case "7":
                        return "seventy $temp";
                    case "8":
                        return "eighty $temp";
                    case "9":
                        return "ninety $temp";
                }
            }
        }

        function convertDigit($digit)
        {
            switch ($digit)
            {
                case "0":
                    return "zero";
                case "1":
                    return "one";
                case "2":
                    return "two";
                case "3":
                    return "three";
                case "4":
                    return "four";
                case "5":
                    return "five";
                case "6":
                    return "six";
                case "7":
                    return "seven";
                case "8":
                    return "eight";
                case "9":
                    return "nine";
            }
        }


function get_datetime_by_defined_timezone($datetime,$timezone = NULL)
{
    if($timezone == '')
    {
        $timezone_dat = fieldByCondition("users",array('id'=>  currentuserinfo()->id),"timezone");
        if(!empty($timezone_dat)){$timezone = $timezone_dat->timezone;}else{$timezone   =   date_default_timezone_get();}
        $date = new DateTime($datetime, new DateTimeZone(date_default_timezone_get()));
    }else{
        $date = new DateTime($datetime, new DateTimeZone($timezone));
    }


    //$date->format('Y-m-d H:i:s') . "\n";
    $date->setTimezone(new DateTimeZone($timezone));
    return $date->format('Y-m-d H:i:s');

}

function convert_datetime_by_defined_timezone($datetime,$timezone_from,$timezone_to)
{
    $date = new DateTime($datetime, new DateTimeZone($timezone_from));
    //$date->format('Y-m-d H:i:s') . "\n";
    $date->setTimezone(new DateTimeZone($timezone_to));
    return $date->format('Y-m-d H:i:s');

}

function get_default_timezone_of_user()
{
    $timezone_dat = fieldByCondition("users",array('id'=>  currentuserinfo()->id),"timezone");
    if(!empty($timezone_dat))
    {
        $timezone = $timezone_dat->timezone;
    }else{
        $timezone   =   date_default_timezone_get();
    }
    return $timezone;
}

/**
 * Function for restore data
 */
if (!function_exists('restoreData')) {

    function restoreData($arr) {
        $CI = &get_instance();
        $table = $arr->table;
        $col1 = $arr->col1;
        if($arr->col2){
        $col2 = $arr->col2;
        }
        $whr[$col2] = $arr->id;
        $upd[$col1] = $arr->value;
        $CI->db->update($table, $upd, $whr);
//        echo $CI->db->last_query(); die;
        if ($CI->db->affected_rows()) {
            $res['status'] = 'success';
            $res['message'] = null;
        } else {
            $res['status'] = 'error';
            $res['message'] = $CI->db->_error_message();
        }
        return $res;
    }

}

/* End of Function */

/**
 * export_data
 *
 * This function give data on given condition
 *
 *
 * @return array or boolean
 */
if (!function_exists('export_data')) {

    function export_data($conArr,$field) {
        $CI = &get_instance();
        $CI->db->select($field, false);
        $CI->db->from($conArr['table']);
		if(!empty($conArr['column1'])){
        $CI->db->where_in($conArr['column1'], $conArr['ids']);
        }
		$CI->db->order_by($conArr['column1'],'desc');
        $query = $CI->db->get();
        if ($query->num_rows()>0) {
            return $query->result();
        } else {
        return false;
		}
    }

}
/* End of Function */



//=============================================Export=================================================
if(! function_exists('array_to_exl'))
{
    function array_to_exl($header,$excellists, $download = "")
    {
		$num=0;
		$data=NULL;
		if($excellists!=null)
		{
			foreach ($excellists as $row)
			{
				$num++;
				$line = $num."\t";
				foreach($row as $value)
				{
					if(!isset($value) || trim($value) == "")
					{
						$value = "\t";
					}
					else
					{
						$value = str_replace('"' , '""' , $value);
						$value = '"' . $value . '"' . "\t";
					}
					$line .= $value;
				}
				$data .= trim($line). "\n";
			}
			$data = str_replace("\r" , "" , $data);
			if(trim($data) == "")
			{
				$data = "\n(0)Records Found!\n";
			}
		}
		if ($download != "")
		{
			header('Content-Type: application/msexcel');
			header('Content-Disposition: attachement; filename="' . $download . '"');
			header("Pragma: no-cache");
			header("Expires: 0");
			print "$header\n$data";
		}
	}
//=============================================End Export=================================================

}
    /* End of Function */


/*

 * function:: generate password
 * author:: Arvind Soni
 * This function generate random 6 digit number
 */
if(! function_exists('generate_password')){
    function generate_password(){
        return random_string('numeric',6);
    }
}
/* End of Function */


/*

 * function:: generate password
 * author:: Arvind Soni
 * This function generate random 6 digit number
 */
if(! function_exists('get_foodCategoryName')){
    function get_foodCategoryName($indx){
        $foodCAT    =   array('1'=>'Food Truck','2'=>'Food Stall','3'=>'Home Made Food');
        return $foodCAT[$indx];
    }
}
/* End of Function */


/*

 * function:: get_cat
   author:: Dharmendra Pal
 * This function single row  */
function get_cat($table,$id = NULL)
{
	$CI =& get_instance();

	$CI->db->where('id',$id);
	$r    = $CI->db->get($table);

	return $r->row();
}
/* End of Function */


/*
* function:: get image
author:: Dharmendra Pal
* This function get image */
if(! function_exists('get_file')){
 function get_file($path=null,$filename=null){
    if(isset($path) && isset($filename)){
        $uploaded_path = base_url()."uploads/".$path;
        $filename =  $uploaded_path.'/'.$filename;

    } else {
        $filename = 'uploads/placeholder.png';
    }

     return $filename;
 }
}
/* End of Function */



/*
* function:: get image thumb
author:: Dharmendra Pal
* This function get image */
if(! function_exists('get_image_thumb')){
    function get_image_thumb($filename=null,$type){

        /*type= _thumb, 40x40, 100x100, 200x200*/
        if($type && $filename){
            $image_expl = explode('.',$filename);
            $thumb_name = $image_expl[0]."_".$type.'.'.@$image_expl[1];

        } else {
            $thumb_name = '';
        }

        return $thumb_name;
    }
   }
   /* End of Function */

/*
* function:: get image thumb with ext a
author:: Dharmendra Pal
* This function get image */
if(! function_exists('get_image_thumb_a')){
    function get_image_thumb_a($filename=null,$type){

        /*type= _thumb, 40x40, 100x100, 200x200*/
        if($type && $filename){
            $image_expl = explode('.',$filename);
            $thumb_name = $image_expl[0]."a_".$type.'.'.@$image_expl[1];

        } else {
            $thumb_name = '';
        }

        return $thumb_name;
    }
   }
   /* End of Function */


   function createUrlByTitleAndId($title,$id)
   {
       return RemoveSpecialChar($title)."-".ID_encode($id);
   }

/*
* function::
author:: Dharmendra Pal
* This function get image */
if(! function_exists('RemoveSpecialChar')){
function RemoveSpecialChar($value){
    $result  = preg_replace('/[^a-zA-Z0-9_]/s','_',$value);

    return $result;
    }

}
/* End of Function */

if(! function_exists('getIdByUrl')){
    function getIdByUrl($url){
        $url_break = explode('-',$url);
        $Id         = ID_decode($url_break[1]);
        return $Id;
    }

}


/*
* function:: get_days
 * author:: Arvind Soni
 *  This function get days
*  */
if(! function_exists('get_days')){
 function get_days(){
    $days   =   array();
    $days['Monday']='Monday';
    $days['Tuesday']='Tuesday';
    $days['Wednesday']='Wednesday';
    $days['Thursday']='Thursday';
    $days['Friday']='Friday';
    $days['Saturday']='Saturday';
    $days['Sunday']='Sunday';
    return $days;
 }
}
/* End of Function */

/*
* function:: get_hours
 * author:: Arvind Soni
 *  This function get hours
*  */
if(! function_exists('get_hours')){
 function get_hours(){
    $hours   =   array();
    $hour = 0;
    while($hour < 24)
    {
        $hours[date('H:i:s',mktime($hour,0,0,1,1,2011))] = date('H:i',mktime($hour,0,0,1,1,2011));
        $hour++;
    }
    return $hours;
 }
}
/* End of Function */

/*
* function:: get_radious
 * author:: Arvind Soni
 *  This function get radious
*  */
if(! function_exists('get_radious')){
 function get_radious(){
    $radious   =   array();
    $r = 100;
    while($r < 2000)
    {
       $radious[$r]=$r.' M';
       $r=$r+100;
    }
    return $radious;
 }
}
/* End of Function */
if(! function_exists('generate_otp')){
 function generate_otp(){
    $otp   =  rand(1000,9999);
    return $otp;
 }
}

/*
 * function:: get_menu_sub_category
   author:: Dharmendra Pal
 * This function single row  */
function get_menu_sub_category($menu_category_id,$menu_subcategory_id = null)
{
	$CI =& get_instance();
	$CI->db->where('parent',$menu_category_id);
	if(isset($menu_subcategory_id) && $menu_subcategory_id != '')
	{
		$CI->db->or_where('id',$menu_subcategory_id);
	}
	$r    = $CI->db->get('fs_menu_category');
	if($r->num_rows() > 0)
	{
		return $r->result();
	}else{
		return false;
	}
}
/* End of Function */


function get_user_currency()
{
    return "Rs.";
}

function get_location_by_session($session_index,$type = ''){
    $CI =& get_instance();
    $locationSession =   $CI->session->userdata($session_index);
    if($type)
    {
        return $locationSession[$type];
    }else{
        $locationSession =   $CI->session->userdata($session_index);
        return $locationSession;
    }
}

function get_cart_stall_id()
{
    $CI =& get_instance();
	$stall_data_session	=	$CI->session->userdata('stall_data_session');
	return $stall_data_session['stall_id'];
}

function get_plan_data($vendor_id){
	$CI =& get_instance();
	$CI->db->select('fsud.pm_active_plan_id,fsud.pm_plan_start_date,fsud.pm_plan_expire_date,fsupp.*');
	$CI->db->join('fs_user_plan_payment as fsupp','fsupp.user_id=fsud.user_id');
	$CI->db->where('fsud.user_id',$vendor_id);
	$CI->db->where('fsupp.status','active');
	$result = $CI->db->get('fs_users_details as fsud');
	if($result->num_rows() > 0){
		$user_data	=	$result->result();
		$user_data	=	$user_data[0];
		$current_date 	=	date('Y-m-d');
		$data['pay_instant_or_later']		=	$user_data->pay_instant_or_later;
		$data['pay_online_or_bank_deposit']	=	$user_data->pay_online_or_bank_deposit;
		$data['plan_id']					=	$user_data->plan_id;
		$data['plan_payment_approve']		=	$user_data->is_approve;
		if($user_data->is_approve 	==	'1'){	/*plan is approved*/

			$data['is_active']	=	'yes';
			$data['plan_id']	=	$user_data->pm_active_plan_id;

			if($user_data->pm_active_plan_id == '1'){	/*pay annualy*/

				if($user_data->pay_instant_or_later	==	'1'){		/*pay instant*/
					if($user_data->pay_online_or_bank_deposit == '1'){	/*pay online*/
						if($current_date <= date('Y-m-d',strtotime($user_data->pm_plan_expire_date)))
						{
							$data['menu_limit']	=	'unlimit';
						}else{
							$data['is_active']	=	'no';
						}
					}else if($user_data->pay_online_or_bank_deposit == '2'){	/*Bank deposit*/
						if($current_date <= date('Y-m-d',strtotime($user_data->pm_plan_expire_date)))
						{
							$data['menu_limit']	=	'unlimit';
						}else{
							$data['is_active']	=	'no';
						}
					}
				}else if($user_data->pay_instant_or_later	==	'2'){		/*Pay later*/
					$data['menu_limit']	=	'5';
				}else if($user_data->pay_instant_or_later	==	'0'){		/*Pay later*/
					$data['menu_limit']	=	'5';
				}
			}else if($user_data->pm_active_plan_id == '2'){		/*pay per order*/
				$data['menu_limit']	=	'unlimit';
			}
			//pr($user_data);
		}else{
			$data['is_active']	=	'no';
			$data['menu_limit']	=	'5';
		}
		return $data;
	}else{
		return false;
	}



}



function featured_stall_by_location_and_type($food_stall_type = null,$limit = null){
		$CI 			=	& get_instance();
		$current_date 	= 	date('Y-m-d');
		$stall_data		=	$CI->session->userdata('stall_data_session');
		$stall_id   	= 	$stall_data['stall_id'];
		$stall_location_session = $CI->session->userdata('stall_location_session');

		$CI->db->select('fsu.*,fsud.food_joint_name As title,fsud.about as description,fsud.logo_image as image,fsud.banner_image,fsud.food_joint_name,fsud.google_search_address');
		$CI->db->join('fs_users_details as fsud','fsu.id=fsud.user_id');
		$CI->db->where('fsu.plan_featured_id !=','0');
		$CI->db->where('fsu.plan_featured_end_date >',$current_date);
		if($stall_location_session['location'] != ''){
			$CI->db->where('fsud.google_search_address',$stall_location_session['location']);
		}
		if(isset($food_stall_type) && $food_stall_type != '')
		{
			$CI->db->where('fsu.food_stall_type',$food_stall_type);
		}
		$CI->db->order_by('fsu.avg_rating','desc');
		if(isset($limit) && $limit != '')
		{
			$CI->db->limit($limit);
		}
		$result = $CI->db->get('fs_users AS fsu');
		return $result->result();
	}

	/**
 * get user role group
 * fetch user role group asssign
 * */
if (!function_exists('get_role_group')) {

    function get_role_group() {
        $CI = &get_instance();
        $CI->db->select("id,role_name");
        $CI->db->where('status', 'active');
		$CI->db->where('id != ', '3');	/*this is seller role id so */
        $query = $CI->db->get('fs_roles');

        if ($query->num_rows()) {
            $res = $query->result();
            return $res;
        }
        return false;

    }

}





function cooking_institute_slider_by_institute_id($institute_id = null){
		$CI 			=	& get_instance();

		$institute_id   	= 	$institute_id;
		//$stall_location_session = $CI->session->userdata('stall_location_session');
		$CI->db->select("id");

		//$CI->db->where('id ', $institute_id);	/*this is seller role id so */
        $query = $CI->db->get('fs_cooking_institutes');
		$res[] = '';
        if ($query->num_rows()) {
            $res = $query->result();
			//pr($institute_id);
			//pr($res);die;
			if(!empty($res))
			{
				$prev_key = '';
				$next_key = '';
				foreach($res as $key => $val){

					$dat_key = $key;
					$dat_val = $val->id;
					if($val->id == $institute_id){

							//pr($dat_key);
							$next_key = $dat_key +1;
							$prev_key = $dat_key -1;


					}

				@$res['prev_val'] = $res[$prev_key]->id;
				@$res['next_val'] = $res[$next_key]->id;
					}


					//$next_key =






			}
			//pr($res);die;
            return $res;
        }
        return false;
	}




/**
 * has user permission
 * this function is used to check user permission
 * */
function has_permission($controller, $action) {
	if(currentuserinfo()->role_id == '1'){
		return true;
	}
    $CI = &get_instance();
    $submoduel_id = 0;
    $dataqry = $CI->db->select('id')->from("fs_modules")->where(array("module_value" => $controller, "parent_id !=" => 0, "status" => 'active'))->get()->row();
	if ($dataqry) {
        $submoduel_id = @$dataqry->id;
    }
    if ($submoduel_id > 0) {
        $get_perm_qry = $CI->db->select('method_id')->get_where('fs_roles_modules_mapping', array('role_id' => currentuserinfo()->role_id, 'submoduel_id' => $submoduel_id));
	   if ($get_perm_qry->num_rows()) {
            $all_method = isset($get_perm_qry->row()->method_id) ? explode(',', $get_perm_qry->row()->method_id) : array();
            $CI->db->where_in('id', $all_method);
            $get_mth_qry = $CI->db->select('method_value')->get_where('fs_method', array('status' => 'active'));
            if ($get_mth_qry->num_rows()) {
                $prm_method = array();
                $i = 0;
                foreach ($get_mth_qry->result() as $val) {
                    $prm_method[$i] = $val->method_value;
                    $i++;
                }
                if (in_array($action, $prm_method)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function social_media(){
	 $CI = &get_instance();
	    $CI->db->select('id,social_media_name,link');
		$CI->db->from('fs_social_media');
		$query = $CI->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
/* End of Function */


/**
 * unique_email
 *
 * This function to check  unique user email
 * @param string
 *
 */
if (!function_exists('unique_email')) {
    function unique_email($email='',$id=''){

        $CI = &get_instance();
        $CI->db->select('id');
        $CI->db->where('email',$email);

        if($id!=''){
        $CI->db->where("id != ", "$id");
        }
        $query  =   $CI->db->get("fs_newbee");

        if ($query->num_rows()){

            return 200;
        }
        else{

           return 404;
        }

       return 404;

    }
}
/*End of function*/

/**
 * unique_mobile
 *
 * This function to check  unique mobile
 * @param string
 *
 */
if (!function_exists('unique_mobile')) {
    function unique_mobile($mobile='',$id=''){

        $CI = &get_instance();
        $CI->db->select('id');
        $CI->db->where('mobile',$mobile);

        if($id!=''){
        $CI->db->where("id != ", "$id");
        }
        $query  =   $CI->db->get("fs_newbee");

        if ($query->num_rows()){

            return 200;
        }
        else{

           return 404;
        }

       return 404;

    }
}
/*End of function*/

/**
 * get_adminInfo
 *
 * This function to fetch admin Info
 * @param string
 *
 */
if (!function_exists('get_adminInfo')) {
    function get_adminInfo(){
        $CI = &get_instance();
        $CI->db->select("id,concat(first_name,' ',last_name) as user_name,first_name,last_name,email,mobile_number,profile_image");
        $CI->db->where('user_type','1');
        $query  =   $CI->db->get("fs_users");
        if($query->num_rows()){
           $rs_data['result']   =   $query->row();
           $rs_data['status']   =   "success";
        }else{
           $rs_data['result']   =   '';
           $rs_data['status']   =   "error";
        }
        return $rs_data;
    }
}
/*End of function*/

/**
 * get_userInfo
 *
 * This function to fetch admin Info
 * @param string
 *
 */
if (!function_exists('get_userInformations')) {

    function get_userInformations($user_id = NULL){
       // pr($user_id);die;
        $CI = &get_instance();
        $CI->db->select("id,username,status,delete_status");
        $CI->db->where('id',$user_id);
        $query  =   $CI->db->get("tbl_users");
        if($query->num_rows()){
           $rs_data['result']   =   $query->row();
           $rs_data['status']   =   "success";
        }else{
           $rs_data['result']   =   '';
           $rs_data['status']   =   "error";
        }
        return $rs_data;
    }
}
if (!function_exists('get_userData')) {

    function get_userData($user_id = NULL){
       // pr($user_id);die;
        $CI = &get_instance();
        $CI->db->select("id,username,email_address,mobile");
        $CI->db->where('id',$user_id);
        $query  =   $CI->db->get("tbl_users");
        if($query->num_rows()){
           $rs_data['result']   =   $query->row();
           $rs_data['status']   =   "success";
        }else{
           $rs_data['result']   =   '';
           $rs_data['status']   =   "error";
        }
        return $rs_data;
    }
}
/*End of function*/


/*Geeting current store id*/
if (!function_exists('get_store_id')) {
    function get_store_id($for_what=''){
        $CI = &get_instance();
        $user_preference = $CI->session->userdata('user_preference');
        // pr($user_preference);die;
        if(isset($user_preference->order_type) && $user_preference->order_type == 1)
        {
            $store_id = $user_preference->order_preference_store;
        }
        elseif(isset($user_preference->order_type) && $user_preference->order_type ==2)
        {
            $store_id = $user_preference->delivery_store_id;
        }
		else{
            $defaultStore = getDefaultStore(); //pr($defaultStore);  die;
			if($defaultStore)
			{
				$data_store = $defaultStore;
				$store_id  = $defaultStore->store_id;
			}
			else
			{
				$data_store='';
				$store_id =0;
			}
        }

		if(isset($for_what) && $for_what == 'id'){
            return $store_id;
        }elseif(isset($for_what) && $for_what == 'data'){
            return $data_store;
        }
        else
        {
        	return '';
        }
    }
}


if (!function_exists('get_store_id_for_api')) {
    function get_store_id_for_api($for_what='',$user_id=''){
        $CI = &get_instance();
        $CI->load->model('Webservices_model/Cart_model');
        $user_preference_data = $CI->Cart_model->get_user_preference_data($user_id);

        if(isset($user_preference_data->order_preference_store) && isset($user_preference_data->order_preference_store) && $user_preference_data->order_preference_store != NULL && isset($user_preference_data->order_preference_store) && $user_preference_data->order_preference_store != 0){
            $store_id = $user_preference_data->order_preference_store;
        }else{
            $defaultStore = getDefaultStore(); //pr($defaultStore);  die;
            if($defaultStore)
            {
                $data_store=$defaultStore;
                $store_id =$defaultStore->store_id;
            }
            else
            {
                $data_store='';
                $store_id ='';
            }
        }

        if(isset($for_what) && $for_what == 'id'){
            return $store_id;
        }elseif(isset($for_what) && $for_what == 'data'){
            return $data_store;
        }
        else
        {
            return '';
        }
    }
}

/**End of Function*/

/*Geeting copyright Information*/
if (!function_exists('cartfull_copy_right')) {
    function cartfull_copy_right(){
        $CI = &get_instance();
        $CI->db->select("id,var_name,var_title,setting_value");
        $CI->db->where('id',4);
        $query  =   $CI->db->get(" tbl_website_setting");
		if($query->num_rows() > 0){
			$result = $query->row();

		}else{
			$result = "Copyright © 2018 by Cartfull. All rights reserved";
		}
		return $result;
    }
}
/**End of Function*/

function get_words_until($paragraph, $limit, $delimiter = ' ', $ellipsis = null)
{
    $parts = explode($delimiter, $paragraph);

    $preview = "";

    if ($ellipsis) {
        $limit = $limit - strlen($ellipsis);
    }

    foreach ($parts as $part) {
        $to_add = $part . $delimiter;
        if (strlen($preview . trim($to_add)) <= $limit) { // Can the part fit?
            $preview .= $to_add;
            continue;
        }
        if (!strlen($preview)) { // Is preview blank?
            $preview = substr($part, 0, $limit - 3) . '...'; // Forced ellipsis
            break;
        }
    }

    return trim($preview) . $ellipsis;
}

/* GEt all products names according product ids*/
function get_products_names($product_ids){

	if(!empty($product_ids)){
		$products_ids_arr = explode(',',$product_ids);
		//pr($products_ids_arr);die;
		$CI = &get_instance();
        $CI->db->select("product_name");
		$CI->db->where_in("product_id",$products_ids_arr);
		$query = $CI->db->get('tbl_product');
		if($query->num_rows() >0){
			$products_name_arr =array();
			$products = $query->result();
			foreach($products as $val){
				array_push($products_name_arr,$val->product_name);

			}
			//pr($products_name_arr);die;
			$data['product_names'] = implode(',',$products_name_arr);
			$data['product_ids']= $product_ids;
			return $data;

		}
	}


}
/* Get all store city names by city ids*/

function get_store_city_name($city_id){

	if(!empty($city_id)){

		$CI = &get_instance();
        $CI->db->select("city_name");
		$CI->db->where("id",$city_id);
		$query = $CI->db->get('tbl_cities');
		if($query->num_rows() >0)
		{
			$city_name = $query->row()->city_name;
			return $city_name;
		}
	}
}

/* Get all store city names by city ids*/

function subcategory_count($cat_id){

	if(!empty($cat_id)){

		$CI = &get_instance();
        $CI->db->select("COUNT(id) as Subcategory");

		$CI->db->where("parent_id =",$cat_id);
		$query = $CI->db->get('tbl_categories');
		if($query->num_rows() >0)
		{
			$subcategory_count = $query->row()->Subcategory;
			//pr($subcategory_count);die;

			return $subcategory_count ;

		}
	}
}

function getMetaTags($product_url){
    $data   =   '';
    $CI = & get_instance();
    $CI->db->select("p.product_metatitle,p.product_metakeyword,p.product_metadescription,p.product_id");
    $CI->db->where('p.product_url',$product_url);

	$query = $CI->db->get("tbl_product as p");
    if($query->num_rows()>0){
        $data = $query->row_array();
    }
    return $data;
}

function check_category_status($category_id = ''){

    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->where('id',$category_id);
    $CI->db->where('status','Active');
    $query = $CI->db->get("tbl_categories");
    if($query->num_rows()>0){
       return $query->row();
    }else{
        return false;
    }
}

function currect_single_data($rawData = ''){
	if(!isset($rawData) || empty($rawData)) {return false; }
	$CI = & get_instance();
	$CI->load->model('search_model');
	$weight_id = explode(',',$rawData->weight_ids);
    $product_price = explode(',',$rawData->product_price);
    $product_pec_weight = explode(",", $rawData->product_pec_weight);
    $product_s_price = explode(',',$rawData->product_s_price);
    $new_weight_id 			= [];
    $new_product_price 		= [];
    $new_product_s_price 	= [];
    $new_product_pec_weight = [];
    asort($product_price);

    foreach ($product_price as $key => $new_product) {

    	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
    	$new_weight_id[] 				= $weight_id[$key];
    	$new_product_price[] 			= $product_price[$key];
    	$new_product_s_price[] 			= $product_s_price[$key];
    }

    $rawData->vid = $new_weight_id[0];
    $rawData->product_price1 = $new_product_price[0];
    $rawData->product_pec_weight1 = $new_new_product_pec_weight[0];
    $rawData->product_s_price1 = $new_product_s_price[0];
    $CI->db->select('special_price_start_date, special_price_end_date, set_quantity');
    $CI->db->where('id',$new_weight_id[0]);
    $ress = $CI->db->get('tbl_product_price')->row();
    $rawData->special_price_start_date = $ress->special_price_start_date;
    $rawData->special_price_end_date = $ress->special_price_end_date;
    $rawData->set_quantity 	= $ress->set_quantity;
    $rawData->weight_id 	= implode(",", ($new_weight_id));
    $rawData->product_price = implode(",", ($new_product_price));
    $rawData->product_pec_weight = implode(",", ($new_new_product_pec_weight));
    $rawData->product_s_price = implode(",", ($new_product_s_price));
    $rawData->gallery_images   = $CI->search_model->fetch_gallery($new_weight_id[0]);
    $rawData->image = @$gallery_images[0]->image;
	#Data manupulating
    return $rawData;
}

 function changePriceByStore($product_data,$weight_id){
    $CI = & get_instance();
   // return $product_data;
    $check_store_id = get_store_id('id');
    // pr($product_data);
    if($product_data->product_pec_weight && $check_store_id){
        $CI->db->select('*');
        $CI->db->where('main_price_id',$weight_id);
        $CI->db->where('store_id',$check_store_id);
        $ress = $CI->db->get('tbl_product_price_store_wise')->row();

        //echo  $CI->db->last_query();
       // pr($ress);die;

            ////////////////////////////////////
            if(isset($ress->product_price) && (int)$ress->product_price>0){
                $product_data->product_price = $ress->product_price;
            }
            if(isset($ress->product_s_price) && (int)$ress->product_s_price>0){
                $product_data->product_s_price = $ress->product_s_price;
                $product_data->special_price_start_date = $ress->special_price_start_date;
                $product_data->special_price_end_date = $ress->special_price_end_date;
                $product_data->set_quantity 	= $ress->set_quantity;
            }

           // pr($product_data);die;
            ////////////////////////////////////
            return $product_data;
    }else{
        return false;
    }


}

 ##########for store wise price on product detail page api starts####################
 function get_weight_data_store_wise_api($product_data,$weight_ids_array,$store_id){
    $CI = & get_instance();


        if($weight_ids_array && $store_id){
            $ress = null;
            $CI->db->select('*');

            if(!is_array($weight_ids_array)){
                $CI->db->where('main_price_id',$weight_ids_array);
            }else{
                $CI->db->where_in('main_price_id',$weight_ids_array);
            }
            $CI->db->where('store_id',$store_id);
            $ress = $CI->db->get('tbl_product_price_store_wise')->row();

            //   echo  $CI->db->last_query();
            //   pr($ress);die;

                ////////////////////////////////////
                if(isset($ress->product_price) && (int)$ress->product_price>0){
                    if(is_array($product_data)){
                        $product_data[0]->vid = $weight_ids_array[0];
                       // $product_data[0]->id = $weight_ids_array[0];
                        $product_data[0]->product_price = $ress->product_price;
                    }else{
                        $product_data->vid = $weight_ids_array;
                       // $product_data->id = $weight_ids_array;
                        $product_data->product_price = $ress->product_price;
                    }

                }
                if(isset($ress->product_s_price) && (int)$ress->product_s_price>0 && isset($ress->product_price) && (int)$ress->product_price>0){
                    if(is_array($product_data)){
                        $product_data[0]->product_s_price = $ress->product_s_price;
                        $product_data[0]->special_price_start_date = $ress->special_price_start_date;
                        $product_data[0]->special_price_end_date = $ress->special_price_end_date;
                        $product_data[0]->set_quantity 	= $ress->set_quantity;
                    }else{
                        $product_data->product_s_price = $ress->product_s_price;
                        $product_data->special_price_start_date = $ress->special_price_start_date;
                        $product_data->special_price_end_date = $ress->special_price_end_date;
                        $product_data->set_quantity 	= $ress->set_quantity;
                    }
                }

                ////////////////////////////////////

        }

        //if(){
           // pr($product_data);die;
       // }

    return $product_data;

 }



##########for store wise price on product detail page api ends####################

/////it is a function called on clicking at cart icon right side & checkout & paynow button starts//////
function getProductByPrice_store_wise($rawData = '',$main_weight_id='',$store_id=''){

    $CI = & get_instance();
    //  return $rawData;
    if($store_id ==''){
        $check_store_id = get_store_id('id');
    }else{
        $check_store_id = $store_id;
    }
    if($rawData=='')
	{
		return false;
	}
   // pr($rawData);
    $CI->db->select('*');
    $CI->db->where('main_price_id',$rawData->id);
    $CI->db->where('product_id',$rawData->product_id);
    $CI->db->where('store_id',$check_store_id);
    $ress = $CI->db->get('tbl_product_price_store_wise')->row();
    //pr($ress);
    //echo $CI->db->last_query(); die;
    if(isset($ress->product_price) && (int)$ress->product_price>0){
        $rawData->product_price = $ress->product_price;
    }
    if(isset($ress->product_s_price) && (int)$ress->product_s_price>0){
        $rawData->product_s_price = $ress->product_s_price;
        $rawData->special_price_start_date = $ress->special_price_start_date;
        $rawData->special_price_end_date = $ress->special_price_end_date;
        $rawData->set_quantity 	= $ress->set_quantity;
    }
    return $rawData;
    //pr($rawData);die;
}


function changePriceByStore_backend($product_data,$store_id){

 //pr($product_data);
// echo("<br>~~~~~~~~~~~<br>");die;

$create = date('Y-m-d',strtotime($product_data['created_date']));

    $CI = & get_instance();
    $check_store_id = $store_id;
    $weight_id = $product_data['product_weight_id'];


        $CI->db->select('*');
        $CI->db->where('id',$weight_id);
        $centralised = $CI->db->get('tbl_product_price')->row();

        // pr($create);
        // pr($centralised);
                if((int)$centralised->product_price>0){
                    $product_data[0]['act_price'] = $centralised->product_price;
                    $product_data[0]['unit_price'] = $centralised->product_price;
                    $product_data[0]['redeem_limit'] 	= 0;
                    $product_data[0]['offer_type'] 	= null;
                }
                if((int)$centralised->product_s_price>0 && (int)$centralised->product_price>0 &&  strtotime($create)>=strtotime($centralised->special_price_start_date) && strtotime($create)<=strtotime($centralised->special_price_end_date)){
                    $product_data[0]['unit_price'] = $centralised->product_s_price;
                    $product_data[0]['redeem_limit'] 	= $centralised->set_quantity;
                    $product_data[0]['offer_type'] 	= '3';
                //    echo "here";die;
                }else{
                    // if((int)$centralised->product_s_price>0 && (int)$storewise->product_s_price>0 &&  strtotime($create)>=strtotime($centralised->special_price_start_date) && strtotime($create)<=strtotime($centralised->special_price_end_date)){
                    // }
                    $CI->db->select('*');
                    $CI->db->where('buy_item_product',$weight_id);
                    $CI->db->where('valid_from<=',date('Y-m-d H:i:s'));
                    $CI->db->where('valid_to>=',date('Y-m-d H:i:s'));
                    $CI->db->where('status=','1');
                    $mb_offer_data = $CI->db->get('tbl_offers')->row();
                 //  pr($mb_offer_data);
                    $free_item_product = explode(",",$mb_offer_data->free_item_product);

                    $free_item_quantity = explode(",",$mb_offer_data->free_item_quantity);
                    $buy_item_quantity = explode(",",$mb_offer_data->buy_item_quantity);
                    //pr($buy_item_quantity);die;
                    foreach ($free_item_product as $key => $value) {
                        $centralised =null;
                        $CI->db->select('*');
                        $CI->db->where('id',$value);
                        $centralised = $CI->db->get('tbl_product_price')->row();

                        $ress5 =null;
                        $CI->db->select('*');
                        $CI->db->where('product_id',$centralised->product_id);
                        $ress5 = $CI->db->get('tbl_product')->row();



                                if((int)$centralised->product_price>0){
                                    $product_data[$key+1]['free_weight_id'] = $value;
                                    $product_data[$key+1]['free_product_id'] = $ress5->product_id;

                                    $product_data[$key+1]['product_name'] = $ress5->product_name.'('.$centralised->product_pec_weight.')';
                                    $product_data[$key+1]['act_price'] = $centralised->product_price;
                                    $product_data[$key+1]['product_pec_weight'] = $centralised->product_pec_weight;
                                    $product_data[$key+1]['offer_type'] 	= '4';
                                    $product_data[$key+1]['redeem_limit'] 	= $free_item_quantity[$key];
                                    $product_data[$key+1]['buy_item_quantity'] 	= $buy_item_quantity[0];
                                }
                                // if((int)$centralised->product_s_price>0 && (int)$centralised->product_price>0){
                                //     $product_data[$key+1]['unit_price'] = $centralised->product_s_price;
                                //     $product_data[$key+1]['redeem_limit'] 	= $centralised->set_quantity;


                                // }
                                $store_wise =null;
                                $CI->db->select('*');
                                $CI->db->where('main_price_id',$value);
                                $CI->db->where('store_id',$check_store_id);
                                $store_wise = $CI->db->get('tbl_product_price_store_wise')->row();

                                if((int)$store_wise->product_price>0){
                                    $product_data[$key+1]['act_price'] = $store_wise->product_price;
                                    $product_data[$key+1]['offer_type'] 	= '4';

                                }
                                // if((int)$store_wise->product_s_price>0 && (int)$store_wise->product_price>0){
                                //     $product_data[$key+1]['unit_price'] = $store_wise->product_s_price;
                                //     $product_data[$key+1]['redeem_limit'] 	= $store_wise->set_quantity;

                                // }





                    }


                    //pr($mb_offer_data);die;
                }



            ////////////////////////////////////

            $CI->db->select('*');
            $CI->db->where('main_price_id',$weight_id);
            $CI->db->where('store_id',$check_store_id);
            $store_wise = $CI->db->get('tbl_product_price_store_wise')->row();
            if((int)$store_wise->product_price>0){
                $product_data[0]['act_price'] = $store_wise->product_price;
                $product_data[0]['unit_price'] = $store_wise->product_price;
                $product_data[0]['redeem_limit'] 	= 0;
                $product_data[0]['offer_type'] 	= null;
                //echo "store";
            }
            if((int)$store_wise->product_s_price>0 &&  (int)$store_wise->product_price>0 && strtotime($create)>=strtotime($store_wise->special_price_start_date) && strtotime($create)<=strtotime($store_wise->special_price_end_date)){
                $product_data[0]['unit_price'] = $store_wise->product_s_price;
                $product_data[0]['redeem_limit'] 	= $store_wise->set_quantity;
                $product_data[0]['offer_type'] 	= '3';
                //echo "store special";
            }

            if($product_data[0]['offer_type']==3){
                $product_datai[0] = $product_data[0];
                //pr($product_datai);die;
                return $product_datai;

            }else{
               // pr($product_data);die;
                return $product_data;
            }
            // echo 'dddd';

            // die;
            ////////////////////////////////////

          //  $product_data_new = enter_in_this($product_data);
            //return $product_data;
  //  }else{
      //  return false;
   // }


}


function changePriceByStore_backend2($product_data,$store_id){

   // pr($product_data);
    //echo("<br>~~~~~~~~~~~<br>");



        $CI = & get_instance();
        $check_store_id = $store_id;
        $weight_id = $product_data['product_weight_id'];

    //~~~~~~~~~~~~~~~~ Centralised Price~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

            $CI->db->select('*');
            $CI->db->where('id',$weight_id);
            $centralised = $CI->db->get('tbl_product_price')->row();
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    //~~~~~~~~~~~~~~~~ Storewise Price~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

            $CI->db->select('*');
            $CI->db->where('main_price_id',$weight_id);
            $CI->db->where('store_id',$check_store_id);
            $store_wise = $CI->db->get('tbl_product_price_store_wise')->row();
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // pr($centralised);
    //  pr($store_wise);

                    if((int)$centralised->product_price>0){
                        $product_data['act_price'] = $centralised->product_price;

                        if($product_data['offer_type']==4){
                            $product_data['offer_type'] 	= 4;

                        }else{
                            $product_data['unit_price'] = $centralised->product_price;
                            $product_data['offer_type'] 	= null;

                        }

                     //    echo "insideiiiiiiiiiiiiii";
                    }
                    $create = date('Y-m-d',strtotime($product_data['created_date']));
                    if((int)$centralised->product_s_price>0 && (int)$centralised->product_price>0 && strtotime($create)>=strtotime($centralised->special_price_start_date) && strtotime($create)<=strtotime($centralised->special_price_end_date)){
                        $product_data['unit_price'] = $centralised->product_s_price;
                        $product_data['redeem_limit'] 	= $centralised->set_quantity;
                        $product_data['offer_type'] 	= '3';
                      //  echo "insideqqqqqqqqqqqqqqqqqq";
                    }

                ////////////////////////////////////


                if((int)$store_wise->product_price>0){
                    $product_data['act_price'] = $store_wise->product_price;
                    $product_data['unit_price'] = $store_wise->product_price;
                    $product_data['redeem_limit'] 	= 0;
                    if($product_data['offer_type']==4){
                        $product_data['offer_type'] 	= 4;

                    }else{
                        $product_data['unit_price'] = $store_wise->product_price;
                        $product_data['offer_type'] 	= null;

                    }
                  //  echo "inside";
                }
                $create = date('Y-m-d',strtotime($product_data['created_date']));
                if((int)$store_wise->product_s_price>0 && (int)$store_wise->product_price>0 && strtotime($create)>=strtotime($store_wise->special_price_start_date) && strtotime($create)<=strtotime($store_wise->special_price_end_date)){
                    $product_data['unit_price'] = $store_wise->product_s_price;
                    $product_data['redeem_limit'] 	= $store_wise->set_quantity;
                    $product_data['offer_type'] 	= '3';
                  //   echo "inside date";
                }

                ////////////////////////////////////

              //  $product_data_new = enter_in_this($product_data);
            //   pr($ress);
          // pr($product_data);
                return $product_data;
      //  }else{
          //  return false;
       // }


    }
function enter_in_this($product_data,$store_id){

   // echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~agya~~~~~~~~~~~~~~~~~~~~~~~";

//pr($product_data);
//echo("<br>~~~~~~~~~~~<br>");



$CI = & get_instance();
$check_store_id = $store_id;
$weight_id = $product_data['product_weight_id'];
// pr($check_store_id);
// echo("<br>~~~~~~~~~~~ress<br>");
//  pr($weight_id);die;
//  if($product_data->product_pec_weight && $check_store_id){


    //echo  $CI->db->last_query();
    // pr($product_data);
    // pr($ress);

    $CI->db->select('*');
    $CI->db->where('id',$weight_id);
    $ress2 = $CI->db->get('tbl_product_price')->row();



            if((int)$ress2->product_price>0){
                $product_data[0]['act_price'] = $ress2->product_price;
                $product_data[0]['offer_type'] 	= null;
            }
            if((int)$ress2->product_s_price>0 && (int)$ress2->product_price>0){
                $product_data[0]['unit_price'] = $ress2->product_s_price;
                $product_data[0]['redeem_limit'] 	= $ress2->set_quantity;
                $product_data[0]['offer_type'] 	= '3';
            }else{
                $CI->db->select('*');
                $CI->db->where('buy_item_product',$weight_id);
                $CI->db->where('valid_from<=',date('Y-m-d H:i:s'));
                $CI->db->where('valid_to>=',date('Y-m-d H:i:s'));
                $CI->db->where('status=','1');
                $ress3 = $CI->db->get('tbl_offers')->row();

                $free_item_product = explode(",",$ress3->free_item_product);
                $free_item_quantity = explode(",",$ress3->free_item_quantity);
                $buy_item_quantity = explode(",",$ress3->buy_item_quantity);
                foreach ($free_item_product as $key => $value) {
                    $ress2 =null;
                    $CI->db->select('*');
                    $CI->db->where('id',$value);
                    $ress2 = $CI->db->get('tbl_product_price')->row();

                    $ress5 =null;
                    $CI->db->select('*');
                    $CI->db->where('product_id',$value);
                    $ress5 = $CI->db->get('tbl_product')->row();



                            if((int)$ress2->product_price>0){
                                $product_data[$key+1]['product_name'] = $ress5->product_name.'('.$ress2->product_pec_weight.')';
                                $product_data[$key+1]['act_price'] = $ress2->product_price;
                                $product_data[$key+1]['product_pec_weight'] = $ress2->product_pec_weight;
                                $product_data[$key+1]['offer_type'] 	= '4';
                                $product_data[$key+1]['redeem_limit'] 	= $free_item_quantity[$key];
                                $product_data[$key+1]['buy_item_quantity'] 	= $buy_item_quantity[$key];
                            }
                            // if((int)$ress2->product_s_price>0 && (int)$ress2->product_price>0){
                            //     $product_data[$key+1]['unit_price'] = $ress2->product_s_price;
                            //     $product_data[$key+1]['redeem_limit'] 	= $ress2->set_quantity;


                            // }
                            $ress =null;
                            $CI->db->select('*');
                            $CI->db->where('main_price_id',$value);
                            $CI->db->where('store_id',$check_store_id);
                            $ress = $CI->db->get('tbl_product_price_store_wise')->row();

                            if((int)$ress->product_price>0){
                                $product_data[$key+1]['act_price'] = $ress->product_price;
                                $product_data[$key+1]['offer_type'] 	= '4';

                            }
                            // if((int)$ress->product_s_price>0 && (int)$ress->product_price>0){
                            //     $product_data[$key+1]['unit_price'] = $ress->product_s_price;
                            //     $product_data[$key+1]['redeem_limit'] 	= $ress->set_quantity;

                            // }





                }


                //pr($ress3);die;
            }



        ////////////////////////////////////

        $CI->db->select('*');
        $CI->db->where('main_price_id',$weight_id);
        $CI->db->where('store_id',$check_store_id);
        $ress = $CI->db->get('tbl_product_price_store_wise')->row();
        if((int)$ress->product_price>0){
            $product_data[0]['act_price'] = $ress->product_price;
        }
        if((int)$ress->product_s_price>0 && (int)$ress->product_price>0){
            $product_data[0]['unit_price'] = $ress->product_s_price;
            $product_data[0]['redeem_limit'] 	= $ress->set_quantity;
            $product_data[0]['offer_type'] 	= '3';
        }
     //pr($product_data);die;

        // echo 'dddd';

        // die;
        ////////////////////////////////////

      //  $product_data_new = enter_in_this($product_data);
       // return $product_data;
   $normal_productssss = $product_data;

   unset($normal_productssss['product_weight_id']);
 // pr($normal_productssss);

//    for ($i=0; $i < ; $i++) {
//        # code...
//    }
   //$normal_productts[0] = $normal_productss[0];
    foreach ($normal_productssss as $key => $normal_product) {
      // pr($normal_product);
        $act_price = 0;
        $unit_price = 0;
        $redeem_limit = 0;
        $product_qty_price = 0;
        $product_qty = 0;
        //$product_qty = $_POST['qnty'];

        if($normal_product['offer_type']!=4){
            $redeem_limit = $normal_product['redeem_limit'];
        }
     $act_price = $normal_product['act_price'];

     if($normal_product['unit_price']){
        $unit_price = $normal_product['unit_price'];
     }else{
        $unit_price = $act_price;
     }

     if($normal_product['offer_type']==3){

        $product_qty = $_POST['qnty'];
        $product_qty_price = $product_qty-$redeem_limit;
     }

     if($normal_product['offer_type']==4){
        // $product_qty = $_POST['qnty'];
        $product_qty = (int)($_POST['qnty']/$normal_product['buy_item_quantity'])*$normal_product['redeem_limit'];

        $unit_price = 0;
     }
     if($normal_product['offer_type']=='' || $normal_product['offer_type']==null){
        $product_qty = $_POST['qnty'];
     }


    }


    }

/////it is a function called on clicking at cart icon right side & checkout & paynow button ends//////

function currect_single_data_store_wise($rawData = '',$main_weight_id='',$store_id='',$wishlist=''){
    $CI = & get_instance();
   // return $rawData;

//   if($rawData->vid==10303){

//     pr($store_id);
//     pr($rawData);
// }

    if($store_id ==''){
        $check_store_id = get_store_id('id');
    }else{
        $check_store_id = $store_id;
    }
	if($rawData=='')
	{
		return false;
	}

	$CI->load->model('search_model');
    $weight_id = explode(',',$rawData->weight_ids);
    // if($CI->cache->file->get('currect_single_data_store_wise_'.$weight_id[0])){
    //     $rawData = $CI->cache->file->get('currect_single_data_store_wise_'.$weight_id[0]);
    //     return $rawData;
    // }
    $product_price          = explode(',',$rawData->product_price);
    $product_pec_weight     = explode(",", $rawData->product_pec_weight);
    $product_s_price        = explode(',',$rawData->product_s_price);
    $new_weight_id 			= [];
    $new_product_price 		= [];
    $new_product_s_price 	= [];
    $new_product_pec_weight = [];
    asort($product_price);
    foreach ($product_price as $key => $new_product) {

    	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
    	$new_weight_id[] 				= $weight_id[$key];
    	$new_product_price[] 			= $product_price[$key];
    	$new_product_s_price[] 			= $product_s_price[$key];
    }
    ////////////////for comma separated and and direct price value manupulation starts/////////
    $loop_data = $new_weight_id;
    foreach ($loop_data as $key_new_weight_id => $value_new_weight_id) {

        // $query = $CI->db->query("SELECT * FROM `tbl_product_price_store_wise` WHERE `main_price_id` ".$loop_data[$key_new_weight_id]." AND `store_id` = ".$check_store_id);
        $CI->db->where('main_price_id', $loop_data[$key_new_weight_id]);
        $CI->db->where('store_id',$check_store_id);
        $ress[$key_new_weight_id] = $CI->db->get('tbl_product_price_store_wise')->row();
        // if($rawData->vid==10303){
        //     echo $CI->db->last_query();
        //     $ress[$key_new_weight_id];
        //     echo '------------------------<br>';
        // }

        //echo $CI->db->last_query();
        if(isset($ress[$key_new_weight_id]->id) && $ress[$key_new_weight_id]->id!='' && isset($ress[$key_new_weight_id]->main_price_id) && isset($rawData->vid) && $ress[$key_new_weight_id]->main_price_id==$rawData->vid && isset($wishlist) && $wishlist=='' ){
            if((int)$ress[$key_new_weight_id]->product_price>0){
                $rawData->product_price1 = $ress[$key_new_weight_id]->product_price;
                $new_product_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_price;
            }
            if((int)$ress[$key_new_weight_id]->product_s_price>0){
                $rawData->product_s_price1 = $ress[$key_new_weight_id]->product_s_price;
                $rawData->special_price_start_date = $ress[$key_new_weight_id]->special_price_start_date;
                $rawData->special_price_end_date = $ress[$key_new_weight_id]->special_price_end_date;
                $rawData->set_quantity 	= $ress[$key_new_weight_id]->set_quantity;
                $new_product_s_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_s_price;
            }
        }

        if(isset($ress[$key_new_weight_id]->id) && $ress[$key_new_weight_id]->id!='' && isset($wishlist) && $wishlist=='1'){

            if(isset($ress[$key_new_weight_id]->product_price) && (int)$ress[$key_new_weight_id]->product_price>0){
                $rawData->product_price1 = $ress[$key_new_weight_id]->product_price;
                $new_product_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_price;
            }
            if(isset($ress[$key_new_weight_id]->product_s_price) && (int)$ress[$key_new_weight_id]->product_s_price>0){
                $rawData->product_s_price1 = $ress[$key_new_weight_id]->product_s_price;
                $rawData->special_price_start_date = $ress[$key_new_weight_id]->special_price_start_date;
                $rawData->special_price_end_date = $ress[$key_new_weight_id]->special_price_end_date;
                $rawData->set_quantity 	= $ress[$key_new_weight_id]->set_quantity;
                $new_product_s_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_s_price;
            }
        }
        if(isset($ress[$key_new_weight_id]->id) && $ress[$key_new_weight_id]->id!=''){
            if(isset($ress[$key_new_weight_id]->product_price) && (int)$ress[$key_new_weight_id]->product_price>0){
                $new_product_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_price;
            }
            if(isset($ress[$key_new_weight_id]->product_s_price) && (int)$ress[$key_new_weight_id]->product_s_price>0){
                $new_product_s_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_s_price;
            }
        }
    }


   ////////////////for comma separated and and direct price value manupulation ends/////////
    if($wishlist=='1'){
        $rawData->product_price1 	= $new_product_price[0];
        $rawData->product_s_price1 	= $new_product_s_price[0];
    }
    $rawData->weight_ids 	   		= implode(",", ($new_weight_id));
    $rawData->product_price     	= implode(",", ($new_product_price));
    $rawData->product_pec_weight 	= implode(",", ($new_new_product_pec_weight));
    $rawData->product_s_price 		= implode(",", ($new_product_s_price));
    $rawData->gallery_images   		= $CI->search_model->fetch_gallery($new_weight_id[0]);
    $rawData->image 				= @$gallery_images[0]->image;
    #Data manupulating


    // if($rawData->vid==10303){
    //     pr($rawData);die;
    // }
    ###############caching save starts######################
    // $CI->cache->file->save('currect_single_data_store_wise_'.$weight_id[0],$rawData, CACHE_EXPIRE);

    ###############caching save ends######################
    //pr($rawData);die;
    return $rawData;
}

function getDiscountOnProduct_main_all($product_id,$price,$store_id,$user_id)
    {

            // pr($product_id);
            // pr($price);

            // pr($store_id);
            // pr($user_id);die;

        $CI = & get_instance();
        $all_discount_list = getDiscountOnProductForListing_all($product_id,$price,$store_id,$user_id);
      // pr($all_discount_list);die;

       foreach ($all_discount_list as $key_all_discount_list => $value_all_discount_list) {

            if(!empty($value_all_discount_list)){
                $discount_data[$key_all_discount_list]['discount']          =   $value_all_discount_list[0]->discountamount;
                $discount_data[$key_all_discount_list]['discount_type']     =   $value_all_discount_list[0]->discount_type;
                $discount_data[$key_all_discount_list]['discount_id']       =   $value_all_discount_list[0]->id;
                $discount_data[$key_all_discount_list]['discount_title']    =   $value_all_discount_list[0]->discount_title;
            }
            else{
                $discount_data[$key_all_discount_list] = false;
            }
        }
      // pr($all_discount_list);die;
        return $discount_data;
    }

    function getDiscountOnProductForListing_all($pid=array(),$price=1,$store=0,$user_id=0) {
        date_default_timezone_set('Asia/Kolkata');
        $CI = & get_instance();
        $data = [];
        $prev_disc_amt = 0;
        $prev_disc_amt1 = 0;
        $disc_amt = 0;
        $date = date("Y-m-d H:i:s");
        $store =    isset($store)?$store:0;

        //pr($pid);
        //     pr($price);

        //     pr($store);
            //r($user_id);die;



        $sql_f='';
        $sql_f.='(';
        foreach ($pid as $key_pid => $value_pid) {
            if($key_pid!=0){
                $sql_f.= " OR FIND_IN_SET('".$value_pid."',`product`)";
            }else{
                $sql_f.= "FIND_IN_SET('".$value_pid."',`product`)";
            }

        }
        $sql_f.=')';

        $sql_price='';
        $sql_price.='(';
        foreach ($price as $key_price => $value_price) {
            if($key_price!=0){
               $sql_price.= " OR FIND_IN_SET('".$value_price."',`product_prices`)";
            }else{
                $sql_price.= "FIND_IN_SET('".$value_price."',`product_prices`)";
            }

        }
        $sql_price.=')';

        $sql_weight_ids='';
        $sql_weight_ids.='(';
        foreach ($pid as $key_pid => $value_pid) {
            if($key_pid!=0){
                $sql_weight_ids.= " OR FIND_IN_SET('".$value_pid."',`weight_ids`)";
            }else{
                $sql_weight_ids.= "FIND_IN_SET('".$value_pid."',`weight_ids`)";
            }

        }
        $sql_weight_ids.=')';
        // pr($sql_f);

        // pr($sql_price);

        // pr($sql_weight_ids);die;

      if( $user_id == 0){
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`)
        AND (CASE WHEN category_status = 2 THEN $sql_f ELSE (product = NULL OR product='') END)
        AND STATUS='Active' ";
        }
        else{
            $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND    FIND_IN_SET('".$store."',`store_id`)
                AND (CASE WHEN category_status = 2 THEN $sql_f ELSE (product = NULL OR product='') END)
                AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END)
                AND STATUS='Active' AND minunit>=1";

        }

        // if( $user_id == 0){
        //     $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`)
        //     AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
        //     AND STATUS='Active' ";
        // }
        // else{
        //     $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND    FIND_IN_SET('".$store."',`store_id`)
        //         AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
        //         AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END)
        //         AND STATUS='Active' AND minunit>=1";

        // }
         $query = $CI->db->query($sql);
       //echo $CI->db->last_query();die;
        // pr($query->result());die;
        if($query->num_rows() > 0){
            $all_discount_list = $query->result();
        // pr($all_discount_list);die;
            ###############for offer exclude starts###################

            ###############for offer exclude ends###################

            //if(!empty($all_discount_list) && count($all_discount_list)>0){

                if(!empty($all_discount_list) && count($all_discount_list)>0){
                    $i = 0;
                    foreach ($all_discount_list as $discount){
                        $redeem_limitss[$i]  = $discount->redeem_limit;
                        $discountss[$i]  = $discount->id;
                        $i++;
                    }

                   // pr($all_discount_list);die;
                    foreach ($pid as $key_pid => $value_pid) {
                      //  pr($value_pid);


                        //$check_redeem = chk_redeem_limit($value_pid,$user_id,$discount->id,'2',$discount->redeem_limit);
                       $check_redeem = chk_redeem_limit_all_product($pid, $user_id,$discountss, '2',$redeem_limitss);

                        pr($check_redeem);die;

                        //    pr($check_redeem);echo '<br>';
                    //    pr($discount);echo '<br>';
                    $check_redeem = 1;
                        if($check_redeem == 1){
                                if($discount->discount_type=='percentage'){
                                    $prev_disc_amt1 = $prev_disc_amt;
                                    $prev_disc_amt = $disc_amt;
                                    $disc_amt = ($price[$key_pid]*$discount->discountamount)/100;

                                }else if($discount->discount_type=='flat'){
                                    $prev_disc_amt1 = $prev_disc_amt;
                                    $prev_disc_amt = $disc_amt;
                                    $disc_amt = $discount->discountamount;
                                }
                                if($prev_disc_amt<$disc_amt)
                                {
                                    $prev_disc_amt = $prev_disc_amt1;
                                }
                                if($prev_disc_amt<$disc_amt)
                                {

                                    //pr($value_pid);echo '<br>';
                                    $data[$value_pid][0] = $discount;
                                    // if($is_excluded->is_excluded=='1'){
                                    //     $data[0] = $discount;
                                    // }
                                }
                                // echo "prev_disc_amt=> ".$prev_disc_amt."<br>";
                                // echo "disc_amt=> ".$disc_amt."<br>";
                            }

                }
            }
        }
        // pr($is_excluded);
      //pr($data);die;
        return $data;
    }

function chk_redeem_limit_all_product($variant_id=array(), $user_id, $offer_id, $offer_type, $redeem_limit=array()){

    $CI = &get_instance();


   // pr($variant_id);die;
    $CI->db->select('torl.*, SUM(torl.purchaged_limit) as purchaged_limit');
    $CI->db->join('tbl_order ord', 'torl.order_id=ord.order_details_id', 'left');
    $CI->db->where_not_in('ord.order_status',array('Cancel','PAYMENT FAILED','WAITING PAYMENT CONFIRMATION'));
    $CI->db->where('torl.offer_type',$offer_type);
    $CI->db->where('torl.user_id',$user_id);
    if($variant_id!='')
    {
        $CI->db->where_in('torl.variant_id',$variant_id);
    }
    $CI->db->where_in('torl.offer_id',$offer_id);
    $CI->db->where('torl.status',1);
    $CI->db->where('DATE(torl.date)=',date('Y-m-d'));
    $CI->db->group_by('torl.offer_type');
    $query = $CI->db->get('tbl_offer_redeem_limit torl');
    // echo $CI->db->last_query();die;
    // $sql = "SELECT *,SUM(`purchaged_limit`) as purchaged_limit FROM tbl_offer_redeem_limit WHERE variant_id='".$variant_id."' AND user_id = '".$user_id."' AND offer_id ='".$offer_id."' AND offer_type = '".$offer_type."'";
     //echo $CI->db->last_query();
    //\\ pr($query->row());die;
    // pr($query->num_rows());

    #############for daily redeem limit check starts####################
        $CI->db->select('*,DATE(date) as check_date');
        $CI->db->where('offer_type',$offer_type);
        $CI->db->where('user_id',$user_id);
        if($variant_id!='')
        {
            $CI->db->where_in('variant_id',$variant_id);
        }
        $CI->db->where_in('offer_id',$offer_id);
        $CI->db->where('status',1);
       // $CI->db->group_by('offer_type');
        $CI->db->order_by('id','DESC');
        $query_redeem = $CI->db->get('tbl_offer_redeem_limit');



    #############for daily redeem limit check starts####################



    if($query->num_rows() > 0){
        // echo "string";
      $abc =  false;
        $data = $query->result();
        $purchaged_limit_count = null;
        foreach ($data as $key_data => $value_data) {
            $purchaged_limit_count = $value_data->purchaged_limit;
            if($purchaged_limit_count < $redeem_limit[$key_data]){
                $abc =  true;
            }else{
                $abc =  false;
            }
            $new_array[$variant_id[$key_data]] = $abc;
            $abc =  false;

            $purchaged_limit_count = null;
            $abc =  false;
        }

        return $new_array;
            // pr($data);
            // pr($redeem_limit.'<br>');
            // pr($purchaged_limit_count.'<br>'); die;


    }
    else
    {
        //$new_array[$vid]->is_redeem = true;

        foreach ($data as $key_data => $value_data) {
            $new_array[$variant_id[$key_data]] = true;
        }

        return $new_array;
    }
 }

// function currect_single_data_store_wise($rawData = '',$main_weight_id=''){
//     $CI = & get_instance();
//     $check_store_id = get_store_id('id');
//     if($rawData->product_id==3025){
//      pr($rawData);

//     }
//         //pr($main_weight_id.'<br>');
//       //  pr($rawData);die;


// 	if($rawData=='')
// 	{
// 		return false;
// 	}

// 	$CI->load->model('search_model');
// 	$weight_id = explode(',',$rawData->weight_id);
//     $product_price = explode(',',$rawData->product_price);
//     $product_pec_weight = explode(",", $rawData->product_pec_weight);
//     $product_s_price = explode(',',$rawData->product_s_price);
//     $new_weight_id 			= [];
//     $new_product_price 		= [];
//     $new_product_s_price 	= [];
//     $new_product_pec_weight = [];
//     asort($product_price);

//     foreach ($product_price as $key => $new_product) {

//     	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
//     	$new_weight_id[] 				= $weight_id[$key];
//     	$new_product_price[] 			= $product_price[$key];
//     	$new_product_s_price[] 			= $product_s_price[$key];
//     }


//     //pr($new_weight_id);die;


//     $CI->db->select('*');
//     if($main_weight_id!=''){
//         $CI->db->where('main_price_id',$main_weight_id);
//         $rawData->vid = $main_weight_id;
//     }else{
//         $CI->db->where('main_price_id',$new_weight_id[0]);
//         $rawData->vid = $new_weight_id[0];
//     }

//     $CI->db->where('store_id',$check_store_id);
//     $ress = $CI->db->get('tbl_product_price_store_wise')->row();

//     //echo $CI->db->last_query(); die;

//     // pr($ress);die;

//      ////////////////////////////////////
//      if($ress->id){
//         if((int)$ress->product_price>0){
//             $rawData->product_price1 = $ress->product_price;
//         }else{
//             $rawData->product_price1 = $new_product_price[0];
//         }
//         if((int)$ress->product_s_price>0){
//             $rawData->product_s_price1 = $ress->product_s_price;
//             $rawData->special_price_start_date = $ress->special_price_start_date;
//             $rawData->special_price_end_date = $ress->special_price_end_date;
//             $rawData->set_quantity 	= $ress->set_quantity;
//         }else{
//             $rawData->product_s_price1 = $new_product_s_price[0];
//         }
//     }

//     ////////////////////////////////////

//     $CI->db->select('*');
//     $CI->db->where('product_id',$rawData->product_id);
//     $CI->db->where('store_id',$check_store_id);
//     $ress_detailed = $CI->db->get('tbl_product_price_store_wise')->result();
//     $names = array();
//     foreach ($ress_detailed as $my_object) {
//         $names[] = $my_object->product_price; //any object field
//     }

//     array_multisort($names, SORT_ASC, $ress_detailed);



//     foreach ($ress_detailed as $keys => $values) {

//         //pr($values->product_price);
//        if((int)$values->product_price>0){
//         $new_product_price[$keys] = $values->product_price;
//        }
//        if((int)$values->product_s_price>0){
//         $new_product_s_price[$keys] = $values->product_s_price;
//        }

//     }

//     $rawData->weight_id 	= implode(",", ($new_weight_id));
//     $rawData->product_price = implode(",", ($new_product_price));
//     $rawData->product_pec_weight = implode(",", ($new_new_product_pec_weight));
//     $rawData->product_s_price = implode(",", ($new_product_s_price));
//     $rawData->gallery_images   = $CI->search_model->fetch_gallery($new_weight_id[0]);
//     $rawData->image = @$gallery_images[0]->image;
//     #Data manupulating
//     // if($main_weight_id=='474'){

//     //     pr($ress_detailed);
//     //     pr($rawData);
//     //     die;
//     // }

//     if($rawData->product_id==3025){
//     pr($rawData);die;
//     }
//     return $rawData;
// }
## it is a function called after on loading for special price date manupulation starts###
function currect_multiple_data_new_store_wise($rawData = '', $variant_special_price=null, $gallery_data=null,$store_id='',$wishlist=''){
    // pr($rawData); die;
    if($store_id ==''){
        $check_store_id = get_store_id('id');
    }else{
        $check_store_id = $store_id;
    }
    //pr($rawData);
   // return $rawData;
    // if($rawData->vid==11576){
    //     pr($rawData);
    // }
    if($rawData=='')
	{
		return false;
    }

	$CI = & get_instance();
	$CI->load->model('search_model');
    $weight_id = explode(',',$rawData->weight_ids);

    // if($CI->cache->file->get('currect_multiple_data_new_store_wise_'.$weight_id[0])){
    //     $rawData = $CI->cache->file->get('currect_multiple_data_new_store_wise_'.$weight_id[0]);
    //     return $rawData;
    // }
    $product_price = explode(',',$rawData->product_price);
    $product_pec_weight = explode(",", $rawData->product_pec_weight);
    $product_s_price = explode(',',$rawData->product_s_price);
    $new_weight_id 			= [];
    $new_product_price 		= [];
    $new_product_s_price 	= [];
    $new_product_pec_weight = [];
    asort($product_price);

    foreach ($product_price as $key => $new_product) {

    	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
    	$new_weight_id[] 				= $weight_id[$key];
    	$new_product_price[] 			= $product_price[$key];
    	$new_product_s_price[] 			= $product_s_price[$key];
    }

    $rawData->vid = $new_weight_id[0];
    $rawData->product_price1 = $new_product_price[0];
    $rawData->product_pec_weight1 = $new_new_product_pec_weight[0];
    $rawData->product_s_price1 = $new_product_s_price[0];
    #special_price_start_date
    $variant_special_price_data = '';
	if(isset($variant_special_price)&& !empty($variant_special_price))
	{
		foreach ($variant_special_price as $special_price_key => $special_price) {
			if($special_price->id==$new_weight_id[0])
			{
				$variant_special_price_data = $special_price;
			}
		}
	}
    #special_price_start_date
    ////////////////for comma separated and and direct price value manupulation starts/////////
    $loop_data = $new_weight_id;
    // pr($loop_data); die;
    foreach ($loop_data as $key_new_weight_id => $value_new_weight_id) {

            $CI->db->select('*');
            $CI->db->where('main_price_id',$loop_data[$key_new_weight_id]);
            $CI->db->where('store_id',$check_store_id);
            $ress[$key_new_weight_id]= $CI->db->get('tbl_product_price_store_wise')->row();
            // if($rawData->vid==11576){
            //     echo $CI->db->last_query();
            //     pr($ress);
            // }
          //  echo $CI->db->last_query();

            if(isset($ress[$key_new_weight_id]->id) && $ress[$key_new_weight_id]->id!='' && isset($ress[$key_new_weight_id]->main_price_id) && isset($rawData->vid) && $ress[$key_new_weight_id]->main_price_id==$rawData->vid){


                // pr($ress);

                    if((int)$ress[$key_new_weight_id]->product_s_price>0){
                        $rawData->product_price1 = $ress[$key_new_weight_id]->product_price;
                        $rawData->product_s_price1 = $ress[$key_new_weight_id]->product_s_price;
                        $rawData->special_price_start_date = $ress[$key_new_weight_id]->special_price_start_date;
                        $rawData->special_price_end_date = $ress[$key_new_weight_id]->special_price_end_date;
                        $rawData->set_quantity 	= $ress[$key_new_weight_id]->set_quantity;
                    }else{
                        $rawData->special_price_start_date = isset($variant_special_price_data->special_price_start_date) ? $variant_special_price_data->special_price_start_date : '';
                        $rawData->special_price_end_date = isset($variant_special_price_data->special_price_end_date) ? $variant_special_price_data->special_price_end_date : '';
                        $rawData->set_quantity 	= isset($variant_special_price_data->set_quantity) ? $variant_special_price_data->set_quantity : '';
                    }
            }

        }


   ////////////////for comma separated and and direct price value manupulation ends/////////

    $rawData->weight_ids 	= implode(",", ($new_weight_id));
    $rawData->product_price = implode(",", ($new_product_price));
    $rawData->product_pec_weight = implode(",", ($new_new_product_pec_weight));
    $rawData->product_s_price = implode(",", ($new_product_s_price));
    $gallery_images = '';
	if(isset($gallery_data) && !empty($gallery_data))
	{
		foreach ($gallery_data as $gallery_key => $gallery) {
			if($gallery_images=='' && $gallery->variant_id==$new_weight_id[0])
			{
				$gallery_images = $gallery;
			}
		}
	}
    // $gallery_images   = $CI->search_model->fetch_gallery($new_weight_id[0]);
    $rawData->image = @$gallery_images->image;
    #Data manupulating
    // if($rawData->vid==11576){
    //     pr($rawData);die;
    // }
    //pr($rawData);die;


       ###############caching save starts######################

      // $CI->cache->file->save('currect_multiple_data_new_store_wise_'.$weight_id[0],$rawData, CACHE_EXPIRE);

       ###############caching save ends######################


    // pr($rawData); die;
    return $rawData;
}

## it is a function called after on loading for special price date manupulation starts###

function currect_multiple_data($rawData = ''){
	if($rawData=='')
	{
		return false;
	}
	$CI = & get_instance();
	$CI->load->model('search_model');
	$weight_id = explode(',',$rawData->weight_ids);
    $product_price = explode(',',$rawData->product_price);
    $product_pec_weight = explode(",", $rawData->product_pec_weight);
    $product_s_price = explode(',',$rawData->product_s_price);
    $new_weight_id 			= [];
    $new_product_price 		= [];
    $new_product_s_price 	= [];
    $new_product_pec_weight = [];
    asort($product_price);

    foreach ($product_price as $key => $new_product) {

    	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
    	$new_weight_id[] 				= $weight_id[$key];
    	$new_product_price[] 			= $product_price[$key];
    	$new_product_s_price[] 			= $product_s_price[$key];
    }

    $rawData->vid = $new_weight_id[0];
    $rawData->product_price1 = $new_product_price[0];
    $rawData->product_pec_weight1 = $new_new_product_pec_weight[0];
    $rawData->product_s_price1 = $new_product_s_price[0];
    $CI->db->select('special_price_start_date, special_price_end_date, set_quantity');
    $CI->db->where('id',$new_weight_id[0]);
    $ress = $CI->db->get('tbl_product_price')->row();
    $rawData->special_price_start_date = $ress->special_price_start_date;
    $rawData->special_price_end_date = $ress->special_price_end_date;
    $rawData->set_quantity 	= $ress->set_quantity;
    $rawData->weight_ids 	= implode(",", ($new_weight_id));
    $rawData->product_price = implode(",", ($new_product_price));
    $rawData->product_pec_weight = implode(",", ($new_new_product_pec_weight));
    $rawData->product_s_price = implode(",", ($new_product_s_price));
    $gallery_images   = $CI->search_model->fetch_gallery($new_weight_id[0]);
    $rawData->image = @$gallery_images[0]->image;
	#Data manupulating

    return $rawData;
}

function currect_multiple_data_new($rawData = '', $variant_special_price = NULL, $gallery_data = NULL){

    if($rawData=='')
	{
		return false;
	}
	$CI = & get_instance();
	// $CI->load->model('search_model');
	$weight_id             	= explode(',',$rawData->weight_ids);
    $product_price          = explode(',',$rawData->product_price);
    $product_pec_weight     = explode(",", $rawData->product_pec_weight);
    $product_s_price 		= explode(',',$rawData->product_s_price);
    $new_weight_id 			= [];
    $new_product_price 		= [];
    $new_product_s_price 	= [];
    $new_product_pec_weight = [];
    asort($product_price);

    foreach ($product_price as $key => $new_product) {

    	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
    	$new_weight_id[] 				= $weight_id[$key];
    	$new_product_price[] 			= $product_price[$key];
    	$new_product_s_price[] 			= $product_s_price[$key];
    }

    $rawData->vid = $new_weight_id[0];
   // $rawData->product_price1 = $new_product_price[0];
    $rawData->product_pec_weight1 = $new_new_product_pec_weight[0];
    $rawData->product_s_price1 = $new_product_s_price[0];
    #special_price_start_date
    $variant_special_price_data = '';
    if(!empty($variant_special_price)){
        foreach ($variant_special_price as $special_price_key => $special_price) {
            if($special_price->id==$new_weight_id[0])
            {
                $variant_special_price_data = $special_price;
            }
        }
    }

    // $CI->db->select('special_price_start_date, special_price_end_date, set_quantity');
    // $CI->db->where('id',$new_weight_id[0]);
    // $ress = $CI->db->get('tbl_product_price')->row();
    #special_price_start_date

    if(!empty($variant_special_price_data)){
        $rawData->special_price_start_date = @$variant_special_price_data->special_price_start_date;
        $rawData->special_price_end_date = @$variant_special_price_data->special_price_end_date;
        $rawData->set_quantity 	= @$variant_special_price_data->set_quantity;
    }

    $rawData->weight_ids 			= implode(",", ($new_weight_id));
    $rawData->product_price 		= implode(",", ($new_product_price));
    $rawData->product_pec_weight 	= implode(",", ($new_new_product_pec_weight));
    $rawData->product_s_price 		= implode(",", ($new_product_s_price));
    $gallery_images 				= '';
    if(!empty($gallery_data)){
        foreach ($gallery_data as $gallery_key => $gallery) {
            if($gallery_images=='' && $gallery->variant_id==$new_weight_id[0])
            {
                $gallery_images = $gallery;
            }
        }
    }

    // $gallery_images   = $CI->search_model->fetch_gallery($new_weight_id[0]);
    $rawData->image = @$gallery_images->image;
	#Data manupulating
    return $rawData;
}

function currect_multiple_data_vid($rawData = ''){
	if(!isset($rawData) || empty($rawData)) {return FALSE; }
    // pr($rawData);die;
    $CI                     = & get_instance();
    $weight_id              = explode(',',$rawData->weight_ids);
    $product_price          = explode(',',$rawData->product_price);
    $product_pec_weight     = explode(",", $rawData->product_pec_weight);
    $product_s_price        = explode(',',$rawData->product_s_price);
    $new_weight_id 			= [];
    $new_product_price 		= [];
    $new_product_s_price 	= [];
    $new_product_pec_weight = [];
    asort($product_price);

    foreach ($product_price as $key => $new_product) {

    	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
    	$new_weight_id[] 				= $weight_id[$key];
    	$new_product_price[] 			= $product_price[$key];
    	$new_product_s_price[] 			= $product_s_price[$key];
    }

    $rawData->vid                   = $new_weight_id[0];
    //$rawData->product_price1        = $new_product_price[0];
    $rawData->product_pec_weight1   = $new_new_product_pec_weight[0];
    $rawData->product_s_price1      = $new_product_s_price[0];
	#Data manupulating
    // pr($rawData);die;
    return $rawData;
}

## it is a function that calls on loading of the category and on filter functionality starts ##
function currect_multiple_data_vid_store_wise($rawData = '', $main_weight_id='',$store_id =''){
    $CI =& get_instance();
    // return $rawData;
    if($store_id ==''){
        $check_store_id = get_store_id('id');
    }else{
        $check_store_id = $store_id;
    }

    if(!isset($rawData) || empty($rawData))
	  {
		return FALSE;
	  }
    $weight_id              = explode(',',$rawData->weight_ids);
    $product_price          = explode(',',$rawData->product_price);
    $product_pec_weight     = explode(",", $rawData->product_pec_weight);
    $product_s_price        = explode(',',$rawData->product_s_price);
    $new_weight_id 			= [];
    $new_product_price 		= [];
    $new_product_s_price 	= [];
    $new_product_pec_weight = [];
    asort($product_price);

    foreach ($product_price as $key => $new_product) {

    	$new_new_product_pec_weight[] 	= $product_pec_weight[$key];
    	$new_weight_id[] 				= $weight_id[$key];
    	$new_product_price[] 			= $product_price[$key];
    	$new_product_s_price[] 			= $product_s_price[$key];
    }

    $rawData->vid = $new_weight_id[0];
    // if($main_weight_id!=''){
    //     $rawData->vid = $main_weight_id;
    // }else{
    //     $rawData->vid = $new_weight_id[0];
    // }

    // if($rawData->vid==11576){

    //     echo 'dddddddddddddddddddddddddddddddddddddddddddddddd';
    //     pr($rawData);
    // }

    ////////////////for comma separated and and direct price value manupulation starts/////////
    $loop_data = $new_weight_id;
    //pr($loop_data);
    if($store_id ==''){
        $check_store_id = get_store_id('id');
    }else{
        $check_store_id = $store_id;
    }


    foreach ($loop_data as $key_new_weight_id => $value_new_weight_id) {
      $keyvalue[]  = $loop_data[$key_new_weight_id];
    }
    //$keynewweightid[] = implode(",",$keyvalue);

  //  print_r($keyvalue); die;




  //  foreach ($loop_data as $key_new_weight_id => $value_new_weight_id) {
        $CI->db->select('*');
        $CI->db->where_in('main_price_id',$keyvalue);
      //  $CI->db->where('main_price_id',$loop_data[$key_new_weight_id]);
        //$CI->db->where('main_price_id',$loop_data[$keyvalue]);
        $CI->db->where('store_id',$check_store_id);
        $ress[$key_new_weight_id] = $CI->db->get('tbl_product_price_store_wise')->row();
        //echo $CI->db->last_query(); die;
        if(isset($ress[$key_new_weight_id]->id) && $ress[$key_new_weight_id]->id!='' && isset($ress[$key_new_weight_id]->main_price_id) && $ress[$key_new_weight_id]->main_price_id==$rawData->vid){

            if((int)$ress[$key_new_weight_id]->product_price>0){
                //$rawData->product_price1 = $ress[$key_new_weight_id]->product_price;
                $new_product_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_price;
            }

            if((int)$ress[$key_new_weight_id]->product_s_price>0){
                $rawData->product_s_price1 = $ress[$key_new_weight_id]->product_s_price;
                $rawData->special_price_start_date = $ress[$key_new_weight_id]->special_price_start_date;
                $rawData->special_price_end_date = $ress[$key_new_weight_id]->special_price_end_date;
                $rawData->set_quantity 	= $ress[$key_new_weight_id]->set_quantity;
                $new_product_s_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_s_price;
            }
        }

        if(isset($ress[$key_new_weight_id]->id) && $ress[$key_new_weight_id]->id!=''){
            if((int)$ress[$key_new_weight_id]->product_price>0){
                $new_product_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_price;
            }
            if((int)$ress[$key_new_weight_id]->product_s_price>0){
                $new_product_s_price[$key_new_weight_id] = $ress[$key_new_weight_id]->product_s_price;
            }
        }
  //  }

    ////////////////for comma separated and and direct price value manupulation ends/////////

    //$rawData->price= current($add_new_price);
    $rawData->weight_ids 	= implode(",", ($new_weight_id));
    $rawData->product_price = implode(",", ($new_product_price));
    $rawData->product_pec_weight = implode(",", ($new_new_product_pec_weight));
    $rawData->product_s_price = implode(",", ($new_product_s_price));
    //  if($rawData->vid==11576){
    //     pr($rawData);die;
    // }
    //pr($rawData);die;
    ###############caching save starts######################
    //  $CI->cache->file->save('currect_multiple_data_vid_store_wise_'.$weight_id[0],$rawData, CACHE_EXPIRE);
    ###############caching save ends######################
    return $rawData;
}

## it is a function that calls on loading of the category and on filter functionality ends ##

## it is a function that calls on loading of the category and on filter functionality starts ##
function fetch_variant_special_price_store_wise($rawData = '', $main_weight_id='',$store_id ='',$varient=''){
    $CI =& get_instance();
    //return $rawData;
    if($store_id ==''){
        $check_store_id = get_store_id('id');
    }else{
        $check_store_id = $store_id;
    }


    if($rawData=='')
	{
		return false;
	}

    // if($CI->cache->file->get('fetch_variant_special_price_store_wise_'.$main_weight_id)){
    //     $rawData = $CI->cache->file->get('fetch_variant_special_price_store_wise_'.$main_weight_id);
    //     return $rawData;
    // }
    ////////////////for comma separated and and direct price value manupulation starts/////////


            $CI->db->select('*');
            $CI->db->where('main_price_id',$main_weight_id);
            $CI->db->where('store_id',$check_store_id);
            $ress= $CI->db->get('tbl_product_price_store_wise')->row();
               // pr($ress);
            if(isset($ress->id) && $ress->id!='' && isset($ress->main_price_id) && isset($rawData->id) && $ress->main_price_id==$rawData->id){
                // pr((int)$ress->product_price);
                // pr($varient);
                    if((int)$ress->product_price>0 && !empty($varient)){
                        $rawData->product_price = $ress->product_price;
                    }
                    if((int)$ress->product_s_price>0 && (int)$ress->product_price>0  && !empty($varient)){
                        $rawData->product_s_price = $ress->product_s_price;
                    }
                    if((int)$ress->product_s_price>0 && (int)$ress->product_price>0){
                        $rawData->special_price_start_date = $ress->special_price_start_date;
                        $rawData->special_price_end_date = $ress->special_price_end_date;
                        $rawData->set_quantity 	= $ress->set_quantity;
                    }
            }

   ////////////////for comma separated and and direct price value manupulation ends/////////


    //  if($rawData->id==12238){
    //      echo $CI->db->last_query();

    //      pr($ress);
    //     pr($rawData);die;
    // }
    // pr($rawData);die;



     ###############caching save starts######################

    // $CI->cache->file->save('fetch_variant_special_price_store_wise_'.$main_weight_id,$rawData, CACHE_EXPIRE);

     ###############caching save ends######################



    return $rawData;
}

## it is a function that calls on loading of the category and on filter functionality ends ##
function check_order_exceed($slot_array,$order_limit,$store_id,$selected_date){


    $correct_select_date = date('Y-m-d',strtotime($selected_date));
    $order_placed_array = array();
    $CI = & get_instance();

   // pr($slot_array);
    if(!empty($slot_array)){
        foreach($slot_array as $key_sa=>$val_sa){

                 $CI->db->select('selectdeliverytime');
                 $CI->db->where('store_id',$store_id);
                 $CI->db->where('selectdeliverytime',$val_sa);
                 $CI->db->where('selectdeliverydate',$correct_select_date);
                 $CI->db->where('order_status!=','Cancel');
                 $result = $CI->db->get('tbl_order')->result();
                 $order_placed_array[$key_sa] = count($result);

        }

    }

    $final_stock_limit_array = array();
    if(!empty($order_limit)){
        foreach($order_limit as $key_l=>$val_l){

                if(isset($order_placed_array[$key_l]) && $order_placed_array[$key_l] < $val_l){
                        $final_stock_limit_array[$key_l] = '1';
                }else{
                        $final_stock_limit_array[$key_l] = '0';
                }
        }
    }


   return $final_stock_limit_array;
}

function gat_all_cat_subcat()
{
    $CI = & get_instance();
    if($CI->cache->file->get('all_category_sucategory'))
    {
        $result__ =  $CI->cache->file->get('all_category_sucategory');
        // pr($result__);die;
        return $result__;
    }

    $all_category       = [];
    $all_category2      = [];
    $sql = "SELECT id,parent_id,name,url_name,web_menu_bg_image,app_landing_page,category_image_app,category_banner,menu_show,category_menu_banner,android_ios_image FROM tbl_categories WHERE status = 'Active' ORDER BY sort_order ASC";
    $query1 = $CI->db->query($sql);
    // pr($query1->result());die;

    if($query1->num_rows()){
        $results    = $query1->result();
        $index      = 0;
        foreach($results as $cat_key => $cat_val){
            if($cat_val->parent_id == 0 && $cat_val->menu_show  == 1)
            {
                $cat_val->is_product    = '1';
                $all_category[$index]   =  $cat_val;
                $subcategory            = [];
                $index2                 = 0;
                foreach($results as $cat_key2 => $cat_val2){
                    if($cat_val2->parent_id == $cat_val->id && $cat_val2->menu_show  == 1)
                    {
                        $subcategory[$index2] = $cat_val2;
                        $subcategory[$index2]->is_product = 1;
                        $index2++;
                    }
                }
                if(isset($subcategory) && !empty($subcategory))
                {
                    $all_category[$index]->subcategory  = $subcategory;
                    // $all_category[$index]->subcat       = $subcategory;
                }
                $index++;
            }
        }

        // pr($all_category);die;
        if(isset($all_category) && !empty($all_category))
        {
            $index3 = 0;
            foreach ($all_category as $key1 => $category) {
                $cat_flag       = 0;
                $subcat_flag    = 0;
                if(isset($category->subcategory) && !empty($category->subcategory))
                {
                    $all_subcategory = [];
                    $all_subcategory2 = [];
                    foreach ($category->subcategory as $key2 => $subcategory2) {
                        $all_subcategory[] = $subcategory2->id;
                    }

                    if(isset($all_subcategory) && !empty($all_subcategory))
                    {
                        $CI->db->select("p.product_id,p.category_ids, GROUP_CONCAT(pp.id) as all_variant_ids", FALSE);
                        $CI->db->join("tbl_product_price as pp","pp.product_id = p.product_id", "LEFT");
                        $CI->db->where("p.product_status", 1);
                        $CI->db->where("pp.unit_status", 1);

                        foreach($all_subcategory as $subcat_key => $subcat)
                        {
                            if($subcat_key == 0)
                            {
                                $str_find_set  = " find_in_set('".$subcat."',p.category_ids)>0";
                            }
                            else
                            {
                                $str_find_set  = $str_find_set." OR find_in_set('".$subcat."',p.category_ids)>0";
                            }
                        }
                        $CI->db->where("(".$str_find_set.")");
                        $CI->db->group_by("p.category_ids");
                        $query2 = $CI->db->get('tbl_product AS p');

                        if($category->id == 281)
                        {
                            // pr($category->subcategory);die;
                            // pr($all_subcategory);die;
                            // echo $CI->db->last_query();die;
                        }
                        if($query2->num_rows())
                        {
                            $subcategory_ids    = [];
                            $all_subcategory_ids    = [];
                            $all_prducts        = $query2->result_array();
                            $subcategory_ids    = array_column($all_prducts, 'category_ids');
                            $subcategory_ids    = array_unique(array_filter($subcategory_ids));

                            if(isset($subcategory_ids) &&! empty($subcategory_ids))
                            {
                                foreach ($subcategory_ids as $$subcategory_key => $subcategory_id) {
                                    $category_ids_temp  = [];
                                    $category_ids_temp  = explode(",", $subcategory_id);
                                    $all_subcategory_ids= array_unique(array_merge($all_subcategory_ids, $category_ids_temp));
                                }
                                $all_subcategory_ids = array_unique($all_subcategory_ids);

                                foreach ($all_subcategory as $all_subcategory_key => $all_subcategory_value) {
                                    if(in_array($all_subcategory_value, $all_subcategory_ids))
                                    {
                                        $all_subcategory2[] = $all_subcategory_value;
                                    }
                                }
                            }

                            if(isset($all_subcategory2) && !empty($all_subcategory2))
                            {
                                $all_category2[$index3] = $category;
                                $all_subcategory_temp = [];
                                foreach ($category->subcategory as $key3 => $subcategory3) {

                                    if(in_array($subcategory3->id, $all_subcategory2))
                                    {

                                        if(isset($subcategory3->android_ios_image) && !empty($subcategory3->android_ios_image) && file_exists(ASSETS_PATH.'uploads/category/'.$subcategory3->android_ios_image))
                                        {
                                            $subcategory3->subcategory_image = $subcategory3->android_ios_image;
                                        }
                                        else{
                                            $subcategory3->subcategory_image = 'product_placeholder.png';
                                        }
                                        $all_subcategory_temp[] = $subcategory3;
                                    }
                                }
                                $all_category2[$index3]->subcategory = $all_subcategory_temp;
                                $index3++;
                            }

                            // pr($all_subcategory);
                            // pr($all_subcategory2);
                            // pr($subcategory_ids);die;
                            // pr($all_subcategory_ids);die;
                        }
                    }
                }
            }
        }
        // pr($all_category2);die;
    }
    $CI->cache->file->save('all_category_sucategory', $all_category2, CACHE_EXPIRE);
    return $all_category2;
}

function terms_conditions(){
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->where('id','5');
    $result = $CI->db->get('tbl_cms')->row();
    return $result;
}

if (!function_exists('is_blocked_user')) {

    function is_blocked_user() {
        $CI = &get_instance();
        if($CI->session->userdata('auth_user')['users_id']!=''){
            $logged_in_customer = $CI->session->userdata('auth_user')['users_id'];
           // pr($logged_in_customer);
            $CI->db->select('id,is_blocked,status');
            $CI->db->where('id',$logged_in_customer);
            $result = $CI->db->get('tbl_users')->row();
            if($result->is_blocked==0){
                redirect('/logout');
            }
            //pr($result);die;
        }


    }

}
if(!function_exists('IsActiveProductWeight')){
    function IsActiveProductWeight($weight_id,$product_id){
        $CI = &get_instance();
       // return true;
        if($weight_id && $product_id){
                $CI->db->select('tbl_product_price.id,tbl_product_price.*');
                // $CI->db->join('tbl_product','tbl_product_price.product_id=tbl_product.product_id','left');
                $CI->db->join('tbl_product_price','tbl_product.product_id=tbl_product_price.product_id','left');
                //$CI->db->where('tbl_product_price.unit_status','1');
                $CI->db->where('tbl_product.product_status','1');
                $CI->db->where('tbl_product_price.id',$weight_id);
                $CI->db->where('tbl_product_price.product_id',$product_id);
                $CI->db->group_by('tbl_product_price.id');
                $res1 = $CI->db->get('tbl_product')->row();
            //    pr($CI->db->last_query());

            //     pr($res1);
            //  if($weight_id==12667){
            //      pr($res1);
            //  }

            //  if($weight_id==12668){
            //     pr($res1);
            // }
                if($res1->unit_status=='1'){
                    return true;
                }
                return false;

        }else{
            return false;
        }
    }

}


if(!function_exists('getNewActiveProductDetail')){
    function getNewActiveProductDetail($weight_id='',$product_id=''){
        $CI = &get_instance();
        if($weight_id && $product_id){



            if($CI->cache->file->get('getNewActiveProductDetail_'.$product_id.'_'.$weight_id)){
                    $res1 = $CI->cache->file->get('getNewActiveProductDetail_'.$product_id.'_'.$weight_id);
                    return $res1;
                }

                $CI->db->select("SQL_CALC_FOUND_ROWS p.product_id,CONVERT(p.product_prices, DECIMAL) as price,p.product_image,p.brand_name,p.product_code,p.product_name,p.product_url,p.product_type,p.product_status,p.weight_ids as weight_id,p.product_prices as product_price,p.product_pec_weights as product_pec_weight,p.product_s_prices as product_s_price,p.category_ids,p.mb_express,p.food_type,p.product_nature,p.product_weight_type,p.country_name,p.featured,pp.special_price_start_date,pp.special_price_end_date,pp.set_quantity,pp.product_s_price as product_s_price1,pp.product_pec_weight as product_pec_weight1,pp.product_price as product_price1,pp.id as vid,cnt.country_flag as flag",false);

                $CI->db->join('tbl_product_price as pp','pp.product_id = p.product_id','left');
                // $CI->db->join('tbl_product_gallery as pg','pg.variant_id = pp.id','left');
                $CI->db->join('tbl_country as cnt','cnt.id = p.country_name','left');
                $CI->db->where('p.product_status','1');
                $CI->db->where("p.product_prices!=''");
                if($weight_id!=''){
                    $CI->db->where('pp.id',$weight_id);
                }

                $CI->db->where('pp.product_id',$product_id);
                $CI->db->group_by('pp.id');
                $res1 = $CI->db->get('tbl_product p')->row();
               //pr($CI->db->last_query());die;

                //return $res1;
            // if($res1->id==9139){
            //     pr($res1);die;
            // }
                if($res1){
                     ###############caching starts######################

                      $CI->cache->file->save('getNewActiveProductDetail_'.$product_id.'_'.$weight_id,$rawData, CACHE_EXPIRE);

                    ###############caching starts######################

                    return $res1;
                }
                return false;

        }else{
            return false;
        }
    }

}

if(!function_exists('getStoreWisePriceDetails')){
    function getStoreWisePriceDetails($price_id,$product_id,$store_id){
        $CI = &get_instance();
        if($price_id && $product_id && $store_id){
                $CI->db->select("pp.product_price,pp.product_s_price",false);
                $CI->db->where('pp.main_price_id',$price_id);
                $CI->db->where('pp.product_id',$product_id);
                $CI->db->where('pp.store_id',$store_id);
                $res1 = $CI->db->get('tbl_product_price_store_wise pp')->row();
                //pr($CI->db->last_query());
                if($res1->product_price>0){
                 //   pr($res1);die;
                }
                //return $res1;
                if($res1){
                    return $res1;
                }
                return false;

        }else{
            return false;
        }
    }

}

function encrypt($string_to_encrypt) {
    $ENCRYPTION_KEY = "__^%&Q@$&*!@#$%^&*^__";
    return  openssl_encrypt($string_to_encrypt,"AES-128-ECB",$ENCRYPTION_KEY);
}

function decrypt($string_to_decrypt) {
    $ENCRYPTION_KEY = "__^%&Q@$&*!@#$%^&*^__";
    return  openssl_decrypt($string_to_decrypt,"AES-128-ECB",$ENCRYPTION_KEY);
}

function changeNumToDate($num = null){
    Switch($num){

        Case 1:
            return 'Monday';
            break;
        Case 2:
            return 'Tuesday';
            break;
        Case 3:
            return 'Wednesday';
            break;
        Case 4:
            return 'Thursday';
            break;
        Case 5:
            return 'Friday';
            break;
        Case 6:
            return 'Saturday';
            break;
        Case 7:
            return 'Sunday';
            break;
        default:
            return NULL;
    }
}

function seoUrl($string) {
    //Lower case everything
    $string = str_replace("&amp;", "", $string);
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", " ", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

//code for get day name added by mukul on 28-06-2020
if(!function_exists('get_days_name')){
    function get_days_name(){
        $CI = &get_instance();
        $CI->db->select('id,day_name');
        $CI->db->from('tbl_dayname');
        $CI->db->where('status',1);
        $query = $CI->db->get();
        if($query->num_rows() >0){
            return $query->result_array();
        }
    }
}

if(!function_exists('_get_day_name')){
    function _get_day_name($dayid=NULL){
        $CI = &get_instance();
        $id = explode(',',$dayid);
        $CI->db->select('id,day_name');
        $CI->db->from('tbl_dayname');
        $CI->db->where_in('id',$id);
        $CI->db->where('status',1);
        $query = $CI->db->get();
        if($query->num_rows() >0){
            $dayname =  $query->result_array();
            $dayname = array_column($dayname, 'day_name');
            return implode(',',$dayname);
        }
    }
}

if(!function_exists('admin_acknowledge_mail')){
    function admin_acknowledge_mail($sub=NULL){
        return true;
    }
}

function get_all_stores($only_active = TRUE)
{
    $CI = & get_instance();
    $data = [];
    if($CI->cache->file->get('all_stores'))
    {
        $data_temp =  $CI->cache->file->get('all_stores');
    }

    if(!isset($data_temp) || empty($data_temp))
    {
        $CI->db->order_by('store_name','ASC');
        $data_temp = $CI->db->get('tbl_store')->result();
        $CI->cache->file->save('all_stores', $data_temp, CACHE_EXPIRE);
    }

    if(isset($data_temp) && !empty($data_temp) && $only_active == TRUE)
    {
        foreach ($data_temp as $key => $store) {

            if($store->store_status == 1)
            {
                $data[] = $store;
            }
        }
    }
    else
    {
        $data = $data_temp;
    }

    return $data;
}

function get_offer_for_all_variant2($all_variant, $user_id = ''){

    $result1    = [];
    $CI         = & get_instance();
    $date       = date('Y-m-d H:i:s');
    $where      = "";


    $CI->db->select('*');
    if(isset($all_variant) && !empty($all_variant))
    {
        foreach ($all_variant as $key => $variant) {
            if(isset($variant) && $variant!="")
            {
                $where.= " FIND_IN_SET('" . $variant . "',`buy_item_product`)>0 OR ";
            }
        }
    }

    if(@$where){
        $CI->db->where("(".rtrim($where, 'OR ').")");
    }
    $CI->db->where("'".$date."' BETWEEN valid_from AND valid_to ");
    $CI->db->where('status', 1);
    $result1 = $CI->db->get("tbl_offers")->result_array();

    // if($query->num_rows()>0){
    //     $results = $query->result_array();
    //     foreach ($results as $key => $result) {
    //         // pr($result);
    //         $is_redeemed_offer = chk_redeem_limit($result['buy_item_product'],$user_id,$result['id'],1,$result['redeem_limit']);
    //         if($is_redeemed_offer)
    //         {
    //             $result1[$key] = $result;

    //         }
    //     }
    // }
    // pr($result1);die;
    return $result1;
}

function get_redeem_limit_all_offer($variant_ids, $user_id, $offer_id = NULL, $offer_type, $redeem_limit = NULL)
{

    $data = [];
    if(isset($user_id) && !empty($user_id) && isset($variant_ids) && !empty($variant_ids) )
    {
        $CI = &get_instance();
        $CI->db->select('torl.id, SUM(torl.purchaged_limit) as total_purchaged_limit, torl.offer_type, torl.user_id, torl.order_id, torl.purchaged_limit,torl.variant_id,torl.offer_id');
        // $CI->db->join('tbl_order ord', 'torl.order_id=ord.order_details_id', 'left');
        // $CI->db->where_not_in('ord.order_status',array('Cancel','PAYMENT FAILED','WAITING PAYMENT CONFIRMATION'));
        $CI->db->where('torl.offer_type',$offer_type); // 3 for special price
        $CI->db->where('torl.user_id',$user_id);
        $CI->db->where_in('torl.variant_id',$variant_ids);
        // $CI->db->where('torl.offer_id',$offer_id);
        $CI->db->where('torl.status',1);
        // $CI->db->where('DATE(torl.date)=',date('Y-m-d'));
        $CI->db->group_by('torl.offer_type');
        $CI->db->group_by('torl.variant_id');
        $data = $CI->db->get('tbl_offer_redeem_limit torl')->result();
        // echo $CI->db->last_query();die;
    }

    return $data;
}

function get_redeem_limit_b1g1_offer($variant_ids, $user_id, $offer_id = NULL, $offer_type, $redeem_limit = NULL)
{

    $data = [];
    if(isset($user_id) && !empty($user_id) && isset($variant_ids) && !empty($variant_ids) )
    {
        $CI = &get_instance();
        $CI->db->select('torl.id, SUM(torl.purchaged_limit) as total_purchaged_limit, torl.offer_type, torl.user_id, torl.order_id, torl.purchaged_limit,torl.variant_id,torl.offer_id');
        // $CI->db->join('tbl_order ord', 'torl.order_id=ord.order_details_id', 'left');
        // $CI->db->where_not_in('ord.order_status',array('Cancel','PAYMENT FAILED','WAITING PAYMENT CONFIRMATION'));
        $CI->db->where('torl.offer_type',$offer_type); // 3 for special price
        $CI->db->where('torl.user_id',$user_id);
        $CI->db->where_in('torl.variant_id',$variant_ids);
        // $CI->db->where('torl.offer_id',$offer_id);
        $CI->db->where('torl.status',1);
        // $CI->db->where('DATE(torl.date)=',date('Y-m-d'));
        $CI->db->group_by('torl.offer_type');
        $CI->db->group_by('torl.offer_id');
        $CI->db->group_by('torl.variant_id');
        $data = $CI->db->get('tbl_offer_redeem_limit torl')->result();
        // echo $CI->db->last_query();die;
    }

    return $data;
}

function get_offer_from_array2($vid = NULL, $all_get_offer = NULL, $all_redeem_offers = NULL, $user_id = NULL)
{
    $offer_data = [];

    if(isset($vid) && !empty($vid) && isset($all_get_offer) && !empty($all_get_offer) && is_array($all_get_offer))
    {

        foreach ($all_get_offer as $key => $offer) {
            if(isset($offer['buy_item_product']) && $offer['buy_item_product'] == $vid)
            {
                // pr($all_redeem_offers);
                // pr($offer);die;
                if(empty($offer_data))
                {
                    if(isset($all_redeem_offers) && !empty($all_redeem_offers) && isset($user_id) && !empty($user_id))
                    {

                        $redeem  = check_b1g1_redeem_limit_in_array($all_redeem_offers, $offer, $vid, $user_id);
                        if($redeem)
                        {
                            $offer_data = $offer;
                        }
                    }
                    else
                    {
                        $offer_data = $offer;
                    }
                }
            }
        }
    }
    // pr($offer_data); die;
    // die;
    return $offer_data;
}

function all_discount_offers($store = 0, $user_id = NULL )
{
    $CI = & get_instance();
    $data = [];
    $date   = date("Y-m-d H:i:s");

    /****************************************/
    if( $user_id == 0){
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`)
            AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
            AND STATUS='Active' ";
    }else{
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND    FIND_IN_SET('".$store."',`store_id`)
                AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
                AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END)
                AND STATUS='Active' AND minunit>=1";
    }
    /****************************************/

    if( isset($user_id) && !empty($user_id)){
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND  FIND_IN_SET('".$store."',`store_id`) AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END) AND STATUS='Active' AND minunit >= 1";
    }else{
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`) AND STATUS='Active' ";
    }
    $data = $CI->db->query($sql)->result();
    // echo $CI->db->last_query();die;
    return $data;
}

function all_getDiscountOnProduct_main($store = 0, $user_id = NULL )
{
    $CI = & get_instance();
    $data = [];
    $date   = date("Y-m-d H:i:s");

    /****************************************/
    if( $user_id == 0){
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`)
            AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
            AND STATUS='Active' ";
    }else{
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND    FIND_IN_SET('".$store."',`store_id`)
                AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
                AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END)
                AND STATUS='Active' AND minunit>=1";
    }
    /****************************************/

    if( isset($user_id) && !empty($user_id)){
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND  FIND_IN_SET('".$store."',`store_id`) AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END) AND STATUS='Active' AND minunit >= 1";
    }else{
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`) AND STATUS='Active' ";
    }
    $data = $CI->db->query($sql)->result();
    // echo $CI->db->last_query();die;
    return $data;
}

function get_discount_offer_from_array($all_offers = NULL, $all_redeem_discount = NULL, $vid = NULL, $price = 1, $store_id = 0, $user_id = NULL, $is_excluded = NULL)
{
    $discount_data  = FALSE;
    $data           = [];
    if(isset($all_offers) && !empty($all_offers) && is_array($all_offers) && isset($vid) && !empty($vid))
    {
        $all_discount_list  = [];

        foreach ($all_offers as $offer_key => $offer) {
            $status         = 0;
            $product_tmp    = $offer->product;
            $users_tmp      = $offer->users;
            $store_id_tmp   = $offer->store_id;

            $store_id_tmp   = explode(",", $store_id_tmp);

            if(in_array($store_id, $store_id_tmp))
            {
                $status++;
            }

            if(isset($user_id) && !empty($user_id))
            {
                if($offer->applicable == 1)
                {
                    $users_tmp = @explode(",", $users_tmp);

                    if(in_array($user_id, $users_tmp))
                    {
                        $status++;
                    }
                }
                else
                {
                    $status++;
                }
            }
            else
            {
                $status++;
            }

            if($offer->category_status == 2)
            {
                $product_tmp    = explode(",", $product_tmp);
                if(in_array($vid, $product_tmp))
                {
                    $status++;
                }
            }
            else
            {
                $status++;
            }

            if($status == 3)
            {
                $all_discount_list[] = $offer;
            }
        }
        if($vid == 141)
        {
            // pr($all_offers);
            // pr($all_discount_list);
            // pr($all_redeem_discount);
        }
        if(isset($all_discount_list) && !empty($all_discount_list) && count($all_discount_list)>0){
            foreach($all_discount_list as $discount){
                $check_redeem = TRUE;
                if(isset($user_id) && !empty($user_id) && isset($all_redeem_discount) && !empty($all_redeem_discount))
                {
                    $check_redeem = check_dis_redeem_limit_in_array($all_redeem_discount, $discount, $vid, $user_id);
                }

                if($check_redeem){
                    if($discount->discount_type == 'percentage')
                    {
                        $prev_disc_amt1 = $prev_disc_amt;
                        $prev_disc_amt  = $disc_amt;
                        $disc_amt       = ($price*$discount->discountamount)/100;

                    }else if($discount->discount_type == 'flat')
                    {
                        $prev_disc_amt1 = $prev_disc_amt;
                        $prev_disc_amt  = $disc_amt;
                        $disc_amt       = $discount->discountamount;
                    }
                    if($prev_disc_amt < $disc_amt)
                    {
                        $prev_disc_amt = $prev_disc_amt1;
                    }
                    if($prev_disc_amt < $disc_amt)
                    {
                        //$data[0] = $discount;
                        if(isset($is_excluded) && !empty($is_excluded) && $is_excluded != 0){
                            $data = $discount;
                        }
                        else if(!isset($is_excluded) || $is_excluded == NULL)
                        {
                            $data = $discount;
                        }
                    }
                }
            }
        }

        // die;
    }

    if(isset($data) && !empty($data))
    {
        $discount_data['discount']          = $data->discountamount;
        $discount_data['discount_type']     = $data->discount_type;
        $discount_data['discount_id']       = $data->id;
        $discount_data['discount_title']    = $data->discount_title;
        $discount_data['maxunit']           = $data->maxunit;
        $discount_data['discount_offer']    = $data;
    }

    return $discount_data;
}

function check_dis_redeem_limit_in_array($all_redeem_discount = NULL, $discount_offer = NULL, $vid = NULL, $user_id = NULL)
{
    $data = TRUE;
    if(isset($all_redeem_discount) && !empty($all_redeem_discount))
    {
        $redeem_discount_temp = [];
        foreach ($all_redeem_discount as $discount_redeem_key => $discount_redeem_value) {
            if($discount_redeem_value->variant_id == $vid && $discount_redeem_value->user_id == $user_id && $discount_redeem_value->offer_type == 2)
            {
                $redeem_discount_temp = $discount_redeem_value;
            }
        }

        if(isset($redeem_discount_temp) && !empty($redeem_discount_temp) && $redeem_discount_temp->total_purchaged_limit >= $discount_offer->redeem_limit)
        {
            $data = FALSE;
        }
    }

    return $data;
}

function check_b1g1_redeem_limit_in_array($all_redeem_offers = NULL, $b1g1_offer = NULL, $vid = NULL, $user_id = NULL)
{
    $data = TRUE;
    if(isset($all_redeem_offers) && !empty($all_redeem_offers))
    {
        $redeem_offer_temp = [];
        foreach ($all_redeem_offers as $offer_redeem_key => $offer_redeem) {
            if($offer_redeem->variant_id == $vid && $offer_redeem->user_id == $user_id && $offer_redeem->offer_type == 1 && $offer_redeem->offer_id == $b1g1_offer['id'])
            {
                $redeem_offer_temp = $offer_redeem;
            }
        }
        if(isset($redeem_offer_temp) && !empty($redeem_offer_temp) && $redeem_offer_temp->total_purchaged_limit >= $b1g1_offer['redeem_limit'])
        {
            $data = FALSE;
        }
    }

    return $data;
}
function delete_cache($name = NULL)
{
    $CI = & get_instance();
    if(isset($name) && !empty($name))
    {
        $CI->cache->file->delete($name);
    }
}

function get_footer_content()
{
    $CI = & get_instance();
    if($CI->cache->file->get('footer_content'))
    {
        return $CI->cache->file->get('footer_content');
    }
    $CI->db->select('id, title, description');
    $CI->db->where('id',3);
    $result = $CI->db->get('tbl_cms')->row();
    $CI->cache->file->save('footer_content', $result, CACHE_EXPIRE);
    return $result;
}

function save_payment_gateway_sent_data($data = NULL)
{
    if(isset($data) && !empty($data))
    {
        $CI = & get_instance();
        $CI->db->insert('tbl_payment_gateway_sent_data', $data);
    }

}

/* Get Order code */

function getOrderCode() {

    $CI = & get_instance();
    $sql_ins = "INSERT INTO tbl_order_code( value_1, value_2 ) SELECT value_1, (MAX( value_2 ) +1) as value_2  From tbl_order_code";
    $rs_ins = $CI->db->query($sql_ins);
    $id = $CI->db->insert_id();

    $sql = "SELECT * FROM  tbl_order_code WHERE id='" . $id . "'";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function sms_templates($name = NULL, $flag = FALSE)
{

    $response = NULL;
    $CI = &get_instance();
    if($CI->cache->file->get('sms_template') && $flag == FALSE)
    {
        $data = $CI->cache->file->get('sms_template');
    }
    else
    {
        $CI->db->select(['name','content']);
        $data_temp = $CI->db->get('tbl_sys_sms_template')->result_array();
        if(isset($data_temp) && !empty($data_temp))
        {
            $keys = array_column($data_temp, 'name');
            $values = array_column($data_temp, 'content');
            $data = array_combine($keys, $values);
            $CI->cache->file->save('sms_template', $data, CACHE_EXPIRE);
        }
    }

    if(isset($data) && !empty($data))
    {
        if(isset($name) && !empty($name) && isset($data[$name]) && !empty($data[$name]))
        {
            $response = $data[$name];
        }
        else
        {
            $response = $data;
        }
    }

    return $response;

}
if(!function_exists('tbl_web_setup'))
{
    function tbl_web_setup()
    {
        $CI=get_instance(); 
        
        if($CI->cache->file->get('tbl_web_setup')) {
            $result__ =  $CI->cache->file->get('tbl_web_setup');
            return $result__;
        } else {
            $result = $CI->db->get_where('tbl_web_setup',['id'=>1])->row();
            $CI->cache->file->save('tbl_web_setup', $result, 604800);
            return $result;

        }
    }
}
if(!function_exists('do_upload_file'))
{
    function do_upload_file($input,$dir, $allowed_type='gif|jpg|png|jpeg|pdf|csv')
    {
        $CI=get_instance(); 
        
        $uploadPath=ASSETS_PATH.'uploads/'.$dir;
        // $uploadPath=FCPATH.'/uploads/'.$dir;
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
            //echo "The directory $f_name was successfully created.";
        }

        $config['upload_path']=$uploadPath;
        $config['allowed_types']=$allowed_type;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $CI->load->library('upload',$config);
        $CI->upload->initialize($config);
        if($CI->upload->do_upload($input)){
            $data = $CI->upload->data();
            $result=array('status'=>1,'file_name' =>$data['file_name']);
        }else{
            $result=array('status'=>0,'file_name' =>$CI->upload->display_errors());
        }
        return $result;
    
    }
}
if(!function_exists('do_remove_file'))
{
    function do_remove_file($file,$dir)
    {        
        $url=ASSETS_PATH .'uploads/'.$dir.'/'.$file;
        if(file_exists($url))
        {
            @unlink($url);
        }
    
    }
}
if(!function_exists('get_supplier_profile'))
{
    function get_supplier_profile($supplier_id)
    {
        $CI=get_instance(); 
        $result = $CI->db->get_where('tbl_user_seller_details',['store_id'=>$supplier_id])->row();
        return $result;
    }
}
if(!function_exists('get_supplier_primary_contact'))
{
    function get_supplier_primary_contact($user_id)
    {
        $CI=get_instance(); 
        $result = $CI->db->get_where('tbl_user_seller_primary_contact_branch',['user_id'=>$user_id, 'record_type'=>1, 'as_primary_contact'=>1])->row();
        return $result;
    }
}
if(!function_exists('get_supplier_address'))
{
    function get_supplier_address($supplier_id)
    {
        $CI=get_instance();
        $result = $CI->db->get_where('tbl_user_seller_details',['store_id'=>$supplier_id])->row();
        if(!empty($result)){
            $country = $CI->db->select('name')->get_where('tbl_country',['id'=>$result->organization_country])->row('name');
            $state = $CI->db->select('name')->get_where('tbl_states',['id'=>$result->organization_state])->row('name');
            $city = $CI->db->select('city_name')->get_where('tbl_cities',['id'=>$result->organization_city])->row('city_name');
            return ($city ? $city.', ' : '') . ($state ? $state .', ' : '') . ($country ? $country : '');

        }else{
            return '';
        }
    }
}

if(!function_exists('get_category_names'))
{
    function get_category_names($id)
    {
        $CI=get_instance();
        $CI->db->select('name');
        $CI->db->from('tbl_categories');
        $CI->db->where('id',$id);
        $result = $CI->db->get()->row_array();
        // pr($result); die();
        if(!empty($result)){
            return $result;
            // $country = $CI->db->select('name')->get_where('tbl_country',['id'=>$result->organization_country])->row('name');
            // $state = $CI->db->select('name')->get_where('tbl_states',['id'=>$result->organization_state])->row('name');
            // $city = $CI->db->select('city_name')->get_where('tbl_cities',['id'=>$result->organization_city])->row('city_name');
            // return ($city ? $city.', ' : '') . ($state ? $state .', ' : '') . ($country ? $country : '');

        }else{
            return '';
        }
    }
}
if(!function_exists('showSideBarPopup'))//not in use
{
    function showSideBarPopup()
    {
        $CI=get_instance();
        $user_id  = $_SESSION['auth_user']['users_id'];
        $show = false;
        if (isset($user_id) && !empty($user_id)) { 
            $show = true;
            // $url_arr = [
            //     '0'
            // ];
            // if(in_array($c_url, $url_arr)){
            //     $show = true;
            // }else{
            //     $show = false;
            // }
            return $show;
        }else{
            $show = false;
        }
        return $show;
    }
}
