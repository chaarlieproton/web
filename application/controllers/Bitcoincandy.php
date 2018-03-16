<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Bitcoincandy extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('utility_helper');
		$this->load->helper(array('file','url','form'));
		$this->load->model('Auth_model');
        $this->load->helper('form');
        $this->load->library('upload');
        $this->load->database();
		if($this->session->userdata('user_id')==false)
		{
		    redirect(base_url().'/logout');
		}
	}
	public function index()
	{
	$this->load->view('claimcandy');
        }
  
	public function claimSave()
	{
		if($_FILES['userfile']['name'])
		{

			 if(file_exists($_FILES['userfile']['tmp_name']) || is_uploaded_file($_FILES['userfile']['tmp_name']))
		{	
			$name=str_replace(" ","_",$this->session->userdata('name'));
	$randString = $name.rand(99,9999); //encode the timestamp - returns a 32 chars long string
  $fileName = $_FILES["userfile"]["name"]; //the original file name
  $splitName = explode(".", $fileName); //split the file name by the dot
  $fileExt = end($splitName); //get the file extension
  $newFileName  = strtolower($randString.'.'.$fileExt); //join file name and ext.
   move_uploaded_file( $_FILES['userfile']['tmp_name'],"uploads/".$newFileName);
    $image = "uploads/".$newFileName;
  
    
		}
	 //    $config['upload_path'] = base_url().'uploads/'; 
		// $config['allowed_types'] = 'gif|jpg|png'; 
		// $config['max_size'] = 100; 
		// $config['max_width'] = 1024; 
		// $config['max_height'] = 768; 
		// //print_r($config); die();
		// $this->upload->initialize($config);
		// $this->load->library('upload', $config);
		
		
		if ($image) 
		{
			$data = $this->upload->data('userfile');
			$data=array(
			"bch_address" =>$this->input->post('bch_address'),
			"amount_of_bch" =>$this->input->post('amount_of_bch'),
			"user_id" =>$this->session->userdata('email'),
			"upload_image" =>$image,
			);
		
		    if($this->db->insert('claimBitcandy',$data))
		    {
		    	$this->claimmail();
		    }
			//$msg['msg']="Thanks for sending BTC review";
			 $this->session->set_flashdata('success', 'Your request has been successfully submited.');
		   redirect(base_url().'bitcoincandy');
			 
		}
		else
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			//$error = array('msg' => $this->upload->display_errors());
		}
	}
	else{
		echo 'error';
	}
		
		
	}


	 public function claimmail()
        {
        	$tomail=$this->session->userdata('email');
        	$name=$this->session->userdata('name');
            $subject='Claim Free CDY';

           $message='<div style="width:500px; margin:auto; font-family:Helvetica,Arial; font-size:13px; color:#333; line-height:18px; background:#fafafa; border:#F1F0F0 solid 1px; padding:10px 10px 0 10px;">
 
<div style="margin-bottom:35px;background:#fafafa; text-align:center;"><img src="'.logo_url().'" style="width:200px" /></div>
<div class="mobile-br"  style="font-size:30px; font-weight: 600; color: #2f982e; text-align:center;">&nbsp; Welcome to <b>'.project_name().'</b> <br><br> </div>
 <div style="font-size:24px; text-align:center;"> <br>Claim Free CDY !!!<br><br> </div>
<div style="margin-bottom:20px;">Dear '.$name.',</div>
<div style="margin-bottom:10px;">Your request has been successfully submited. You  will receive your bitcoin candy after review your request. ';

$message .='
 <div style="text-align:left; font-size:13px;" class="mobile-center body-padding w320"><br>If you have any questions regarding claim <b>'.project_name().'</b>. please read our FAQ or use our support form wallet email address. Our support staff will be more than happy to assist you.<br><br><br></div>
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
