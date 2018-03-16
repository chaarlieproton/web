<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');



include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';


class Exchange extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Rpc');
		$this->load->helper('utility_helper');
		$this->load->model('Auth_model');
        	$this->load->helper('form');
		if($this->session->userdata('email')==false)
		{
		    redirect(base_url().'logout');
		}
	}
	
	public function index()
	{
	$json_url = "https://cex.io/api/ticker/BCH/BTC";
	$data['askdata']=$this->curlfunction($json_url);
	$currnecy_detail=$this->Auth_model->currencylist();

	$rpc_host=$currnecy_detail[0]->host;
	$rpc_user=$currnecy_detail[0]->user;
	$rpc_pass=$currnecy_detail[0]->pass;
	$rpc_port=$currnecy_detail[0]->port;

        $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
        $data['user_bal']=$client->getBalance($this->session->userdata['email']);
	$this->load->view('exchange',$data); 
    }

    public function changeamt()
    {


	$currnecy_detail=$this->Auth_model->currencylist();

	$rpc_host=$currnecy_detail[0]->host;
	$rpc_user=$currnecy_detail[0]->user;
	$rpc_pass=$currnecy_detail[0]->pass;
	$rpc_port=$currnecy_detail[0]->port;

        $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);

    	$email=$this->session->userdata['email'];
    	$amount=$this->input->post('amount');
    	$pin=$this->input->post('pin');

    	///  currennt rate////////
    	$json_url = "https://cex.io/api/ticker/BTC/USD";
	$askdata=$this->curlfunction($json_url);

	$coin_amount = $amount *$askdata;

        //************UNCOMMENT THIS ONE***********
        $reciever_address = "TPhb9J2XKSjzKJfqdvwTy6hW9skmbg6zzb";
        //************company's btc address********
        $reciever_address_btc = "1J3MgWKP48rveV9fn4YfhJfhCWGpstvcyr";



    	if($amount>0)
    	{

    		if($this->Auth_model->chkpinbyemail($pin)==1)
            {
            	$user_bal=$client->getBalance($email);
	

            	if($user_bal>$amount)
            	{
            		 /////   get fee
	                //$fee=$this->Auth_model->chksendfee($amount);
			$fee=$amount*0.1/100;
                        //$current_bal=$user_bal-$fee[0]->charge;
			 $current_bal=$user_bal-$fee;
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
				$getaddress=$client_btc->getNewAddress($this->session->userdata['email']);
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
	                		$this->session->set_flashdata('success', "Your amount sent successfully.");
		            	     redirect('exchange');
	                	}else{
	                		$this->session->set_flashdata('error', "Error occurred while exchange amount!!!");
		            	     redirect('exchange');
	                	}
	                }else{

		            $this->session->set_flashdata('error', "you don't have sufficient balance!!!");
		            redirect('exchange');
		            }

            	}else{

		            $this->session->set_flashdata('error', "you don't have sufficient balance!!!");
		            redirect('exchange');
		            }

            }else{

            $this->session->set_flashdata('error', 'Please enter valid pin !!!');
            redirect('exchange');
            }
    	}else{
    		$this->session->set_flashdata('error', 'Please enter valid amount!!!');
            redirect('exchange');
    	}
    }


    function curlfunction($url)
    {
    	
         $response = file_get_contents($url);
          $response=json_decode($response);

          return $respons=$response->ask;
    	
    }

   
}
?>
