<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Forgetemail extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');
	}
	
	

     public function verifyemail()
        {
	   header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	   header("Content-Type: text/html;charset=UTF-8"); 
           $json = file_get_contents('php://input');
           $data=json_decode($json);

           $tomail = $data->userMailId;
	$userid=$this->Auth_model->chkmailvalid($tomail);
            if(count($userid)==1)
            {
		if($this->Auth_model->mailverifychk($tomail)) 
		{
            
                $otp=rand(100000,999999);

                if($this->Auth_model->updateotpbyuserid($otp,$userid[0]->id))
                {
                      $mail=$this->sendforgetmail($tomail,$otp,$userid[0]->name);

                    if($mail==1)
                    {
			$array=array(
			         "statusCode"=>200, 
				 "message" => "An OTP has been sent on your registered email id."
				    );
                        //$this->session->set_flashdata('success', 'An OTP has been sent on your registered email id .');
                        //redirect('resetpassword');
                    }else{
			$array=array(
			         "statusCode"=>400, 
				 "message" => "Error occurred while sending otp on your registered email!!!"
				    );
                        //$this->session->set_flashdata('error', 'Error occurred while sending otp on your registered email!!!');
                        //redirect('forgetemail');
                    }

                }else{
		    $array=array(
			         "statusCode"=>400, 
				 "message" => "Error occurred while creating your otp!!!"
				    );
                    //$this->session->set_flashdata('error', 'Error occurred while creating your otp!!!');
                    //redirect('forgetemail');
                }

           
	}
	else {
             $array=array(
			         "statusCode"=>400, 
				 "message" => "Please verify account email first!!!"
				    );
	 //$this->session->set_flashdata('error', 'Please verify account email first');
	 //redirect(base_url());
	}
	 }else{
                $array=array(
			         "statusCode"=>400, 
				 "message" => "Please enter registered email!!!"
				    );
                //$this->session->set_flashdata('error', 'Please input valid email!!!');
                //redirect('forgetemail');
            }
	 echo $myJSON = json_encode($array);
        }

        public function sendforgetmail($tomail,$otp,$name)
        {
            $subject='Forget password mail';

           $message='<div style="width:500px; margin:auto; font-family:Helvetica,Arial; font-size:13px; color:#333; line-height:18px; background:#fafafa; border:#F1F0F0 solid 1px; padding:10px 10px 0 10px;">
 
<div style="margin-bottom:35px;background:#fafafa; text-align:center;"><img src="'.logo_url().'" style="height:70px;" /></div>
<div class="mobile-br"  style="font-size:35px; font-weight: 600; color: #2f982e; text-align:center;">&nbsp; Welcome to <b>'.project_name().'</b> <br><br> </div>
 <div style="font-size:24px; text-align:center;"> <br>OTP E-Mail One Time Password!!!<br><br> </div>
<div style="margin-bottom:20px;">Dear '.$name.',</div>
<div style="margin-bottom:10px;">You told us you forgot your password.';
$message .=" That's okay! it happens. Use this OTP to reset your password.<br><br>";
$message .=' <div>
  <a href="javascript:;" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:180px;-webkit-text-size-adjust:none;">'.$otp.'</a>';

$message .="<br><br><b>Note: </b>If you didn't mean to reset your password. Then you can just ignore this email; your password will not change.<br><br></div> 
 ";
$message .='<div style="text-align:left; font-size:13px;" class="mobile-center body-padding w320"><br><b>Please Note : </b>Never share your Email-Id, OTP, Password or Pin with anyone, even if person claims to be a wallet employee. Sharing these details can lead to unauthorised access to your account.<br><br><br></div>
 <div style="text-align:left; font-size:13px;" class="mobile-center body-padding w320"><br>If you have any questions regarding <b>'.project_name().'</b>. please read our FAQ or use our support form wallet email address. Our support staff will be more than happy to assist you.<br><br><br></div>
<div style="margin-bottom:20px;">
<br>
<b>With Best of Regards</b>,<br>
<b>Team '.project_name().'</b> <br>

</div></div>';
$message .='<div style="background:#1a1a1a; padding:10px; width:100%; color:#fff; box-sizing: border-box; text-align:center;">
<div style="font-size:18px; font-weight:bold; margin-bottom:5px;"><b>'.project_name().'</b></div>
<div style="margin-bottom:10px;">'.base_url().'</div></div>';




            $config['protocol']    = 'smtp';
            $config['smtp_host']    = 'ssl://smtp.zoho.com';
            $config['smtp_port']    = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user']    = sending_mail();
            $config['smtp_pass']    = sending_mail_pass();
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'text'; 
            $config['validation'] = TRUE;

            $this->load->library('email',$config);

            $this->email->from(sending_mail(),project_name());
            $this->email->to($tomail); 

            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
            $this->email->set_header('Content-type', 'text/html');

	
            if($this->email->send())
            {
                return true;
            }else{
                return false;
            }
        } 

}


?>
