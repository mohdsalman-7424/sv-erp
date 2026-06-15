<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Imagelib {  

    protected $CI;

    public function create_thumbnail_image($source_path,$image_name,$height = 100,$quality = '100%') 
    {
        // echo $source_path;die;
        $CI  = & get_instance();
        $CI->load->library('image_lib');
        $destination_path = $source_path.'thumbnails/'.$height.'/';
        if(!is_dir($destination_path))
        {
            mkdir($destination_path, 0777, TRUE);
            chmod($destination_path, 0777);
        }
        $source_image = $source_path.$image_name;
        $new_image = $destination_path . $image_name;
        $config['image_library'] = 'gd2';
        $config['source_image']  = $source_image;
        $config['new_image']     = $new_image;
        $config['maintain_ratio']= TRUE;
        $config['create_thumb']  = FALSE;
        // $config['width']         = $width;
        $config['quality']       = $quality; 
        $config['height']        = $height;
        // pr($config);die;
        $CI->image_lib->initialize($config);
        if (!$CI->image_lib->resize())
        {
            // pr(getimagesize($source_image));
            // echo $CI->image_lib->display_errors() . "-> ".$source_image;
        }
        else
        {
            // echo "<p> success : ".$source_image."</p>";
        }
        // echo "----------------------------------------------------------------------";
    }

    public function create_thumbnail_image400($source_path,$image_name,$height = 100,$quality = '100%') 
    {
        // echo $source_path;die;
        $CI  = & get_instance();
        $CI->load->library('image_lib');
        $destination_path = $source_path.'thumbnails/'.$height.'/';
        if(!is_dir($destination_path))
        {
            mkdir($destination_path, 0777, TRUE);
            chmod($destination_path, 0777);
        }
        $source_image = $source_path.$image_name;
        $new_image = $destination_path . $image_name;
        $config['image_library'] = 'gd2';
        $config['source_image']  = $source_image;
        $config['new_image']     = $new_image;
        $config['maintain_ratio']= TRUE;
        // $config['width']         = $width;
        $config['quality']       = $quality; 
        $config['height']        = 300;
        // pr($config);die;
        $CI->image_lib->initialize($config);
        if (!$CI->image_lib->resize())
        {
            // pr(getimagesize($source_image));
            // echo $CI->image_lib->display_errors() . "-> ".$source_image;
        }
        else
        {
            // echo "<p> success : ".$source_image."</p>";
        }
        // echo "----------------------------------------------------------------------";
    }


    // public function ccompress_image($source_path, $image_name,$quality = '80%') 
    // {

    //     $CI  = & get_instance();
    //     $CI->load->library('image_lib');
    //     $destination_path = $source_path.'compress/';
    //     if(!is_dir($destination_path))
    //     {
    //         mkdir($destination_path, 0777, TRUE);
    //         chmod($destination_path, 0777);
    //     }
    //     $source_image = $source_path.$image_name;
    //     $original_size = getimagesize($source_image);
    //     $new_image = $destination_path . $image_name;
    //     $config['image_library'] = 'gd2';
    //     $config['source_image']  = $source_image;
    //     // $config['new_image']     = $new_image;
    //     // $config['maintain_ratio']= FALSE;
    //     $config['quality']       = $quality; 
    //     // $config['width']         = $width;
    //     // $config['height']        = $height;
    //     $CI->image_lib->initialize($config);
    //     if (!$CI->image_lib->resize())
    //     {
    //         echo $CI->image_lib->display_errors();
    //     }
    // }


    public function compress_image($source_path, $image_name,$quality = '100%') 
    {

        $source = $source_path.DIRECTORY_SEPARATOR.$image_name;
        $destination = $source_path.'compress'.DIRECTORY_SEPARATOR;
        if(!is_dir($destination))
        {
            mkdir($destination, 0777, TRUE);
            chmod($destination, 0777);
        }
        if($source && $destination)
        {
            
            $destination = $destination.$image_name;
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
