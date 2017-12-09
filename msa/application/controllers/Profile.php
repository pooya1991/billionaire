<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Bil_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('component/user_model');
        $this->load->model('component/logedin');
        $this->load->model('modules/user'); 
        $this->load->library('imgresize');
    }
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
        $user_profile_info=$this->user_model->get_user_full_info_by_userkey($link);
        $displayname=$this->session->userdata('billogged_in')['firstname'];
        $profile_pic=$this->session->userdata('billogged_in')['pic'];
        if(isset($profile_pic)){
            $profile_pic=$this->session->userdata('billogged_in')['pic'];
        }else{
            $profile_pic='defaultm.png';
        }

         $profile_account = array(
            'menu' => '',
            'link'=> $this->session->userdata('billogged_in')['userkey'],
            'username'=> $username,
            'displayname'=> $this->session->userdata('billogged_in')['firstname']." ".$this->session->userdata('billogged_in')['lastname'],
            'profile_pic' => $profile_pic       
        );
        $data = array(

             'userinfo' => $user_profile_info,
             'userrisk'=>$this->user_model->get_user_risk($user_profile_info['user_id'])[0]
        ); 

        $this->load->view('layout/header',$profile_account);
        $this->load->view('pages/profile',$data);
        $this->load->view('layout/footer',true);
            
    }
        public function save_user_risk()
    {
        header('Content-type: application/json; charset=utf-8');
        $error=$data="";
        $user_info = array(
            'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "" ,
            'target' => (isset($_POST["data"]['target'])) ? $_POST["data"]['target'] : "" ,
            'up' => (isset($_POST["data"]['up'])) ? $_POST["data"]['up'] : "" ,
            'down' => (isset($_POST["data"]['down'])) ? $_POST["data"]['down'] : "" ,
            'number' => (isset($_POST["data"]['number'])) ? $_POST["data"]['number'] : "" ,
            'year' => (isset($_POST["data"]['year'])) ? $_POST["data"]['year'] : "" ,
            'month' => (isset($_POST["data"]['month'])) ? $_POST["data"]['month'] : "" ,
            'day' => (isset($_POST["data"]['day'])) ? $_POST["data"]['day'] : "" ,
            'amount' => (isset($_POST["data"]['amount'])) ? $_POST["data"]['amount'] : "" ,
            'retirement' => (isset($_POST["data"]['retierment'])) ? $_POST["data"]['retierment'] : "" ,
            'discription' => (isset($_POST["data"]['discription'])) ? $_POST["data"]['discription'] : "" 
        );
       
        $link=$this->session->userdata('billogged_in')['userkey'];
        if ($user_info['userkey']!=$link) {
            $error[] = "hehe...!";
        }
        
        //*******don't have error*****
        if (!is_array($error)) {
            $user_profile_info=$this->user_model->get_user_full_info_by_userkey($link);
            $birthday="";
            if($user_info['year']!="" and $user_info['month']!="" and $user_info['day']!="")
             $birthday=$this->jdf->jalali_to_gregorian($user_info['year'],$user_info['month'],$user_info['day'],'-');
             $target="";
             if(is_array($user_info['target']))
             foreach ($user_info['target'] as $key => $value) {
                 $target.=$value."&";
             }
            $riskinfo = array(
                'user_id' => $user_profile_info['user_id'],
                'risk_number' => $user_info['number'],
                'up_number' => $user_info['up'],
                'down_number' => $user_info['down'],
                'targets' => $target,
                'discription' => $user_info['discription'],
                'birthday' => $birthday,
                'retirement' => $user_info['retirement'],
                'cash' => $user_info['amount'],
             );
           if($this->user_model->insert_user_risk($riskinfo))
           {
            $data='success';
           }else
           {
                $error[]="Save error..";
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
        echo json_encode(array('result'=>$result));
    }
   
















    protected function display_profile($user_profile_info) 
    {
        $userkey= $user_profile_info['userkey'];//*********
        $ownuserkey= $this->session->userdata('synlogged_in')['userkey'];//*********
        $visitor_id= $this->user_model->get_user_id_from_userkey($ownuserkey);
        $all_users=$this->user->get_user_info_by_key($userkey);
        $secender= $this->user_model->get_user_secender_by_id($all_users['user_id']);
        $follower= $this->user_model->get_user_follower_by_id($all_users['user_id']);
        $following= $this->user_model->get_user_following_by_id($all_users['user_id']);
        $confirmd=$this->user_model->get_user_confirmd_by_id($all_users['user_id']);

        if( $all_users['pic']=='defaultsh.png' or $all_users['pic']=='defaultf.png' or $all_users['pic']=='defaultm.png'){
            $user_img= base_url().'img/profile/'.$all_users['pic'];
        }else
        {
            $user_img= base_url().'users/'.$all_users['userkey'].'/images/'.$all_users['pic'];
        }
        $skills=$this->userskill($all_users['user_id']);
        $resumes=$this->userresume($all_users['user_id']);

        if (strlen($all_users['description']) > 250)
            $all_users['description'] = substr($all_users['description'], 0, 250) . '...';

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
                "description" =>$all_users['description'],
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
                'video' => $video
            );
       // echo json_encode(array('users'=> $users));

        $profile_pic=$this->session->userdata('synlogged_in')['pic'];

         $profile_account = array(
            'link'=> $this->session->userdata('synlogged_in')['userkey'],
            'username'=> $this->session->userdata('synlogged_in')['username'],
            'displayname'=> $this->session->userdata('synlogged_in')['firstname'],
            'profile_pic' => $this->session->userdata('synlogged_in')['pic']       
        );
        //$Data = json_decode(file_get_contents('http://freegeoip.net/json/31.58.48.162'),true);
        // $Data["country_code"]
       // print_r($Data);
        $countrylist= $this->load->view("component/country","",true);
        //-----------------       
        //***** load components
        $data = array(
            'link'=> $this->session->userdata('synlogged_in')['userkey'],
            'menus' => $this->load->view("component/".$this->userinfo['type']."/menu","",true),
            // 'sitesetting' => $this->load->view("component/".$this->userinfo['type']."/site_setting","",true),
            'login' => $this->load->view("component/".$this->userinfo['type']."/profile_account",$profile_account,true),
            'dashbord' => $this->load->view("component/".$this->userinfo['type']."/dashbord","",true),
            'content' => $this->load->view("component/".$this->userinfo['type']."/profile/profile",array('pageinfo' => $users),true),
            'search' => $this->load->view("component/search","",true),
            'profile_setting' => $this->load->view("component/".$this->userinfo['type']."/profile_setting","",true),
            //'notifactions' => $this->load->view("component/".$this->userinfo['type']."/notifactions","",true),
            ); 
   
        $this->load->view('layout/tpl_profile_fa',$data);
    }

 //**************************************************************************************
    public function updateprofileinfo()
    {
        header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
        'fname' => (isset($_POST["data"]['fname'])) ? $_POST["data"]['fname'] : "" ,
        'lname' => (isset($_POST["data"]['lname'])) ? $_POST["data"]['lname'] : "" ,
        'job' => (isset($_POST["data"]['job'])) ? $_POST["data"]['job'] : "" ,
        'birthday' => (isset($_POST["data"]['birthday'])) ? $_POST["data"]['birthday'] : "" ,
        'gender' => (isset($_POST["data"]['gender'])) ? $_POST["data"]['gender'] : "" ,
        'livelocation' => (isset($_POST["data"]['livelocation'])) ? $_POST["data"]['livelocation'] : "" ,
        'livepermission' => (isset($_POST["data"]['livepermission'])) ? $_POST["data"]['livepermission'] : "" ,
        'livelatlong' => (isset($_POST["data"]['livelatlong'])) ? $_POST["data"]['livelatlong'] : "" ,
        'fromlocation' => (isset($_POST["data"]['fromlocation'])) ? $_POST["data"]['fromlocation'] : "" ,
        'fromlatlong' => (isset($_POST["data"]['fromlatlong'])) ? $_POST["data"]['fromlatlong'] : "" ,
        'formpermission' => (isset($_POST["data"]['formpermission'])) ? $_POST["data"]['formpermission'] : "" ,
        'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "" ,
        'ownuserkey' => (isset($_POST["data"]['ownuserkey'])) ? $_POST["data"]['ownuserkey'] : "" ,
        );
        /* Email Validation */
        if ($user_info['ownuserkey']!= $this->session->userdata('synlogged_in')['userkey']) {
        $error[] = "hehe...!";
        }else
        {
            $user_id= $this->user_model->get_user_id_from_userkey($user_info['ownuserkey']);
        }
        //*******don't have error*****
        if (!is_array($error)) {
            $basic_info = array( 
                "user_id" => $user_id,
                "firstname" => $user_info['fname'],
                "lastname" => $user_info['lname'],
                "birthday" =>  $user_info['birthday'],
                "job" =>  $user_info['job'],              
                "marital"=> 0,
                "gender"  => $user_info['gender'],
                "birthday_p"=>0,
                "marital_p"=>0
                );
            $this->user_model->update_user_profile($basic_info);
            //-----------add locations--------
            
            if(isset($user_info['livelatlong']))
            { 
                $liveaddress="";
                $user_info['livelatlong']=str_replace('(', '',$user_info['livelatlong']);
                $user_info['livelatlong']=str_replace(')', '',$user_info['livelatlong']);
                $liveaddress[0] = array(
                            'refrence_id' => $user_id,
                            'type' => 'hometown',
                            'title' => $user_info['livelocation'] ,
                            'latlong' => $user_info['livelatlong'],
                            //'category' => $_POST['livesin_city'],
                            'security'=>$user_info['livepermission'],
                            //'iso'=>$_POST['livesin_iso']
                            );
            $this->user_model->delete_user_location_hometown($user_id);    
            $this->user_model->insert_user_address($liveaddress);
            }
            
            if(isset($user_info['fromlatlong']))
            { 
                    $fromaddress="";
                    $user_info['fromlatlong']=str_replace('(', '',$user_info['fromlatlong']);
                    $user_info['fromlatlong']=str_replace(')', '',$user_info['fromlatlong']);
                    $fromaddress[0] = array(
                                'refrence_id' => $user_id,
                                'type' => 'from',
                                'title' => $user_info['fromlocation'] ,
                                'latlong' => $user_info['fromlatlong'],
                               // 'category' => $user_info['livepermission'],
                                'security'=>$user_info['formpermission']                          
                                );
                $this->user_model->delete_user_location_from($user_id);
                $this->user_model->insert_user_address($fromaddress);
            }
            $data="ok";
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

    public function addcontact()
    {
        header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
        'title' => (isset($_POST["data"]['title'])) ? $_POST["data"]['title'] : "" ,
        'type' => (isset($_POST["data"]['type'])) ? $_POST["data"]['type'] : "" ,
        'permission' => (isset($_POST["data"]['permission'])) ? $_POST["data"]['permission'] : "" ,
        'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "" ,
        'ownuserkey' => (isset($_POST["data"]['ownuserkey'])) ? $_POST["data"]['ownuserkey'] : "" ,
        );
        /* Email Validation */
        if ($user_info['ownuserkey']!= $this->session->userdata('synlogged_in')['userkey']) {
        $error[] = "hehe...!";
        }else
        {
            $user_id= $this->user_model->get_user_id_from_userkey($user_info['ownuserkey']);
        }
        //*******don't have error*****
        if (!is_array($error)) {
             $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $user_info['title'],
                    "type" => $user_info['type'], 
                   // "category" => $_POST['type'],  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$user_info['permission']
                );

            $contact_id =$this->user_model->insert_user_contact($contact_info);    
            $data="ok";
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


  //***************************************************************************************  
  public function uploadimg()
{
    header('Content-type: application/json; charset=utf-8');
    $error=$data="";
    $filetype = array('jpeg','jpg','png','gif','PNG','JPEG','JPG');
    $type=explode("/", $_FILES['image']['type']);
    if(in_array($type[1], $filetype)){
    $file = $_FILES['image']['tmp_name'];
    //indicate the path and name for the new resized file
    $filepath='users/'.$this->session->userdata('synlogged_in')['userkey'].'/images/';
    $resizedFile =  time().$_FILES['image']['name'];
    //call the function (when passing path to pic)
    $this->imgresize->smart_resize_image($file , null, 400 , 400 , false , $filepath.$resizedFile , false , false ,100 );
    
        $data = array(
        'url' => base_url($filepath.$resizedFile),
        'name'=> $resizedFile
        );

    }
    else{
        $error[]='error';
    }

    $result = array(
            'error' =>  (is_array($error)) ? 1 : 0 ,
            'error_detalis'=>$error,
            'data'=>$data
             );
    echo json_encode(array('result'=>$result));
 } 
 //**************************update profile pic************************************
 public function updateprofileimage()
    {
        header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
        'img' => (isset($_POST["data"]['img'])) ? $_POST["data"]['img'] : "" ,
        'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "" ,
        'ownuserkey' => (isset($_POST["data"]['ownuserkey'])) ? $_POST["data"]['ownuserkey'] : "" ,
        );
        /* Email Validation */
        if ($user_info['ownuserkey']!= $this->session->userdata('synlogged_in')['userkey']) {
        $error[] = "hehe...!";
        }else
        {
            $user_id= $this->user->get_user_info_by_key($user_info['ownuserkey']);
        }
        //*******don't have error*****
        $img="";
        if($user_info['img']=='default')
        {
            if( $user_id['gender']==0){
                $user_info['img']='defaultm.png';
            }elseif( $user_id['gender']==1)
            {
                $user_info['img']='defaultf.png';   
            }elseif( $user_id['gender']==2)
            {
                $user_info['img']='defaultsh.png';  
            }
             $img=base_url().'img/profile/'.$user_info['img'];
        }else{
            
            $img=base_url().'users/'.$this->session->userdata('synlogged_in')['userkey'].'/images/'.$user_info['img'];
        }
        if (!is_array($error)) {
            $basic_info = array( 
                "id" => $user_id['user_id'],
                "pic" => $user_info['img']
                );
            $this->user_model->update_user_profile_pic($basic_info);
            $this->session->set_userdata('pic', $img);
            $data="ok";
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
    private function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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


}