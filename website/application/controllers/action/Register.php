<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/


class Register extends CI_Controller
{
	public function __construct() {
		
		parent::__construct();
		
	}

	public function activator()
	{

		$this->load->helper('url');
		if($this->uri->segment(4)) {
			$data = $this->uri->segment(4);
			$this->load->model("component/user_model");	
			$this->user_model->check_update_user_active_link($data);
			if ($this->session->unset_userdata('billogged_in') or $this->session->unset_userdata('billogged_in')['bilislogin']=== true) {
			
			// remove session datas
			foreach ($this->session->unset_userdata('billogged_in') as $key => $value) {
				unset($this->session->unset_userdata('billogged_in')[$key]);
			}
		}
			redirect(base_url('login'), 'refresh');				
		}
		
	}	

	
}

?>