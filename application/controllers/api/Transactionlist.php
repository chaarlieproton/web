<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';

class Transactionlist extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Rpc');
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');

        }
	
	
   public function transactionlist()
    {

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	header("Content-Type: text/html;charset=UTF-8");  
	$json = file_get_contents('php://input');
	$data=json_decode($json);
	
	$curr=$data->currency;
	$email=$data->userMailId;
    	if($curr!='')
    	{
    		
         $chkcurr=$this->Auth_model->getcurrencydetailbyshortname($curr);
    		
    			
      $rpc_host=$chkcurr[0]->host;
      $rpc_user=$chkcurr[0]->user;
      $rpc_pass=$chkcurr[0]->pass;
      $rpc_port=$chkcurr[0]->port;

      $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
      $detail=$client->getTransactionList($email);
	$i=0;
	$count=count($detail);
	if($count>0)
		{
		foreach($detail as $transaction)
			{
			      $deta[$i]=array(
						"date"=>date('d-M-Y h:i a',$transaction['time']),
						"address"=>$transaction['address'],
						"category"=>$transaction['category'],
						"amount"=>number_format($transaction['amount'],8),
						"confirmations"=>$transaction['confirmations'],
						"txid"=>$transaction['txid']
				
				);
		
			$i++;}
				$array=array(
					"statusCode"=>200,
					"message"=>"Data found",	
					"tx"=>$deta	
					);
		}else{
			$array=array(
					"statusCode"=>400,
					"message"=>"No data available in table"	
					);
		}

       print_r(json_encode($array));
       }
    }


   
}


?>
