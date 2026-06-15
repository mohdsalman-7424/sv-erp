<?php 

function send_sms_password($api_type, $mobile_number, $pass2) 
{

    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res = FALSE;
    $message    = "Your password is - $pass2. Please login using this password";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res        = file_get_contents($url);
    return $res;
}  
 
function send_reg_sms_otp($api_type, $mobile_number, $otp) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res = FALSE;
    $message = "Your Raprocure new account verification otp is - $otp.";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res = file_get_contents($url);
    return $res;
}   

function send_reg_sms($api_type, $mobile_number, $pass2) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res     = FALSE;
    $message = "Your password is - $pass2. Please login using this password";
    $message = urlencode($message);
    $url     = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res = file_get_contents($url);
    return $res;
}   

function send_sms_otp($mobile_number, $otp) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    $message    = "$otp is the OTP. Please enter this to verify your identity. It will be valid for next 1 hour. samriddhi.ventures. Customer Support: +91-9999999999";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res = file_get_contents($url);
    return $res;
}

function send_user_sms($user_name, $mobile_number) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    $message    = "Dear " . ucwords(strtolower($user_name)) . ',' . "Thank you for registering on samriddhi.ventures. Customer Support: +91-9999999999";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res        = file_get_contents($url);
    return $res;
}

function send_order_sms($user_name, $mobile_number, $order_no, $amount) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    $message    = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order ". $order_no ." is confirmed to be delivered on ". $delivery_date . " between ". $timeslot .". For any query call us on +91-9999999999 or mail us on Support@samriddhi.ventures or WhatsApp on +91-9999999999";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res        = file_get_contents($url);
    return $res;

}

function place_order_sms($data=NULL, $mobile_number=NULL, $status=NULL)
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    $message    = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order ". $order_no ." is confirmed to be delivered on ". $delivery_date . " between ". $timeslot .". For any query call us on +91-9999999999 or mail us on Support@samriddhi.ventures or WhatsApp on +91-9999999999";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res        = file_get_contents($url);
    return $res;
}  

function order_assignstatus_sms($user_name, $mobile_number, $order_no, $type, $adminMail, $userNumber) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $message =  "Dear $user_name, Your order has been $type Order no is #$order_no. For any query call us on $mobile_number or mail us on $adminMail Raprocure";
    $message    = urlencode($message);
    $url = '';//'http://kyi.solutions/V2/http-api.php?apikey=OvFOF6aAd2HmlfWS&senderid=Raprocure&number='.$userNumber.'&message='.$message.'&format=json';
    $res = file_get_contents($url);
    return $res;

}


function send_order_sms_payment_failed($user_name, $mobile_number, $order_no, $amount) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    $message    = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order could not be placed. Order no is :" . $order_no . ' ' . ". Customer Support: +91-9999999999. Customer Support Email:support@samriddhi.ventures . samriddhi.ventures";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res = file_get_contents($url);
    return $res;
}

function send_order_status_sms($user_name, $mobile_number, $order_no, $status) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    // $message    = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order has been " . $order_no . " is" . ' ' . $status . '.' . ' ' . "Customer Support: +91-9999999999 samriddhi.ventures";


   $message    =  "Dear " . ucwords(strtolower($user_name)) . ',' . ", Your order has been " . $status . " Order no is " . $order_no . ". For any query call us on +91-9999999999 or mail us on support@raprocure.com Raprocure";



    $message    = urlencode($message);

    $url    = '';//"http://kyi.solutions/V2/http-api.php?apikey=OvFOF6aAd2HmlfWS&senderid=Raprocure&number=".$mobile_number."&message=".$message."&format=json";


    // $url        = 'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res = file_get_contents($url);
    return $res;
}

function send_cancel_order_sms($user_name, $mobile_number, $order_no) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    $message    = "Dear " . ucwords(strtolower($user_name)) . ',' . "Your order no " . $order_no . ' ' . "has been" . ' ' . 'cancelled' . '.' . ' ' . "Customer Support: +91-9999999999 samriddhi.ventures";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res = file_get_contents($url);
    return $res;
}

function send_bulk_sms($mobile_number, $message) 
{
    
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res            = FALSE;
    if ($mobile_number && $message) {
        $message    = urlencode($message);
        
        $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
        
        $res = file_get_contents($url);
        return $res;
    }
}

function send_sms_otpppp($api_type, $mobile_number, $otp) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    
    $res        = FALSE;
    $message    = "$otp is the OTP. Please enter this to verify your identity.";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    $res        = file_get_contents($url);
    return $res;
}

function send_wallet_pinnn($api_type, $mobile_number, $pin) 
{
    if( !(isset($mobile_number) && !empty($mobile_number) && is_numeric($mobile_number) && strlen($mobile_number) == 10) )
    {
        return FALSE;
    }
    $res        = FALSE;
    $message    = "Your Raprocure wallet pin OTP is - $pin.";
    $message    = urlencode($message);
    $url        = '';//'http://kyi.support/api/push?user=user5196103892&pwd=User@51961cvb&route=Transactional&sender=sham&mobileno='.$mobile_number.'&text='.$message;
    
    $res        = file_get_contents($url);
    return $res;
}



?>
