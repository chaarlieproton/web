<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');



include_once APPPATH.'third_party/jsonRPCClient.php';
include_once APPPATH.'third_party/Client.php';


class Sendamount extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session','Rpc');
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
	$currnecy_detail=$this->Auth_model->currencylist();

	$rpc_host=$currnecy_detail[0]->host;
        $rpc_user=$currnecy_detail[0]->user;
        $rpc_pass=$currnecy_detail[0]->pass;
        $rpc_port=$currnecy_detail[0]->port;

        $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
       

       

        $data['user_bal']=$client->getadminbal();
	$this->load->view('adminpanel/sendamount',$data); 
    }

    public function transferamount()
    {


        if($this->input->post('amount')>0)
        {
    	$currnecy_detail=$this->Auth_model->currencylist();

	$rpc_host=$currnecy_detail[0]->host;
        $rpc_user=$currnecy_detail[0]->user;
        $rpc_pass=$currnecy_detail[0]->pass;
        $rpc_port=$currnecy_detail[0]->port;

        $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);

//    	$pin=$this->input->post('pin');
    	$email=$this->session->userdata['email'];

        ///  check pin 
    	//if($this->Auth_model->chkpinpass($pin))
    	//{
    		$user_bal=$client->getadminbal();
	    	$amount=$this->input->post('amount');

            /////   check balance 
	    	if($user_bal>$amount)
	    	{
                /////   get fee
                $fee=$this->Auth_model->chksendfee($amount);

                $current_bal=$user_bal-$fee[0]->charge;
                //  chk balance after deduct fee
                if($current_bal>=$amount)
                {

    	    		$receive_address=$this->input->post('receive_address');

    	    		if($client->withdraw($email, $receive_address, $amount))
    	    		{
                        $this->session->set_flashdata('success',"Your amount has been successfully sent.");
                        redirect('admin/sendamount');
    	    		}else{
    	    			$this->session->set_flashdata('error', "Error occured while sending amount!!!");
                        redirect('admin/sendamount');
    	    		}
                }else{
                    $this->session->set_flashdata('error', "you don't have sufficient balance!!!");
                    redirect('admin/sendamount');
                }

	    	}else{
	    		$this->session->set_flashdata('error', "you don't have sufficient balance!!!");
            	redirect('admin/sendamount');
	    	}

    	//}else{
    	//	$this->session->set_flashdata('error', 'Please enter correct pin!!!');
          //  redirect('sendamount');
    	//}

    }else{
        $this->session->set_flashdata('error', 'Please enter valid amount!!!');
            redirect('admin/sendamount');
    }

    	

    }
}
?>
