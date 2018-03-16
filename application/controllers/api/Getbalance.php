<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';

class Getbalance extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('utility_helper');
		$this->load->library('Rpc');
		$this->load->model('Auth_model');
		$this->load->helper('utility_helper');

	}	
    


    function getbal()
    {
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
     header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
     header("Content-Type: text/html;charset=UTF-8");  
     $json = file_get_contents('php://input');
     $data=json_decode($json);
	if($data->userMailId!='')
	{
		
		$email=$data->userMailId;
		$currency_detail=$this->Auth_model->currencylist();
		foreach($currency_detail as $detail)
		{
		 $rpc_host=$detail->host;
		 $rpc_user=$detail->user;
		 $rpc_pass=$detail->pass;
		 $rpc_port=$detail->port;
		 $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
                 $bal[$detail->short_name]=$client->getBalance($email);
		}
		$array=array(
				"statusCode"=>200,
				"BTCBalance"=>$bal['BTC'],
				"VCNBalance"=>$bal['VCN']	
				
			);
		//echo json_decode($bal);
                print_r(json_encode($array));
	}
	
    }

     function currentvcnrate()
    {
   
	header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        header("Content-Type: text/html;charset=UTF-8");  
        $detail=file_get_contents("https://cex.io/api/ticker/BTC/USD");
        $data=json_decode($detail);
        $vcn_rate=$data->ask;
        $vcn = 1/$vcn_rate;
        $rate=number_format($vcn,8);
	$array=array(
		"statusCode"=>200,
		"currentBTCprice"=>$rate
		);
	print_r(json_encode($array));
    }

    function askamt()
    {
	header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        header("Content-Type: text/html;charset=UTF-8");  
        //$json = file_get_contents('php://input');
       // $data=json_decode($json);
	
        //$amount=$data->currenntrate;

        $detail=file_get_contents("https://cex.io/api/ticker/BTC/USD");
        $dataapi=json_decode($detail);
        //$vcn=$dataapi->ask*$amount;

	$array=array(
				"statusCode"=>200,
				"askRate"=>number_format($dataapi->ask,8)
				
			);

        print_r(json_encode($array));
    }
}
