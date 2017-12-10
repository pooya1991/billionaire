<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Welcome extends CI_Controller
{
	
	function __construct()
    {
        parent::__construct();
        $this->load->model('component/user_model'); 

    }

	public function index()
	{
		$link=$this->session->userdata('billogged_in')['userkey'];
		$username=$this->session->userdata('billogged_in')['username'];			
        $user_profile_id=$this->user_model->get_user_id_from_userkey($link);
        $displayname=$this->session->userdata('billogged_in')['firstname'];
        $profile_pic=$this->session->userdata('billogged_in')['pic'];
        if(isset($profile_pic)){
            $profile_pic=$this->session->userdata('billogged_in')['pic'];
        }else{
            $profile_pic='default.png';
        }

         $profile_account = array(
         	'menu' => '',
            'link'=> $this->session->userdata('billogged_in')['userkey'],
            'username'=> $username,
            'displayname'=> $this->session->userdata('billogged_in')['firstname']." ".$this->session->userdata('billogged_in')['lastname'],
            'profile_pic' => $profile_pic       
        );
		$data = array(

			// 'clock' => $this->load->view("modules/clock","",true),
			// 'mainchart' => $this->load->view("modules/mainchart","",true)
			); 

		$this->load->view('layout/header',$profile_account);
		$this->load->view('pages/welcome',$data);
		$this->load->view('layout/footer',true);
	}
 	
	

}

?>