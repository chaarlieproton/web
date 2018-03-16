<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('utility_helper');
		$this->load->library('Rpc');
		$this->load->model('Auth_model');
		$this->load->helper('utility_helper');
		

	}	
    

   
     public function authentcate()
     {
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
     header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
     header("Content-Type: text/html;charset=UTF-8"); 
      $json = file_get_contents('php://input');
        $data=json_decode($json);

            $name = $data->email;
            $password = $data->password;
            $ip=$_SERVER['REMOTE_ADDR'];
	  if($this->Auth_model->mailverifychk($name)) 
	  {

	      if($this->Auth_model->auth($name, $password, $ip))
	      {
			$data=$this->Auth_model->chkmailvalid($name);
			$currency_detail=$this->Auth_model->currencylist();
			
			foreach($currency_detail as $detail)
			{
			 
			 $rpc_host=$detail->host;
			 $rpc_user=$detail->user;
			 $rpc_pass=$detail->pass;
			 $rpc_port=$detail->port;
			 $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
		         $bal[$detail->short_name]=$client->getAddress($data[0]->email);
			}

			        if($data[0]->email_verify_status==1)
			        {
			           
			         $array=array(
			         	"statusCode"=>200, 
						"message" => "User created Successfully.",
						"user"=> array(
						"id"=>$data[0]->id,
						"email"=>$data[0]->email,
						"name"=>$data[0]->name,
						"ip_address"=>$data[0]->ip_address,
						"tfa_status"=>$data[0]->tfa_status,
						"tfa_key"=>$data[0]->tfa_key,
						"verifyEmail"=>$data[0]->email_verify_status,
						"status"=>$data[0]->status,
						"kyc_status"=>$data[0]->kyc_status,
						"created_date"=>$data[0]->created_date,
						"last_login"=>$data[0]->last_login,
						"BTCAddress"=>$bal['BTC'],
						"VCNAddress"=>$bal['VCN']
						)
					);
				
			        }
		    }
		    else
		    {
			$array=array('statusCode'=>400, "message" => "Please enter correct email and password.");
			
		    }
	}

	else
	{
		$array=array('statusCode'=>400, "message" => "Please enter valid email And password code!!!.");
		
	}
		
 echo $myJSON = json_encode($array);

     }

}

