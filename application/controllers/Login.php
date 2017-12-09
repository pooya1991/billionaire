<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Login extends Bil_Controller
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
		$this->load->view('component/login',true);

	}
	public function login()
	{
		header('Content-type: application/json; charset=utf-8');
		$json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
		$user_info = array(
			'email' => (isset($_POST["data"]['email'])) ? $_POST["data"]['email'] : "" ,
			'password' => (isset($_POST["data"]['passwd'])) ? $_POST["data"]['passwd'] : "",
			'device_id'=>'web'
		);
        /* Email Validation */
		if (empty($user_info["email"])) {
		$error[] = "Email is required";
		} else {
		// check if e-mail address is well-formed
			if (!filter_var($user_info["email"], FILTER_VALIDATE_EMAIL)) {
			  $error[] = "Invalid email format";
			}
		}
		if (empty($user_info["password"]))
		{
		 $error[]="Password is required";
		}
		//*******don't have error*****
		if (!is_array($error)) {
			$this->check_login($user_info);
			$loginresult=$this->check_database($user_info);
			if ($loginresult) {
				if( $loginresult['pic']=='defaultsh.png' or $loginresult['pic']=='defaultm.png' or$loginresult['pic']=='defaultf.png'){
					$user_img= base_url().'msa/img/profile/'.$loginresult['pic'];;
				}else
				{
					$user_img= base_url().'msa/users/'.$loginresult['userkey'].'/images/'.$loginresult['pic'];
				}
				$user_info=$this->user_model->get_user_info_from_email($user_info['email']);
				$profilecompleted=1;
				$sess_array = array(
							'user_id' => $user_info["user_id"],
							'userkey' => $user_info["userkey"],
							'username' => $user_info["username"],
							'type' => $user_info["category"],
							'bilislogin'=>TRUE,
							'session_id'=>$loginresult['session_id'],
							'is_confirmed'=>$user_info["is_confirmed"],
							'firstname' => $user_info['firstname'] ,
							'lastname' => $user_info['lastname'] ,
							'profilecompleted' => $profilecompleted,
							'pic' => $user_img 
							);	
			
							// set session			   
							$this->session->set_userdata('billogged_in', $sess_array);
							$data=1;
			}
			else{
				$error[]="Login faild..";
			}
		}
		//*************return result************
        $result = array(
        	'error' =>  (is_array($error)) ? 1 : 0 ,
        	'error_detalis'=>$error,
        	'data'=>$data
        	 );
        echo json_encode(array('result'=>$result));
	
		}
	/**
	 * check_login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function check_login($info)
	{
		 if(isset($info)){
		 	$user_info=$this->user_model->get_user_info_from_email($info['email']);
	      	// set user info
			$login_info = array(

				'device_id'=> 'web',
				'user_id'    => $user_info['user_id'] ,
			);
			//$loginresult= $this->user_model->check_user_session($login_info);
			$loginresult= $this->user_model->delete_user_app_session($login_info);

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

	/**
	 * forget_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function forget_password()
	{
		 if(isset($_POST)){

	      	// set user info
			$result= $this->user_model->send_password_to_email($_POST['loginemail']);
			if ($result) {

				echo '1';
			}
			else
			{
				echo '0';
			}
		}
		
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