<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Signup extends Bil_Controller
{
	public 	function __construct()
	{
		parent::__construct();
		$this->load->model('component/user_model');
		$this->load->model('component/logedin');
		$this->time=date("Y-m-d H:i:s");
		
	}
 	
	public function index()
	{
		$this->load->view('layout/header2',true);
		$this->load->view('component/signup',true);

	}
	public function register()
	{
		header('Content-type: application/json; charset=utf-8');
		$json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
		$user_info = array(
			'fname' => (isset($_POST["data"]['fname'])) ? $_POST["data"]['fname'] : "" ,
			'lname' => (isset($_POST["data"]['lname'])) ? $_POST["data"]['lname'] : "" ,
			'email' => (isset($_POST["data"]['email'])) ? $_POST["data"]['email'] : "" ,
			'gender' => (isset($_POST["data"]['gender'])) ? $_POST["data"]['gender'] : "2" ,
			'password' => (isset($_POST["data"]['passwd'])) ? $_POST["data"]['passwd'] : "",
			'repassword' => (isset($_POST["data"]['repasswd'])) ? $_POST["data"]['repasswd'] : ".",
			'category'=> (isset($_POST["data"]['type'])) ? $_POST["data"]['type'] : "",
			'phone'=> (isset($_POST["data"]['phone'])) ? $_POST["data"]['phone'] : ""

		);
		/* Email Validation */
		if (empty($user_info["phone"])) {
		$error[] = "phone number is required";
		} 
        /* Email Validation */
		if (empty($user_info["email"])) {
		$error[] = "Email is required";
		} else {
		// check if e-mail address is well-formed
			if (!filter_var($user_info["email"], FILTER_VALIDATE_EMAIL)) {
			  $error[] = "Invalid email format";
			}
		}
		if ($user_info['password']!= $user_info['repassword'])
		{
		 $error[]="Password did not match!";
		}
		if($this->user_model->check_email_exist($user_info['email'])) 
		{
			$error[]="Email exsit...";
		}
		if (!is_array($error)) {
		      	

				if( $user_info['gender']==0){
					$user_info['pic']='defaultm.png';
				}elseif( $user_info['gender']==1)
				{
					$user_info['pic']='defaultf.png';	
				}elseif( $user_info['gender']==2)
				{
					$user_info['pic']='defaultsh.png';	
				}
					

					//$username= $this->make_username($user_info);
					//$user_info['username']= $username;
					$username_tmp=explode('@', $user_info['email']);
					$userkey=$this->userkeygerator(5,$username_tmp[0]);
					$username=$this->usernamegerator(5,$username_tmp[0]);
					$user_info['userkey']=$userkey;
					$user_info['username']=$username;
					// insert user information	
					//print_r($user_info);
					$result=$this->user_model->create_user($user_info);
					if ($result) 
					{
						$data = array();
						$data[]=$result["user_id"];
						$data[]=$result["userkey"];
						$data[]=$result["username"];
						$data[]="0";
						$data[]=date('Y-m-j H:i:s');	 				 			
						$this->logedin->set_login_attempts($data);					
				    	// set user info
						$login_info = array(

							'device_id'=> 'Web',
							'email'    => $user_info['email'],
							'password' => $user_info['password']
						);
						$user_profile = array(
							      'user_id' => $result["user_id"],
							      'gender' =>  $user_info['gender'] ,
							      'firstname' =>  $user_info['fname'],
							      'lastname' =>  $user_info['lname'],
								);
						$this->user_model->save_user_info($user_profile);
						 //--------------------------------

						$zip = new ZipArchive;
						$res = $zip->open('msa/users/userbase.zip');
						if ($res === TRUE) {
						  $zip->extractTo('msa/users/'.$result["userkey"]);
						  $zip->close();
						  
						} else {
						  
						}
						$loginresult=$this->check_database($login_info);
						if( $loginresult['pic']=='defaultsh.png' or $loginresult['pic']=='defaultm.png' or$loginresult['pic']=='defaultf.png'){
						$user_img= base_url().'msa/img/profile/'.$loginresult['pic'];;
						}else
						{
							$user_img= base_url().'msa/users/'.$loginresult['userkey'].'/images/'.$loginresult['pic'];
						}
						if ($loginresult) {

							$sess_array = array(
							'user_id' => $result["user_id"],
							'userkey' => $result["userkey"],
							'username' => $result["username"],
							'type' => $result["category"],
							'bilislogin'=>TRUE,
							'session_id'=>$loginresult['session_id'],
							'is_confirmed'=>$result["is_confirmed"],
							'firstname' => $user_info['fname'] ,
							'lastname' => $user_info['lname'] ,
							'profilecompleted' =>1,
							'pic' => $user_img 
							);	

			
							// set session			   
							$this->session->set_userdata('billogged_in', $sess_array);
							$data=1;		
						}		
					}
					else
					{
						$error[]='error...';
					}	
		}

        $result = array(
        	'error' =>  (is_array($error)) ? 1 : 0 ,
        	'error_detalis'=>$error,
        	'data'=>$data
        	 );
        echo json_encode(array('result'=>$result));
   
	}
	public function usernamegerator($length ,$user)
	{
		$characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = $user;

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;

	}
	public function checkemail($email)
	{
		
		return ($this->user_model->check_email_exist($email)) ? '1':'0';
	}
	public function userkeygerator($length , $user)
	{
		$characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = $user.date('smhyid');

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;

	}
	public function login()
	{
		 if(isset($_POST)){

	      	// set user info
			$login_info = array(

				'device_id'=> $_POST['logindevice'],
				'email'    => $_POST['loginemail'],
				'password' => $_POST['loginpassword']
			);

			$loginresult=$this->check_database($login_info);
			if ($loginresult) {
				if( $loginresult['pic']=='defaultsh.png' or $loginresult['pic']=='defaultm.png' or$loginresult['pic']=='defaultf.png'){
					$user_img= base_url().'msa/img/profile/'.$loginresult['pic'];;
				}else
				{
					$user_img= base_url().'msa/users/'.$loginresult['userkey'].'/images/'.$loginresult['pic'];
				}
				$user_info=$this->user_model->get_user_info_from_email($login_info['email']);
				$profilecompleted=1;
				if($user_info['job']!="") $profilecompleted=2;
				$result = array(
					'loginkey' => $loginresult['login_key'] ,
					'ownuserimg' => $user_img ,
					'mobile' => $loginresult['register_phone'],
					'ownuserkey' => $loginresult['userkey'],
					'profilecompleted' => $profilecompleted,
					'type'=>intval($user_info['category'])

					);

				echo json_encode(array('logininfo'=>$result));	
			}
			else
			{
				echo 'false';
			}
		}
		
	}
	/**
	 * check_login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function check_login()
	{
		 if(isset($_POST)){
		 	$user_info=$this->user_model->get_user_info_from_email($_POST['loginemail']);
	      	// set user info
			$login_info = array(

				'device_id'=> $_POST['logindevice'],
				'user_id'    => $user_info['user_id'] ,
				'login_key' => $_POST['loginkey']
			);
			$loginresult= $this->user_model->check_user_session($login_info);
			if (is_array($loginresult)) {

				
                $data = array(
                		"user_id" => $login_info['user_id'], 
                		"last_online"=> date("Y-m-d H:i:s")
                		);
                $this->user_model->update_user_app_session($data);
				if($user_info['job']!="")
				{
				echo '2';
				}
				else
				{
				echo '1';
				}
			}
			else
			{
				echo '0';
			}
		}
		
	}

	private function check_database($login_info)
	{

		//Field validation succeeded.  Validate against database

		if ($this->user_model->resolve_user_login($login_info['email'], $login_info['password'])) 
		{
			
				$user_id = $this->user_model->get_user_info_from_email($login_info['email']);
				//$user    = $this->user_model->get_user($user_id);			
				// set session user datas
				$session_info = array(
					'user_id' => $user_id['user_id'],
					'userkey' => $user_id['userkey'],
					'session_id'=> date("Y-m-d H:i:s"),
					'device_id' => $login_info['device_id'],
					'ip_address'=> '0.0.0.0',
					'user_agent' => 'appication' ,
					'login_key' => $user_id['userkey'].$login_info['device_id'],
				 );
				$result=$this->user_model->set_user_app_session($session_info);
				if($result)
				{
					return $result['0'];
				}

				return False;

		} else {

			 	return False;
				
		}

	}
	public function forget()
	{
		$this->load->view('layout/header2',true);
		$this->load->view('component/forget',true);

	}
	/**
	 * forget_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function forget_password()
	{
		header('Content-type: application/json; charset=utf-8');
		$json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
		$user_info = array(

			'email' => (isset($_POST["data"]['email'])) ? $_POST["data"]['email'] : "" 

		);
		/* Email Validation */
		if (empty($user_info["email"])) {
		$error[] = "Email is required";
		} 
		// check if e-mail address is well-formed
		if (!filter_var($user_info["email"], FILTER_VALIDATE_EMAIL)) {
		  $error[] = "Invalid email format";
		}
		if(!$this->checkemail($user_info["email"]))
		{
			$error[] = "ایمیل نامعتبر";
		}
		if (!is_array($error)) {
			$link= password_hash(date('Y-m-jH:i:s').$user_info["email"], PASSWORD_BCRYPT);
			$link = trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($link))))));
			$link=trim($link,'$');
			$link=trim($link,'.');
			$link=trim($link,'/');
	      	// set user info
			$result1= $this->user_model->update_user_reset_password($user_info["email"],$link);
			if ($result1>0) {
				$this->user_model->send_password_to_email($user_info["email"],$link);
				$data= 'لینک بازیابی با موفقیت به ایمیل شما ارسال شد';
			}
			else
			{
				$error[] = 'خطا در ارسال';
			}
		}
		$result = array(
        	'error' =>  (is_array($error)) ? 1 : 0 ,
        	'error_detalis'=>$error,
        	'data'=>$data
        	 );
        echo json_encode(array('result'=>$result));
		
	}

	public function resetaccount($key)
	{
		$this->load->view('layout/header2',true);
		$this->load->view('component/resetpass',array('key' => $key));

	}
	/**
	 * forget_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function resetpass()
	{
		header('Content-type: application/json; charset=utf-8');
		$json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
		$user_info = array(
			'password' => (isset($_POST["data"]['passwd'])) ? $_POST["data"]['passwd'] : "",
			'repassword' => (isset($_POST["data"]['repasswd'])) ? $_POST["data"]['repasswd'] : ".",
			'key' => (isset($_POST["data"]['link'])) ? $_POST["data"]['link'] : "" 

		);
		if ($user_info['password']!= $user_info['repassword'])
		{
		 $error[]="Password did not match!";
		}
		if (!is_array($error)) {
			

	      	// set user info
			$result1= $this->user_model->update_user_password($user_info["password"],$user_info["key"]);
			if ($result1) {
				
				$data= 'با گذرواژه جدید وارد شوید';
			}
			else
			{
				$data= 'ایمیل نامعتبر';
			}
		}
		$result = array(
        	'error' =>  (is_array($error)) ? 1 : 0 ,
        	'error_detalis'=>$error,
        	'data'=>$data
        	 );
        echo json_encode(array('result'=>$result));
		
	}
/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		
		 if(isset($_POST)){

	      	// set user info
			$login_info = array(

				'device_id'=> $_POST['logindevice'],
				'user_id'    => $this->user_model->get_user_id_from_email($_POST['loginemail']),
				'login_key' => $_POST['loginkey']
			);
			$loginresult= $this->user_model->delete_user_app_session($login_info);

			if ($loginresult) {

				echo '1';
			}
			else
			{
				echo '0';
			}
		}
		
	}

}

?>