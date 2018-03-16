<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Changepin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');

        
	}
	
	

    public function updatepin()
    {

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	header("Content-Type: text/html;charset=UTF-8");  
	$json = file_get_contents('php://input');
	$data=json_decode($json);
	
	$email=$data->userMailId;
    	$old_password=$data->currentPassword;
    	$new_pin=$data->newPin;
    	$confirm_pin=$data->confirmNewPin;
    	
    	if($new_pin==$confirm_pin)
    	{
            if($this->Auth_model->chkpasswordbyemailapi($email,$old_password)==1)
            {
            	if($this->Auth_model->updatepinpasswordapi($email,$old_password,$new_pin))
                    {
			$array=array(
				"statusCode"=>200,
				"message"=>"Your pin has been changed successfully."
				);
                    }
                    else
                    {
			$array=array(
				"statusCode"=>400,
				"message"=>"Error occurred while change pin !!!"
				);
                       
                    }
            }else{
			$array=array(
				"statusCode"=>400,
				"message"=>"Please enter valid old pin !!!"
				);
           
            }
        }else{
		$array=array(
				"statusCode"=>400,
				"message"=>"Pin not matched !!!"
				);
        	
        }
	print_r(json_encode($array));
    }
    

}


?>
