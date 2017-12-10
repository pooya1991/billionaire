<?php
Class Logedin extends CI_Model
{


      // $data = array('name' => $name, 'email' => $email, 'url' => $url);

      // $where = "author_id = 1 AND status = 'active'";

      // $str = $this->db->update_string('table_name', $data, $where);

 function set_auto_login($data)
 {
   $str = array('key_id' => $data[1],
                'user_id' => $data[2],
                'user_agent' => $data[0],
                'last_ip' => $data[3],
                'last_login' => $data[4]
                 );
    $str = $this->db->insert_string('autologin', $str);
    $str=$this->db->query($str);
   if($str)
   {
     return $str;
   }
   else
   {
     return false;
   }
 }
 //*****************
 function set_login_session($data)
 {
   $str = array('session_id' => $data[0],
                'ip_address' => $data[1],
                'user_agent' => $data[2],
                'last_activity' => $data[3],
                'user_data' => $data[4],
                'is_online' => $data[5],
                'last_online' => $data[6],
                 );
    $str = $this->db->insert_string('sessions', $str);
    $str=$this->db->query($str);
   if($str)
   {
     return $str;
   }
   else
   {
     return false;
   }
 }
 //******************`user_id`, `ip_address`, `login`, `time`
  function set_login_attempts($data)
 {
   $str = array(
                'ip_address' => $data[2],
                'login' => $data[1],
                'time' => $data[3],
                'user_id' => $data[0]
                 );
    $str = $this->db->insert_string('login_attempts', $str);
    $str=$this->db->query($str);
   if($str)
   {
     return $str;
   }
   else
   {
     return false;
   }
 }



}
?>