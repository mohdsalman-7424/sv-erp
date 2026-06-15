<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_functions {

    var $CI;
    var $status_arr = array("1" => "Active", "0" => "Inactive");
    var $status_img_arr = array("0" => '<img src=../assets/images/in-active.png>', "1" => '<img src=../assets/images/active.gif>');
    var $features_img_arr = array("0" => '<img src=../assets/images/images.jpg>', "1" => '<img src=../assets/images/favorites.png>');
    var $recomonded_img_arr = array("0" => '<img src=../assets/images/grey-sign.png>', "1" => '<img src=../assets/images/green-sign.png>');
    var $star_img_arr = array("0" => '<img src=../assets/images/star1.gif>', "1" => '<img src=../assets/images/star2.gif>');
    var $rating_arr = array("0" => 'Online Response Time', "1" => 'Industry References', "2" => 'No of Transactions done on MYHEERA', "3" => 'Quality Assurance', "4" => 'Quick Payments Terms');

    //Log
    function recordActionLog($action_module, $action_type, $ref_id, $users_id, $ip_address) {
        $CI = & get_instance();
        $CI->load->model("general_model");

        $save['action_module'] = $action_module;
        $save['action_type'] = $action_type;
        $save['ref_id'] = $ref_id;
        $save['users_id'] = $users_id;
        $save['ip_address'] = $ip_address;
        $save['action_date'] = time();
        //print_r($save);exit;
        return $CI->general_model->recordActionLog($save);
    }

    public function __construct() {
        $this->CI = & get_instance();
    }

    function get_location_count($id) {

        $sql = "select * from tbl_locations where parent_id='$id'";
        $query = $this->CI->db->query($sql);
        //echo $this->CI->db->last_query();
        return $query->num_rows();
    }

    function createStatusList($status_id = "") {

        $this_list = '';
        foreach ($this->status_arr as $s_id => $s_name) {
            if ($status_id == $s_id && $status_id != "") {
                $this_list .= "<OPTION value=\"" . $s_id . "\"  selected >" . $s_name . "</OPTION>";
            } else {
                $this_list .= "<OPTION value=\"" . $s_id . "\" >" . $s_name . "</OPTION>";
            }
        }

        return $this_list;
    }

    function date_to_display($date) {
        if (!empty($date)) {
            list($year, $month, $day) = preg_split("/[\/.-]/", $date);
            return $day . "-" . $month . "-" . $year;
        }
    }

    function datetime_to_display($datetime) {
        $data_arr = explode(" ", $datetime);
        $date = $data_arr[0];
        $time = $data_arr[1];

        list($year, $month, $day) = preg_split("/[\/.-]/", $date);
        return $day . "-" . $month . "-" . $year . " " . $time;
    }

    function date_to_store($date) {
        if (!empty($date)) {
            $year = "";
            $month = "";
            $day = "";
            if (!empty($date)) {
                list($day, $month, $year) = preg_split("/[\/.-]/", $date);
            }
            return $year . "-" . $month . "-" . $day;
        }
        return;
    }

    function date_to_storenew($date) {
        $year = "";
        $month = "";
        $day = "";
        if (!empty($date)) {
            list($day, $month, $year) = preg_split("/[\/.-]/", $date);
        }
        return $year . "-" . $month . "-" . $day;
    }

    function datetime_to_display_new($datetime) {
        $data_arr = explode(" ", $datetime);
        $date = $data_arr[0];


        list($year, $month, $day) = preg_split("/[\/.-]/", $date);
        return $day . "-" . $month . "-" . $year;
    }

    function getStatusVal($status_id = "") {
        return $this->status_img_arr[$status_id];
    }

    function getFeaturedVal($featured_id = "") {
        return $this->features_img_arr[$featured_id];
    }

    function getrecomondedVal($recom_id = "") {
        return $this->recomonded_img_arr[$recom_id];
    }

    function get5StarVal($recom_id = "") {
        return $this->star_img_arr[$recom_id];
    }

    public function findExtension($filename) {
        $filename = strtolower($filename);
        $exts = explode(".", $filename);
        $n = count($exts) - 1;
        $exts = $exts[$n];
        return $exts;
    }

    //Upload File Function
    public function upload_folder_file($form_field_name = 'user_file', $upload_path = '', $allowed_filetype = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|rtf|ogv|mp4|webm|mp3', $file_maxsize = '2000KB', $u_year = '') {
        //echo $form_field_name;
        //echo $upload_path;
        if (empty($u_year)) {
            $upload_path = $upload_path . date('Y') . "/";
        } else {
            $upload_path = $upload_path . $u_year . "/";
        }
        //echo $upload_path;
        //exit;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
            chmod($upload_path, 0777);
        }

        $config = array(
            'upload_path' => $upload_path,
            //'upload_url' => base_url()."files/",
            'allowed_types' => $allowed_filetype,
            //'overwrite' => TRUE,
            //'xss_clean' => TRUE,
            'max_size' => $file_maxsize//,
                //'max_height' => "768",
                //'max_width' => "1024"
        );

        $this->CI->load->library('upload');
        $this->CI->upload->initialize($config);

        if ($this->CI->upload->do_upload($form_field_name)) {
            $image_data = $this->CI->upload->data();
            //echo $image_data['file_name'];
            return $image_data['file_name'];
        }
    }

    public function make_thumb($image_path, $thumb_path, $image_name, $thumb_width = 150, $thumb_height = 150) {


        if (!is_dir($thumb_path)) {
            mkdir($thumb_path, 0777, TRUE);
            chmod($thumb_path, 0777);
        }

        $source_image = $image_path;
        $new_image = $thumb_path . $image_name;


        $this->CI->load->library('image_lib');


        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['new_image'] = $new_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $thumb_width;
        $config['height'] = $thumb_height;

        $this->CI->image_lib->initialize($config);

        if (!$this->CI->image_lib->resize()) {
            echo $this->CI->image_lib->display_errors();
        }

        //echo $thumb_width."--".$thumb_height;
        //echo $image_path."<br>";
        //echo $new_image."<br>";
        //exit;
    }

    ##########################################################################################################
    # IMAGE FUNCTIONS																						 #
    # You do not need to alter these functions																 #
    ##########################################################################################################
    public function resizeImage($image, $width, $height, $scale) {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image);
        $imageType = image_type_to_mime_type($imageType);
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);

        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $image, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $image);
                break;
        }
        chmod($image, 0777);
        return $image;
    }

    //You do not need to alter these functions
    public function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale) {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image);
        $imageType = image_type_to_mime_type($imageType);

        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $thumb_image_name);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $thumb_image_name, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $thumb_image_name);
                break;
        }
        chmod($thumb_image_name, 0777);
        return $thumb_image_name;
    }

    //You do not need to alter these functions
    public function getHeight($image) {
        $size = getimagesize($image);
        $height = $size[1];
        return $height;
    }

    //You do not need to alter these functions
    public function getWidth($image) {
        $size = getimagesize($image);
        $width = $size[0];
        return $width;
    }

    public function getCountryName($data_id = "") {
        if (!empty($data_id)) {
            $sql = "select name from tbl_locations where id='$data_id'";

            $query = $this->CI->db->query($sql);
            foreach ($query->result() as $row) {
                return $row->name;
            }
        }
        return "";
    }

    public function get_count_seller($type = "0", $status = "", $from_date = "", $to_date = "") {

        $this->CI->db->select('r.id,r.groups_id,r.status, r1.users_id,r1.users_type_id, r1.users_type_parent_id');
        $this->CI->db->from("tbl_users as r");
        $this->CI->db->join("tbl_users_data  as r1", "r.id=r1.users_id", "left");
        $this->CI->db->where("r1.users_type_parent_id='" . $type . "'", NULL, FALSE);
        $this->CI->db->where("r.status='" . $status . "'", NULL, FALSE);

        if (!empty($from_date) || !empty($to_date)) {
            $this->CI->db->where("r.date_added between '" . $from_date . " 0000-00-00 00:00:00' and '" . $to_date . " 23:59:59'");
        }

        $this->CI->db->order_by("r.id", "DESC");
        $query = $this->CI->db->get();
        //$query = $this->CI->db->query($sql);
        //echo $this->CI->db->last_query();
        $total = $query->num_rows();
        if ($total > 0) {
            return $total;
        }

        return 0;
    }

    public function get_classified_count($status = "", $from_date = "", $to_date = "") {

        if ($status != "") {
            $this->CI->db->where("`tbl_classified`.status", $status);
        }

        if (!empty($from_date) || !empty($to_date)) {
            $this->CI->db->where("tbl_classified.date_added between '" . $from_date . " 0000-00-00 00:00:00' and '" . $to_date . " 23:59:59'");
        }
        $query = $this->CI->db->get('tbl_classified');
        //print_r($this->CI->db->last_query());
        $total = $query->num_rows();
        if ($total > 0) {
            return $total;
        }

        return 0;
    }

    public function get_enquiry_count($tbl, $status = "", $from_date = "", $to_date = "") {

        if ($status != "") {
            $this->CI->db->where("$tbl.status", $status);
        }

        if (!empty($from_date) || !empty($to_date)) {
            $this->CI->db->where("$tbl.date_added between '" . $from_date . " 0000-00-00 00:00:00' and '" . $to_date . " 23:59:59'");
        }
        $query = $this->CI->db->get($tbl);
        //print_r($this->CI->db->last_query());
        $total = $query->num_rows();
        if ($total > 0) {
            return $total;
        }

        return 0;
    }

    public function getpackage_type($users_type_id = "") {

        if ($users_type_id != "") {
            $this->CI->db->where("`tbl_users_type_to_package`.users_type_id", $users_type_id);
        }
        $query = $this->CI->db->get('tbl_users_type_to_package');
        $total = $query->num_rows();
        if ($total > 0) {
            foreach ($query->result() as $row) {
                return $row->package_id;
            }
        }

        return 0;
    }

    function impression_count($id = "", $users_id = "") {
        $CI = & get_instance();
        $CI->load->model('general_model');

        $total_data = $CI->general_model->update_impression($id, $users_id);

        return $total_data;
    }

    function total_impression_count($users_id = "") {
        $CI = & get_instance();
        $CI->load->model('general_model');

        $result = $CI->general_model->get_impressions_count($users_id);
        return $result;
    }

    function getPackagepermissionName($id = "") {
        if (!empty($id)) {
            $sql = "select name from  tbl_packages_permission where id='$id'";
            $query = $this->CI->db->query($sql);
            foreach ($query->result() as $row) {
                return $row->name;
            }
        }
        return "";
    }

    function get_franchise_feature($id = "") {
        if (!empty($id)) {
            $sql = "select * from  tbl_franchises where users_id='$id'";
            $query = $this->CI->db->query($sql);
            return $query->result();
        }
        return "";
    }

    function getPackagepermission($id = "") {
        $where = "";
        if (!empty($id)) {
            $where = " and  id = '" . $id . "'";
        }
        $sql = "select * from  tbl_packages_permission where 1 $where";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }

    public function substrwords($text, $maxchar, $end = '...') {
        if (strlen($text) > $maxchar) {
            $words = preg_split('/\s/', $text);
            $output = '';
            $i = 0;
            while (1) {
                $length = strlen($output) + strlen($words[$i]);
                if ($length > $maxchar) {
                    break;
                } else {
                    $output .= " " . $words[$i];
                    ++$i;
                }
            }
            $output .= $end;
        } else {
            $output = $text;
        }
        return $output;
    }

    public function get_count_user($users_type_id = "", $status = "", $from_date = "", $to_date = "") {
        $this->CI->db->from('`tbl_users`');
        if ($users_type_id != "") {
            if ($users_type_id == '1') {
                $this->CI->db->where("(  `users_type_id` = '" . $users_type_id . "' )");
            } else {
                $this->CI->db->where("(  `users_type_id` = '" . $users_type_id . "' OR `users_type_id` = '0' )");
            }
        }
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_users`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_users`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_users`.`date_added` <=", $toDate);
            }
        }
        if ($status != "") {
            $this->CI->db->where('`status`', $status);
        }
        $this->CI->db->where('`groups_id`', '3');
        return $this->CI->db->count_all_results();
    }

    public function get_count_enquiry($status = "", $from_date = "", $to_date = "") {
        $this->CI->db->from('`tbl_enquiry`');
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_enquiry`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_enquiry`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_enquiry`.`date_added` <=", $toDate);
            }
        }
        if ($status != "") {
            $this->CI->db->where('`status`', $status);
        }
        return $this->CI->db->count_all_results();
    }

    public function get_count_requirement($status = "", $from_date = "", $to_date = "") {
        $this->CI->db->from('`tbl_requirement`');
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_requirement`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_requirement`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_requirement`.`date_added` <=", $toDate);
            }
        }
        if ($status != "") {
            $this->CI->db->where('`status`', $status);
        }
        return $this->CI->db->count_all_results();
    }

    public function get_count_downloaded($from_date = "", $to_date = "") {
        $this->CI->db->from('`tbl_requirement`');
        $this->CI->db->join('`tbl_requirement_to_users`', '`tbl_requirement`.`id` = `tbl_requirement_to_users`.`requirement_id`');
        //$this->CI->db->where('`tbl_requirement`.`status`','1');
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_requirement`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_requirement`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_requirement`.`date_added` <=", $toDate);
            }
        }
        //$this->CI->db->group_by('`tbl_requirement_to_users`.`users_id`');
        $result = $this->CI->db->get()->result();
        return count($result);
        //return $this->CI->db->count_all_results();
    }

    public function get_count_packages($status = "", $from_date = "", $to_date = "") {
        $this->CI->db->from('`tbl_packages`');
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_packages`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_packages`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_packages`.`date_added` <=", $toDate);
            }
        }
        if ($status != "") {
            $this->CI->db->where('`status`', $status);
        }
        return $this->CI->db->count_all_results();
    }

    public function get_count_bundle_packages($status = "", $from_date = "", $to_date = "") {
        $this->CI->db->from('`tbl_package_group`');
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_package_group`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_package_group`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_package_group`.`date_added` <=", $toDate);
            }
        }
        if ($status != "") {
            $this->CI->db->where('`status`', $status);
        }
        return $this->CI->db->count_all_results();
    }

    public function get_count_user_packages($bundle_id = "", $status = "", $from_date = "", $to_date = "") {
        if ($bundle_id != '' && $bundle_id == '8') {
            $this->CI->db->from('`tbl_users`');
            //$this->CI->db->join('`tbl_users_package`','`tbl_users_package`.`users_id` = `tbl_users`.`id`','left');
            if (!empty($from_date) || !empty($to_date)) {
                $fromDate = $from_date . ' 00:00:00';
                $toDate = $to_date . ' 23:59:59';
                if (!empty($from_date) && !empty($to_date)) {
                    $this->CI->db->where("(`tbl_users`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
                } else if (!empty($from_date)) {
                    $this->CI->db->where("`tbl_users`.`date_added` >=", $fromDate);
                } else if (!empty($to_date)) {
                    $this->CI->db->where("`tbl_users`.`date_added` <=", $toDate);
                }
            }
            $this->CI->db->where('`tbl_users`.`groups_id`', '3');
            if ($status != "") {
                $this->CI->db->where('`tbl_users`.`status`', $status);
            }
            $this->CI->db->where("(`tbl_users`.`users_type_id` = '2' OR `tbl_users`.`users_type_id` = '0')");
            //$condition = "( select tbl_users_package.users_id from tbl_users_package where ( tbl_users_package.bundle_id <> 8 and tbl_users_package.bundle_id <>0 ) )";
            //$this->CI->db->where("( tbl_users.id not in ".$condition."  )");
            //$this->CI->db->where("( `tbl_users_package`.`users_id` IS NULL OR (`tbl_users_package`.`bundle_id` = '8' ) or  )");
            $this->CI->db->where("( tbl_users.id not in ( SELECT users_id FROM tbl_users_package WHERE bundle_id <>0) )", NULL, FALSE);
            $result = $this->CI->db->get()->result();
            //echo $this->CI->db->last_query();
            return count($result);
        } else {
            /*
              $query = "SELECT count(*) as NumRows from (SELECT tbl_users_package.users_id FROM `tbl_users_package` LEFT JOIN `tbl_users` ON `tbl_users_package`.`users_id` = `tbl_users`.`id` WHERE `tbl_users_package`.`bundle_id` = '".$bundle_id."' AND `tbl_users`.`status` = '".$status."' GROUP BY `tbl_users_package`.`users_id` ) as newTable";
              return $this->CI->db->query($query)->row()->NumRows;
             */
            $this->CI->db->from('`tbl_users_package`');
            $this->CI->db->join('`tbl_users`', '`tbl_users_package`.`users_id` = `tbl_users`.`id`', 'left');
            if ($bundle_id != "") {
                $this->CI->db->where('`tbl_users_package`.`bundle_id`', $bundle_id);
            }
            if (!empty($from_date) || !empty($to_date)) {
                $fromDate = $from_date . ' 00:00:00';
                $toDate = $to_date . ' 23:59:59';
                if (!empty($from_date) && !empty($to_date)) {
                    $this->CI->db->where("(`tbl_users`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
                } else if (!empty($from_date)) {
                    $this->CI->db->where("`tbl_users`.`date_added` >=", $fromDate);
                } else if (!empty($to_date)) {
                    $this->CI->db->where("`tbl_users`.`date_added` <=", $toDate);
                }
            }
            $this->CI->db->where("(`tbl_users`.`users_type_id` = '2' OR `tbl_users`.`users_type_id` = '0')");
            if ($status != "") {
                $this->CI->db->where('`tbl_users`.`status`', $status);
            }
            $this->CI->db->group_by('`tbl_users_package`.`users_id`');
            $result = $this->CI->db->get()->result();
            //$count = $this->CI->db->count_all('`tbl_users_package`');
            //echo $this->CI->db->last_query();
            return count($result);
        }
    }

    public function get_count_user_packages_31aug2015($bundle_id = "", $status = "", $from_date = "", $to_date = "") {
        /*
          $query = "SELECT count(*) as NumRows from (SELECT tbl_users_package.users_id FROM `tbl_users_package` LEFT JOIN `tbl_users` ON `tbl_users_package`.`users_id` = `tbl_users`.`id` WHERE `tbl_users_package`.`bundle_id` = '".$bundle_id."' AND `tbl_users`.`status` = '".$status."' GROUP BY `tbl_users_package`.`users_id` ) as newTable";
          return $this->CI->db->query($query)->row()->NumRows;
         */
        $this->CI->db->from('`tbl_users_package`');
        $this->CI->db->join('`tbl_users`', '`tbl_users_package`.`users_id` = `tbl_users`.`id`', 'left');
        if ($bundle_id != "") {
            $this->CI->db->where('`tbl_users_package`.`bundle_id`', $bundle_id);
        }
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_users`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_users`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_users`.`date_added` <=", $toDate);
            }
        }
        if ($status != "") {
            $this->CI->db->where('`tbl_users`.`status`', $status);
        }
        $this->CI->db->group_by('`tbl_users_package`.`users_id`');
        $result = $this->CI->db->get()->result();
        //$count = $this->CI->db->count_all('`tbl_users_package`');
        //echo $this->CI->db->last_query();
        return count($result);
    }

    function time_passed($timestamp) {

        $timestamp = (int) $timestamp;
        $current_time = time();
        $diff = $current_time - $timestamp;

        //intervals in seconds
        $intervals = array('year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60);

        //now we just find the difference
        if ($timestamp == 0) {
            return false;
        }
        if ($diff == 0) {
            return 'just now';
        }

        if ($diff < 60) {
            return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
        }

        if ($diff >= 60 && $diff < $intervals['hour']) {
            $diff = floor($diff / $intervals['minute']);
            return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
        }

        if ($diff >= $intervals['hour'] && $diff < $intervals['day']) {
            $diff = floor($diff / $intervals['hour']);
            return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
        }

        if ($diff >= $intervals['day'] && $diff < $intervals['week']) {
            $diff = floor($diff / $intervals['day']);
            return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
        }

        if ($diff >= $intervals['week'] && $diff < $intervals['month']) {
            $diff = floor($diff / $intervals['week']);
            return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
        }

        if ($diff >= $intervals['month'] && $diff < $intervals['year']) {
            $diff = floor($diff / $intervals['month']);
            return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
        }

        if ($diff >= $intervals['year']) {
            $diff = floor($diff / $intervals['year']);
            return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
        }
    }

    public function get_count_package_orders($bundle_id = "", $status = "", $from_date = "", $to_date = "") {
        $this->CI->db->from('`tbl_order_history`');
        //$this->CI->db->join('`tbl_users`','`tbl_users_package`.`users_id` = `tbl_users`.`id`','left');
        if ($bundle_id != "") {
            $this->CI->db->where('`tbl_order_history`.`bundle_id`', $bundle_id);
        }
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_order_history`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_order_history`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_order_history`.`date_added` <=", $toDate);
            }
        }
        //$this->CI->db->where("(`tbl_users`.`users_type_id` = '2' OR `tbl_users`.`users_type_id` = '0')");
        if ($status != "") {
            //$this->CI->db->where('`tbl_order_history`.`status`',$status);
        }
        //$this->CI->db->order_by('`tbl_order_history`.`date_added`','DESC');
        $result = $this->CI->db->get()->result();
        //$count = $this->CI->db->count_all('`tbl_users_package`');
        //echo $this->CI->db->last_query();
        return count($result);
    }

    public function get_count_package_orders_amount($bundle_id = "", $status = "", $from_date = "", $to_date = "") {
        $this->CI->db->select_sum('total_price');
        $this->CI->db->from('`tbl_order_history`');
        if ($bundle_id != "") {
            $this->CI->db->where('`tbl_order_history`.`bundle_id`', $bundle_id);
        }
        if (!empty($from_date) || !empty($to_date)) {
            $fromDate = $from_date . ' 00:00:00';
            $toDate = $to_date . ' 23:59:59';
            if (!empty($from_date) && !empty($to_date)) {
                $this->CI->db->where("(`tbl_order_history`.`date_added` BETWEEN '" . $fromDate . "' AND '" . $toDate . "')");
            } else if (!empty($from_date)) {
                $this->CI->db->where("`tbl_order_history`.`date_added` >=", $fromDate);
            } else if (!empty($to_date)) {
                $this->CI->db->where("`tbl_order_history`.`date_added` <=", $toDate);
            }
        }
        //$this->CI->db->where("(`tbl_users`.`users_type_id` = '2' OR `tbl_users`.`users_type_id` = '0')");
        if ($status != "") {
            //$this->CI->db->where('`tbl_order_history`.`status`',$status);
        }
        //$this->CI->db->order_by('`tbl_order_history`.`date_added`','DESC');
        $count = $this->CI->db->get()->row()->total_price;
        return $count;
    }

    public function cropSelectedImageArea($filename, $x1, $y1, $x2, $y2, $w, $h) {
        $imgProperty = getimagesize($filename);
        $imageType = $imgProperty['mime'];

        switch ($imageType) {
            case "image/gif":
                $image = imagecreatefromgif($filename);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $image = imagecreatefromjpeg($filename);
                break;
            case "image/png":
            case "image/x-png":
                $image = imagecreatefrompng($filename);
                break;
        }

        $resized_width = ((int) $x2) - ((int) $x1);
        $resized_height = ((int) $y2) - ((int) $y1);

        $resized_image = imagecreatetruecolor($resized_width, $resized_height);
        if ($imageType == 'image/gif' || $imageType == 'image/png') {
            imagecolortransparent($resized_image, imagecolorallocatealpha($resized_image, 0, 0, 0, 127));
        }
        imagealphablending($resized_image, false);
        imagesavealpha($resized_image, true);
        imagecopyresampled($resized_image, $image, 0, 0, (int) $x1, (int) $y1, (int) $resized_width, (int) $resized_height, (int) $w, (int) $h);

        switch ($imageType) {
            case "image/gif":
                imagegif($resized_image, $filename);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($resized_image, $filename);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($resized_image, $filename);
                break;
        }
        chmod($filename, 0777);
        return $filename;
    }

    function getRatingVal($rating_id = "") {
        return $this->rating_arr[$rating_id];
    }
    
    function get_admin_rating_arr(){
        return $this->rating_arr;
    }
}
##end of class
?>