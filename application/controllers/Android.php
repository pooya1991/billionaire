<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Android extends Syn_Controller {

    public function __construct() {

            parent::__construct(); 
            $this->load->model('modules/user');
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

		$this->load->view('config/android');	
		 
	}
	public function getapp()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

		$hit_count = file_get_contents('android/counter.txt');
		$hit_count++;
		$log="{[".$hit_count."],[".$ip."]}"."\n";
		file_put_contents('android/counter.txt', $hit_count);
		file_put_contents('android/dllog.txt', $log ,FILE_APPEND); 


		header('Location: '.base_url().'android/afb.synskill.com.apk');	
		 
	}




}
