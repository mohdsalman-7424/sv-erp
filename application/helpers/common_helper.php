<?php

//========Helper Function========//
/*********Start Resize image 100x100 function **********************/
 function make_thumb_100($image_path, $thumb_path, $image_name) {

        // pr($image_path);
        // pr($thumb_path);
        // pr($image_name);die;
        if (!is_dir($thumb_path)) {
            mkdir($thumb_path, 0777, TRUE);
            chmod($thumb_path, 0777);
        }

        $source_image = $image_path;
        $new_image = $thumb_path . $image_name;

        $CI =& get_instance();
        $CI->load->library('image_lib');


        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['new_image'] = $new_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 0;
        $config['height'] = 100;
        // pr($config);die;

        $CI->image_lib->initialize($config);

        if (!$CI->image_lib->resize()) {
            echo $CI->image_lib->display_errors();
        }

        //echo $thumb_width."--".$thumb_height;
        //echo $image_path."<br>";
        //echo $new_image."<br>";
        //exit;
    }
/******************END FUNCTION********************/
/*********Start Resize image 250x250 function **********************/
    function make_thumb_250($image_path, $thumb_path, $image_name) {

        // pr($image_path);
        // pr($thumb_path);
        // pr($image_name);die;
        if (!is_dir($thumb_path)) {
            mkdir($thumb_path, 0777, TRUE);
            chmod($thumb_path, 0777);
        }

        $source_image = $image_path;
        $new_image = $thumb_path . $image_name;

        $CI =& get_instance();
        $CI->load->library('image_lib');


        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['new_image'] = $new_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 0;
        $config['height'] = 250;
        // pr($config);die;

        $CI->image_lib->initialize($config);

        if (!$CI->image_lib->resize()) {
            echo $CI->image_lib->display_errors();
        }

        //echo $thumb_width."--".$thumb_height;
        //echo $image_path."<br>";
        //echo $new_image."<br>";
        //exit;
    }
/*********END FUNCTION**********************************************/

function get_gst_tax($unit_price1, $product_weight_id) {
    $CI =& get_instance();
    if ($CI->dbsettings->Tax_class == 'on') {
        $CI->db->select('product_price, tax_class');
        $CI->db->where('id', $product_weight_id);
        $query = $CI->db->get('tbl_product_price');
        $gsttax = $query->result();
        $CI->db->select('tax, status');
        $CI->db->where('status', 'Active');
        $CI->db->where('id', $gsttax[0]->tax_class);
        $queryTax = $CI->db->get('tbl_tax');
        $taxpercent  = $queryTax->result();

        // $pprice = number_format($gsttax[0]->product_price, 2);
        $pprice = number_format($unit_price1, 2);
        $taxclass = number_format($taxpercent[0]->tax);
        $taxprice = $pprice - ($pprice * (100 / (100 + $taxclass)));

        // echo number_format((float)$taxprice, 2, '.', '');die;
        // pr($taxprice);die;
        return number_format((float)$taxprice, 2, '.', '');
    }
}

/*********Start Resize image 500x500 function **********************/
    function make_thumb_500($image_path, $thumb_path, $image_name) {


        if (!is_dir($thumb_path)) {
            mkdir($thumb_path, 0777, TRUE);
            chmod($thumb_path, 0777);
        }

        $source_image = $image_path;
        $new_image = $thumb_path . $image_name;

        $CI =& get_instance();
        $CI->load->library('image_lib');


        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['new_image'] = $new_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 0;
        $config['height'] = 500;
        // pr($config);die;

        $CI->image_lib->initialize($config);

        if (!$CI->image_lib->resize()) {
            echo $CI->image_lib->display_errors();
        }

        //echo $thumb_width."--".$thumb_height;
        //echo $image_path."<br>";
        //echo $new_image."<br>";
        //exit;
    }
/**
    *   create function for compress Images
    *   created by Sumit
    *   created date  09/02/2018
    *
    */
    if (!function_exists('compress_images'))
    {
        function compress_images($source, $destination, $quality='50')
        {
            if($source && $destination)
            {
                $CI = &get_instance();
                $info = getimagesize($source);
                if ($info['mime'] == 'image/jpeg')
                    $image = imagecreatefromjpeg($source);

                elseif ($info['mime'] == 'image/gif')
                    $image = imagecreatefromgif($source);

                elseif ($info['mime'] == 'image/png')
                    $image = imagecreatefrompng($source);

                imagejpeg($image, $destination, $quality);

                return $destination;

            }
        }
    }

    if (!function_exists('compress_images2'))
    {
        function compress_images2($source, $destination, $quality='50',$destination3)
        {
            if($source && $destination)
            {
                $folderName = './assets/uploads/product/compress/';
                if(!is_dir($folderName))
                {
                    mkdir($folderName,0777, true);
                }
                $folderName = './assets/uploads/category/compress/';
                if(!is_dir($folderName))
                {
                    mkdir($folderName,0777, true);
                }
                $CI = &get_instance();
                $w=150;
                $h=150;
                list($width, $height) = getimagesize($source);
                $r = $width / $height;
                if ($w/$h > $r) {
                    $newwidth = $h*$r;
                    $newheight = $h;
                } else {
                    $newheight = $w/$r;
                    $newwidth = $w;
                }
                $info = getimagesize($source);
                if ($info['mime'] == 'image/jpeg')
                    $image = imagecreatefromjpeg($source);

                elseif ($info['mime'] == 'image/gif')
                    $image = imagecreatefromgif($source);

                elseif ($info['mime'] == 'image/png')
                    $image = imagecreatefrompng($source);

                $dst = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresampled($dst, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagepng($dst, $destination3);

                $info = getimagesize($destination3);
                if ($info['mime'] == 'image/jpeg')
                    $image = imagecreatefromjpeg($destination3);

                elseif ($info['mime'] == 'image/gif')
                    $image = imagecreatefromgif($destination3);

                elseif ($info['mime'] == 'image/png')
                    $image = imagecreatefrompng($destination3);

                imagejpeg($image, $destination, $quality);

                return $destination;

            }
        }
    }

    if (!function_exists('compress_images3'))
    {
        function compress_images3($imagess)
        {
            $source='./assets/uploads/product/'.$imagess;
            $destination='./assets/uploads/product/compress/compress_'.$imagess;
            $quality='50';
            $destination3='./assets/uploads/product/new_compress_'.$imagess;
            if(file_exists($destination))
            {
                return base_url().'assets/uploads/product/compress/compress_'.$imagess;
            }
            else
            {

                if($imagess && $destination && file_exists($source))
                {
                    $folderName = './assets/uploads/product/compress/';
                    if(!is_dir($folderName))
                    {
                        mkdir($folderName,0777, true);
                    }
                    $folderName = './assets/uploads/category/compress/';
                    if(!is_dir($folderName))
                    {
                        mkdir($folderName,0777, true);
                    }
                    $CI = &get_instance();
                    $w=150;
                    $h=150;
                    list($width, $height) = getimagesize($source);
                    $r = $width / $height;
                    if ($w/$h > $r) {
                        $newwidth = $h*$r;
                        $newheight = $h;
                    } else {
                        $newheight = $w/$r;
                        $newwidth = $w;
                    }
                    $info = getimagesize($source);
                    if ($info['mime'] == 'image/jpeg')
                        $image = imagecreatefromjpeg($source);

                    elseif ($info['mime'] == 'image/gif')
                        $image = imagecreatefromgif($source);

                    elseif ($info['mime'] == 'image/png')
                        $image = imagecreatefrompng($source);

                    $dst = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresampled($dst, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagepng($dst, $destination3);

                    $info = getimagesize($destination3);
                    if ($info['mime'] == 'image/jpeg')
                        $image = imagecreatefromjpeg($destination3);

                    elseif ($info['mime'] == 'image/gif')
                        $image = imagecreatefromgif($destination3);

                    elseif ($info['mime'] == 'image/png')
                        $image = imagecreatefrompng($destination3);

                    imagejpeg($image, $destination, $quality);
                    if(file_exists($destination))
                    {
                        return base_url().'assets/uploads/product/compress/compress_'.$imagess;
                    }
                    else
                    {
                        return false;
                    }
                    //return base_url().'assets/uploads/product/compress/compress_'.$imagess;

                }
                else
                {
                    return false;
                }
            }
        }
    }

//=======Helper Function=========//
function getchildcategories($id = "") {
    $CI = & get_instance();
    $where = "";
    if ($id != "") {
        $where .= " AND `tbl_categories`.`parent_id` = '" . $id . "'";
    }
    $where .= "order by  `tbl_categories`.`sort_order` ASC";
    $sql = "select `tbl_categories`.* from `tbl_categories` where `tbl_categories`.`status` = 'Active' " . $where . "";
    $query = $CI->db->query($sql);
    $return_arry = $query->result();
    return $return_arry;
}

function getProductNameByVariantId($id) {
    $CI = & get_instance();
    $sql = "SELECT p1.product_name from tbl_product as p1 JOIN tbl_product_price as p2 on p1.product_id=p2.product_id WHERE p2.id = ".$id;
    if(!empty($id))
    {
        $query = $CI->db->query($sql);
        return $query->row()->product_name;
    }
    else
    {
        return "";
    }

}


function getIdByUrllink($url = "") {
    $CI = & get_instance();

    if($CI->cache->file->get('category_banner_'.$url))
    {
        return $CI->cache->file->get('category_banner_'.$url);
    }
    $where  = "";
    if ($url != "") {
        $where .= " where `tbl_categories`.`url_name` = '" . $url . "'";
    }
    $sql    = "SELECT id,name,parent_id,url_name,category_banner,web_landing_page,web_landing_page from `tbl_categories` " . $where . " limit 1";
    $query  = $CI->db->query($sql);
    //echo $CI->db->last_query(); die;
    $data   = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        $CI->cache->file->save('category_banner_'.$url,$data,CACHE_EXPIRE);
    }
    return $data;
}

function getDivisionBySupplierID($supplier_id) {
    $CI = & get_instance();

    $divisions = $CI->db->get_where('tbl_seller_division', ['store_id'=>$supplier_id])->row();
    if(empty($divisions)){
        return false;
    }

    $all_category = explode(",", $divisions->division_cats);
    $CI->db->select('tbl_categories.*');
    $CI->db->where_in("`tbl_categories`.`id`", $all_category);
    $query =  $CI->db->get('tbl_categories');
    // pr( $query->result());
    // $where  = "";
    // if ($url != "") {
    //     $where .= " where `tbl_categories`.`url_name` = '" . $url . "'";
    // }
    // $sql    = "SELECT id,name,parent_id,url_name,category_banner,web_landing_page,web_landing_page from `tbl_categories` " . $where . " limit 1";
    // $query  = $CI->db->query($sql);
    //echo $CI->db->last_query(); die;
    $data   = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return ['data'=>$data, 'divisions'=>$divisions];
}

function getCategoryById($parent_id = "") {
    $CI = & get_instance();
    #Check if cache file is exist or not
    if($CI->cache->file->get('subcategory_listing_'.$parent_id))
    {
        return $CI->cache->file->get('subcategory_listing_'.$parent_id);
    }
    #Check if cache file is exist or not

    $CI->db->select('id, name, url_name, category_banner,web_landing_page,app_landing_page,web_menu_bg_image,category_image_web ,category_menu_banner,android_ios_image');
    if (is_numeric($parent_id)) {
        $CI->db->where("`parent_id`",$parent_id);
    }
    $CI->db->where("`status`","Active");
    $CI->db->order_by("sort_order");
    $result = $CI->db->get('tbl_categories')->result();

    #Save cache file
    $CI->cache->file->save('subcategory_listing_'.$parent_id,$result,CACHE_EXPIRE);
    #Save cache file
    // echo $CI->db->last_query();
    return $result;
}

function getCategoryById_filter($parent_id = "") {
    $CI = & get_instance();
    $where = "";
    if (is_numeric($parent_id)) {
        $where .= " AND `tbl_categories`.`parent_id` = '" . $parent_id . "'";
    }
    $sql = "select id,name,url_name,category_banner from `tbl_categories` where `tbl_categories`.`status` = 'Active' " . $where . " order by name ASC limit 5";
    $query = $CI->db->query($sql);
    /* $data ="";
      if ($query->num_rows() > 0) {
      $data = $query->result();
      } */
    return $query->result();
    ;
}

function getCategory($parent_id = "", $id = "", $no_parent = "", $featured = "", $limit = "", $url = "", $header_menu_limit = "", $menu_show = "", $header_menu = "", $footer_menu = "") {
    $CI = & get_instance();
    $where = "";
    if (is_numeric($parent_id)) {
        $where .= " AND `tbl_categories`.`parent_id` = '" . $parent_id . "'";
    }

    if (is_numeric($no_parent)) {
        $where .= " AND `tbl_categories`.`parent_id` != '" . $parent_id . "'";
    }

    if ($id != "") {
        $where .= " AND `tbl_categories`.`id` = '" . $id . "'";
    }
    if ($url != "") {
        $where .= " AND `tbl_categories`.`url_name` = '" . $url . "'";
    }

    if ($featured != "") {
        $where .= " AND `tbl_categories`.`featured` = '" . $featured . "'";
    }
    if ($menu_show != "") {
        $where .= " AND `tbl_categories`.`menu_show` = '" . $menu_show . "'";
    }
    if ($header_menu != "") {
        $where .= " AND `tbl_categories`.`header_menu` = '" . $header_menu . "'";
    }
    if ($footer_menu != "") {
        $where .= " AND `tbl_categories`.`footer_menu` = '" . $footer_menu . "'";
    }
    $where .= "and name!='Special Offers' order by  `tbl_categories`.`sort_order` ASC";

    if ($limit != "") {
        $where .= " limit 0, " . $limit . "";
    }
    $sql = "select id,name,url_name,category_menu_banner,category_banner,android_ios_image,parent_id,status,category_description,page_title,page_description from `tbl_categories` where `tbl_categories`.`status` = 'Active' " . $where . "";

    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getSubCategory($parent_id = "", $id = "", $no_parent = "", $featured = "", $limit = "") {
    $CI = & get_instance();
    $where = "";
    if (is_numeric($parent_id)) {
        $where .= " AND `tbl_categories`.`parent_id`= '" . $parent_id . "'";
    }

    if (is_numeric($no_parent)) {
        $where .= " AND `tbl_categories`.`parent_id` != '" . $parent_id . "'";
    }

    if ($id != "") {
        $where .= " AND `tbl_categories`.`id` = '" . $id . "'";
    }

    if ($featured != "") {
        $where .= " AND `tbl_categories`.`featured` = '" . $featured . "'";
    }

    $where .= "order by  `tbl_categories`.`name` asc";

    if ($limit != "") {
        $where .= " limit 0, " . $limit . "";
    }

    $sql = "select id,name,url_name,category_menu_banner,category_banner,android_ios_image,parent_id,status,category_description,page_title,page_description from `tbl_categories` where `tbl_categories`.`status` = 'Active' " . $where . "";

    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function get_store_name($store_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($store_id != "") {
        $where .= "AND store_id = '" . $store_id . "'";
    }
    $sql = "select * from tbl_store where store_status='1' " . $where . " order by store_id desc";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function get_store_name_without_status($store_id = "") {
    $CI = & get_instance();
    if (empty($store_id)) {
        return false;
    }
    $sql = "SELECT * FROM tbl_store WHERE store_id=$store_id ORDER BY store_id DESC";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}



function getOceanCategories() {
    $CI = & get_instance();
    $where .= " AND tbl_categories.feature_show = '4'";
    $sql = "select name, ocean_category,url_name from  tbl_categories where 1 " . $where . " order by `sort_order` ASC limit 4";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getCountryName($country_name = "") {
    $CI = & get_instance();
    $where = "";
    if ($country_name != "") {
        $where .= "AND id = '" . $country_name . "'";
    }
    $sql = "select * from  tbl_country where 1 " . $where . " order by `id` ASC";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getBrandName($brand_name = "") {
    $CI = & get_instance();
    $where = "";
    if ($brand_name != "") {
        $where .= "AND brand_id = '" . $brand_name . "'";
    }
    $sql = "select brand_id,brand_name,url_name,image,brand_type,order_no,category_id from  tbl_brand where 1 " . $where . " order by `brand_id` desc";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getSkuCode() {
    $CI = & get_instance();
    $sql = "select * from  tbl_sku_code where 1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function gePriceCode() {
    $CI = & get_instance();
    $sql = "select id,value_1,value_2 from  tbl_price_code where 1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getPriceList($porduct_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($porduct_id != "") {
        $where .= "AND product_id = '" . $porduct_id . "'";
    }
    $sql = "select * from  tbl_product_price where 1 " . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getProductCategory($product_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " AND `interface_procategories`.`product_id` = '" . $product_id . "'";
    }
    $sql = "select interface_procategories.sub_category_id  from `tbl_product` left join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id` where 1 " . $where;

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {

        $data = $query->result();
    }

    return $data;
}

function getProductSubCategory($product_id = ""){
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " AND `interface_procategories`.`product_id` = '" . $product_id . "'";
    }
    $sql = "select interface_procategories.sub_category_id  from `tbl_product` left join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id` where 1 " . $where;

    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

/* function getAllProductPricelist($product_id ="") {
  $CI = & get_instance();
  $where = "";
  if ($product_id != "") {
  $where .= "AND `tbl_product_price`.`product_id` = '" . $product_id . "'";
  }
  $where .=" AND `tbl_product_price`.`product_price`!=0 ";
  $where .=" AND `tbl_product_price`.`unit_status`='Enable'";
  $sql = "select * from  tbl_product_price where 1=1 " . $where . " order by product_price ASC";
  $query = $CI->db->query($sql);
  $data = "";
  if ($query->num_rows() > 0) {
  $data = $query->result();
  }
  return $data;
  } */

function getAllProductPricelist($product_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= "AND p.product_id = '" . $product_id . "'";
    }

    $sql = "SELECT p.*,inv.qnty_type,inv.qnty from tbl_product_price as p left join (SELECT qnty_type,qnty,product_id,priceid,store_id FROM tbl_inventory where store_id='11' ) as inv on  p.id=inv.priceid where p.product_price!=0 AND p.unit_status='Enable' " . $where . "  order by p.product_price ASC";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getAllProductImagelist($product_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " AND `tbl_interface_product_images`.`product_id` = '" . $product_id . "'";
    }
    $sql = "select * from  tbl_interface_product_images  where 1=1 " . $where . "";

    $query = $CI->db->query($sql);

    $data = "";

    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    } else {
        return 0;
    }
}

function getUserProfile($user_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($user_id != "") {
        $where .= " AND `tbl_users`.`id` = '" . $user_id . "'";
    }
    $sql = "select * from  tbl_users where 1 " . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getProductBrandName($product_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= "AND product_id = '" . $product_id . "'";
    }
    $sql = "select * from  tbl_interface_manufactured where 1 " . $where . " group by `brand_name` ASC ";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function get_Stockstore_name($product_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= "AND product_id = '" . $product_id . "'";
    }
    $sql = "select * from tbl_inventory where 1=1 " . $where . " group by store_id order by store_id desc";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function get_Stockbypriceid($price_id = "", $store_id = "", $pid = "") {
    $CI = & get_instance();
    $where = "";
    if ($price_id != "") {
        $where .= "AND priceid = '" . $price_id . "' AND store_id = '" . $store_id . "' AND product_id='" . $pid . "'";
    }
    $sql = "select * from tbl_inventory where 1=1 " . $where . " LIMIT 1";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function getCountProductCategory($product_subcategory = "", $keywords = '') {
    $CI = & get_instance();
    $sql = "select interface_procategories.product_id from interface_procategories join tbl_product on tbl_product.product_id = interface_procategories.product_id where interface_procategories.sub_category_id = '$product_subcategory' and tbl_product.product_status='Enable'and tbl_product.product_name like '%$keywords%' group by tbl_product.product_name";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function getCountBrandProduct($brand_id = "") {
    $CI = & get_instance();
    // $sql = "select count(tbl_interface_manufactured.product_id) as total_record from tbl_product where tbl_product.brand_name = '$brand_id'";
    $sql = "select count(tbl_interface_manufactured.product_id) as total_record from tbl_interface_manufactured join tbl_product on tbl_product.product_id = tbl_interface_manufactured.product_id where tbl_interface_manufactured.brand_name = '$brand_id'";
    $count = $CI->db->query($sql)->row()->total_record;
    return $count;
}

function getProductByPricesdd($id = NULL) {
    $CI = & get_instance();
    if (isset($id) && !empty($id)) {
        $sql = "SELECT tbl_product_price.*,tbl_product.product_status,tbl_product.weight_ids,tbl_product.product_name,tbl_product.product_nature,tbl_product.product_url,tbl_product.product_image,tbl_product.mb_express,tbl_product_gallery.image from `tbl_product_price` left join `tbl_product` on `tbl_product`.`product_id` = `tbl_product_price`.`product_id` left join `tbl_product_gallery` on `tbl_product_price`.`id` = `tbl_product_gallery`.`variant_id` where tbl_product_price.id = '" . $id . "' group by tbl_product.product_id";
    }
    else{

        $sql = "SELECT tbl_product_price.*,tbl_product.product_status,tbl_product.product_name,tbl_product.product_nature,tbl_product.product_url,tbl_product.product_image,tbl_product.mb_express,tbl_product_gallery.image from `tbl_product_price` left join `tbl_product` on `tbl_product`.`product_id` = `tbl_product_price`.`product_id` left join `tbl_product_gallery` on `tbl_product_price`.`id` = `tbl_product_gallery`.`variant_id` group by tbl_product.product_id";
    }

    $query = $CI->db->query($sql);
    // echo $CI->db->last_query()."<br>";
    $data = $query->result();
    return $data;
}

function getParentCategory($cat_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($cat_id != "") {
        $where .= "AND tbl_categories.parent_id = '" . $cat_id . "'";
    }
    $sql = "select * from  tbl_categories where 1 " . $where . " order by `id` desc";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function get_Store_Namess($store_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($store_id != "") {
        $where .= "AND tbl_store.store_id = '" . $store_id . "'";
    }
    $sql = "select store_id,google_coordinate,store_name,store_city,max_range,coords from  tbl_store where store_status=1 " . $where . " order by `store_id` desc";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function getAllProduct($category_id = "") {
    echo $category_id;
    $CI = & get_instance();
    $where = "";
    if ($category_id != "") {
        $where .= "where interface_procategories.sub_category_id IN ($category_id)";
    }
    if ($category_id != "") {
        $where .= "AND tbl_product.product_status='Enable'";
    }
    //echo $sql = "select product_id,product_name,product_code from  tbl_product where product_status='Enable' order by `product_id` desc";
    $sql = "select tbl_product.product_id,product_name,product_code from `tbl_product` inner join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id`" . $where . " ";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function getAllProducts() {
    $CI = & get_instance();
    //echo $sql = "select product_id,product_name,product_code from  tbl_product where product_status='Enable' order by `product_id` desc";
    $sql = "select tbl_product.product_id,product_name,product_code from `tbl_product` where product_status='Enable' order by `product_name` ASC";
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function userAddresslist($user_id) {
    $CI = & get_instance();
    if (isset($user_id) && !empty($user_id)) {
        $sql = "SELECT * FROM tbl_address WHERE uid=" . $user_id . " order by id DESC LIMIT 6";
        $query = $CI->db->query($sql);
        $data = $query->result();
        return $data;
    }
}

function getStateName($state_id) {
    $CI = & get_instance();
    if (isset($state_id) && !empty($state_id)) {
       $CI->db->select('name');
       $CI->db->where('id',$state_id);
       $state_data = $CI->db->get('tbl_states')->row();
       if(!empty($state_data)){
        return $state_data->name;
       }else{
        return false;
       }
    }
}

function userAddressbyid($addressid) {
    $CI = & get_instance();
    if (isset($addressid) && !empty($addressid)) {
        $query = $CI->db->select("a.*, s.name as state_name");
        $query = $CI->db->join("tbl_states AS s","s.id= a.state_id",'LEFT');
        $query = $CI->db->where("a.id", $addressid);
        return $CI->db->get('tbl_user_address AS a')->result();
    }
    else
    {
        return false;
    }
}

function AlluserAddressbyid($addressid) {
    $CI = & get_instance();
    if (isset($addressid) && !empty($addressid)) {
        $sql = "SELECT * FROM tbl_address WHERE uid=" . $addressid . " order by id desc";
        $query = $CI->db->query($sql);
        $data = $query->result();
        return $data;
    }
}

function AlluserOrderbyid($user_id) {
    $CI = & get_instance();
    if (isset($user_id) && !empty($user_id)) {
        $sql = "SELECT * FROM tbl_order WHERE uid=" . $user_id . " order by id desc";
        $query = $CI->db->query($sql);
        $data = $query->result();
        return $data;
    }
}

function generateRandomString($length = 7) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = 'MB';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getDiscountOnProduct($pid,$minunit=0,$price=1,$store=0,$user_id=0) {

    date_default_timezone_set('Asia/Kolkata');
    $CI = & get_instance();
    $data = [];
    $prev_disc_amt = 0;
    $disc_amt = 0;
    $date = date("Y-m-d H:i:s");

    $store =    isset($store)?$store:0;
    if($minunit==''|| empty($minunit)){
        $minunit=0;
    }
    
    if($minunit == 0 && $user_id == 0){

        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`)
        AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
        AND STATUS='Active' ";
  }else{
    $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND    FIND_IN_SET('".$store."',`store_id`)
        AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
        AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END)
        AND STATUS='Active' AND ".$minunit." >= minunit";

    }
    // echo $sql;die;
    $query = $CI->db->query($sql);
    if($query->num_rows() > 0){
        $all_discount_list = $query->result();
        // pr($all_discount_list);die;
        ###############for offer exclude starts###################
        // $is_excluded = null;
        // $CI->db->select('product_id, product_name, is_excluded');
        // $CI->db->where("FIND_IN_SET('" . $pid . "',`weight_ids`)!=",0);
        // if($price!=1){
        //   $CI->db->where("FIND_IN_SET('" . $price . "',`product_prices`)!=",0);
        // }
        // $query_excluded=$CI->db->get("tbl_product");
        // $is_excluded = $query_excluded->row();
        //pr($is_excluded);
        ###############for offer exclude ends###################
        //if(!empty($all_discount_list) && count($all_discount_list)>0){
        if(!empty($all_discount_list) && count($all_discount_list)>0){

            //////check offer redeem limit////
            foreach($all_discount_list as $discount){
                $check_redeem = chk_redeem_limit($pid, $user_id,$discount->id,'2',$discount->redeem_limit);
                if($check_redeem == 1){
                    if($discount->discount_type=='percentage'){
                        $prev_disc_amt = $disc_amt;
                        $disc_amt = ($price*$discount->discountamount)/100;

                    }else if($discount->discount_type=='flat'){
                        $prev_disc_amt = $disc_amt;
                        $disc_amt = $discount->discountamount;
                    }
                    // echo "prev_disc_amt=".$prev_disc_amt."<br>";
                    // echo "disc_amt=".$disc_amt."<br>";
                    if($prev_disc_amt < $disc_amt)
                    {
                        // echo "prev_disc_amt--------<br>";
                        $data[0] = $discount;
                        // if($is_excluded->is_excluded=='1'){
                        //     $data[0] = $discount;
                        // }
                    }
                }
            }
        }
    }

    if(!isset($data) || empty($data))
    {
        $data = FALSE;
    }
    return $data[0];
}

function getDiscountOnProductForListing($pid, $price=1, $store=0, $user_id=0) {
    date_default_timezone_set('Asia/Kolkata');
    $CI = & get_instance();
    $data = [];
    $prev_disc_amt = 0;
    $prev_disc_amt1 = 0;
    $disc_amt = 0;
    $date = date("Y-m-d H:i:s");
    $store =    isset($store)?$store:0;
    if( $user_id == 0){
        $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND FIND_IN_SET('".$store."',`store_id`)
        AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
        AND STATUS='Active' ";
    }
    else{
    $sql = "SELECT * FROM tbl_discount WHERE start_date <= '".$date."' AND `end_date` >= '".$date."' AND    FIND_IN_SET('".$store."',`store_id`)
        AND (CASE WHEN category_status = 2 THEN (FIND_IN_SET('".$pid."',`product`)) ELSE (product = NULL OR product='') END)
        AND (CASE WHEN applicable = 1 THEN (FIND_IN_SET('".$user_id."',`users`)) ELSE (users = NULL OR users='') END)
        AND STATUS='Active' AND minunit>=1";
    }
    $query = $CI->db->query($sql);
    // echo $CI->db->last_query();
    // pr($query->result());
    if($query->num_rows() > 0){
        $all_discount_list = $query->result();
        // pr($all_discount_list);die;
        ###############for offer exclude starts###################
        // $is_excluded = null;
        // $CI->db->select('product_id,product_name,is_excluded');
        // $CI->db->where("FIND_IN_SET('" . $pid . "',`weight_ids`)!=",0);
        // if($price!=1){
        //     $CI->db->where("FIND_IN_SET('" . $price . "',`product_prices`)!=",0);
        // }
        //pr($price);
        // $query_excluded=$CI->db->get("tbl_product");
        // $is_excluded = $query_excluded->row();
        if(!empty($all_discount_list) && count($all_discount_list)>0){
            foreach($all_discount_list as $discount){

                $check_redeem = chk_redeem_limit($pid, $user_id,$discount->id,'2',$discount->redeem_limit);
                if($check_redeem == 1){
                    if($discount->discount_type=='percentage'){
                        $prev_disc_amt1 = $prev_disc_amt;
                        $prev_disc_amt = $disc_amt;
                        $disc_amt = ($price*$discount->discountamount)/100;

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
                        //$data[0] = $discount;
                        // if($is_excluded->is_excluded=='1'){
                        //     $data[0] = $discount;
                        // }
                        $data[0] = $discount;
                    }
                    // echo "prev_disc_amt=> ".$prev_disc_amt."<br>";
                    // echo "disc_amt=> ".$disc_amt."<br>";
                }
            }
        }
    }
    // pr($is_excluded);
    // pr($data);die;
    return $data;
}

function chk_redeem_limit($variant_id, $user_id, $offer_id, $offer_type, $redeem_limit){

    if(!$user_id)
    {
        return true;
    }
    else
    {
        $CI = &get_instance();
        $CI->db->select('torl.*, SUM(torl.purchaged_limit) as purchaged_limit');
        $CI->db->join('tbl_order ord', 'torl.order_id=ord.id', 'left');
        $CI->db->where_not_in('ord.order_status',array('Cancel','PAYMENT FAILED','WAITING PAYMENT CONFIRMATION'));
        $CI->db->where('torl.offer_type',$offer_type);
        $CI->db->where('torl.user_id',$user_id);
        if($variant_id!='')
        {
            $CI->db->where('torl.variant_id',$variant_id);
        }
        $CI->db->where('torl.offer_id',$offer_id);
        $CI->db->where('torl.status', 1);
        // $CI->db->where('DATE(torl.date)=',date('Y-m-d'));
        $CI->db->group_by('torl.offer_type');
        $query = $CI->db->get('tbl_offer_redeem_limit torl');

        if($query->num_rows() > 0){
            $data = $query->row();
            if($data->purchaged_limit < $redeem_limit){
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return true;
        }
    }

}
// function chk_redeem_limit($variant_id, $user_id, $offer_id, $offer_type, $redeem_limit){

//     $CI = &get_instance();
//     $CI->db->select('torl.*, SUM(torl.purchaged_limit) as purchaged_limit');
//     $CI->db->join('tbl_order ord', 'torl.order_id=ord.id', 'left');
//     $CI->db->where_not_in('ord.order_status',array('Cancel','PAYMENT FAILED','WAITING PAYMENT CONFIRMATION'));
//     $CI->db->where('torl.offer_type',$offer_type);
//     $CI->db->where('torl.user_id',$user_id);
//     if($variant_id!='')
//     {
//         $CI->db->where('torl.variant_id',$variant_id);
//     }
//     $CI->db->where('torl.offer_id',$offer_id);
//     $CI->db->where('torl.status',1);
//     $CI->db->where('DATE(torl.date)=',date('Y-m-d'));
//     $CI->db->group_by('torl.offer_type');
//     $query = $CI->db->get('tbl_offer_redeem_limit torl');
//     // echo $CI->db->last_query();die;
//     // $sql = "SELECT *,SUM(`purchaged_limit`) as purchaged_limit FROM tbl_offer_redeem_limit WHERE variant_id='".$variant_id."' AND user_id = '".$user_id."' AND offer_id ='".$offer_id."' AND offer_type = '".$offer_type."'";
//      //echo $CI->db->last_query();
//     //\\ pr($query->row());die;
//     // pr($query->num_rows());

//     #############for daily redeem limit check starts####################
//     //     $CI->db->select('*,DATE(date) as check_date');
//     //     $CI->db->where('offer_type',$offer_type);
//     //     $CI->db->where('user_id',$user_id);
//     //     if($variant_id!='')
//     //     {
//     //         $CI->db->where('variant_id',$variant_id);
//     //     }
//     //     $CI->db->where('offer_id',$offer_id);
//     //     $CI->db->where('status',1);
//     //    // $CI->db->group_by('offer_type');
//     //     $CI->db->order_by('id','DESC');
//     //     $query_redeem = $CI->db->get('tbl_offer_redeem_limit');



//     #############for daily redeem limit check starts####################



//     if($query->num_rows() > 0){
//         // echo "string";

//         $data = $query->row();
//         $purchaged_limit_count = $data->purchaged_limit;

//             // pr($data);
//             // pr($redeem_limit.'<br>');
//             // pr($purchaged_limit_count.'<br>'); die;

//         if($purchaged_limit_count < $redeem_limit){
//             return true;
//         }else{
//             return false;
//         }
//     }
//     else
//     {
//      return true;
//     }
// }

function chk_redeem_limit_combo($variant_id, $user_id, $offer_id, $offer_type, $redeem_limit){

    $CI = &get_instance();
    $CI->db->select('*, SUM(purchaged_limit) as purchaged_limit');
    $CI->db->where('offer_type',$offer_type);
    $CI->db->where('user_id',$user_id);
    if($variant_id!='')
    {
        $CI->db->where('variant_id',$variant_id);
    }
    $CI->db->where('offer_id',$offer_id);
    $CI->db->where('status', 1);
    $CI->db->group_by('offer_type');
    $query = $CI->db->get('tbl_offer_redeem_limit');
    if($query->num_rows() > 0){
        $data = $query->row();
        return ($redeem_limit - $data->purchaged_limit);
    }
    else
    {
        return $redeem_limit;
    }
}


function getShipingOnProduct($distance) {
    $CI = & get_instance();
    $data='';
    $sql = "SELECT * FROM tbl_shiping WHERE status='Active' order by id asc";
     $query = $CI->db->query($sql);
    if($query->num_rows() > 0){
          $data = $query->result();
    }
    return $data;
}

function checkcart($users_id) {
    $CI = & get_instance();
    $data = '';
    if ($users_id != '') {
        $sql = "SELECT * FROM tbl_activecart WHERE user_id =" . $users_id;
        $query = $CI->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
    }
    return $data;
}

function checkcartforitem($users_id, $weightid) {
    $CI = & get_instance();
    if ($users_id != '') {
        $sql = "SELECT * FROM tbl_activecart WHERE FIND_IN_SET('" . $weightid . "',`weight_id`) AND user_id=" . $users_id . " order by id DESC LIMIT 1";
        $query = $CI->db->query($sql);
        $data = $query->result();
        return $data;
    }
}

#check user temporary cart for android devices

function checkCartbymobileid($mobile_id) {
    $CI = & get_instance();
    if ($mobile_id != '') {
        $sql = "SELECT * FROM tbl_activecart WHERE mobile_id='" . $mobile_id . "' order by id DESC LIMIT 1";
        $query = $CI->db->query($sql);
        $data = $query->result();
        return $data;
    }
}

#check user temporary cart items for android devices

function checkCartitembymobileid($mobile_id, $weightid) {
    $CI = & get_instance();
    if ($mobile_id != '') {
        $sql = "SELECT * FROM tbl_activecart WHERE FIND_IN_SET('" . $weightid . "',`weight_id`) AND mobile_id='" . $mobile_id . "' order by id DESC LIMIT 1";
        $query = $CI->db->query($sql);
        //echo $CI->db->last_query();die();
        $data = $query->result();

        return $data;
    }
}

function getUsers($id = "", $groups_id = "", $email_address = "", $users_type = "", $status = "") {
    $CI = & get_instance();
    $where = "";
    if ($id != "") {
        $where .= "AND id = '" . $id . "'";
    }
    if ($groups_id != "") {
        $where .= "AND groups_id!= '" . $groups_id . "'";
    }

    if ($email_address != "") {
        $where .= "AND email_address = '" . $email_address . "'";
    }

    if ($status != "") {
        $where .= "AND status = '" . $status . "'";
    }
    $sql = "select * from `tbl_users` where 1 " . $where . " order by `id`";
    //echo $sql;
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function get_user($user_id = NULL)
{
    $data =  [];
    if(isset($user_id) && !empty($user_id))
    {
        $CI = & get_instance();
        $CI->db->select("id,username,status,delete_status,email_address,mobile,first_name,last_name,gender,user_dob");
        $CI->db->where('id', $user_id);
        $data  =   $CI->db->get("tbl_users")->row();
    }

    return $data;
}
#Get Order Details

function getOrderDetails($orders_id = "", $order_no = "", $users_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($orders_id != "") {
        $where .= " AND `tbl_order`.`id` = '" . $orders_id . "'";
    }
    if ($order_no != "") {
        $where .= " AND `tbl_order`.`order_number` = '" . $order_no . "'";
    }
    if ($users_id != "") {
        $where .= " AND `tbl_order`.`user_id` = '" . $users_id . "'";
    }
    $sql = "select tbl_order.*,tbl_address.* from `tbl_order` inner join `tbl_address` on `tbl_address`.`id` = `tbl_order`.`multiple_address_id` " . $where . " ";
    $query = $CI->db->query($sql);

    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function convert_number_to_words($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

function convert_number_to_words_old($number) {
    $CI = & get_instance();
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

#Check/Update User Cart when logged in

function checkusercart() {
    $CI = & get_instance();
    #Check user login status
    if ($CI->session->userdata('auth_user') != NULL && $CI->session->userdata('auth_user') != '') {
        $user_login = $CI->session->userdata('auth_user');
        if (isset($user_login) && !empty($user_login)) {
            $users_id = $user_login['users_id'];

            $checkcartinDB = checkcart($users_id);

            if ($checkcartinDB!='' && $checkcartinDB[0]->product_id == '') {
                setcookie('cart_items_cookie', '', time() + 2592000, "/");
            } else {
                //initialize empty cart items array
                $cart_items = array();
                $previous_items = array();

                #Get cart items details
                $pidByweight = '';
                $pid = '';
                $qnty = '';
                $saved_cart_items   =   array();
                if(@$_COOKIE['cart_items_cookie']!='' && @$_COOKIE['cart_items_cookie']!=NULL){
                    $cookie = $_COOKIE['cart_items_cookie'];
                    $cookie = stripslashes($cookie);
                    $saved_cart_items = json_decode($cookie, true);
                }
                $pid='';
                $pidByweight    =   '';
                $qnty           =   '';
                if(is_array($saved_cart_items) && count($saved_cart_items) > 0){
                    foreach ($saved_cart_items as $key => $value) {

                        $data = getProductByPricesdd($key);

                        foreach ($data as $d) {
                            $pid = $pid . $d->product_id . ",";
                            $pidByweight = $pidByweight . $key . ",";
                            $qnty = $qnty . $value . ",";
                        }
                    }
                }
                $store = $CI->session->userdata('storedate_user');
                $store_id = isset($store['store_id']) ? $store['store_id'] : '';

                $cookieweight = explode(',', $pidByweight);
                $cookieqnty = explode(',', $qnty);
                #Check cart exist in db
                $checkcart = checkcart($users_id);
                if($checkcart!='' && count($checkcart) > 0) {
                    #Fetch exisiting dbcart details
                    $cart_id = $checkcart[0]->id;
                    $dbcartitems = explode(',', $checkcart[0]->weight_id);
                    $dbcartqnty = explode(',', $checkcart[0]->qnty);
                    $dbcartcount = sizeof($dbcartitems) - 1;
                    $cookiecartcount = sizeof($cookieweight) - 1;
                    for ($i = 0; $i <= $dbcartcount; $i++) {
                        $cart_items[$dbcartitems[$i]] = $dbcartqnty[$i];
                        $previous_items[$dbcartitems[$i]] = $dbcartqnty[$i];
                        /* if($dbcartitems[$i]==$cookieweight[$i]){
                          $cart_items[$dbcartitems[$i]]=$dbcartqnty[$i];
                          }else{
                          if($dbcartitems[$i]!=''){
                          $cart_items[$dbcartitems[$i]]=$dbcartqnty[$i];
                          } */
                        /* if($cookieweight[$i]!=''){
                          $cart_items[$cookieweight[$i]]=$cookieqnty[$i];
                          }
                          } */
                    }
                    /* if($dbcartcount>=$cookiecartcount){
                      for($i=0;$i<=$dbcartcount;$i++){
                      if($dbcartitems[$i]==$cookieweight[$i]){
                      $cart_items[$cookieweight[$i]]=$cookieqnty[$i];
                      }else{
                      if($dbcartitems[$i]!=''){
                      $cart_items[$dbcartitems[$i]]=$dbcartqnty[$i];
                      }
                      if($cookieweight[$i]!=''){
                      $cart_items[$cookieweight[$i]]=$cookieqnty[$i];
                      }
                      }
                      }
                      }else{
                      for($i=0;$i<=$cookiecartcount;$i++){
                      if($dbcartitems[$i]==$cookieweight[$i]){
                      $cart_items[$cookieweight[$i]]=$cookieqnty[$i];
                      }else{
                      if($cookieweight[$i]!=''){
                      $cart_items[$cookieweight[$i]]=$cookieqnty[$i];
                      }
                      if($dbcartitems[$i]!=''){
                      $cart_items[$dbcartitems[$i]]=$dbcartqnty[$i];
                      }
                      }
                      }
                      } */

                    //print_r($cart_items);
                    $new_pid = '';
                    $new_pidByweight = '';
                    $new_qnty = '';
                    $new_cart_items = array();
                    if (count($cart_items) > 0) {
                        foreach ($cart_items as $key => $value) {
                            if ($key != '') {
                                $new_cart_items[$key] = $value;
                                $data = getProductByPricesdd($key);
                                foreach ($data as $d) {
                                    $new_pid = $new_pid . $d->product_id . ",";
                                    $new_pidByweight = $new_pidByweight . $key . ",";
                                    $new_qnty = $new_qnty . $value . ",";
                                }
                            }
                        }
                    }
                    $newdata = array('user_id' => $users_id,
                        'product_id' => $new_pid,
                        'weight_id' => $new_pidByweight,
                        'qnty' => $new_qnty,
                        'store_id' => $store_id,
                        'updatedat' => date('Y-m-d H:i:s'),
                        'addedfrom' => 'website',
                    );
                    $CI->db->where('id', $cart_id);
                    $CI->db->update('tbl_activecart', $newdata);
                    $json = json_encode($new_cart_items, true);
                    $pjson = json_encode($previous_items, true);
                    setcookie('cart_items_cookie', $json, time() + 2592000, "/");
                    $review = $CI->session->userdata('cart_review');
                    if ($review != 'yes') {
                        setcookie('prev_items_cookie', $pjson, time() + 2592000, "/");
                    }
                }
            }
        }
    } else {

    }
}

#Check Stock In Store by Weight and Store ID

function checkStockbystore($store_id = "", $weight_id = "") {
    $CI = & get_instance();
    $data = '';
    if ($store_id != '' && $weight_id != '') {
        $sql = "SELECT * FROM tbl_inventory WHERE priceid=" . $weight_id . " AND store_id=" . $store_id . " order by id DESC LIMIT 1";
        $query = $CI->db->query($sql);
        $data = $query->result();
        // return ($CI->db->last_query());
    }
    return $data;
}

#Update Stock In Store by Weight and Store ID

function updateStockbystore($store_id = "", $weight_id = "", $qty = "") {
    $CI = & get_instance();
    if ($store_id != '' && $weight_id != '' && $qty >= 0) {
        $sql = "UPDATE tbl_inventory SET qnty=" . $qty . " WHERE priceid=" . $weight_id . " AND store_id=" . $store_id . " LIMIT 1";
        $query = $CI->db->query($sql);
    }
}

#Check Promo Code

function getPromo($promocode,$store_id='',$user_id='') {
    $CI = & get_instance();
    date_default_timezone_set('Asia/Kolkata');
    if ($promocode != '') {
        $date = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM tbl_promocode WHERE status='1' AND promocode='" . $promocode . "' AND (start_date<='$date' AND end_date<='$date') order by id DESC LIMIT 1";
        //$sql = "SELECT * FROM tbl_promocode WHERE status='Active' AND NOW()>=`start_date` AND NOW()<=`end_date` AND promocode='" . $promocode . "' order by id DESC LIMIT 1";
        $query = $CI->db->query($sql);
        // $CI->db->last_query();
        $data = $query->result();
        return $data;
    }
}

function checkuserPromo($promocode, $user) {
    $CI = & get_instance();
    if ($promocode != '' && $user != '') {
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d H:i:s");
        //$sql = "SELECT * FROM tbl_promocode WHERE FIND_IN_SET('" . $user . "',`users`) AND status='Active' AND NOW()>=`start_date` AND NOW()<=`end_date` AND promocode='" . $promocode . "' order by id DESC LIMIT 1";
        $sql = "SELECT * FROM tbl_promocode WHERE FIND_IN_SET('" . $user . "',`users`) AND status='Active'  AND promocode='" . $promocode . "' AND (start_date<='" . $date . "' AND end_date<='" . $date . "') order by id DESC LIMIT 1";
        $query = $CI->db->query($sql);
        //$CI->db->last_query();
        $data = $query->result();
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}

#Calculate Shipping Charges

function shippingCharges($cart_subtotal) {
    $CI = & get_instance();
    $response = array();
    $mincartvalue = 0;
    $shipping_charges = 0;
    $shipping_amt = 0;
    $mincartvalue = '';
    $paymoney = $cart_subtotal;
    $shipping = $CI->session->userdata('storedate_user');
    $shipping_distance = $shipping['store_distance'];

    $shipping_details = getShipingOnProduct($shipping_distance);

    if ($shipping_details!='' && count($shipping_details) > 0) {

        foreach ($shipping_details as $sc) {
            $range1 = $sc->distancefrom;
            $range2 = $sc->distanceto;
            if ($shipping_distance >= $range1 && $shipping_distance <= $range2) {
                $lt = explode('~', $sc->lessthan);
                $gt = explode('~', $sc->greaterthan);
                $sp = explode('~', $sc->price);

                for($j = 0; $j < sizeof($gt); $j++){
                    if ($cart_subtotal >= $gt[$j] && $cart_subtotal <= $lt[$j]) {
                        $shipping_charges = '(+)<span class="WebRupee">Rs.</span> ' . number_format((float) $sp[$j], '2', '.', '') . "/-";
                        $shipping_amt = $sp[$j];
                        $paymoney = $sp[$j] + $cart_subtotal;
                    } else if ($cart_subtotal > $lt[sizeof($gt) - 1]) {
                        $shipping_charges = 'free';
                        $shipping_amt = 0;
                        $paymoney = $cart_subtotal;
                    } else {
                        $mincartvalue = $gt[0];
                        //$paymoney = $cart_subtotal;
                    }
                }
            }
        }
    }
    $response['shipping_charges'] = $shipping_charges;
    $response['shipping_amt'] = $shipping_amt;
    $response['paymoney'] = $paymoney;
    $response['mincartvalue'] = $mincartvalue;
    return $response;
}

#Calculate Shipping Charges API CALL

function shippingChargesapi($cart_subtotal, $shipping_distance) {
    $CI = & get_instance();
    $response = array();
    $shipping_charges = '';
    //$shipping=$CI->session->userdata('storedate_user');
    //$shipping_distance=$shipping['store_distance'];
    $shipping_details = getShipingOnProduct($shipping_distance);
    if (count($shipping_details) > 0) {
        foreach ($shipping_details as $sc) {
            $range1 = $sc->distancefrom;
            $range2 = $sc->distanceto;
            if ($shipping_distance >= $range1 && $shipping_distance <= $range2) {
                $lt = explode('~', $sc->lessthan);
                $gt = explode('~', $sc->greaterthan);
                $sp = explode('~', $sc->price);

                for ($j = 0; $j < sizeof($gt); $j++) {
                    if ($cart_subtotal >= $gt[$j] && $cart_subtotal <= $lt[$j]) {
                        $shipping_charges = number_format($sp[$j], '2', '.', '');
                        $shipping_amt = $sp[$j];
                        $paymoney = $sp[$j] + $cart_subtotal;
                    } else if ($cart_subtotal > $lt[sizeof($gt) - 1]) {
                        $shipping_charges = 'free';
                        $shipping_amt = 0;
                        $paymoney = $cart_subtotal;
                    }
                }
            }
        }
    }
    $response['shipping_charges'] = $shipping_charges;
    $response['shipping_amt'] = $shipping_amt;
    $response['paymoney'] = $paymoney;
    return $response;
}

function searchyProductBycat($searchkey = '') {
    $CI = & get_instance();
    $searchkey = addslashes($searchkey);
    //$sql='SELECT *,IF(`category_name` LIKE "'.$searchkey.'%",  20, IF(`category_name` LIKE "%'.$searchkey.'%", 15, 0)) + IF(`product_name` LIKE "%'.$searchkey.'%", 10,  0) + IF(`brand_name`   LIKE "%'.$searchkey.'%", 5,  0) + IF(`brand_name` LIKE "%MODERN%", 5, 0)+ IF(`product_name` LIKE "%Modern%", 3,  0) AS `weight` FROM `tbl_search` WHERE ( `parent_category` LIKE "%'.$searchkey.'%"  OR `category_name` LIKE "%'.$searchkey.'%" OR `product_name` LIKE "%'.$searchkey.'%" OR `brand_name`  LIKE "%'.$searchkey.'%") and product_status="Enable" GROUP BY product_id ORDER BY `weight` DESC,`product_name` ASC limit 25';
    $CI->db->select('*,(select img_1 from tbl_interface_product_images where product_id = tbl_search.product_id) AS PRODUCT_IMAGE,IF(category_name LIKE "' . $searchkey . '%",  20, IF(category_name LIKE "%' . $searchkey . '%", 15, 0)) + IF(product_name LIKE "%' . $searchkey . '%", 10,  0) + IF(brand_name   LIKE "%' . $searchkey . '%", 5,  0)  + IF(brand_name LIKE "%MODERN%", 5, 0) + IF(product_name LIKE "%Modern%", 3,  0) AS weight', false);
    $CI->db->where('product_status', 'Enable');

    if ($searchkey != '') {
        $CI->db->where('(parent_category LIKE "%' . $searchkey . '%"  OR category_name LIKE "%' . $searchkey . '%" OR product_name LIKE "%' . $searchkey . '%" OR brand_name  LIKE "%' . $searchkey . '%")');
    }

    $CI->db->group_by("product_id");
    $CI->db->order_by('weight');
    $CI->db->order_by("product_name");
    $CI->db->limit('25');

    $query = $CI->db->get("tbl_search");

    //$query = $CI->db->query($sql);
    //echo $CI->db->last_query();die;
    if ($query->num_rows() > 0) {
        $data = $query->result();
    } else {
        $data = '';
    }

    return $data;
}

/* function searchyProductBycat($searchkey){
  $CI = & get_instance();
  $sql="SELECT `tbl_categories`.`name`, `tbl_product`.`product_name`, `tbl_product`.`product_url`, `tbl_product`.`product_id` FROM `tbl_categories` JOIN `interface_procategories` ON `tbl_categories`.`id`=`interface_procategories`.`sub_category_id` JOIN `tbl_product` ON `interface_procategories`.`product_id` = `tbl_product`.`product_id` WHERE `tbl_product`.`product_status` = 'Enable' AND `tbl_categories`.`name` LIKE '".$searchkey."%' ESCAPE '!' group by `tbl_product`.`product_id` order by case when `tbl_product`.`product_name` LIKE 'Bazaar%' then 0 else 1 end, `tbl_product`.`product_name` LIMIT 10";
  $query = $CI->db->query($sql);
  $CI->db->last_query();
  $data = $query->result();
  return $data;
  } */

function searchyProductBycatsss($searchkey, $start, $last) {
    $CI = & get_instance();
    $where = '';
    if ($searchkey != '') {
        $where = ' AND (parent_category LIKE "%' . $searchkey . '%"  OR category_name LIKE "%' . $searchkey . '%" OR product_name LIKE "%' . $searchkey . '%" OR brand_name  LIKE "%' . $searchkey . '%")';
    }
    // $sql='SELECT *,IF(category_name LIKE "'.$searchkey.'%",  20, IF(category_name LIKE "%'.$searchkey.'%", 15, 0)) + IF(product_name LIKE "%'.$searchkey.'%", 10,  0) + IF(brand_name   LIKE "%'.$searchkey.'%", 5,  0)  + IF(brand_name LIKE "%MODERN%", 5, 0) + IF(product_name LIKE "%Modern%", 3,  0) AS weight FROM tbl_search` WHERE product_status="Enable" '.$where.'  GROUP BY product_id ORDER BY weight DESC limit '.$start.','.$last.'';

    $CI->db->select('*,IF(category_name LIKE "' . $searchkey . '%",  20, IF(category_name LIKE "%' . $searchkey . '%", 15, 0)) + IF(product_name LIKE "%' . $searchkey . '%", 10,  0) + IF(brand_name   LIKE "%' . $searchkey . '%", 5,  0)  + IF(brand_name LIKE "%MODERN%", 5, 0) + IF(product_name LIKE "%Modern%", 3,  0) AS weight', false);
    $CI->db->where('product_status', 'Enable');
    if ($searchkey != '') {
        $CI->db->where('(parent_category LIKE "%' . $searchkey . '%"  OR category_name LIKE "%' . $searchkey . '%" OR product_name LIKE "%' . $searchkey . '%" OR brand_name  LIKE "%' . $searchkey . '%")');
    }
    $CI->db->group_by("product_id");
    $CI->db->order_by("weight");
    $CI->db->limit($start, $last);
    $query = $CI->db->get("tbl_search");
    //$query = $CI->db->query($sql);
    //echo $CI->db->last_query();die;
    $data = $query->result();
    return $data;
}

function searchProductsort($searchkey, $start, $last, $orderby, $store_id = '') {
    $CI = & get_instance();
    $sql = 'SELECT *,IF(`category_name` LIKE "' . $searchkey . '%",  20, IF(`category_name` LIKE "%' . $searchkey . '%", 15, 0)) + IF(`product_name` LIKE "%' . $searchkey . '%", 10,  0) + IF(`brand_name`   LIKE "%' . $searchkey . '%", 5,  0)  + IF(`brand_name` LIKE "%MODERN%", 5, 0) + IF(`product_name` LIKE "%Modern%", 3,  0) AS `weight` FROM `tbl_search` WHERE ( `parent_category` LIKE "%' . $searchkey . '%"  OR `category_name` LIKE "%' . $searchkey . '%" OR `product_name` LIKE "%' . $searchkey . '%" OR `brand_name`  LIKE "%' . $searchkey . '%") and  product_status="Enable" GROUP BY product_id ORDER BY `product_price` ' . $orderby . ',`weight` DESC limit ' . $start . ',' . $last . '';
    $query = $CI->db->query($sql);
    //echo $CI->db->last_query();die;
    $data = $query->result();
    return $data;
}

function searchCountBycat($searchkey = '') {
    $CI = & get_instance();
    $where = '';
    if ($searchkey != '') {
        $where = ' AND ( `parent_category` LIKE "%' . $searchkey . '%"  OR `category_name` LIKE "%' . $searchkey . '%" OR `product_name` LIKE "%' . $searchkey . '%" OR `brand_name`  LIKE "%' . $searchkey . '%")';
    }
    $sql = 'SELECT *,IF(category_name LIKE "' . $searchkey . '%",  20, IF(category_name LIKE "%' . $searchkey . '%", 15, 0)) + IF(product_name LIKE "%' . $searchkey . '%", 10,  0) + IF(brand_name   LIKE "%' . $searchkey . '%", 5,  0) + IF(brand_name LIKE "%MODERN%", 5, 0) + IF(product_name LIKE "%Modern%", 3,  0) AS weight FROM tbl_search WHERE  product_status="Enable" ' . $where . ' GROUP BY product_id ORDER BY weight DESC';

    //$query = $CI->db->query($sql);
    $CI->db->select('*,IF(category_name LIKE "' . $searchkey . '%",  20, IF(category_name LIKE "%' . $searchkey . '%", 15, 0)) + IF(product_name LIKE "%' . $searchkey . '%", 10,  0) + IF(brand_name   LIKE "%' . $searchkey . '%", 5,  0) + IF(brand_name LIKE "%MODERN%", 5, 0) + IF(product_name LIKE "%Modern%", 3,  0) AS weight', false);
    $CI->db->where("product_status", "Enable");
    if ($searchkey != '') {
        $CI->db->where('( parent_category LIKE "%' . $searchkey . '%"  OR category_name LIKE "%' . $searchkey . '%" OR product_name LIKE "%' . $searchkey . '%" OR brand_name  LIKE "%' . $searchkey . '%")');
    }

    $CI->db->group_by('product_id');
    $CI->db->order_by('weight', 'desc');

    $query = $CI->db->get('tbl_search');
    //echo $CI->db->last_query();
    $data = $query->result();
    return $data;
}

function searchRefinebycat($searchkey, $category = '', $brand = '', $start = '', $last = '') {
    $CI = & get_instance();
    $where = '';
    if ($category != '') {
        $where .= " AND `category_id` IN (" . $category . ")";
    }
    if ($brand != '') {
        $where .= " AND `brand_id` IN (" . $brand . ")";
    }
    if ($start != '' && $last != '') {
        $limit = ' limit ' . $start . ',' . $last . '';
    }
    $sql = 'SELECT *,IF(`category_name` LIKE "' . $searchkey . '%",  20, IF(`category_name` LIKE "%' . $searchkey . '%", 15, 0)) + IF(`product_name` LIKE "%' . $searchkey . '%", 10,  0) + IF(`brand_name`   LIKE "%' . $searchkey . '%", 5,  0)  + IF(`brand_name` LIKE "%MODERN%", 5, 0) + IF(`product_name` LIKE "%Modern%", 3,  0) AS `weight` FROM `tbl_search` WHERE ( `parent_category` LIKE "%' . $searchkey . '%"  OR `category_name` LIKE "%' . $searchkey . '%" OR `product_name` LIKE "%' . $searchkey . '%" OR `brand_name`  LIKE "%' . $searchkey . '%") ' . $where . ' and  product_status="Enable" GROUP BY product_id ORDER BY `weight` DESC' . $limit;
    $query = $CI->db->query($sql);
    //echo $CI->db->last_query();
    $data = $query->result();
    return $data;
}

function searchRefinesort($searchkey, $category = '', $brand = '', $start = '', $last = '', $orderby, $store_id = '') {
    $CI = & get_instance();
    $where = '';
    if ($category != '') {
        $where .= " AND `category_id` IN (" . $category . ")";
    }
    if ($brand != '') {
        $where .= " AND `brand_id` IN (" . $brand . ")";
    }
    if ($start != '' && $last != '') {
        $limit = ' limit ' . $start . ',' . $last . '';
    }

    $sql = 'SELECT *,IF(`category_name` LIKE "' . $searchkey . '%",  20, IF(`category_name` LIKE "%' . $searchkey . '%", 15, 0)) + IF(`product_name` LIKE "%' . $searchkey . '%", 10,  0) + IF(`brand_name`   LIKE "%' . $searchkey . '%", 5,  0) + IF(`brand_name` LIKE "%MODERN%", 5, 0) + IF(`product_name` LIKE "%Modern%", 3,  0) AS `weight` FROM `tbl_search` WHERE ( `parent_category` LIKE "%' . $searchkey . '%"  OR `category_name` LIKE "%' . $searchkey . '%" OR `product_name` LIKE "%' . $searchkey . '%" OR `brand_name`  LIKE "%' . $searchkey . '%") ' . $where . ' and  product_status="Enable" GROUP BY product_id ORDER BY product_price ' . $orderby . $limit;
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function searchyBycat($searchkey, $start, $last) {
    $CI = & get_instance();
    $sql = "SELECT `tbl_categories`.`name`, `tbl_product`.`product_name`, `tbl_product`.`product_url`, `tbl_product`.`product_id` FROM `tbl_categories` JOIN `interface_procategories` ON `tbl_categories`.`id`=`interface_procategories`.`sub_category_id` JOIN `tbl_product` ON `interface_procategories`.`product_id` = `tbl_product`.`product_id` WHERE `tbl_product`.`product_status` = 'Enable' AND `tbl_categories`.`name` LIKE '" . $searchkey . "%' ESCAPE '!' group by `tbl_product`.`product_id` order by case when `tbl_product`.`product_name` LIKE 'Bazaar%' then 0 else 1 end, `tbl_product`.`product_name` LIMIT " . $start . "," . $last . "";
    $query = $CI->db->query($sql);
    $CI->db->last_query();
    $data = $query->result();
    return $data;
}

function searchyBycatsss($searchkey, $start, $last) {
    $CI = & get_instance();
    $sql = "SELECT `tbl_categories`.`name`, `tbl_product`.`product_name`, `tbl_product`.`product_url`, `tbl_product`.`product_id` FROM `tbl_categories` JOIN `interface_procategories` ON `tbl_categories`.`id`=`interface_procategories`.`sub_category_id` JOIN `tbl_product` ON `interface_procategories`.`product_id` = `tbl_product`.`product_id` WHERE `tbl_product`.`product_status` = 'Enable' AND `tbl_categories`.`name` LIKE '" . $searchkey . "%' ESCAPE '!' group by `tbl_product`.`product_id` order by case when `tbl_product`.`product_name` LIKE 'Bazaar%' then 0 else 1 end, `tbl_product`.`product_name` LIMIT " . $start . "," . $last . "";
    $query = $CI->db->query($sql);
    $CI->db->last_query();
    $data = $query->result();
    return $data;
}

function getBrandNameByProductId($brand_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($brand_id != "") {
        $where .= " AND `tbl_brand`.`brand_id`= '" . $brand_id . "'";
    }
    $sql = "select `tbl_brand`.brand_id,`tbl_brand`.brand_name from `tbl_brand` where 1=1 " . $where . " GROUP BY brand_name";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}



function test() {
    $CI = & get_instance();
    $where = "";
    $sql = "select product_name,product_id from `tbl_search` where 1=1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function brand() {
    $CI = & get_instance();
    $where = "";
    $sql = "select brand_name from `tbl_brand` where 1=1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function product($product_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " AND `tbl_product`.`product_id`= '" . $product_id . "'";
    }
    $sql = "select product_id from `tbl_product` where 1=1 " . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getProductSearchByCheckedValue($cat = "", $category_id = "", $brand_id = "", $start = "", $last = "") {
    $CI = & get_instance();
    $where = "";
    if ($start != "" && $last != "") {
        $checklimit = " limit " . $start . "," . $last . "";
    }

    if ($category_id != '') {
        $searchCat = $category_id;
    } else {
        $searchCat = implode(',', $cat);
    }
    $where .= "AND interface_procategories.sub_category_id IN ($searchCat)";


    if ($brand_id != "") {
        $where .= " AND `tbl_product`.brand_name IN ($brand_id)";
    }

    $sql = "select tbl_product.product_id,product_name,product_code,product_url from `tbl_product` inner join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id`  and `tbl_product`.`product_status`='Enable' " . $where . " group by tbl_product.product_name  order by product_id desc " . $checklimit . "";
    $query = $CI->db->query($sql);
    //echo $CI->db->last_query();
    $data = $query->result();
    return $data;
}

function sortsearchquery($Cat = "", $category_id = "", $brand_id = "", $start = "", $last = "", $orderby = "", $store_id) {
    $CI = & get_instance();
    $where = "";
    if ($start != "" && $last != "") {
        $checklimit = " limit " . $start . "," . $last . "";
    }
    if ($category_id != "") {
        $where .= "AND interface_procategories.sub_category_id IN ($category_id)";
    }
    if ($Cat != '' && $category_id == '') {
        $Cat = implode(',', $Cat);
        $where .= "AND interface_procategories.sub_category_id IN ($Cat)";
    }
    if ($brand_id != "") {
        $where .= " AND `tbl_product`.brand_name IN ($brand_id)";
    }

    //$sql = "select tbl_product.product_id,product_name,product_code,product_url from `tbl_product` inner join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id`  and `tbl_product`.`product_status`='Enable' " . $where . " group by tbl_product.product_name  order by product_id desc ".$checklimit."";
    $sql = "select `tbl_product`.`product_id`,`tbl_product`.`product_name`,`tbl_product`.`product_code`,`tbl_product`.`product_url`,`tbl_product_price`.`product_price` from `tbl_product`
inner join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id` and `tbl_product`.`product_status`='Enable' " . $where . " inner join `tbl_product_price` on `tbl_product_price`.`product_id`=`tbl_product`.`product_id` AND `tbl_product_price`.`product_price`!=0  group by `tbl_product`.`product_name`  order by `tbl_product_price`.`product_price` " . $orderby . " " . $checklimit . "";
    $query = $CI->db->query($sql);
    //echo $CI->db->last_query(); die;
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function validatepromo2($promocode = "") {
    $response = array();
    $valid = "no";
    $cart_subtotal = 0;      //Cart Subtotal
    //$total_discount=0;     //Total Saving
    $shipping_charges = '';  //Shipping Charge
    $promo_discount = 0;     //Promo Discount Amount
    $paymoney = 0;           //Final Amount to be paid after promo validation.
    $temp_payamout = 0;

    if ($promocode != '') {
        $promo = getPromo($promocode);
        if (count($promo) > 0) {
            foreach ($promo as $pc) {
                $discount_type = $pc->discount_type;
                $discount_value = $pc->discountamount;
                #Get user current cart
                $getcart = getCurrentcart();
                $cart_subtotal = $getcart['cart_subtotal'];
                $cart_subtotal_discount = $getcart['total_discount'];
                $totalitems = $getcart['total_items'];
                $ship = shippingCharges($cart_subtotal);
                $shipping_charges = $ship['shipping_charges'];
                $temp_payamount = $ship['paymoney'];
                #Check Promo available for all users
                /* if($pc->users_status==1){
                  $allstatus="yes";
                  }else{
                  $allstatus="no";
                  } */

                #Check Promo available for selected users
                if ($pc->users_status == 2) {
                    $user_login = $CI->session->userdata('auth_user');
                    if (isset($user_login) && !empty($user_login)) {
                        $uid = $user_login['users_id'];
                        $ch = checkuserPromo($promocode, $uid);
                        if ($ch == 1) {
                            $userstatus = "yes";
                        } else {
                            $userstatus = "no";
                        }
                    } else {
                        $userstatus = "no";
                    }
                }

                #Check Cart Subtotal
                if ($pc->cartsubtotal_status == 4) {
                    if ($cart_subtotal >= $pc->mincartsubtotal) {
                        $cartstatus = "yes";
                    } else {
                        $cartstatus = "no";
                    }
                }

                #Check Minimum cart items
                if ($pc->minunit_status == '8') {
                    if ($totalitems >= $pc->minunit) {
                        $itemsstatus = "yes";
                    } else {
                        $itemsstatus = "no";
                    }
                }

                if ($userstatus == 'yes' && $cartstatus == "yes" && $itemsstatus = "yes") {
                    $valid = "yes";
                } else if ($userstatus == 'yes' && $cartstatus == "yes") {
                    $valid = "yes";
                } else if ($userstatus == 'yes' && $itemsstatus == "yes") {
                    $valid = "yes";
                } else if ($cartstatus == "yes" && $itemsstatus = "yes") {
                    $valid = "yes";
                } else if ($cartstatus == "yes") {
                    $valid = "yes";
                } else if ($itemsstatus == "yes") {
                    $valid = "yes";
                } else if ($userstatus == "yes") {
                    $valid = "yes";
                }
                if ($valid == 'yes') {
                    if ($discount_type == 'percentage') {
                        $promo_discount_amt = ($cart_subtotal * $discount_value) / 100;
                        if ($promo_discount > $pc->max_discount_amt) {
                            $discounted_cart_subtotal = $cart_subtotal - $pc->max_discount_amt;
                        } else {
                            $discounted_cart_subtotal = $cart_subtotal - $promo_discount_amt;
                        }
                    } else if ($discount_type == 'flat') {
                        $discounted_cart_subtotal = $cart_subtotal - $discount_value;
                    }

                    $response['cart_subtotal'] = $cart_subtotal;
                    $response['shipping_charges'] = $shipping_charges;
                    $response['promodiscount'] = $promo_discount_amt;
                    $response['paymoney'] = $temp_payamount - $promo_discount_amt;
                    $response['total_saving'] = $cart_subtotal_discount + $promo_discount_amt;
                    $response['status'] = 'pass';
                    //$CI->session->set_userdata('promocode',$promocode);
                } else {
                    $response['status'] = 'invalid';
                }
            }
        } else {
            $response['status'] = 'invalid';
        }
    } else {
        $response['status'] = 'fail';
    }
    return $response;
}

function validatepromo3($promocode = "", $cart_items) {
    $CI = & get_instance();
    $response = array();
    $valid = "no";
    $cart_subtotal = 0;      //Cart Subtotal
    //$total_discount=0;     //Total Saving
    $shipping_charges = '';  //Shipping Charge
    $promo_discount = 0;     //Promo Discount Amount
    $paymoney = 0;           //Final Amount to be paid after promo validation.
    $temp_payamout = 0;

    if ($promocode != '') {
        $promo = getPromo($promocode);

        if (count($promo) > 0) {
            foreach ($promo as $pc) {

                $discount_type = $pc->discount_type;
                $discount_value = $pc->discountamount;
                #Get user current cart
                $getcart = getcartByarray($cart_items);
                $cart_subtotal = $getcart['cart_subtotal'];
                $cart_subtotal_discount = $getcart['total_discount'];
                $totalitems = $getcart['total_items'];
                $ship = shippingCharges($cart_subtotal);
                $shipping_charges = $ship['shipping_charges'];
                $shipping_amt = $ship['shipping_amt'];
                $temp_payamount = $ship['paymoney'];

                #Check Promo available for selected users

                if ($pc->users_status == '2') {

                    $user_login = $CI->session->userdata('auth_user');

                    if (isset($user_login) && !empty($user_login)) {
                        $uid = $user_login['users_id'];
                        $ch = checkuserPromo($promocode, $uid);
                        if ($ch == 1) {
                            $userstatus = "yes";
                        } else {
                            $userstatus = "no";
                        }
                    } else {
                        $userstatus = "no";
                    }
                }

                #Check Cart Subtotal
                if ($pc->cartsubtotal_status == 4) {
                    if ($cart_subtotal >= $pc->mincartsubtotal) {
                        $cartstatus = "yes";
                    } else {
                        $cartstatus = "no";
                    }
                }

                #Check Minimum cart items
                if ($pc->minunit_status == '8') {
                    if ($totalitems >= $pc->minunit) {
                        $itemsstatus = "yes";
                    } else {
                        $itemsstatus = "no";
                    }
                }

                if ($pc->users_status == 1) {
                    if ($cartstatus == "yes" && $itemsstatus = "yes") {
                        $valid = "yes";
                    } else if ($cartstatus == "yes") {
                        $valid = "yes";
                    } else if ($itemsstatus == "yes") {
                        $valid = "yes";
                    } else if ($pc->users_status == 1) {
                        $valid = "yes";
                    }
                } else if ($pc->users_status == 2) {
                    if ($userstatus == 'yes' && $cartstatus == "yes" && $itemsstatus = "yes") {
                        $valid = "yes";
                    } else if ($userstatus == 'yes' && $cartstatus == "yes") {
                        $valid = "yes";
                    } else if ($userstatus == 'yes' && $itemsstatus == "yes") {
                        $valid = "yes";
                    } else if ($cartstatus == "yes" && $itemsstatus = "yes") {
                        $valid = "yes";
                    } else if ($cartstatus == "yes") {
                        $valid = "yes";
                    } else if ($itemsstatus == "yes") {
                        $valid = "yes";
                    } else if ($userstatus == "yes") {
                        $valid = "yes";
                    }
                }

                if ($valid == 'yes') {
                    $promo_discount_amt = 0;
                    if ($discount_type == 'percentage') {
                        $promo_discount_amt = ($cart_subtotal * $discount_value) / 100;
                        if ($promo_discount_amt > $pc->max_discount_amt) {
                            $promo_discount_amt = $pc->max_discount_amt;
                        }
                        $discounted_cart_subtotal = $cart_subtotal - $promo_discount_amt;
                    } else if ($discount_type == 'flat') {
                        $discounted_cart_subtotal = $cart_subtotal - $discount_value;
                    }
                    $paymoney = $discounted_cart_subtotal + $shipping_amt;
                    $response['discount_type'] = $discount_type;
                    $response['discount_value'] = $discount_value;
                    $response['cart_subtotal'] = $cart_subtotal;
                    $response['shipping_charges'] = $shipping_charges;
                    $response['shipping_amt'] = $shipping_amt;
                    $response['promodiscount'] = $promo_discount_amt;
                    $response['paymoney'] = number_format($paymoney, "2", ".", "");
                    $response['total_saving'] = $cart_subtotal_discount + $promo_discount_amt;
                    $response['status'] = 'pass';
                    //$CI->session->set_userdata('promocode',$promocode);
                } else {
                    $response['status'] = 'invalid';
                }
            }
        } else {
            $response['status'] = 'invalid';
        }
    } else {
        $response['status'] = 'fail';
    }
    return $response;
}

function getcartByarray($saved_cart_items) {
    $response = array();
    $cart_subtotal = 0;
    $actualcart_subtotal = 0;
    $total_discount = 0;
    foreach ($saved_cart_items as $key => $value) {
        $data = getProductByPricesdd($key);
        foreach ($data as $d) {
            $discount_amount = 0;
            $column = array();
            $product_id = $d->product_id;
            $product_name = $d->product_name;
            $weight = $d->product_pec_weight;
            if ($d->product_s_price != 0) {
                $price = number_format($d->product_s_price, '2', '.', '');
                $actualprice = '<span class="WebRupee">Rs.</span>' . number_format($d->product_price, '2', '.', '') . '/-';
                $disc_amt_val = ($d->product_price) - ($d->product_s_price);
                $discount_amount = $disc_amt_val * $value;
            } else {
                $price = number_format($d->product_price, '2', '.', '');
                $actualprice = '';
            }

            $temp_subtotal = $price * $value;
            $actualcart_subtotal = $actualcart_subtotal + $temp_subtotal;
            $all_discount_list = getDiscountOnProduct($product_id);
            if ($d->product_s_price == 0 && $all_discount_list != '' && count($all_discount_list) > 0) {
                if ($all_discount_list != '' && count($all_discount_list) > 0) {
                    $temp_unit_price = 0;
                    foreach ($all_discount_list as $pd) {
                        $disc_value = $pd->discountamount;
                        if ($value >= $pd->minunit && $value <= $pd->maxunit) {
                            if ($pd->discount_type == 'percentage') {
                                $discount_amount = ($temp_subtotal * $disc_value) / 100;
                                #Calculate Unit price with discount
                                $temp_actualprice = $price;
                                $tempdisc_unit_price = (($price * 1) * $disc_value) / 100;
                                $temp_unit_price = $price - $tempdisc_unit_price;
                            } else if ($pd->discount_type == 'flat') {
                                $temp_unit_price = 0;
                                $discount_amount = $temp_subtotal - $disc_value;
                            }
                            if ($temp_unit_price != 0) {
                                $actualprice = $temp_actualprice;
                                $price = $temp_unit_price;
                            }
                            $total_discount = $total_discount + $discount_amount;
                            $product_subtotal = ($temp_subtotal) - $discount_amount;
                        } else if ($value > $pd->maxunit) {
                            #Non Discounted Qnty
                            $non_discounted_qnty = $value - $pd->maxunit;
                            #Discounted Qnty
                            $discounted_qnty = $pd->maxunit;

                            #Discounted Qnty Price Details
                            if ($pd->discount_type == 'percentage') {
                                #Calculate Unit price with discount
                                $temp_actualprice = $price;
                                $tempdisc_unit_price = (($price * 1) * $disc_value) / 100;
                                $temp_unit_price = $price - $tempdisc_unit_price;
                            } else if ($pd->discount_type == 'flat') {
                                $temp_unit_price = 0;
                            }
                            if ($temp_unit_price != 0) {
                                $disc_actualprice = $temp_actualprice;
                                $disc_price = $temp_unit_price;
                            }


                            if ($pd->discount_type == 'percentage') {
                                #Non discounted amt
                                $non_disc_qnty_amt = $non_discounted_qnty * $price;
                                #Discounted amt
                                $discount_amount = (($discounted_qnty * $price) * $disc_value) / 100;
                                $disc_qnty_amt = ($discounted_qnty * $price) - $discount_amount;
                                #Product Subtotal
                                $product_subtotal = $disc_qnty_amt + $non_disc_qnty_amt;
                            } else if ($pd->discount_type == 'flat') {
                                $discount_amount = $disc_value;
                                $non_disc_qnty_amt = $non_discounted_qnty * $price;
                                $disc_qnty_amt = ($non_discounted_qnty * $price) - $disc_value;
                                $product_subtotal = $disc_qnty_amt + $non_disc_qnty_amt;
                            }
                            $total_discount = $total_discount + $discount_amount;
                            //$column['disc_qnty']=$discounted_qnty;
                            $disclimit = 'limit';
                            //echo json_encode($response,JSON_PRETTY_PRINT);
                            //exit;
                        }
                        $cart_subtotal = $cart_subtotal + $product_subtotal;
                    }
                }
            } else {
                $product_subtotal = $price * $value;
                $cart_subtotal = $cart_subtotal + $product_subtotal;
                $total_discount = $total_discount + $discount_amount;
            }
        }
    }
    $response['total_items'] = count($saved_cart_items);
    $response['cart_subtotal'] = $cart_subtotal;
    $response['total_discount'] = $total_discount;
    return $response;
}

##Check user current cart

function getCurrentcart($user_id) {
    $CI = & get_instance();
    $response = array();
    if($user_id){
        $CI->load->model('Webservices_model/Cart_model');
        $result = $CI->Cart_model->get_cart_items($user_id);
        $saved_cart_items = $result;
    }else{
         // $cookie = $_COOKIE['cart_items_cookie'];
        // $cookie = stripslashes($cookie);
        $saved_cart_items = $_SESSION['cart_items_cookie'];
    }

    $cart_subtotal = 0;
    $actualcart_subtotal = 0;
    $total_discount = 0;

    if (count($saved_cart_items) > 0) {
        foreach ($saved_cart_items as $key => $value) {
            $data = getProductByPricesdd($key);
            foreach ($data as $d) {
                $discount_amount = 0;
                $column = array();
                $product_id = $d->product_id;
                $product_name = $d->product_name;
                $weight = $d->product_pec_weight;
                if ($d->product_s_price != 0) {
                    $price = number_format((float) $d->product_s_price, '2', '.', '');
                    $actualprice = '<span class="WebRupee">Rs.</span>' . number_format((float) $d->product_price, '2', '.', '') . '/-';
                    $disc_amt_val = ($d->product_price) - ($d->product_s_price);
                    $discount_amount = $disc_amt_val * $value;
                } else {
                    $price = number_format((float) $d->product_price, '2', '.', '');
                    $actualprice = '';
                }
                /* $productimages = getAllProductImagelist($product_id);
                  foreach($productimages as $pi){
                  if(!empty($pi->img_1) && file_exists(UPLOAD_PRODUCT_IMAGE_PATH.$pi->img_1)) {
                  $pimage=UPLOAD_FS_PRODUCT_IMAGE_PATH.$pi->img_1;
                  }else{
                  $pimage=MAINSITE_IMAGES_PATH.'no-image-color.jpg';
                  }
                  } */
                $temp_subtotal = $price * $value;
                $actualcart_subtotal = $actualcart_subtotal + $temp_subtotal;
                $all_discount_list = getDiscountOnProduct($product_id);
                if ($d->product_s_price == 0 && $all_discount_list != '' && count($all_discount_list) > 0) {
                    if ($all_discount_list != '' && count($all_discount_list) > 0) {
                        $temp_unit_price = 0;
                        foreach ($all_discount_list as $pd) {
                            $disc_value = $pd->discountamount;
                            if ($value >= $pd->minunit && $value <= $pd->maxunit) {
                                if ($pd->discount_type == 'percentage') {
                                    $discount_amount = ($temp_subtotal * $disc_value) / 100;
                                    #Calculate Unit price with discount
                                    $temp_actualprice = $price;
                                    $tempdisc_unit_price = (($price * 1) * $disc_value) / 100;
                                    $temp_unit_price = $price - $tempdisc_unit_price;
                                } else if ($pd->discount_type == 'flat') {
                                    $temp_unit_price = 0;
                                    $discount_amount = $temp_subtotal - $disc_value;
                                }
                                if ($temp_unit_price != 0) {
                                    $actualprice = $temp_actualprice;
                                    $price = $temp_unit_price;
                                }
                                $total_discount = $total_discount + $discount_amount;
                                $product_subtotal = ($temp_subtotal) - $discount_amount;
                            } else if ($value > $pd->maxunit) {
                                #Non Discounted Qnty
                                $non_discounted_qnty = $value - $pd->maxunit;
                                #Discounted Qnty
                                $discounted_qnty = $pd->maxunit;

                                #Discounted Qnty Price Details
                                if ($pd->discount_type == 'percentage') {
                                    #Calculate Unit price with discount
                                    $temp_actualprice = $price;
                                    $tempdisc_unit_price = (($price * 1) * $disc_value) / 100;
                                    $temp_unit_price = $price - $tempdisc_unit_price;
                                } else if ($pd->discount_type == 'flat') {
                                    $temp_unit_price = 0;
                                }
                                if ($temp_unit_price != 0) {
                                    $disc_actualprice = $temp_actualprice;
                                    $disc_price = $temp_unit_price;
                                }


                                if ($pd->discount_type == 'percentage') {
                                    #Non discounted amt
                                    $non_disc_qnty_amt = $non_discounted_qnty * $price;
                                    #Discounted amt
                                    $discount_amount = (($discounted_qnty * $price) * $disc_value) / 100;
                                    $disc_qnty_amt = ($discounted_qnty * $price) - $discount_amount;
                                    #Product Subtotal
                                    $product_subtotal = $disc_qnty_amt + $non_disc_qnty_amt;
                                } else if ($pd->discount_type == 'flat') {
                                    $discount_amount = $disc_value;
                                    $non_disc_qnty_amt = $non_discounted_qnty * $price;
                                    $disc_qnty_amt = ($non_discounted_qnty * $price) - $disc_value;
                                    $product_subtotal = $disc_qnty_amt + $non_disc_qnty_amt;
                                }
                                $total_discount = $total_discount + $discount_amount;
                                //$column['disc_qnty']=$discounted_qnty;
                                $disclimit = 'limit';
                                //echo json_encode($response,JSON_PRETTY_PRINT);
                                //exit;
                            }
                            $cart_subtotal = $cart_subtotal + $product_subtotal;
                        }
                    }
                } else {
                    $product_subtotal = $price * $value;
                    $cart_subtotal = $cart_subtotal + $product_subtotal;
                    $total_discount = $total_discount + $discount_amount;
                }
            }
        }
    }
    $response['total_items'] = count($saved_cart_items);
    $response['cart_subtotal'] = $cart_subtotal;
    $response['total_discount'] = $total_discount;
    return $response;
}

function checkcookies() {
    $CI = & get_instance();
    $store_array = array();
    if (isset($_COOKIE['store_location'])) {
        $store_data_json = json_decode($_COOKIE['store_location']);
        foreach ($store_data_json as $key => $val) {
            $store_array[$key] = $val;
        }
        $CI->session->set_userdata('storedate_user', $store_array);
        $CI->session->set_userdata('letmein', HASH_VALUE);
    } else {
        setcookie('cart_items_cookie', '', time() + 2592000, "/");
    }
}

function getWeekName($day_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($day_id != "") {
        $where .= " AND `tbl_day`.`id`= '" . $day_id . "'";
    }
    $sql = "select * from `tbl_day` where 1=1 and status='Active' " . $where . " order by id asc";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getTimeLimit($day_name = "") {
    $CI = & get_instance();
    $where = "";
    if ($day_name != "") {
        $where .= " AND `tbl_timeslot`.`day_name`= '" . strtolower($day_name) . "'";
    }
    $sql = "select * from `tbl_timeslot` where 1=1 and status='Active' " . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getModuleCode() {
    $CI = & get_instance();
    $sql = "select mod_modulecode from `tbl_module` " . $where . " order by `id`";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function set_rights($menus, $menuRights, $topmenu) {
    $data = array();
    //pr($topmenu);
    for ($i = 0, $c = count($menus); $i < $c; $i++) {


        $row = array();
        for ($j = 0, $c2 = count($menuRights); $j < $c2; $j++) {
            if ($menuRights[$j]["rr_modulecode"] == $menus[$i]["mod_modulecode"]) {
                if (authorize($menuRights[$j]["rr_create"]) || authorize($menuRights[$j]["rr_edit"]) ||
                        authorize($menuRights[$j]["rr_delete"]) || authorize($menuRights[$j]["rr_view"]) || authorize($menuRights[$j]["rr_cancel"]) || authorize($menuRights[$j]["rr_reports"])
                ) {

                    $row["menu"] = $menus[$i]["mod_modulegroupcode"];
                    $row["menu_name"] = $menus[$i]["mod_modulename"];
                    $row["page_name"] = $menus[$i]["mod_modulepagename"];
                    $row["create"] = $menuRights[$j]["rr_create"];
                    $row["edit"] = $menuRights[$j]["rr_edit"];
                    $row["delete"] = $menuRights[$j]["rr_delete"];
                    $row["view"] = $menuRights[$j]["rr_view"];
                    $row["cancel"] = $menuRights[$j]["rr_cancel"];
                    $row["reports"] = $menuRights[$j]["rr_reports"];
                    $row["export"] = $menuRights[$j]["rr_export"];
                    $row["import"] = $menuRights[$j]["rr_import"];

                    $data[$menus[$i]["mod_modulegroupcode"]][$menuRights[$j]["rr_modulecode"]] = $row;
                    $data[$menus[$i]["mod_modulegroupcode"]]["top_menu_name"] = $menus[$i]["mod_modulegroupname"];
                    $data[$menus[$i]["mod_modulegroupcode"]]["top_class_icon"] = $menus[$i]["mod_icon_name"];
                }
            }
        }
    }

    return $data;
}

function authorize($module) {
    return $module == "yes" ? TRUE : FALSE;
}

function getPermissionrights() {
    $CI = & get_instance();
    $sql = "SELECT mod_modulegroupcode, mod_modulegroupname,mod_icon_name FROM tbl_module "
            . " WHERE 1  and status =1 and orby IS NOT NULL  GROUP BY `mod_modulegroupcode` "
            . " ORDER BY `orby`";
    $query = $CI->db->query($sql);
    $commonModules = $query->result_array();

  //  echo $CI->db->last_query(); die();
    //pr($commonModules);die;
    $sql1 = "SELECT mod_modulegroupcode, mod_modulegroupname, mod_modulepagename,  mod_modulecode, mod_modulename ,mod_icon_name FROM tbl_module "
            . " WHERE 1 "
            . " and  status =1 and orby IS NOT NULL  ORDER BY `orby` ";
    $query1 = $CI->db->query($sql1);
    $allModules = $query1->result_array();
    //pr($allModules);
    $system_admin = $CI->session->userdata('system_admin');
    $group_name = getGroups($system_admin['groups_id']);
    $rc = $group_name[0]->role_rolecode;
    $sql2 = "SELECT rr_modulecode, rr_create, rr_rolecode, rr_edit, rr_delete, rr_view,rr_reports,rr_cancel,rr_export,rr_import FROM tbl_permissions WHERE  rr_rolecode = '" . $rc . "' and status =1 ORDER BY `rr_modulecode` ASC  ";
    $query2 = $CI->db->query($sql2);
    $userRights = $query2->result_array();
    $_SESSION["access"] = set_rights($allModules,$userRights,$commonModules);
   // pr($_SESSION["access"]);
}

function checkStorePermission($store_id = "") {
    $CI = & get_instance();
    $where = "FIND_IN_SET('" . $store_id . "',`store_id`)";
    $sql = "select store_id from `tbl_store` where " . $where . " order by `store_id`";
    $query = $CI->db->query($sql);
    //print_r($CI->db->last_query());die;
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getCardDetails($order_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($order_id != "") {
        $where .= " AND tbl_gatewayorders.order_id= '" . $order_id . "'";
    }
    $sql = "select * from tbl_gatewayorders where 1=1" . $where . "";
    $query = $CI->db->query($sql);

    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getOrderDay($order_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($order_id != "") {
        $where .= " AND `t`.`id`= '" . $order_id . "'";
    }
    $sql = "SELECT d.day_name from `tbl_timeslot` t LEFt join tbl_dayname d on d.id = t.day_id  where 1=1 " . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

##Get order details on OrderID

function get_orderdetails($orders_id) {
    $CI = & get_instance();
    $where = "";
    if ($orders_id != "") {
        $where .= " WHERE `tbl_order`.`order_number` = '" . $orders_id . "'";
    }
    $sql = "select tbl_order.*,tbl_address.* from `tbl_order` inner join `tbl_address` on `tbl_address`.`id` = `tbl_order`.`multiple_address_id` " . $where . " LIMIT 1";
    $query = $CI->db->query($sql);

    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getBrandNamesss() {
    $CI = & get_instance();
    $where = "";
    $sql = "select brand_name from `tbl_brand` where 1=1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

##Get search data list

function getSearchData($product_id) {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " WHERE `tbl_search`.`product_id` = '" . $product_id . "'";
    }
    $sql = "select product_id from `tbl_search`" . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getCategoryByIdName($parent_id = "") {
    $CI = & get_instance();
    $where = "";
    if (is_numeric($parent_id)) {
        $where .= " AND `tbl_categories`.`id` = '" . $parent_id . "'";
    }
    $sql = "select name,url_name , category_banner from `tbl_categories` where `tbl_categories`.`status` = 'Active' " . $where . " limit 1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}
function getCategorySubCategoryName($cat_strs) {
    $CI = & get_instance();
    $cat_id = explode(",", $cat_strs);
    if($cat_id[0]){
        $data['division_name'] = $CI->db->select('name')->get_where('tbl_categories', ['id'=>$cat_id[0], 'status'=>'Active'])->row('name');
    }else{
        $data['division_name'] = '';
    }
    if($cat_id[1]){
        $data['category_name'] = $CI->db->select('name')->get_where('tbl_categories', ['id'=>$cat_id[1], 'status'=>'Active'])->row('name');
    }else{
        $data['category_name'] = '';
    }
    return $data;
}
function getBannerDataBySubCategory($subcatId){
    $CI = & get_instance();
    $CI->db->select('id,category_menu_banner');
    $CI->db->from('tbl_categories');
    $CI->db->where('id',$subcatId);
    $CI->db->where('status','Active');
    $query = $CI->db->get();
    if($query->num_rows()>0){
            //$bannerData = array();
            $bannerData= $query->row();
    }
return $bannerData;
}

function get_valid_name($string) {
    if ($string) {
        $sps_chr_arr = array("--", ",", "\\", "/", "&quot;", ".", "_", ".", "'", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "=", "-", "[", "]", "{", "}", "<", ">", "?", ";", ",", "|", ":", "`", "~", " ");
        $m = 1;
        for ($x = 0; $x < strlen($string); $x++) {
            if (!in_array($string[$x], $sps_chr_arr) && $string[$x] != "\"") {
                $m = '';
                if ($replace_char) {
                    $valid_name .= $replace_char;
                    $replace_char = '';
                }
                $valid_name .= $string[$x];
            } else if ($m == '' && $string[$x] == " ") {
                $m = 5;
                $replace_char = "-";
            }
        }
    }
    return strtolower($valid_name);
}

function locationDistance($lat1, $lon1, $lat2, $lon2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K") {
        number_format((float) ($miles * 1.609344), 2, '.', '');
        return number_format((float) ($miles * 1.609344), 2, '.', '');
    } else if ($unit == "N") {
        return round(($miles * 0.8684), 1);
        number_format((float) ($miles * 0.8684), 2, '.', '');
    } else {
        return number_format((float) ($miles), 2, '.', '') . $unit;
    }
}

function getImage($imagename) {
    $imageurl = explode('.', $imagename);
    //$url = str_replace(' ','_',trim($imageurl[0]));
    $url = trim($imageurl[0]);
    if (file_exists('./assets/uploads/product/' . $url . '.jpg')) {
        $img = UPLOAD_FS_PRODUCT_IMAGE_PATH . $url . '.jpg';
    } else if (file_exists('./assets/uploads/product/' . $url . ".JPG")) {
        $img = UPLOAD_FS_PRODUCT_IMAGE_PATH . $url . '.JPG';
    } else if (file_exists('./assets/uploads/product/' . $url . ".jpeg")) {
        $img = UPLOAD_FS_PRODUCT_IMAGE_PATH . $url . '.jpeg';
    } else if (file_exists('./assets/uploads/product/' . $url . ".JPEG")) {
        $img = UPLOAD_FS_PRODUCT_IMAGE_PATH . $url . '.JPEG';
    } else if (file_exists('./assets/uploads/product/' . $url . ".png")) {
        $img = UPLOAD_FS_PRODUCT_IMAGE_PATH . $url . '.png';
    } else if (file_exists('./assets/uploads/product/' . $url . ".PNG")) {
        $img = UPLOAD_FS_PRODUCT_IMAGE_PATH . $url . '.PNG';
    } else {
        $img = MAINSITE_IMAGES_PATH . 'product_placeholder.png';
    }
    return $img;
}

function get_InternationalCuisine($category_id = "", $start = "", $limit = "") {
    $CI = & get_instance();
    $CI->db->select("p.product_id,p.product_image,p.product_code,p.product_name,p.product_url,p.product_type,p.product_status,p.weight_ids as weight_id,p.product_prices as product_price,p.product_pec_weights as product_pec_weight,p.product_s_prices as product_s_price,p.category_ids", false);
    $CI->db->where("p.product_status='Enable'");
    $CI->db->where("p.product_prices!=''");

    if (isset($category_id) && $category_id != '') {

        $str_find_set = " find_in_set('" . $category_id[0] . "',category_ids)>0";
        if (count($category_id) > 1) {
            $cnt = count($category_id);
            for ($i = 1; $i < $cnt; $i++) {
                $str_find_set = $str_find_set . " OR find_in_set('" . $category_id[$i] . "',category_ids)>0";
            }
        }

        $CI->db->where("(" . $str_find_set . ")");
    }
    if ($start != "" && $limit != "") {
        $CI->db->limit($limit, $start);
    }

    $query = $CI->db->get("tbl_product as p");
    //echo $this->db->last_query();die;
    if ($query->num_rows()) {

        $rs_data['status'] = "success";

        $rs_data['result'] = $query->result();
    } else {
        $rs_data['status'] = "error";
        $rs_data['result'] = '';
        $rs_data['totalRecords'] = 0;
        $rs_data['search_records'] = 0;
    }
    return $rs_data;
}

function getBrandCategoryIdByUrl($brand_url = "") {
    $CI = & get_instance();
    $where = "";
    if ($brand_url != "") {
        $where .= " AND `tbl_brand`.`url_name` = '" . $brand_url . "'";
    }
    $sql = "select category_id,brand_name,url_name from `tbl_brand` where 1=1 " . $where . " limit 1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getModernProductBrand($category_id, $searchkey) {
    $CI = & get_instance();
    $where = "";
    if ($category_id != "") {
        $where .= "AND interface_procategories.sub_category_id IN ($category_id)";
    }
    $sql = "select tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_product.product_url,tbl_product.product_image from `tbl_product` inner join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id`  and `tbl_product`.`product_status`='Enable' and `tbl_product`.`product_name` LIKE '%" . $searchkey . "%'" . $where . " group by tbl_product.product_name order by tbl_product.product_id desc";
    $query = $CI->db->query($sql);
    $CI->db->last_query();
    $data = $query->result();
    return $data;
}

/* Get new order number */

function get_new_order_number() {
    $order_number = 0;
    $CI = & get_instance();
    $sql_ins = "INSERT INTO tbl_order_code( value_1, value_2 ) SELECT value_1, (MAX( value_2 ) +1) as value_2  FROM tbl_order_code";


    $rs_ins = $CI->db->query($sql_ins);
     // echo $CI->db->last_query(); die();
    $id = $CI->db->insert_id();
    $sql = "SELECT * FROM  tbl_order_code WHERE id='" . $id . "'";
    $query = $CI->db->query($sql);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $value_1        = $row->value_1;
        $value_2        = $row->value_2;
        $order_number   = $value_1 . str_pad($value_2,7,"0", STR_PAD_LEFT);
    }
    // pr($order_number);die;
    return $order_number;
}


function get_new_po_order_number() {
    $CI=get_instance();

    $CI->db->select("*");
    $CI->db->from("tbl_po_order");
    $CI->db->limit(1);
    $CI->db->order_by('id',"DESC");
    $query = $CI->db->get();
    $result = $query->row_array();
    if(empty($result)){
        return 'PO0001';
    }else{
         $ID = $result['id']+1;
         return 'PO000'.$ID;
    }
}


function geDkCode($product_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " AND `tbl_product_price`.`product_id` = '" . $product_id . "' AND `tbl_product_price`.`product_price`!='0.00' ";
    }
    $sql = "select code,ean_code,product_price,product_pec_weight from `tbl_product_price` where 1=1 " . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}
function getUsers_android($notificationID = '') {
     $CI = & get_instance();
     $sql = "select id,username,first_name,last_name from `tbl_users` where is_blocked=1 && status=1 && login_type='android' LIMIT 200";
    $query2 = $CI->db->query($sql);
     if ($query2->num_rows() > 0) {
        $data2 = $query2->result();
        return $data2;
    }
}

function getUsers_ios($notificationID = '') {
     $CI = & get_instance();
     $sql = "select id,username,first_name,last_name from `tbl_users` where is_blocked=1 && status=1 && login_type='ios' LIMIT 200";
    $query2 = $CI->db->query($sql);
     if ($query2->num_rows() > 0) {
        $data2 = $query2->result();
        return $data2;
    }
}
function getNotificationUsers($notificationID = '') {
    $CI = & get_instance();
    $where = '';
    if ($notificationID != '') {
        $where = " AND id=" . $notificationID . "";
    }
    $sql = "select *  from `tbl_notificationid` where 1=1 " . $where;
    $query = $CI->db->query($sql);


    //pr(  $query );die;
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function get_PincodeArray() {
    $CI = & get_instance();
    $where = "";
    $sql = "select *  from `tbl_pincode_array` where 1=1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function searchRefinebycatproCount($searchkey, $category = '') {
    $CI = & get_instance();
    $where = '';
    $CI->db->select('*,IF(category_name LIKE "' . $searchkey . '%",  20, IF(category_name LIKE "%' . $searchkey . '%", 15, 0)) + IF(product_name LIKE "%' . $searchkey . '%", 10,  0) + IF(brand_name  LIKE "%' . $searchkey . '%", 5,  0) + IF(product_name LIKE "%Modern%", 3,  0) AS weight', false);
    if ($searchkey != '') {

        $CI->db->where('( parent_category LIKE "%' . $searchkey . '%"  OR category_name LIKE "%' . $searchkey . '%" OR product_name LIKE "%' . $searchkey . '%" OR brand_name  LIKE "%' . $searchkey . '%")');
    }

    if ($category != '') {
        $CI->db->where_in('category_id', $category);
    }

    $CI->db->group_by('product_id');
    $CI->db->order_by('weight', 'desc');

    $query = $CI->db->get('tbl_search');
    //-------------------------
    //echo $CI->db->last_query();
    $data = $query->result();
    return count($data);
}

##Get Brand List from Categories

function getBrandsbycategory($category_id = "", $limit = "", $start = "", $counts = "", $status = "") {
    $CI = & get_instance();
    if ($limit != "" || $start != "") {
        $CI->db->limit($limit, $start);
    }
    $category_id = strlen($category_id) > 1 ? explode(',', $category_id) : $category_id;
    $CI->db->select('tbl_product.brand_name');
    $CI->db->join('tbl_product', 'interface_procategories.product_id=tbl_product.product_id', 'left');
    $CI->db->where('tbl_product.product_status', 'Enable');
    $CI->db->where_in('interface_procategories.sub_category_id', $category_id);
    $CI->db->where("tbl_product.product_name <> ", 'Modern');
    $CI->db->where("tbl_product.product_name <>", 'Bazaar');
    $CI->db->group_by('tbl_product.brand_name');
    $CI->db->order_by("tbl_product.product_name", "asc");
    $CI->db->order_by('tbl_product.product_id', 'desc');
    $query = $CI->db->get('interface_procategories');
    //pr($CI->db->last_query()); die;
    $total = $query->num_rows();
    if ($counts != "") {
        return $total;
    } else {
        if ($total > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
    return false;
}

##GET Categories on brands

function getCategoriesbybrand($mainCat = "", $brand_id = "") {
    $CI = & get_instance();
    //$brand_id=strlen($brand_id)>1?explode(',',$brand_id):$brand_id;
    //pr($brand_id);
    if ($brand_id != "") {
        $where .= " AND `tbl_product`.brand_name IN (" . $brand_id . ")";
    }
    if ($mainCat != '') {
        $maincategory = " AND `tbl_categories`.`parent_id`=$mainCat";
    } else {
        $maincategory = '';
    }

    $sql = "select `tbl_product`.`product_id`,`tbl_product`.`product_name`,`tbl_product`.`brand_name`,`interface_procategories`.`sub_category_id`,`tbl_categories`.`name` from `tbl_product`";
    $sql .= "inner join `interface_procategories` on `interface_procategories`.`product_id` = `tbl_product`.`product_id` INNER JOIN  `tbl_categories` ON  `tbl_categories`.`id` =  `interface_procategories`.`sub_category_id` " . $maincategory . " and `tbl_product`.`product_status`='Enable' and `tbl_categories`.`status`='Active' " . $where . " group by interface_procategories.sub_category_id  order by `tbl_categories`.`name` ASC";
    $query = $CI->db->query($sql);
    return $query->result();
}

function getBrandBycategorysearch($keyword = '', $category_id = "") {
    $CI = & get_instance();
    $category_id = strlen($category_id) > 1 ? explode(',', $category_id) : $category_id;
    $CI->db->select('tbl_product.brand_name');
    $CI->db->from('tbl_product');
    $CI->db->join('interface_procategories', 'interface_procategories.product_id = tbl_product.product_id');
    $CI->db->join('tbl_categories', 'tbl_categories.id = interface_procategories.sub_category_id');
    if ($keyword != '') {
        $CI->db->like('tbl_product.product_name', $keyword);
    }

    if ($category_id != '') {
        $CI->db->where_in('interface_procategories.sub_category_id', $category_id);
    }
    $CI->db->where('tbl_product.product_status', 'Enable');
    $CI->db->group_by('tbl_product.brand_name');
    $query = $CI->db->get();
    //pr($CI->db->last_query());
    return $query->result();
}

function getCategoryBybrandsearch($keyword = '', $brand_id = "") {
    $CI = & get_instance();
    $brand_id = strlen($brand_id) > 1 ? explode(',', $brand_id) : $brand_id;
    $CI->db->select('`interface_procategories`.`sub_category_id`,`tbl_categories`.`name`');
    $CI->db->from('tbl_product');
    $CI->db->join('tbl_brand', 'tbl_brand.brand_id = tbl_product.brand_name');
    $CI->db->join('interface_procategories', 'interface_procategories.product_id = tbl_product.product_id');
    $CI->db->join('tbl_categories', 'tbl_categories.id = interface_procategories.sub_category_id');
    if ($keyword != '') {
        $CI->db->like('tbl_product.product_name', $keyword);
    }

    $CI->db->where('tbl_product.product_status', 'Enable');
    $CI->db->where('tbl_categories.status', 'Active');
    if ($brand_id != "") {
        $CI->db->where_in('tbl_product.brand_name', $brand_id);
    }
    $CI->db->group_by('`interface_procategories`.`sub_category_id`');
    $query = $CI->db->get();
    //echo $CI->db->last_query();die;
    return $query->result();
}

#Check user logged in and update user location with current selected location.

function updateUserlocation() {
    $CI = & get_instance();
    $user_login = $CI->session->userdata('auth_user');
    if (isset($user_login) && !empty($user_login)) {
        $users_id = $user_login['users_id'];
        $data_store = $CI->session->userdata('storedate_user');
        $userDetails = getUsers($users_id);
        if (!empty($userDetails) && count($userDetails) > 0) {
            // $latitude=$userDetails[0]->longitude;
        }
    }
}

function checkUserlocationinDB() {
    $CI = & get_instance();
    $user_login = $CI->session->userdata('auth_user');
    if (isset($user_login) && !empty($user_login)) {
        $users_id = $user_login['users_id'];
        $sql = "select * from `tbl_userlocations` where 1 AND uid=" . $users_id . " order by `id`";
        $query = $CI->db->query($sql);
        $data = $query->result();
    }
    return getUserLocationfromDB;
}

function getUserLocationfromDB($uid = '') {
    $CI = & get_instance();

    /*if($CI->cache->file->get('all_location_cache')){
             $__result =  $CI->cache->file->get('all_location_cache');

            // pr($__result);die;

            return $__result;
        }*/
    $data = '';
    if ($uid != '') {
        $sql = "SELECT * FROM `tbl_userlocations` where 1=1 AND uid=" . $uid . " order by `id` LIMIT 1";
        $query = $CI->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();

            // $CI->cache->file->save('user_location_cache', $result, CACHE_EXPIRE);
        }
    }
    return $data;
}

function checkloggedCart() {
    $cart = array();
    if (isset($user_login) && !empty($user_login)) {
        $users_id = $user_login['users_id'];
        $checkcart = checkcart($users_id);
        $dbcartitems = explode(',', $checkcart[0]->weight_id);
        $dbcartqnty = explode(',', $checkcart[0]->qnty);
        $dbcartcount = sizeof($dbcartitems) - 1;
        for ($i = 0; $i < $dbcartcount; $i++) {
            $cart[$dbcartitems[$i]] = $dbcartqnty[$i];
        }
    } else {
        #Read saved cart items cookie
        $cookie = $_COOKIE['cart_items_cookie'];
        $cookie = stripslashes($cookie);
        $cart = json_decode($cookie, true);
    }
    return $cart;
}

function getOrderAmount($orderno = NULL) {
    $orderdata = array();
    if(isset($orderno) && !empty($orderno))
    {
        $CI = & get_instance();

        $sql = "SELECT * FROM `tbl_order` WHERE `tbl_order`.`id` =  " . $orderno . " ";
        $query = $CI->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $product_name_list = explode(",", $data[0]->product_name);
            $unit_price = explode(",", $data[0]->unit_price);
            $product_qty = explode(",", $data[0]->product_qty);
            $p_status = explode("~", $data[0]->p_status);
            $p_reason = explode("~", $data[0]->p_reason);
            $removedproductamt = 0;
            $itemscount = 0;
            for ($i = 0; $i < sizeof($product_name_list) - 1; $i++) {
                if ($p_status[$i] != '') {
                    $removedproductamt += $unit_price[$i] * $product_qty[$i];
                    $itemscount--;
                }
                $itemscount++;
            } //Product items loop
            $orderdata['totalitems'] = $itemscount;
            if ($removedproductamt != 0) {
                $orderdata['ordertotal'] = $data[0]->paymoney - $removedproductamt;
            } else {
                $orderdata['ordertotal'] = $data[0]->paymoney;
            }
        }

    }
    return $orderdata;
}

function checkUserLogin() {
    $CI = & get_instance();
    if ($CI->session->userdata('auth_user') != NULL) {
        $user_login = $CI->session->userdata('auth_user');
        if (isset($user_login) && !empty($user_login)) {
            $users_id = "yes";
        } else {
            $users_id = '';
        }
    } else {
        $users_id = '';
    }

    return $users_id;
}
function isUserLogin() {
    $CI = & get_instance();
    if ($CI->session->userdata('auth_user') == NULL) {
        redirect('/');
    }
}
function isUserOrAdminLogin() {
    $CI = & get_instance();
    if ($CI->session->userdata('auth_user') == NULL && $CI->session->userdata('system_admin') == NULL) {
        redirect('/');
    }
    if($CI->session->userdata('auth_user')!=NULL){
        $buyer_user = $CI->session->userdata('auth_user');
        if(isset($_SESSION['auth_user']['parent_id']) && $_SESSION['auth_user']['parent_id'] != '') {
            $user_id    = $buyer_user['parent_id'];
        } else {
            $user_id    = $buyer_user['users_id'];
        }


        $CI->db->from("buyer_details");
        $CI->db->where("user_id", $user_id);
        $buyer_details = $CI->db->get()->row();
        $form_status = true;
        $payment_status = true;
        if($buyer_details->tab1_status==1){
            if($buyer_details->tab2_status==1){
                if($buyer_details->tab3_status==1){
                    if($buyer_details->tab4_status==1){
                        if($buyer_details->status==1){
                            if($buyer_details->payment_status==2){
                                $payment_status = false;
                            }
                        }else{
                            $form_status = false;
                        }
                    }else{
                        $form_status = false;
                    }
                }else{
                    $form_status = false;
                }
            }else{
                $form_status = false;
            }
        }else{
            $form_status = false;
        }

        if($form_status == false){
            redirect(base_url('buyer/index/' . $user_id));
        }
        if($payment_status == false){
            redirect(base_url('buyer/payment'));
        }
    }
}

function getBuyerFormDetails() {
    $CI = & get_instance();
    if($CI->session->userdata('auth_user')!=NULL){
        $buyer_user = $CI->session->userdata('auth_user');
        $user_id    = $buyer_user['users_id'];

        $CI->db->from("buyer_details");
        $CI->db->where("user_id", $user_id);
        $buyer_details = $CI->db->get()->row();
        return $buyer_details;
    }else{
        // redirect('/');        
    }
}

function productgetCategory($parent_id = "", $id = "", $no_parent = "", $featured = "", $limit = "", $url = "", $header_menu_limit = "", $menu_show = "", $header_menu = "", $footer_menu = "") {
    $CI = & get_instance();
    $where = "";
    if (is_numeric($parent_id)) {
        $where .= " AND `tbl_categories`.`parent_id` = '" . $parent_id . "'";
    }

    if (is_numeric($no_parent)) {
        $where .= " AND `tbl_categories`.`parent_id` != '" . $parent_id . "'";
    }

    if ($id != "") {
        $where .= " AND `tbl_categories`.`id` = '" . $id . "'";
    }
    if ($url != "") {
        $where .= " AND `tbl_categories`.`url_name` = '" . $url . "'";
    }

    if ($featured != "") {
        $where .= " AND `tbl_categories`.`featured` = '" . $featured . "'";
    }
    if ($menu_show != "") {
        $where .= " AND `tbl_categories`.`menu_show` = '" . $menu_show . "'";
    }
    if ($header_menu != "") {
        $where .= " AND `tbl_categories`.`header_menu` = '" . $header_menu . "'";
    }
    if ($footer_menu != "") {
        $where .= " AND `tbl_categories`.`footer_menu` = '" . $footer_menu . "'";
    }
    $where .= " AND status = 'active' order by  `tbl_categories`.`sort_order` ASC";

    if ($limit != "") {
        $where .= " limit 0, " . $limit . "";
    }
    $sql = "select `tbl_categories`.* from `tbl_categories` where 1=1 " . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function getProductEanAndMrp($price_id) {
    $CI = & get_instance();
    $where = "";
    if ($price_id != "") {
        $where .= " WHERE `tbl_product_price`.`id` = '" . $price_id . "'";
    }
    $sql = "select tbl_product_price.ean_code,tbl_product_price.product_price from `tbl_product_price`" . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getProductName($product_id) {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " WHERE `tbl_product`.`product_id` = '" . $product_id . "'";
    }
    $sql = "select tbl_product.product_name from `tbl_product`" . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}
function getProductStatus($product_id) {
    $CI = & get_instance();
    $where = "";
    if ($product_id != "") {
        $where .= " WHERE `tbl_product`.`product_id` = '" . $product_id . "'";
    }
    $sql = "select tbl_product.product_status from `tbl_product`" . $where . "";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->row();
        return $data->product_status;
    }
    return false;
}

function getCategoryName($category_id = '') {
    $CI = & get_instance();

    //$sql = "select tbl_categories.name,tbl_categories.url_name,tbl_categories.parent_id from `tbl_categories`" . $where . "";
    //---------------
    $CI->db->select("c.name,c.url_name,c.category_menu_banner,c.category_banner,c.app_landing_page,c.web_landing_page,c.parent_id,c.id");

    if ($category_id != "") {
        $CI->db->where_in("c.id", $category_id);
    }
    $query = $CI->db->get("tbl_categories as c");
    //------------------

    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function getCategoryList($category_id = '') {
    $CI = & get_instance();
    $CI->db->select("c.name,c.url_name,c.parent_id,c.id,c1.name as parent_name");
    $CI->db->join("tbl_categories as c1", " c1.id=c.parent_id", "left");
    if ($category_id != "") {
        $CI->db->where_in("c.id", $category_id);
    }
    $CI->db->order_by('c1.name');

    $query = $CI->db->get("tbl_categories as c");

    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}
function getBrandList($brand_id = '') {
    $CI = & get_instance();
    $CI->db->select("c.brand_name,c.brand_id");
    if ($brand_id != "") {
        $CI->db->where_in("c.brand_id", $brand_id);
    }
    $CI->db->order_by('c.brand_name');

    $query = $CI->db->get("tbl_brand as c");

    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

//---------
function getProductByPricesddshubh($id = "") {
    $CI = & get_instance();
    $where = "";

    if ($id != "") {
        $where .= "AND tbl_product_price.id = '" . $id . "'";
    }

    $sql = "select * from `tbl_product_price` inner join `tbl_product` on `tbl_product`.`product_id` = `tbl_product_price`.`product_id` where 1 " . $where;
    $query = $CI->db->query($sql);
    $data = $query->result();
    return $data;
}

function getdeviceBymultipleusers($id) {
    $CI = & get_instance();
    $where = "";
    if ($id != "") {
        $where .= "where tbl_notificationid.device_type IN($id)";
    }
    $sql = "select * from `tbl_notificationid` " . $where;
    $query = $CI->db->query($sql);
    // echo $CI->db->last_query();
    // die;
    $data = $query->result();
    return $data;
}

function getdevice($devices) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_notificationid');
    $CI->db->where_in('tbl_notificationid.device_type', $devices);
    $query = $CI->db->get();
    return $query->result();
}


function checkOrderNumber($ordernumber) {
    $CI = & get_instance();
    $sql = "select * from `tbl_order` WHERE order_number='" . $ordernumber . "' LIMIT 1";
    $query = $CI->db->query($sql);
    if ($query->num_rows() > 0) {
        //$data = $query->result();
        return 1;
    } else {
        return 0;
    }
}

function checkposOrderNumber($ordernumber) {
    $CI = & get_instance();
    $sql = "select * from `tbl_po_order` WHERE order_number='" . $ordernumber . "' LIMIT 1";
    $query = $CI->db->query($sql);
    if ($query->num_rows() > 0) {
        //$data = $query->result();
        return 1;
    } else {
        return 0;
    }
}

function getImageAll() {
    $CI = & get_instance();
    $where = "";
    $sql = "select img_1  from `tbl_interface_product_images` where 1=1";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

function checkInventoryBypriceid($priceid, $storeid) {
    $CI = & get_instance();
    if ($priceid != '' && $priceid > 0 && $storeid != '' && $storeid > 0) {
        $sql = "SELECT `tbl_inventory`.*, `tbl_product_price`.* FROM `tbl_inventory`, `tbl_product_price` WHERE 1 = 1 AND `tbl_inventory`.`priceid` = `tbl_product_price`.`id` AND `tbl_product_price`.`id` = " . $priceid . " AND `tbl_inventory`.`store_id` = " . $storeid . "";
        $query = $CI->db->query($sql);
        $data = "";
        if ($query->num_rows() > 0) {
            //$data = $query->result();
            return $query->num_rows();
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function getCartfinalAmount($saved_cart_items) {
    $CI = & get_instance();
    if ($CI->session->userdata('promocode') != '') {
        $promo = $CI->session->userdata('promocode');
        if ($promo != '') {
            $validatepromo = validatepromo3($promo, $saved_cart_items);
            if (count($validatepromo) > 0) {
                if ($validatepromo['status'] == 'pass') {
                    $cart_subtotal = $validatepromo['cart_subtotal'];
                    $paymoney = $validatepromo['paymoney'];
                    $shipping_charges = $validatepromo['shipping_charges'];
                    $total_discount = $validatepromo['total_saving'];
                    $promo_discount = $validatepromo['promodiscount'];
                }
            }
        }
        return $paymoney;
    } else {
        $getcart = getcartByarray($saved_cart_items);
        $cart_subtotal = $getcart['cart_subtotal'];
        $cart_subtotal_discount = $getcart['total_discount'];
        $totalitems = $getcart['total_items'];
        $ship = shippingCharges($cart_subtotal);
        $shipping_charges = $ship['shipping_charges'];
        $paymoney = number_format($ship['paymoney'], '2', '.', '');
        return $paymoney;
    }
}

/**
 * cache_opration
 *
 * This function set cache data in variable Or get variable value
 *
 * @access  public
 * @return  boolean
 */
if (!function_exists('cache_opration')) {

    function cache_opration($option = '', $var = '', $val = '') {
        $CI = &get_instance();
        //CACHE_EXPIRE
        // $CI->load->driver('Cache/drivers/cache_file', array('adapter' => 'apc', 'backup' => 'file'));
        if ($option == 'set') {
            $CI->cache->file->save($var, $val, CACHE_EXPIRE);
        } else if ($option == 'get') {
            return $CI->cache->file->get($var);
        } else if ($option == 'delete') {
            return $CI->cache->file->delete($var);
        } else {
            return false;
        }
    }

}

#Check Stock In Store by Weight and Store ID

function is_OutOfStock($store_id = "", $product_id = '', $pid = '') {
    $CI = & get_instance();
    if ($store_id != '' && $weight_id != '') {
        $sql = "SELECT * FROM tbl_inventory WHERE priceid=" . $pid . " AND store_id=" . $store_id . " AND product_id=" . $product_id . "";
        $query = $CI->db->query($sql);
        $data = $query->result();
        return $data;
    }
}

function checkCartItem($users_id = '', $mid = '', $pweight = '') {
    $data = '';
    $CI = & get_instance();
    $CI->db->select("weight_id,qnty");
    if ($users_id == '' && $mid != '') {
        $CI->db->where("mobile_id", $mid);
    } else {
        if ($users_id != '') {

            $CI->db->where("user_id", $users_id);
        }
        if ($mid != '') {
            $CI->db->where("mobile_id", $mid);
        }
    }
    $CI->db->where("FIND_IN_SET('" . $pweight . "',weight_id)>0");

    $query = $CI->db->get("tbl_activecart");
    if ($query->num_rows()) {
        $data = $query->row();
    }

    return $data;
}

function checkStock($store_id = "", $weight_id = "") {
    $data   = '';
    $CI     = & get_instance();
    if (isset($weight_id) && !empty($weight_id)) {
        $CI->db->select("id,store_id, qnty_type, qnty, priceid");
        $CI->db->where_in('priceid', $weight_id);
        // $CI->db->where('store_id', $store_id);//comment by ravindra
        $CI->db->group_by('priceid','store_id');
        $query = $CI->db->get("tbl_inventory");
        if ($query->num_rows()) {
            if (is_array($weight_id) && count($weight_id)) {
                $data = $query->result();
            } else {
                $data = $query->row();
            }
        }else{
            return false;
        }
    }
    return $data;
}
/*function checkStock($store_id = "", $weight_id = "") {
    $data   = '';
    $CI     = & get_instance();
    if (isset($store_id) && !empty($store_id) && isset($weight_id) && !empty($weight_id)) {
        $CI->db->select("id,store_id, qnty_type, qnty, priceid");
        $CI->db->where_in('priceid', $weight_id);
        $CI->db->where('store_id', $store_id);
        $CI->db->group_by('priceid','store_id');
        $query = $CI->db->get("tbl_inventory");
        if ($query->num_rows()) {
            if (is_array($weight_id) && count($weight_id)) {
                $data = $query->result();
            } else {
                $data = $query->row();
            }
        }else{
            return false;
        }
    }
    return $data;
}*/

function checkStock_api($store_id = "", $weight_id = "") {
    $data = '';
    $CI = & get_instance();
    if ($store_id != '' && $weight_id != '') {
        // $sql="SELECT qnty_type,qnty FROM tbl_inventory WHERE priceid=".$weight_id." AND store_id=".$store_id." order by id DESC LIMIT 1";
        $CI->db->select("qnty_type,qnty,priceid");
        $CI->db->where('priceid', $weight_id);
        $CI->db->where('store_id', $store_id);
        $query = $CI->db->get("tbl_inventory");
        //echo $CI->db->last_query;

        if ($query->num_rows()) {
            if (is_array($weight_id) && count($weight_id)) {
                $data = $query->result();
            } else {
                $data = $query->row();
            }
        }else{
            return false;
        }
    }
    return $data;
}


function cartItemDetails($option = array()) {
    $data = '';
    $CI = & get_instance();
    $CI->db->select("pp.id,pp.product_price,pp.product_pec_weight,pp.product_s_price,p.product_name,p.product_image,p.product_url,p.product_id");
    $CI->db->join("tbl_product as p", "p.product_id=pp.product_id", "left");
    if (isset($option['weight_id']) && $option['weight_id'] != '') {
        $CI->db->where_in('id', $option['weight_id']);
    }

    $query = $CI->db->get("tbl_product_price as pp");
    if ($query->num_rows()) {
        $data = $query->result();
    }
    return $data;
}

function getNotificationIdByUserId($user_id = '') {
    $data = '';
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->where('user_id', $user_id);
    $query = $CI->db->get("tbl_notificationid");
    if ($query->num_rows()) {
        $data = $query->result();
    }
    return $data;
}

/* End of Function */

function saveOrderDetail11() {
    $CI = & get_instance();
    // $CI->db->select("id,user_id,product_name,product_id,product_weight,pweight,unit_price,product_qty,act_price,ean_code,order_date");
    $sql1 = "SELECT id,user_id,product_name,product_id, product_weight, pweight,unit_price,product_qty, act_price, ean_code, order_date FROM tbl_order WHERE order_date> '2017-09-29 11:55:55' and order_date< '2017-10-03 13:33:53'";
    $query = $CI->db->query($sql1);

    if ($query->num_rows()) {
        $result = $query->result();
        foreach ($result as $row) {
            $data = array();

            $product_name = explode(',', $row->product_name);
            $product_ids = explode(',', $row->product_id);
            $product_weight = explode(',', $row->product_weight);
            $pweight = explode(',', $row->pweight);
            $unit_price = explode(',', $row->unit_price);
            $product_qty = explode(',', $row->product_qty);
            $act_price = explode(',', $row->act_price);
            $ean_code = explode(',', $row->ean_code);

            $i = 0;
            $data = array();
            foreach ($product_ids as $product_id) {

                if ($product_id != '') {
                    $sql = "INSERT INTO tbl_order_detail set order_id =$row->id";
                    $sql .= ",user_id='$row->user_id'";
                    $sql .= ",product_id = '$product_id'";
                    $sql .= ",product_weight_id = '$product_weight[$i]'";
                    $sql .= ",pweight = '$pweight[$i]'";
                    $sql .= ",unit_price = '$unit_price[$i]'";
                    $sql .= ",product_qty = '$product_qty[$i]'";
                    $act_price[$i] = ($act_price[$i]) ? $act_price[$i] : '0';
                    $sql .= ",act_price = '$act_price[$i]'";
                    $ean_code[$i] = ($ean_code[$i]) ? $ean_code[$i] : '';
                    $sql .= ",ean_code = '$ean_code[$i]'";
                    $sql .= ",created_date = '$row->order_date'";

                    $CI->db->query($sql);
                }
                $i++;
                echo "update successfully" . $row->id . '<br>';
            }
        }
    }
}

/* call api using curl */

if (!function_exists('call_api')) {

    function call_api($postData, $api_url = '') {
        $CI = &get_instance();
        $url = $api_url;
        $ch = curl_init();  // create a new cURL resource


        if (isset($postData['headers']) && $postData['headers'] != '' && $postData['is_header'] == '1') {

            curl_setopt_array($ch, array(
                CURLOPT_HTTPHEADER => $postData['headers'],
                CURLOPT_USERPWD => $postData['USERPWD'],
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData['postData'],
                CURLOPT_TIMEOUT => 500,
                CURLOPT_FOLLOWLOCATION => true));
        } else {
            curl_setopt_array($ch, array(
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData['postData'],
                CURLOPT_TIMEOUT => 500,
                CURLOPT_FOLLOWLOCATION => true));
        }


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);   // grab URL and pass it to the browser

        if (curl_errno($ch)) {
            // echo 'error:' . curl_error($ch);
        }
        curl_close($ch);    // close cURL resource, and free up system resources
        return $output;
    }

}
/* End of Function */

function get_storeData($store_id) {
    $data = '';
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->where('store_id', $store_id);
    $query = $CI->db->get("tbl_store");
    if ($query->num_rows()) {
        $data = $query->row();
    }
    return $data;
}

// Function to return the JavaScript representation of a TransactionData object.
function getTransactionJs($trans) {
    return <<<HTML
ga('ecommerce:addTransaction', {
  'id': '{$trans['order_id']}',
  'affiliation': '{$trans['store_name']}',
  'revenue': '{$trans['paymoney']}',
  'shipping': '{$trans['shipping_charges']}',
  'tax': '{$trans['tax']}',
  'currency': 'INR'
});
HTML;
}

// Function to return the JavaScript representation of an ItemData object.
function getItemJs($transId, $item) {
    return <<<HTML
ga('ecommerce:addItem', {
  'id': '$transId',
  'name': '{$item['name']}',
  'sku': '{$item['sku']}',
  'category': '{$item['category']}',
  'price': '{$item['price']}',
  'quantity': '{$item['quantity']}',
  'currency': 'INR'
});
HTML;
}

/*

 * This function fatch parent category data by Sub category id */

function get_parentBySubCategoryId($id = '') {
    $data = '';
    $CI = & get_instance();
    $CI->db->select("c1.id,c1.name,c2.id as parent_id,c2.id as parent_id,c2.name as parent_name");
    $CI->db->join("tbl_categories as c2", "c1.parent_id=c2.id", "left");
    $CI->db->where('c1.id', $id);
    $query = $CI->db->get("tbl_categories as c1");
    if ($query->num_rows()) {
        $data = $query->row();
    }
    return $data;
}

/*

 * End Finction */

/*

 * This function fatch parent category data by Sub category id */

function get_productImage($product_id = '') {
    $product_image = '';
    $CI = & get_instance();
    $CI->db->select("p.product_image");
    $CI->db->where('p.product_id', $product_id);
    $query = $CI->db->get("tbl_product as p");
    if ($query->num_rows()) {
        $product_image = $query->row()->product_image;
    }
    return $product_image;
}

/*

 * End Finction */
//SELECT parent_id FROM tbl_categories where id IN (184,186,17,35) and parent_id>0 group by parent_id

function get_parentIdsBySubcategories($subIds=array()){
    $CI = & get_instance();
    if(is_array($subIds) && count($subIds)){
       $CI->db->select("c.parent_id");
       $CI->db->where_in('c.id',$subIds);
       $CI->db->where("c.parent_id>0");
       $CI->db->group_by("c.parent_id");
       $query = $CI->db->get("tbl_categories as c");
       if($query->num_rows()){
           $rs_data['result']  =   $query->result();
           $rs_data['status']  =   "success";
       }else{
           $rs_data['status']  =   "error";
       }
    }else{
        $rs_data['status']  =   "error";
    }
    return $rs_data;
}

function getCategoryInfoById($id = "") {
    $CI = & get_instance();

    if($id!=''){
       $CI->db->select("c.*");
       $CI->db->where('c.id',$id);
       $query = $CI->db->get("tbl_categories as c");
       if($query->num_rows()){
           $rs_data['result']  =   $query->row();
           $rs_data['status']  =   "success";
       }else{
           $rs_data['status']  =   "error";
       }
    }else{
        $rs_data['status']  =   "error";
    }
    return $rs_data;
}

function getUsersDevices($devices) {
    $CI = & get_instance();
    $CI->db->select("id,(case when user_id=0 then concat('Device','-',mobile_id) else (select username from tbl_users as u where u.id=n.user_id) end) as user_name",false);

    $CI->db->where_in('n.device_type', $devices);
    $query  =   $CI->db->get("tbl_notificationid as n");

    if($query->num_rows()){
        $rs_data['result']  =   $query->result_array();
        $rs_data['status']  =   "success";
    }else{
        $rs_data['status']  =   "error";
    }

   return $rs_data;
}

function getDeviceDetail($mobile_id = '') {
    $CI = & get_instance();
    $where = '';
    if ($mobile_id != '') {
        $where = " AND mobile_id='". $mobile_id ."'";
    }
    $sql = "select *  from `tbl_notificationid` where 1=1 " . $where;
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return $data;
}

function getLastOrderTimeDiffrence($user_id){
    $CI             = & get_instance();
    $cdate          = date('Y-m-d');
    $sql            = "SELECT order_date FROM `tbl_order` where user_id='$user_id' AND DATE(order_date)='$cdate' ORDER BY `id` DESC LIMIT 1 ";
    $query          = $CI->db->query($sql);

    $datetime1      = new DateTime();
    if($query->num_rows()>0){
        $data       = $query->row()->order_date;
        $datetime2  = new DateTime($data);
        $interval   = $datetime1->diff($datetime2);
        $hours      =   $interval->format('%h');
        $minutes    =   $interval->format('%i');
        $second     =   $interval->format('%s');

        if($hours==0 && $minutes==0 && $second<=15){
            return FALSE;
        }else{
            return TRUE;
        }

    }else{
        return TRUE;
    }

}

function getTimeLimitById($id="") {
    $CI = & get_instance();
    $CI->db->select('status');
    $CI->db->where('id',$id);
    $result = $CI->db->get('tbl_timeslot')->row();
    if(!empty($result->status)){
        $status_array = explode(',',$result->status);
    }

    $status = 'Active';
    $CI->db->select('*');
    $CI->db->where('id',$id);
    $CI->db->where("FIND_IN_SET('".$status."',status) !=",0);
    $result1 = $CI->db->get('tbl_timeslot');

    $data = "";
    if ($result1->num_rows() > 0) {
        $data = $result1->row();
    }
    return $data;
}

function get_allCategories(){
    $data   =   '';
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->where('status','Active');
    $CI->db->where('name!=','Special Offers');
    $CI->db->order_by('sort_order','asc');

    $query=$CI->db->get("tbl_categories");
    if($query->num_rows()>0){
        $data = $query->result();
    }
    return $data;
}

function get_allBanners(){
    $data   =   '';
    $CI = & get_instance();
    $CI->db->select("b.*");
    $CI->db->where('b.status','1');
    $CI->db->order_by('b.sort_order','asc');
    $query=$CI->db->get("tbl_banner as b");
    if($query->num_rows()>0){
        $data = $query->result();
    }
    return $data;
}
function get_allOfferBanners_byCat($category_id=1,$bn_type) {
    //echo $category_id . '' .$bn_type;
    $CI = & get_instance();
    if($CI->cache->file->get($bn_type.'_offer_banner_'.$category_id))
    {
        return $CI->cache->file->get($bn_type.'_offer_banner_'.$category_id);
    }
    $where = '';
    if($bn_type == 'subcategory'){
        $where = "where tbl_offer_banner.subcat_id =".$category_id." ";
    }else{
        $where = "where tbl_offer_banner.cat_id =".$category_id." ";
    }
    $where .= " AND tbl_offer_banner.banner_type = '".$bn_type."'";
    $where .= " AND tbl_offer_banner.status = 1";
    $sql = "select tbl_offer_banner.banner_position ,banner_url,image from  tbl_offer_banner " . $where . " order by `order_no` ASC";

    $query = $CI->db->query($sql);
    // pr($CI->db->last_query());die;
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result_array();
    }
    $CI->cache->file->save($bn_type.'_offer_banner_'.$category_id,$data,CACHE_EXPIRE);
    return $data;
}

function get_allOfferBanners() {
    $CI = & get_instance();
    $where = '';
    $where .= " AND tbl_offer_banner.status = '1'";
    $sql = "select tbl_offer_banner.* from  tbl_offer_banner where 1 " . $where . " order by `order_no` ASC";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

function get_allBrands(){
    $data   =   '';
    $CI = & get_instance();
    $CI->db->select("b.*");
    $CI->db->where('b.status','1');
    $CI->db->order_by('b.international_order_no','asc');
    $query=$CI->db->get("tbl_brand as b");
    if($query->num_rows()>0){
        $data = $query->result();
    }
    return $data;
}

function get_allProductsList(){
    $data   =   '';
    $CI = & get_instance();
    $CI->db->select("p.product_metatitle,p.product_metakeyword,p.product_metadescription,p.product_id,p.product_image,p.product_code,p.product_s_desc,p.product_name,p.product_url,p.product_type,p.brand_name,p.product_status,p.category_ids,p.weight_ids as weight_id,p.product_prices as product_price,p.product_pec_weights as product_pec_weight,p.product_s_prices as product_s_price,,CONVERT(p.product_prices, DECIMAL) as price",false);

    $CI->db->where("p.product_status='Enable'");
    $CI->db->order_by('p.product_id','asc');
    $query=$CI->db->get("tbl_product as p");
    if($query->num_rows()>0){
        $data = $query->result();
    }
    return $data;
}

function send_mailChimpSubcription($data=array()){
    $CI = & get_instance();
    $CI->load->library('My_MailChimp');
    $api_key    =   MailChimp_API_KEY;
    $list_id    =   MailChimp_LIST_ID;

    $MailChimp = new MailChimp($api_key,$list_id);
    $rs_data    =   $MailChimp->setUserData($data);
    return $rs_data;

}

    // function getDiscountOnProductForListing($pid,$minunit=0,$price=1,$store=0,$user_id=0)
    function getDiscountOnProduct_main($product_id,$price,$store_id,$user_id)
    {
        $CI = & get_instance();
        $all_discount_list = getDiscountOnProductForListing($product_id,$price,$store_id,$user_id);
       //pr($all_discount_list);die;
        if(!empty($all_discount_list)){
            $discount_data['discount']          =   $all_discount_list[0]->discountamount;
            $discount_data['discount_type']     =   $all_discount_list[0]->discount_type;
            $discount_data['discount_id']       =   $all_discount_list[0]->id;
            $discount_data['discount_title']    =   $all_discount_list[0]->discount_title;
        }
        else{
            $discount_data = false;
        }
        //pr($all_discount_list);die;
        return $discount_data;
    }

    function get_offer_with_qty($weight_id,$qty){
        $CI = & get_instance();
        $CI->db->select('*');
        $where = "FIND_IN_SET('" . $weight_id . "',`buy_item_product`)>0 and FIND_IN_SET('" . $qty . "',`buy_item_quantity`)>0";
        $CI->db->where("(".$where.")");
        $CI->db->where('status',1);
        $query=$CI->db->get("tbl_offers");
        if($query->num_rows()>0){
            $result = $query->row_array();
        }
        return $result;
    }

    function get_offer_for_all_variant($all_variant, $user_id = ''){

        $CI         = & get_instance();
        $result1    = [];

        $date       = date('Y-m-d H:i:s');
        $where="";
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
        $CI->db->where('status',1);
        $query=$CI->db->get("tbl_offers");

        if($query->num_rows()>0){
            $results = $query->result_array();
            foreach ($results as $key => $result) {
                // pr($result);
                $is_redeemed_offer = chk_redeem_limit($result['buy_item_product'],$user_id,$result['id'],1,$result['redeem_limit']);
                if($is_redeemed_offer)
                {
                    $result1[$key] = $result;

                }
            }
        }
        // pr($result1);die;
        return $result1;
    }

    function get_offer_from_array($weight_id, $all_get_offer){
        $offer1 = '';
        if(is_array($all_get_offer))
        {
            foreach ($all_get_offer as $key => $offer) {
                if($offer['buy_item_product']==$weight_id)
                {
                    if($offer1=='')
                    {
                        $offer1 = $offer;
                    }
                }
            }
        }
        return $offer1;
    }

    function get_offer($weight_id,$user_id = ''){

        $CI         = & get_instance();
        $result1    = '';
        if($user_id==''){
            $user_id    = $CI->session->userdata('auth_user')['users_id'];
        }

        $date       = date('Y-m-d H:i:s');
        $CI->db->select('*');
        $where      = "FIND_IN_SET('" . $weight_id . "',`buy_item_product`)>0  AND '".$date."' BETWEEN valid_from AND valid_to ";
        $CI->db->where("(".$where.")");
        $CI->db->where('status',1);
        $query=$CI->db->get("tbl_offers");

        if($query->num_rows()>0){
            $result = $query->row_array();
            // pr($result);
            $is_redeemed_offer = chk_redeem_limit($result['buy_item_product'],$user_id,$result['id'],1,$result['redeem_limit']);
            if($is_redeemed_offer)
            {
                $result1            = $result;
                $free_item_product  = explode(",", $result['free_item_product']);
                $CI->db->select('p.product_name,p.product_image,pg.image,pp.product_pec_weight');
                $CI->db->join('tbl_product_price as pp','pp.product_id = p.product_id');
                $CI->db->join("tbl_product_gallery as pg","pg.variant_id=pp.id","left");
                $CI->db->where_in("pp.id",$free_item_product);
                $CI->db->group_by("p.product_id");
                $free_offer_data            = $CI->db->get("tbl_product as p")->result_array();
                $result1['free_products']   = $free_offer_data;

                // $qry = "SELECT product_name,product_image FROM `tbl_product` WHERE find_in_set(`weight_ids` ,'".$result['free_item_product']."')";

                // $query = $CI->db->query($qry);
                // foreach($query->result_array() as $pr_data){
                //     $result1['free_products']  = $pr_data['product_name'];
                //     $result1['product_image'][]  = $pr_data['product_image'];
                // }
            }

        }
        // pr($result1);die;
        return $result1;
    }

    function get_flag($country_id){
        $CI = & get_instance();
        $CI->db->select('country_flag');
        $CI->db->where('id',$country_id);
        $query=$CI->db->get("tbl_country");
        if($query->num_rows()>0){
            $result = $query->row_array();
        }
            return $result;
    }

    function  get_splPrice($weight_id){
    $CI = & get_instance();
       $CI->db->select('*');
       $date = date('Y-m-d H:i:s');
       $CI->db->where('tbl_product_price.id', $weight_id);
       $where = "'".$date."' BETWEEN special_price_start_date AND special_price_end_date ";
       $CI->db->where("$where");
       $query = $CI->db->get('tbl_product_price');
       //  pr($CI->db->last_query());die;
        if($query->num_rows()>0){
            $result = $query->row();
            return $result->product_s_price;
        }else{
            return '0.00';
        }


    }
function get_max_distance_for_free_delivery(){
    $CI = & get_instance();
    $shipping = $CI->session->userdata('storedate_user');
    $shipping_distance = $shipping['store_distance'];

    $shipping_details = getShipingOnProduct($shipping_distance);
    $price_from         = '';
    $price_to           = '';
    $shipping_charge    = '';
    if (count($shipping_details) > 0) {
        foreach ($shipping_details as $sc) {
            $range1 = $sc->distancefrom;
            $range2 = $sc->distanceto;
            //if ($shipping_distance >= $range1 && $shipping_distance <= $range2) {
                $lt = explode('~', $sc->lessthan);
                $gt = explode('~', $sc->greaterthan);
                $sp = explode('~', $sc->price);
                $price_from         = $gt[2];
                $price_to           = $lt[2];
                $shipping_charge    = $sp[2];

               /* for ($j = 0; $j < sizeof($gt); $j++) {
                    if ($cart_subtotal >= $gt[$j] && $cart_subtotal <= $lt[$j]) {
                        $shipping_charges = number_format($sp[$j], '2', '.', '');
                        $shipping_amt = $sp[$j];
                        $paymoney = $sp[$j] + $cart_subtotal;
                    } else if ($cart_subtotal > $lt[sizeof($gt) - 1]) {
                        $shipping_charges = 'free';
                        $shipping_amt = 0;
                        $paymoney = $cart_subtotal;
                    }
                }*/
            //}
        }
    }
    $res['price_from'] = $price_from;
    $res['price_to'] = $price_to;
    $res['shipping_charge'] = $shipping_charge;
    return $res;
}



function getOfferBanner() {
    $CI = & get_instance();
    $where = "tbl_offer_banner.category = ".$category;
    $where .= " AND tbl_offer_banner.status = '1'";
    $sql = "select id,image,android_ios_image,offer_name,url_name,catid from  tbl_offer_banner where 1 " . $where . " order by `order_no` ASC limit 5";
    $query = $CI->db->query($sql);
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    //echo $CI->db->last_query(); die;
    return $data;
}
    function getHeaderCart()
    {
        $CI = & get_instance();
        if($CI->session->userdata('auth_user')['users_id'])
        {
            $cartData = (isset($_COOKIE['cart_items_cookie']))?json_decode($_COOKIE['cart_items_cookie']):array();
            return $cartData;
        }
        else{
            return array();
        }
    }

    function getStoreData($id = NULL){
        $CI = & get_instance();
        // $CI->db->select('store_id,store_name,store_address');
        $CI->db->where('store_status',1);
        if(isset($id) && !empty($id))
        {
            $CI->db->where('store_id', $id);
        }
        $query=$CI->db->get("tbl_store");
        if($query->num_rows()>0){
            $result = $query->result_array();
            return $result;
        }else{
            return false;
        }
    }


    function getCustomerAddress($user_id){
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->where('user_id',$user_id);
        $CI->db->where("( addr_type = 'office' OR addr_type = 'home' OR addr_type = 'other' )");
        $CI->db->order_by('id','DESC');
        $CI->db->group_by('addr_type');
        $query=$CI->db->get("tbl_user_address");
        // echo $CI->db->last_query(); die;
        if($query->num_rows()>0){
            $result = $query->result_array();
            return $result;
        }else{
            return false;
        }
    }

    function get_new_order($counts='')
    {
        $CI = & get_instance();
        $CI->db->select('o.order_number,o.pos_id, o.id,o.order_type,u.first_name,u.last_name');
        $CI->db->join("tbl_users as u", 'u.id = o.user_id');
        $CI->db->where("o.order_status", 'Order Confirm');
        $CI->db->where("o.view_status", 2);
        $CI->db->where("o.pos_id", 0);
        $CI->db->order_by("o.id", 'DESC');
        $query = $CI->db->get('tbl_order as o');
        if($counts != "")
        {
            return $query->num_rows();
        }
        else
        {
            return $query->result();
        }
    }

    function call_center_notification() {
        $CI = & get_instance();
        $CI->db->select("manage_ticket.*,TBLU.email_address,TBLU.first_name,TBLU.last_name");
        $CI->db->join('tbl_users as TBLU','TBLU.id = manage_ticket.added_by');
        if(@$_SESSION['system_admin']['groups_id'] != '1' && @$_SESSION['system_admin']['groups_id'] != '4'){
                $assinged_user = @$_SESSION['system_admin']['id'];
                $CI->db->where('assigned_to',$assinged_user);
        }
        $CI->db->group_by('id');
        $CI->db->where('manage_ticket.status_view', 0);
        $query = $CI->db->get('manage_ticket');

        if($counts != "")
        {
            return $query->num_rows();
        }
        else
        {
            return $query->result();
        }
    }

    function change_status($id) {
        $CI = & get_instance();
        $CI->db->select('id, view_status');
        $CI->db->where('id', $id);
        $qry = $CI->db->get('tbl_order');
        if($qry->num_rows() > 0) {
            $view_status = $qry->result();
            if($view_status[0]->view_status == 2) {
                $CI->db->set('view_status', 1);
                $CI->db->where('id', $id);
                $CI->db->update('tbl_order');
            }
        }
    }

    function GetUserStatus($users_id=null){

        if(!empty($users_id))
        {
            $CI = & get_instance();
            $CI->db->select('status, delete_status');
            $CI->db->where('id',$users_id);
            $query=$CI->db->get("tbl_users");
            if($query->num_rows()>0){
                $result = $query->row_array();
                if($result['status']==0 || $result['delete_status']==1)
                {
                    return redirect(base_url('logout'));
                }

            }else{
                return redirect(base_url('logout'));
            }
        }

    }



    function get_product_weight_oncart($product_id,$weight_id){
        $CI = & get_instance();
                $CI->db->select("weight_ids,product_pec_weights");
                $CI->db->from("tbl_product");
                $CI->db->where("product_id",$product_id);
                $CI->db->where("FIND_IN_SET('".$weight_id."',weight_ids) !=",0);
                $query=$CI->db->get()->row();
                // echo $CI->db->last_query();

                $weight = explode(",",$query->weight_ids);
                $product_pec = explode(",",$query->product_pec_weights);
                $key = array_search($weight_id,$weight);
                $data = $product_pec[$key];
        return  $data;
    }
    function get_offer_limit($discount_id){

        $CI = & get_instance();
        $CI->db->select("maxunit");
        $CI->db->from("tbl_discount");
        $CI->db->where("id",$discount_id);
        $CI->db->where("status",'Active');
        $query=$CI->db->get()->row();
        // echo $CI->db->last_query();

        return $query->maxunit;
    }

    function number_of_edit($edited_id) {
        $CI = & get_instance();
        if(@$edited_id){
            $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
            $check_num_edit = $CI->db->select('num_of_edit as num_edit,id')
            ->from("tbl_users_logs")
            // ->where("edited_id",@$edited_id)
            // ->where("edited_by",@$logged_in_added_by)
            ->where("num_of_edit!=",'0')
            ->where("added_id",@$edited_id)
            ->where("added_by",@$logged_in_added_by)
            ->get()->row();
            //pr($check_num_edit);die;
            if(@$check_num_edit->id){
                return $check_num_edit;
            }
            return 0;
        }else{
            return 0;
        }
    }
    function number_of_edit1($edited_id) {
        $CI = & get_instance();
        if(@$edited_id){
            $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
            $check_num_edit = $CI->db->select('num_of_edit as num_edit,id')
            ->from("tbl_settings_logs")
            // ->where("edited_id",@$edited_id)
            // ->where("edited_by",@$logged_in_added_by)
            ->where("num_of_edit!=",'0')
            ->where("added_id",@$edited_id)
            ->where("added_by",@$logged_in_added_by)
            ->get()->row();
            //pr($check_num_edit);die;
            if(@$check_num_edit->id){
                return $check_num_edit;
            }
            return 0;
        }else{
            return 0;
        }
    }
    function number_of_access($edited_id) {
        $CI = & get_instance();
        if(@$edited_id){
            $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
            $check_num_edit = $CI->db->select('num_of_access as num_edit,id')
            ->from("tbl_users_logs")
            // ->where("edited_id",@$edited_id)
            // ->where("edited_by",@$logged_in_added_by)
            ->where("num_of_access!=",'0')
            ->where("added_id",@$edited_id)
            ->where("added_by",@$logged_in_added_by)
            ->get()->row();
            //pr($check_num_edit);die;
            if(@$check_num_edit->id){
                return $check_num_edit;
            }
            return 0;
        }else{
            return 0;
        }
    }
    function user_log_entry($module_name, $action, $user_id,$after_save="",$before_save="") {
        $CI = & get_instance();
        if($module_name=='Admin Users' || $module_name== 'Customers'){
            $table = 'tbl_users';
            $userDetails = getUsers($user_id);
        }else if($module_name=='Pickers'){
            $table = 'tbl_pickers';
            $userDetails= $CI->db->select("first_name,last_name,email as email_address",false)
                            ->from("$table")
                            ->where("id",$user_id)
                            ->get()->result();
        }else if($module_name=='Delivery Boys'){
            $table = 'tbl_delivery_boys';
            $userDetails= $CI->db->select("first_name,last_name,email as email_address",false)
                            ->from("$table")
                            ->where("id",$user_id)
                            ->get()->result();
        }
        $logged_in_added_by = $CI->session->userdata('system_admin')['id'];

                $user_log['module_name'] = @$module_name;
                $user_log['action'] = ucwords($action);
                $user_log['action_time'] = @date('Y-m-d H:i:s');

                if (!empty($userDetails) && count($userDetails) > 0) {
                    $user_log['name'] = @$userDetails[0]->first_name.' '.@$userDetails[0]->last_name;
                    $user_log['email_id'] = @$userDetails[0]->email_address;
                }
        if(@$user_id){
            if(strtolower($action)=='delete'){
                // $user_log['deleted_id'] = @$user_id;
                // $user_log['deleted_by'] = @$logged_in_added_by;
                $user_log['added_id'] = @$user_id;
                $user_log['added_by'] = @$logged_in_added_by;
                $logged_inDetails = getUsers($logged_in_added_by);

                //pr($logged_inDetails);die;
                if (!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                }

            }else if(strtolower($action)=='add'){
                $user_log['added_id'] = @$user_id;
                $user_log['added_by'] = @$logged_in_added_by;
                $logged_inDetails = getUsers($logged_in_added_by);
                if (!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                }
            }else if(strtolower($action)=='account access'){

                // // $user_log['edited_id'] = @$user_id;
                // // $user_log['edited_by'] = @$logged_in_added_by;
                // $user_log['added_id'] = @$user_id;
                // $user_log['added_by'] = @$logged_in_added_by;
                // $logged_inDetails = getUsers($logged_in_added_by);
                // if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                //     $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                //     $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                // }
                //         pr($user_log); die;

################################################################################################################
               $num_edit = number_of_access(@$user_id);
                if($num_edit->id){
                    $number = $num_edit->num_edit;
                    $check_num_edit = $number + 1;

                    // $user_log['added_id'] = @$user_id;
                    // $user_log['added_by'] = @$logged_in_added_by;
                    $user_log_edit['num_of_access'] = @$check_num_edit;
                    //$logged_inDetails = getUsers($logged_in_added_by);
                    // if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    //     $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    // }

                        // pr($num_edit);
                        //  pr($user_log_edit);
                    $CI->db->update('tbl_users_logs',@$user_log_edit,array('id'=>$num_edit->id));
                    //echo $CI->db->last_query();die;
                    $user_edit_detail_data['before_accessed'] = 'Accessed';
                    $user_edit_detail_data['is_changed'] = 1;
                    //    pr($before_save);
                    //    pr($after_save);
                    //    pr($user_edit_detail_data);die;
                        $user_edit_detail_data['edited_id'] = @$user_id;
                        $user_edit_detail_data['edited_by'] = @$logged_in_added_by;
                        $logged_inDetails = getUsers($logged_in_added_by);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $user_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }

                        $user_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_users_logs_detial',@$user_edit_detail_data);

                  //  }
                    return 1;


                }else{
                    $number = 0;
                    $check_num_edit = $number + 1;
                }


                // $user_log['edited_id'] = @$user_id;
                // $user_log['edited_by'] = @$logged_in_added_by;
                $user_log['added_id'] = @$user_id;
                $user_log['added_by'] = @$logged_in_added_by;
                $user_log['num_of_access'] = @$check_num_edit;
                $logged_inDetails = getUsers($logged_in_added_by);
                if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                }

                //if($after_save['first_name']!="" && $before_save['id']!=""){
                    $user_edit_detail_data['before_accessed'] = 'Accessed';
                    $user_edit_detail_data['is_changed'] = 1;
                    // pr($before_save);
                    //    pr($after_save);
                   // pr($user_edit_detail_data);die;
                    $user_edit_detail_data['edited_id'] = @$user_id;
                    $user_edit_detail_data['edited_by'] = @$logged_in_added_by;
                    $user_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $user_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }
                    $CI->db->insert('tbl_users_logs_detial',@$user_edit_detail_data);

               // }





##########################################################################################################################################






            }else{
                $num_edit = number_of_edit(@$user_id);
                if($num_edit->id){
                    $number = $num_edit->num_edit;
                    $check_num_edit = $number + 1;

                    // $user_log['added_id'] = @$user_id;
                    // $user_log['added_by'] = @$logged_in_added_by;
                    $user_log_edit['num_of_edit'] = @$check_num_edit;
                    //$logged_inDetails = getUsers($logged_in_added_by);
                    // if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    //     $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    // }

                        // pr($num_edit);
                        // pr($user_log_edit);die;
                    $CI->db->update('tbl_users_logs',@$user_log_edit,array('id'=>$num_edit->id));

                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                        if($after_save['first_name']!=$before_save['first_name'] && $after_save['first_name']){
                            $user_edit_detail_data['before_first_name'] = $before_save['first_name'];
                            $user_edit_detail_data['after_first_name'] = $after_save['first_name'];
                            $is_changed++;
                        }
                        if($after_save['last_name']!=$before_save['last_name'] && $after_save['last_name']){
                            $user_edit_detail_data['before_last_name'] = $before_save['last_name'];
                            $user_edit_detail_data['after_last_name'] = $after_save['last_name'];
                            $is_changed++;
                        }
                        if($after_save['email_address']!=$before_save['email_address'] && $after_save['email_address']){
                            $user_edit_detail_data['before_email_address'] = $before_save['email_address'];
                            $user_edit_detail_data['after_email_address'] = $after_save['email_address'];
                            $is_changed++;
                        }
                        if($after_save['email']!=$before_save['email'] && $after_save['email']){
                            $user_edit_detail_data['before_email_address'] = $before_save['email'];
                            $user_edit_detail_data['after_email_address'] = $after_save['email'];
                            $is_changed++;
                        }
                        if(($after_save['password'])!=($before_save['store_user_password']) && $after_save['password']){
                            $user_edit_detail_data['before_password'] = $before_save['store_user_password'];
                            $user_edit_detail_data['after_password'] = $after_save['password'];
                            $is_changed++;
                        }
                        if($after_save['mobile_number']!=$before_save['mobile_number'] && $after_save['mobile_number']){
                            $user_edit_detail_data['before_mobile'] = $before_save['mobile_number'];
                            $user_edit_detail_data['after_mobile'] = $after_save['mobile_number'];
                            $is_changed++;
                        }
                        if($after_save['mobile']!=$before_save['mobile'] && $after_save['mobile']){
                            $user_edit_detail_data['before_mobile'] = $before_save['mobile'];
                            $user_edit_detail_data['after_mobile'] = $after_save['mobile'];
                            $is_changed++;
                        }

                        if($after_save['store']!=$before_save['store'] && $after_save['store']){
                            $user_edit_detail_data['before_store_id'] = $before_save['store'];
                            $user_edit_detail_data['after_store_id'] = $after_save['store'];
                            $user_edit_detail_data['before_store_name'] =$CI->db->get_where('tbl_store',array('store_id'=>$before_save['store']))->row()->store_name;
                            $user_edit_detail_data['after_store_name'] = $CI->db->get_where('tbl_store',array('store_id'=>$after_save['store']))->row()->store_name;
                            $is_changed++;
                        }

                        if($after_save['status']!=$before_save['status'] && $after_save['status']){
                            $user_edit_detail_data['before_status'] = $before_save['status']==1?'Active':'Inactive';
                            $user_edit_detail_data['after_status'] = $after_save['status']==1?'Active':'Inactive';
                            $is_changed++;
                        }
                        if($after_save['is_blocked']!=$before_save['is_blocked'] && $after_save['is_blocked']){
                            $user_edit_detail_data['before_blocked'] = $before_save['is_blocked']==1?'Blocked':'Unblocked';
                            $user_edit_detail_data['after_blocked'] = $after_save['is_blocked']==1?'Blocked':'Unblocked';
                            $is_changed++;
                        }

                        if($after_save['phone_verify']!=$before_save['phone_verify'] && $after_save['phone_verify']){
                            $user_edit_detail_data['before_phone_verify'] = $before_save['phone_verify']==1?'Verified':'Unverified';
                            $user_edit_detail_data['after_phone_verify'] = $after_save['phone_verify']==1?'Verified':'Unverified';
                            $is_changed++;
                        }

                        if($is_changed==0){
                            $user_edit_detail_data['is_changed'] = '0';
                        }
                      //  pr($before_save);
                     //   pr($after_save);
                      //  pr($user_edit_detail_data);die;
                        $user_edit_detail_data['edited_id'] = @$user_id;
                        $user_edit_detail_data['edited_by'] = @$logged_in_added_by;
                        $logged_inDetails = getUsers($logged_in_added_by);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $user_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }

                        $user_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');

                        // pr($before_save);
                        // pr($after_save);

                        // pr($user_edit_detail_data);die;


                        $CI->db->insert('tbl_users_logs_detial',@$user_edit_detail_data);

                  //  }
                    return 1;


                }else{
                    $number = 0;
                    $check_num_edit = $number + 1;
                }


                // $user_log['edited_id'] = @$user_id;
                // $user_log['edited_by'] = @$logged_in_added_by;
                $user_log['added_id'] = @$user_id;
                $user_log['added_by'] = @$logged_in_added_by;
                $user_log['num_of_edit'] = @$check_num_edit;
                $logged_inDetails = getUsers($logged_in_added_by);
                if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                }

                //if($after_save['first_name']!="" && $before_save['id']!=""){
                    $is_changed = 0;
                    if($after_save['first_name']!=$before_save['first_name']  && $after_save['first_name']){
                        $user_edit_detail_data['before_first_name'] = $before_save['first_name'];
                        $user_edit_detail_data['after_first_name'] = $after_save['first_name'];
                        $is_changed++;
                    }
                    if($after_save['last_name']!=$before_save['last_name']  && $after_save['last_name']){
                        $user_edit_detail_data['before_last_name'] = $before_save['last_name'];
                        $user_edit_detail_data['after_last_name'] = $after_save['last_name'];
                        $is_changed++;
                    }
                    if($after_save['email_address']!=$before_save['email_address']  && $after_save['email_address']){
                        $user_edit_detail_data['before_email_address'] = $before_save['email_address'];
                        $user_edit_detail_data['after_email_address'] = $after_save['email_address'];
                        $is_changed++;
                    }
                    if($after_save['email']!=$before_save['email'] && $after_save['email']){
                        $user_edit_detail_data['before_email_address'] = $before_save['email'];
                        $user_edit_detail_data['after_email_address'] = $after_save['email'];
                        $is_changed++;
                    }
                    if(($after_save['password'])!=($before_save['store_user_password'])  && $after_save['password']){
                        $user_edit_detail_data['before_password'] = $before_save['store_user_password'];
                        $user_edit_detail_data['after_password'] = $after_save['password'];
                        $is_changed++;
                    }
                    if($after_save['mobile_number']!=$before_save['mobile_number'] && $after_save['mobile_number']){
                        $user_edit_detail_data['before_mobile'] = $before_save['mobile_number'];
                        $user_edit_detail_data['after_mobile'] = $after_save['mobile_number'];
                        $is_changed++;
                    }
                    if($after_save['mobile']!=$before_save['mobile'] && $after_save['mobile']){
                        $user_edit_detail_data['before_mobile'] = $before_save['mobile'];
                        $user_edit_detail_data['after_mobile'] = $after_save['mobile'];
                        $is_changed++;
                    }

                    if($after_save['store']!=$before_save['store'] && $after_save['store']){
                        $user_edit_detail_data['before_store_id'] = $before_save['store'];
                        $user_edit_detail_data['after_store_id'] = $after_save['store'];
                        $user_edit_detail_data['before_store_name'] =$CI->db->get_where('tbl_store',array('store_id'=>$before_save['store']))->row()->store_name;
                        $user_edit_detail_data['after_store_name'] = $CI->db->get_where('tbl_store',array('store_id'=>$after_save['store']))->row()->store_name;
                        $is_changed++;
                    }
                    if($after_save['status']!=$before_save['status']  && $after_save['status']){
                        $user_edit_detail_data['before_status'] = $before_save['status']==1?'Active':'Inactive';
                        $user_edit_detail_data['after_status'] = $after_save['status']==1?'Active':'Inactive';
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $user_edit_detail_data['is_changed'] = 0;
                    }
                   // pr($user_edit_detail_data);die;
                    $user_edit_detail_data['edited_id'] = @$user_id;
                    $user_edit_detail_data['edited_by'] = @$logged_in_added_by;
                    $user_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $user_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }
                        // pr($before_save);
                        // pr($after_save);

                        // pr($user_edit_detail_data);die;

                    $CI->db->insert('tbl_users_logs_detial',@$user_edit_detail_data);

               // }



            }
            $CI->db->insert('tbl_users_logs',@$user_log);
        }

    }


    function product_detail_for_log($id = "",$weight_id="") {
        $CI = & get_instance();
        if ($id != "") {
        // $CI->db->select("tbl_product.product_name");
        // $CI->db->where("`tbl_product`.`product_id`", $id);
        // $query = $CI->db->get('tbl_product');

        $CI->db->select("*,tbl_product_price.id as pid");
        $CI->db->join('`tbl_product_price`', '`tbl_product`.`product_id` = `tbl_product_price`.`product_id`', 'left');
        $CI->db->where('`tbl_product_price`.product_price!=', 0);
        $CI->db->where("`tbl_product`.`product_id`", $id);

        $query = $CI->db->get('tbl_product');
        // pr($CI->db->last_query()); die;
        $total = $query->num_rows();
            if ($total > 0) {
                $data = @$query->row();

                $CI->db->select('*');
                $CI->db->from('tbl_product_price');
                $CI->db->where('product_id', $id);
                //$CI->db->where('product_price>', 0);
                $CI->db->order_by('id','asc');
                $CI->db->group_by('id');
                $data_3 = $CI->db->get()->result();
                @$data->main_price = @$data_3;

                $CI->db->select('*');
                $CI->db->from('tbl_inventory');
                $CI->db->where('product_id', $id);
                //$CI->db->where('product_price>', 0);
                $CI->db->order_by('id','asc');
                $CI->db->group_by('id');
                $data_4 = $CI->db->get()->result();
                $gg=0;
                foreach ($weight_id as $key_weight_id => $value_weight_id) {
                    foreach ($data_4 as $key_data_4 => $value_data_4) {
                        if($weight_id[$key_weight_id]==$data_4[$key_data_4]->priceid){
                            $new_data_4[$key_weight_id][$gg] = $data_4[$key_data_4];
                            $gg++;
                        }
                    }
                    $gg=0;
                }

               // @$data->inventory = @$data_4;
                @$data->inventory = @$new_data_4;




                $CI->db->select('tbl_pst.*');
                $CI->db->from('tbl_product_price_store_wise tbl_pst');
                $CI->db->where('tbl_pst.product_id', $id);
                //$CI->db->where('tbl_pst.product_price>', 0);
                //$CI->db->order_by('tbl_pst.id','asc');
                //$CI->db->group_by('tbl_pst.id');
                //$CI->db->where('tbl_pst.main_price_id!=', null);
                $data_2 = $CI->db->get()->result();
               // echo $CI->db->last_query();die;
               $gg=0;
                foreach ($weight_id as $key_weight_id => $value_weight_id) {
                    foreach ($data_2 as $key_data_2 => $value_data_2) {
                        if($weight_id[$key_weight_id]==$data_2[$key_data_2]->main_price_id){
                             $new_data_2[$key_weight_id][$gg] = $data_2[$key_data_2];
                            // $new_data_2[$key_weight_id][$gg]->product_price = $data_2[$key_data_2]->product_price;
                            // $new_data_2[$key_weight_id][$gg]->product_s_price = $data_2[$key_data_2]->product_s_price;
                            $gg++;
                        }
                    }
                    $gg=0;
                }
                // @$data->store_wise_price = @$data_2;
                @$data->store_wise_price = @$new_data_2;
                return @$data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function product_ean_sku_for_log($id = "",$pid = "") {
        $CI = & get_instance();
        if ($id != "") {
        $CI->db->select("tbl_product_price.id as pid,tbl_product_price.ean_code,tbl_product_price.sku_code,tbl_product_price.product_price,tbl_product_price.product_s_price");
        $CI->db->where('`tbl_product_price`.product_price!=', 0);
        $CI->db->where("`tbl_product_price`.`product_id`", $id);
        if($pid != ""){
            $CI->db->where("`tbl_product_price`.id", $pid);
        }


        $query = $CI->db->get('tbl_product_price');
        //pr($CI->db->last_query()); die;
        $total = $query->num_rows();
            if ($total > 0) {
                return @$query->result();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function number_of_product_edit($edited_id) {
        $CI = & get_instance();
        if(@$edited_id){
            $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
            // $check_num_edit = $CI->db->select('COUNT(id) as num_edit')
            // $check_num_edit = $CI->db->select('num_of_edit as num_edit')
            // ->from("tbl_products_logs")
            // ->where("product_id",@$edited_id)
            // ->where("by_id",@$logged_in_added_by)
            // ->order_by("id","desc")
            // ->get()->row()->num_edit;
            $check_num_edit = $CI->db->select('num_of_edit as num_edit')
            ->from("tbl_products_logs_main")
            ->where("product_id",@$edited_id)
            ->where("by_id",@$logged_in_added_by)
            ->where("action",'edit')
            ->order_by("id","desc")
            ->get()->row()->num_edit;
            if(@$check_num_edit){
                return $check_num_edit;
            }
            return 0;
        }else{
            return 0;
        }
    }
    function product_log_entry($module_name="", $action="", $before_save="", $after_save="") {


        $CI = & get_instance();
        $product_id = $before_save->product_id;



        // echo $product_name;
        // die;
        // pr($module_name);
        // pr($action);
        // pr($before_save);die;
    //    pr($before_save->inventory);
    //     pr($after_save['sw_p_price']);
       if(@$before_save->inventory){
        $product_name = $after_save['p_name'];

            foreach ($before_save->inventory as $key_inventoryss=> $value_inventoryssss) {
                foreach ($value_inventoryssss as $key_inventoryss_value_inventoryssss=> $value_inventory_new) {

                 $new_sw_p_price[$key_inventoryss][$key_inventoryss_value_inventoryssss] = $after_save['sw_p_price'][$key_inventoryss_value_inventoryssss][$key_inventoryss];
                 $new_sw_ps_price[$key_inventoryss][$key_inventoryss_value_inventoryssss] = $after_save['sw_ps_price'][$key_inventoryss_value_inventoryssss][$key_inventoryss];
                }
            }
            $after_save['sw_p_price'] = $new_sw_p_price;
            $after_save['sw_ps_price'] = $new_sw_ps_price;
       }

        //  pr($before_save->store_wise_price);
        //  pr($after_save['sw_p_price']);
        //  die;

        if($module_name=='Products'){



        }else if($module_name=='Pickers'){
            $table = 'tbl_pickers';
            $userDetails= $CI->db->select("first_name,last_name,email as email_address",false)
                            ->from("$table")
                            ->where("id",$user_id)
                            ->get()->result();
        }else if($module_name=='Delivery Boys'){
            $table = 'tbl_delivery_boys';
            $userDetails= $CI->db->select("first_name,last_name,email as email_address",false)
                            ->from("$table")
                            ->where("id",$user_id)
                            ->get()->result();
        }
        $logged_in_added_by = $CI->session->userdata('system_admin')['id'];

                $user_log_main['module_name'] = @$module_name;
                $user_log_main['action'] = ucwords($action);
                $user_log_main['action_time'] = @date('Y-m-d H:i:s');

                if (!empty(@$product_name)) {
                    $user_log_main['name'] = trim(@$product_name);
                    $user_log_main['ean_codes'] = implode(",",array_filter(@$ean_codes));
                    $user_log_main['sku_codes'] = implode(",",array_filter(@$sku_codes));
                }
        if(@$product_id){
            if(strtolower($action)=='delete'){


                $product_name = $before_save->product_name;
                $user_log_main['product_pec_weight'] = @$after_save;
                $user_log_main['name'] = trim(@$product_name);
                $user_log_main['product_id'] = @$product_id;
                $user_log_main['by_id'] = @$logged_in_added_by;
                $logged_inDetails = getUsers($logged_in_added_by);

                if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $user_log_main['by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                }

                $user_log['product_id'] = $user_log_main['product_id'];
                $user_log['by_id'] = $user_log_main['by_id'];
                $user_log['by_name'] = $user_log_main['by_name'];
                $user_log['name'] = $user_log_main['name'];
                $user_log['module_name'] = $user_log_main['module_name'];
                $user_log['action'] = $user_log_main['action'];
                $user_log['action_time'] = $user_log_main['action_time'];
                $user_log['product_pec_weight'] = $user_log_main['product_pec_weight'];

               // pr($user_log);die;
                $CI->db->insert('tbl_products_logs',@$user_log);
                $CI->db->insert('tbl_products_logs_main',@$user_log);

            }else if(strtolower($action)=='add'){
                $user_log_main['name'] = trim(@$after_save['p_name']);
                $user_log_main['product_id'] = @$product_id;
                $user_log_main['by_id'] = @$logged_in_added_by;
                $logged_inDetails = getUsers($logged_in_added_by);

                if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $user_log_main['by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                }

                $user_log['product_id'] = $user_log_main['product_id'];
                $user_log['by_id'] = $user_log_main['by_id'];
                $user_log['by_name'] = $user_log_main['by_name'];
                $user_log['name'] = $user_log_main['name'];
                $user_log['module_name'] = $user_log_main['module_name'];
                $user_log['action'] = $user_log_main['action'];
                $user_log['action_time'] = $user_log_main['action_time'];
                $CI->db->insert('tbl_products_logs',@$user_log);
                $CI->db->insert('tbl_products_logs_main',@$user_log);


            }else{
                $check_num_edit = number_of_product_edit(@$product_id) + 1;
                $user_log = null;

                ################################Check Inventory & Price(Centralised/Store Wise) starts###########################################
                    $dd=0;

                    $centralised_price_after =  array_filter($after_save['p_price']);

                    $centralised_price_s_after =  array_filter($after_save['ps_price']);

                    $s = json_decode($after_save['stockdata']);
                    // pr($before_save->inventory);
                    // pr($s);die;
                    $dd_invt = 0;
                    $dd_store_wise = 0;
                    $dd_store_wise1 = 0;
                    foreach ($before_save->main_price as $key_main_price => $value_main_price) {
                        $ddd = 'ref'.$key_main_price;
                        $h = $s->$ddd;
                        //  pr($h);
                        //  pr($before_save->inventory[$key_main_price]);die;
                        $spcl=0;
                        $invt=0;
                        if($before_save->main_price[$key_main_price]->product_price!=$centralised_price_after[$key_main_price]){
                            $user_log[$dd]['before_product_price'] = @$before_save->main_price[$key_main_price]->product_price;
                            $user_log[$dd]['after_product_price'] = @$centralised_price_after[$key_main_price];
                            $user_log[$dd]['product_pec_weight'] = @$before_save->main_price[$key_main_price]->product_pec_weight;
                            if($before_save->main_price[$key_main_price]->product_s_price!=$centralised_price_s_after[$key_main_price]){
                                $user_log[$dd]['before_product_s_price'] = @$before_save->main_price[$key_main_price]->product_s_price;
                                $user_log[$dd]['after_product_s_price'] = @$centralised_price_s_after[$key_main_price];
                                $user_log[$dd]['product_pec_weight'] = $before_save->main_price[$key_main_price]->product_pec_weight;
                                $spcl=1;
                            }
                            $dd++;
                        }
                        if($before_save->main_price[$key_main_price]->product_s_price!=$centralised_price_s_after[$key_main_price] && $spcl==0){
                            $user_log[$dd]['before_product_s_price'] = @$before_save->main_price[$key_main_price]->product_s_price;
                            $user_log[$dd]['after_product_s_price'] = @$centralised_price_s_after[$key_main_price];
                            $user_log[$dd]['product_pec_weight'] = $before_save->main_price[$key_main_price]->product_pec_weight;
                            $dd++;
                        }


                        #################for inventory starts#########################

                        foreach ($before_save->inventory[$key_main_price] as $key_inventory => $value_inventory) {

                            if($before_save->inventory[$key_main_price][$key_inventory]->qnty_type!=$h[$key_inventory]->store_qnty_type){

                                if($h[$key_inventory]->store_qnty_type=='limited' && $before_save->inventory[$key_main_price][$key_inventory]->qnty!=$h[$key_inventory]->qnty){
                                    $user_log_invt[$dd_invt]['before_qnty'] = $before_save->inventory[$key_main_price][$key_inventory]->qnty;
                                    $user_log_invt[$dd_invt]['after_qnty'] = $h[$key_inventory]->qnty;
                                    $user_log_invt[$dd_invt]['before_qnty_type'] = $before_save->inventory[$key_main_price][$key_inventory]->qnty_type;
                                    $user_log_invt[$dd_invt]['after_qnty_type'] = $h[$key_inventory]->store_qnty_type;
                                    $user_log_invt[$dd_invt]['store_name'] = get_store_name_without_status($h[$key_inventory]->store_id)[0]->store_name;
                                    $user_log_invt[$dd_invt]['product_pec_weight'] = $before_save->main_price[$key_main_price]->product_pec_weight;
                                    $invt=1;
                                    $dd_invt++;
                                }
                                if($h[$key_inventory]->store_qnty_type=='unlimited'){
                                    $user_log_invt[$dd_invt]['before_qnty'] = $before_save->inventory[$key_main_price][$key_inventory]->qnty;
                                    $user_log_invt[$dd_invt]['before_qnty_type'] = $before_save->inventory[$key_main_price][$key_inventory]->qnty_type;
                                    $user_log_invt[$dd_invt]['after_qnty_type'] = $h[$key_inventory]->store_qnty_type;
                                    $user_log_invt[$dd_invt]['store_name'] = get_store_name_without_status($h[$key_inventory]->store_id)[0]->store_name;
                                    $user_log_invt[$dd_invt]['product_pec_weight'] = $before_save->main_price[$key_main_price]->product_pec_weight;
                                    $invt=1;
                                    $dd_invt++;
                                }

                            }
                            if($before_save->inventory[$key_main_price][$key_inventory]->qnty_type==$h[$key_inventory]->store_qnty_type && $h[$key_inventory]->store_qnty_type=='limited' && $before_save->inventory[$key_main_price][$key_inventory]->qnty!=$h[$key_inventory]->qnty){
                                $user_log_invt[$dd_invt]['before_qnty'] = $before_save->inventory[$key_main_price][$key_inventory]->qnty;
                                $user_log_invt[$dd_invt]['after_qnty'] = $h[$key_inventory]->qnty;
                                $user_log_invt[$dd_invt]['before_qnty_type'] = $before_save->inventory[$key_main_price][$key_inventory]->qnty_type;
                                $user_log_invt[$dd_invt]['after_qnty_type'] = $h[$key_inventory]->store_qnty_type;
                                $user_log_invt[$dd_invt]['store_name'] = get_store_name_without_status($h[$key_inventory]->store_id)[0]->store_name;
                                $user_log_invt[$dd_invt]['product_pec_weight'] = $before_save->main_price[$key_main_price]->product_pec_weight;
                                $invt=1;
                                $dd_invt++;
                            }

                            $invt=0;
                                    #################for Store Wise Price starts#########################
                                    // pr($before_save->store_wise_price[$key_main_price]);
                                    // pr($after_save['sw_p_price'][$key_main_price]);die;
                                    $sw_spcl = 0;
                                    if($before_save->store_wise_price[$key_main_price][$key_inventory]->product_price!=$after_save['sw_p_price'][$key_main_price][$key_inventory]){

                                       // pr($before_save->store_wise_price[$key_main_price][$key_inventory]->product_price);
                                      //  pr($after_save['sw_p_price'][$key_main_price][$key_inventory]);


                                        $user_log_store_wise[$dd_store_wise1]['store_wise'] = '1';
                                        $user_log_store_wise[$dd_store_wise1]['before_product_price'] = @$before_save->store_wise_price[$key_main_price][$key_inventory]->product_price;
                                        $user_log_store_wise[$dd_store_wise1]['after_product_price'] = @$after_save['sw_p_price'][$key_main_price][$key_inventory];
                                        $user_log_store_wise[$dd_store_wise1]['store_name'] = get_store_name_without_status($before_save->store_wise_price[$key_main_price][$key_inventory]->store_id)[0]->store_name;
                                        $user_log_store_wise[$dd_store_wise1]['product_pec_weight'] = @$before_save->store_wise_price[$key_main_price][$key_inventory]->product_pec_weight;
                                        if($before_save->store_wise_price[$key_main_price][$key_inventory]->product_s_price!= @$after_save['sw_ps_price'][$key_main_price][$key_inventory]){
                                            $user_log_store_wise[$dd_store_wise1]['before_product_s_price'] = @$before_save->store_wise_price[$key_main_price][$key_inventory]->product_s_price;
                                            $user_log_store_wise[$dd_store_wise1]['after_product_s_price'] =  @$after_save['sw_ps_price'][$key_main_price][$key_inventory];
                                            $user_log_store_wise[$dd_store_wise1]['product_pec_weight'] = $before_save->store_wise_price[$key_main_price][$key_inventory]->product_pec_weight;
                                            $sw_spcl=1;
                                           // $dd_store_wise++;
                                        }
                                        $dd_store_wise1++;
                                    }
                                    if($before_save->store_wise_price[$key_main_price][$key_inventory]->product_s_price!=@$after_save['sw_ps_price'][$key_main_price][$key_inventory] && $sw_spcl==0){
                                        $user_log_store_wise[$dd_store_wise1]['store_wise'] = '1';
                                        $user_log_store_wise[$dd_store_wise1]['store_name'] = get_store_name_without_status($before_save->store_wise_price[$key_main_price][$key_inventory]->store_id)[0]->store_name;
                                        $user_log_store_wise[$dd_store_wise1]['before_product_s_price'] = @$before_save->store_wise_price[$key_main_price][$key_inventory]->product_s_price;
                                        $user_log_store_wise[$dd_store_wise1]['after_product_s_price'] = @$after_save['sw_ps_price'][$key_main_price][$key_inventory];
                                        $user_log_store_wise[$dd_store_wise1]['product_pec_weight'] = $before_save->store_wise_price[$key_main_price][$key_inventory]->product_pec_weight;
                                        $sw_spcl=1;
                                        $dd_store_wise1++;
                                    }
                                    $sw_spcl =0;



                                     #################for Store Wise Price ends#########################



                        }

                        #################for inventory ends#########################
                        $invt=0;
                        $spcl=0;
                    }//foreach ends

                        $dd_invt = 0;
                        $dd_store_wise1 = 0;






               ################################Check Inventory & Price(Centralised/Store Wise) ends###########################################


                    $user_log_main['product_id'] = @$product_id;
                    $user_log_main['by_id'] = @$logged_in_added_by;
                    $user_log_main['num_of_edit'] = @$check_num_edit;
                    $logged_inDetails = getUsers($logged_in_added_by);
                    //  pr($user_log_main);
                    //  pr($user_log_invt);
                    //  pr($user_log_store_wise);
                    //   pr($user_log); die;
                    if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                        $user_log_main['by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    }
                    if(!empty($user_log)){


                        foreach ($user_log as $key_user_log => $value_user_log) {

                            $value_user_log['name'] = $user_log_main['name'];
                            $value_user_log['product_id'] = $user_log_main['product_id'];
                            $value_user_log['by_id'] = $user_log_main['by_id'];
                            $value_user_log['by_name'] = $user_log_main['by_name'];
                            $value_user_log['num_of_edit'] = $user_log_main['num_of_edit'];

                            $value_user_log['module_name'] = $user_log_main['module_name'];
                            $value_user_log['action'] = $user_log_main['action'];
                            $value_user_log['action_time'] = $user_log_main['action_time'];

                            $CI->db->insert('tbl_products_logs',@$value_user_log);

                        }
                    }
                    if(!empty($user_log_invt)){


                        foreach ($user_log_invt as $key_user_log_invt => $value_user_log_invt) {

                            $value_user_log_invt['name'] = $user_log_main['name'];
                            $value_user_log_invt['product_id'] = $user_log_main['product_id'];
                            $value_user_log_invt['by_id'] = $user_log_main['by_id'];
                            $value_user_log_invt['by_name'] = $user_log_main['by_name'];
                            $value_user_log_invt['num_of_edit'] = $user_log_main['num_of_edit'];

                            $value_user_log_invt['module_name'] = $user_log_main['module_name'];
                            $value_user_log_invt['action'] = $user_log_main['action'];
                            $value_user_log_invt['action_time'] = $user_log_main['action_time'];

                            $CI->db->insert('tbl_products_logs',@$value_user_log_invt);

                        }
                    }
                    if(!empty($user_log_store_wise)){


                        foreach ($user_log_store_wise as $key_user_log_store_wise => $value_user_log_store_wise) {

                            $value_user_log_store_wise['name'] = $user_log_main['name'];
                            $value_user_log_store_wise['product_id'] = $user_log_main['product_id'];
                            $value_user_log_store_wise['by_id'] = $user_log_main['by_id'];
                            $value_user_log_store_wise['by_name'] = $user_log_main['by_name'];
                            $value_user_log_store_wise['num_of_edit'] = $user_log_main['num_of_edit'];

                            $value_user_log_store_wise['module_name'] = $user_log_main['module_name'];
                            $value_user_log_store_wise['action'] = $user_log_main['action'];
                            $value_user_log_store_wise['action_time'] = $user_log_main['action_time'];

                            $CI->db->insert('tbl_products_logs',@$value_user_log_store_wise);

                        }
                    }

                    if(empty($user_log_invt) && empty($user_log) && empty($user_log_store_wise)){
                        $user_log['product_id'] = $user_log_main['product_id'];
                        $user_log['by_id'] = $user_log_main['by_id'];
                        $user_log['by_name'] = $user_log_main['by_name'];
                        $user_log['num_of_edit'] = $user_log_main['num_of_edit'];
                        $user_log['name'] = $user_log_main['name'];
                        $user_log['module_name'] = $user_log_main['module_name'];
                        $user_log['action'] = $user_log_main['action'];
                        $user_log['action_time'] = $user_log_main['action_time'];
                        $CI->db->insert('tbl_products_logs',@$user_log);
                    }

                    if($user_log_main['num_of_edit']=='1'){

                        $CI->db->insert('tbl_products_logs_main',@$user_log_main);
                    }else{
                        $whr['product_id'] = $user_log_main['product_id'];
                        $whr['by_id'] = $user_log_main['by_id'];
                        $upd_data['num_of_edit'] =  $user_log_main['num_of_edit'];
                        $CI->db->update('tbl_products_logs_main',@$upd_data,$whr);
                    }


                    //pr($user_log);die;



                    return 1;



            }

            //pr($user_log);die;

        }


        //die;

    }

    function checkStoreWiseDetail($product_id,$main_price_id,$store_wise_price_id){
        $CI = & get_instance();

        // $CI->db->select('tbl_pst.id');
        // $CI->db->from('tbl_product_price_store_wise tbl_pst');
        // $CI->db->where('tbl_pst.product_id', $product_id);
        // $CI->db->where('tbl_pst.main_price_id', $main_price_id);
        // $CI->db->where('tbl_pst.id', $store_wise_price_id);
        // $CI->db->order_by('tbl_pst.id','asc');
        // $query = $CI->db->get();
        // $data = $query->row()->id;
        // if($data){
        //     return true;
        // }else{
        //     return false;
        // }

        $CI->db->select('tbl_pst.id,tbl_pst.code');
        $CI->db->from('tbl_product_price tbl_pst');
        $CI->db->where('tbl_pst.product_id', $product_id);
        $CI->db->where('tbl_pst.id', $main_price_id);
        $CI->db->order_by('tbl_pst.id','asc');
        $query = $CI->db->get();
        $data = $query->row();
        if($data){
            return $data;
        }else{
            return false;
        }

    }

    function checkStoreWisePriceExist($product_id,$main_price_id,$store_id){
        $CI = & get_instance();

        $CI->db->select('tbl_pst.id');
        $CI->db->from('tbl_product_price_store_wise tbl_pst');
        $CI->db->where('tbl_pst.product_id', $product_id);
        $CI->db->where('tbl_pst.main_price_id', $main_price_id);
        $CI->db->where('tbl_pst.store_id', $store_id);
        $CI->db->order_by('tbl_pst.id','asc');
        $query = $CI->db->get();
        $data = $query->row()->id;
        //pr($data);die;
        if($data){
            return true;
        }else{
            return false;
        }

    }

    function checkInvetoryExist($product_id,$main_price_id,$store_id){
        $CI = & get_instance();

        $CI->db->select('tbl_pst.id');
        $CI->db->from('tbl_inventory tbl_pst');
        $CI->db->where('tbl_pst.product_id', $product_id);
        $CI->db->where('tbl_pst.priceid', $main_price_id);
        $CI->db->where('tbl_pst.store_id', $store_id);
        $CI->db->order_by('tbl_pst.id','asc');
        $query = $CI->db->get();
        $data = $query->row()->id;
        //pr($data);die;
        if($data){
            return true;
        }else{
            return false;
        }

    }

    function GetSubstituteList($id){
        $CI = & get_instance();

       // pr($_SESSION['user_preference']->order_preference_store);
//        $store_id = $_SESSION['user_preference']->order_preference_store;
//         $sql = "SELECT p1.* from tbl_product as p1 JOIN tbl_product_price as p2 on p1.product_id=p2.product_id WHERE p2.id = ".$id." AND p2.unit_status = 1";
//         if(!empty($id))
//         {
//             $query = $CI->db->query($sql);
// //   $sql = "SELECT `tbl_inventory`.*, `tbl_product_price`.* FROM `tbl_inventory`, `tbl_product_price` WHERE 1 = 1 AND `tbl_inventory`.`priceid` = `tbl_product_price`.`id` AND `tbl_product_price`.`id` = " . $priceid . " AND `tbl_inventory`.`store_id` = " . $storeid . "";

//             pr($query->row());
//             if($query->row()->substitute){
//                 $subs_array = explode(",",$query->row()->substitute);
//                 $substitute_list = $CI->db->select("p.*,pp.id as price_id,pp.product_price,pp.product_s_price")
//                 ->from('tbl_product p')
//                 ->join('tbl_product_price pp', 'p.product_id=pp.product_id', 'left')
//                 ->where('pp.unit_status','1')
//                 ->where_in('pp.id',$subs_array)
//                 ->get()->result();
//                 foreach ($substitute_list as $key_substitute_list => $value_substitute_list) {
//                     $sw_substitute_list = $CI->db->select("pp.id as price_id,pp.product_price as sw_product_price,pp.product_s_price as sw_product_s_price")
//                     ->from('tbl_product p')
//                     ->join('tbl_product_price_store_wise pp', 'p.product_id=pp.product_id', 'left')
//                     //->where('pp.unit_status','1')
//                     ->where('pp.main_price_id',$value_substitute_list->price_id)
//                     ->where('pp.store_id',$store_id)
//                     ->get()->row();
//                     pr($sw_substitute_list);
//                     if(!empty($sw_substitute_list)){
//                         $value_substitute_list->sw_product_price = $sw_substitute_list->sw_product_price;
//                         $value_substitute_list->sw_product_s_price = $sw_substitute_list->sw_product_s_price;
//                     }
//                 }
//             }

//             pr($substitute_list);
//             die;
//             return $query->row()->substitute;
//         }
//         else
//         {
//             return "";
//         }
    }

    function getProductIDByVariantId($id) {
        $CI = & get_instance();
        $sql = "SELECT p1.product_id from tbl_product as p1 JOIN tbl_product_price as p2 on p1.product_id=p2.product_id WHERE p2.id = ".$id;
        if(!empty($id))
        {
            $query = $CI->db->query($sql);
            return $query->row()->product_id;
        }
        else
        {
            return "";
        }

    }
    function getRFQProductDetails($id) {
        $CI = & get_instance();
        $sql = "SELECT * from tbl_product  WHERE product_id = ".$id;
        if(!empty($id))
        {
            $query = $CI->db->query($sql);
            return $query->row();
        }
        else
        {
            return "";
        }
    }
    function rfq_product_brand_list($brand_ids)
    {

        $brand_arr = explode(",", $brand_ids);
        $CI = & get_instance();
        $CI->db->select("SQL_CALC_FOUND_ROWS brand.brand_id, brand.brand_name", false);
        $CI->db->where_in("brand.brand_id", $brand_arr);
        $CI->db->where("brand.status", 1);
        $query = $CI->db->get("tbl_brand as brand");

        return $query->result();;
    }
    function ticket_log_exist($ticket_id){
        $CI = & get_instance();
        $ticket = "#ODMB".$ticket_id;

        $data = $CI->db->select("*")
        ->from("tbl_ticket_logs_detial")
        ->where("ticket_id",$ticket)
        ->order_by("id","DESC")
        ->get()->row_array();
        if($data['id']){
            return $data;
        }
        return false;


    }
    function ticket_log_entry($action,$after_save, $ticket_id,$before_save="") {
        $CI = & get_instance();
        // pr($action);
        // pr($ticket_id);

         $data = ticket_log_exist($ticket_id);
         //pr($data);
         if($after_save['status']!='' && isset($after_save['assigned_to'])=='' && $data['id']!=''){
            //pr($after_save);
            $whr['id'] = $data['id'];
            unset($data['id']);
           // pr($data);
            $ticket_detail_data = $data;
            $ticket_detail_data['status'] = $after_save['status'];
            $ticket_detail_data['status_name'] = $after_save['status_name'];
            $ticket_detail_data['created_date'] = @date('Y-m-d H:i:s');
            //pr($ticket_detail_data);die;
            // $CI->db->update('tbl_ticket_logs_detial',@$ticket_detail_data,@$whr);
            $CI->db->insert('tbl_ticket_logs_detial',@$ticket_detail_data);
            return 1;
         }
         if($after_save['status']!='' && $after_save['status']=='4' && isset($after_save['assigned_to'])=='' && $data['id']==''){
          //  echo 'ddd';die;

            ###############################################################################################

                        $ticket_data = get_order_issues_data($ticket_id);
                            if($ticket_data->assigned_to!=0){
                                $assigned_user_data = get_assigned_user_data($ticket_data->assigned_to);
                                $admin_name = ucfirst($assigned_user_data->first_name).' '.ucfirst($assigned_user_data->last_name);
                            $admin_email =  ucfirst($assigned_user_data->email_address);

                            }else{
                                $assigned_user_data->id = $_SESSION['system_admin']['id'];
                                $admin_name = ucfirst($_SESSION['system_admin']['first_name']).' '.ucfirst($_SESSION['system_admin']['last_name']);
                                $admin_email = ucfirst($_SESSION['system_admin']['email_address']);

                            }

                        $log_data['assigned_name'] = $admin_name;
                        $log_data['assigned_email'] = $admin_email;
                        $log_data['ticket_id'] = '#ODMB'.$ticket_data->id;
                        $log_data['ticket_type'] = $ticket_data->ticket_type;
                        $log_data['subject'] = $ticket_data->subject;
                        $log_data['description'] = $ticket_data->description;
                        $log_data['status'] = $ticket_data->status;
                        if($ticket_data->status == '1'){
                            $status = 'Pending';
                        }else if($ticket_data->status == '2'){
                            $status = 'In-Process';
                        }else if($ticket_data->status == '3'){
                            $status = 'Resolved';
                        }else if($ticket_data->status == '4'){
                            $status = 'Closed';
                        }
                        $log_data['status_name'] = $status;
                        $log_data['order_id'] = $ticket_data->order_id;
                        $log_data['issue_type'] = $ticket_data->issue_type;
                        if($ticket_data->issue_type == '1'){
                            $issue_type = 'Product';
                        }else if($ticket_data->issue_type == '2'){
                            $issue_type = 'Delivery Boy';
                        }
                        $log_data['issue_type_name'] = $issue_type;
                        $log_data['assigned_to'] = $assigned_user_data->id;
                        $log_data['email_address'] = $ticket_data->email_address;
                        $log_data['name'] = $ticket_data->first_name.' '.$ticket_data->last_name;
                        $log_data['order_number'] = $ticket_data->order_number;
                        $log_data['status'] = $after_save['status'];
                        $log_data['status_name'] = $after_save['status_name'];
                        $log_data['created_date'] = @date('Y-m-d H:i:s');

                  //pr($log_data);die;

            ###############################################################################################

            $CI->db->insert('tbl_ticket_logs_detial',@$log_data);
            return 1;

         }


        $ticket_detail_data = $after_save;
        $ticket_detail_data['created_date'] = @date('Y-m-d H:i:s');

        //pr($ticket_detail_data);die;
        $CI->db->insert('tbl_ticket_logs_detial',@$ticket_detail_data);

        return 1;


        //die;
    }

    function get_order_issues_data($id)
     {
        $CI = & get_instance();
        $CI->db->select("manage_ticket.*,TBLU.email_address,TBLU.first_name,TBLU.last_name,TBLO.order_type,TBLO.order_number");
        $CI->db->join('tbl_users as TBLU','TBLU.id = manage_ticket.added_by');
        $CI->db->join('tbl_order as TBLO','TBLO.id = manage_ticket.order_id');
        $CI->db->where('manage_ticket.id',$id);
        $CI->db->from('manage_ticket');
        $query = $CI->db->get();
        $data = $query->row();
        $ticket_id = $data->id;
        $CI->db->select('*');
        $CI->db->where('ticket_id',$ticket_id);
        $response = $CI->db->get('ticket_log')->result();
        $data->log = $response;

            return $data;
    }
    function get_assigned_user_data($assigned_to_id){
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->where('id',$assigned_to_id);
        $user_data  = $CI->db->get('tbl_users')->row();
        if($user_data){
            return $user_data;
        }else{
            return false;
        }
    }


    function GetDrivingDistance_h($lat1, $long1, $lat2, $long2){


        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?key=".MAP_API."&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        // $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $dist = isset($response_a['rows'][0]['elements'][0]['distance']['value']) ? $response_a['rows'][0]['elements'][0]['distance']['value'] : 0;
        $time = isset($response_a['rows'][0]['elements'][0]['duration']['text']) ? $response_a['rows'][0]['elements'][0]['duration']['text'] : 0;
        $dist_km = round(($dist/1000),2);
        // pr($response_a);die;
        return array('distance' => $dist_km, 'time' => $time);
    }

    function isExistsReportLog($id,$action)
    {
        $CI = & get_instance();
       $data = $CI->db->get_where("tbl_report_log",array('export_by'=>$id,'action'=>$action))->row();

      // pr($data);die;
       if($data->id){
        return $data;
       }
       return false;
    }

//////////////////////////////////////////  insert data for reports module ///////////////////////////////////
    function report_sale_log($report_log)
    {

       // pr($report_log); die;
        $CI = & get_instance();
        $id = $report_log['export_by'];
        $check_data = isExistsReportLog($id,$report_log['action']);
       if($check_data->id)
       {

            $CI->db->set('num_of_export',$check_data->num_of_export+1);
            $CI->db->where('action',$report_log['action']);
            $CI->db->where('export_by',$id);
            $CI->db->update('tbl_report_log');

       }else{
              //echo 'heyy'; die;

            $report_log['num_of_export'] = 1;
            $CI->db->insert('tbl_report_log',$report_log);
       }

      $data['export_by'] =  $report_log['export_by'];
      $data['store_id'] =  $report_log['store_id'];
      $data['action'] =  $report_log['action'];
      $data['action_time'] =  @date('Y-m-d H:i:s');
      $CI->db->insert('tbl_report_log_details',$data);


    return true;
    }

//////////////////////////////////////////  insert data for reports module end ///////////////////////////////
function get_store_wise_price($price='',$weight_id='',$store_id='',$product_id=''){
    $CI = & get_instance();
    if(checkStoreWisePriceExist($product_id,$weight_id,$store_id)){

                $CI->db->select('tbl_pst.*');
                $CI->db->from('tbl_product_price_store_wise tbl_pst');
                $CI->db->where('tbl_pst.product_id', $product_id);
                $CI->db->where('tbl_pst.main_price_id', $weight_id);
                $CI->db->where('tbl_pst.store_id', $store_id);
                //$CI->db->where('tbl_pst.product_price>', 0);
                $CI->db->order_by('tbl_pst.id','asc');
                $query = $CI->db->get();
                $data = $query->row();
                 // echo $CI->db->last_query();
                //  pr($data);
                //pr($query->num_rows());

                //die;
                if($query->num_rows()>0 && $data->product_price>0){

                    return $data->product_price;

                }else{
                    return $price;
                }


    }

}



/////////////////////////////////////////   website settings details end  //////////////////////////////////
function setting_log_entry($module_name, $action, $user_id,$after_save="",$before_save="") {
    $CI = & get_instance();

    if($module_name == 'System Settings')
    {
        $table = 'tbl_website_setting';
         $userDetails= $CI->db->select("var_name,var_title,setting_value",false)
                            ->from($table)
                            ->where("id",$user_id)
                            ->get()->result();

                          //  pr($userDetails);die;
    }else if($module_name == 'Slots Management')
    {
        $table ='tbl_timeslot';
        $userDetails= $CI->db->select("store",false)
        ->from($table)
        ->where("id",$user_id)
        ->get()->result();

    }else if($module_name == 'Email Templates')
    {
        $table ='tbl_sys_email_template';
        $userDetails= $CI->db->select("name,subject",false)
        ->from($table)
        ->where("id",$user_id)
        ->get()->result();

    }else if($module_name == 'Shipping Charges')
    {
        $table ='tbl_shiping';
        $userDetails= $CI->db->select("distancefrom,distanceto,status",false)
        ->from($table)
        ->where("id",$user_id)
        ->get()->result();

    }else if($module_name == 'CMS Pages')
    {
        $table =' tbl_cms';
        $userDetails= $CI->db->select("title",false)
        ->from($table)
        ->where("id",$user_id)
        ->get()->result();

    }else if($module_name == 'MB Express')
    {
        $table =' tbl_mbexpress';
        $userDetails= $CI->db->select("price,time",false)
        ->from($table)
        ->where("id",$user_id)
        ->get()->result();

    }
    //pr($userDetails);die;
     $logged_in_added_by = $CI->session->userdata('system_admin')['id'];

            $user_log['module_name'] = @$module_name;
            $user_log['action'] = ucwords($action);
            $user_log['action_time'] = @date('Y-m-d H:i:s');
            //pr($user_log); die;
            if (!empty($userDetails) && count($userDetails) > 0) {
                $user_log['var_name'] = @$userDetails[0]->var_name;
                $user_log['name'] = @$userDetails[0]->name;
                $user_log['subject'] = @$userDetails[0]->subject;
                $user_log['var_title'] = @$userDetails[0]->var_title;
                $user_log['title'] = @$userDetails[0]->title;
                $user_log['setting_value'] = @$userDetails[0]->setting_value;
                $user_log['store_name'] =  @$userDetails[0]->store;
                $user_log['distance_from'] =  @$userDetails[0]->distancefrom;
                $user_log['distance_to'] =  @$userDetails[0]->distanceto;
                $user_log['status'] =  @$userDetails[0]->status;
                $user_log['time'] =  @$userDetails[0]->time;
                $user_log['price'] =  @$userDetails[0]->price;
              // pr($user_log); die;
            }

           // pr($user_log); die;
            if(@$user_id){
                if(strtolower($action)=='delete'){
                    // $user_log['deleted_id'] = @$user_id;
                    // $user_log['deleted_by'] = @$logged_in_added_by;
                    $user_log['added_id'] = @$user_id;
                    $user_log['added_by'] = @$logged_in_added_by;
                    $logged_inDetails = getUsers($logged_in_added_by);

                //pr($logged_inDetails);die;
                    if (!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                        $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                       // pr($user_log); die;
                    }

                }else if(strtolower($action)=='add'){
                    $user_log['added_id'] = @$user_id;
                    $user_log['added_by'] = @$logged_in_added_by;
                    $logged_inDetails = getUsers($logged_in_added_by);
                  //  pr($logged_inDetails); die;
                    if (!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                        $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                        //pr($user_log); die;
                    }

                    // $CI->db->insert('tbl_settings_logs',$user_log);

     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                }else{
                    $num_edit = number_of_edit1(@$user_id);
                    if($num_edit->id){
                        $number = $num_edit->num_edit;
                        $check_num_edit = $number + 1;

                        // $user_log['added_id'] = @$user_id;
                        // $user_log['added_by'] = @$logged_in_added_by;
                        $user_log_edit['num_of_edit'] = @$check_num_edit;
                        //$logged_inDetails = getUsers($logged_in_added_by);
                        // if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                        //     $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        // }

                            //     pr($num_edit);
                            //  pr($user_log_edit);die;
                        $CI->db->update('tbl_settings_logs',@$user_log_edit,array('id'=>$num_edit->id));

                        //if($after_save['first_name']!="" && $before_save['id']!=""){
                            $is_changed = 0;
                            if($after_save['first_name']!=$before_save['first_name'] && $after_save['first_name']){
                                $user_edit_detail_data['before_first_name'] = $before_save['first_name'];
                                $user_edit_detail_data['after_first_name'] = $after_save['first_name'];
                                $is_changed++;
                            }
                            if($after_save['last_name']!=$before_save['last_name'] && $after_save['last_name']){
                                $user_edit_detail_data['before_last_name'] = $before_save['last_name'];
                                $user_edit_detail_data['after_last_name'] = $after_save['last_name'];
                                $is_changed++;
                            }
                            if($after_save['email_address']!=$before_save['email_address'] && $after_save['email_address']){
                                $user_edit_detail_data['before_email_address'] = $before_save['email_address'];
                                $user_edit_detail_data['after_email_address'] = $after_save['email_address'];
                                $is_changed++;
                            }
                            if($after_save['email']!=$before_save['email'] && $after_save['email']){
                                $user_edit_detail_data['before_email_address'] = $before_save['email'];
                                $user_edit_detail_data['after_email_address'] = $after_save['email'];
                                $is_changed++;
                            }
                            if(($after_save['password'])!=($before_save['store_user_password']) && $after_save['password']){
                                $user_edit_detail_data['before_password'] = $before_save['store_user_password'];
                                $user_edit_detail_data['after_password'] = $after_save['password'];
                                $is_changed++;
                            }
                            if($after_save['mobile_number']!=$before_save['mobile_number'] && $after_save['mobile_number']){
                                $user_edit_detail_data['before_mobile'] = $before_save['mobile_number'];
                                $user_edit_detail_data['after_mobile'] = $after_save['mobile_number'];
                                $is_changed++;
                            }
                            if($after_save['mobile']!=$before_save['mobile'] && $after_save['mobile']){
                                $user_edit_detail_data['before_mobile'] = $before_save['mobile'];
                                $user_edit_detail_data['after_mobile'] = $after_save['mobile'];
                                $is_changed++;
                            }

                            if($after_save['store']!=$before_save['store'] && $after_save['store']){
                                $user_edit_detail_data['before_store_id'] = $before_save['store'];
                                $user_edit_detail_data['after_store_id'] = $after_save['store'];
                                $user_edit_detail_data['before_store_name'] =$CI->db->get_where('tbl_store',array('store_id'=>$before_save['store']))->row()->store_name;
                                $user_edit_detail_data['after_store_name'] = $CI->db->get_where('tbl_store',array('store_id'=>$after_save['store']))->row()->store_name;
                                $is_changed++;
                            }

                            if($after_save['status']!=$before_save['status'] && $after_save['status']){
                                $user_edit_detail_data['before_status'] = $before_save['status']==1?'Active':'Inactive';
                                $user_edit_detail_data['after_status'] = $after_save['status']==1?'Active':'Inactive';
                                $is_changed++;
                            }
                            if($after_save['is_blocked']!=$before_save['is_blocked'] && $after_save['is_blocked']){
                                $user_edit_detail_data['before_blocked'] = $before_save['is_blocked']==1?'Blocked':'Unblocked';
                                $user_edit_detail_data['after_blocked'] = $after_save['is_blocked']==1?'Blocked':'Unblocked';
                                $is_changed++;
                            }

                            if($after_save['phone_verify']!=$before_save['phone_verify'] && $after_save['phone_verify']){
                                $user_edit_detail_data['before_phone_verify'] = $before_save['phone_verify']==1?'Verified':'Unverified';
                                $user_edit_detail_data['after_phone_verify'] = $after_save['phone_verify']==1?'Verified':'Unverified';
                                $is_changed++;
                            }

                            if($is_changed==0){
                                $user_edit_detail_data['is_changed'] = '0';
                            }
                          //  pr($before_save);
                         //   pr($after_save);
                          //  pr($user_edit_detail_data);die;
                            $user_edit_detail_data['edited_id'] = @$user_id;
                            $user_edit_detail_data['edited_by'] = @$logged_in_added_by;
                            $logged_inDetails = getUsers($logged_in_added_by);
                            if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                                $user_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                            }

                            $user_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                            $CI->db->insert('tbl_users_logs_detial',@$user_edit_detail_data);

                      //  }
                        return 1;


                    }else{
                        $number = 0;
                        $check_num_edit = $number + 1;
                    }


                    // $user_log['edited_id'] = @$user_id;
                    // $user_log['edited_by'] = @$logged_in_added_by;
                    $user_log['added_id'] = @$user_id;
                    $user_log['added_by'] = @$logged_in_added_by;
                    $user_log['num_of_edit'] = @$check_num_edit;
                    $logged_inDetails = getUsers($logged_in_added_by);
                    if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                        $user_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        $user_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                    }

                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                        if($after_save['first_name']!=$before_save['first_name']  && $after_save['first_name']){
                            $user_edit_detail_data['before_first_name'] = $before_save['first_name'];
                            $user_edit_detail_data['after_first_name'] = $after_save['first_name'];
                            $is_changed++;
                        }
                        if($after_save['last_name']!=$before_save['last_name']  && $after_save['last_name']){
                            $user_edit_detail_data['before_last_name'] = $before_save['last_name'];
                            $user_edit_detail_data['after_last_name'] = $after_save['last_name'];
                            $is_changed++;
                        }
                        if($after_save['email_address']!=$before_save['email_address']  && $after_save['email_address']){
                            $user_edit_detail_data['before_email_address'] = $before_save['email_address'];
                            $user_edit_detail_data['after_email_address'] = $after_save['email_address'];
                            $is_changed++;
                        }
                        if($after_save['email']!=$before_save['email'] && $after_save['email']){
                            $user_edit_detail_data['before_email_address'] = $before_save['email'];
                            $user_edit_detail_data['after_email_address'] = $after_save['email'];
                            $is_changed++;
                        }
                        if(($after_save['password'])!=($before_save['store_user_password'])  && $after_save['password']){
                            $user_edit_detail_data['before_password'] = $before_save['store_user_password'];
                            $user_edit_detail_data['after_password'] = $after_save['password'];
                            $is_changed++;
                        }
                        if($after_save['mobile_number']!=$before_save['mobile_number'] && $after_save['mobile_number']){
                            $user_edit_detail_data['before_mobile'] = $before_save['mobile_number'];
                            $user_edit_detail_data['after_mobile'] = $after_save['mobile_number'];
                            $is_changed++;
                        }
                        if($after_save['mobile']!=$before_save['mobile'] && $after_save['mobile']){
                            $user_edit_detail_data['before_mobile'] = $before_save['mobile'];
                            $user_edit_detail_data['after_mobile'] = $after_save['mobile'];
                            $is_changed++;
                        }

                        if($after_save['store']!=$before_save['store'] && $after_save['store']){
                            $user_edit_detail_data['before_store_id'] = $before_save['store'];
                            $user_edit_detail_data['after_store_id'] = $after_save['store'];
                            $user_edit_detail_data['before_store_name'] =$CI->db->get_where('tbl_store',array('store_id'=>$before_save['store']))->row()->store_name;
                            $user_edit_detail_data['after_store_name'] = $CI->db->get_where('tbl_store',array('store_id'=>$after_save['store']))->row()->store_name;
                            $is_changed++;
                        }
                        if($after_save['status']!=$before_save['status']  && $after_save['status']){
                            $user_edit_detail_data['before_status'] = $before_save['status']==1?'Active':'Inactive';
                            $user_edit_detail_data['after_status'] = $after_save['status']==1?'Active':'Inactive';
                            $is_changed++;
                        }
                        if($is_changed==0){
                            $user_edit_detail_data['is_changed'] = 0;
                        }
                       // pr($user_edit_detail_data);die;
                        $user_edit_detail_data['edited_id'] = @$user_id;
                        $user_edit_detail_data['edited_by'] = @$logged_in_added_by;
                        $user_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                            if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                                $user_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                            }
                        $CI->db->insert('tbl_users_logs_detial',@$user_edit_detail_data);

                   // }



                }
                $CI->db->insert('tbl_settings_logs',@$user_log);
            }




}

//===================================================== ORDERS LOGS STARTS ========================================//
function number_of_access_order($edited_id) {
        $CI = & get_instance();
        if(@$edited_id){
            $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
            $check_num_edit = $CI->db->select('num_of_access as num_edit,id')
            ->from("tbl_orders_logs")
            // ->where("edited_id",@$edited_id)
            // ->where("edited_by",@$logged_in_added_by)
            ->where("num_of_access!=",'0')
            ->where("added_id",@$edited_id)
            ->where("added_by",@$logged_in_added_by)
            ->get()->row();
            // echo $CI->db->last_query();die;
            //pr($check_num_edit);die;
            if(@$check_num_edit->id){
                return $check_num_edit;
            }
            return 0;
        }else{
            return 0;
        }
    }

    function number_of_order_cancel($edited_id,$added_by,$order_number) {
        $CI = & get_instance();
        if(@$edited_id){
            // $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
            $check_num_edit = $CI->db->select('num_of_edit as num_edit,id')
            ->from("tbl_orders_logs")
            ->where("num_of_edit!=",'0')
            ->where("added_id",@$edited_id)
            ->where("added_by",@$added_by)
            ->where("order_number",@$order_number)
            ->get()->row();
            // echo $CI->db->last_query();die;
            //pr($check_num_edit);die;
            if(@$check_num_edit->id){
                return $check_num_edit;
            }
            return 0;
        }else{
            return 0;
        }
    }

    function number_of_order_edit($edited_id,$user_id) {
        $CI = & get_instance();
        if(@$edited_id){
            $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
            $check_num_edit = $CI->db->select('num_of_edit as num_edit,id')
            ->from("tbl_orders_logs")
            ->where("num_of_edit!=",'0')
            ->where("added_id",@$edited_id)
            ->where("added_by",@$user_id)
            // ->or_where("edited_by",@$logged_in_added_by)
            ->get()->row();
            // echo $CI->db->last_query();die;
            // pr($check_num_edit);die;
            if(@$check_num_edit->id){
                return $check_num_edit;
            }
            return 0;
        }else{
            return 0;
        }
    }

    function getOrderPreviousDetails($order_id = "") {
    $CI = & get_instance();
    $CI->db->select('told.*');
    $CI->db->where('told.edited_id',$order_id);
    // $CI->db->or_where('told.before_order_number',$order_number);
    // $CI->db->where('told.edited_by', $user_id);
    $CI->db->order_by('told.id', 'DESC');
    $query = $CI->db->get('tbl_orders_logs_detial told');
    // echo $CI->db->last_query();die;
    if ($query->num_rows() > 0) {
        $data = $query->row();
        return $data;
    }
    return false;
}

// function getOrderDetailsNew($orders_id = "", $order_no = "", $users_id = "") {
//     $CI = & get_instance();
//     $where = "";
//     if ($orders_id != "") {
//         $where .= " AND `tbl_order`.`id` = '" . $orders_id . "'";
//     }
//     if ($order_no != "") {
//         $where .= " AND `tbl_order`.`order_number` = '" . $order_no . "'";
//     }
//     if ($users_id != "") {
//         $where .= " AND `tbl_order`.`user_id` = '" . $users_id . "'";
//     }
//     $sql = "select tbl_order.*,tbl_user_address.* from `tbl_order` inner join `tbl_user_address` on `tbl_user_address`.`id` = `tbl_order`.`multiple_address_id` " . $where . " ";
//     $query = $CI->db->query($sql);
//     echo $CI->db->last_query();die;
//     $data = "";
//     if ($query->num_rows() > 0) {
//         $data = $query->result();
//         return $data;
//     }
//     return false;
// }
function getOrderDetailsNew($orders_id = "", $order_no = "", $users_id = "") {
    $CI = & get_instance();
    $where = "";
    if ($orders_id != "") {
        $where .= " WHERE `tbl_order`.`id` = '" . $orders_id . "'";
    }
    if ($order_no != "") {
        $where .= " WHERE `tbl_order`.`order_number` = '" . $order_no . "'";
    }
    if ($users_id != "") {
        $where .= " WHERE `tbl_order`.`user_id` = '" . $users_id . "'";
    }
    $sql = "select tbl_order.* from `tbl_order` " . $where . " ";
    $query = $CI->db->query($sql);
    //echo $CI->db->last_query();die;
    $data = "";
    if ($query->num_rows() > 0) {
        $data = $query->result();
        return $data;
    }
    return false;
}

 function AlertOnAddCart($action='',$date='',$id='',$order_type=''){
    $CI = & get_instance();
    if($action=='insert'){
        if($order_type=='1'){
            $tbl_users['alert_date_pickup'] = @$date;
        }else{
            $tbl_users['alert_date'] = @$date;
        }

        $CI->db->update('tbl_users',@$tbl_users,array('id'=>$id));

    }else{

        $CI->db->select('told.alert_date,told.alert_date_pickup');
        $CI->db->where('told.id',$id);
        $query = $CI->db->get('tbl_users told');
        if ($query->num_rows() > 0) {
            $data = $query->row();
            if($order_type=='2'){
                if($data->alert_date==$date){
                    return 'yes';
                }else{
                    $tbl_users['alert_date'] = @$date;
                    $CI->db->update('tbl_users',@$tbl_users,array('id'=>$id));
                    return 'no';
                }
            }else{
                if($data->alert_date_pickup==$date){
                    return 'yes';
                }else{
                    $tbl_users['alert_date_pickup'] = @$date;
                    $CI->db->update('tbl_users',@$tbl_users,array('id'=>$id));
                    return 'no';
                }
            }

        }else{
            return 'no';
        }
        return 'no';
    }
}


function order_log_entry($module_name, $action, $order_id,$after_save="",$before_save="") {
    // pr($module_name);
        $CI = & get_instance();
        if($module_name=='Delivery'){
            $table = 'tbl_order';
            $orderDetails = getOrderDetailsNew($order_id);
            // pr($orderDetails);die;

        $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
                $order_log['module_name'] = @$module_name;
                $order_log['action'] = ucwords($action);
                $order_log['action_time'] = @date('Y-m-d H:i:s');
                if (!empty($orderDetails) && count($orderDetails) > 0) {
                    $order_log['name'] = @$orderDetails[0]->first_name.' '.@$orderDetails[0]->last_name;
                    $order_log['email_id'] = @$orderDetails[0]->email_address;
                }
        if(@$order_id){
            if($action=='cancel_order'){
                $orderDetails = getOrderDetailsNew($order_id);
                $order_by_customer_details = getUsers($orderDetails[0]->user_id);
                $num_edit = number_of_order_cancel(@$order_id,$orderDetails[0]->user_id,$orderDetails[0]->order_number);
                $previous_order_log_details = getOrderPreviousDetails($orderDetails[0]->id);
                if($num_edit->id){
                    $number = $num_edit->num_edit;
                    $check_num_edit = $number + 1;

                    $order_log_edit['num_of_edit'] = @$check_num_edit;
                    $CI->db->update('tbl_orders_logs',@$order_log_edit,array('id'=>$num_edit->id));

                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                    if($orderDetails[0]->order_status){
                        $order_cancel_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_cancel_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_cancel_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_cancel_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_cancel_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_cancel_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_cancel_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_cancel_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_cancel_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_cancel_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $before_save;
                        $is_changed++;
                    }

                    if($is_changed==0){
                        $order_cancel_detail_data['is_changed'] = 0;
                    }
                        $order_cancel_detail_data['edited_id'] = @$order_id;
                        $order_cancel_detail_data['edited_by'] = @$order_by_customer_details[0]->id;
                        // $order_by_customer_details = getUsers($logged_in_added_by);
                        if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                            $order_cancel_detail_data['edited_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                        }

                        $order_cancel_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_cancel_detail_data);

                  //  }
                    return 1;


                }else{
                    $number = 0;
                    $check_num_edit = $number + 1;
                }

                $order_log['added_id'] = @$order_id;
                $order_log['added_by'] = @$logged_in_added_by;
                $order_log['num_of_edit'] = @$check_num_edit;
                // $logged_inDetails = getUsers($logged_in_added_by);
                // pr($logged_inDetails);
                if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                    $order_log['added_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                    $order_log['groups_id'] = @$order_by_customer_details[0]->groups_id;
                }

                //if($after_save['first_name']!="" && $before_save['id']!=""){
                    $is_changed = 0;
                    if($orderDetails[0]->order_status){
                        $order_cancel_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_cancel_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_cancel_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_cancel_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_cancel_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_cancel_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_cancel_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_cancel_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_cancel_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_cancel_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $before_save;
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_cancel_detail_data['is_changed'] = 0;
                    }
                    // pr($order_cancel_detail_data);die;
                    $order_cancel_detail_data['edited_id'] = @$order_id;
                    $order_cancel_detail_data['edited_by'] = @$order_by_customer_details[0]->id;
                    $order_cancel_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                            $order_cancel_detail_data['edited_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                        }
                    $CI->db->insert('tbl_orders_logs_detial',@$order_cancel_detail_data);

               // }



            }
            else if(strtolower($action)=='add'){
                $order_by_customer_details = getUsers($after_save['user_id']);
                $order_log['order_type'] = '2';
                $order_log['added_id'] = @$order_id;
                $order_log['added_by'] = @$order_by_customer_details[0]->id;
                if (!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                    $order_log['added_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                    $order_log['email_id'] = @$order_by_customer_details[0]->email_address;
                    $order_log['groups_id'] = @$order_by_customer_details[0]->groups_id;
                }

                // $order_add_data['order_status'] = 'confirm';
                if(isset($after_save['order_number']) && !empty($after_save['order_number'])){
                        $order_add_data['order_number'] = $after_save['order_number'];
                }
                if(isset($after_save['total_amount']) && !empty($after_save['total_amount'])){
                        $order_add_data['total_amount'] = $after_save['total_amount'];
                }
                if(isset($after_save['selectdeliverydate']) && !empty($after_save['selectdeliverydate'])){
                        $order_add_data['selectdeliverydate'] = $after_save['selectdeliverydate'];
                }

                if(isset($after_save['selectdeliverytime']) && !empty($after_save['selectdeliverytime'])){
                        $order_add_data['selectdeliverytime'] = $after_save['selectdeliverytime'];
                }
                if(isset($after_save['payment_type']) && !empty($after_save['payment_type'])){
                        $order_add_data['payment_type'] = $after_save['payment_type'];
                }
                if(isset($after_save['order_date']) && !empty($after_save['order_date'])){
                        $order_add_data['order_date'] = $after_save['order_date'];
                }
                if(isset($after_save['order_status']) && !empty($after_save['order_status'])){
                        $order_add_data['order_status'] = $after_save['order_status'];
                }
                if(isset($after_save['assigned_store_id']) && !empty($after_save['assigned_store_id'])){
                        $order_add_data['store_id'] = $after_save['assigned_store_id'];
                }
                $insert_data = array_merge($order_add_data,$order_log);
                        $CI->db->insert('tbl_orders_logs',@$insert_data);

                        $is_changed = 0;
                    if($after_save['order_number']!=$before_save['order_number']  && $after_save['order_number']){
                        $order_add_detail_data['before_order_number'] = $before_save['order_number'];
                        $order_add_detail_data['after_order_number'] = $after_save['order_number'];
                        $is_changed++;
                    }
                    if($after_save['order_date']!=$before_save['order_date']  && $after_save['order_date']){
                        // $order_add_detail_data['before_order_date'] = $before_save['order_date'];
                        $order_add_detail_data['order_date'] = $after_save['order_date'];
                        $is_changed++;
                    }
                    if($after_save['total_amount']!=$before_save['total_amount']  && $after_save['total_amount']){
                        $order_add_detail_data['before_total_amount'] = $before_save['total_amount'];
                        $order_add_detail_data['after_total_amount'] = $after_save['total_amount'];
                        $is_changed++;
                    }
                    if($after_save['selectdeliverydate']!=$before_save['selectdeliverydate']  && $after_save['selectdeliverydate']){
                        $order_add_detail_data['before_selectdeliverydate'] = $before_save['selectdeliverydate'];
                        $order_add_detail_data['after_selectdeliverydate'] = $after_save['selectdeliverydate'];
                        $is_changed++;
                    }

                    if($after_save['selectdeliverytime']!=$before_save['selectdeliverytime']  && $after_save['selectdeliverytime']){
                        $order_add_detail_data['before_selectdeliverytime'] = $before_save['selectdeliverytime'];
                        $order_add_detail_data['after_selectdeliverytime'] = $after_save['selectdeliverytime'];
                        $is_changed++;
                    }

                    if($after_save['payment_type']!=$before_save['payment_type'] && $after_save['payment_type']){
                        $order_add_detail_data['before_payment_type'] = $before_save['payment_type'];
                        $order_add_detail_data['after_payment_type'] = $after_save['payment_type'];
                        $is_changed++;
                    }

                    if($after_save['assigned_store_id']!=$before_save['assigned_store_id'] && $after_save['assigned_store_id']){
                        $order_add_detail_data['before_store_id'] = $before_save['assigned_store_id'];
                        $order_add_detail_data['after_store_id'] = $after_save['assigned_store_id'];
                        $is_changed++;
                    }

                    if($after_save['order_status'] && !empty($after_save['order_status'])){
                        $order_add_detail_data['before_status'] = $before_save['order_status'];
                        $order_add_detail_data['after_status'] = $after_save['order_status'];
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_add_detail_data['is_changed'] = 0;
                    }
                        $order_add_detail_data['edited_id'] = @$order_id;
                        $order_add_detail_data['edited_by'] = @$order_by_customer_details[0]->id;
                        if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                            $order_add_detail_data['edited_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                        }

                        $order_add_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_add_detail_data);

                  //  }
                    return 1;

            }
            elseif(strtolower($action)=='edit'){

            //     pr($module_name);
            //     pr($action);
            //     pr($order_id);
            //     pr($after_save);
            //     pr($before_save);
            //    // die;
                $orderDetails = getOrderDetailsNew(@$order_id);
                $num_edit = number_of_order_edit(@$order_id,$orderDetails[0]->user_id);
                $previous_order_log_details = getOrderPreviousDetails($orderDetails[0]->id);
               if($num_edit){

               }else{
                $num_edit = number_of_order_edit(@$order_id,$logged_in_added_by);
               }
                // pr($num_edit);
                //  pr($orderDetails);die;
                if($num_edit->id){
                    $number = $num_edit->num_edit;
                    $check_num_edit = $number + 1;
                    $order_log_edit['num_of_edit'] = @$check_num_edit;

                    $order_log_edit['edited_by'] = @$logged_in_added_by;
                    $CI->db->update('tbl_orders_logs',@$order_log_edit,array('id'=>$num_edit->id,'order_number'=>$orderDetails[0]->order_number));

                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                     if($orderDetails[0]->order_status){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_edit_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_edit_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_edit_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_edit_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_edit_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_edit_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->assigned_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->assigned_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_picker'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Picker';
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_delivery_boy'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Delivery Boy';
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_edit_detail_data['is_changed'] = 0;
                    }
                        $order_edit_detail_data['edited_id'] = @$order_id;
                        $order_edit_detail_data['edited_by'] = @$logged_in_added_by;
                        $logged_inDetails = getUsers($logged_in_added_by);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }

                        $order_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_edit_detail_data);
                        // echo $CI->db->last_query();die;
                  //  }
                    return 1;


                }else{
                    $number = 0;
                    $check_num_edit = $number + 1;
                    // pr($orderDetails)

                    ################for already added order starts########3
                   // $order_by_customer_details = getUsers($orderDetails[0]->order_number);

                    $order_log['num_of_edit'] = @$check_num_edit;
                    $order_log['order_type'] = '2';
                        $order_log['edited_by'] = @$logged_in_added_by;
                        $order_log['added_id'] = @$order_id;
                        $order_log['added_by'] = @$orderDetails[0]->user_id;
                        $logged_inDetails = getUsers(@$orderDetails[0]->user_id);
                        // pr($logged_inDetails);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                            $order_log['email_id'] = @$logged_inDetails[0]->email_address;
                            $order_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                        }

                        // $order_add_data['order_status'] = 'confirm';
                        $order_add_data['order_number'] = $orderDetails[0]->order_number;
                        $order_add_data['total_amount'] = $orderDetails[0]->total_amount;
                        $order_add_data['selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $order_add_data['selectdeliverytime'] = $orderDetails[0]->selectdeliverytime;
                        $order_add_data['payment_type'] = $orderDetails[0]->payment_type;
                        $order_add_data['order_date'] =$orderDetails[0]->order_date;
                        $order_add_data['order_status'] =$orderDetails[0]->order_status;
                        $order_add_data['store_id'] =$orderDetails[0]->assigned_store_id;

                        $insert_data = array_merge($order_add_data,$order_log);

                       // pr($insert_data);die;
                        $CI->db->insert('tbl_orders_logs',@$insert_data);







                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                     if($orderDetails[0]->order_status){
                        $order_edit_detail_data['before_status'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_edit_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['order_date'] = $orderDetails[0]->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverydate'] =$orderDetails[0]->selectdeliverydate;
                        $order_edit_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverytime){
                        $order_edit_detail_data['before_selectdeliverytime'] = $orderDetails[0]->selectdeliverytime;
                        $order_edit_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverytime;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_edit_detail_data['before_total_amount'] = $orderDetails[0]->total_amount;
                        $order_edit_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_payment_type'] = $orderDetails[0]->payment_type;
                        $order_edit_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }

                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $orderDetails[0]->assigned_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->assigned_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_picker'){
                        $order_edit_detail_data['before_status'] = $orderDetails[0]->assigned_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Picker';
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_delivery_boy'){
                        $order_edit_detail_data['before_status'] = $orderDetails[0]->assigned_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Delivery Boy';
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_edit_detail_data['is_changed'] = 0;
                    }
                        $order_edit_detail_data['edited_id'] = @$order_id;
                        $order_edit_detail_data['edited_by'] = @$logged_in_added_by;
                        $logged_inDetails = getUsers($logged_in_added_by);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }

                        $order_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_edit_detail_data);
                        // echo $CI->db->last_query();die;
                  //  }
                    return 1;


                    ################for already added order ends########3





                }


                $order_log['added_id'] = @$order_id;
                $order_log['added_by'] = @$logged_in_added_by;
                $order_log['num_of_edit'] = @$check_num_edit;
                $logged_inDetails = getUsers($logged_in_added_by);
                // pr($logged_inDetails);
                if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $order_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    $order_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                }

                //if($after_save['first_name']!="" && $before_save['id']!=""){
                    $is_changed = 0;
                    if($orderDetails[0]->order_status){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_edit_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_edit_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_edit_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_edit_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_edit_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_edit_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->after_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_picker'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Picker';
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_delivery_boy'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Delivery Boy';
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_edit_detail_data['is_changed'] = 0;
                    }
                    // pr($order_edit_detail_data);die;
                    $order_edit_detail_data['edited_id'] = @$order_id;
                    $order_edit_detail_data['edited_by'] = @$logged_in_added_by;
                    $order_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }
                    $CI->db->insert('tbl_orders_logs_detial',@$order_edit_detail_data);

               // }



            }
            // pr($order_log);die;
            // $CI->db->insert('tbl_orders_logs',@$order_log);
        }
      }
      else{


            $table = 'tbl_order';
            $orderDetails = getOrderDetailsNew($order_id);
        $logged_in_added_by = $CI->session->userdata('system_admin')['id'];
                $order_log['module_name'] = @$module_name;
                $order_log['action'] = ucwords($action);
                $order_log['action_time'] = @date('Y-m-d H:i:s');
                if (!empty($orderDetails) && count($orderDetails) > 0) {
                    $order_log['name'] = @$orderDetails[0]->first_name.' '.@$orderDetails[0]->last_name;
                    $order_log['email_id'] = @$orderDetails[0]->email_address;
                }
        if(@$order_id){
            if($action=='cancel_order'){
                $orderDetails = getOrderDetailsNew($order_id);
                $order_by_customer_details = getUsers($orderDetails[0]->user_id);
                $num_edit = number_of_order_cancel(@$order_id,$orderDetails[0]->user_id,$orderDetails[0]->order_number);
                $previous_order_log_details = getOrderPreviousDetails($orderDetails[0]->id);
                if($num_edit->id){
                    $number = $num_edit->num_edit;
                    $check_num_edit = $number + 1;

                    $order_log_edit['num_of_edit'] = @$check_num_edit;
                    $CI->db->update('tbl_orders_logs',@$order_log_edit,array('id'=>$num_edit->id));

                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                    if($orderDetails[0]->order_status){
                        $order_cancel_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_cancel_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_cancel_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_cancel_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_cancel_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_cancel_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_cancel_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_cancel_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_cancel_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_cancel_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $before_save;
                        $is_changed++;
                    }

                    if($is_changed==0){
                        $order_cancel_detail_data['is_changed'] = 0;
                    }
                        $order_cancel_detail_data['edited_id'] = @$order_id;
                        $order_cancel_detail_data['edited_by'] = @$order_by_customer_details[0]->id;
                        // $order_by_customer_details = getUsers($logged_in_added_by);
                        if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                            $order_cancel_detail_data['edited_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                        }

                        $order_cancel_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_cancel_detail_data);

                  //  }
                    return 1;


                }else{
                    $number = 0;
                    $check_num_edit = $number + 1;
                }

                $order_log['added_id'] = @$order_id;
                $order_log['added_by'] = @$logged_in_added_by;
                $order_log['num_of_edit'] = @$check_num_edit;
                // $logged_inDetails = getUsers($logged_in_added_by);
                // pr($logged_inDetails);
                if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                    $order_log['added_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                    $order_log['groups_id'] = @$order_by_customer_details[0]->groups_id;
                }

                //if($after_save['first_name']!="" && $before_save['id']!=""){
                    $is_changed = 0;
                    if($orderDetails[0]->order_status){
                        $order_cancel_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_cancel_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_cancel_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_cancel_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_cancel_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_cancel_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_cancel_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_cancel_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_cancel_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_cancel_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_cancel_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $before_save;
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_cancel_detail_data['is_changed'] = 0;
                    }
                    // pr($order_cancel_detail_data);die;
                    $order_cancel_detail_data['edited_id'] = @$order_id;
                    $order_cancel_detail_data['edited_by'] = @$order_by_customer_details[0]->id;
                    $order_cancel_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                            $order_cancel_detail_data['edited_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                        }
                    $CI->db->insert('tbl_orders_logs_detial',@$order_cancel_detail_data);

               // }



            }
            else if(strtolower($action)=='add'){
                $order_by_customer_details = getUsers($after_save['user_id']);
                $order_log['order_type'] = '1';
                $order_log['added_id'] = @$order_id;
                $order_log['added_by'] = @$order_by_customer_details[0]->id;
                if (!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                    $order_log['added_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                    $order_log['email_id'] = @$order_by_customer_details[0]->email_address;
                    $order_log['groups_id'] = @$order_by_customer_details[0]->groups_id;
                }

                // $order_add_data['order_status'] = 'confirm';
                if(isset($after_save['order_number']) && !empty($after_save['order_number'])){
                        $order_add_data['order_number'] = $after_save['order_number'];
                }
                if(isset($after_save['total_amount']) && !empty($after_save['total_amount'])){
                        $order_add_data['total_amount'] = $after_save['total_amount'];
                }
                if(isset($after_save['selectdeliverydate']) && !empty($after_save['selectdeliverydate'])){
                        $order_add_data['selectdeliverydate'] = $after_save['selectdeliverydate'];
                }

                if(isset($after_save['selectdeliverytime']) && !empty($after_save['selectdeliverytime'])){
                        $order_add_data['selectdeliverytime'] = $after_save['selectdeliverytime'];
                }
                if(isset($after_save['payment_type']) && !empty($after_save['payment_type'])){
                        $order_add_data['payment_type'] = $after_save['payment_type'];
                }
                if(isset($after_save['order_date']) && !empty($after_save['order_date'])){
                        $order_add_data['order_date'] = $after_save['order_date'];
                }
                if(isset($after_save['order_status']) && !empty($after_save['order_status'])){
                        $order_add_data['order_status'] = $after_save['order_status'];
                }
                if(isset($after_save['assigned_store_id']) && !empty($after_save['assigned_store_id'])){
                        $order_add_data['store_id'] = $after_save['assigned_store_id'];
                }
                $insert_data = array_merge($order_add_data,$order_log);
                        $CI->db->insert('tbl_orders_logs',@$insert_data);

                        $is_changed = 0;
                    if($after_save['order_number']!=$before_save['order_number']  && $after_save['order_number']){
                        $order_add_detail_data['before_order_number'] = $before_save['order_number'];
                        $order_add_detail_data['after_order_number'] = $after_save['order_number'];
                        $is_changed++;
                    }
                    if($after_save['order_date']!=$before_save['order_date']  && $after_save['order_date']){
                        // $order_add_detail_data['before_order_date'] = $before_save['order_date'];
                        $order_add_detail_data['order_date'] = $after_save['order_date'];
                        $is_changed++;
                    }
                    if($after_save['total_amount']!=$before_save['total_amount']  && $after_save['total_amount']){
                        $order_add_detail_data['before_total_amount'] = $before_save['total_amount'];
                        $order_add_detail_data['after_total_amount'] = $after_save['total_amount'];
                        $is_changed++;
                    }
                    if($after_save['selectdeliverydate']!=$before_save['selectdeliverydate']  && $after_save['selectdeliverydate']){
                        $order_add_detail_data['before_selectdeliverydate'] = $before_save['selectdeliverydate'];
                        $order_add_detail_data['after_selectdeliverydate'] = $after_save['selectdeliverydate'];
                        $is_changed++;
                    }

                    if($after_save['selectdeliverytime']!=$before_save['selectdeliverytime']  && $after_save['selectdeliverytime']){
                        $order_add_detail_data['before_selectdeliverytime'] = $before_save['selectdeliverytime'];
                        $order_add_detail_data['after_selectdeliverytime'] = $after_save['selectdeliverytime'];
                        $is_changed++;
                    }

                    if($after_save['payment_type']!=$before_save['payment_type'] && $after_save['payment_type']){
                        $order_add_detail_data['before_payment_type'] = $before_save['payment_type'];
                        $order_add_detail_data['after_payment_type'] = $after_save['payment_type'];
                        $is_changed++;
                    }

                    if($after_save['assigned_store_id']!=$before_save['assigned_store_id'] && $after_save['assigned_store_id']){
                        $order_add_detail_data['before_store_id'] = $before_save['assigned_store_id'];
                        $order_add_detail_data['after_store_id'] = $after_save['assigned_store_id'];
                        $is_changed++;
                    }

                    if($after_save['order_status'] && !empty($after_save['order_status'])){
                        $order_add_detail_data['before_status'] = $before_save['order_status'];
                        $order_add_detail_data['after_status'] = $after_save['order_status'];
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_add_detail_data['is_changed'] = 0;
                    }
                        $order_add_detail_data['edited_id'] = @$order_id;
                        $order_add_detail_data['edited_by'] = @$order_by_customer_details[0]->id;
                        if(!empty($order_by_customer_details) && count($order_by_customer_details) > 0) {
                            $order_add_detail_data['edited_by_name'] = @$order_by_customer_details[0]->first_name.' '.@$order_by_customer_details[0]->last_name;
                        }

                        $order_add_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_add_detail_data);

                  //  }
                    return 1;

            }
            elseif(strtolower($action)=='edit'){
                $orderDetails = getOrderDetailsNew(@$order_id);
                $num_edit = number_of_order_edit(@$order_id,$orderDetails[0]->user_id);
                $previous_order_log_details = getOrderPreviousDetails($orderDetails[0]->id);
                // pr($orderDetails);die;
                if($num_edit){

                }else{
                 $num_edit = number_of_order_edit(@$order_id,$logged_in_added_by);
                }

                if($num_edit->id){
                    $number = $num_edit->num_edit;
                    $check_num_edit = $number + 1;
                    $order_log_edit['num_of_edit'] = @$check_num_edit;
                    $order_log_edit['edited_by'] = @$logged_in_added_by;
                    $CI->db->update('tbl_orders_logs',@$order_log_edit,array('id'=>$num_edit->id,'order_number'=>$orderDetails[0]->order_number));

                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                     if($orderDetails[0]->order_status){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_edit_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_edit_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_edit_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_edit_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_edit_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_edit_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->assigned_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->assigned_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_picker'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Picker';
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_delivery_boy'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Delivery Boy';
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_edit_detail_data['is_changed'] = 0;
                    }
                        $order_edit_detail_data['edited_id'] = @$order_id;
                        $order_edit_detail_data['edited_by'] = @$logged_in_added_by;
                        $logged_inDetails = getUsers($logged_in_added_by);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }

                        $order_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_edit_detail_data);
                        // echo $CI->db->last_query();die;
                  //  }
                    return 1;


                }else{
                    $orderDetails = getOrderDetailsNew(@$order_id);
                    $number = 0;
                    $check_num_edit = $number + 1;
                    //pr($orderDetails);

                    ################for already added order starts########3
                   // $order_by_customer_details = getUsers($orderDetails[0]->order_number);

                    $order_log['num_of_edit'] = @$check_num_edit;
                    $order_log['order_type'] = '1';
                        $order_log['edited_by'] = @$logged_in_added_by;
                        $order_log['added_id'] = @$order_id;
                        $order_log['added_by'] = @$orderDetails[0]->user_id;
                        $logged_inDetails = getUsers(@$orderDetails[0]->user_id);
                        // pr($logged_inDetails);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                            $order_log['email_id'] = @$logged_inDetails[0]->email_address;
                            $order_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                        }

                        // $order_add_data['order_status'] = 'confirm';
                        $order_add_data['order_number'] = $orderDetails[0]->order_number;
                        $order_add_data['total_amount'] = $orderDetails[0]->total_amount;
                        $order_add_data['selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $order_add_data['selectdeliverytime'] = $orderDetails[0]->selectdeliverytime;
                        $order_add_data['payment_type'] = $orderDetails[0]->payment_type;
                        $order_add_data['order_date'] =$orderDetails[0]->order_date;
                        $order_add_data['order_status'] =$orderDetails[0]->order_status;
                        $order_add_data['store_id'] =$orderDetails[0]->assigned_store_id;

                        $insert_data = array_merge($order_add_data,$order_log);

                       // pr($insert_data);die;
                        $CI->db->insert('tbl_orders_logs',@$insert_data);







                    //if($after_save['first_name']!="" && $before_save['id']!=""){
                        $is_changed = 0;
                     if($orderDetails[0]->order_status){
                        $order_edit_detail_data['before_status'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_edit_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['order_date'] = $orderDetails[0]->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverydate'] =$orderDetails[0]->selectdeliverydate;
                        $order_edit_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverytime){
                        $order_edit_detail_data['before_selectdeliverytime'] = $orderDetails[0]->selectdeliverytime;
                        $order_edit_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverytime;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_edit_detail_data['before_total_amount'] = $orderDetails[0]->total_amount;
                        $order_edit_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_payment_type'] = $orderDetails[0]->payment_type;
                        $order_edit_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }

                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $orderDetails[0]->assigned_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->assigned_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_picker'){
                        $order_edit_detail_data['before_status'] = $orderDetails[0]->assigned_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Picker';
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_delivery_boy'){
                        $order_edit_detail_data['before_status'] = $orderDetails[0]->assigned_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Delivery Boy';
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_edit_detail_data['is_changed'] = 0;
                    }
                        $order_edit_detail_data['edited_id'] = @$order_id;
                        $order_edit_detail_data['edited_by'] = @$logged_in_added_by;
                        $logged_inDetails = getUsers($logged_in_added_by);
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }

                        $order_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        $CI->db->insert('tbl_orders_logs_detial',@$order_edit_detail_data);
                        // echo $CI->db->last_query();die;
                  //  }
                    return 1;


                    ################for already added order ends########3







                }


                $order_log['added_id'] = @$order_id;
                $order_log['added_by'] = @$logged_in_added_by;
                $order_log['num_of_edit'] = @$check_num_edit;
                $logged_inDetails = getUsers($logged_in_added_by);
                // pr($logged_inDetails);
                if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                    $order_log['added_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                    $order_log['groups_id'] = @$logged_inDetails[0]->groups_id;
                }

                //if($after_save['first_name']!="" && $before_save['id']!=""){
                    $is_changed = 0;
                    if($orderDetails[0]->order_status){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = $orderDetails[0]->order_status;
                        $is_changed++;
                    }
                    if($orderDetails[0]->order_date){
                        // $order_edit_detail_data['order_date'] = $orderDetails[0]->order_status;
                        $order_edit_detail_data['order_date'] = $previous_order_log_details->order_date;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverydate'] = $previous_order_log_details->after_selectdeliverydate;
                        $order_edit_detail_data['after_selectdeliverydate'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->selectdeliverydate){
                        $order_edit_detail_data['before_selectdeliverytime'] = $previous_order_log_details->after_selectdeliverytime;
                        $order_edit_detail_data['after_selectdeliverytime'] = $orderDetails[0]->selectdeliverydate;
                        $is_changed++;
                    }
                    if($orderDetails[0]->total_amount){
                        $order_edit_detail_data['before_total_amount'] = $previous_order_log_details->after_total_amount;
                        $order_edit_detail_data['after_total_amount'] = $orderDetails[0]->total_amount;
                        $is_changed++;
                    }
                    if($orderDetails[0]->payment_type){
                        $order_edit_detail_data['before_payment_type'] = $previous_order_log_details->after_payment_type;
                        $order_edit_detail_data['after_payment_type'] = $orderDetails[0]->payment_type;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save)){
                        $order_edit_detail_data['before_store_id'] = $previous_order_log_details->after_store_id;
                        $order_edit_detail_data['after_store_id'] = $orderDetails[0]->after_store_id;
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_picker'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Picker';
                        $is_changed++;
                    }
                    if(isset($before_save) && !empty($before_save) && $before_save=='assign_delivery_boy'){
                        $order_edit_detail_data['before_status'] = $previous_order_log_details->after_status;
                        $order_edit_detail_data['after_status'] = 'Assigned Delivery Boy';
                        $is_changed++;
                    }
                    if($is_changed==0){
                        $order_edit_detail_data['is_changed'] = 0;
                    }
                    // pr($order_edit_detail_data);die;
                    $order_edit_detail_data['edited_id'] = @$order_id;
                    $order_edit_detail_data['edited_by'] = @$logged_in_added_by;
                    $order_edit_detail_data['created_date'] = @date('Y-m-d H:i:s');
                        if(!empty($logged_inDetails) && count($logged_inDetails) > 0) {
                            $order_edit_detail_data['edited_by_name'] = @$logged_inDetails[0]->first_name.' '.@$logged_inDetails[0]->last_name;
                        }
                    $CI->db->insert('tbl_orders_logs_detial',@$order_edit_detail_data);

               // }



            }
            // pr($order_log);die;
            // $CI->db->insert('tbl_orders_logs',@$order_log);
        }
      }

    }

    //===================================================== ORDERS LOGS ENDS ========================================//
function checkStock_by_POS($store_id = "", $weight_id = "")
{
    $result = [];
    $pos_store_id = [7=>2,6=>3,8=>4];
    $CI     = & get_instance();
    if (isset($store_id) && !empty($store_id) && isset($weight_id) && !empty($weight_id))
    {
        $CI->db->select("pp.pos_product_code,p.product_name");
        $CI->db->join('tbl_product p','p.product_id = pp.product_id','inner');
        $CI->db->where('pp.id', $weight_id);
        $query = $CI->db->get("tbl_product_price pp");
        if ($query->num_rows())
        {
            if(isset($query->row()->pos_product_code) && !empty($query->row()->pos_product_code))
            {
                $data = getStock_by_POS($pos_store_id[$store_id],$query->row()->pos_product_code);
                $result['stock'] = $data['items'][0]['stock'][0]['stock'];
                $result['name']  = $query->row()->product_name;
                // pr($query->row());
                return $result;
            }
        }

    }
    return false;
}

function getStock_by_POS($store_id = "", $item_id = "")
{
    $query_string = "";
    $query_string .= "?limit=1&q=appliesOnline==1,outletId==".$store_id.",itemId==".$item_id;
    $url = Gofrugal_items_url.$query_string;
    /* Init cURL resource */
    $curl = curl_init($url);
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_ENCODING => "",
    CURLOPT_TIMEOUT => 30000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      // Set Here Your Requested Headers
         'Content-Type: application/json',
         'X-Auth-Token: '.Gofrugal_Auth_Token
        ),
    ));

    /* execute request */
    $result = curl_exec($curl);
    $result = json_decode(utf8_encode($result),true);
    // echo json_last_error_msg();
    // pr($result['items']);die;
    /* close cURL resource */
    curl_close($curl);
    return $result;
}


function prip($data)
{
    // echo "string";die;
    if($_SERVER['REMOTE_ADDR'] == '27.7.212.228'  || $_SERVER['REMOTE_ADDR'] == '223.233.101.86')
    {
        echo "<pre>";
        print_r($data);
        die;
    }
}

function check_store_inventory($store_id, $product_id)
{
    $CI     = &get_instance();
    if ($store_id) {
        $CI->db->select('product_id');
        $CI->db->where('store_id', $store_id);
        $CI->db->where('product_id', $product_id);
        $query = $CI->db->get('tbl_inventory');

        echo $CI->db->last_query(); die;

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function getProductCountByCategoryId($category_id)
{
    $CI     = &get_instance();
    $CI->db->where('FIND_IN_SET('.$category_id.', category_ids)');
    $query = $CI->db->get('tbl_product');
    return $query->num_rows();
}

function getCategoryIdByName($category_name)
{
    $CI     = &get_instance();
    $CI->db->select('id');
    $CI->db->where('name', $category_name);
    // $CI->db->like('name', $category_name);
    $cat_id = $CI->db->get('tbl_categories')->row();
    if (!empty($cat_id)) {
        return $cat_id->id;
    } else {
        return 0;
    }

}

function check_pos_user() {
    if($_SESSION['auth_user']['groups_id'] == 6 OR $_SESSION['auth_user']['groups_id'] == 5) {

        return redirect(base_url()."poscart");
    }
}

function limit_echo($x,$length)
{
  if(strlen($x)<=$length)
  {
    echo strtoupper($x);
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo strtoupper($y);
  }
}

 function send_pushnotification($user_id,$msg){

       $CI     = &get_instance();
       $fcm_id = $CI->db->get_where('tbl_users',['id '=>$user_id])->row('device_token');
       // payload data, it will vary according to requirement
       $fields=array(
          'to'=>$fcm_id,
          'data'=>array(
             "title"=>$msg,
             "body"=>$msg,
             "sound"=>base_url()."assets/audio/bell.mp3"
          )
        );

        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key='AAAAf_zJSvM:APA91bGl7VuwZIL3r4ki72sh5oYvaTUJel33j_9yUS68mIE4X2hNe1bXnYlCceO-4zIGOC1c-3QyuCiitqATWG92ufj_U3Wp4kSOJBJEi5AFHY8fvqIDtaU6cpQvIqU_OqXNSNISNAMF';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }

    function send_orderpushnotification($user_id,$msg,$newurls){

       $CI     = &get_instance();
       $fcm_id = $CI->db->get_where('tbl_users',['id '=>$user_id])->row('device_token');
       // payload data, it will vary according to requirement
       $fields=array(
          'to'=>$fcm_id,
          'data'=>array(
             "title"=>$msg,
             "body"=>$msg,
             "sound"=>base_url()."assets/audio/bell.mp3",
             "url" => $newurls
          ),

        );

        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key='AAAAf_zJSvM:APA91bGl7VuwZIL3r4ki72sh5oYvaTUJel33j_9yUS68mIE4X2hNe1bXnYlCceO-4zIGOC1c-3QyuCiitqATWG92ufj_U3Wp4kSOJBJEi5AFHY8fvqIDtaU6cpQvIqU_OqXNSNISNAMF';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }


    function getadminuser(){

         $CI     = &get_instance();
         $admin = $CI->db->get_where('tbl_users',['groups_id'=>'4'])->result_array();
         return $admin;

    }



  function check_login_user(){

     if(empty($_SESSION['auth_user']['mobile'])){

         $auth_user = explode(",", $_COOKIE["auth_user"]);
            $username = $auth_user[0];
            $userlast_name = $auth_user[1];
            $useremail = $auth_user[2];
            $userid = $auth_user[3];
            $usermobile = $auth_user[4];
            $auth = array( 'first_name'=> $username,'last_name'=>$userlast_name, 'email_address'=>$useremail, 'users_id'=> $userid, 'mobile'=> $usermobile);
            $data['auth_user'] = $auth;
            $user_preference = explode(",", $_COOKIE["user_preference"]);
            $day_value = array($user_preference[2],$user_preference[3],$user_preference[4],$user_preference[5], $user_preference[6], $user_preference[7], $user_preference[8]);
            $day = implode($day_value,', ');
            $time_value = array($user_preference[9], $user_preference[10], $user_preference[11], $user_preference[12], $user_preference[13], $user_preference[14], $user_preference[15]);
            $store_coordinates_value = array($user_preference[20],  $user_preference[21]);
            $store_coordinates= implode($store_coordinates_value,', ');
            $store_address_value = array($user_preference[18], $user_preference[19]);
            $store_address = implode($store_address_value,', ');
            $data['user_preference'] =  (object) array('order_type'=>$user_preference[0], 'categories'=>$user_preference[1],'order_type_name'=>$user_preference[16],'order_preference_store'=>$user_preference[17],'store_address'=>$store_address, 'day'=>$day, 'time'=>$time_value, 'Deliveryy_store_name'=>$user_preference[22], 'store_coordinates'=>$store_coordinates);
            $CI = & get_instance();
            $CI->session->set_userdata($data);
            return true;

     }
 }


 function countdeliveryorder($type){
     $CI     = &get_instance();
    if($type == 'All'){
       $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'2','pos_id'=>'0'])->result_array();
    }

    if($type == 'New'){
     $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'2','pos_id'=>'0','order_status'=>'Order Confirm'])->result_array();
    }


    if($type == 'InProcess'){
        $CI->db->where("order_type ",'2');
        $CI->db->where("pos_id", 0);
        $CI->db->where("order_status !=",'Order Confirm');
        $CI->db->where("order_status !=",'Delivered');
        $CI->db->where("order_status !=",'Cancel');
        $CI->db->where("order_status !=",'Return');
        $CI->db->where("order_status !=",'WAITING PAYMENT CONFIRMATION');
        $CI->db->where("order_status !=",'PAYMENT FAILED');
        $totalcount  =  $CI->db->get('tbl_order')->result_array();
    }

     if($type == 'Delivered'){
      $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'2','pos_id'=>'0','order_status'=>'Delivered'])->result_array();
    }

    if($type == 'Cancel'){
      $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'2','pos_id'=>'0','order_status'=>'Cancel'])->result_array();
    }

    if($type == 'Dropped'){

        $CI->db->where('order_type','2');
        $CI->db->where("pos_id", 0);
        $CI->db->where('order_status','WAITING PAYMENT CONFIRMATION');
        $CI->db->or_where('order_status','PAYMENT FAILED');
        $totalcount  =  $CI->db->get('tbl_order')->result_array();
    }

    return count($totalcount);

 }

  function countpickuporder($type){
     $CI     = &get_instance();
    if($type == 'All'){
       $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'1','pos_id'=>'0'])->result_array();
    }

    if($type == 'New'){
     $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'1','pos_id'=>'0','order_status'=>'Order Confirm'])->result_array();
    }


    if($type == 'InProcess'){
        $CI->db->where("order_type",'1');
        $CI->db->where("order_status !=", 'Order Confirm');
        $CI->db->where("order_status !=", "Return");
        $CI->db->where("order_status !=", "Delivered");
        $CI->db->where("order_status !=", "Picked");
        $CI->db->where("order_status !=", "Picked up by Customer");
        $CI->db->where("order_status !=", 'PAYMENT FAILED');
        $CI->db->where("order_status !=", 'WAITING PAYMENT CONFIRMATION');
        $CI->db->where("order_status !=", "Return ");
        $CI->db->where("order_status !=", "Cancel");
        $CI->db->where("pos_id", 0);
        $totalcount  =  $CI->db->get('tbl_order')->result_array();
    }

     if($type == 'Picked'){

       $condition = array('Picked','Picked up by Customer');
       $CI->db->where("order_type",'1');
       $CI->db->where("pos_id", 0);
       $CI->db->where_in("order_status",$condition);
       $totalcount  = $CI->db->get('tbl_order')->result_array();

    }

     if($type == 'Return'){
      $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'1','pos_id'=>'0','order_status'=>'Return'])->result_array();
    }





    if($type == 'Cancel'){
      $totalcount  = $CI ->db->get_where('tbl_order',['order_type'=>'1','pos_id'=>'0','order_status'=>'Cancel'])->result_array();
    }

    if($type == 'Dropped'){

        $CI->db->where('order_type','1');
        $CI->db->where("pos_id", 0);
        $CI->db->where('order_status','WAITING PAYMENT CONFIRMATION');
        $CI->db->or_where('order_status','PAYMENT FAILED');
        $totalcount  =  $CI->db->get('tbl_order')->result_array();
    }

    return count($totalcount);

 }


 if(!function_exists('insert_layerdata')){
    function insert_layerdata($data,$or_number)
    {
        $CI = &get_instance();

        foreach ($data as $key => $val) {

            $qnty = $val['qnty'];
            $inv = $CI->db->get_where('tbl_inventory',['id'=>$val['id']])->row();
            $product = $CI->db->get_where('tbl_product',['product_id'=>$inv->product_id])->row();
            $product_price = $CI->db->get_where('tbl_product_price',['id'=>$inv->priceid])->row();

            $pro['product_id'] = $inv->product_id;
            $pro['order_id'] =   $or_number;
            $pro['ean_code'] =   $product_price->ean_code;
            $pro['product_name'] = $product->product_name;
            $pro['store_id'] = $inv->store_id;
            $pro['product_qty'] = $qnty;
            $pro['type '] = "1";
            $pro['total_stock'] = $qnty;
            $pro['date'] = date('Y-m-d');
            $CI->db->insert('tbl_product_layer',$pro);

        }
        return true;
    }
}


if(!function_exists('get_supplier_id'))
{
    function get_supplier_id()
    {
        $CI=get_instance();

        $CI->db->select("*");
        $CI->db->from("tbl_brand");
        $CI->db->limit(1);
        $CI->db->order_by('brand_id',"DESC");
        $query = $CI->db->get();
        $result = $query->row_array();
        if(empty($result)){
            return 'SUPP0001';
        }else{
             $ID = $result['brand_id']+1;
             return 'SUPP000'.$ID;
        }


    }
}

if(!function_exists('supplier_all_brand'))
{
    function supplier_all_brand()
    {
        $CI=get_instance();

        $CI->db->select("brand_id, brand_name");
        $CI->db->from("tbl_brand");
        $CI->db->where('status', 1);
        $query = $CI->db->get();
        $result = $query->result_array();
        if(!empty($result)){
            return $result;
        }


    }
}


if(!function_exists('getbrandaddress'))
{
    function  getbrandaddress($name)
    {
        $CI=get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_brand");
        $CI->db->like('brand_name',$name);
        $query = $CI->db->get();
        $result = $query->row();
        if(!empty($result)){
            return $result->address;
        }
    }
}

if(!function_exists('getinventory'))
{
    function  getinventory($id)
    {
        $CI=get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_product_price");
        $CI->db->where('id',$id);
        $query = $CI->db->get();
        $result = $query->row();

        $CI->db->select("*");
        $CI->db->from("tbl_inventory");
        $CI->db->where('priceid',$result->id);
        $query1 = $CI->db->get();
        $result1 = $query1->row(); 

        if(!empty($result1)){
            return $result1->id;
        }
    }
}
if(!function_exists('getCityByStateId'))
{
    function getCityByStateId($state, $city=0)
    {
        $CI=get_instance();
        $city_list = $CI->db->get_where("tbl_cities", ['state_id'=>$state])->result();

        $html = '';
        if(count($city_list)>0){
            foreach ($city_list as $key => $value) {
                $html .= '<option value="'.$value->id.'" '.($city==$value->id ? "selected" : "").'>'.$value->city_name.'</option>';
            }
        }else{
            $html .='<option value="0">No City Found...</option>';
        }
        echo $html;
    }
}

if(!function_exists('getStateByCountryId'))
{
    function getStateByCountryId($country, $state=0)
    {
        $CI=get_instance();
        $state_list = $CI->db->get_where("tbl_states", ['country_id'=>$country])->result();

        $html = '';
        if(count($state_list)>0){
            foreach ($state_list as $key => $value) {
                $html .= '<option value="'.$value->id.'" '.($state==$value->id ? "selected" : "").'>'.$value->name.'</option>';
            }
        }else{
            $html .='<option value="0">No State Found...</option>';
        }
        echo $html;
    }
}
if(!function_exists('getCurrentUserGroupId'))
{
    function getCurrentUserGroupId()
    {
        $CI=get_instance();
        $userdata = $CI->session->userdata('system_admin');
        return $userdata['groups_id'];
    }
}
if(!function_exists('getCurrentUserStoreId'))
{
    function getCurrentUserStoreId()
    {
        $CI=get_instance();
        $userdata = $CI->session->userdata('system_admin');
        return $userdata['store_id'];
    }
}
if(!function_exists('getUOMList'))
{
    function getUOMList()
    { 
        $CI=get_instance();
        return $CI->db->get_where("tbl_uom", ['status'=>1])->result();        
    }
}
if(!function_exists('getDealerTypeList'))
{
    function getDealerTypeList()
    { 
        $CI=get_instance();
        return $CI->db->get_where("tbl_dealer_type", ['status'=>1])->result();        
    }
}
if(!function_exists('getUOMNameById'))
{
    function getUOMNameById()
    { 
        $CI=get_instance();
        $uomList =  $CI->db->get_where("tbl_uom", ['status'=>1])->result();
        $uom_arr = array();
        foreach ($uomList as $key => $value) {
            $uom_arr[$value->id] = $value->uom_name;
        }
        return $uom_arr;
    }
}
 

if(!function_exists('get_field_value'))
{
    function get_field_value($table,$field,$where)
    {
        $CI=get_instance(); 
        $rest = $CI->db->get_where($table,$where)->row_array();
        if ($rest) {
            return $rest[$field];
        }
        else
        {
            return false;
        }
    }
}


if(!function_exists('get_division_val'))
{
    function get_division_val()
    {
        $CI=get_instance();   


        $session_id   = $_GET['rfq_draft_id']; 


        $user_id  = $_SESSION['auth_user']['users_id'];
        $CI->db->select("*");
        $CI->db->where("user_id",$user_id);
        if(empty($session_id) && $session_id == ''){
          $CI->db->where('rfq_draft_id IS NULL', null, false);
        }
        $CI->db->order_by("id", "desc");
        $query = $CI->db->get('tbl_activecart'); 
        $catdata =  $query->row_array();   

        $div = $catdata['category_ids'];
        $array = explode(',',$div);
        $div_id = $array[0]; 
        $rest = $CI->db->get_where('tbl_categories',['id'=>$div_id])->row();


        if ($rest) {
            return $rest->name;
        }
        else
        {
            return false;
        }
    }
}

if(!function_exists('get_category_val'))
{
    function get_category_val()
    {
        $CI=get_instance();   
        
        $session_id   = $_GET['rfq_draft_id']; 

        $user_id  = $_SESSION['auth_user']['users_id'];
        $CI->db->select("*");
        $CI->db->where("user_id",$user_id);
        if(empty($session_id) && $session_id == '' ){
        $CI->db->where('rfq_draft_id IS NULL', null, false); 
        }
        $CI->db->order_by("id", "desc");
        $query = $CI->db->get('tbl_activecart'); 
        $catdata =  $query->row_array();   
        $div = $catdata['category_ids'];
        $array = explode(',',$div);
        $div_id = $array[1];
        $rest = $CI->db->get_where('tbl_categories',['id'=>$div_id])->row();
        if ($rest) {
            return $rest->name;
        }
        else
        {
            return false;
        }
    }
}



if(!function_exists('get_category_id_val'))
{
    function get_category_id_val()
    {
        $CI=get_instance();   
          
        $session_id   = $_GET['rfq_draft_id']; 

        $user_id  = $_SESSION['auth_user']['users_id'];
        $CI->db->select("*");
        $CI->db->where("user_id",$user_id);  
        if(empty($session_id) && $session_id == ''){
         $CI->db->where('rfq_draft_id IS NULL', null, false);
        }
        $CI->db->order_by("id", "desc");
        $query = $CI->db->get('tbl_activecart'); 
        $catdata =  $query->row_array();   
        $div = $catdata['category_ids'];
        $array = explode(',',$div);
        $div_id = $array[1];
        $rest = $CI->db->get_where('tbl_categories',['id'=>$div_id])->row();
        if ($rest) {
            return $rest->id;
        }
        else
        {
            return false;
        }
    }
}




if(!function_exists('get_subcategory_data'))
{
    function get_subcategory_data()
    {  
        $CI=get_instance();   

        $cat_id  = get_category_id_val();
        $CI->db->select('*');
        $CI->db->where('find_in_set("'.$cat_id.'", category_ids) <> 0');
        $CI->db->from('tbl_product');
        $CI->db->group_by('product_name');
        $query = $CI->db->get();
        $subcategorydata =  $query->result();   
        if ($subcategorydata) {
            return $subcategorydata;
        }
        else
        {
            return false;
        }
    }
}

if(!function_exists('get_counter_price'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function get_counter_price($order_id,$product_id,$customer_id,$sub_variant_id)
    {
        $CI=get_instance(); 
        $CI->db->select('order_did, id, buyer_price, seller_price, seller_mrp, seller_discount, seller_price_basis, seller_delivery_date, seller_payment_terms, seller_remarks, seller_additional_remarks');
        $CI->db->where('sub_order_variant_id', $sub_variant_id);
        $CI->db->where('order_did', $order_id);
        // $CI->db->where('product_id', $product_id);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('status', '1');
        $CI->db->limit(1);
        // $CI->db->where('buyer_price', $price);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        if($counterRate->num_rows() > 0) {
            return $counterRate->result();
        }
    }
}


if(!function_exists('get_last_counter_date'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function get_last_counter_date($vendor_user_id, $order_id)
    {
        $CI=get_instance(); 
        $CI->db->select('created_date');
        $CI->db->where('rfq_number', $order_id);
        $CI->db->where('seller_id', $vendor_user_id);
        $CI->db->where('status', '1');
        // $CI->db->limit(1);
        // $CI->db->where('buyer_price', $price);
        $CI->db->order_by('id', DESC);
        $CI->db->limit(1);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        // echo $CI->db->last_query();
        if($counterRate->num_rows() > 0) {
            $data = $counterRate->row();
            // return $data->created_date;
            $date = strtotime($data->created_date);
            return date('d/m/Y', $date);
        }
    }
}

if(!function_exists('get_vendor_quoted_percent'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function get_vendor_quoted_percent($vendor_id, $vendor_user_id, $rfq_number, $order_id)
    {
        $CI = & get_instance();
        // return 10;
        $CI->db->select('order_did');
        $CI->db->where('order_id', $order_id);
        $CI->db->where('store_id', $vendor_id);
        $vendor_order_details_data = $CI->db->get('tbl_order_detail')->result();
        $order_sub_product_count = 0;
        $price_counter_count = 0;

        if(!empty($vendor_order_details_data) && count($vendor_order_details_data)>0 ){
            $order_details_ids = array();
            foreach ($vendor_order_details_data as $key => $value) {
                $order_details_ids[]=$value->order_did;
            }
            $CI->db->select('id');
            $CI->db->where('record_type', "Order");
            $CI->db->where_in('order_details_id', $order_details_ids);
            $CI->db->order_by('id', "ASC");

            $order_sub_product_data = $CI->db->get('order_sub_product')->result();
            $order_sub_product_ids = array();
            if(!empty($order_sub_product_data)){
                foreach ($order_sub_product_data as $key => $value) {
                    $order_sub_product_ids[]=$value->id;
                }
            }
            $order_sub_product_count = count($order_sub_product_ids);

            $CI->db->select('id');
            $CI->db->where_in('order_did', $order_details_ids);
            $CI->db->where_in('sub_order_variant_id', $order_sub_product_ids);
            $CI->db->where('seller_id', $vendor_user_id);
            $CI->db->group_by('order_did');
            $price_counter_count = $CI->db->get('tbl_price_counter_rate')->num_rows();
        }
        $percent = ($price_counter_count/$order_sub_product_count)*100;
        if($percent){
            $percent = number_format((float)$percent, 2, '.', '');
        }
        return $percent."% (".$price_counter_count."/".$order_sub_product_count.")";
    }
}

if(!function_exists('getPaymentTerms'))
{
    function getPaymentTerms($user_id, $order_number)
    {
        $CI=get_instance();
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('seller_payment_terms');
        $CI->db->where('seller_id', $user_id);
        $CI->db->where('rfq_number', $order_number);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('seller_payment_terms !=', '');
        $CI->db->where('status', '1');
        $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        if($counterRate->num_rows() > 0) {
            return $counterRate->row('seller_payment_terms').' Days';
        }
        return '&nbsp;';
    }
}
if(!function_exists('getDeliveryPeriod'))
{
    function getDeliveryPeriod($user_id, $order_number)
    {
        $CI=get_instance();
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('seller_delivery_date');
        $CI->db->where('seller_id', $user_id);
        $CI->db->where('rfq_number', $order_number);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('seller_delivery_date !=', '');
        $CI->db->where('status', '1');
        $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        if($counterRate->num_rows() > 0) {
            return $counterRate->row('seller_delivery_date');
        }
        return '&nbsp;';
    }
}
if(!function_exists('getPriceBasis'))
{
    function getPriceBasis($user_id, $order_number)
    {
        $CI=get_instance();
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('seller_price_basis');
        $CI->db->where('seller_id', $user_id);
        $CI->db->where('rfq_number', $order_number);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('seller_price_basis !=', '');
        $CI->db->where('status', '1');
        $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        if($counterRate->num_rows() > 0) {
            return $counterRate->row('seller_price_basis');
        }
        return '&nbsp;';
    }
}
if(!function_exists('getSellerRemarks'))
{
    function getSellerRemarks($user_id, $order_number)
    {
        $CI=get_instance();
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('seller_remarks');
        $CI->db->where('seller_id', $user_id);
        $CI->db->where('rfq_number', $order_number);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('seller_remarks !=', '');
        $CI->db->where('status', '1');
        $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        if($counterRate->num_rows() > 0) {
            return $counterRate->row('seller_remarks');
        }
        return '&nbsp;';
    }
}
if(!function_exists('getSellerAdditionalRemarks'))
{
    function getSellerAdditionalRemarks($user_id, $order_number)
    {
        $CI=get_instance();
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('seller_additional_remarks');
        $CI->db->where('seller_id', $user_id);
        $CI->db->where('rfq_number', $order_number);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('seller_additional_remarks !=', '');
        $CI->db->where('status', '1');
        $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        if($counterRate->num_rows() > 0) {
            return $counterRate->row('seller_additional_remarks');
        }
        return '&nbsp;';
    }
}
if(!function_exists('getSellerPrice'))
{
    function getSellerPrice($product_name, $vendor_id, $o_id, $start)
    {
        $CI=get_instance();
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('order_did');
        $CI->db->where('product_name', $product_name);
        $CI->db->where('order_id', $o_id);
        // $CI->db->where('order_did', $order_details_id);
        $CI->db->where('store_id', $vendor_id);
        $CI->db->where('customer_id', $customer_id);
        $CI->db->limit(1);
        $orderDetails = $CI->db->get('tbl_order_detail');
        // pr($orderDetails->result());
        // echo $CI->db->last_query();//die;
        // echo "<br>";
        if($orderDetails->num_rows() > 0) {
            $order_details = $orderDetails->row();
            $CI->db->select('id');
            $CI->db->order_by('id', DESC);
            $CI->db->limit($start);
            // $CI->db->limit('1', $start);
            $CI->db->where('order_details_id', $order_details->order_did);
            $sub_product = $CI->db->get('order_sub_product'); 
            
            // echo $CI->db->last_query();//die;
            // echo "<br>";
            if($sub_product->num_rows() > 0) {
                $sub_products = $sub_product->result();
                // return $sub_products;
                $sub_pro_row = array();
                foreach ($sub_products as $key => $value) {
                    $sub_pro_row = $value;
                }
                // pr($sub_pro_row);
                return [$order_details->order_did, $sub_pro_row->id];
            }
            return false;
        }
        return false;
    }
}


if(!function_exists('get_all_price'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function get_all_price($order_id,$product_id,$customer_id,$sub_variant_id)
    {
        $CI=get_instance(); 
        $CI->db->select('order_did, id, buyer_price, seller_price, created_date');
        $CI->db->where('sub_order_variant_id', $sub_variant_id);
        $CI->db->where('order_did', $order_id);
        // $CI->db->where('product_id', $product_id);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('status', '1');
        // $CI->db->where('buyer_price', $price);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        if($counterRate->num_rows() > 0) {
            return $counterRate->result();
        }
        return '&nbsp;';
    }
}
if(!function_exists('is_buyer_price_submitted'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function is_buyer_price_submitted($val)//only for buyer
    {
        $CI=get_instance(); 
        $order_id       = $val->order_details_id;
        $variant_id       = $val->id;
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('order_did, id, buyer_price, created_date');
        $CI->db->where('order_did', $order_id);
        $CI->db->where('sub_order_variant_id', $variant_id);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        // echo $CI->db->last_query();//die;
        if($counterRate->num_rows() > 0) {
            $all_counters = $counterRate->row();
            return $all_counters->buyer_price!='' ? true : false;
        }
        return false;
    }
}
if(!function_exists('is_vendor_price_submitted'))
{
    function is_vendor_price_submitted($val)//only for buyer
    {
        $CI=get_instance(); 
        $order_id       = $val->order_details_id;
        $variant_id       = $val->id;
        $vendor_id       = $val->vendor_id;
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('order_did, id, buyer_price, created_date');
        $CI->db->where('order_did', $order_id);
        $CI->db->where('sub_order_variant_id', $variant_id);
        $CI->db->where('buyer_id', $customer_id);
        $CI->db->where('seller_id', $vendor_id);
        $CI->db->where('buyer_price', NULL);
        $CI->db->where('status', '1');
        $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        // echo $CI->db->last_query();//die;
        if($counterRate->num_rows() > 0) {
            $all_counters = $counterRate->row();
            return $all_counters ? true : false;
        }
        return false;
    }
}
if(!function_exists('buyer_price_history'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function buyer_price_history($val)
    {
        $CI=get_instance(); 
        $order_id       = $val->order_details_id;
        $variant_id       = $val->id;
        $auth_user  = $CI->session->userdata('auth_user');
        $customer_id    = $auth_user['users_id'];
        $CI->db->select('order_did, id, buyer_price, created_date');
        $CI->db->where('buyer_price !=', '');
        $CI->db->where('order_did', $order_id);
        $CI->db->where('sub_order_variant_id', $variant_id);
        $CI->db->where('buyer_id', $customer_id);
        // $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_price_counter_rate');
        // echo $CI->db->last_query();//die;
        if($counterRate->num_rows() > 0) {
            $all_counters = $counterRate->result();
            return $all_counters;
        }
        return false;
    }
}
if(!function_exists('vendor_user_id'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function vendor_user_id($vender_id)
    {
        $CI=get_instance(); 
        
        $CI->db->select('id');
        $CI->db->where('user_type', '0');
        $CI->db->where('supplier_user_id', NULL);
        $CI->db->where('store_id', $vender_id);
        // $CI->db->limit(1);
        $CI->db->order_by('id', DESC);
        $counterRate = $CI->db->get('tbl_users');
        // echo $CI->db->last_query();//die;
        if($counterRate->num_rows() > 0) {
            return $counterRate->row('id');
        }
        return false;
    }
}
if(!function_exists('getBuyerCompanyName'))
{
    // function get_counter_price($order_id,$variant_id,$customer_id, $price)
    function getBuyerCompanyName()
    {
        $CI=get_instance(); 
        
        $auth_user  = $CI->session->userdata('auth_user');

        $CI->db->select('legal_name');
        $CI->db->where('user_id', $auth_user['users_id']);
        $buyer_data = $CI->db->get('buyer_details');
        if($buyer_data->num_rows() > 0) {
            return $buyer_data->row('legal_name');
        }
        return '';
    }
}

if(!function_exists('get_rfq_category'))
{
    function get_rfq_category($rfq_number) {
        $CI = & get_instance();
        
        $CI->db->select('id, order_number ');
        $CI->db->where('order_number', $rfq_number);
        $data = $CI->db->get('tbl_order')->row();

        $cat_names = array();
        if (!empty($data)) {
            $CI->db->select('category_ids ');
            $CI->db->where('order_id', $data->id);
            $order_details_data = $CI->db->get('tbl_order_detail')->row();
            
            if(!empty($order_details_data) && !empty($order_details_data->category_ids) ){
                $cat_array = explode(",", $order_details_data->category_ids);
                $CI->db->select('name');
                $CI->db->where_in('id', $cat_array);
                $CI->db->order_by('id', "ASC");
                $CI->db->limit(2);
                $cat_data = $CI->db->get('tbl_categories')->result();
                if(!empty($cat_data)){
                    foreach ($cat_data as $key => $value) {
                        $cat_names[]=$value->name;
                    }
                }
            }
        }
        // echo $CI->db->last_query();
        return $cat_names;
    }
}
// mail helpers

if(!function_exists('isProtected'))
{
    function isProtected()
    {
        return true;
    }
}


if(!function_exists('edit_count_order'))
{
    function edit_count_order($id)
    {
        $CI = & get_instance();
        $CI->db->select('edit_count, is_edit');
        $CI->db->where('id', $id);
        $results = $CI->db->get('tbl_order')->row();
        return $results;
    }
}

if(!function_exists('get_edit_draft_id'))
{
    function get_edit_draft_id($id)
    {
        $CI = & get_instance();
        $CI->db->select('rfq_draft_id');
        $CI->db->where('order_id', $id);
        $CI->db->where('is_edit', '1');
        $results = $CI->db->get('tbl_activecart')->row();
        // echo $CI->db->last_query();die;
        return $results;

    }
}


if(!function_exists('check_close_rfq_status'))
{
    function check_close_rfq_status($id)
    {
        $CI = & get_instance();
        $CI->db->select('close_status');
        $CI->db->where('order_id', $id);
        $CI->db->group_by('order_id');
        $results = $CI->db->get('tbl_order_detail')->row();
        // echo $CI->db->last_query();die;
        return $results;

    }
}


if(!function_exists('get_storename_from_user'))
{
    function get_storename_from_user($id)
    {
        $CI = & get_instance();
        $CI->db->select('s.store_name');
        $CI->db->join('tbl_store as s', 'e.store_id = s.store_id', left);
        $CI->db->where('e.id', $id);
        $results = $CI->db->get('tbl_users as e')->row();
        return $results->store_name;

    }
}

if(!function_exists('get_store_ids'))
{
    function get_store_ids($id)
    {
        $CI = & get_instance();
        $CI->db->select('store_id');
        $CI->db->where('id', $id);
        $results = $CI->db->get('tbl_users')->row();
        return $results->store_id;

    }
}
if (!function_exists('pr')) {
    function pr($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}




