<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
        $this->load->helper('url');
 	}


		 	function mailindb($name)
		 	 {

		 			 $this->db->where('email',$name);
		 			// $this->db->where('password',$password1);
		 			// $this->db->where('status',1);
		 			 $this->db->where('email_verify_status',0);
		 			 $query = $this->db->get('users');
		 			 if($query->num_rows()==1)
		 			 {
		          return true;
		 			 }
		 else{
		 	return false ;
		 }
		 		 }



 	function auth($name,$password,$ip)
    {
		$currnecy_detail = array();
        $password1 = sha1($password);
        $this->db->where('email',$name);
        $this->db->where('password',$password1);
        $this->db->where('status',1);
        $this->db->where('email_verify_status',1);
        $query = $this->db->get('users');
        if($query->num_rows()==1)
        {
            
            
            foreach ($query->result() as $row)
            {
                $data = array(
                    'email'                 =>   $row->email,
                    'name'                  =>   $row->name,
                    'tfa_status'            =>   $row->tfa_status,
                    'tfa_key'               =>   $row->tfa_key,
                    'kyc_status'            =>   $row->kyc_status,
                    'user_id'               =>   $row->id,
                    'tfa_key'               =>   $row->tfa_key,
                    'ip_address'            =>   $ip,
				//	'currency'              =>   $currnecy_detail[0]->id,
                 //   'currencyname'          =>   $currnecy_detail[0]->short_name,
                  //  'rpc_host'              =>   $currnecy_detail[0]->host,
                   // 'rpc_user'              =>   $currnecy_detail[0]->user,
                   // 'rpc_pass'              =>   $currnecy_detail[0]->pass,
                   // 'rpc_port'              =>   $currnecy_detail[0]->port,
                    'logged_in'             =>   TRUE,
                );
            }
			$userid = $data['user_id'];
			
			if($userid >  RPC_CUT_OFF_VALUE)
			{
				$currnecy_detail=$this->currencylist(2);
			}
			else
			{
				$currnecy_detail=$this->currencylist(1);
			}
			if(count($currnecy_detail)>0)
			{
				$data['currency']              =   $currnecy_detail[0]->id,
				$data['currencyname']          =   $currnecy_detail[0]->short_name,
				$data['rpc_host']              =   $currnecy_detail[0]->host,
				$data['rpc_user']              =   $currnecy_detail[0]->user,
				$data['rpc_pass']              =   $currnecy_detail[0]->pass,
				$data['rpc_port']              =   $currnecy_detail[0]->port,
			}
			
            $this->insertlogindetail($data['user_id'],$ip);
            $this->updatelogindetail($data['user_id']);


            if(($name==$data['email'])) {
            $this->session->set_userdata($data);
            return TRUE;
            } else {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
        
    }


    function signup($name,$email,$password,$pin,$secret,$rpc_detail)
    {
    	$data = array( 
				'name'	      =>  $name, 
				'email'       =>  $email,
				'password'    =>  sha1($password),
				'ip_address'  =>  $_SERVER['REMOTE_ADDR'],
				'pin'         =>  sha1($pin),
                		'tfa_key'     =>  $secret,
                		'rpc_id'      =>  $rpc_detail
			);
    	$this->db->insert('users', $data);
    	$userid=$this->db->insert_id();
    	return $userid;
    }

	 function signupfront($name,$email,$password,$pin,$secret)
    {
    	$data = array( 
				'name'	      =>  $name, 
				'email'       =>  $email,
				'password'    =>  sha1($password),
				'ip_address'  =>  $_SERVER['REMOTE_ADDR'],
				'pin'         =>  sha1($pin),
                		'tfa_key'     =>  $secret
			);
    	$this->db->insert('users', $data);
    	$userid=$this->db->insert_id();
    	return $userid;
    }

    function insertlogindetail($user_id,$ip)
    {
    	
    	$data = array( 
				'user_id'	      =>  $user_id, 
				'ip_address'      =>  $ip 
			);

		$this->db->insert('login_detail', $data);
    }

    function updatelogindetail($user_id)
    {
        $data = array( 
                'last_login' =>  date("Y-m-d H:i:s")
            );
        $this->db->where('id',$user_id);
        $query=$this->db->update('users', $data);
        return $query;

    }

    function updatepassword($old_password,$new_password)
    {
        $user_id=$this->session->userdata['user_id'];
        $data = array('password' => sha1($new_password));

        $this->db->where('id',$user_id);
        $this->db->where('password',sha1($old_password));

        $userid=$this->db->update('users', $data);
        return $userid;
    }



    function updatepinpassword($old_pin,$new_pin)
    {
        $user_id=$this->session->userdata['user_id'];
        $data = array('pin' => sha1($new_pin));

        $this->db->where('id',$user_id);
        $this->db->where('pin',sha1($old_pin));

        $userid=$this->db->update('users', $data);
        return $userid;
    }
/*
    function currencylist()
    {
        $this->db->select("*");
        $this->db->from("currency_list");
        $this->db->where("status",'1');
	$q = $this->db->get();
        $row = $q->result();

        return $row;
    }
*/
	
    function currencylist($sel_value)
    {
        $this->db->select("*");
        $this->db->from("currency_list");
        $this->db->where("status",'1');
        $this->db->where("sel_val",$sel_value);
	$q = $this->db->get();
        $row = $q->result();

        return $row;
    }
	
    function savenewaddress($address)
    {
        $user_id=$this->session->userdata['user_id'];
        $curr_id=$this->session->userdata['currency'];
        $data = array( 
                'user_id'         =>  $user_id, 
                'curr_id'         =>  $curr_id,
                'curr_address'    =>  $address 
            );

        $data=$this->db->insert('balance', $data);
        return $data;
    }

    function getalladdresslistByCurrency()
    {
        $user_id=$this->session->userdata['user_id'];
        $curr_id=$this->session->userdata['currency'];

        $this->db->select("*");
        $this->db->from("balance");
        $this->db->where("user_id",$user_id);
        $this->db->where("curr_id",$curr_id);
        $this->db->order_by("id", "desc");
        $q = $this->db->get();
        $row = $q->result();

        return $row;
    }

    function chkpinpass($pin)
    {
        $user_id=$this->session->userdata['user_id'];
        $this->db->select('*');
        $this->db->from("users");
        $this->db->where("pin",sha1($pin));
        $this->db->where("id",$user_id);
        $query = $this->db->get();
        $q=$query->num_rows();
        return $q;
    }

    function fee_amount($amount)
    {
        $this->db->select("*");
        $this->db->from("fee_charges");
        $this->db->where("user_id",$user_id);
        $this->db->where("curr_id",$curr_id);
        $q = $this->db->get();
        $row = $q->result();
    }

    function chkgetcurrencylist($curr)
    {
        $this->db->select("*");
        $this->db->from("currency_list");
        $this->db->where("status",'1');
        $this->db->where("id",$curr);
        $query = $this->db->get();
        $q=$query->result();
        return $q;
    }

    function chksendfee($amt)
    {
        $this->db->select("charge");
        $this->db->from("fee_charges");
        $this->db->where("min_amt <=",$amt);
        $this->db->where("max_amt >=",$amt);
        $query = $this->db->get();

        $q=$query->result();
        return $q;
    }

    function updateauthstatus($status)
    {
        $user_id=$this->session->userdata['user_id'];
        $email=$this->session->userdata['email'];
        $data = array('tfa_status' => $status);

        $this->db->where('id',$user_id);
        $this->db->where('email',$email);

        $userid=$this->db->update('users', $data);
        return $userid;
    }

    function activateaccount($email,$uid)
    {
        $user_id=$uid;
        $email=$email;
        $data = array('email_verify_status' => '1','status' => '1');

        $this->db->where('id',$user_id);
        $this->db->where('email',$email);

        $userid=$this->db->update('users', $data);
        return $userid;
    }

    function chkmailvalid($tomail)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("email",$tomail);
        $query = $this->db->get();

        $q=$query->result();
        return $q;
    }

    function updateforgetpassword($password,$otp)
    {
        
        $data = array('password' => sha1($password));

        $this->db->where('otp',sha1($otp));

        $userid=$this->db->update('users', $data);
        return $userid;
    }

	function chkpasswordbyemail($password)
    {
        $name=$this->session->userdata('email');
        $password1 = sha1($password);
        $this->db->where('email',$name);
        $this->db->where('password',$password1);
        $this->db->where('status',1);
        $this->db->where('email_verify_status',1);
        $query = $this->db->get('users');
        return $query->num_rows();
    }



    function chkpinbyemail($pin)
    {
        $name=$this->session->userdata('email');
        $password1 = sha1($pin);
        $this->db->where('email',$name);
        $this->db->where('pin',$password1);
        $this->db->where('status',1);
        $this->db->where('email_verify_status',1);
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    function updateotpbyuserid($otp,$userid)
    {
        
        $data = array('otp' => sha1($otp));

        $this->db->where('id',$userid);

        $userid=$this->db->update('users', $data);
        return $userid;
    }

    function chkotpisvalid($otp)
    {
        $this->db->where('otp',sha1($otp));
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    function resetpassblank($otp)
    {
        $data = array('otp' => '');

        $this->db->where('otp',$otp);

        $userid=$this->db->update('users', $data);
        return $userid;
    }

    function transaction($btcaddress,$amt,$txnid)
    {
        $user_id=$this->session->userdata['user_id'];
        $data = array('trans_address' => $btcaddress,'amount'=>$amt,'user_id'=>$user_id,'txnid'=>$txnid);

        //$this->db->where('otp',$otp);

        $userid=$this->db->insert('transaction', $data);
        return $userid;
    }
   function mailverifychk($name)
   {

		 $this->db->where('email',$name);
		// $this->db->where('password',$password1);
		 $this->db->where('status',1);
		 $this->db->where('email_verify_status',1);
		 $query = $this->db->get('users');
		 if($query->num_rows()==1)
		 {
 			return true;
		 }
		else{
			return false ;
		}
    }

   function getcurrencydetailbyshortname($currency)
   {
	$this->db->where('short_name',$currency);
        $this->db->where('status',1);
        $query = $this->db->get('currency_list');
	$q=$query->result();
        return $q;
   }

    function chkemailpinpass($email,$pin)
    {
        $user_id=$email;
        $this->db->select('*');
        $this->db->from("users");
        $this->db->where("pin",sha1($pin));
        $this->db->where("email",$user_id);
        $query = $this->db->get();
        $q=$query->num_rows();
        return $q;
    }

    function updatepasswordapi($email,$old_password,$new_password)
    {
        
        $data = array('password' => sha1($new_password));

        $this->db->where('email',$email);
        $this->db->where('password',sha1($old_password));

        $userid=$this->db->update('users', $data);
        return $userid;
    }

    function chkpasswordbyemailapi($email,$password)
    {
        $name=$email;
        $password1 = sha1($password);
        $this->db->where('email',$name);
        $this->db->where('password',$password1);
        $this->db->where('status',1);
        $this->db->where('email_verify_status',1);
        $query = $this->db->get('users');
        return $query->num_rows();
    }

      function updatepinpasswordapi($email,$old_pin,$new_pin)
    {
        
        $data = array('pin' => sha1($new_pin));

        $this->db->where('email',$email);
        $this->db->where('password',sha1($old_pin));

        $userid=$this->db->update('users', $data);
        return $userid;
    }

  

    


    function getrpcdetail($email)
    {
        $this->db->select('user.*,rpc.*');
        $this->db->from('users as user');
        $this->db->where('email', $email);
        $this->db->join('rpc_detail as rpc', 'rpc.id = user.rpc_id', 'left');
        $query = $this->db->get();
        $q=$query->result();
        
        return $query; 
    }

    function getuserdetailbyemail($email)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("email",$email);
        $query = $this->db->get();

        $q=$query->result();
        return $q;
    }

    function rpcdetailbymultiid($id)
    {
        $id=str_replace(",","','",$id);

        $qu="select rpc.*,curr.short_name from rpc_detail as rpc left join currency_list as curr on curr.id=rpc.curr_id where rpc.id IN ('$id')";

        $query =$this->db->query($qu);

        
        $q=$query->result();
        
        return $q;

    }

    function getpairfornewuserrpc()
    {
        $qu="select rpc_id,count(rpc_id) as coun from users group by rpc_id order by coun asc";
        $query=$this->db->query($qu);
        $q=$query->result();
        //print_r($q);
        return $q[0];


    }

    function getnewrpcpair($curr_id)
    {
       $qu="select f.id,f.curr_id, f.count_users from ( select curr_id, min(count_users) as connection_count from rpc_detail group by curr_id ) as x inner join rpc_detail as f on f.curr_id = x.curr_id and f.count_users =x.connection_count where f.curr_id='$curr_id'";
        $query=$this->db->query($qu);
        $q=$query->result();
        return $q[0]->id;
      
    }

    function updatecount($rpc_detail,$count)
    {

	$qu="update rpc_detail set count_users='$count' where id='$rpc_detail'";
        $query=$this->db->query($qu);
        //print_r($qu);
       return $query;
    }

function updatecountIN($rpc_detail,$count)
    {
        $rpc_detail=str_replace(",","','",$rpc_detail);
        $qu="update rpc_detail set count_users='$count' where id IN ('$rpc_detail')";
        $query=$this->db->query($qu);
        //print_r($q);
       return $query;
    }

 

 

}


?>
