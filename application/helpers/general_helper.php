<?php 
/**
 * is_protected
 *
 * This function check user already login or not
 * 
 * @access	public
 * @return	boolean
 */

if (!function_exists('is_protected')){

    function is_protected(){
        $CI = &get_instance();
        if ($CI->session->userdata('isLogin') != 'yes') {
            redirect(base_url());
        } 
    }
}

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
			header('Content-Disposition: attachement;filename="' . $download . '"');
			header("Pragma: no-cache");
			header("Expires: 0");
			print "$header\n$data";
		}
	}
}
/* End of Function */


function is_system_admin() {
    $CI = & get_instance();
    $system_admin = $CI->session->userdata('system_admin');
    if (!isset($system_admin) || empty($system_admin)) {
        redirect("sysadmin/login");
    }
    if($system_admin['groups_id']==SELLER_ID){
        $seller_details = $CI->db->select('organization_tab, director_tab, primary_contact_tab, branch_details_tab, other_registration_tab, other_information_tab, division_tab')->get_where('tbl_user_seller_details', ['user_id'=>$system_admin['id']])->row();
        $is_profile_complete = true;
        if($seller_details->organization_tab==2){
            $is_profile_complete = false;
        }
        if($seller_details->director_tab==2){
            $is_profile_complete = false;
        }
        if($seller_details->primary_contact_tab==2){
            $is_profile_complete = false;
        }
        if($seller_details->branch_details_tab==2){
            $is_profile_complete = false;
        }
        if($seller_details->other_registration_tab==2){
            $is_profile_complete = false;
        }
        if($seller_details->other_information_tab==2){
            $is_profile_complete = false;
        }
        if($seller_details->division_tab==2){
            $is_profile_complete = false;
        }
        
        if($is_profile_complete == false){
            if (!$this->input->is_ajax_request()) {
                redirect("sysadmin/seller");
            }
        }
    }
    
}

function is_system_users() {
    $CI = & get_instance();
    $system_admin = $CI->session->userdata('auth_users');
    if (!isset($system_admin) || empty($system_admin)) {
        redirect("");
    }
}

function price_formate($price){ 
	$CI = & get_instance();
	$price =  number_format($price,2); 
	$price = explode('.',$price); 
	$point = isset($price[1])?$price[1]:'00';
	$price = '<span class="rupee">'.$price[0].'</span>.'.$point;
	return $price;
	
}

function resize($image_name, $thumbs_nails_path = '', $width, $height) {
    $CI = & get_instance();
    $base_name = basename(str_replace("\\", "/", $image_name));
    $thumb_image_path = $thumbs_nails_path . $base_name;
    list($image_width, $image_height, $type) = getimagesize($image_name);
    if ($width >= $image_width) {

        $width = $image_width;

    }

    if ($height >= $image_height) {

        $height = $image_height;

    }

    $thumb_scale = min($width / $image_width, $height / $image_height);

    $width = floor($thumb_scale * $image_width);

    $height = floor($thumb_scale * $image_height);

    if ($type == 1) {

        $main_image = imagecreatefromgif($image_name);

    }

    if ($type == 2) {

        $main_image = imagecreatefromjpeg($image_name);

    }

    if ($type == 3) {

        $main_image = imagecreatefrompng($image_name);

    }

    $thumb_image = imagecreatetruecolor($width, $height);

    if (($type == 1) OR ( $type == 3)) {

        imagealphablending($thumb_image, false);

        imagesavealpha($thumb_image, true);

        $transparent = imagecolorallocatealpha($thumb_image, 255, 255, 255, 127);

        imagefilledrectangle($thumb_image, 0, 0, $width, $height, $transparent);
    }

    imagecopyresampled($thumb_image, $main_image, 0, 0, 0, 0, $width, $height, $image_width, $image_height);



    if ($type == 1) {

        imagegif($thumb_image, $thumb_image_path, 100);

    }

    if ($type == 2) {

        imagejpeg($thumb_image, $thumb_image_path, 100);

    }

    if ($type == 3) {



        imagepng($thumb_image, $thumb_image_path);

    }

    imagedestroy($thumb_image);

    imagedestroy($main_image);

    @chmod($thumb_image_path, 0777);



    $explode = explode('/', $thumbs_nails_path);

    if (in_array('product', $explode)) {

        $get_img = UPLOAD_FS_PRODUCT_THUMB_IMAGE_PATH . basename($image_name);

        $img_width = PRODUCT_THUMB_IMAGE_WIDTH;

        $img_height = PRODUCT_THUMB_IMAGE_HEIGHT;

        $thumbs_path = UPLOAD_WHITE_THUMB_PRODUCT_IMAGES;

        list($w, $h) = getimagesize(basename($get_img));

        if ($img_width != $w && $img_height != $h) {

            white_resize($get_img, $thumbs_path);

        }

    }

}


function white_resize($image_name, $thumbs_nails_path) {

    $CI = & get_instance();

    $explode = explode('/', $thumbs_nails_path);

    if (in_array('product', $explode)) {

        $file_path = upload_file_folder(UPLOAD_WHITE_THUMB_PRODUCT_IMAGES);

        $get_img = UPLOAD_FS_PRODUCT_THUMB_IMAGE_PATH . $file_path . basename($image_name);

        $W = PRODUCT_THUMB_IMAGE_WIDTH;

        $H = PRODUCT_THUMB_IMAGE_HEIGHT;

        $thumbs_path = $thumbs_nails_path;
    }

    $im = imagecreatetruecolor($W, $H);

    $stamp = imagecreatefromjpeg($get_img);

    $red = imagecolorallocate($im, 255, 255, 255);

    imagefill($im, 0, 0, $red);

    $sx = imagesx($stamp);

    $sy = imagesy($stamp);

    $marge_right = (imagesx($im) - $sx) / 2;

    $marge_bottom = (imagesy($im) - $sy) / 2;

    imagecopy($im, $stamp, $marge_right, $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
    ob_clean();
    header('Content-Type: image/jpeg');
    imagejpeg($im, $thumbs_path . $file_path . basename($image_name), 95);
}

function data_format($data) {

    $CI = & get_instance();

    if (!empty($data) && $data != '0000-00-00') {

        $newDate = date("d M Y h:i A", strtotime($data));

        return $newDate;

    }
}


function data_format_new($data) {

    if (!empty($data) && $data != '0000-00-00') {

        $CI = & get_instance();

        $newDate = date("d M Y  h:i A", strtotime($data));

        return $newDate;
    }
}


function getGroups($groups_id) {   

    $CI = & get_instance();

    $where = "";

    if ($groups_id != "") {

        $where .= "where id = '" . $groups_id . "'";

    }

    $sql = "select * from `tbl_groups` " . $where . " order by `id`";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;
}

function getModules() {
    $CI = & get_instance();
    $sql = "SELECT id,mod_modulecode from `tbl_module` order by `id`";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getPermission($role_code='',$module_code) {

    $CI = & get_instance();

    $sql = "select * from `tbl_permissions` where `rr_rolecode` = '" . $role_code . "' AND `rr_modulecode` = '".$module_code."'";

    $query = $CI->db->query($sql);

    if ($query->num_rows() > 0) {

        return $query->row();

    }
    else
    {
        return '';
    }
}


function getUserPermission($permissions_id = "", $user = "") {

    $CI = & get_instance();

    $sql = "select tbl_permissions.id,tbl_permissions.path,`tbl_users_permissions`.status from `tbl_users_permissions` inner join tbl_permissions on tbl_permissions.id = tbl_users_permissions.permissions_id AND `tbl_users_permissions`.`permissions_id` = '" . $permissions_id . "' AND `tbl_users_permissions`.`users_id` = '" . $user . "'";

    $query = $CI->db->query($sql);

    $num = $query->num_rows();

    $result = "";

    if ($num > 0) {

        $result = $query->result();

    }

    return $result;

}


function getGroupPermission($permissions_id = "", $group_id = "") {

    $CI = & get_instance();

    $where = "";
    if (!empty($permissions_id)) {

        $where .= "AND `permissions_id` = '" . $permissions_id . "'";

    }

    if (!empty($group_id)) {

        $where .= "AND `groups_id` = '" . $group_id . "'";

    }

    $sql = "select * from `tbl_groups_permissions` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    $data = $query->result();

    return $data;

}



function getCategoryNameId($name = "") {

    $CI = & get_instance();

    $cat_saprator = array();

    $where = "";
    if (!empty($name)) {

        $where .= "AND `name` LIKE '%" . $name . "%'";

    }

    $sql = "select id from `tbl_categories` where status = '1' " . $where . "";

    $query = $CI->db->query($sql);

    $data = $query->result();

    $cat_seprator = "";

    foreach ($data as $category) {

        $cat_saprator[] = $category->id;

    }

    $categories = implode(',', $cat_saprator);

    return $categories;
}



function PermissionAuthentication($section = "", $controller = "", $function = "") {

    $CI = & get_instance();

    $url = "";
    if ($section != "") {

        $url .= $section . "/";

    }

    if ($controller != "") {

        $url .= $controller . "/";

    }

    if ($function != "" && $function != "page" && $function != "index") {

        $url .= $function . "/";

    }

    $system_permission = $CI->session->userdata('system_permission');

    if (!in_array($url, $system_permission)) {

        $msg = '<font color=green>Unauthorized Access !</font><br />';

        $CI->session->set_flashdata('msg', $msg);

        redirect('sysadmin/dashboard', 'refresh');

    } else {
        return true;
    }

}

function getLocation($parent_id = "", $id = "", $name = "", $featured = "", $market_place = "") {

    $CI = & get_instance();

    $limit = "";

    $where = "";

    if ($parent_id != "" || $parent_id == 0) {

        $where .= " AND `parent_id` = '" . $parent_id . "'";

    }

    if ($id != "") {

        $where .= " AND `id` = '" . $id . "'";

    }



    if ($featured != "") {

        $where .= " AND `featured` = '" . $featured . "'";

    }



    if ($market_place != "") {

        $where .= " AND `market_place` = '" . $market_place . "'";

    }



    if ($name != "") {

        $where .= " AND `name` LIKE '" . $name . "%'";

        $limit .= " limit 0,10";

    }

    $sql = "select * from `tbl_locations` where status = '1' " . $where . " order by name asc " . $limit;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function getLocationname($parent_id = "", $id = "", $name = "", $featured = "") {

    $CI = & get_instance();

    $limit = "";

    $where = "";

    if ($parent_id != "" && $parent_id == 0) {

        $where .= " AND `parent_id` = '" . $parent_id . "'";

    }

    if ($id != "") {

        $where .= " AND `id` = '" . $id . "'";

    }



    if ($featured != "") {

        $where .= " AND `featured` = '" . $featured . "'";

    }



    if ($name != "") {

        $where .= " AND `name` LIKE '" . $name . "'";

        $limit .= " limit 0,10";

    }

    $sql = "select * from `tbl_locations` where status=1 " . $where . " order by name asc " . $limit;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function get_individual_location($id) {

    $CI = & get_instance();

    $CI->load->model("location_model");

    $result = $CI->location_model->get_individual_location($id);

    return $result;

}



function upload_file_folder($folder_path) {

    $year = date('Y') . '/';

    $folder_path_year = $folder_path . $year;

    $month = date('M') . '/';

    $folder_path_month = $folder_path_year . $month;



    $month_year = date('Y') . '/' . date('M') . '/';

    if (!file_exists($folder_path_year)) {

        mkdir($folder_path_year, 0777, true);

        chmod($folder_path_year, 0777);

    }



    if (!file_exists($folder_path_month)) {

        mkdir($folder_path_month, 0777, true);

        chmod($folder_path_month, 0777);

    }

    return $month_year;

}



function update_token($email, $value) {

    $CI = & get_instance();

    $sql = "update tbl_users set token='" . $value . "' where email_address = '" . $email . "'";

    $CI->db->query($sql);

    return true;

}



function check_id($id = "") {

    $CI = & get_instance();

    if ($id == "" || !is_numeric($id)) {

        redirect(MAINSITE_URL . 'home');

    }

}



function getSystemEmail($name = "") {
    $CI = & get_instance();
    $where = "";
    if ($name != "") {
        $where .= " AND `name` = '" . $name . "'";
    }
    $sql = "select * from `tbl_sys_email_template` where 1 " . $where;
    $query = $CI->db->query($sql);
    return $query->result();
}



function getLocationString($location = "") {

    $CI = & get_instance();

    $where = "";

    if (is_numeric($location)) {

        $sql = "select * from `tbl_locations` where id = '" . $location . "'";

        $query = $CI->db->query($sql);

        $location = $query->result();

        return $location[0]->name;

    } else {

        return $location;

    }

}



//function by Braham Dev for re-populating form with table data and set_value

function getValue($Data, $formField, $setValue = '') {

    if (count($Data)) {

        if (is_object($Data) && isset($Data->$formField)) {

            return $Data->$formField;

        } else if (isset($Data[$formField])) {

            return $Data[$formField];

        }

    } else {

        return $setValue;

    }

}


function get_cms_pages($id = "", $page_type = "", $parent_id = "", $users_id = "") {

    $CI = & get_instance();

    $where = "";

    if ($id != "") {

        $where .= "AND id = '" . $id . "'";

    }

    if ($page_type != "") {

        $where .= "AND page_type = '" . $page_type . "'";

    }

    if ($parent_id != "") {

        $where .= "AND parent_id = '" . $parent_id . "'";

    }



    if ($users_id != "") {

        $where .= "AND users_id = '" . $users_id . "'";

    }

    // $where .= "AND status = '1'";

    //$where .= " order by sort_order ASC"; 

    $sql = "select * from `tbl_cms` where 1 " . $where . " ";

    $query = $CI->db->query($sql);



    return $query->result();

}


function get_top_search_keyword() {

    $CI = & get_instance();

    $where = "";

    $sql = "select * from `tbl_search_keyword` where 1 " . $where . " ORDER BY hits DESC, keyword ASC limit 4";

    $query = $CI->db->query($sql);



    return $query->result();

}



function getProdcutImg($id = "", $product_id = "", $order_by = "ASC") {

    $CI = & get_instance();

    $where = "";

    if ($id != "") {

        $where .= " AND `id` = '" . $id . "'";

    }



    if ($product_id != "") {

        $where .= " AND `product_id` = '" . $product_id . "'";

    }



    $where .= " order by sort_order $order_by";

    $sql = "select * from `tbl_product_images` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data = $row;

        }

    }

    return $data;

}



function getProdcutImages($id = "", $product_id = "", $users_id = "") {

    $CI = & get_instance();

    $where = "";

    if ($id != "") {

        $where .= " AND `tbl_product_images`.`product_id` = '" . $id . "'";

    }



    if ($product_id != "") {

        $where .= " AND `tbl_product_images`.`product_id` = '" . $product_id . "'";

    }



    if ($users_id != "") {

        $where .= " AND `tbl_product`.`users_id` = '" . $users_id . "'";

    }

    $where .= " order by sort_order ASC";

    $sql = "select `tbl_product_images`.*  from `tbl_product_images` left join `tbl_product` on `tbl_product`.`id` = `tbl_product_images`.`product_id` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    return $query->result_array();

}



function getUserId($username = "") {

    $CI = & get_instance();

    $where = "";

    if ($username != "") {

        $where .= "AND username = '" . $username . "'";

    }





    $sql = "select id from `tbl_users` where 1 " . $where . "";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}


function getBanner($id = "", $users_id = "", $group_id = "", $not_group_id = "") {

    $CI = & get_instance();

    $where = "";

    if ($id != "") {

        $where .= " AND tbl_banner.id = '" . $id . "'";

    }

    if ($users_id != "") {

        $where .= " AND tbl_banner.users_id = '" . $users_id . "'";

    }

    if ($group_id != "") {

        $where .= " AND tbl_users.groups_id = '" . $group_id . "'";

    }

    if ($not_group_id != "") {

        $where .= " AND tbl_users.groups_id != '" . $not_group_id . "'";

    }

    $where .= " AND tbl_banner.status = '1'";

    $sql = "select tbl_banner.* from `tbl_banner` left join tbl_users on tbl_users.id = tbl_banner.users_id where 1 " . $where . " order by `sort_order` ASC";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function getProduct($product_id = "", $users_id = "", $group_by = "", $num = "", $featured = "", $limit = "") {

    $CI = & get_instance();

    $where = "";

    if ($product_id != "") {

        $where .= " AND `tbl_product`.`id` = '" . $product_id . "'";

    }



    if ($users_id != "") {

        $where .= " AND `tbl_product`.`users_id` = '" . $users_id . "'";

    }



    if ($featured != "") {

        $where .= " AND `tbl_product`.`featured` = '1' AND `tbl_product`.`status` = '1' ";

    }



    if ($group_by != "") {

        $where .= " group by `tbl_product`.`users_id`";

    } else {

        $where .= " group by `tbl_product`.`id`";

    }

    $where .= " order by id DESC";



    $limit_txt = "";

    if ($limit > 0) {

        $limit_txt = " limit " . $limit;

    }

    $sql = "select `tbl_product`.*, `tbl_users`.`first_name`,`tbl_users`.`last_name`,`tbl_users`.`company_name` from `tbl_product` left join `tbl_users` on `tbl_users`.`id` = `tbl_product`.`users_id` where 1 " . $where . " " . $limit_txt;

    $query = $CI->db->query($sql);

    $data = "";

    if ($num != "") {

        return $query->num_rows();

    }

    if ($query->num_rows() > 0) {

        return $query->result();

    }

    return false;

}


function getLocationsIds($name = '') {

    $CI = & get_instance();

    $where = "";

    if ($name != "") {

        $where .= " AND LCASE(`name`) = '" . $name . "'";

    }

    $sql = "SELECT * FROM `tbl_locations` WHERE `name` LIKE '" . trim($name) . "'";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        return $query->result();

    }

    return false;

}



function get_category_name($categories_id) {

    $CI = & get_instance();

    $sql = "select categories_name  from tbl_blog_categories where categories_id='$categories_id'";

    $query = $CI->db->query($sql);

    $data = $query->row();

    return $data;

}



function getBlogCategory($parent_id = "", $id = "", $no_parent = "", $featured = "", $limit = "") {

    $CI = & get_instance();

    $where = "";

    if (is_numeric($parent_id)) {

        $where .= " AND `tbl_blogs_categories`.`parent_id` = '" . $parent_id . "'";

    }



    if (is_numeric($no_parent)) {

        $where .= " AND `tbl_blogs_categories`.`parent_id` != '" . $parent_id . "'";

    }



    if ($id != "") {

        $where .= " AND `tbl_blogs_categories`.`id` = '" . $id . "'";

    }



    if ($featured != "") {

        $where .= " AND `tbl_blogs_categories`.`featured` = '" . $featured . "'";

    }



    //$where .= "order by  `tbl_blogs_categories`.`name` asc `tbl_blogs_categories`.`date_added` DESC  ";

    // $where .= " 'order_by `tbl_blogs_categories`.`date_added` DESC  `tbl_blogs_categories`.`name` asc'";

    if ($limit != "") {

        $where .= " limit 0, " . $limit . "";

    }



    $sql = "select `tbl_blogs_categories`.* from `tbl_blogs_categories` where `tbl_blogs_categories`.`status` = '1' " . $where . " order by`tbl_blogs_categories`.`date_added` DESC,`tbl_blogs_categories`.`id`";



    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function getBlogSubCategory($parent_id = "", $id = "", $no_parent = "", $featured = "", $limit = "") {

    $CI = & get_instance();

    $where = "";

    if (is_numeric($parent_id)) {

        $where .= " AND `tbl_blogs_categories`.`parent_id` != '" . $parent_id . "'";

    }



    if (is_numeric($no_parent)) {

        $where .= " AND `tbl_blogs_categories`.`parent_id` != '" . $parent_id . "'";

    }



    if ($id != "") {

        $where .= " AND `tbl_blogs_categories`.`id` = '" . $id . "'";

    }



    if ($featured != "") {

        $where .= " AND `tbl_blogs_categories`.`featured` = '" . $featured . "'";

    }



    $where .= "order by  `tbl_blogs_categories`.`name` asc";



    if ($limit != "") {

        $where .= " limit 0, " . $limit . "";

    }



    $sql = "select `tbl_blogs_categories`.* from `tbl_blogs_categories` where `tbl_blogs_categories`.`status` = '1' " . $where . "";



    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function getUsersCategoryexport($users_id = "", $parent_category_id = "", $no_parent_category_id = "no") {

    $CI = & get_instance();

    $where = "";

    if ($users_id != "") {

        $where .= " AND `tbl_users_category`.`users_id` = '" . $users_id . "'";

    }



    if ($parent_category_id != "") {

        $where .= " AND `tbl_users_category`.`parent_category_id` = '" . $parent_category_id . "'";

    }



    if (is_numeric($no_parent_category_id)) {

        $where .= " AND `tbl_users_category`.`parent_category_id` != '" . $no_parent_category_id . "'";

    }



    $where .= " group by tbl_users_category.parent_category_id";

    $sql = "select  IF( tbl_categories.name IS NULL , 'Others', tbl_categories.name ) name,tbl_categories.id,tbl_categories.parent_id from `tbl_users_category` left join `tbl_categories` on `tbl_categories`.`id` = `tbl_users_category`.`category_id` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function getRecentBlog($featured = "", $limit = "") {

    $CI = & get_instance();

    $where = "";



    if ($featured != "") {

        $where .= " AND `tbl_blog`.`featured` = '" . $featured . "'";

    }



    if ($limit != "") {

        $where .= " limit 0, " . $limit . "";

    }

    $sql = "select * from tbl_blog where status = '1'  ORDER BY `tbl_blog`.`article_date` DESC,`tbl_blog`.`blog_id` DESC " . $where . "";

    $query = $CI->db->query($sql);

    //echo $CI->db->last_query(); 

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function getRecentarchive() {

    $CI = & get_instance();

    $where = "";

    $sql = "SELECT MONTHNAME(`article_date`) as month,year (`article_date`) as year FROM `tbl_blog` where `status`='1'  GROUP BY YEAR(article_date), MONTH(article_date) DESC ORDER BY YEAR(article_date) DESC";



    $query = $CI->db->query($sql);

    //echo $CI->db->last_query(); 

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function geTagType($tag_id = "", $tag = "") {

    $CI = & get_instance();

    $where = "";

    if ($tag_id != "") {

        $where .= " AND `tbl_blog_tag`.`blog_tag_id` = '" . $tag_id . "'";

    }



    if ($tag != "") {

        $where .= " AND `tbl_blog_tag`.`tag_id` = '" . $tag . "'";

    }



    $sql = "select tbl_master_tag.name from `tbl_blog_tag` left join tbl_master_tag on tbl_master_tag.id = tbl_blog_tag.tag_id where 1 " . $where;







    $query = $CI->db->query($sql);

    $data = array();

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            array_push($data, $row['name']);

        }

        //print_r($data);die;

        return $data;

    }

    //return $data;

}



function getTagname($id = "", $name = "") {

    $CI = & get_instance();

    $limit = "";

    $where = "";



    if ($id != "") {

        $where .= " AND `id` = '" . $id . "'";

    }



    if ($name != "") {

        $where .= " AND `name` LIKE '" . $name . "'";

        $limit .= " limit 0,10";

    }

    $sql = "select * from `tbl_master_tag` where status=1 " . $where . " order by name asc " . $limit;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function geTagTypes($tag_id = "", $tag = "") {

    $CI = & get_instance();

    $where = "";

    if ($tag_id != "") {

        $where .= " AND `tbl_blog_tag`.`blog_tag_id` = '" . $tag_id . "'";

    }



    if ($tag != "") {

        $where .= " AND `tbl_blog_tag`.`tag_id` = '" . $tag . "'";

    }



    $sql = "select tbl_master_tag.name,tbl_blog_tag.tag_id from `tbl_blog_tag` left join tbl_master_tag on tbl_master_tag.id = tbl_blog_tag.tag_id where 1 " . $where;

    $query = $CI->db->query($sql);

    if ($query->num_rows() > 0) {

        return $query->result();

    }

}



function getBlogCategoryParent($categories_id) {

    $CI = & get_instance();

    $sql = "select parent_id from `tbl_blogs_categories` where `id` = '" . $categories_id . "'";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}



function search_text_exact($text) {



    $CI = & get_instance();

    $string = "";

    $cat_present = 0;

    $sql3 = "select tbl_categories.parent_id,tbl_categories.id from `tbl_categories` where status=1 AND name= '" . $text . "' ";

    $query3 = $CI->db->query($sql3);

    $data3 = "";

    $num3 = $query3->num_rows();

    if ($num3 > 0) {

        $data3 = $query3->result();

        $sub_category_list = getCategory($data3[0]->id);

        if (!empty($sub_category_list)) {

            $string .= '&parent_cat_arr[]=' . $data3[0]->id;

        } else {

            $string .= '&cat_arr[]=' . $data3[0]->id;

        }

        $cat_present = 1;

    }

    return $string;

}

function search_text_split($text = "") {

    $CI = & get_instance();

    $city_str = "";

    $remaining_text = "";

    if (!empty($text)) {

        $explode_string = explode(" ", $text);

        #$match_string = array(" in ", " and ", " or ", " like ", " from "); // Comment on 09Feb 2016

        $match_string = array();

        $string = "";

        usort($match_string, 'arr_sort');

        $remaining_text = str_replace($match_string, " ", strtolower($text));

        $brack_remaininng = array();

        $new_brack_remaininng = array();

        $brack_remaininng = explode(" ", $remaining_text);

        $special_words = array("&", "_", "-", "@");

        foreach ($brack_remaininng as $brack) {

			/*if (strlen($brack) > 1 || in_array($brack, $special_words)) {  //Commented on 26th Feb 2016 */ 

            if (strlen($brack) > 0 || in_array($brack, $special_words)) {

                $new_brack_remaininng[] = $brack;

            }

        }

        $remaining_text = implode(" ", $new_brack_remaininng);

        $remaining_text = urlencode($remaining_text);

        //echo trim($string.'&text='.$remaining_text).$city_str;die;

        return trim($string . '&text=' . $remaining_text) . $city_str;

    }

}

function arr_sort($a, $b) {

    return strlen($b) - strlen($a);

}

function getcategoryId($id = "") {

    $CI = & get_instance();

    $where = "";

    if (!empty($id)) {
        $where .= "AND `parent_id` ='" . $id . "'";
    }

    $sql = "select id from `tbl_blogs_categories` where 1 " . $where . "";

    $query = $CI->db->query($sql);

    $data = $query->result();

    $cat_saprator = array();

    foreach ($data as $category) {

        $cat_saprator[] = $category->id;

    }
    $categories = implode(',', $cat_saprator);
    return $categories;
}

/* 04 june */

function get_seocompany_name() {

    $CI = & get_instance();

    $sql = "select product_id,product_name  from tbl_product order by product_id";

    $query = $CI->db->query($sql);

    $data = $query->result();

    return $data;

}



function update_seo_name($id,$newName) {

    $CI = & get_instance();

    $sql = "update tbl_product set product_url='".$newName."' where product_id='".$id."'";

    $query = $CI->db->query($sql);

}

/* This function use for any array print 04-06-2016*/

function pr($var, $strict = false) {

	$CI = & get_instance();

	if ($var != NULL) {

		if ($strict == false) {

			if( is_array($var) ||  is_object($var) ) {

				echo "<pre>";print_r($var);echo "</pre>";

			 }else{

				echo $var;

			 }

		}else{

			if( is_array($var) ||  is_object($var) ) {

				echo "<pre>";var_dump($var);echo "</pre>";

			 }else{

				var_dump($var) ;

			  }

		}

	}else {

		var_dump($var) ;

	}

}

/* 06 june            */

function getProductlist($supplier_id) {

    $CI = & get_instance();

    $sql = "select id,name,description  from tbl_product where users_id='".$supplier_id."' order by users_id";

    $query = $CI->db->query($sql);

    $data = $query->result();

    return $data;

}

function exhibitionList($users_id){

	$CI = & get_instance();

    $sql = "select id,title  from tbl_exhibition where users_id='".$users_id."' order by id";

    $query = $CI->db->query($sql);

    $data = $query->result();

    return $data;

}

function getRequirementmages($id = "", $requirement_id = "", $users_id = "") {

    $CI = & get_instance();

    $where = "";

    if ($id != "") {

        $where .= " AND `tbl_requirement_files`.`requirement_id` = '" . $id . "'";

    }



    if ($requirement_id != "") {

        $where .= " AND `tbl_requirement_files`.`requirement_id` = '" . $requirement_id . "'";

    }



    if ($users_id != "") {

        $where .= " AND `tbl_requirement`.`users_id` = '" . $users_id . "'";

    }

    $where .= " order by id ASC";

    $sql = "select `tbl_requirement_files`.*  from `tbl_requirement_files` left join `tbl_requirement` on `tbl_requirement`.`id` = `tbl_requirement_files`.`requirement_id` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    return $query->result_array();

}

function getRequirementImg($id = "", $requirement_id = "", $order_by = "ASC") {

    $CI = & get_instance();

    $where = "";

    if ($id != "") {

        $where .= " AND `id` = '" . $id . "'";

    }



    if ($requirement_id != "") {

        $where .= " AND `requirement_id` = '" . $requirement_id . "'";

    }



    $where .= " order by sort_order $order_by";

    $sql = "select * from `tbl_requirement_files` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data = $row;

        }

    }

    return $data;

}

function getUsersProductCategory($users_id = "") {

    $CI = & get_instance();

    $sql = "SELECT tbl_product_category.*, tbl_categories.* FROM tbl_product_category INNER JOIN tbl_categories on tbl_product_category.category_id  = tbl_categories.id WHERE tbl_product_category.users_id= '$users_id' group by tbl_product_category.category_id";

    $result = $CI->db->query($sql)->result();

    return $result;

}

function getCountUsersProductCategory($users_id = "", $product_category ="") {

    $CI = & get_instance();

    $sql = "select count(tbl_product_category.parent_category_id) as total_record from tbl_product_category join tbl_product on tbl_product.id = tbl_product_category.product_id where tbl_product.users_id = '$users_id' and tbl_product_category.category_id = '$product_category' and tbl_product.status=1";

    $count = $CI->db->query($sql)->row()->total_record;

    return $count;

}



/* 14 June ----------------- */

function getProductTypeList() {

    $CI = & get_instance();

    $sql = "select * from `tbl_producttype` where producttype_status=1 order by producttype_id desc";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}

function getMetalTypeList() {

    $CI = & get_instance();

    $sql = "select * from `tbl_metaltype` where metal_status=1 order by metal_id desc";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}

function getPurityList($metal_id) {

    $CI = & get_instance();

    $sql = "select * from `tbl_metalpurity` where metal_status=1 and metal_type_id='".$metal_id."' order by metal_id desc";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}

function getProductCategoryList($users_id = "", $parent_id = "") {

    $CI = & get_instance();

    $where = "";

    if ($users_id != "") {

        $where .= " AND `tbl_users_category`.`users_id` = '" . $users_id . "'";

    }

	 if ($parent_id != "") {

       $where .= " AND `tbl_users_category`.`parent_category_id` = '" . $parent_id . "'";

    }

	if ($parent_id== "") {

       $where .= " AND `tbl_users_category`.`parent_category_id` = '" . $parent_id . "'";

    }

   $sql = "select tbl_categories.name,tbl_categories.parent_id,tbl_categories.id  from `tbl_users_category` left join `tbl_categories` on `tbl_categories`.`id` = `tbl_users_category`.`category_id` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}

function getSupplierCategory($users_id="",$product_id="") {

    $CI = & get_instance();

	 $where = "";

	 if ($users_id != "") {

		  $where .= " AND `tbl_product_category`.`users_id` = '" . $users_id . "'";

	 }

	 if ($product_id != "") {

		  $where .= " AND `tbl_product_category`.`product_id` = '" . $product_id . "'";

	 }

    $sql = "select  IF( tbl_categories.name IS NULL , 'Others', tbl_categories.name ) name ,tbl_categories.parent_id,tbl_categories.id  from `tbl_product_category` left join `tbl_categories` on `tbl_categories`.`id` = `tbl_product_category`.`category_id` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

		foreach ($query->result() as $row) 

				{

					$data[] = $row;

				}

				    return $data;

    }

	 return false;

}

function getUserProductCategory($users_id = "", $product_id = "") {

    $CI = & get_instance();

    $where = "";

    if ($users_id != "") {

        $where .= " AND `tbl_product_category`.`users_id` = '" . $users_id . "'";

    }

	 if ($product_id != "") {

       $where .= " AND `tbl_product_category`.`product_id` = '" . $product_id . "'";

    }

   $sql = "select tbl_categories.name,tbl_categories.parent_id,tbl_categories.id  from `tbl_product_category` left join `tbl_categories` on `tbl_categories`.`id` = `tbl_product_category`.`category_id` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

}

function getUserProductCategoryName($product_id="",$category_id="")

{ $CI = & get_instance();

 $where = "";

    if ($product_id != "") {

        $where .= " AND `tbl_product`.`id` = '" . $product_id . "'";

    }

	 if ($category_id != "") {

       $where .= " AND `tbl_product`.`group_id` = '" . $category_id . "'";

    }

	$sql = "select tbl_categories.name,tbl_categories.parent_id,tbl_categories.id  from `tbl_product` left join `tbl_categories` on `tbl_categories`.`id` = `tbl_product`.`group_id` where 1 " . $where;

	$query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();

    }

    return $data;

	}

	

	function getCatName($field,$id) {

		$CI = & get_instance();

		$sql = "select name,id,parent_id from tbl_categories where $field ='".$id."'";

		$query = $CI->db->query($sql);

		$data = $query->result();

		return $data;

	}
	
		
function userEmailIdbyid($customer_id) {
		$CI = & get_instance();
		$sql = "select email_address,mobile from tbl_users where id ='".$customer_id."'";
		$query = $CI->db->query($sql);
		$data = $query->result();
		return $data;
	}
	
	
	if (!function_exists('_sendMailPhpMailer1')) {

    function _sendMailPhpMailer1($email_data) {
        $CI = &get_instance();
        $this->config->item();
       //$isCISendmail =true;
        $isCISendmail   =   $CI->config->item('sendmailCI');
        if($isCISendmail){// mail send by CI sendmail
            
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset']  = 'iso-8859-1';
            $config['wordwrap'] = true;
            
            $CI->email->set_mailtype("html");
            $CI->email->initialize($config);
            $CI->email->from($email_data['from'], ucwords($email_data['sender_name']));

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
           
       
            $msg =  $data['message'];
      
            $CI->email->message($msg);

            if ($CI->email->send()) {
                
                return TRUE;
            } else {
                
                return FALSE;
            }
            
        }else{
            $CI->load->library('sendmail');
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
            $data['message'] = $email_data['message'];
            if(isset($email_data['cmp_logo'])){
                $data['cmp_logo']   =   @$email_data['cmp_logo'];
            }else{
                $data['cmp_logo']   =   @currentuserinfo()->cmp_logo;
            }
        
            $msg = $data['message'] ;
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

function paynow($post=null){
    require APPPATH.'helpers/payu.php';
 
    
    if (count($post)) {
	  pay_page( array ('key' => '5jvBR4', 'txnid' => uniqid(), 'amount' =>$post['amount'],
			'firstname' => $post['firstname'], 'email' => $_POST['email'], 'phone' => $post['phone'],
			'productinfo' =>$post['productinfo'], 'surl' => 'payment_success', 'furl' => 'payment_failure'), 
			'JBq22BGL' );
             return true;

     }else{
         return false;
     }
  
}

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
            $msg = '<div class="alert alert-success flash-row text-left">
                            <button class="close alert-close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>
                            ' . $success . ' </div>';
        } elseif ($error) {
            $msg = '<div class="alert alert-danger flash-row text-left">
			<button class="close alert-close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-close green"></i>
			' . $error . ' </div>';
        } elseif ($warning) {
            $msg = '<div class="alert alert-warning flash-row text-left">
			<button class="close alert-close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			' . $warning . '</div>';
        }
        return $msg;
    }

}

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
        if($CI->input->is_ajax_request()){
            return TRUE;
        }else{
            return FALSE;
        }
        //show_error('No direct script access allowed');
           
    }

}
if (!function_exists('getGroupIds')) {

    function getGroupIDs() {
        $CI = &get_instance();
        $usersdata = $CI->session->userdata('system_admin');
        return $usersdata['groups_id'];
           
    }

}
	
