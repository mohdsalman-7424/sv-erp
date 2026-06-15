<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_lib { 
    public function __construct() { 
        
    } 

public function SendEmail($subject = NULL, $body = NULL, $to = NULL, $cc = NULL, $bcc = NULL, $attrachments = NULL, $attrachments2 = NULL, $is_reply = NULL, $smtp = NULL) {

    	$CI = & get_instance();
        $config['protocol']     = 'smtp';
        // $config['smtp_host']    = 'ssl://smtp.gmail.com';
        // $config['smtp_port']    = '465';
      
        $config['smtp_host']    = EMAIL_SMTP_HOST;
        $config['smtp_port']    = EMAIL_SMTP_PORT;
        $config['smtp_user']    = EMAIL_SMTP_USER;
        $config['smtp_pass']    = EMAIL_SMTP_PASS;
        if(isset($smtp['smtp_host']) && $smtp['smtp_host'] && isset($smtp['smtp_port']) && $smtp['smtp_port'] && isset($smtp['smtp_user']) && $smtp['smtp_user'] && isset($smtp['smtp_pass']) && $smtp['smtp_pass'])
        {
            $config['smtp_host']    = $smtp['smtp_host'];
            $config['smtp_port']    = $smtp['smtp_port'];
            $config['smtp_user']    = $smtp['smtp_user'];
            $config['smtp_pass']    = $smtp['smtp_pass'];
        }

        $config['smtp_timeout'] = '7';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'text'; // or html
        $config['validation']   = TRUE; // bool whether to validate email or not      
        $CI->email->initialize($config);
        // pr($config);die;
        $CI->email->from($config['smtp_user'],$this->dbsettings->WEBSITE_NAME);
        $CI->email->reply_to($config['smtp_user'],$this->dbsettings->WEBSITE_NAME); //User email submited in form
        $CI->email->to($to);
        if(!empty($cc)) {

            $CI->email->cc($cc);
        }
        if(!empty($bcc)) {

            $CI->email->bcc($bcc);
        }
        if(!empty($attrachments))
        {
            if(is_array($attrachments) && count($attrachments)>0) {

                foreach ($attrachments as $key => $attrachment) {
                    $CI->email->attach($attrachment);
                }
            }
            else
            {
                $CI->email->attach($attrachments);
            }
        }
        if(!empty($attrachments2))
        {
            if(is_array($attrachments2) && count($attrachments2)>0)
            {
                foreach ($attrachments2 as $key => $attrachment2) {
                    $CI->email->attach($attrachment2);
                }
            }
            else
            {
                $CI->email->attach($attrachments2);
            }
        }
        
        $CI->email->subject($subject);
        $CI->email->set_mailtype("html");
        $CI->email->message($body);
        if($status = $CI->email->send())
        {
            return $status;
        }
        else
        {
            // echo ($CI->email->print_debugger());die;
            return false;
        }
    }

public function SendEmailToOrder($subject = null, $body = null, $email = null, $cc = NULL) {
        
        $CI = & get_instance();
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = EMAIL_SMTP_HOST;
        $config['smtp_port']    = EMAIL_SMTP_PORT;
        $config['smtp_user']    = ORDER_SMTP_USER;
        $config['smtp_pass']    = ORDER_SMTP_PASS;

        if(isset($smtp['smtp_host']) && $smtp['smtp_host'] && isset($smtp['smtp_port']) && $smtp['smtp_port'] && isset($smtp['smtp_user']) && $smtp['smtp_user'] && isset($smtp['smtp_pass']) && $smtp['smtp_pass']) {

            $config['smtp_host']    = $smtp['smtp_host'];
            $config['smtp_port']    = $smtp['smtp_port'];
            $config['smtp_user']    = $smtp['smtp_user'];
            $config['smtp_pass']    = $smtp['smtp_pass'];
        }

        $config['smtp_timeout'] = '7';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'text'; // or html
        $config['validation']   = TRUE; // bool whether to validate email or not      
        $CI->email->initialize($config);
        // pr($config);die;
        $CI->email->from($config['smtp_user'],$this->dbsettings->WEBSITE_NAME);
        $CI->email->reply_to($config['smtp_user'],$this->dbsettings->WEBSITE_NAME); //User email submited in form
        $CI->email->to($to);
        if(!empty($cc)) {

            $CI->email->cc($cc);
        }
        if(!empty($bcc)) {

            $CI->email->bcc($bcc);
        }
        if(!empty($attrachments)) {

            if(is_array($attrachments) && count($attrachments)>0) {

                foreach ($attrachments as $key => $attrachment) {
                    $CI->email->attach($attrachment);
                }
            }
            else {
                $CI->email->attach($attrachments);
            }
        }
        if(!empty($attrachments2)) {

            if(is_array($attrachments2) && count($attrachments2)>0) {

                foreach ($attrachments2 as $key => $attrachment2) {
                    $CI->email->attach($attrachment2);
                }
            }
            else {
                $CI->email->attach($attrachments2);
            }
        }
        
        $CI->email->subject($subject);
        $CI->email->set_mailtype("html");
        $CI->email->message($body);
        if($status = $CI->email->send()) {

            return $status;
        }
        else
        {
            // echo ($CI->email->print_debugger());die;
            return false;
        }
    }
    
}
