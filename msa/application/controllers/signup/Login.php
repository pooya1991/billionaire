<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Login extends CI_Controller
{
	public $time;
	function __construct()
	{
		parent::__construct();
		$this->load->model('component/user_model');
		$this->load->model('component/logedin');
		$this->time=date("Y-m-d H:i:s");
		
	}
 	
	function index()
	{
		
	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('email',TRUE);

		if ($this->user_model->resolve_user_login($username, $password)) 
		{
				
				$user_id = $this->user_model->get_user_id_from_email($username);
				$user    = $this->user_model->get_user($user_id);			
				// set session user datas
				$sess_array = array();
				foreach($user as $row)
				{
					$sess_array = array(
						 'id' => $row->id,
						 'username' => $row->username,
						 'type' => $row->type,
						 'bilislogin'=>TRUE,
						 'is_confirmed'=>$row->is_confirmed
					);	
					// set session			   
					$this->session->set_userdata('billogged_in', $sess_array);
					//save login info in database set_login_session
				
					$data = array();
					$data[]=$sess_array['id'];
					$data[]=$sess_array['username'];
					$data[]=$this->input->ip_address();
					$data[]=$this->time;	 				 			
					$this->logedin->set_login_attempts($data);
				}
				return TRUE;

			} else {
				
				// login failed
				$this->form_validation->set_message('check_database', 'Invalid username or password');
			 	return false;
				
			}

	}

function logout()
 {
 	//$this->session->unset_userdata('billogged_in');
 	$login_info = array(
		'session_id'=> $this->session->userdata('billogged_in')['session_id'],
		'user_id'    => $this->session->userdata('billogged_in')['user_id'],
	);

	$loginresult= $this->user_model->delete_user_app_session($login_info);
  	if ($this->session->unset_userdata('billogged_in') or $this->session->unset_userdata('billogged_in')['bilislogin']=== true) {
			
			// remove session datas
			foreach ($this->session->unset_userdata('billogged_in') as $key => $value) {
				unset($this->session->unset_userdata('billogged_in')[$key]);
			}
			
			// user logout ok
			redirect('../../home');
			
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('../../home');
			
		}
  

   redirect('../../home', 'refresh');
 }


}

?>