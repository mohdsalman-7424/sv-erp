<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

 *

 * @package     Library

 * @category    Sms lib

 * @author      Pradeep



 * @since       Version 3.0

 */



class Sms_lib {  



    protected $api_url;

    protected $username;

    protected $sender;

    protected $password;



    function __construct() {



        /*KYI sms Gateway*/

        // $this->api_url      = 'http://kyi.solutions/V2/http-api.php';
        $this->api_url      = '';//'http://kyi.solutions/V2/http-api.php';

        $this->apikey       = '';//'OvFOF6aAd2HmlfWS';

        $this->senderid     = '';//'web';

        $this->format        = '';//'json';

//        $this->sender       = 'FNGONL';

    }

    

    public function send_order_confirm_sms($user_name, $number, $order_no, $amount = NULL, $order_type = 2) 

    {



        $CI             = & get_instance();

        $delivery_date  = 'Not set';

        $timeslot       = 'Not set';

        if(!isset($number) || empty($number))

        {

            $user_preference        = $CI->session->userdata('user_preference');

            if(isset($user_preference) && !empty($user_preference))

            {

                $delivery_address_id    = $user_preference->order_preference_address;

                $user_address_record    = userAddressbyid($delivery_address_id);

                $number                 = $user_address_record[0]->mobile_number;

            }

            else

            {

                return FALSE;

            }

        }

        

        if (isset($order_no) && !empty($order_no)) {

            

            $sql = "SELECT selectdeliverydate, selectdeliverytime FROM `tbl_order` WHERE `tbl_order`.`order_number` = '" . $order_no . "'";

            $query = $CI->db->query($sql);

            if ($query->num_rows() > 0) {

                $data = $query->row();

                $delivery_date = date('d-m-Y',strtotime($data->selectdeliverydate));

                $timeslot = $data->selectdeliverytime;

            }

        }

        if(isset($order_type) && $order_type == 1)

        {



            $template = sms_templates("ORDER_SUCCESS_PICKUP");

        }

        else

        {

            $template = sms_templates("ORDER_SUCCESS");



        }

        // pr($template);die;

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$user_name', ucwords(strtolower($user_name)), $template);

            $template = str_replace('$order_no', $order_no, $template);

            $template = str_replace('$delivery_date', $delivery_date, $template);

            $template = str_replace('$timeslot', $timeslot, $template);

            // $template = str_replace('$type', $type, $template);

            $message = $template;

        }

        else

        {

            if(isset($order_type) && $order_type == 1)

            {

                $message = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order ". $order_no ." is confirmed your order will be ready for pickup by ".$timeslot." on ". $delivery_date . ". For any query call us on +91 6377716311 or mail us on support@web.com";

            }

            else

            {

                $message = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order ". $order_no ." is confirmed to be delivered on ". $delivery_date . " between ". $timeslot .". For any query call us on +91-6377716311 or mail us on support@web.com";

            }

        }



        if ($number && $message) {



            $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;



            // $url = $this->api_url.'?username='.$this->username.'&password='.$this->password.'&sender='.$this->sender.'&to='.$number.'&message='.urlencode(@$message).'&priority=1&dnd=1&unicode=0';

            // pr($message);die;

            if(isset($url) && !empty($url))

            {

                return file_get_contents($url);

            }

        }

    }



    public function send_order_status_sms($user_name, $number, $order_no, $type, $smstype = 'NOT_SET') 

    {



        $template = sms_templates($smstype);

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$order_no', $order_no, $template);

            $template = str_replace('$user_name', ucwords(strtolower($user_name)), $template);

            $template = str_replace('$type', $type, $template);

            $message = $template;

        }

        else

        {

            $message = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order has been ".$type.". Order no is :" . $order_no . ' ' . ", For any query call us on +91-6377716311 or mail us on support@web.com or WhatsApp on +91-6377716311";

        }



        if (isset($number) && !empty($number) && strlen($number) >= 10 && isset($message) && !empty($message)) 

        {



             $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;



            // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



            if(isset($url) && !empty($url))

            {

                return file_get_contents($url);

            }

        }

    }



    // public function send_wallet_pin($pin=NULL,$number=NULL,$templte=NULL){

    //     $template = sms_templates($templte);



    //     if(isset($template) && !empty($template))

    //     {

    //         $template = str_replace('$pin', $pin, $template);

    //         $message = $template;

    //     }

    //     if($number !='' )

    //     {

    //          $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;

    //     }

    //     if(isset($url) && !empty($url))

    //         {

    //             return file_get_contents($url);

    //         }

    // }



    public function send_order_rescheduled_sms($user_name, $number, $order_no, $type, $smstype = 'NOT_SET', $order_date = NULL, $time_slot = NULL) 

    {



        $template = sms_templates($smstype);

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$order_no', $order_no, $template);

            $template = str_replace('$user_name', ucwords(strtolower($user_name)), $template);

            $template = str_replace('$type', $type, $template);

            $template = str_replace('$order_date', $order_date, $template);

            $template = str_replace('$time_slot', $time_slot, $template);

            $message = $template;

        }

        else

        {

            $message = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order has been ".$type.". Order no is :" . $order_no . ' ' . ", For any query call us on +91-6377716311 or mail us on support@web.com or WhatsApp on +91-6377716311";

        }



        if (isset($number) && !empty($number) && strlen($number) >= 10 && isset($message) && !empty($message)) 

        {



             $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;



            // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



            if(isset($url) && !empty($url))

            {

                return file_get_contents($url);

            }

        }

    }



    public function send_order_sms_payment_failed($user_name, $number, $order_no) 

    {



        $template = sms_templates('ORDER_FAILED');

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$user_name', ucwords(strtolower($user_name)), $template);

            $template = str_replace('$order_no', $order_no, $template);

            $message = $template;

        }

        else

        {

            $message = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order could not be placed. Order no is :" . $order_no . ' ' . ". Customer Support: +91-6377716311. Customer Support Email:support@web.com";

        }



        if (isset($number) && !empty($number) && strlen($number) >= 10 && isset($message) && !empty($message)) 

        {



             $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;

            

            // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



            if(isset($url) && !empty($url))

            {

                return file_get_contents($url);

            }

        }

    }



    public function send_forgot_sms( $number, $resetlink, $smstype = 'NOT_SET') 

    {

        $template = sms_templates($smstype);

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$resetlink', $resetlink, $template);

            $message = $template;

        }

        else

        {

            $message = "Click the below Link to reset the Password :- ".$resetlink;

        }



         $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;



        // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



        if(isset($url) && !empty($url))

        {

            return file_get_contents($url);

        }

    }



    public function send_singup_sms( $number, $password, $smstype = 'NOT_SET') 

    {
        // pr($number);
        // pr($password);
        // die();
         // echo "hello";die();
        $template = sms_templates($smstype);

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$password', $password, $template);

            $message = $template;

        }

        else

        {

            $message = "Your password is - ".$password.". Please login using this password";

        }



         // $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;
        // pr($password);die();
          $url    = "http://kyi.solutions/V2/http-api.php?apikey=OvFOF6aAd2HmlfWS&senderid=DMHAAC&number=$number&message=The%20OTP%20is%20$password%20Team%20DMH&format=json";
         // pr($url);die();

// pr($url);die();

          if (isset($url) && !empty($url)) {
            // echo "hello"; die();
                $fileget = file_get_contents($url);
                // pr($fileget);die();
                $data    = json_decode($fileget);
                // pr($data);die();
                if ($data->status == 'OK') {
                    $information = array(
                        'phone_no' => $number,
                        'password' => $password,
                    );
                    // $this->db->insert('master_customers',$information);
                    $response['status'] = '1';
                    $response['success_msg'] = 'OTP has been send on your ' . $number;

                    return $response;
                } else {
                    // echo "bye";die();
                    $response['status'] = "0";
                    $response['error_msg'] = "Something went  wrong.";
                    return $response;
                }
                // pr($response);die();
            }
       

        // pr($url);die();

        // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



        if(isset($url) && !empty($url))

        {

            return file_get_contents($url);

        }

    }



    

    public function send_otp( $number, $otp, $smstype = 'NOT_SET') 

    {
// pr($number);
// pr($ot);
// die();
        $template = sms_templates($smstype);

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$otp', $otp, $template);

            $message = $template;

        }

        else

        {

            $message = "$otp". "is the OTP. Please enter this to verify your number. It will be valid for next 1 hour.";

        }



        $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;

        // $url    = "http://kyi.solutions/V2/http-api.php?apikey=OvFOF6aAd2HmlfWS&senderid=DMHAAC&number=$number&message=The%20OTP%20is%20$otp%20Team%20DMH&format=json";

         // pr($url);die();

        // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



        if(isset($url) && !empty($url))

        {

            return file_get_contents($url);

        }

    }

    

    // public function send_wallet_pin_sms( $number, $pin, $smstype = 'NOT_SET')

    // {

    //     $template = sms_templates($smstype);

    //     if(isset($template) && !empty($template))

    //     {

    //         $template = str_replace('$pin', $pin, $template);

    //         $message = $template;

    //     }

    //     else

    //     {

    //         $message = "$pin is the PIN. Please enter this to verify your Wallet. Please don't share with anyone.";

    //     }



    //      $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;



    //     // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



    //     if(isset($url) && !empty($url))

    //     {

    //         return file_get_contents($url);

    //     }

    // }


    public function send_wallet_pins($pin=NULL,$number=NULL,$templte=NULL){
        // pr($pin);
        // pr($number); die();
        $template = sms_templates($templte);

        if(isset($template) && !empty($template))
        {
            $template = str_replace('$pin', $pin, $template);
            $message = $template;
        }
        if($number !='' )
        {
             // $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;

             $url    = "http://kyi.solutions/V2/http-api.php?apikey=OvFOF6aAd2HmlfWS&senderid=DMHAAC&number=$number&message=The%20OTP%20is%20$pin%20Team%20DMH&format=json";
             // pr($url);die();
        }
        if(isset($url) && !empty($url))
            {
                return file_get_contents($url);
            }
    }



    public function send_wallet_otp_sms( $number, $otp, $smstype = 'NOT_SET')

    {

        $template = sms_templates($smstype);

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$otp', $otp, $template);

            $message = $template;

        }

        else

        {

            $message = "$otp is the OTP. Please enter this to verify your Number. It will be valid for next 1 hour.";

        }



         $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;



        // $url = $this->api_url."?username=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&to=" . urlencode($number) . "&sender=" . urlencode($this->sender) . "&message=" . urlencode($message) . "&type=" . urlencode('3')."&priority=1&dnd=1&unicode=0";



        if(isset($url) && !empty($url))

        {

            return file_get_contents($url);

        }

    }



    public function send_addmoneyinwallet_sms( $number, $amount, $smstype = 'NOT_SET', $customer_name = NULL, $total_amount = 0)

    {

        $template = sms_templates($smstype);

        if(isset($template) && !empty($template))

        {

            $template = str_replace('$amount', $amount, $template);

            $template = str_replace('$customer_name', $customer_name, $template);

            $template = str_replace('$total_amount', $total_amount, $template);

            $message = $template;

        }

        else

        {

            $message = "You have added Rs . $amount in you FNG Wallet.";

        }



         $url = $this->api_url."?apikey=" . $this->apikey . "&senderid=" . $this->senderid ."&number=" . $number . "&message=" . urlencode($message) ."&format=".$this->format;

        

        if(isset($url) && !empty($url))

        {

            return file_get_contents($url);

        }

    }

    

}

