<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Company Controller
 *
 * @package		CodeIgniter
 * @subpackage	Library
 * @category	Company
 * @author		
 * @since		Version 1.0 (initial)
 */
/*Note: This library is dependent library to email detail and table structure*/
class SyncEmailLib {
   	
    public $export_limit    = NULL;
    public $delete_limit    = NULL;
    public $type            = NULL;
    public $submodule		= NULL;
     /**
	 * Constructor
	 */
	public function __construct($submodule = '')
	{
        
	    // parent::__construct();
	    // pr($module_name);die;

	    isProtected();
	    $thisObj 			= &get_instance();
	    $thisObj->type 		= $thisObj->uri->segment(2);
	    $thisObj->submodule = $submodule;
	    $thisObj->load->model('mail_mod');
        $thisObj->load->helper('url');
	    $thisObj->load->helper('cats_helper');
	    $thisObj->load->helper('comman');
	    $thisObj->load->helper('db');
	    // $thisObj->lang->load('mail', get_site_language());
        // echo "string1";die;
	    // ini_set('max_excecution_time', 900);
	    // ini_set('memory_limit', '-1');
	    $thisObj->data['title']	= $submodule;
        // pr(phpinfo());die;
	}
   	
    public function list_items($msg_type) {
        $thisObj = &get_instance();
        // $total_records = $thisObj->mail_mod->get_mail_list("", "", "", "", "", "", "1");
        // $total_records             = 1;
        $response['total_record']  = $total_records;
        $response['page_title']    = "Messages";
        $response['page_heading']  = "Message List";
        // $per_page    = $this->dbsettings->RECORD_PER_PAGE;
        $per_page                  = 10;
        $page = $_POST['page'];
        $cur_page = $page;
        $page -= 1;
        $start = $page * $per_page; 
        $response['total_pages'] = ceil($total_records/$per_page); 
        $response['per_page']  = $per_page;
        $response['page']  = $_POST['page'];
        $response['message_list'] = $thisObj->mail_mod->get_mail_list($thisObj->type, $msg_type, '', '', $per_page, $start);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }



	// public function list_items($msg_type)
	// {  	

	// 	$thisObj = &get_instance();   
	// 	/*Pagination*/
 //        if($msg_type=="inbox"){
 //            $config['base_url']     = $thisObj->data['base_url']."/list_items/";
 //        }else{
 //            $config['base_url']     = $thisObj->data['base_url']."/".$msg_type."/";
 //        }
 //        // pr($thisObj->data);die;
	// 	$config['per_page']     = PERPAGE;
	// 	$config["uri_segment"]  = 4;
		
	// 	if( count($_GET) > 0 )
	// 	{
	// 		$query_string_url               = '?'.http_build_query($_GET, '', "&");
	// 		$config['enable_query_string']  = TRUE;
	// 		$config['suffix']               = $query_string_url;
	// 		$config['first_url']            = $config["base_url"].$config['suffix'];
	// 	}
	// 	$config['full_tag_open']    = '<ul class="pagination pagination-sm">';
	// 	$config['full_tag_close']   = '</ul>';
	// 	$config['first_link']       = FALSE;
	// 	$config['last_link']        = FALSE;
	// 	$config['first_tag_open']   = '<li>';
	// 	$config['first_tag_close']  = '</li>';
	// 	$config['prev_link']        = '&laquo;';
	// 	$config['prev_tag_open']    = '<li class="prev">';
	// 	$config['prev_tag_close']   = '</li>';
	// 	$config['next_link']        = '&raquo;';
	// 	$config['next_tag_open']    = '<li>';
	// 	$config['next_tag_close']   = '</li>';
	// 	$config['last_tag_open']    = '<li>';
	// 	$config['last_tag_close']   = '</li>';
	// 	$config['cur_tag_open']     = '<li class="active"><a href="#">';
	// 	$config['cur_tag_close']    = '</a></li>';
	// 	$config['num_tag_open']     = '<li>';
	// 	$config['num_tag_close']    = '</li>';
		
	// 	$page 		= $thisObj->uri->segment(4) ? $thisObj->uri->segment(4) : 0;
	// 	$thisObj->data['total_pages']	= $page;
	// 	// pr($thisObj->type);
 //  //       pr($msg_type);die;
 //        $response 	= $thisObj->mail_mod->get_mail_list($thisObj->type, $msg_type, '', '', PERPAGE, $page);
	// 	$thisObj->data['data_list']   = $response['result'];
	// 	$thisObj->data['total_record']= $response['total'];
	// 	$config['total_rows']         = $response['total'];
	// 	// pr($thisObj->data['total_pages']);die;
	// 	$thisObj->load->library('pagination');
	// 	$thisObj->pagination->initialize($config);
	// 	$thisObj->data['pagination_link']	= $thisObj->pagination->create_links();
	// 	/*Pagination*/
		
	// 	$thisObj->data['place_holder']	= "Enter filter terms here";        
	// 	$thisObj->data['action']		= "list";
	// 	$thisObj->data['msg_type']		= $msg_type;
	// 	$thisObj->data['title'] 		= $thisObj->submodule;
	// 	$thisObj->data['email_tag_list']= false;//get_email_tag_data();
	// 	$views[]						= isset($msg_type) && $msg_type=='draft'?"chat/draft_list":"chat/mail_list";;
	// 	// pr($views);die;
 //        $thisObj->data['page_title'] = "User Chat";
 //        $thisObj->data['__show_sidebar_popup'] = true;
	// 	pr($thisObj->data);die;
 //        $thisObj->load->view('user/user-chat', $thisObj->data);
	// 	// view_load($views, $thisObj->data);
	// }

	public function view($id = NULL)
	{     

        $userCred = get_smtp_user($thisObj->type, $thisObj->data['country_type']);
        $current_email = $userCred->email_id;

		$thisObj = &get_instance();   
		$thisObj->data['title']			= 'Sales Spares Email';
       	$result 						= $thisObj->mail_mod->get($id);
       	$thisObj->data['result'] 		= $result['mail_list'];
        $reply_all_email = str_replace($current_email, $result['mail_list']->from_email, $result['mail_list']->to_email);
        $thisObj->data['result']->reply_all = $reply_all_email;
        // pr($thisObj->data['result']);die;
       	$thisObj->data['attachments'] 	= $result['mail_doc'];
       	$thisObj->data['submodule'] 	= 'Email List';
        $thisObj->data['urimodule']     = $thisObj->type;
        $thisObj->data['email_tag_list']= get_email_tag_data();
        $thisObj->data['getIndiaEmailCategory']  = _getIndiaEmailCategory();
        $thisObj->data['getChinaEmailCategory']  = _getChinaEmailCategory();
        $msg_type                       = $result['mail_list']->msg_type;
       	$views[] 					  	= isset($msg_type) && ($msg_type=='draft' || $msg_type=='outbox')?"draft_view":"view_email";
		// pr((($thisObj->data['attachments'])));die;
		// $thisObj->mail_log($id);
		// pr($thisObj->data);die;
        view_report($id);
       	view_load($views, $thisObj->data);
	}

    public function reply($id='')
    {
        $thisObj = &get_instance();
        if(empty($id))
        {
            return false;
        }
        if(isPostBack())
        {
            $result     = $thisObj->mail_mod->get($id);
            $mail_list  = $result['mail_list'];
            $mail_doc   = $result['mail_doc'];
            $to         = [];
            $cc         = [];
            $bcc        = [];
            // $userCred = get_smtp_user($thisObj->type, $thisObj->data['country_type']);
            // if(isset($userCred) && !empty($userCred) && isset($userCred->smtp_host) && !empty($userCred->smtp_host) && isset($userCred->smtp_port) && !empty($userCred->smtp_port) && isset($userCred->smtp_port) && !empty($userCred->smtp_port) && isset($userCred->password) && !empty($userCred->password))
            // {
            //     $smtp['smtp_host'] = $userCred->smtp_host;
            //     $smtp['smtp_port'] = $userCred->smtp_port;
            //     $smtp['smtp_user'] = $userCred->email_id;
            //     $smtp['smtp_pass'] = $userCred->password;
            // }
            // if(isset($_POST['to']) && !empty($_POST['to']))
            // {
            //     $to = explode(',', $_POST['to']);
            //     foreach ($to as $to_key => $to_value) {
            //         if(!filter_var($to_value,FILTER_VALIDATE_EMAIL))
            //         {
            //             set_flashdata('error',"Some email id is invalid.");
            //             echo "Some email id is invalid";
            //             return false;
            //         }
            //     }
            // }

            // if(isset($_POST['cc']) && !empty($_POST['cc']))
            // {
            //     $cc = explode(',', $_POST['cc']);
            //     foreach ($cc as $cc_key => $cc_value) {
            //         if(!filter_var($cc_value,FILTER_VALIDATE_EMAIL))
            //         {
            //             set_flashdata('error',"Some email id is invalid.");
            //             echo "Some email id is invalid";
            //             return false;
            //         }
            //     }
            // }
            // if(isset($_POST['bcc']) && !empty($_POST['bcc']))
            // {
            //     $bcc = explode(',', $_POST['bcc']);
            //     foreach ($bcc as $bcc_key => $bcc_value) {
            //         if(!filter_var($bcc_value,FILTER_VALIDATE_EMAIL))
            //         {
            //             set_flashdata('error',"Some email id is invalid.");
            //             echo "Some email id is invalid";
            //             return false;
            //         }
            //     }
            // }
            // pr($cc);die;
            /*Start save client multiple  attachment*/
            $attachments    = [];
            $attachmentdata = [];
            $folder_doc     = './upload/email_attachment/';
            if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                // echo "string";
                foreach ($_FILES['attachment']['name'] as $attachment_key => $attachment_value) {
                    $_FILES['attachment_file']['name']     = $_FILES['attachment']['name'][$attachment_key];
                    $_FILES['attachment_file']['type']     = $_FILES['attachment']['type'][$attachment_key];
                    $_FILES['attachment_file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$attachment_key];
                    $_FILES['attachment_file']['error']    = $_FILES['attachment']['error'][$attachment_key];
                    $_FILES['attachment_file']['size']     = $_FILES['attachment']['size'][$attachment_key];
                    // $fileData=$thisObj->uploadDoc($_FILES['attachment_file']);
                    $fileData = uploadDoc($_FILES['attachment_file'], $folder_doc, 'attachment_file');
                    // pr($fileData);die;
                    if(isset($fileData['success'])){
                        $attachments[]  = FCPATH.'/upload/email_attachment/'.$fileData['success']['file_name'];
                        $attachmentdata[$attachment_key]['file_title']  = $fileData['success']['file_name'];
                        $attachmentdata[$attachment_key]['filename']    = $fileData['success']['file_name'];   
                    }
                }
            }
            // pr($mail_doc);die;

            /*$old_attachments = [];
            if(isset($mail_doc) && !empty($mail_doc))
            {
                foreach ($mail_doc as $key => $old_attachment) {
                    
                    $old_attachments[]  =  FCPATH.'/upload/email_attachment/'.$old_attachment['filename'];
                    $attachmentdata_old[$key]['file_title']  = $old_attachment['file_title'];
                    $attachmentdata_old[$key]['filename']    = $old_attachment['filename'];   
                }
            }*/

            // pr($old_attachments);die;
            $old_header 	= '';
            $old_header 	.= "<p style='margin: 0;'>On ".date('D, d M Y', strtotime($mail_list->mail_date))." at ".date('H:i:s', strtotime($mail_list->mail_date)).", ".$mail_list->from_name." &lt;".$mail_list->from_email."&gt; wrote</p>";
            $subject 		= $_POST['subject'];
            // $body           = $_POST['body']."<hr style='margin:unset;border-top: 1px solid #908f8f;'>".$old_header.$mail_list->message;
            $body   		= $_POST['body'];
            // $status = $thisObj->SendEmail($subject, $body, $to, $cc, $bcc, $attachments, NULL, NULL, $smtp);
            // if($status)
            // {
                // $thisObj->db->select('email_address, first_name');
                // $thisObj->db->where_in('id', [$_POST['vendor_id'], $_POST['user_id']]);
                // $userQuery = $thisObj->db->get('tbl_users');
                // echo $thisObj->db->last_query();die;
                // $userData = $userQuery->result();
                // pr($userData);die;

                $thisObj->db->select('first_name');
                $thisObj->db->where('id', $_POST['vendor_id']);
                $userQuery1 = $thisObj->db->get('tbl_users');
                // echo $thisObj->db->last_query();die;
                $vendorData = $userQuery1->row();

                $thisObj->db->select('first_name');
                $thisObj->db->where('id', $_POST['user_id']);
                $userQuery2 = $thisObj->db->get('tbl_users');
                $userData = $userQuery2->row();

                $save_data['user_id']           = $_POST['user_id'];
                $save_data['vendor_id']         = $_POST['vendor_id'];
                $save_data['from']              = $_POST['from'];
                $save_data['sender_type']       = $_POST['sender_type'];
                $save_data['receiver_type']     = 0;
                $save_data['email_label']       = $_POST['email_label'];
                $save_data['draft']             = $_POST['draft'];
                $save_data['type_message']      = $_POST['type_message'];
                $save_data['from_name']         = $userData->first_name;
                $save_data['to_name']           = $vendorData->first_name;
                $save_data['type']			    = $thisObj->type;
                // $save_data['to_email']		    = isset($to) && !empty($to)?implode(",", $to):'';
                // $save_data['cc_email']		    = isset($cc) && !empty($cc)?implode(",", $cc):'';
                // $save_data['bcc_email']		    = isset($bcc) && !empty($bcc)?implode(",", $bcc):'';
                $save_data['subject']		    = $subject;
                $save_data['message']		    = $body;
                // $save_data['is_attachment']	    = isset($attachmentdata) && !empty($attachmentdata)?1:0;
                $save_data['mail_date']		    = date('Y-m-d H:i:s');
                //===================now get mail parent id===========================//
               
                $parent_id = 0;
                if($subject)
                {

                    if($mail_list->parent_id == 0)
                    {
                        $parent_id = $mail_list->id;
                    }
                    else
                    {
                        $parent_id = $mail_list->parent_id;
                    }
                    // $subject = str_replace("'","\'",$subject);
                    // $subject = strpos($subject,"RE: ")!== false?str_replace("RE: ", "",$subject):$subject;
                    // $subject = strpos($subject,"FW: ")!== false?str_replace("FW: ", "",$subject):$subject;
                    // $subject = strpos($subject,"FWD: ")!== false?str_replace("FWD: ", "",$subject):$subject;
                    // pr($subject);die;
                    // $where = "subject LIKE '%".$subject."%'";
                    // $query = $thisObj->db->select('id')->from($thisObj->data['table'])->where('subject',$subject)->where('type',$thisObj->type)->get();
                    // if($query->num_rows() > 0)
                    // {
                        // $parent_id = $query->row()->id;
                    // }
                }
                $save_data['parent_id']  = $parent_id;  
                //===================now get mail parent id===========================//
                
                // set_common_insert_value2();
                // pr($save_data);die;

                $thisObj->db->insert($thisObj->data['table'], $save_data);
                $last_id = $thisObj->db->insert_id();
                if($_POST['edit_draft'] == 1) {
                    $thisObj->db->where('id', $id);
                    $thisObj->db->delete($thisObj->data['table']);
                    // echo $thisObj->db->last_query();die;
                }

                // pr($attachmentdata);die;
                if(isset($attachmentdata) && !empty($attachmentdata))
                {
                    foreach ($attachmentdata as $key => $value) {
                        $attachmentdata[$key]['email_data_id'] = $last_id;
                    }
                    // pr($attachmentdata);die;
                    $thisObj->db->insert_batch($thisObj->data['table_doc'], $attachmentdata);
                }
                
                /*if(isset($attachmentdata_old) && !empty($attachmentdata_old))
                {
                    foreach ($attachmentdata_old as $key => $value) {
                        $attachmentdata_old[$key]['email_data_id'] = $last_id;
                    }
                    // pr($attachmentdata_old);die;
                    $thisObj->db->insert_batch($thisObj->data['table_doc'], $attachmentdata_old);
                }*/
                
                // add_report($id);
                echo json_encode(array('message'=>'Message sent successfully.', 'status'=>true));
                // set_flashdata('success',"Email sent successfully.");
                // echo "Email send successfully.";
            // }
            // else
            // {
            //     echo json_encode(array('message'=>'Message could not be send.', 'status'=>false));
            //     // set_flashdata('error',"Email could not be send.");
            //     // echo "Email could not be send";
            // }
        }
    }

    public function reply_all($id)
    {
        $thisObj    = &get_instance();
        $thisObj->reply($id);
    }

    public function forword($id='')
    {
    	$thisObj = &get_instance();
    	if(empty($id))
    	{
    		return false;
    	}
    	if(isPostBack())
    	{
    		
    		// pr($_POST);die;
    		// pr($_FILES['attachment']);die;
    		$result		= $thisObj->mail_mod->get($id);
       		$mail_list	= $result['mail_list'];
    		$mail_doc	= $result['mail_doc'];
    		$to 		= [];
    		$cc 		= [];
    		$bcc 		= [];
            $userCred = get_smtp_user($thisObj->type, $thisObj->data['country_type']); // 1 for india
            if(isset($userCred) && !empty($userCred) && isset($userCred->smtp_host) && !empty($userCred->smtp_host) && isset($userCred->smtp_port) && !empty($userCred->smtp_port) && isset($userCred->smtp_port) && !empty($userCred->smtp_port) && isset($userCred->password) && !empty($userCred->password))
            {
                $smtp['smtp_host'] = $userCred->smtp_host;
                $smtp['smtp_port'] = $userCred->smtp_port;
                $smtp['smtp_user'] = $userCred->email_id;
                $smtp['smtp_pass'] = $userCred->password;
            }
    		if(isset($_POST['to']) && !empty($_POST['to']))
    		{
    			$to = explode(',', $_POST['to']);
    			foreach ($to as $to_key => $to_value) {
    				if(!filter_var($to_value,FILTER_VALIDATE_EMAIL))
    				{
    					set_flashdata('error',"Some email id is invalid.");
    					echo "Some email id is invalid";
    					return false;
    				}
    			}
    		}
    		if(isset($_POST['cc']) && !empty($_POST['cc']))
    		{
    			$cc = explode(',', $_POST['cc']);
    			foreach ($cc as $cc_key => $cc_value) {
    				if(!filter_var($cc_value,FILTER_VALIDATE_EMAIL))
    				{
    					set_flashdata('error',"Some email id is invalid.");
    					echo "Some email id is invalid";
    					return false;
    				}
    			}
    		}
    		if(isset($_POST['bcc']) && !empty($_POST['bcc']))
    		{
    			$bcc = explode(',', $_POST['bcc']);
    			foreach ($bcc as $bcc_key => $bcc_value) {
    				if(!filter_var($bcc_value,FILTER_VALIDATE_EMAIL))
    				{
    					set_flashdata('error',"Some email id is invalid.");
    					echo "Some email id is invalid";
    					return false;
    				}
    			}
    		}
    		// pr($cc);die;
    		/*Start save client multiple  attachment*/
	        $attachments    = [];
            $attachmentdata = [];
            $folder_doc     = './upload/email_attachment/';
            if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                // echo "string";
                foreach ($_FILES['attachment']['name'] as $attachment_key => $attachment_value) {
                    $_FILES['attachment_file']['name']     = $_FILES['attachment']['name'][$attachment_key];
                    $_FILES['attachment_file']['type']     = $_FILES['attachment']['type'][$attachment_key];
                    $_FILES['attachment_file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$attachment_key];
                    $_FILES['attachment_file']['error']    = $_FILES['attachment']['error'][$attachment_key];
                    $_FILES['attachment_file']['size']     = $_FILES['attachment']['size'][$attachment_key];
                    // $fileData=$thisObj->uploadDoc($_FILES['attachment_file']);
                    $fileData = uploadDoc($_FILES['attachment_file'], $folder_doc, 'attachment_file');
                    // pr($fileData);die;
                    if(isset($fileData['success'])){
                        $attachments[]  = FCPATH.'/upload/email_attachment/'.$fileData['success']['file_name'];
                        $attachmentdata[$attachment_key]['file_title']  = $fileData['success']['file_name'];
                        $attachmentdata[$attachment_key]['filename']    = $fileData['success']['file_name'];   
                    }
                }
            }
			// pr($mail_doc);die;

			$old_attachments = [];
            $attachmentdata_old = [];
	        if(isset($mail_doc) && !empty($mail_doc))
	        {
	        	foreach ($mail_doc as $key => $old_attachment) {
	        		
	        		$old_attachments[]  =  FCPATH.'/upload/email_attachment/'.$old_attachment['filename'];
                    $attachmentdata_old[$key]['file_title']  = $old_attachment['file_title'];
                    $attachmentdata_old[$key]['filename']    = $old_attachment['filename'];   
	        	}
	        }
	        // pr($old_attachments);die;
            $old_header = '';
            $old_header .= "<p style='margin: 0;'><b>From:</b>".$mail_list->from_name." <span>".$mail_list->from_email."</span></p>";
            $old_header .= "<p style='margin: 0;'><b>Sent:</b> <span>".date('D, d M Y, H:i:s', strtotime($mail_list->mail_date))."</span></p>";
            $old_header .= "<p style='margin: 0;'><b>To:</b> <span>".filter_var($mail_list->to_name, FILTER_VALIDATE_EMAIL)."</span>&nbsp;<span>".$mail_list->to_email."</span></p>";
            $old_header .= "<p style='margin: 0;'><b>Subject:</b>".html_entity_decode($mail_list->subject)."</p>";
            if($mail_list->cc_email== 'N;' || empty($mail_list->cc_email)) {
                $old_header .= "<br>";
            }else{
            $old_header .= "<p style='margin: 0;'><span style='color: #999;'>Cc:</span> <span>".implode(',', getEmailArrayFromString($result->cc_email))."</span></p><br>";
            }
            
	        $body = $_POST['body']."<hr>".$old_header.$mail_list->message;
            $subject = $_POST['subject'];
	        // pr($body);die;
    		$status = $thisObj->SendEmail($_POST['subject'], $body, $to, $cc, $bcc, $attachments, $old_attachments, NULL, $smtp);
    		if($status)
    		{
    			add_report($id);
    			set_flashdata('success',"Email send successfully.");
    			$user_id                     = @currentuserinfo()->id;
                $save_data['user_id']       = $user_id;
                $save_data['from_email']    = $smtp['smtp_user'];
                $save_data['type']          = $thisObj->type;
                $save_data['to_email']      = isset($to) && !empty($to)?implode(",", $to):'';
                $save_data['cc_email']      = isset($cc) && !empty($cc)?implode(",", $cc):'';
                $save_data['bcc_email']     = isset($bcc) && !empty($bcc)?implode(",", $bcc):'';
                $save_data['subject']       = $subject;
                $save_data['message']       = $body;
                $save_data['msg_type']      = 'sent';
                $save_data['is_attachment'] = isset($attachmentdata) && !empty($attachmentdata)?1:0;
                $save_data['mail_date']     = date('Y-m-d H:i:s');
                set_common_insert_value2();
                $thisObj->db->insert($thisObj->data['table'], $save_data);
                $last_id = $thisObj->db->insert_id();

                // pr($attachmentdata);die;
                if(isset($attachmentdata) && !empty($attachmentdata))
                {
                    foreach ($attachmentdata as $key => $value) {
                        $attachmentdata[$key]['email_data_id'] = $last_id;
                    }
                    // pr($attachmentdata);die;
                    $thisObj->db->insert_batch($thisObj->data['table_doc'], $attachmentdata);
                }
                
                if(isset($attachmentdata_old) && !empty($attachmentdata_old))
                {
                    foreach ($attachmentdata_old as $key => $value) {
                        $attachmentdata_old[$key]['email_data_id'] = $last_id;
                    }
                    // pr($attachmentdata_old);die;
                    $thisObj->db->insert_batch($thisObj->data['table_doc'], $attachmentdata_old);
                }
                
                add_report($id);
                set_flashdata('success',"Email sent successfully.");
    			// echo "Email send successfully.";

    		}
    		else
    		{
    			set_flashdata('error',"Email could not be send.");
    			// echo "Email could not be send";
    		}
    	}
        redirect($thisObj->data['base_url']."/view/".$_POST['mail_id']);
    }
	
    public function compose_email($msg_type)
    {
        $thisObj = &get_instance();
        if(isPostBack())
        {
            // pr($_FILES);
            // die;
            $to         = [];
            $cc         = [];
            $bcc        = [];
            $body       = $_POST['body']."<br>";
            $subject    = isset($_POST['subject']) && !empty($_POST['subject'])?$_POST['subject']:'';
            $fromName = $thisObj->mail_mod->from_name($_POST['user_id']);
            $toName   = $thisObj->mail_mod->toNames($_POST['vendor_id']);
            // if(isset($_POST['to']) && !empty($_POST['to']))
            // {
            //     $to = explode(',', $_POST['to']);
            //     foreach ($to as $to_key => $to_value) {
            //         if(!filter_var($to_value,FILTER_VALIDATE_EMAIL))
            //         {
            //             echo json_encode(array('message'=>'Some email id is invalid.', 'status'=>false));
            //             // set_flashdata('error',"Some email id is invalid.");
            //             // echo "Some email id is invalid";
            //             return false;
            //         }
            //     }
            // }


            // if(isset($_POST['cc']) && !empty($_POST['cc']))
            // {
            //     $cc = explode(',', $_POST['cc']);
            //     foreach ($cc as $cc_key => $cc_value) {
            //         if(!filter_var($cc_value,FILTER_VALIDATE_EMAIL))
            //         {
            //             echo json_encode(array('message'=>'Some email id is invalid.', 'status'=>false));
            //             // set_flashdata('error',"Some email id is invalid.");
            //             // echo "Some email id is invalid";
            //             return false;
            //         }
            //     }
            // }

            // if(isset($_POST['bcc']) && !empty($_POST['bcc']))
            // {
            //     $bcc = explode(',', $_POST['bcc']);
            //     foreach ($bcc as $bcc_key => $bcc_value) {
            //         if(!filter_var($bcc_value,FILTER_VALIDATE_EMAIL))
            //         {
            //             echo json_encode(array('message'=>'Some email id is invalid.', 'status'=>false));
            //             // set_flashdata('error',"Some email id is invalid.");
            //             // echo "Some email id is invalid";
            //             return false;
            //         }
            //     }
            // }

            // pr($thisObj->data);die;
            /*Start save client multiple  attachment*/
            $smtp           = [];
            $attachments    = [];
            $attachments2   = [];
            $attachmentdata = [];
            // pr($_FILES);die;
            $folder_doc = 'assets/uploads/temp_attachment/';
            if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                // echo "string";
                foreach ($_FILES['attachment']['name'] as $attachment_key => $attachment_value) {
                    $_FILES['attachment_file']['name']     = $_FILES['attachment']['name'][$attachment_key];
                    $_FILES['attachment_file']['type']     = $_FILES['attachment']['type'][$attachment_key];
                    $_FILES['attachment_file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$attachment_key];
                    $_FILES['attachment_file']['error']    = $_FILES['attachment']['error'][$attachment_key];
                    $_FILES['attachment_file']['size']     = $_FILES['attachment']['size'][$attachment_key];
                    $fileData = uploadDoc($_FILES['attachment_file'], $folder_doc, 'attachment_file');
                    // pr($fileData);die;
                    if(isset($fileData['success'])){
                        $attachments[]  = FCPATH.'/upload/email_attachment/'.$fileData['success']['file_name']; 
                        $attachmentdata[$attachment_key]['file_title']  = $fileData['success']['file_name'];
                        $attachmentdata[$attachment_key]['filename']    = $fileData['success']['file_name'];
                    }
                }
            }
            // if(isset($_POST['is_already_draft']) && !empty($_POST['is_already_draft']) && !isset($_POST['save_draft']))
            if(isset($_POST['is_already_draft']) && !empty($_POST['is_already_draft']))
            {
                $last_id = $_POST['is_already_draft'];
                $draft_attachment = $thisObj->mail_mod->get_doc($last_id);
                foreach ($draft_attachment as $attachment_key => $attachment) {
                    $attachments2[] = FCPATH.'/upload/email_attachment/'.$attachment['filename'];
                }
                // pr($attachments2);die;

            }
            // elseif(isset($_POST['is_already_draft']) && !empty($_POST['is_already_draft']) && isset($_POST['save_draft']))
            // pr($_POST);
            // pr($_POST['is_already_draft']);die;
             if(isset($_POST['is_already_draft']) && !empty($_POST['is_already_draft']))
            {
                // echo "yes";die;

                $last_id = $_POST['is_already_draft'];
                // $user_id = @currentuserinfo()->id;
                // $draft_data['user_id']      = $user_id;
                // $draft_data['type']         = $thisObj->type;
                // $draft_data['to_email']     = isset($to) && !empty($to)?implode(",", $to):'';
                // $draft_data['cc_email']     = isset($cc) && !empty($cc)?implode(",", $cc):'';
                // $draft_data['bcc_email']    = isset($bcc) && !empty($bcc)?implode(",", $bcc):'';
                // $draft_data['subject']      = $subject;
                // $draft_data['message']      = $body;
                // $draft_data['msg_type']     = 'draft';
                // // $draft_data['msg_status']   = isset($_POST['save_draft'])?2:0;
                // // set_common_update_value2();
                

                $draft_data['from_name']        = $fromName->first_name;
                $draft_data['to_name']          = $toName->first_name;
                $draft_data['user_id']          = $_POST['user_id'];
                $draft_data['vendor_id']        = $_POST['vendor_id'];
                $draft_data['type']             = $thisObj->type;
                $draft_data['from']             = $_POST['from'];
                $draft_data['sender_type']      = $_POST['sender_type'];
                $draft_data['receiver_type']    = 0;
                $draft_data['email_label']      = $_POST['email_label'];
                $draft_data['draft']            = $_POST['draft'];
                $draft_data['type_message']     = $_POST['type_message'];

                // $draft_data['to_email']     = isset($to) && !empty($to)?implode(",", $to):'';
                $draft_data['to']               = isset($to) && !empty($to)?implode(",", $to):'';
                $draft_data['cc_email']         = isset($cc) && !empty($cc)?implode(",", $cc):'';
                $draft_data['bcc_email']        = isset($bcc) && !empty($bcc)?implode(",", $bcc):'';
                $draft_data['subject']          = $subject;
                $draft_data['message']          = $body;
            
                $draft_data['msg_type']         = isset($_POST['save_draft'])?'draft':'outbox';

                $thisObj->db->where("id", $last_id);
                $thisObj->db->update($thisObj->data['table'], $draft_data);
                // echo $thisObj->db->last_query();die;
            } else {
                $draft_data['user_id']          = $_POST['user_id'];
                $draft_data['vendor_id']        = $_POST['vendor_id'];
                $draft_data['type']             = $thisObj->type;
                $draft_data['from']             = $_POST['from'];
                $draft_data['from_name']        = $fromName->first_name;
                $draft_data['sender_type']      = $_POST['sender_type'];
                $draft_data['receiver_type']    = 0;
                $draft_data['email_label']      = $_POST['email_label'];
                $draft_data['draft']            = $_POST['draft'];
                $draft_data['type_message']      = $_POST['type_message'];
                $draft_data['to_name']          = $toName->first_name;
                // $draft_data['to_email']     = isset($to) && !empty($to)?implode(",", $to):'';
                $draft_data['to']               = isset($to) && !empty($to)?implode(",", $to):'';
                $draft_data['cc_email']         = isset($cc) && !empty($cc)?implode(",", $cc):'';
                $draft_data['bcc_email']        = isset($bcc) && !empty($bcc)?implode(",", $bcc):'';
                $draft_data['subject']          = $subject;
                $draft_data['message']          = $body;
                $draft_data['msg_type']         = isset($_POST['save_draft'])?'draft':'outbox';
                // $draft_data['msg_status']   = isset($_POST['save_draft'])?2:0;
                // set_common_insert_value2();
                // echo "mail data";die;
                $thisObj->db->insert($thisObj->data['table'], $draft_data);
                // echo $thisObj->db->last_query();die;
                $last_id = $thisObj->db->insert_id();
                $thisObj->db->where("id", $last_id);
                $thisObj->db->update("email_data", ['parent_id'=>$last_id]);
            }
            if(isset($attachmentdata) && !empty($attachmentdata))
            {
                foreach ($attachmentdata as $key => $value) {
                    $attachmentdata[$key]['email_data_id'] = $last_id;
                }
                // pr($attachmentdata);die;
                $thisObj->db->insert_batch($thisObj->data['table_doc'], $attachmentdata);
            }
            // add_report($last_id);
            if(isset($_POST['save_draft']))
            {
                echo json_encode(array('message'=>'Message saved to draft.', 'status'=>true));
                return false;
                // set_flashdata('success',"Email saved to draft.");
                // return redirect($thisObj->data['base_url']."/".($msg_type=='inbox'?'list_items':$msg_type));
            }
            // pr($old_attachments);die;
            // pr($body);die;
            // echo "yes";die;
            /*Update where email sent*/
            $thisObj->db->where("id", $last_id);
            $thisObj->db->update("email_data", ['msg_type'=>'sent','from_email'=>$smtp['smtp_user'],'mail_date'=>date('Y-m-d H:i:s')]);
            /*Update where email sent*/
            echo json_encode(array('message'=>'Message Sent.', 'status'=>true));

            // set_flashdata('success',"Email sent.");

            // $userCred = get_smtp_user($thisObj->type, $thisObj->data['country_type']); // 1 for india
            // pr($userCred);die;
            // if(isset($userCred) && !empty($userCred) && isset($userCred->smtp_host) && !empty($userCred->smtp_host) && isset($userCred->smtp_port) && !empty($userCred->smtp_port) && isset($userCred->smtp_port) && !empty($userCred->smtp_port) && isset($userCred->password) && !empty($userCred->password))
            // {
            //     $smtp['smtp_host'] = $userCred->smtp_host;
            //     $smtp['smtp_port'] = $userCred->smtp_port;
            //     $smtp['smtp_user'] = $userCred->email_id;
            //     $smtp['smtp_pass'] = $userCred->password;
            // }


            // // $status = $thisObj->SendEmail($subject, $body, $to, $cc, $bcc, $attachments, $attachments2, NULL, $smtp);
            // if($status)
            // {
            //     /*foreach ($attachments as $key => $attachment) {
            //         unlink($attachment);
            //     }*/

            //     /*Update where email sent*/
            //     $thisObj->db->where("id", $last_id);
            //     $thisObj->db->update("email_data", ['msg_type'=>'sent','from_email'=>$smtp['smtp_user'],'mail_date'=>date('Y-m-d H:i:s')]);
            //     /*Update where email sent*/
                
            //     set_flashdata('success',"Email sent.");
            // }
            // else
            // {
            //     set_flashdata('error',"Email could not be send.");
            // }
            // return redirect($thisObj->data['base_url']."/".($msg_type=='inbox'?'list_items':$msg_type));
            // return redirect($thisObj->data['base_url']."/".($msg_type=='inbox'?'list_items':$msg_type));
        }
    }
        
    public function sync_inbox($msg_type="inbox")
    {
        $thisObj 	= &get_instance();
        $userCred 	= get_smtp_user($thisObj->type, $thisObj->data['country_type']);
        // pr($userCred);die;
        if($userCred->is_sync == 1)
        {
            set_flashdata('error',"Email synchronization already in process.");
            return redirect($thisObj->data['base_url']."/".($msg_type=='inbox'?'list_items':$msg_type));exit;
        }

        if(!empty($userCred) && count((array) $userCred)>0 && !empty($userCred->email_id) && !empty($userCred->password))
        {
        	$username 	= $userCred->email_id;
        	$password 	= $userCred->password;
            $mailbox  	= $userCred->mailbox;
            $label  	= $userCred->label;
            $sentbox  	= $userCred->sentbox;
            $encrypto  	= $userCred->encrypto;
            $imap_port	= $userCred->imap_port;
        }
        else
        {
        	set_flashdata('error', "Email account details not exist for this module. Please add email account details.");
            return redirect($thisObj->data['base_url'].'/'.($msg_type=='inbox'?'list_items':$msg_type));
        }

        if($msg_type=='inbox')
        {
        	$config['encrypto'] = $encrypto;
	        $config['validate'] = false;
	        $config['host']     = $mailbox;
	        $config['port']     = $imap_port;
	        $config['username'] = $username;
	        $config['password'] = $password;
	        $config['folder'] 	= 'INBOX';
        }
        else
        {
        	$config['encrypto'] = $encrypto;
	        $config['validate'] = false;
	        $config['host']     = $mailbox;
	        $config['port']     = $imap_port;
	        $config['username'] = $username;
	        $config['password'] = $password;
	        $config['folder'] 	= $sentbox;
        }
        update_smtp_user($thisObj->type, $thisObj->data['country_type'],1);
        // pr($config);die;
        $thisObj->load->library('imap');
        $stream = $thisObj->imap->connect($config);
        // pr($thisObj->imap->get_folders());die;
        // $stream = 1;
        if (!$stream) {
        	
            set_flashdata('error', 'Cannot connect to your mail server: ' . '<a href="https://www.google.com/search?q='.$mailbox.'" target="_blank">Allow access to your Email account</a>');
        } 
        else 
        {
	        
	        $data = [];
	        $user_id = @currentuserinfo()->id;
	        if(empty($user_id)) return false;
	        mb_internal_encoding("UTF-8");
            $last_sync_date = false;
            $last_msg_id    = 0;
	        $last_msg 	    = last_msg($msg_type, $username, $thisObj->type, $thisObj->data['country_type']);
            if(isset($last_msg) && !empty($last_msg))
            {
                $last_msg_id    = $last_msg->mail_id;
                $last_sync_date = $last_msg->last_sync;
            }

            /*$last_msg_id    = last_msg_id_new($user_id, $msg_type, $username, $thisObj->type, $thisObj->data['country_type']);
	        $last_sync_date = get_data_last_dates_new($user_id, $msg_type, $username, $thisObj->type, $thisObj->data['country_type']);*/
            // pr($last_msg);die;
	        // echo $last_sync_date;
	        // $last_msg_id 	= isset($last_msg_id) && !empty($last_msg_id)?$last_msg_id:0;

	        if(!$last_sync_date && $thisObj->data['country_type']=='2')
            {
                $last_sync_date = '2020-03-15';
            }

            if ($last_sync_date) {
                $date 	= date('d-M-Y', strtotime($last_sync_date. ' -1 day'));
                $emails = $thisObj->imap->search('SINCE ' . $date);
            }
            else {
            	$emails = $thisObj->imap->search('ALL');
            }
	        // pr($emails);die;
	        asort($emails);
	        if (count($emails) && $emails) {
                $thisObj->db->db_debug = false;
                
	            foreach ($emails as $email_number) {
	            	if ($email_number > $last_msg_id) {
                        // $mail_id = $_GET['mail_id'];
		                $message	= $thisObj->imap->get_message($email_number);
                        // pr($message);die;
						$data['user_id'] 		= $user_id;
				        $data['type']   		= $thisObj->type;
				        $data['added_by']		= $user_id;
				        $data['mail_id']		= $email_number;
				        $data['last_ip']		= current_ip();
				        $data['uid']			= $message['uid'];
				        $data['message_id']		= $message['message_id'];
				        $data['from_email']		= $message['from']['email'];
				        $data['from_name']		= $message['from']['name'];
				        $data['to_email']		= implode(',', array_column($message['to'], 'email'));
				        $data['to_name']		= implode(',', array_column($message['to'], 'name'));
				        $data['reply']			= implode(',', array_column($message['reply_to'], 'email'));
				        $data['reply_name']		= implode(',', array_column($message['reply_to'], 'name'));
				        $data['cc_email']		= implode(',', array_column($message['cc'], 'email'));
				        $data['bcc_email']		= implode(',', array_column($message['bcc'], 'email'));
				        $data['subject']		= trim($message['subject']);
				        $data['message']		= $message['body'];
				        $data['is_attachment']	= 0;
				        $data['mail_date']		= date('Y-m-d h:i:s', $message['udate']);
				        $data['last_sync']		= date('Y-m-d', $message['udate']);
				        $data['msg_type']		= $msg_type;
                        //===================now get mail parent id===========================//
                        $parent_id = 0;
                        $subject = $data['subject'];
                        if($subject)
                        {
                            // var_dump(strpos($subject,"FW: "));
                            $subject = str_replace("'","\'",$subject);
                            $subject = strpos($subject,"RE: ")!== false?str_replace("RE: ", "",$subject):$subject;
                            $subject = strpos($subject,"FW: ")!== false?str_replace("FW: ", "",$subject):$subject;
                            $subject = strpos($subject,"FWD: ")!== false?str_replace("FWD: ", "",$subject):$subject;
                            // pr($subject);die;
                            // $where = "subject LIKE '%".$subject."%'";
                            $query = $thisObj->db->select('id')->from($thisObj->data['table'])->where('subject',$subject)->where('type',$thisObj->type)->get();
                            if($query->num_rows() > 0)
                            {
                                $parent_id = $query->row()->id;
                            }
                        }
                        $data['parent_id']      = $parent_id;  
                        //===================now get mail parent id===========================//
				        $attachments 			= [];
				        // pr($data);die;
				        if(isset($message['attachments']) && !empty($message['attachments']) && count($message['attachments']))
				        {

					        foreach ($message['attachments'] as $att_key => $attach) {
				                $destination 	= FCPATH.'/upload/email_attachment/';
				                $filename 		= $attach['name'];
				                $extension 		= pathinfo($filename)['extension'];
				                $filename_md5   = time().uniqid().'.'.$extension;
				                $target_path 	= $destination . $filename_md5;
				                $fpp 			= file_put_contents($target_path, $attach['content'] );
				                // $fp = fopen(iconv($target_path, "w+");
				                // fwrite($fpp, $attach['content']);
				                // fclose($fp);
				                $attachments[$att_key]['file_title'] 	= $filename;
				                $attachments[$att_key]['filename'] 		= $filename_md5;
					        }
				        }

					    if($query = $thisObj->db->insert($thisObj->data['table'], $data))
                        {
    					    $last_id = $thisObj->db->insert_id();

    					    if(isset($attachments) && !empty($attachments))
    					    {
    					    	foreach ($attachments as $key1 => $value1) {
    	                        	$attachments[$key1]['email_data_id'] = $last_id;
    	                        }
                            	$thisObj->db->insert_batch($thisObj->data['table_doc'], $attachments);
    					    }
                        }
					}
	            }
	        }
            set_flashdata('success', "Email synchronization successfully.");   
	    }
        update_smtp_user($thisObj->type, $thisObj->data['country_type'],0);
        return redirect($thisObj->data['base_url']."/".($msg_type=='inbox'?'list_items':$msg_type));
    }

    public function sync_inbox2($msg_type="inbox")
    {

    	$thisObj = &get_instance();
        $user_id = @currentuserinfo()->id;
        if(empty($user_id)) return false;


        $userCred = get_smtp_user($thisObj->type, $thisObj->data['country_type']);

        if(!empty($userCred) && count((array) $userCred)>0 && !empty($userCred->email_id) && !empty($userCred->password))
        {
        	$username 	= $userCred->email_id;
        	$password 	= $userCred->password;
            $mailbox  	= $userCred->mailbox;
            $label  	= $userCred->label;
            $sentbox  	= $userCred->sentbox;
        }
        else
        {
        	set_flashdata('error', "Email account details not exist for this module. Please add email account details.");
            return redirect($thisObj->data['base_url'].'/'.($msg_type=='inbox'?'list_items':$msg_type));
        }

        if($msg_type=='inbox')
        {
        	$sync_mail_ac = array(
				// 'label'    => $label,
				// 'enable'   => true,
				// 'mailbox'  => $mailbox,
	            // 'mailbox'  => '{imap.qq.com:993/imap/ssl/novalidate-cert}INBOX',
	            'mailbox'  => '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX',
				'username' => 'developers.sm@gmail.com',
				'password' => 'developers@1234'
			);
        }
        else
        {
        	$sync_mail_ac = array(
				// 'label'    => $label,
				// 'enable'   => true,
				'mailbox'  => $sentbox,
				'username' => $username,
				'password' => $password
			);
        }
		/*Start email sync*/
        $stream = imap_open($sync_mail_ac['mailbox'], $sync_mail_ac['username'], $sync_mail_ac['password']);
        // $mailboxes = imap_list($stream, $sync_mail_ac['mailbox'], '*');
        mb_internal_encoding("UTF-8");
        // pr($stream);
        // pr($mailboxes);die;
        if (!$stream) {
        	
            set_flashdata('error', 'Cannot connect to your mail server: ' . '<a href="https://www.google.com/search?q='.$sync_mail_ac['mailbox'].'" target="_blank">Allow access to your Email account</a>');
        } 
        else 
        {
        	
	        $last_msg_id 	= last_msg_id_new($user_id, $msg_type, $username, $thisObj->type, $thisObj->data['country_type']); //1 for india
	        // echo $last_msg_id;die;
	        $last_msg_id 	= isset($last_msg_id) && !empty($last_msg_id)?$last_msg_id:0;
        	$last_sync_date = get_data_last_dates_new($user_id, $msg_type, $username, $thisObj->type, $thisObj->data['country_type']);
        	$last_sync_date = NULL;
        	// echo $last_sync_date;die;
            if (@$last_sync_date) {

                $date = date('d-M-Y', strtotime($last_sync_date));
                $emails = imap_search($stream, 'SINCE ' . $date);
                // $emails = imap_search($stream, 'UNSEEN ');

            } else {
            	// $emails   = imap_search($stream, 'SUBJECT "Test Subject tiwari ji"');
                $emails = imap_search($stream, "ALL");
            }
            // pr($emails);die;
           	/*echo "emails";
            pr($emails);
            $headerinfo = imap_headerinfo($stream,1, 0);
            echo "headerinfo";
            pr($headerinfo);
         	$overview = imap_fetch_overview($stream, 1, 0);
            echo "overview";
            pr($overview);
			$structure   = imap_fetchstructure($stream, 1);
            echo "structure";
            pr($structure);
            $message = quoted_printable_decode(imap_fetchbody($stream,1,1));
            echo "message";
            pr($message);die;
            // Get our messages from the last week
            // Instead of searching for this week's message you could search for all the messages in your inbox using: $emails = imap_search($stream,'ALL');*/
            $newMail = false;
            if (count($emails) && $emails) {
            	// pr($emails);die;
                // If we've got some email IDs, sort them from new to old and show them
                // rsort($emails);
                foreach ($emails as $email_number) {
                    // print_r($email_number);die;
                    $last_msg_id = 1;
                    $email_number = 11;
                    if ($email_number > $last_msg_id) {

                        $overview = imap_fetch_overview($stream, $email_number, 0);
                        // echo "overview";
                        // pr($overview);

                        $header_info = imap_headerinfo($stream, $email_number);
                        // find out how may parts the object has
                        echo "header_info";
                        pr($header_info);
                        // $body = imap_fetchbody($stream, $email_number, 1);
                        // echo "Body";
                        // $body1 = base64_decode($body);
                        // echo mb_convert_encoding($body1, 'UTF-8', 'GB2312');
                                      
                        /* get mail structure */
                        $structure   = imap_fetchstructure($stream, $email_number);
                        echo "structure";
                        pr($structure);
                        die;
                        $parts       = $structure->parts;
                        $attachments = array();
                        if (!$structure->parts) {
                            $content = imap_body($stream, $email_number);
                            // echo "content";
                            // pr($content);
                        }
                        
                        /* No attachments */
                        //$content .= imap_fetchbody($stream, $email_number,'1.2');
                        /* if any attachments found... */
                        if (isset($structure->parts) && count($structure->parts)) {
                        	// pr($structure);die;
                            for ($i = 0; $i < count($structure->parts); $i++) {
                                $attachments[$i] = array(
                                    'is_attachment' => false,
                                    'is_inline'     => false,
                                    'filename'      => '',
                                    'name'          => '',
                                    'attachment'    => '');

                                if ($structure->parts[$i]->ifdparameters) {
                                    foreach ($structure->parts[$i]->dparameters as $object) {
                                        if (strtolower($object->attribute) == 'filename' || strtoupper($parts[$i]->disposition) == "ATTACHMENT") {

                                            $attachments[$i]['is_attachment'] = true;
                                            /*$path_parts                       = pathinfo($object->value);
                                            $extension                        = $path_parts['extension'];*/
                                            $attachments[$i]['filename']      = ($object->value); // removed md5 
                                            $content                          = imap_fetchbody($stream, $email_number, '1.2');
                                        }
                                    }
                                }

                                if ($structure->parts[$i]->ifparameters) {
                                    foreach ($structure->parts[$i]->parameters as $object) {
                                        if (strtolower($object->attribute) == 'name') {
                                            $attachments[$i]['is_inline'] = true;
                                            $attachments[$i]['name']      = $object->value;
                                            $attachments[$i]['file_title']= $object->value;
                                            $content                      = imap_fetchbody($stream, $email_number, '1.2');
                                        }
                                    }
                                }
                                if (strtoupper($parts[$i]->subtype) == "PLAIN" && strtoupper($parts[$i + 1]->subtype) != "HTML")
                                {
                                    /* Message */
                                    $content = imap_fetchbody($stream, $email_number, '2');
                                }
                                if (strtoupper($parts[$i]->subtype) == "HTML") {
                                    /* Message */
                                    $content = imap_fetchbody($stream, $email_number, '2');
                                }

                                if ($attachments[$i]['is_inline']) {
                                    $attachments[$i]['attachment'] = imap_fetchbody($stream, $email_number, $i + 1);

                                    /* 4 = QUOTED-PRINTABLE encoding */
                                    if ($structure->parts[$i]->encoding == 3) {
                                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                                    }
                                    /* 3 = BASE64 encoding */
                                    elseif ($structure->parts[$i]->encoding == 4) {

                                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                                    }
                                }
                            }
                        }
                        /* iterate through each attachment and save it */
                        $doc_arr = [];
                        foreach ($attachments as $att_key => $attachment) {
                            //Commented By Manish Kumar

                            if ($attachment['is_attachment'] == 1) {
	                            $filename = $attachment['filename'];
	                            if (empty($filename))
	                            $filename = $attachment['filename'];

	                            if (empty($filename))
	                            $filename = time() . ".dat";
	                            $destination = FCPATH.'/upload/email_attachment/'.$curr_user_id.'/';
	                            $path_parts = pathinfo($filename);
	                            $extension = $path_parts['extension'];
	                            if (!is_dir($destination)) {
	                            	mkdir($destination, 0777, true);
	                            }
	                            //preg_match_all('/src="cid:(.*)"/Uims', $content, $matches);
	                            /* prefix the email number to the filename in case two emails
	                            * have the attachment with the same file name.*/
	                            
	                            $fp = fopen($destination . time() . "-" . $filename, "w+");
	                            fwrite($fp, $attachment['attachment']);
	                            $doc_arr[$att_key]['filename'] = time() . "-" .$filename;
	                            $doc_arr[$att_key]['file_title'] = $filename;
	                            fclose($fp);
                            }

                            //Commented By Manish Kumar
                            if ($attachment['is_inline'] == 1) {
                                $filename = $attachment['name'];
                                if (empty($filename)) {
                                    $filename = $attachment['filename'];
                                }

                                if (empty($filename)) {
                                    $filename = time() . ".dat";
                                }

                                $destination = FCPATH.'/upload/email_attachment/'.$curr_user_id.'/';
                                $path_parts  = pathinfo($filename);
                                $filetype    = $path_parts['extension'];
                                if ($filetype == 'docx' || $filetype == 'pdf' || $filetype == 'rtf' || $filetype == 'doc')
                                {

                                    if (!is_dir($destination)) {
                                        mkdir($destination, 0777, true);
                                    }
                                    preg_match_all('/src="cid:(.*)"/Uims', $content, $matches);
                                    /* prefix the email number to the filename in case two emails
                                     * have the attachment with the same file name.
                                     */
                                    $fp = fopen($destination . time() . "-" . $filename, "w+");
                                    fwrite($fp, $attachment['attachment']);
                                    $doc_arr[$att_key]['filename'] = time() . "-" .$filename;
                                    $doc_arr[$att_key]['file_title'] = $filename;
                                    fclose($fp);
                                }
                            }
                        }

                        /* complicated message */
                        /* complicated message */
                        $from         			= mb_decode_mimeheader($overview[0]->from);
                        $from_emailid 			= trim(array_pop(explode('<', $from)), '>');
                        $to           			= mb_decode_mimeheader($overview[0]->to);
                        $subject      			= mb_decode_mimeheader($overview[0]->subject);
                        $subject      			= mb_decode_mimeheader($overview[0]->subject);
                        $mdate        			= $overview[0]->date;
                        $uid          			= $overview[0]->uid;
                        $mail_id      			= $email_number;
                        // $content                = base64_decode($content);
                        $content                = mb_convert_encoding($content, 'UTF-8', 'GB2312');
                        // pr($content);die;
                        $data         			= array(
                            'user_id'         	=> $user_id,
                            'type'              => $thisObj->type,
                            'added_by'        	=> $user_id,
                            'mail_id'         	=> $mail_id,
                            'from_email'        => $from_emailid,
                            'from_name'       	=> mb_decode_mimeheader($header_info->fromaddress),
                            'to_email'          => $to,
                            'to_name'         	=> mb_decode_mimeheader($header_info->to[0]->mailbox),
                            'reply'         	=> mb_decode_mimeheader($header_info->reply_to[0]->mailbox).'@'.mb_decode_mimeheader($header_info->reply_to[0]->host),
                            'reply_name'        => mb_decode_mimeheader($header_info->reply_to[0]->personal),
                            'subject'         	=> $subject,
                            'cc_email'        	=> serialize(mb_decode_mimeheader($header_info->ccaddress)),
                            'bcc_email'         => serialize(mb_decode_mimeheader($header_info->bccaddress)),

                            'message'         	=> ($content),
                            // 'recived_message' 	=> json_encode($attachments),
                            'uid'             	=> $uid,
                            'mail_date'  	  	=> date('Y-m-d h:i:s', strtotime($header_info->MailDate)),
                            'last_sync_date'  	=> $mdate,
                            'last_sync'       	=> date('Y-m-d'),
                            'msg_type'        	=> $msg_type);

                        $emailid = trim(array_pop(explode('<', $from)), '>');

                        $query   = $thisObj->db->insert($thisObj->data['table'], $data);
                        $last_id = $thisObj->db->insert_id();
                        if(isset($doc_arr) && !empty($doc_arr))
                        {
	                        foreach ($doc_arr as $key1 => $value1) {
	                        	$doc_arr[$key1]['email_data_id'] = $last_id;
	                        }
                        	$thisObj->db->insert_batch($thisObj->data['table_doc'], $doc_arr);
                        }

                        $newMail = true;
                        set_flashdata('success', "Email syncing successfully");

                    }
                }
            }
            if (!$newMail) {
                // echo "no_new_mail";die;
                set_flashdata('success', "Email syncing successfully. No new Email!");
            }
            imap_close($stream);
            //update_data(array('last_sync_date' => date('Y-m-d')), 'users', array('id' =>
            //$user_id));
        }
        return redirect($thisObj->data['base_url']."/".($msg_type=='inbox'?'list_items':$msg_type));
    }

    public function ajax_list_items($limit = 10)
	{ 
		$thisObj = &get_instance();
		$user=currentuserinfo();
		$perPage = $this->obj->enquiry_china_mod->perPage($user->id);
		if($perPage) {
		} else {
			$controllerInfo = $this->obj->uri->segment(1) . "/" . $this->obj->uri->segment(2);
			$pageArr = array(
				'action' => $controllerInfo,
				'records' => $this->obj->input->get_post('rp', true),
				'user_id' => $user->id);
				$this->obj->enquiry_china_mod->insert_perPage($pageArr);
		}
	   
		if($this->obj->input->post("order_by")) {
			$order_by = $this->obj->input->post("order_by");
		}else{
			$order_by = 'id';
		}
		if($this->obj->input->post("order")) {
			$order = $this->obj->input->post("order");
		}else{
			$order = 'desc';
		}
		$offset = $this->obj->input->post("offset");
		if(!$offset){
			$offset =1;
		}
		if(!$limit) {
			$limit = 10;
		}
		if($this->obj->input->post("limit")) {
			$limit = $this->obj->input->post("limit");
			$this->obj->data["hiddenLimit"] = $limit;
		}
		if($this->obj->input->post('text')) {
			$text = $this->obj->input->post('text');
		} else {
			$text = null;
		}
		
		$data = $this->obj->mail_mod->ajax_list_items($text, $limit, $offset, $order_by, $order);
		$permission=_check_perm();
	   // pr($data);die;
		foreach ($data['result'] as $row)
		{

			//pr($row->name);die;
			
			if ($row->status == '0')
			{
				$row->status = "Inactive";
			} else
			{
				$row->status = "Active";
			}  
				
			if($row->added_by == $user->id && ($permission != '1' && $permission !='' ))
			{
				$row->status =  $row->status;
				//$row->status = '<a href="' . $this->obj->data['base_url'] . '/status/' . $row->id . '" class="status" style="color:#000">' . $row->status . '</a>';
			}else
			{
				$row->status = '<a href="' . $this->obj->data['base_url'] . '/status/' . $row->id . '" class="status" style="color:#000">' . $row->status . '</a>';
			}
			//$cityResult = viewCity($row->city);
			//pr($cityResult);die;
			//$row->city = @$cityResult->cityName;
		}
	   
		$data['grid']['total'] = $data['total'];
		$data['grid']['cols'] = $this->obj->mail_mod->get_flexigrid_cols();
		$data['grid']['result'] = $data['result'];
		$data['grid']["page_offset"] = $offset;
		$data['grid']["limit"] = $limit;
		$data['grid']["base_url"] = $this->obj->data['base_url'];
		$this->obj->load->view('kg_grid/ajax_grid', $data);
	}
    
    public function add_mail_tags($msg_type)
    {
        // pr($_POST);die;
        $thisObj = &get_instance();
        if(isset($_POST['mail_id']) && !empty($_POST['mail_id']) && isset($_POST['tags']) && !empty($_POST['tags']))
        {
            $mail_id    = $_POST['mail_id'];
            $tags       = $_POST['tags'];
            $status     = $thisObj->db->query("UPDATE ".$thisObj->data['table']." SET `tags` = '".$tags."' WHERE `id` = ".$mail_id);
            // echo $thisObj->db->last_query();die;
            if($status)
            {
                set_flashdata('success',"Email tags saved successfully.");
            }
            else
            {
                set_flashdata('error',"Email tags could not be saved");
            }
        }
        else
        {
            set_flashdata('error',"Email tags could not be saved");
        }
        return redirect($thisObj->data['base_url']."/".($msg_type=='inbox'?'list_items':$msg_type));
    }
    

 	// ------------------------------------------------------------------------

    /**
     * Export items
     *
     * This function display Export by id
     * 
     * @access	public
     * @return	html data
     */
    
    public function export()
    {
    	$thisObj = &get_instance();
       $items          =$thisObj->input->get_post('items',TRUE);
       $items_data     = str_replace("row","",$items);       
       $items_data      = explode(",",$items_data);
       $data = $thisObj->mail_mod->export();

       export_report($items_data);
       array_to_csv($data,"Client.csv");
    }
    
    
  // ------------------------------------------------------------------------

    /**
     * delete items
     *
     * This function display delete by id
     * 
     * @access	public
     * @return	html data
     */
    
    public function delete()
    {
		$thisObj = &get_instance();
		$items           = $thisObj->input->get_post('items',TRUE);
		$items_data      = str_replace("row","",$items);       
		$items_data      = explode(",",$items_data);      

		$thisObj->db->where_in("id",$items_data);
		filter_data();
		$thisObj->db->delete($thisObj->table_name);
		delete_report($items_data);
    }
		
    public function delete_records()
    {
        $thisObj         = &get_instance();
        $items           = $thisObj->input->get_post('delRow',TRUE);
        $items_data      = explode(",",$items);
        $thisObj->db->where_in("id",$items_data);
        $status = $thisObj->db->delete($thisObj->data['table']);
        delete_report($items_data);
        if($status)
        {
            set_flashdata("success", 'Record successfully deleted');
            echo json_encode(['status'=>1]);
        }
        else
        {
            set_flashdata("error", 'Record could not be deleted');
            echo json_encode(['status'=>0]);
        }
    }
        
    public function status($id = null) {
    	$thisObj = &get_instance();
        $result = $thisObj->mail_mod->get($id);
        $r = $thisObj->mail_mod->status_update($id, $result->status);
        if($r) {
            redirect($thisObj->data['base_url'] . "/list_items");
        }

    }

    public function uploadDoc($file_arr) {
        
    	$thisObj = &get_instance();
		if ($file_arr['name'] != '') {
			
            $file_name = time() . "-" . $file_arr['name'];
			$folder_doc = './upload/email_attachment/';
			if (!file_exists($folder_doc)) {
				mkdir($folder_doc, 0777, true);
			}
			$file_arr['name'] 			= $file_name;
	        $config['upload_path'] 		= $folder_doc;
	        $config['allowed_types'] 	= check_file_extension();
	        $config['max_size'] 		= '20000';
	        $config['encrypt_name'] 	= false;
	        $config['remove_spaces'] 	= true;
	        $config['overwrite'] 		= false;
	        $thisObj->load->library('upload');
	        $thisObj->upload->initialize($config);
	        $data = [];
	        if (!$thisObj->upload->do_upload('attachment_file'))
	        {
	            $data['error'] = $thisObj->upload->display_errors();
	        } 
            else
	        {
	            $data['success'] = $thisObj->upload->data();
	        }
            // pr($data);
	        return $data;
		}
    }

    public function get_mail_list()
    {
        $thisObj = &get_instance();
        if ($thisObj->input->is_ajax_request()) 
        {

            $mail_id    = $thisObj->input->get_post('mail_id');
            $thisObj->db->select('tags');
            $thisObj->db->where("id",$mail_id);
            $query = $thisObj->db->get($thisObj->data['table']);
            // echo $this->db->last_query();
            if ($query->num_rows() > 0) {
                $result  = $query->row()->tags;
                echo json_encode(['status' => 1, 'message' => 'Record found', 'data' => $result]);
            } else {
                echo json_encode(['status' => 0, 'message' => 'No record found', 'data' => '']);
            }
        } else {
            echo json_encode(['status' => 0, 'message' => 'No direct script access allowed', 'data' => '']);
        }
    }
  
    public function addNote() {
		$thisObj = &get_instance();
		
		$var = $_POST['email_tag'];
		//pr($var);die;
		$standard_tags = implode(',',$var);
		$id = $_POST['id'];
		$data['standard_tags'] =  $standard_tags;

		$thisObj->db->where('id',$id);
		$status = $thisObj->db->update($thisObj->data['table'],$data);
		//pr($thisObj->db->last_query());die;
		if($status)
		{
			set_flashdata("success", "Tag saved successfully.");
		}
		else
		{
			set_flashdata("error", "Tag could not be saved.");
		}
		
        return redirect($thisObj->data['base_url']."/view/".$id);
	}
	 
	public function release(){
		$thisObj = &get_instance();
		$id = $_POST['id'];
		$data['release_email'] = $_POST['release_email'];
		$thisObj->db->where('id',$id);
		$data = $thisObj->db->update($thisObj->data['table'],$data);
	}
	public function unrelease(){
		$thisObj = &get_instance();
		$id = $_POST['id'];
		$data['release_email'] = $_POST['release_email'];
		$thisObj->db->where('id',$id);
		$data = $thisObj->db->update($thisObj->data['table'],$data);
	}

    public function assignCategory(){
        $thisObj = &get_instance();
        $id = $_POST['id'];
        $data['type'] = $_POST['category'];
        $thisObj->db->where('id',$id);
        $data = $thisObj->db->update($thisObj->data['table'],$data);
 	}

 	public function download($id)
	{
		$thisObj = &get_instance();
		$thisObj->db->where('id', $id);
		$query = $thisObj->db->get($thisObj->data['table_doc']);
        // pr($thisObj->db->last_query());die;
		if($query->num_rows()>0)
		{
			$row = $query->row();
			// pr($row);die;
			$filepath = FCPATH.'/upload/email_attachment/'.$row->filename;
			$filename = $row->file_title;
			// pr($filepath);die;
            $fileExt = explode('.', $filename)[1];
            // pr($fileExt);die;
            if(file_exists($filepath))
            {
                if(ini_get('zlib.output_compression'))
                {
                    ini_set('zlib.output_compression', 'Off');
                }
                switch($fileExt)
                {
                    case "pdf": $ctype="application/pdf"; break;
                    case "exe": $ctype="application/octet-stream"; break;
                    case "zip": $ctype="application/zip"; break;
                    case "doc": $ctype="application/vnd.ms-word"; break;
                    case "xls": $ctype="application/vnd.ms-excel"; break;
                    case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
                    case "gif": $ctype="image/gif"; break;
                    case "png": $ctype="image/png"; break;
                    default: $ctype="application/force-download";
                }
                // $thisObj = &get_instance();
                // $thisObj->ob_clean_all();
                $ob_active = ob_get_length ()!== FALSE;
                while($ob_active)
                {
                    ob_end_clean();
                    $ob_active = ob_get_length ()!== FALSE;
                }
				header('Pragma: public');
				header('Expires: 0');
				// header('Cache-Control: must-revalidate');
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private",false);
                header('Content-Type: $ctype');
				header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                header("Content-Transfer-Encoding: binary");
				// header('Content-Description: File Transfer');
				// header('Content-Type: application/octet-stream');
				header('Content-Length: ' . filesize($filepath));
				// flush(); // Flush system output buffer
				readfile($filepath);
				die();
			}
		}
		else
		{
			return false;
		}
		// echo $this->db->last_query();
	}

    public function get_parent_mail_id($subject = "")
    {
       
        // var_dump($parent_id);die;
        return $parent_id;
    }

    public function read_status($id) {
        $thisObj = &get_instance();
        if(is_array($id) && count($id) > 1) {
            $thisObj->db->where_in('id', $id);
        } else {
            $thisObj->db->where('id', $id);
        }
        $thisObj->db->update('email_data', ['read_status'=>'1']);      
        
        if($thisObj->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function get_mail_doc($id) {
        $thisObj = &get_instance();
        $data = $thisObj->db->get_where('email_data_doc', ['email_data_id'=>$id])->result();
        return $data;
    }

    public function view_message_data($id) {
        $thisObj = &get_instance();
        if(!is_array($id)) {
            $thisObj->db->select('parent_id');   
            $thisObj->db->where('id', $id);
            $query1 = $thisObj->db->get('email_data')->row();

            $thisObj->db->select('e.id, e.parent_id, e.to_name, e.from_name, e.user_id, e.vendor_id, e.subject, e.created_date, e.message, e.draft, doc.file_title, doc.filename, e.type_message');
            $thisObj->db->join('email_data_doc as doc', 'doc.email_data_id = e.id', left);
            // $thisObj->db->where('e.id', $id);
            $thisObj->db->where('e.parent_id', $query1->parent_id);
           
            if(isset($_POST['search_type']) && $_POST['search_type'] == 'sendmessage') {
                $thisObj->db->where('e.draft', '2');
            }

            if(isset($_POST['search_type']) && $_POST['search_type'] == 'draftmessage') {
                $thisObj->db->where('e.draft', '1');
            }

            $thisObj->db->order_by('e.id', DESC);
            $query = $thisObj->db->get('email_data as e');
            if($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            } else {
                $data = '';
                return $data;
            }   
        }
    }


    public function unread_status($id) {
        $thisObj = &get_instance();
        if(is_array($id) && count($id) > 1) {
            $thisObj->db->where_in('id', $id);
        } else {
            $thisObj->db->where('id', $id);
        }
        $thisObj->db->update('email_data', ['read_status'=>'0']);      
        if($thisObj->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function star_message($id) {
        $thisObj = &get_instance();
        if(is_array($id)) {
            $thisObj->db->where_in('id', $id);
        } else {
            $thisObj->db->where('id', $id);
        }
        $query = $thisObj->db->get('email_data');      
        if($query->num_rows() > 0) {
            $data = $query->result();
            if(isset($data) && !empty($data)) {
                $myarr = [];
                foreach($data as $key=>$val) {
                    $myarr[$key]['user_id'] = $val->user_id;
                    $myarr[$key]['msg_id'] = $val->id;
                    $msg_id[] = $val->id;
                }
                $checkQueryData = $thisObj->db->get('msg_favourite');
                if ($checkQueryData->num_rows() > 0) {
                    $thisObj->db->where_in('msg_id', $msg_id);  
                    $thisObj->db->delete('msg_favourite');         
                } 
                $thisObj->db->insert_batch('msg_favourite', $myarr);
                return true;
            }
        } else {
            return false;
        }
    }

    public function unstar_message($id) {
        $thisObj = &get_instance();
        $checkQueryData = $thisObj->db->get('msg_favourite');
        
        if ($checkQueryData->num_rows() > 0) { 
            if(is_array($id) && count($id) > 1) {
                $thisObj->db->where_in('msg_id', $id);
            } else {
                $thisObj->db->where('msg_id', $id);
            }
            $thisObj->db->delete('msg_favourite');
         
            if ($thisObj->db->affected_rows()) {
                return  true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function delete_message($id) {
        $thisObj = &get_instance();
        // if(is_array($id) && count($id) > 1) {
        //     $thisObj->db->where_in('id', $id);
        // } else {
        //     $thisObj->db->where('id', $id);
        // }
        // $thisObj->db->delete('email_data');

        if(is_array($id) && count($id) > 1) {
            $thisObj->db->where_in('id', $id);
        } else {
            $thisObj->db->where('id', $id);
        }
        $thisObj->db->update('email_data', ['is_trash'=>'1']);
        if($thisObj->db->affected_rows()) {
            // $checkQueryData = $thisObj->db->get('msg_favourite');
            // if ($checkQueryData->num_rows() > 0) { 
            //     if(is_array($id) && count($id) > 1) {
            //         $thisObj->db->where_in('msg_id', $id);
            //     } else {
            //         $thisObj->db->where('msg_id', $id);
            //     }
            //     $thisObj->db->delete('msg_favourite');
            // }

            return true;
        } else {
            return false;
        }   
    }


    public function get_draftmsg() {
        $thisObj = &get_instance();
        $auth_user                  = $thisObj->session->userdata('auth_user');
        $user_id                    = $auth_user['users_id'];  
        $data['result'] = $thisObj->db->get_where('email_data', ['id'=>$_POST['id']])->result();
        $data['user']               = $thisObj->db->get_where('tbl_users',['parent_id'=>$user_id ])->result();

        if($data['result'] == '') {
            echo json_encode(array('message'=>'Message not found', 'status'=>false, 'data'=>''));
        } else {
            echo json_encode(array('message'=>'Message found', 'status'=>true, 'data'=>$data));
        }
    }

}

    
 