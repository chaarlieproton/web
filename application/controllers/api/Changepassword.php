<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Changepassword extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');
	}
	
	
    public function updatepass()
    {


        header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	header("Content-Type: text/html;charset=UTF-8");  
	$json = file_get_contents('php://input');
	$data=json_decode($json);
	
	$email=$data->userMailId;
    	$old_password=$data->currentPassword;
    	$new_password=$data->newPassword;
    	$confirm_password=$data->confirmNewPassword;
    	

    	if($new_password==$confirm_password)
    	{

            if($this->Auth_model->chkpasswordbyemailapi($email,$old_password)==1)
            {
            	if($this->Auth_model->updatepasswordapi($email,$old_password,$new_password))
                    {
			$array=array(
				"statusCode"=>200,
				"message"=>"Your password has been changed successfully."
				);
                    	
                    }
                    else
                    {
			$array=array(
				"statusCode"=>400,
				"message"=>"Error occurred while change password !!!"
				);
                       
                    }
            }else{
			$array=array(
				"statusCode"=>400,
				"message"=>"Please enter valid old password !!!"
				);
           
            }
        }else{
		$array=array(
				"statusCode"=>400,
				"message"=>"New Password and Confirm Password must be same !!!"
				);
        	
        }
	print_r(json_encode($array));
    }
    

}


?>
