<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Learning extends Bil_Controller {

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
         	'menu' => 'learning',
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
		$this->load->view('pages/learning',$data);
		$this->load->view('layout/footer',true);

		
		 
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


function logout()
 {
 	if ($this->session->unset_userdata('billogged_in') && $this->session->unset_userdata('billogged_in')['bilislogin']=== true) {
			
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
   $this->session->unset_userdata('billogged_in');

   redirect('../../home', 'refresh');
 }
}
