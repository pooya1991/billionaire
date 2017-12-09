<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Syn_Controller
*/

class Bil_Controller extends CI_Controller
{
	
	public $userinfo=array();
	function __construct()
	{
		parent::__construct();

		$login=$this->input->cookie('bilcookie');
		if(!empty($login))
		{
			$this->load->library("encrypt");
			$login= $this->encrypt->decode($login,ENCRYPT_KEY);
			$login = explode("$^$", $login);
			$this->userinfo['username']=$login[0];			
			$this->userinfo['user_id']=$login[2];
			$this->userinfo['is_confirmed']=$login[6];
			
			
			
		}else
		{
			if($this->session->userdata('billogged_in')['bilislogin'])
		   {
		   		if($this->session->userdata('billogged_in')['is_confirmed']){
		   			$this->userinfo['username']=$this->session->userdata('billogged_in')['username'];
					$this->userinfo['user_id']=$this->session->userdata('billogged_in')['user_id'];
					$this->userinfo['type']=$this->session->userdata('billogged_in')['type'];
					$this->userinfo['is_confirmed']=$this->session->userdata('billogged_in')['is_confirmed'];
		   		}else{
		   			redirect('../welcome', 'refresh');
		   		}
				
				
		   }
		   else
		   {
		     redirect('../../home', 'refresh');
		     
		   }
		}
		
	}

}

?>