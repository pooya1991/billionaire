<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Bil_Controller {

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
	public function index($s_code="IRO1FKHZ0001")
	{

		$link=$this->session->userdata('billogged_in')['userkey'];
		$username=$this->session->userdata('billogged_in')['username'];
        $user_profile_id=$this->user_model->get_user_id_from_userkey($link);
        $displayname=$this->session->userdata('billogged_in')['firstname'];
        $profile_pic=$this->session->userdata('billogged_in')['pic'];
        /*******************/
        $user_profile_info=$this->user_model->get_user_full_info_by_userkey($link);
        if(isset($profile_pic)){
            $profile_pic=$this->session->userdata('billogged_in')['pic'];
        }else{
            $profile_pic='default.png';
        }

         $profile_account = array(
         	'menu' => 'home',
            'link'=> $this->session->userdata('billogged_in')['userkey'],
            'username'=> $username,
            'displayname'=> $this->session->userdata('billogged_in')['firstname']." ".$this->session->userdata('billogged_in')['lastname'],
            'profile_pic' => $profile_pic
        );
		if(isset($s_code)){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://xtrader.ir/data/stockwatch/'.$s_code.'/');
		curl_setopt($ch, CURLOPT_ENCODING ,"utf-8");
		//$result1 = curl_exec($ch);
		$page = utf8_decode(curl_exec($ch));
		curl_close($ch);
		$page = json_decode($page,true);
		}

		/********************************/
		$close_histry=$this->stocks_history($s_code)['data'];
		$suggest_portfolio=$this->user_model->get_user_portfilio_suggestion($user_profile_info['user_id']);
		$watchlists=$this->user_model->get_user_watchlists($user_profile_info['user_id']);
		$watchlist_details=$this->user_model->get_user_watchlist_details($user_profile_info['user_id']);

		$data = array(

			'clock' => $this->load->view("modules/clock","",true),
			'mainchart' => $this->load->view("modules/mainchart1",array('data' => $close_histry),true),
			'circlechart' => $this->load->view("modules/circlechart-rebalenc",array('stocks' => $suggest_portfolio),true),
			'pageinfo'=>$page,
			'watchlists'=>$watchlists,
			'watchlist_details'=>$watchlist_details
			);



		$this->load->view('layout/header',$profile_account);
		$this->load->view('pages/home',$data);
		$this->load->view('layout/footer',true);



	}
	public function test()
	{

		$url = "https://shahr-online.com/realtime";
		curl_setopt($ch, CURLOPT_USERPWD, "hosi50028:6spss");


	}



	private function stocks_history($num)
	{
		$url = base_url('component/stocks/stockhistory.txt');
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
		  echo curl_error($ch);
		  echo "\n<br />";
		  $contents = '';
		} else {
		  curl_close($ch);
		}

		if (!is_string($contents) || !strlen($contents)) {
		echo "Failed to get contents.";
		$contents = '';
		}

		$json=$contents;
		$obj = json_decode($json,true);
		$error=$data="";
		$user_info = array(
		    'risknum' => ($num!="") ? $num : '0'
        );
        if ( $user_info['risknum']=='0') {
        	$error[] = "hehe...!";
        }

		//*******don't have error*****
		if (!is_array($error)) {
			foreach ($obj as $key => $value) {
				if(isset($value[$user_info['risknum']])){
			   		$data=$value[$user_info['risknum']];
				}
			}

		}
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		return $result;
	}
}
