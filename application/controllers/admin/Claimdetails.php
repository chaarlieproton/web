<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';

class Claimdetails extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session','Rpc');
		$this->load->helper('utility_helper');
		$this->load->model('Home_model');
    $this->load->model('Auth_model');

		$this->from="";
        if($this->session->userdata('user_id')==false || $this->session->userdata('is_Admin_in')==false )
        {
            redirect(base_url().'/logout');
        }
	}
	
	public function index()
	{
	$sql="select * from claimBitcandy order by serial_no desc limit 1";
	$query['listing']=$this->db->query($sql)->result();
        $this->load->view('adminpanel/claimdetails',$query); 
       
    }
    public function details($value)
    {
    	$sql="select * from claimBitcandy where serial_no='$value' order by serial_no desc limit 1";
	$query['listing']=$this->db->query($sql)->result();
        $this->load->view('adminpanel/claimdetails',$query);
    }
    public function sendRecords()
    {
    	$query=$this->db->query('select * from currency_list')->result();
    	 $rpc_host=$query[0]->host;
    	 $rpc_port=$query[0]->port;
    	 $rpc_user=$query[0]->user;
    	 $rpc_pass=$query[0]->pass;

        $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
		$post = $this->input->post();
	
		 	//die();
		 foreach ($post['claimData'] as  $value) {
		 	$a=explode("^",$value);
		 	$user=$a[0];
		 	$amt=$a[1];
		 	$data=$this->getmove($this->from, $user, $amt);
		 	if($data)
		 	{
		 		$this->verifymail($name,$user,$userid);
		 	}
		 	redirect(base_url().'','refresh');	 		
		 }	
    }

 	public function verifymail($name,$toemail,$userid)
				{

						$subject='Confirm Claim CDY';

					 $message='<div style="width:500px; margin:auto; font-family:Helvetica,Arial; font-size:13px; color:#333; line-height:18px; background:#fafafa; border:#F1F0F0 solid 1px; padding:10px 10px 0 10px;">

		<div style="margin-bottom:35px;background:#fafafa; text-align:center;"><img src="'.favicon_url().'" style="height:70px;" /></div>
		<div class="mobile-br"  style="font-size:30px; font-weight: 600; color: #2f982e; text-align:center;">&nbsp; Welcome to <b>'.project_name().'</b> <br><br> </div>
		 <div style="font-size:24px; text-align:center;"> <br>Congratulations!!!<br><br> </div>
		<div style="margin-bottom:20px;">Dear '.ucfirst(strtolower($name)).',</div>
		<div style="margin-bottom:10px;">Thank you for registering at <b>'.project_name().'</b> !  <br><br>
		You have successfully gone through the process of registration at <b>'.project_name().'</b>. Now You can start to receive and send from your wallet account in seconds. <br><br></div>
		 <div>
		 <a href="'.base_url().'signup/activateaccount?em='.base64_encode($toemail).'&uid='.base64_encode($userid).'" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:180px;-webkit-text-size-adjust:none; text-align="center" target="_blank">Activate Account</a><br><br>
												 </div>';

		$message .='
		 <div style="text-align:left; font-size:13px;" class="mobile-center body-padding w320"><br>If you have any questions regarding <b>'.project_name().'</b> please read our FAQ or use our support form wallet email address. Our support staff will be more than happy to assist you.<br><br><br></div>
		<div style="margin-bottom:20px;">
		<br>
		<b>With Best of Regards</b>,<br>
		<b>Team '.project_name().'</b> <br>
		</div>
		<div style="background:#1a1a1a; padding:10px; width:100%; color:#fff; box-sizing: border-box; text-align:center;">
		<div style="font-size:18px; font-weight:bold; margin-bottom:5px;"><b>'.project_name().'</b></div>
		<div style="margin-bottom:10px;"><b>'.base_url().'</b></div>

		</div></div>';

						$config['protocol']    = 'smtp';
						$config['smtp_host']    = 'ssl://smtp.gmail.com';
						$config['smtp_port']    = '465';
						$config['smtp_timeout'] = '7';
						$config['smtp_user']    = sending_mail();
						$config['smtp_pass']    = sending_mail_pass();
						$config['charset']    = 'utf-8';
						$config['newline']    = "\r\n";
						$config['mailtype'] = 'text';
						$config['validation'] = TRUE;

						$this->load->library('email',$config);

						$this->email->from(sending_mail(), project_name());
						$this->email->to($toemail);

						$this->email->subject($subject);
						$this->email->message($message);
						$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
						$this->email->set_header('Content-type', 'text/html');
						$this->email->send();
				}

    

}


?>
