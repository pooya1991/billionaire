<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Bil_Controller {

    public function __construct() {
            parent::__construct(); 
        $this->load->model('component/user_model');
        $this->load->model('modules/user');
    }

    public function index()
    {
       $username = $this->uri->segment(1);

        if (empty($username)) {
            header("Location: ".base_url());
            die();
        }
        
        $user_profile_info=$this->user_model->get_user_info_by_username($username);

        // Check if parameter is not a valid username.
        if (!$user_profile_info) {
            header("Location: ".base_url());
            die();
        } else {
        	$this->display_profile($user_profile_info);
        }
            // Load data for user profile.
            // $ip = $this->session->userdata('ip_address');
            // $curr_user = $this->session->userdata('id');

            // $data['profile'] = $this->db->get_where('users', array('id' => $profile_id))->row_array();  
            // $data['followers'] = $this->db->get_where('followers', array('following_id' => $profile_id))->num_rows();       
            // $data['following'] = $this->db->get_where('followers', array('follower_id' => $profile_id))->num_rows();
            // $data['doesFollow'] = $this->db->get_where('followers', array('follower_id' => $curr_user, 'following_id' => $profile_id))->num_rows();
            // $data['posts'] = $this->db->get_where('posts', array('user_id' => $profile_id))->result_array();        

            // $data['main_content'] = 'profile';  
            // $this->load->view('template', $data);   

            // $this->get_profile_view($profile_id, $ip, $curr_user);  
        }
   
    protected function display_profile($user_profile_info) 
    {

        $username=$user_profile_info['username'];         
        $userkey= $user_profile_info['userkey'];//*********
        $all_users=$this->user->get_user_info_by_key($userkey);
        if( $all_users['pic']=='defaultsh.png' or $all_users['pic']=='defaultf.png' or $all_users['pic']=='defaultm.png'){
            $user_img= base_url().'msa/img/profile/'.$all_users['pic'];
        }else
        {
            $user_img= base_url().'msa/users/'.$all_users['userkey'].'/images/'.$all_users['pic'];
        }
        $skills=$this->userskill($all_users['user_id']);
        $resumes=$this->userresume($all_users['user_id']);

         $datetmp = explode("-",$all_users['birthday']);
        if(count($datetmp)>2){
            $date= $this->jdf->jalali_to_gregorian($datetmp[0],$datetmp[1],$datetmp[2],'-');
            $age=date_diff(date_create($date), date_create('today'))->y;
        }
        else $age="";

        $video="";
        if (preg_match('/aparat.com\/v\/(.*)?/', $all_users['video'], $display) === 1) {
             $video=str_replace("/","", $display[1]);
        } 
        $users = array(        
                "isBlocked" => -1,
                "isSpamed" => 1,
                "type" => 1,
                "userkey" => $all_users['userkey'],
                "name" => $all_users['firstname'],
                "lastName" => $all_users['lastname'],
                "pic" => $user_img,
                "age" => $age,
                "birthday" => $all_users['birthday'],
                'description'=>$all_users['description'],
                "job" => (is_null($all_users['job'])) ? '' : $all_users['job']  ,
                "score" =>  $all_users['rate'],
                "status" => $this->relativeTime($all_users['last_login']) ,
                "baseskill" => (isset($skills['baseskill'])) ? $skills['baseskill']:"" ,
                "skills" => (isset($skills['skills'])) ? $skills['skills']:"" ,
                "experts" => (isset($skills['experts'])) ? $skills['experts']:"" ,         
                "livelocation" => (is_null($all_users['live'])) ? '' : $all_users['live']  ,
                "fromlocation" => (is_null($all_users['born'])) ? '' : $all_users['born']  ,  
                "flag" => strtolower($all_users['liveflag']),
                "education" => (isset($resumes['education'])) ? $resumes['education']:"" ,
                "resume" => (isset($resumes['resume'])) ? $resumes['resume']:"" ,
                "languages" => $all_users['languages'],         
                "gender"  => intval( $all_users['gender']),
                'private' => intval(0),
                'video'=>$video
            );
       // echo json_encode(array('users'=> $users));

        //-----------------       
        //***** load components
        $data = array(

            'menus' => $this->load->view("component/menu","",true),
            'dashbord' => $this->load->view("component/".$user_profile_info['category']."/dashbord","",true),
            'content' => $this->load->view("component/".$user_profile_info['category']."/profile/profile",array('pageinfo' => $users),true),
            'search' => $this->load->view("component/search","",true),

            ); 
   
        $this->load->view('layout/tpl_profile_fa',$data);
    }

        //******************************************
    private function userresume($user_id)
    {
        if( isset($user_id))
        {
            $result="";
            $resume=$this->user_model->get_user_resumes_by_user_id($user_id);   
               
            if(is_array($resume)){  
                //$resume = array_slice($startup,0, 3);         
                foreach ($resume as $key => $value){
                     if($value['type']==1 and $value['security']==0)
                    $result['education'][]= $value;
                    else
                    $result['resume'][]= $value;                 
                }
                return $result;
            }else
            {
                $result[]="";
                return  $result;
            }
            
        }   
    }
    private function userskill($user_id)
    {
        if( isset($user_id))
        {
            $result="";
            $skill=$this->user_model->get_user_skills_by_id($user_id);   
              
            if(is_array($skill)){
               // $skill = array_slice($skill,0, 3);           
                foreach ($skill as $key => $value){
                    if($value['skilltype']==0 and $value['security']==0)
                    $result['baseskill'][]= $value;
                    elseif ($value['skilltype']==1 and $value['security']==0) {
                        $result['skills'][]= $value;
                    }elseif ($value['skilltype']==2 and $value['security']==0) {
                         $result['experts'][]= $value;
                    }
                             
                }
                return $result;
            }else
            {
                $result[]="";
                return  $result;
            }
            
        }   
    }

    private function relativeTime($time, $short = false){
        $SECOND = 1;
        $MINUTE = 60 * $SECOND;
        $HOUR = 60 * $MINUTE;
        $DAY = 24 * $HOUR;
        $MONTH = 30 * $DAY;
        $before = time() - $time;

        if ($before < 0)
        {
            return "not yet";
        }

        if ($short){
            if ($before < 1 * $MINUTE)
            {
                return ($before <5) ? " just " : $before . " ago ";
            }

            if ($before < 2 * $MINUTE)
            {
                return "1 Min ago ";
            }

            if ($before < 45 * $MINUTE)
            {
                return floor($before / 60) . " Min ago ";
            }

            if ($before < 90 * $MINUTE)
            {
                return "1 Hour ago";
            }

            if ($before < 24 * $HOUR)
            {

                return floor($before / 60 / 60). " Hour ago ";
            }

            if ($before < 48 * $HOUR)
            {
                return "1 Day ago";
            }

            if ($before < 30 * $DAY)
            {
                return floor($before / 60 / 60 / 24) . " Day ago ";
            }


            if ($before < 12 * $MONTH)
            {
                $months = floor($before / 60 / 60 / 24 / 30);
                return $months <= 1 ? "1 month ago " : $months . " Month ago ";
            }
            else
            {
                $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
                return $years <= 1 ? "1 year ago " : $years." Year ago ";
            }
        }

        if ($before < 1 * $MINUTE)
        {
            return ($before <= 1) ? " Online " : $before . " Second ago ";
        }

        if ($before < 2 * $MINUTE)
        {
            return "one minute ago";
        }

        if ($before < 45 * $MINUTE)
        {
            return floor($before / 60) . " Minute ago ";
        }

        if ($before < 90 * $MINUTE)
        {
            return " One Hour ago ";
        }

        if ($before < 24 * $HOUR)
        {

            return (floor($before / 60 / 60) == 1 ? '  One Hour ' : floor($before / 60 / 60).' Hour '). " ago ";
        }

        if ($before < 48 * $HOUR)
        {
            return " Day ";
        }

        if ($before < 30 * $DAY)
        {
            return floor($before / 60 / 60 / 24) . " Day ago ";
        }

        if ($before < 12 * $MONTH)
        {

            $months = floor($before / 60 / 60 / 24 / 30);
            return $months <= 1 ? " One Month ago " : $months . " Month ago";
        }
        else
        {
            $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
            return $years <= 1 ? " One Year ago " : $years." Year ago";
        }

        return "$time";
    }

    protected function displayPageNotFound() {
        $this->output->set_status_header('404');
        $this->load->view('page_not_found');
    }
}