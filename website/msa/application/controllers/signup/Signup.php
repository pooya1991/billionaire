<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Signup extends Syn_Controller
{
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('form','url'));
		$this->load->model('component/user_model');
		$this->load->model('component/logedin');
		
	}
	
	public function index()
	{
		//***** load components
		$data = array(
			'menus' => $this->load->view("component/menu","",true),
			'sitesetting' => $this->load->view("component/site_setting","",true),
			'login' => $this->load->view("component/login","",true),
			'search' => $this->load->view("component/search","",true)

			); 
		$this->load->view('signup/signup',$data);
	}
		/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register() {
		
		
		// load form helper and validation library
		
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 
			'trim|required|alpha_numeric|min_length[4]|is_unique[user.username]',
			array(
				'is_unique' => 'This username already exists. Please choose another one.'
				)
			);
		$this->form_validation->set_rules('email', 'Email', 
			'trim|required|valid_email|is_unique[user.email]'
			);
		$this->form_validation->set_rules('regpassword', 'Password',
		 	'trim|required|min_length[6]'
		 	);
		$this->form_validation->set_rules('regpassword_confirm', 'Confirm Password', 
			'trim|required|min_length[6]|matches[regpassword]'
			);
		
		if ($this->form_validation->run() === false) {
			
			
			$view = array(
					'menus' => $this->load->view("component/menu","",true),
					'sitesetting' => $this->load->view("component/site_setting","",true),
					'login' => $this->load->view("component/login","",true),
					'search' => $this->load->view("component/search","",true)
					
					); 
				$this->load->view('signup/signup',$view);
			
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('regpassword');
			$gender = $this->input->post('gender');
			$birthday= $this->input->post('yearcombo').'-'.$this->input->post('monthcombo').'-'.$this->input->post('daycombo');

			// insert user information	
			$result=$this->user_model->create_user($username, $email, $password);
			if ($result) 
			{
				$sess_array = array();
				foreach($result as $row)
				{
					$sess_array = array(
						 'id' => $row->id,
						 'username' => $row->username,
						 'type' => $row->type,
						 'synislogin'=>TRUE,
						 'is_confirmed'=>$row->is_confirmed
					);	
				}
				// set session			   
				$this->session->set_userdata('synlogged_in', $sess_array);
				//save login info in database set_login_session
				
				$data = array();
				$data[]=$sess_array['id'];
				$data[]=$sess_array['username'];
				$data[]=$this->input->ip_address();
				$data[]=date('Y-m-j H:i:s');	 				 			
				$this->logedin->set_login_attempts($data);

				// insert basic information	
				$user_info = array(
								   array(
								      'user_id' => $sess_array['id'] ,
								      'type' => 'gender' ,
								      'value' => $gender
								   ),
								   array(
								      'user_id' => $sess_array['id'] ,
								      'type' => 'birthday' ,
								      'value' => $birthday
								   )
								);
				$this->user_model->save_user_info($user_info);

				// user creation ok
				redirect('../welcome', 'refresh');
				exit();
				
			} else {
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				//***** load components
				$view = array(
					'menus' => $this->load->view("component/menu","",true),
					'sitesetting' => $this->load->view("component/site_setting","",true),
					'login' => $this->load->view("component/login","",true),
					'search' => $this->load->view("component/search","",true),
					'error'=> $data
					); 
				$this->load->view('signup/signup',$view);
				
			}
			
		}
		
	}
		


	public function email()
	{
		$this->load->library('email');

		$this->email->from('info@synskill.com', 'Synskill');
		$this->email->to('hooman.qorbani@gmail.com');
		// $this->email->cc('another@another-example.com');
		// $this->email->bcc('them@their-example.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		$this->email->send();
	}
}

?>