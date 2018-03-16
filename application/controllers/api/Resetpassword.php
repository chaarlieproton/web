<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Resetpassword extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');
	}
	
	

    public function resetpass()
    {
	header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	header("Content-Type: text/html;charset=UTF-8"); 
        $json = file_get_contents('php://input');
        $data=json_decode($json);

        $otp=$data->otp;
        $newpassword=$data->newPassword;
        $confirmpassword=$data->confirmNewPassword;

        if($newpassword==$confirmpassword)
        {
            if($this->Auth_model->chkotpisvalid($otp))
            {
                if($this->Auth_model->updateforgetpassword($newpassword,$otp))
                {
                    $this->Auth_model->resetpassblank($otp);

		    $array=array(
			        "statusCode"=>200, 
				"message" => "Your password has been updated successfully."
                             );
                    //$this->session->set_flashdata('success', 'Your password has been updated successfully.');
                    //redirect(base_url());
                }else{
		   $array=array(
			        "statusCode"=>400, 
				"message" => "Error occurred while updated your password!!!"
                             );
                    //$this->session->set_flashdata('error', 'Error occurred while updated your password!!!');
                    //redirect('resetpassword');
                }
            }else{
		$array=array(
			        "statusCode"=>400, 
				"message" => "Please enter valid OTP!!!"
                             );
                //$this->session->set_flashdata('error', 'Please enter valid OTP!!!');
                //redirect('resetpassword');
            }
        }else{
            $array=array(
			        "statusCode"=>400, 
				"message" => "New Password and Confirm Password must be same !!!"
                             );
            //$this->session->set_flashdata('error', 'New Password and Confirm Password must be same !!!');
            //redirect('resetpassword');
        }
	echo $myJSON = json_encode($array);
        
    }


}


?>
