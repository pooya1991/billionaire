<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Syn_Base {


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
        $this->load->model('modules/location');
        chdir('../');
    }
    public function index()
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
        /* Email Validation */
        if ($user_info['ownuserkey']!= $this->session->userdata('synlogged_in')['userkey']) {
        $error[] = "hehe...!";
        }
        /* Email Validation */
        if (empty($user_info["keyword"])) {
        $error[] = "keyword problem...";
        }
        //*******don't have error*****
        if (!is_array($error)) {
            switch ($data=$user_info["keyword"]) {
                case 'address':
                    $data=$this->addressbykey($user_info["userkey"]);
                    break;
                case 'phone':
                    $data=$this->numberbykey($user_info["userkey"]);
                    break;
                case 'web':
                     $data=$this->webbykey($user_info["userkey"]);
                    break;
                case 'massage':
                    $data=$this->emailbykey($user_info["userkey"]);
                    break;
                
                default:
                    $error[]="incoret parameter...";
                    break;
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
    private function addressbykey($userkey)
    {
       $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
            $user_info=$this->user->get_user_info_by_key($userkey);
            if(is_array( $user_info))
            {
                $contacts=$this->user_model->get_user_contacts_by_user_id($user_info['user_id'],'address');
                if(is_array( $contacts)){

                    foreach ($contacts as $key => $value) {
                            $usercontacts[$key] = array( 
                               "key"=>$value['id'],
                                "userkey"=>$user_info['userkey'],
                                "value"=>$value['value'],
                                "type"=>$value['category'],
                                "date_create"=> $value['create_date'],
                                "date_modified"=> $value['modify_date'],
                                "premission"=>intval($value['security']),
                        );
                       if(!is_null($value['location'])) $usercontacts[$key]['location']=$value['location'];
                       if(!is_null($value['latlong'])) $usercontacts[$key]['locationlatlong']=$value['latlong'];
                    }              
                    
                }
            }
            if(isset($usercontacts))
            return $usercontacts; 
    }

   private function numberbykey($userkey)
    {
       $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
            //$visitor_id= $this->user_model->get_user_id_from_userkey($_POST['userkey']);
            $user_info=$this->user->get_user_info_by_key($userkey);
            if(is_array( $user_info))
            {
                $contacts=$this->user_model->get_user_contacts_by_user_id($user_info['user_id'],'number');
                if(is_array( $contacts)){

                    foreach ($contacts as $key => $value) {
                        if ($value['security']==0) 
                            $usercontacts[$key] = array( 
                               "key"=>$value['id'],
                               // "userkey"=>$user_info['userkey'],
                                "value"=>$value['value'],
                                "type"=>$value['category'],
                               // "date_create"=> $value['create_date'],
                               // "date_modified"=> $value['modify_date'],
                               // "premission"=>intval($value['security']
                        );
                      
                    }              
                    
                }
            }
            if(isset($usercontacts))
            return $usercontacts; 
    }

   private function webbykey($userkey)
    {
       $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
            $user_info=$this->user->get_user_info_by_key($userkey);
            if(is_array( $user_info))
            {
                $contacts=$this->user_model->get_user_contacts_by_user_id($user_info['user_id'],'web');
                if(is_array( $contacts)){

                    foreach ($contacts as $key => $value) {
                        if ($value['security']==0) 
                            $usercontacts[$key] = array( 
                               "key"=>$value['id'],
                               // "userkey"=>$user_info['userkey'],
                                "value"=>$value['value'],
                                "type"=>$value['category'],
                               // "date_create"=> $value['create_date'],
                               // "date_modified"=> $value['modify_date'],
                               // "premission"=>intval($value['security']
                        );
                    }                 
                }
            }
            if(isset($usercontacts))
            return $usercontacts; 
    }

   private function socialbykey($userkey)
    {
       $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
            //$visitor_id= $this->user_model->get_user_id_from_userkey($_POST['userkey']);
            $user_info=$this->user->get_user_info_by_key($userkey);
            if(is_array( $user_info))
            {
                $contacts=$this->user_model->get_user_contacts_by_user_id($user_info['user_id'],'social');
                if(is_array( $contacts)){

                    foreach ($contacts as $key => $value) {
                        if ($value['security']==0) 
                            $usercontacts[$key] = array( 
                               "key"=>$value['id'],
                               // "userkey"=>$user_info['userkey'],
                                "value"=>$value['value'],
                                "type"=>$value['category'],
                               // "date_create"=> $value['create_date'],
                               // "date_modified"=> $value['modify_date'],
                               // "premission"=>intval($value['security']
                        );
                    }              
                    
                }
            }
            if(isset($usercontacts))
            return $usercontacts;   
    }
   private function emailbykey($userkey)
    {
       $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
            //$visitor_id= $this->user_model->get_user_id_from_userkey($_POST['userkey']);
            $user_info=$this->user->get_user_info_by_key($userkey);
            if(is_array( $user_info))
            {
                $contacts=$this->user_model->get_user_contacts_by_user_id($user_info['user_id'],'email');
                if(is_array( $contacts)){

                    foreach ($contacts as $key => $value) {
                        if ($value['security']==0) 
                            $usercontacts[$key] = array( 
                               "key"=>$value['id'],
                               // "userkey"=>$user_info['userkey'],
                                "value"=>$value['value'],
                                "type"=>$value['category'],
                               // "date_create"=> $value['create_date'],
                               // "date_modified"=> $value['modify_date'],
                               // "premission"=>intval($value['security']
                        );
                    }              
                    
                }
            }
            if(isset($usercontacts))
            return $usercontacts;  
    }

    private function addaddress()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if($user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'address',  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );

            $contact_id =$this->user_model->insert_user_contact($contact_info);
            //-----------add locations--------
           if(isset($_POST['location']))
            { 
                if(isset($_POST['latlong']))
                {
                    $address="";
                    $_POST['latlong']=str_replace('(', '',$_POST['latlong']);
                    $_POST['latlong']=str_replace(')', '',$_POST['latlong']);
                    $address[0] = array(
                                'refrence_id' => $contact_id,
                                'type' => 'contact',
                                'title' => $_POST['location'] ,
                                'latlong' => $_POST['latlong'],
                                'category' => $_POST['city'],
                                'security'=>$_POST['premission']
                                );
                }else
                {
                    $pizza= $_POST['location'];
                    $pieces = explode("##", $pizza);
                    foreach ($pieces as $key => $value) {
                        $title=$value;
                        $value = preg_replace('/\s+/', '', $value);
                        if(isset($value)){  
                            $locatin=$this->location->get_latlong_by_location($value);
                            $address[$key] = array(
                                'refrence_id' => $contact_id,
                                'type' => 'contact',
                                'title' => $title ,
                                'latlong' => (isset($locatin['latlong'])) ? $locatin['latlong'] :"",
                                'category' => $_POST['city'],
                                'security'=>$_POST['premission']
                                );
                        }      
                    }
                }
                $this->user_model->insert_user_address($address);    
            }
          
         echo json_encode(array('key'=>$contact_id)); 
          
        }   
    }
    public function updateaddress()
    {   
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if( $user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'address',  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );


            $contact_id =$this->user_model->update_user_contact($contact_info, $_POST['key'],$user_id);
            $this->user_model->delete_user_contact_location($_POST['key']);            
            //-----------add locations--------
            if(isset($_POST['location']))
            { 
                if(isset($_POST['latlong']))
                {
                    $address="";
                    $_POST['latlong']=str_replace('(', '',$_POST['latlong']);
                    $_POST['latlong']=str_replace(')', '',$_POST['latlong']);
                    $address[0] = array(
                                'refrence_id' => $_POST['key'],
                                'type' => 'contact',
                                'title' => $_POST['location'] ,
                                'latlong' => $_POST['latlong'],
                                'category' => $_POST['city'],
                                'security'=>$_POST['premission']
                                );
                }else
                {
                    $pizza= $_POST['location'];
                    $pieces = explode("##", $pizza);
                    foreach ($pieces as $key => $value) {
                        $title=$value;
                        $value = preg_replace('/\s+/', '', $value);
                        if(isset($value)){  
                            $locatin=$this->location->get_latlong_by_location($value);
                            $address[$key] = array(
                                'refrence_id' => $_POST['key'],
                                'type' => 'resume',
                                'title' => $title ,
                                'latlong' => (isset($locatin['latlong'])) ? $locatin['latlong'] :"",
                                'category' => $_POST['city'],
                                'security'=>$_POST['premission']
                                );
                        }      
                    }
                }
                $this->user_model->insert_user_address($address);
            }

                     echo json_encode(array('key'=>$_POST['key']));  
        }
 
    }

    public function addnumber()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if($user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'number', 
                    "category" => $_POST['type'],  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );

            $contact_id =$this->user_model->insert_user_contact($contact_info);

            echo json_encode(array('key'=>$contact_id)); 
          
        }   
    }
    public function updatenumber()
    {   
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if( $user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'number',
                    "category" => $_POST['type'],  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );


            $contact_id =$this->user_model->update_user_contact($contact_info, $_POST['key'],$user_id);

            echo json_encode(array('key'=>$_POST['key']));  
        }
 
    }
   public function addweb()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if($user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'web', 
                    "category" => 'website',  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );

            $contact_id =$this->user_model->insert_user_contact($contact_info);

            echo json_encode(array('key'=>$contact_id)); 
          
        }   
    }
    public function updateweb()
    {   
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if( $user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'web',
                    "category" => $_POST['type'],  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );


            $contact_id =$this->user_model->update_user_contact($contact_info, $_POST['key'],$user_id);

            echo json_encode(array('key'=>$_POST['key']));  
        }
 
    }
   public function addsocial()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if($user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'social', 
                    "category" => $_POST['type'],  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );

            $contact_id =$this->user_model->insert_user_contact($contact_info);

            echo json_encode(array('key'=>$contact_id)); 
          
        }   
    }
    public function updatesocial()
    {   
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if( $user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'social',
                    "category" => $_POST['type'],  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );


            $contact_id =$this->user_model->update_user_contact($contact_info, $_POST['key'],$user_id);

            echo json_encode(array('key'=>$_POST['key']));  
        }
 
    }
   public function addemail()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if($user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'email',  
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );

            $contact_id =$this->user_model->insert_user_contact($contact_info);

            echo json_encode(array('key'=>$contact_id)); 
          
        }   
    }
    public function updateemail()
    {   
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if( $user_id)
        {
            $contact_info = array( 
                    "user_id" => $user_id,
                    "value" => $_POST['value'],
                    "type" => 'email', 
                    "create_date"  => date('Y-m-j H:i:s'),
                    "security"=>$_POST['premission']
                );


            $contact_id =$this->user_model->update_user_contact($contact_info, $_POST['key'],$user_id);

            echo json_encode(array('key'=>$_POST['key']));  
        }
 
    }
    public function deletecontact()
    {
         $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        header('Content-type: application/json; charset=utf-8');
        $user_id=$this->check_login();
        if( $user_id)
        {
            
            $contact_id =$this->user_model->delete_user_contact($_POST['key'],$user_id);
            if($contact_id)
            {
                $this->user_model->delete_user_contact_location($_POST['key']);
                echo json_encode(1);
            }
           
            
        }     
    }
//---------------------------------------------------------

public function uploadimg($pic)
{
    if(!isset($pic))
    {
            return "error";
            die("error");
    } 
    $json = file_get_contents('php://input');
    $obj = json_decode($json , true);
    header('Content-type: application/json; charset=utf-8');
    $date = new DateTime();
    $result = $date->format('YmdHis');
    $output_file=$result.$this->generateRandomString().".png";
    $uploaddir = getcwd().'/msa/users/'.$_POST["ownuserkey"].'/images/'; 
    $file = $uploaddir .$output_file; 
    $ifp = fopen($file, "X+"); 
    $data = $pic;
    $ok=fwrite($ifp, base64_decode($data)); 
    fclose($ifp);  
    
      if($ok) { 
        
         return $output_file; 
        }
        else{
            return false;
        }  

    
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
  




}