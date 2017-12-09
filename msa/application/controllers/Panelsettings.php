<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panelsettings extends Bil_Controller {

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

        $users=$this->user_model->get_system_users();
        echo "<table border='1'>
        		<th>نام</th>
        		<th>نام خانوادگی</th>
        		<th>ایمیل</th>
        		<th>وضعیت فعال سازی</th>
        		<th>تاریخ ثبت نام</th>
        		<th>آخرین ورود</th>

        ";
       foreach ($users as $key => $value) {
       	   echo "
       	   <tr>
       	   		<td>".$value['firstname']."</td>
       	   		<td>".$value['lastname']."</td>
       	   		<td>".$value['email']."</td>
       	   		<td>".$value['is_confirmed']."</td>
       	   		<td>".$value['created']."</td>
       	   		<td>".$value['last_online']."</td>
       	   </tr>
       	   ";
       }
		 echo "</table>";
		 
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
