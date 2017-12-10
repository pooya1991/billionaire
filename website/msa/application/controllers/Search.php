<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Syn_Base {

  function __construct() {

            parent::__construct(); 
            $this->load->model('modules/user');
            $this->load->model('component/user_model');
            $this->load->model('component/search_model'); 
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
         $profile_account = array(
            'link'=> $this->session->userdata('synlogged_in')['userkey'],
            'username'=> $this->session->userdata('synlogged_in')['username'],
            'displayname'=> $this->session->userdata('synlogged_in')['firstname'],
            'profile_pic' => $this->session->userdata('synlogged_in')['pic']       
        );
        

		$data = array(
			'username'=> $this->session->userdata('synlogged_in')['username'],
			'keyword' =>$this->input->get(),
			'numberofsearch' => 10, //number of show result for any page
			'page' =>$this->input->get('page')
		);
		if(isset($data['keyword']['key']) or isset($data['keyword']['location']))
		{
			if(!is_null($data['keyword']['key']) or !is_null($data['keyword']['location']))
			{
			  	$keys=str_replace('+', ' ', trim($data['keyword']['key']));
			  	$keys=explode(' ',$keys);
			  	$location= isset($data['keyword']['location']) ? trim($data['keyword']['location']):null;

			    if (!isset($data['keyword']['page']))
			    {
					$page['from']=0;
				}else
				{
					$page['from']=$data['keyword']['page']*$data['numberofsearch'];
				}
				$page['to']=$data['numberofsearch'];
		        $result="";
			  	foreach ($keys as $key => $value) 
			  	{		  	
				    $keyword=$value;
		     		if($keyword!="" or $location!=null)
					{
						$names=$this->search_model->search_user_by_name($keyword,$location);
						if(is_array($names))
						{
							foreach ($names as $key => $value) 
							{	
								$result[]= $value['user_id'];
							}
						}	
					}
					if($keyword!="" or $location!=null)
					{
						$names=$this->search_model->search_expo_by_name($keyword,$location);
						if(is_array($names)){
							foreach ($names as $key => $value) 
							{
								$result[]= $value['user_id'];
							}
						}	
					}
			        if($keyword!="" or $location!=null)
					{
						$names=$this->search_model->search_user_by_job($keyword,$location);
						if(is_array($names))
						{
							foreach ($names as $key => $value) 
							{			
								$result[]= $value['user_id'];
							}
						}	
					}
			        if($keyword!="" or $location!=null)
					{
						$skill=$this->search_model->search_skills($keyword,$location);
						if(is_array($skill))
						foreach ($skill as $key => $value) 
						{
							$result[]= $value['user_id'];
						}	
					}
			        if($keyword!="" or $location!=null)
					{
						$resumes=$this->search_model->search_resumes($keyword,$location); 
						if(is_array($resumes))
						{
							foreach ($resumes as $key => $value) 
							{
								$result[]= $value['user_id'];
							}
						}
					}            
					  
				}      		
				if(is_array($result))
				{ 

					$data['numberofresult']=count(array_unique($result));
					$result= "'".join("','",array_unique($result))."'";
					$users=$this->user->get_all_users_info($result,$page);
					$result="";
					if(is_array($users))
					foreach ($users as $key => $value) 
					{
						if($value['pic']=='defaultsh.png' or $value['pic']=='defaultf.png' or $value['pic']=='defaultm.png' )
						{
	            			$value['pic']= base_url().'img/profile/'.$value['pic'];
	          			}else
	          			{
	            			$value['pic']= base_url().'users/'.$value['userkey'].'/images/'.$value['pic'];
	          			}
	          			$age="";
	          			 $datetmp = explode("-",$value['birthday']);
				        if(count($datetmp)>2){
				            $date= $this->jdf->jalali_to_gregorian($datetmp[0],$datetmp[1],$datetmp[2],'-');
				            $age=date_diff(date_create($date), date_create('today'))->y;
				        }
	          			if (strlen($value['description']) > 250)
            			$value['description'] = substr($value['description'], 0, 250) . '...';
						$result[]=array(
							'userkey' => $value['userkey'],
							'username' => $value['username'],
							'firstname' => $value['firstname'],
							'lastname' => $value['lastname'],
							'pic' => $value['pic'],
							'job' => $value['job'],
							'description' => $value['description'],
							'last_online' => $this->relativeTime(strtotime($value['last_online'])),
							'livecity' => $value['live'],
							'birthday' =>$age,
							"marital"=>$value['marital'],
							"visitor"=>$value['visitor'],
							'gender'=>($value["gender"]) ? 'زن':'مرد',
					  	);
					}
					$data['users']=$result;
					$data['username']= $this->session->userdata('synlogged_in')['username'];
				}
				$pagesinfo= array(
		            'link'=> $this->session->userdata('synlogged_in')['userkey'],
		            'menus' => $this->load->view("component/".$this->userinfo['type']."/menu","",true),
		           // 'sitesetting' => $this->load->view("component/".$this->userinfo['type']."/site_setting","",true),
		            'login' => $this->load->view("component/".$this->userinfo['type']."/profile_account",$profile_account,true),
		            'dashbord' => $this->load->view("component/".$this->userinfo['type']."/dashbord","",true),
		            'content' => $this->load->view("pages/search-result",$data,true),
		           // 'search' => $this->load->view("component/search","",true),
		            'profile_setting' => $this->load->view("component/".$this->userinfo['type']."/profile_setting","",true),
		            //'notifactions' => $this->load->view("component/".$this->userinfo['type']."/notifactions","",true),
		            );  	
				$this->load->view('layout/tpl_main_fa',$pagesinfo);
			}else
			{
				$pagesinfo['username']= $this->session->userdata('synlogged_in')['username'];
				$data = array(
	            'link'=> $this->session->userdata('synlogged_in')['userkey'],
	            'menus' => $this->load->view("component/".$this->userinfo['type']."/menu","",true),
	            'login' => $this->load->view("component/".$this->userinfo['type']."/profile_account",$profile_account,true),
	            'dashbord' => $this->load->view("component/".$this->userinfo['type']."/dashbord","",true),
	            'profile_setting' => $this->load->view("component/".$this->userinfo['type']."/profile_setting","",true),
	            'content' => $this->load->view("pages/search",$pagesinfo,true),

	            );  	

				$this->load->view('layout/tpl_main_fa',$data);
			}
		}else
		{
			$pagesinfo['username']= $this->session->userdata('synlogged_in')['username'];
			$data = array(
	            'link'=> $this->session->userdata('synlogged_in')['userkey'],
	            'username'=> $this->session->userdata('synlogged_in')['username'],
	            'menus' => $this->load->view("component/".$this->userinfo['type']."/menu","",true),
	           // 'sitesetting' => $this->load->view("component/".$this->userinfo['type']."/site_setting","",true),
	            'login' => $this->load->view("component/".$this->userinfo['type']."/profile_account",$profile_account,true),
	            'dashbord' => $this->load->view("component/".$this->userinfo['type']."/dashbord","",true),
	            'content' => $this->load->view("pages/search",$pagesinfo,true),
	           // 'search' => $this->load->view("component/search","",true),
	            'profile_setting' => $this->load->view("component/".$this->userinfo['type']."/profile_setting","",true),
	            //'notifactions' => $this->load->view("component/".$this->userinfo['type']."/notifactions","",true),
	            );  	

		$this->load->view('layout/tpl_main_fa',$data);
		}	 
 
	}
	public function location()
	{
		
        header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
            'keyword' => (isset($_POST["data"]['keyword'])) ? $_POST["data"]['keyword'] : "" ,
            'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "" ,
            'ownuserkey' => (isset($_POST["data"]['ownuserkey'])) ? $_POST["data"]['ownuserkey'] : "" ,
        );
        // /* Email Validation */
        // if ($user_info['ownuserkey']!= $this->session->userdata('synlogged_in')['userkey']) {
        // $error[] = "hehe...!";
        // }
        /* Email Validation */
        if (empty($user_info["keyword"])) {
        $error[] = "keyword problem...";
        }
        //*******don't have error*****
        if (!is_array($error)) {
            
            $location=$this->search_model->search_location($user_info["keyword"]);
            foreach ($location as $key => $value) {
            	$data[]=$value['title'];
            }
        }
        else{
            $error[]="Fetch faild..";
        }
        //*************return result************
        $result = array(
            'error' =>  (is_array($error)) ? 1 : 0 ,
            'error_detalis'=>$error,
            'data'=>$data
             );
        echo json_encode(array('result'=>$result));
	}
	
	public function allsearch()
	{
		
        header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
            'keyword' => (isset($_POST["data"]['keyword'])) ? $_POST["data"]['keyword'] : "" ,
            'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "" ,
            'ownuserkey' => (isset($_POST["data"]['ownuserkey'])) ? $_POST["data"]['ownuserkey'] : "" ,
        );
        // /* Email Validation */
        // if ($user_info['ownuserkey']!= $this->session->userdata('synlogged_in')['userkey']) {
        // $error[] = "hehe...!";
        // }
        /* Email Validation */
        if (empty($user_info["keyword"])) {
        $error[] = "keyword problem...";
        }
        //*******don't have error*****
        if (!is_array($error)) {
            $num=3;
            $skill=$this->search_model->search_skill($user_info["keyword"]);
            $i=0;
			if(is_array($skill))
			foreach ($skill as $key => $value) {
				if ($i++ ==$num) break;
				$data[]= $value['title'];
			}
            $resume=$this->search_model->search_resume($user_info["keyword"]);
            $i=0;
			if(is_array($resume))
			foreach ($resume as $key => $value) {
				if ($i++ ==$num) break;
				$data[]= $value['title'];
			}
            $user=$this->search_model->search_user($user_info["keyword"]);
            $i=0;
			if(is_array($user))
			foreach ($user as $key => $value) {
				if ($i++ ==$num) break;
				$data[]= $value['firstname']." ".$value['lastname'];
			}
        }
        else{
            $error[]="Fetch faild..";
        }
        //*************return result************
        $result = array(
            'error' =>  (is_array($error)) ? 1 : 0 ,
            'error_detalis'=>$error,
            'data'=>$data
             );
        echo json_encode(array('result'=>$result));
	}
	//**********************************************
		private function relativeTime($time, $short = false){
	    $SECOND = 1;
	    $MINUTE = 60 * $SECOND;
	    $HOUR = 60 * $MINUTE;
	    $DAY = 24 * $HOUR;
	    $MONTH = 30 * $DAY;
	    $before = time() - $time;

	    if ($before < 0)
	    {
	        return "مشخص نشده";
	    }

	    if ($short){
	        if ($before < 1 * $MINUTE)
	        {
	            return ($before <5) ? " فقط " : $before . " قبل ";
	        }

	        if ($before < 2 * $MINUTE)
	        {
	            return "1 دقیقه قبل ";
	        }

	        if ($before < 45 * $MINUTE)
	        {
	            return floor($before / 60) . " دقیقه قبل ";
	        }

	        if ($before < 90 * $MINUTE)
	        {
	            return "1 ساعت قبل";
	        }

	        if ($before < 24 * $HOUR)
	        {

	            return floor($before / 60 / 60). " ساعت قبل ";
	        }

	        if ($before < 48 * $HOUR)
	        {
	            return "1 روز قبل";
	        }

	        if ($before < 30 * $DAY)
	        {
	            return floor($before / 60 / 60 / 24) . " روز قبل ";
	        }


	        if ($before < 12 * $MONTH)
	        {
	            $months = floor($before / 60 / 60 / 24 / 30);
	            return $months <= 1 ? "1 ماه قبل " : $months . " ماه قبل ";
	        }
	        else
	        {
	            $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
	            return $years <= 1 ? "1 سال قبل " : $years." سال قبل ";
	        }
	    }

	    if ($before < 1 * $MINUTE)
	    {
	        return ($before <= 1) ? " آنلاین " : $before . " ثانیه قبل ";
	    }

	    if ($before < 2 * $MINUTE)
	    {
	        return "one دقیقه قبل";
	    }

	    if ($before < 45 * $MINUTE)
	    {
	        return floor($before / 60) . " دقیقه قبل ";
	    }

	    if ($before < 90 * $MINUTE)
	    {
	        return " 1 ساعت قبل ";
	    }

	    if ($before < 24 * $HOUR)
	    {

	        return (floor($before / 60 / 60) == 1 ? '  1 ساعت ' : floor($before / 60 / 60).' ساعت '). " قبل ";
	    }

	    if ($before < 48 * $HOUR)
	    {
	        return " روز ";
	    }

	    if ($before < 30 * $DAY)
	    {
	        return floor($before / 60 / 60 / 24) . " روز قبل ";
	    }

	    if ($before < 12 * $MONTH)
	    {

	        $months = floor($before / 60 / 60 / 24 / 30);
	        return $months <= 1 ? " 1 ماه قبل " : $months . " ماه قبل";
	    }
	    else
	    {
	        $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
	        return $years <= 1 ? " 1 سال قبل " : $years." سال قبل";
	    }

	    return "$time";
	}	
}
