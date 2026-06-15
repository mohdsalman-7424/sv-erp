<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cache_lib {  
     
    public function get_category_wise_product($option = NULL, $store_id = NULL)
    {
        $data       = [];
        $store_data = [];
        if(isset($option) && !empty($option) && isset($option['subcategory_id']) && !empty($option['subcategory_id']))
        {
            $CI = & get_instance();

            $CI->db->select("SQL_CALC_FOUND_ROWS p.*, GROUP_CONCAT(pp.id) as all_variant_ids, GROUP_CONCAT(pp.product_price) as all_product_prices, GROUP_CONCAT(pp.product_s_price) as all_product_s_prices, GROUP_CONCAT(pp.product_pec_weight) as all_product_pec_weights, GROUP_CONCAT(pp.special_price_start_date) as all_special_price_start_date, GROUP_CONCAT(pp.special_price_end_date) as all_special_price_end_date, GROUP_CONCAT(pp.set_quantity) as all_set_quantity", FALSE);
            $CI->db->join("tbl_product_price as pp","pp.product_id = p.product_id, pp1.order as sort_order", "LEFT");
            $CI->db->join("tbl_product_positioning as pp1", "pp.id = pp1.product_variant_id AND pp1.sub_cat_id =".$option['subcategory_id'], 'LEFT', FALSE);
            $CI->db->where("p.product_status", 1);
            $CI->db->where("pp.unit_status", 1);
            $CI->db->where("pp.product_price !=''", NULL, FALSE);
            $CI->db->where("pp.product_price != 0.00", NULL, FALSE);
            if(isset($option['subcategory_id']) && !empty($option['subcategory_id']))
            {
                $CI->db->where(" ( FIND_IN_SET('".$option['subcategory_id']."',p.category_ids)>0 ) ", NULL, FALSE);
            }
            $CI->db->group_by("p.product_id");
            $CI->db->order_by("pp1.order", "ASC");
            $query = $CI->db->get("tbl_product as p");
            // echo $CI->db->last_query();die;
            if($query->num_rows()){
           
                $data['status']         = "success";
                $data['search_records'] = $query->num_rows();
                $data['result']         = $query->result();
                $total_record           = $CI->db->query('SELECT FOUND_ROWS() AS `count`');
                $data['totalRecords']   = $total_record->row()->count; 

                if(isset($data['result']) && !empty($data['result']))
                {
                    $all_variant = '';
                    foreach ($data['result'] as $key => $row) {
                        if(isset($row->all_variant_ids) && !empty($row->all_variant_ids))
                        {
                            $all_variant .= $row->all_variant_ids . ",";
                        }
                    }

                    if(isset($all_variant) && !empty($all_variant))
                    {
                        $all_variant = explode(",", $all_variant);
                        $all_variant = array_filter($all_variant);
                        $all_variant = array_unique($all_variant);

                        $CI->db->select("SQL_CALC_FOUND_ROWS id,product_id,main_price_id,store_id,product_price,product_s_price,unit_status,special_price_start_date,special_price_end_date,set_quantity", FALSE);
                        $CI->db->where_in('main_price_id', $all_variant);
                        $query1 = $CI->db->get('tbl_product_price_store_wise');
                        if($query1->num_rows()){
           
                            $store_data['result']          = $query1->result();
                        }

                        $CI->db->select("id, product_id, image, variant_id", FALSE);
                        $CI->db->where_in('variant_id', $all_variant);
                        $CI->db->where('image !=""', NULL, FALSE);
                        $CI->db->where('product_id !=""', NULL, FALSE);
                        $query1 = $CI->db->get('tbl_product_gallery');
                        // echo $CI->db->last_query();die;
                        if($query1->num_rows()){

                            $all_gallery  = $query1->result_array();
                        }

                        if(isset($data['result']) && !empty($data['result']))
                        {
                            
                            foreach ($data['result'] as $key => $row) {
                                $all_variant_temp = [];
                                if(isset($row->all_variant_ids) && !empty($row->all_variant_ids))
                                {
                                    $all_variant_temp = explode(",", $row->all_variant_ids);
                                    $store_data_temp = [];
                                    if(isset($store_data['result']) && !empty($store_data['result']))
                                    {
                                        foreach ($store_data['result'] as $store_key => $store_row) {
                                            if(isset($store_row->main_price_id) && in_array($store_row->main_price_id, $all_variant_temp))
                                            {
                                                $store_data_temp[] = $store_row;
                                            }
                                        }
                                    }
                                    $data['result'][$key]->store_wise_price = $store_data_temp;

                                    $gallery_data_temp = [];

                                    $gallery_keys = array_keys(array_column($all_gallery, 'product_id'), $row->product_id);
                                    if(isset($gallery_keys) && !empty($gallery_keys))
                                    {
                                        foreach ($gallery_keys as $gallery_key => $gallery_value) {
                                            $gallery_data_temp[] = $all_gallery[$gallery_value];
                                        }
                                    }
                                    $data['result'][$key]->gallery = $gallery_data_temp;
                                }
                            }
                        }
                    }
                }
                
                $CI->cache->file->save('all_products_'.$option['subcategory_id'], $data, CACHE_EXPIRE);

            }else{
                $data['status']         = "error";
                $data['result']         = '';
                $data['totalRecords']   = 0;
                $data['search_records'] = 0;
            }
        }
        return $data;
    }

    public function feature_product_by_category($category = NULL)
    {
        $data       = [];
        $store_data = [];
        
        if(isset($category) && !empty($category))
        {
            $CI = & get_instance();
            $CI->db->select("SQL_CALC_FOUND_ROWS p.*, GROUP_CONCAT(pp.id) as all_variant_ids, GROUP_CONCAT(pp.product_price) as all_product_prices, GROUP_CONCAT(pp.product_s_price) as all_product_s_prices, GROUP_CONCAT(pp.product_pec_weight) as all_product_pec_weights, GROUP_CONCAT(pp.special_price_start_date) as all_special_price_start_date, GROUP_CONCAT(pp.special_price_end_date) as all_special_price_end_date, GROUP_CONCAT(pp.set_quantity) as all_set_quantity", FALSE);
            $CI->db->join("tbl_product_price as pp","pp.product_id = p.product_id", "LEFT");
            $CI->db->join("tbl_product_positioning as pp1", "pp.id = pp1.product_variant_id AND pp1.sub_cat_id =".$category, 'LEFT', FALSE);
            $CI->db->where("p.product_status", 1);
            $CI->db->where("pp.unit_status", 1);
            $CI->db->where("featured", 1);
            $CI->db->where("pp.product_price !=''", NULL, FALSE);
            $CI->db->where("pp.product_price != 0.00", NULL, FALSE);
            if(isset($category) && !empty($category))
            {
                $CI->db->where(" ( FIND_IN_SET('".$category."',p.category_ids)>0 ) ", NULL, FALSE);
            }
            $CI->db->group_by("p.product_id");
            $CI->db->order_by("pp1.order", "ASC");
            $CI->db->limit(100);
            $query = $CI->db->get("tbl_product as p");
            // echo $CI->db->last_query();die;
            if($query->num_rows()){
           
                $data['status']         = "success";
                $data['search_records'] = $query->num_rows();
                $data['result']         = $query->result();
                $total_record           = $CI->db->query('SELECT FOUND_ROWS() AS `count`');
                $data['totalRecords']   = $total_record->row()->count; 

                if(isset($data['result']) && !empty($data['result']))
                {
                    $all_variant = '';
                    foreach ($data['result'] as $key => $row) {
                        if(isset($row->all_variant_ids) && !empty($row->all_variant_ids))
                        {
                            $all_variant .= $row->all_variant_ids . ",";
                        }
                    }

                    if(isset($all_variant) && !empty($all_variant))
                    {
                        $all_variant = explode(",", $all_variant);
                        $all_variant = array_filter($all_variant);
                        $all_variant = array_unique($all_variant);

                        $CI->db->select("id,product_id,main_price_id,store_id,product_price,product_s_price,unit_status,special_price_start_date,special_price_end_date,set_quantity", FALSE);
                        $CI->db->where_in('main_price_id', $all_variant);
                        $query1 = $CI->db->get('tbl_product_price_store_wise');
                        if($query1->num_rows()){
           
                            $store_data['result']   = $query1->result();
                        }

                        $CI->db->select("id, product_id, image, variant_id", FALSE);
                        $CI->db->where_in('variant_id', $all_variant);
                        $CI->db->where('image !=""', NULL, FALSE);
                        $CI->db->where('product_id !=""', NULL, FALSE);
                        $query1 = $CI->db->get('tbl_product_gallery');
                        // echo $CI->db->last_query();die;
                        if($query1->num_rows()){

                            $all_gallery  = $query1->result_array();
                        }

                        if(isset($data['result']) && !empty($data['result']))
                        {
                            
                            foreach ($data['result'] as $key => $row) {
                                $all_variant_temp = [];
                                if(isset($row->all_variant_ids) && !empty($row->all_variant_ids))
                                {
                                    $all_variant_temp = explode(",", $row->all_variant_ids);
                                    $store_data_temp = [];
                                    if(isset($store_data['result']) && !empty($store_data['result']))
                                    {
                                        foreach ($store_data['result'] as $store_key => $store_row) {
                                            if(isset($store_row->main_price_id) && in_array($store_row->main_price_id, $all_variant_temp))
                                            {
                                                $store_data_temp[] = $store_row;
                                            }
                                        }
                                    }
                                    $data['result'][$key]->store_wise_price = $store_data_temp;

                                    $gallery_data_temp = [];

                                    $gallery_keys = array_keys(array_column($all_gallery, 'product_id'), $row->product_id);
                                    if(isset($gallery_keys) && !empty($gallery_keys))
                                    {
                                        foreach ($gallery_keys as $gallery_key => $gallery_value) {
                                            $gallery_data_temp[] = $all_gallery[$gallery_value];
                                        }
                                    }
                                    $data['result'][$key]->gallery = $gallery_data_temp;
                                }
                            }
                        }
                    }
                }
                
                $CI->cache->file->save('all_feature_products_'.$category, $data, CACHE_EXPIRE);

            }else{
                $data['status']         = "error";
                $data['result']         = '';
                $data['totalRecords']   = 0;
                $data['search_records'] = 0;
            }
        }
        return $data;
    }

    public function delete_category_wise_product($subcategory_id = NULL)
    {
        if(isset($subcategory_id) && !empty($subcategory_id))
        {
            $CI = & get_instance();
            $CI->cache->file->delete('all_products_'.$subcategory_id);
        }
    }

    public function delete_feature_product_by_category($category_id = NULL)
    {
        if(isset($category_id) && !empty($category_id))
        {
            $CI = & get_instance();
            $CI->cache->file->delete('all_feature_products_'.$category_id);
        }
    }

    public function all_product_images_compress($product_id = NULL)
    {
        
        $result = [];
        $CI = & get_instance();
        $CI->load->library('imagelib');
        $CI->db->select("p.product_id, p.product_name,p.product_image");
        if(isset($product_id) && !empty($product_id))
        {
            $CI->db->where("p.product_id", $product_id);
        }
       
        $result = $CI->db->get("tbl_product as p")->result();
        if(isset($result) && !empty($result))
        {
            foreach ($result as $key => $value)
            {
                if(isset($value->product_image) && !empty($value->product_image) && file_exists(ASSETS_PATH.'uploads/product/'.$value->product_image))
                {
                    if(!file_exists(ASSETS_PATH.'uploads'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.'compress'.DIRECTORY_SEPARATOR.$value->product_image) || !file_exists(ASSETS_PATH.'uploads'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR.'250'.DIRECTORY_SEPARATOR.$value->product_image))
                    {
                        //============create thumb and compress image=====================//
                        $CI->imagelib->create_thumbnail_image(ASSETS_PATH.'uploads/product/',$value->product_image,'100');
                        $CI->imagelib->create_thumbnail_image(ASSETS_PATH.'uploads/product/',$value->product_image,'250');
                        $CI->imagelib->create_thumbnail_image(ASSETS_PATH.'uploads/product/',$value->product_image,'500');
                        $CI->imagelib->compress_image(ASSETS_PATH.'uploads/product/',$value->product_image);
                        //============create thumb and compress image=====================//
                    }
                }
            }
        }
        

        $result = [];
        $CI->db->select("pg.id, pg.image as product_image");
        if(isset($product_id) && !empty($product_id))
        {
            $CI->db->where("pg.product_id", $product_id);
        }
        $CI->db->where("pg.product_id != ''", NULL, FALSE);
        $CI->db->where("pg.image != ''", NULL, FALSE);
        $result = $CI->db->get("tbl_product_gallery as pg")->result();
        // pr($result);die;
        if(isset($result) && !empty($result))
        {
            foreach ($result as $key => $value) {
                if(isset($value->product_image) && !empty($value->product_image) && file_exists(ASSETS_PATH.'uploads/product/'.$value->product_image))
                {
                    if(!file_exists(ASSETS_PATH.'uploads'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.'compress'.DIRECTORY_SEPARATOR.$value->product_image) || !file_exists(ASSETS_PATH.'uploads'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR.'250'.DIRECTORY_SEPARATOR.$value->product_image))
                    {
                        //============create thumb and compress image=====================//
                        $CI->imagelib->create_thumbnail_image(ASSETS_PATH.'uploads/product/',$value->product_image,'100');
                        $CI->imagelib->create_thumbnail_image(ASSETS_PATH.'uploads/product/',$value->product_image,'250');
                        $CI->imagelib->create_thumbnail_image(ASSETS_PATH.'uploads/product/',$value->product_image,'500');
                        $CI->imagelib->compress_image(ASSETS_PATH.'uploads/product/',$value->product_image);
                        //============create thumb and compress image=====================//
                    }
                }
            }
        }
    }

    public function all_product_images_compress2($product_id = NULL)
    {
        
        $result = [];
        $CI = & get_instance();
        $CI->db->select("p.product_id, p.product_name,p.product_image");
        if(isset($product_id) && !empty($product_id))
        {
            $CI->db->where("p.product_id", $product_id);
        }
        // $CI->db->where("p.product_status", 1);
        // $CI->db->limit(20);
        // $CI->db->order_by("p.product_id", "DESC");
        $result = $CI->db->get("tbl_product as p")->result();
        // pr($result);die;

        if(isset($result) && !empty($result))
        {
            foreach ($result as $key => $value) {
                if(isset($value->product_image) && !empty($value->product_image) && file_exists(ASSETS_PATH.'uploads/product/'.$value->product_image))
                {
                    if(!file_exists(ASSETS_PATH.'uploads/product/'.'compress'.DIRECTORY_SEPARATOR.$value->product_image))
                    {
                        $source         = ASSETS_PATH.'uploads/product/'.$value->product_image;
                        $destination    = ASSETS_PATH.'uploads/product/'."compress".DIRECTORY_SEPARATOR.$value->product_image;
                        $this->compress_images($source, $destination, '100');
                    }
                }
            }
        }
        
        // pr($result);die;

        $result = [];
        $CI->db->select("pg.id, pg.image as product_image");
        if(isset($product_id) && !empty($product_id))
        {
            $CI->db->where("pg.product_id", $product_id);
        }
        $CI->db->where("pg.product_id != ''", NULL, FALSE);
        $CI->db->where("pg.image != ''", NULL, FALSE);
        $result = $CI->db->get("tbl_product_gallery as pg")->result();
        if(isset($result) && !empty($result))
        {
            foreach ($result as $key => $value) {
                if(isset($value->product_image) && !empty($value->product_image) && file_exists(ASSETS_PATH.'uploads/product/'.$value->product_image))
                {
                    if(!file_exists(ASSETS_PATH.'uploads/product/'.'compress'.DIRECTORY_SEPARATOR.$value->product_image))
                    {
                        $source         = ASSETS_PATH.'uploads/product/'.$value->product_image;
                        $destination    = ASSETS_PATH.'uploads/product/'."compress".DIRECTORY_SEPARATOR.$value->product_image;
                        $this->compress_images($source, $destination, '100');
                    }
                }
            }
        }
    }

    public function compress_images($source, $destination, $quality = '100')
    {
        if($source && $destination)
        {
            
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
            imagepng($dst, $destination);
            
            $info = getimagesize($destination);
            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($destination);

            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($destination);

            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($destination);

            // imagejpeg($image, $destination, $quality);

            return $destination;
        }
    }

    
}
