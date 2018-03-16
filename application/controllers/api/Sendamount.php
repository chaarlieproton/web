<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');



include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';


class Sendamount extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Rpc');
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');
       
        
	}
	
	

    public function transferamount()
    {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	header("Content-Type: text/html;charset=UTF-8");  
	$json = file_get_contents('php://input');
	$data=json_decode($json);

	$amount=$data->amount;
	$pin=$data->spendingPassword;
    	$email=$data->userMailId;
	$currency=$data->currency;
	if($amount>0)
        {
	
        
	$rpcdetail=$this->Auth_model->getcurrencydetailbyshortname($currency);
	$rpc_host=$rpcdetail[0]->host;
        $rpc_user=$rpcdetail[0]->user;
        $rpc_pass=$rpcdetail[0]->pass;
        $rpc_port=$rpcdetail[0]->port;

        $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	
    	
	 ///  check pin 
    	if($this->Auth_model->chkemailpinpass($email,$pin))
    	{
    		$user_bal=$client->getBalance($email);
	    	$amount=$data->amount;

            /////   check balance 
	    	if($user_bal>$amount)
	    	{
                /////   get fee
               // $fee=$this->Auth_model->chksendfee($amount);

               // $current_bal=$user_bal-$fee[0]->charge;
               $current_bal=$user_bal-$amount*0.1/100;
                //  chk balance after deduct fee
                if($current_bal>=$amount)
                {

    	    		$receive_address=$data->recieverCoinAddress;

    	    		if($client->withdraw($email, $receive_address, $amount))
    	    		{
			$array=array(
				"statusCode"=>200,
				"message"=>"Your amount has been successfully sent."
				);
                        
    	    		}else{
				$array=array(
					"statusCode"=>400,
					"message"=>"Error occured while sending amount!!!"
					);
    	    		
    	    		}
                }else{
			$array=array(
				"statusCode"=>400,
				"message"=>"you don't have sufficient balance!!!"
				);
                    
                }

	    	}else{
			$array=array(
				"statusCode"=>400,
				"message"=>"you don't have sufficient balance!!!"
				);
	    		
	    	}

    	}else{
		$array=array(
			"statusCode"=>400,
			"message"=>"Please enter correct pin!!!"
			);
    		
    	}

    }else{
		$array=array(
			"statusCode"=>400,
			"message"=>"Please enter valid amount!!!"
			);
       
    }
	print_r(json_encode($array));
    }


}
?>
