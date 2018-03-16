<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');



include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';


class Mobileexchange extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Rpc');
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');
        	$this->load->helper('form');
		
	}
	
	

     public function changeamt()
    {

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	header("Content-Type: text/html;charset=UTF-8");  
	$json = file_get_contents('php://input');

	$data=json_decode($json);

	$email=$data->userMailId;
	$amount=$data->amount;
	$pin=$data->spendingPassword;

	if($email && $amount)
	{
	$currnecy_detail=$this->Auth_model->currencylist();

	$rpc_host=$currnecy_detail[0]->host;
	$rpc_user=$currnecy_detail[0]->user;
	$rpc_pass=$currnecy_detail[0]->pass;
	$rpc_port=$currnecy_detail[0]->port;

        $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);

    	//$email=$this->input->post('email');
    	//$amount=$this->input->post('amount');
    	//$pin=$this->input->post('pin');

    	///  currennt rate////////
    	$json_url = "https://cex.io/api/ticker/BTC/USD";
	$askdata=$this->curlfunction($json_url);

	$coin_amount = $amount *$askdata;

        //************UNCOMMENT THIS ONE***********
        $reciever_address = "TPhb9J2XKSjzKJfqdvwTy6hW9skmbg6zzb";
        //************company's btc address********
        $reciever_address_btc = "1AKLhW6Yk8FfF3jvv3AzawYZcD1Dyg1KVh";



    	if($amount>0)
    	{

    		if($this->Auth_model->chkemailpinpass($email,$pin)==1)
            {
            	$user_bal=$client->getBalance($email);
	

            	if($user_bal>$amount)
            	{
            		 /////   get fee
	                $fee=$this->Auth_model->chksendfee($amount);
                        //$current_bal=$user_bal-$fee[0]->charge;
			$current_bal=$user_bal-$fee*0.1/100;
	                //$current_bal=$user_bal-0;
	                //  chk balance after deduct fee
	                if($current_bal>=$amount)
	                {

			// RPC VCN
				$currnecy_detail=$this->Auth_model->currencylist();

				$rpc_host=$currnecy_detail[1]->host;
				$rpc_user=$currnecy_detail[1]->user;
				$rpc_pass=$currnecy_detail[1]->pass;
				$rpc_port=$currnecy_detail[1]->port;

				$client_btc= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
				$getaddress=$client_btc->getNewAddress($email);
				$withdraw_message = $client_btc->withdraw('visioncoin017@gmail.com', $getaddress, (float)$coin_amount);
			///  BTC RPC
				$currnecy_detail=$this->Auth_model->currencylist();
				$rpc_host=$currnecy_detail[0]->host;
				$rpc_user=$currnecy_detail[0]->user;
				$rpc_pass=$currnecy_detail[0]->pass;
				$rpc_port=$currnecy_detail[0]->port;
				$client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
				$withdraw_message = $client->withdraw($email, $reciever_address_btc, (float)$amount);
				
	                	if($withdraw_message)
	                	{
	                		
					$data=array(
					'status'=>200,
					'message'=>"Your amount changed successfully.",
					);
	                	}else{
	                		
					$data=array(
					'status'=>401,
					'message'=>"Error occurred while exchange amount!!!",
					);
	                	}
	                }else{

		          
				$data=array(
					'status'=>401,
					'message'=>"you don't have sufficient BTC balance!!!",
					);
		            }

            	}else{

				$data=array(
					'status'=>401,
					'message'=>"you don't have sufficient BTC balance!!!",
					);
		            }

            }else{
			$data=array(
		'status'=>401,
		'message'=>'Please enter valid pin !!!',
		);
           
            }
    	}else{
    		$data=array(
		'status'=>401,
		'message'=>'Please enter valid amount',
		);
    	}
}else{
$data=array(
		'status'=>401,
		'message'=>'Please enter valid detail',
		);
}

echo json_encode($data);
    }


    function curlfunction($url)
    {
    	
         $response = file_get_contents($url);
          $response=json_decode($response);

          return $respons=$response->ask;
    	
    }

   
}
