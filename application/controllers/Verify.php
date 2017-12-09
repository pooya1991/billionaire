<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/


class Verify extends CI_Controller
{
	public function __construct() {
		
		parent::__construct();
		
	}

	
	public function index()
	{

		if($this->uri->segment(4)) {
		echo "Thanks for verify<a href='".base_url()."'msa/signup/login/logout/'>click here...</a>";
			$data = $this->uri->segment(4);
			$this->load->model("component/user_model");	
			$this->user_model->check_update_user_active_link($data);
			//redirect(base_url().'msa/signup/login/logout/', 'refresh');				
		}
		
	}
	
}

?>