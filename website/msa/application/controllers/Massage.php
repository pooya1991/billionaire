<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Massage extends Syn_Base {

	function __construct()
    {
        parent::__construct();
        $this->load->model('component/user_model'); 

    }
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
        
		$link=$this->session->userdata('synlogged_in')['userkey'];
        $username=$this->session->userdata('synlogged_in')['username'];         
        $user_profile_id=$this->user_model->get_user_id_from_userkey($link);
        $displayname=$this->user_model->get_user_firstname_by_id($user_profile_id);
        $profile_pic=$this->session->userdata('synlogged_in')['pic'];
        if(isset($profile_pic)){
            $profile_pic=$this->session->userdata('synlogged_in')['pic'];
        }else{
            $profile_pic='default.png';
        }

         $profile_account = array(
            'link'=> $this->session->userdata('synlogged_in')['userkey'],
            'username'=> $username,
            'displayname'=> $this->session->userdata('synlogged_in')['firstname'],
            'profile_pic' => $profile_pic       
        );
        
        //***** load components
         $user_page_data = array(
            'link'=> $link,
            'username'=> $username,
            'userkey'=> $link  
             
        );
        

         //************************
        $data = array(
            'link'=> $link,
            'menus' => $this->load->view("component/".$this->userinfo['type']."/menu","",true),
            'sitesetting' => $this->load->view("component/".$this->userinfo['type']."/site_setting","",true),
            'login' => $this->load->view("component/".$this->userinfo['type']."/profile_account",$profile_account,true),
            //'dashbord' => $this->load->view("component/".$this->userinfo['type']."/dashbord","",true),
            'center_content' => $this->load->view("component/".$this->userinfo['type']."/massage",$user_page_data,true),
            'search' => $this->load->view("component/search","",true),
            'profile_setting' => $this->load->view("component/".$this->userinfo['type']."/profile_setting","",true),
            'notifactions' => $this->load->view("component/".$this->userinfo['type']."/notifactions","",true),

            );	
			
		$this->load->view('layout/tpl_main_fa',$data);
	 
	}
}
