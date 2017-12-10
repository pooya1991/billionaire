<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {


    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http => //example.com/index.php/welcome
     *  - or -
     *      http => //example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http => //example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http => //codeigniter.com/user_guide/general/urls.html
     */
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
        $this->load->library(array('session'));     
        $this->load->model('component/user_model');
        $this->load->model('component/logedin');
        $this->load->model('modules/user');
    }
    public function index()
    {
        
        

    }
    /**
     * check_login function.
     * 
     * @access public
     * @return void
     */
    private function check_login()
    {
         if(isset($_POST)){

            // set user info
            $login_info = array(

                'device_id'=> $_POST['logindevice'],
                'user_id'    => $this->user_model->get_user_info_from_email($_POST['loginemail'])['user_id'],
                'login_key' => $_POST['loginkey']
            );
            $loginresult= $this->user_model->check_user_session($login_info);
            if (is_array($loginresult)) {

                return $login_info['user_id'];
            }
            else
            {
                return false;
            }
        }
        
    }

    public function addfeedback()
    {
        header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
        'value' => (isset($_POST["data"]['value'])) ? $_POST["data"]['value'] : "" ,
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

             $feedback_info = array( 
                    "user_id"=>  $user_id,
                    "comment"=> $user_info['value'],
                    "category"=> 'feedback',
                    //"device"=> $_POST['type'],
                );

            $this->user_model->insert_user_feedback($feedback_info);
   
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
   
   public function addproblem()
    {
         header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
        'value' => (isset($_POST["data"]['value'])) ? $_POST["data"]['value'] : "" ,
        'subject' => (isset($_POST["data"]['subject'])) ? $_POST["data"]['subject'] : "" ,
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

            $problem_info=array(
            "user_id" => $user_id,
            "comment" => $user_info['value'],
            "subject" => $user_info['subject'],
            //"category" => $_POST['cat'],  
            // "version"  => $_POST['version'],
            // "phone_brand"  => $_POST['brand'],
            // "os"=>$_POST['os'],
            "date"=>date('Y-m-j H:i:s')
            );


            $this->user_model->insert_user_problem($problem_info);

   
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
   

}