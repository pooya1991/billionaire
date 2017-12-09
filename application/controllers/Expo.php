<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expo extends Syn_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//***** load components
		$data = array(
			'menus' => $this->load->view("component/menu","",true),
			'sitesetting' => $this->load->view("component/site_setting","",true),
			'login' => $this->load->view("component/login","",true),
			'search' => $this->load->view("component/search","",true),

			); 

		//*** load contents
		// $this->load->model("modules/user");	
		// $tmp=array('prouser' => $this->user->get_all_userpro());				
		// $data["user_free"] = $this->load->view("modules/free_users", $tmp ,true);
		// $tmp1= array('freeuser' => $this->user->get_all_userfree()) ;
		// $data["user_pro"] =  $this->load->view("modules/pro_users",$tmp1,true);	
				
			
		$this->load->view('layout/tpl_main_fa',$data);
		
		 
	}
	public function test()
	{
		// echo "salam";
		// $this->load->model("main/menu");
		// $posts=$this->menu->get_all1();
		// echo "<pre>";

		// print_r($posts->result());
		// echo json_encode($posts->result());

		$this->load->model("modules/user");
		$pro_user=$this->user->get_all_userpro();
		$data["user_pro"] = $pro_user;
		$free_user=$this->user->get_all_userfree();
		$data["user_free"] = $free_user;
		echo "<pre>";
		print_r($data);

	}


	public function test1()
	{
		$this->load->model("modules/user");	
		$tmp=array('prouser' => $this->user->get_all_userpro());				
		$data["user_free"] = $this->load->view("modules/free_users", $tmp ,true);
		$tmp1= array('freeuser' => $this->user->get_all_userfree()) ;
		$data["user_pro"] =  $this->load->view("modules/pro_users",$tmp1,true);	
				
			
		$this->load->view('layout/tpl_main_fa',$data);
	}
}
