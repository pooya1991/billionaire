<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($data,$userkey,$username, $email, $password,$phone,$pic) {
		$link=$this->hash_password(date('Y-m-j H:i:s').$data['email']);
		$clear = trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($link))))));
		$info = array(
			'username'   => $data['username'],
			'userkey' => $data['userkey'],
			'email'      => $data['email'],
			'password'   => $this->hash_password($data['password']),
			'created' => date('Y-m-j H:i:s'),
			'confirm_key'=>$clear,
			'pic' =>$data['pic'],
			'register_phone'=> $data['phone'],
			'category'=>$data['category']
		);
		
		$this->db->insert('user', $info);
        $id = $this->db->insert_id();
        $this->db->from('user');
        $this->db->where('id', $id);
        $query = $this ->db->get();
        if($query->num_rows() == 1){
            $this->sendEmail($info);
            return $query->result_array()[0];
        }
        else{
         return false;
        }
		
	}
	private function sendEmail($to_email)
    	{
    	$this->load->library('email');
        $from_email = 'info@synskill.com'; //change this to yours
        $subject = 'Verify Your Email Address';
        $message = 'Dear User,<br /><br />Please click on the below activation link to verify your email address.<br /><br />'.base_url().'api/actions/verify/index/' . $to_email['confirm_key'] . '<br /><br /><br />Thanks<br />synskill Team';
        
        //configure email settings
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->email->initialize($config);
        
        //send mail
        $this->email->from($from_email, 'synskill');
        $this->email->to($to_email['email']);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();  			 
    }
    public function send_password_to_email($to_email)
    	{
    	$this->load->library('email');
        $from_email = 'info@synskill.com'; //change this to yours
        $subject = 'SYNSKILL--Reset password';
        $message = 'Dear User,<br /><br />Please click on the below reset password link to reset your account password.<br /><br />'.base_url().'api/verify/index/' . $to_email . '<br /><br /><br />Thanks<br />synskill Team';
        
        //configure email settings
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->email->initialize($config);
        
        //send mail
        $this->email->from($from_email, 'synskill');
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();  			 
    }
    /**
	 * check_email_exist function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function check_email_exist($email) {
		
		$this->db->from('user');
		$this->db->where('email', $email);
		$query = $this ->db->get();
		if($query->num_rows() == 1){
		 return True;
		}
		else{
		 return False;
		}
		
	}

	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {
		
		$this->db->select('password');
		$this->db->from('user');
		$this->db->where('email', $username);
		$hash = $this->db->get()->row('password');		
		return $this->verify_password_hash($password, $hash);
		
	}
    /**
	 * check_user_session function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function check_user_session($info) {
		
		$this->db->from('sessions');
		$this->db->where('device_id', $info['device_id']);
		$this->db->where('user_id', $info['user_id']);
		$this->db->where('login_key', $info['login_key']);
		$query = $this ->db->get();
		if($query->num_rows() >= 1){
		 return $query->result_array();
		}
		else{
		 return False;
		}
		
	}
/**
	 * set_user_app_session function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function set_user_app_session($data) {
				
	$this->db->insert_batch('sessions', $data);
	$id = $this->db->insert_id();
		$this->db->from('sessions');
		$this->db->join('user' , 'sessions.user_id = user.id');
		$this->db->where('sessions.id', $id);
		$query = $this ->db->get();
		if($query->num_rows() == 1){
		 	return $query->result_array();
		}
		 		
	}
	/* update_user_profile function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_app_session($data) {
				
		$this->db->where('user_id',$data['user_id']);
		return $this->db->update('sessions', $data);
	}
	/**
	 * delete_user_app_session function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_app_session($info) {
				
		return	$this->db->delete('sessions', $info);
	}
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $email
	 * @return int the user id
	 */
	public function get_user_id_from_email($email) {
		
		$this->db->select('id');
		$this->db->from('user');
		$this->db->where('email', $email);

		return $this->db->get()->row('id');
		
	}
		/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from('user');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');
		
	}
	/**
	 * get_user_id_from_userkey function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_userkey($userkey) {
		
		$this->db->select('id');
		$this->db->from('user');
		$this->db->where('userkey', $userkey);

		return $this->db->get()->row('id');
		
	}
	/**
	 * get_user_id_from_userkey function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_info_by_username($username) {
		
	
		$this->db->from('user');
		$this->db->where('username', $username);

		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_info_from_email function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_info_from_email($email) {
		
	
		$myquery="
SELECT *
FROM `stbl_user`
JOIN stbl_user_profiles ON `stbl_user`.`id` = stbl_user_profiles.user_id
WHERE stbl_user.email = '".$email."'" ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
		
	}	
	/**
	 * get_user_id_from_userkey function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_full_info_by_username($username) {
		
	
		$this->db->from('user');
		$this->db->join('user_profiles' , 'user.id = user_profiles.user_id');
		$this->db->where('user.username', $username);

		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user info function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('user');
		$this->db->join('user_profiles' , 'user.id = user_profiles.user_id');
		$this->db->where('user.id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() == 1){
		 return $query->result();
		}
		else{
		 return false;
		}
		
	}
	
		/**
	 * save_user_info function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function save_user_info($data) {
				
	//return	$this->db->insert_batch('basicinformation', $data);
		return	$this->db->insert('user_profiles', $data);
	}

	/**
	 * add_user_visitor_by_id function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function add_user_visitor_by_id($user_id) {
				
		
		$this->db->from('user_profiles');
		$this->db->where('user_id', $user_id);
		$visitor=$this->db->get()->row('visitor');
	
		$data = array('visitor' => ($visitor+1) );
		$this->db->where('user_id', $user_id);
		$this->db->update('user_profiles', $data);
		return $visitor;
	

		 		
	}

	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		
		
		return password_verify($password, $hash);
		
		
	}

		/**
	 * check_user_active_link function.
	 * 
	 * @access public
	 * @param mixed $link
	 * @return int the user id
	 */
	public function check_update_user_active_link($link) {
		
		$this->db->select('id');
		$this->db->from('user');
		$this->db->where('confirm_key', $link);
		$id=$this->db->get()->row('id');
		if($id)
		{
			$this->db->where('id', $id);
		    $this->db->update('user', array('is_confirmed' => '1'));
		    return true;
		}
		
	}


	/**
	 * get_user_firstname_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_firstname_by_id($user_id) {
		
		$this->db->from('basicinformation');
		$this->db->where('user_id', $user_id);
		$this->db->where('type', 'Firstname');
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_base_info_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_base_info_by_id($user_id) {
		
		$this->db->from('user_profiles');
		$this->db->where('user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
		
	}

	/**
	 * get_user_contact_info_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_contact_info_by_id($user_id,$security) {
		
		$this->db->from('contact');
		$this->db->where('user_id', $user_id);
		$this->db->where('security', $security);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}


	/**
	 * get_user_quote_by_user_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_quote_by_user_id($user_id) {
		
		$this->db->select("quoted,userkey,username,pic");
		$this->db->from('quoted');
		$this->db->join('user', 'user.id = quoted.user_a');
		$this->db->where('user_b', $user_id);
		$this->db->where('pass', 1);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_picturs_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_pictures_by_id($user_id) {
		
		$this->db->from('picture');
		$this->db->where('user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_profile_picture_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_profile_picture_by_id($user_id) {
		
		$this->db->select('value');
		$this->db->from('picture');
		$this->db->where('user_id', $user_id);
		$this->db->where('type', 'profile');
		$this->db->where('del', '0');
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->row_array(1);
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_job_city_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_job_city_by_id($user_id) {
		
		$this->db->select('job.id,job.title,city.latitude,city.longitude');
		$this->db->from('job');
		$this->db->join('city', 'city.id = job.city');
		$this->db->where('user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	
	/**
	 * get_user_skill_city_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_skill_city_by_id($user_id) {
		
		$this->db->select('skills.id,skills.title,city.latitude,city.longitude');
		$this->db->from('skills');
		$this->db->join('city', 'city.id = skills.city');
		$this->db->where('user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}	
	/**
	 * get_user_skill_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_skill_by_id($user_id) {
		$this->db->select('skills.*,city.name as cityname,province.name as provincename,country.name as countryname');
		$this->db->from('skills');
		$this->db->join('city', 'city.id = skills.city');
		$this->db->join('province', 'province.id = city.province');
		$this->db->join('country', 'country.id = province.country');
		$this->db->where('user_id', $user_id);
		$this->db->order_by("date", "desc"); 
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_job_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_job_by_id($user_id) {
		$this->db->select('job.*,city.name as cityname,province.name as provincename,country.name as countryname');
		$this->db->from('job');
		$this->db->join('city', 'city.id = job.city');
		$this->db->join('province', 'province.id = city.province');
		$this->db->join('country', 'country.id = province.country');
		$this->db->where('user_id', $user_id);
		$this->db->order_by("date", "desc"); 
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_current_job_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_current_job_by_id($user_id) {
		
		$this->db->select('employer');
		$this->db->from('job');
		$this->db->where('user_id', $user_id);
		$this->db->where('stillinjob', 1);
		$this->db->order_by("date", "desc");
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
		
	}

	/**
	 * get_is_follow_users_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_is_follow_users_by_id($visitor,$pageowner) {

		$this->db->from('follow');
		$this->db->where('user_b', $visitor);
		$this->db->where('user_a', $pageowner);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 	return $query->result_array()[0]['accsept'];
		}
		else{
		 return -1;
		}
		
	}
	/**
	 * get_is_secender_users_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_is_secender_users_by_id($visitor,$pageowner) {

		$this->db->from('confirm');
		$this->db->where('user_b', $visitor);
		$this->db->where('user_a', $pageowner);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 	return $query->result_array()[0]['accsept'];
		}
		else{
		 return -1;
		}
		
	}
	/**
	 * get_is_confirmd_users_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_is_confirmd_users_by_id($visitor,$pageowner) {

		$this->db->from('confirm');
		$this->db->where('user_a', $visitor);
		$this->db->where('user_b', $pageowner);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 	return $query->result_array()[0]['accsept'];
		}
		else{
		 return -1;
		}
		
	}
/**
	 * add_follow_by_users_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function add_follow_by_users_ids($owner,$guest) {
				
		$data = array(
			'user_a' => $guest ,
			'user_b' => $owner ,
			'accsept' => "1", 
		);
		return	$this->db->insert('follow', $data);
	}
	/**
	 * delete_follow_by_users_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_follow_by_users_ids($owner,$guest) {
				
		$data = array(
			'user_a' => $guest ,
			'user_b' => $owner  
		);
		return	$this->db->delete('follow', $data);
	}
	/**
	 * get_user_following_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_following_by_id($user_id) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_follow` as c 
join (select * from stbl_user ) a on a.id=c.user_a
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_b = ".$user_id." 
and c.accsept = 1 
group by a.id
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_following_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_following_by_id_page($user_id,$page) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_follow` as c 
join (select * from stbl_user ) a on a.id=c.user_a
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_b = ".$user_id." 
and c.accsept = 1 
group by a.id
LIMIT ".$page['from']." , ".$page['to']."
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}

		/**
	 * get_user_picturs_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_follower_by_id($user_id) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_follow` as c 
join (select * from stbl_user ) a on a.id=c.user_b
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_a = ".$user_id." 
and c.accsept = 1 
group by a.id
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}
		/**
	 * get_user_picturs_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_follower_by_id_page($user_id,$page) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_follow` as c 
join (select * from stbl_user ) a on a.id=c.user_b
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_a = ".$user_id." 
and c.accsept = 1 
group by a.id
LIMIT ".$page['from']." , ".$page['to']."
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_picturs_info function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_follower_info($user_id) {
		
		$this->db->select("user_id,userkey,username,pic,firstname,lastname");
		$this->db->from('follow');
		$this->db->join('user' , 'user.id = follow.user_a');
		$this->db->join('user_profiles' , 'user.id = user_profiles.user_id');
		$this->db->where('user_b', $user_id);
		$this->db->where('accsept', 1);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}

		/**
	 * add_confirm_by_users_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function add_confirm_by_users_ids($owner,$guest) {
				
		$data = array(
			'user_a' => $guest ,
			'user_b' => $owner ,
			'accsept' => "1", 
		);
		return	$this->db->insert('confirm', $data);
	}
	/**
	 * delete_confirm_by_users_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_confirm_by_users_ids($owner,$guest) {
				
		$data = array(
			'user_a' => $guest ,
			'user_b' => $owner  
		);
		return	$this->db->delete('confirm', $data);
	}
		/**
	 * get_user_picturs_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_confirmd_by_id($user_id) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_confirm` as c 
join (select * from stbl_user ) a on a.id=c.user_a
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_b = ".$user_id." 
and c.accsept = 1 
group by a.id
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}

		
	}
		/**
	 * get_user_picturs_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_confirmd_by_id_page($user_id,$page) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_confirm` as c 
join (select * from stbl_user ) a on a.id=c.user_a
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_b = ".$user_id." 
and c.accsept = 1 
group by a.id
LIMIT ".$page['from']." , ".$page['to']."
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}

		
	}
	/**
	 * get_user_confirmd_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_secender_by_id($user_id) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_confirm` as c 
join (select * from stbl_user ) a on a.id=c.user_b
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_a = ".$user_id." 
and c.accsept = 1 
group by a.id
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_confirmd_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_secender_by_id_page($user_id,$page) {
		
		$myquery="select  c.*,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education from `stbl_confirm` as c 
join (select * from stbl_user ) a on a.id=c.user_b
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where c.user_a = ".$user_id." 
and c.accsept = 1 
group by a.id
LIMIT ".$page['from']." , ".$page['to']."
";	
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_confirmd_info function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_secender_info($user_id) {
		$this->db->select("user_id,userkey,username,pic,firstname,lastname");
		$this->db->join('user' , 'user.id = confirm.user_b');
		$this->db->join('user_profiles' , 'user.id = user_profiles.user_id');
		$this->db->from('confirm');
		$this->db->where('user_a', $user_id);
		$this->db->where('accsept', 1);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_secender_info function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_confirmd_info($user_id) {
		$this->db->select("user_id,userkey,username,pic,firstname,lastname");
		$this->db->join('user' , 'user.id = confirm.user_b');
		$this->db->join('user_profiles' , 'user.id = user_profiles.user_id');
		$this->db->from('confirm');
		$this->db->where('user_b', $user_id);
		$this->db->where('accsept', 1);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return array(
		 			'num' => $query->num_rows(), 
		 			'result'=>$query->result_array());
		}
		else{
		 return false;
		}
		
	}	
	/**
	 * add_profile_rate_users_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function add_profile_rate_users_ids($owner,$guest,$rate) {
				
		$data = array(
			'user_a' => $guest ,
			'user_b' => $owner ,
			'type' => "profile" 
		);
		$this->db->delete('rate', $data);
		$data = array(
			'user_a' => $guest ,
			'user_b' => $owner ,
			'type' => "profile", 
			'rate' => $rate
		);
		return	$this->db->insert('rate', $data);
	}
	/**
	 * add_quote_for_users_by_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function add_quote_for_users_by_ids($owner,$guest,$text) {
				
		$data = array(
			'user_a' => $guest ,
			'user_b' => $owner ,
			'quoted' => $text,
			'date' => date("Y-m-d H:i:s") 
		);
		return	$this->db->insert('quoted', $data);
	}
	/**
	 * delete_quote_by_user_id function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_quote_by_user_id($guest,$quote_id) {
				
		$data = array(
			'id' => $quote_id ,
			'user_a' => $guest 
			
		);
		return $this->db->delete('quoted', $data);
	}
	/**
	 * update_quote_pass_by_user_id function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_quote_pass_by_user_id($guest,$quote_id) {
				
		$data = array(
			'pass' => 1 			
		);
		$this->db->where('id',$quote_id);
		$this->db->where('user_a',$guest);
		return $this->db->update('quoted', $data);
	}
	/**
	 * add_suggest_for_users_by_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function add_suggest_for_users_by_ids($guest,$owner,$suggest) {
				
		$data = array(
			'guest' => $guest ,
			'owner' => $owner ,
			'suggested' => $suggest,
			'date' => date("Y-m-d H:i:s") 
		);
		return	$this->db->insert('suggest', $data);
	}
	/**
	 * add_profile_report_by_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function add_profile_report_by_ids($guest,$owner,$text) {
				
		$data = array(
			'guest' => $guest ,
			'owner' => $owner ,
			'reason' => $text,
			'date' => date("Y-m-d H:i:s") 
		);
		return	$this->db->insert('report', $data);
	}
	/**
	 * get_is_block_users_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_is_block_users_by_id($guest,$owner) {
		
		$this->db->from('block');
		$this->db->where('guest', $guest);
		$this->db->where('owner', $owner);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return 1;
		}
		else{
		 return 0;
		}
		
	}
	/**
	 * block_profile_by_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function block_profile_by_ids($guest,$owner) {
				
		$data = array(
			'guest' => $guest ,
			'owner' => $owner ,
			'date' => date("Y-m-d H:i:s") 
		);
		return	$this->db->insert('block', $data);
	}
	/**
	 * unblock_profile_by_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function unblock_profile_by_ids($guest,$owner) {
				
		$data = array(
			'guest' => $guest ,
			'owner' => $owner 
		);
		return	$this->db->delete('block', $data);
	}
	/**
	 * get_is_spam_users_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_is_spam_users_by_id($guest,$owner) {
		
		$this->db->from('spam');
		$this->db->where('guest', $guest);
		$this->db->where('owner', $owner);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return true;
		}
		else{
		 return false;
		}
		
	}
	/**
	 * spam_profile_by_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function spam_profile_by_ids($guest,$owner) {
				
		$data = array(
			'guest' => $guest ,
			'owner' => $owner ,
			'date' => date("Y-m-d H:i:s") 
		);
		return	$this->db->insert('spam', $data);
	}
	/**
	 * unspam_profile_by_ids function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function unspam_profile_by_ids($guest,$owner) {
				
		$data = array(
			'guest' => $guest ,
			'owner' => $owner 
		);
		return	$this->db->delete('spam', $data);
	}
	/**
	 * get_similar_user_address_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_similar_user_address_by_id($user_id) {
		
		$this->db->select("city");
		$this->db->from('address');
		$this->db->where('user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){			
			foreach ($query->result_array() as $key => $value) {
				$city[]=$value["city"];
			}
			$this->db->select("user_id");
			$this->db->from('address');
			$this->db->where_in('city', $city);
			$query = $this ->db->get();
			if($query->num_rows() != 0 ){
				return $query->result_array();
			}
		}
		else{
		 return false;
		}
		
	}

/**
	 * get_similar_user_skill_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_similar_user_skill_by_id($user_id) {
		
		$this->db->select("title");
		$this->db->from('skills');
		$this->db->where('user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){	
		$title="select user_id from stbl_skills where ";		
			foreach ($query->result_array() as $key => $value) {
				if($key == 0){
					$title.=" 'tilte' LIKE '%".$value["title"]."%'";
				}
				else{
					$title.=" or 'tilte' LIKE '%".$value["title"]."%'";
				}
				
			}
			$this->db->select("user_id");
			$this->db->from('skills');
			$this->db->query($title);
			$query = $this ->db->get();
			if($query->num_rows() != 0 ){
				return $query->result_array();
			}
		}
		else{
		 return false;
		}
		
	}

	/**
	 * get_users_base_info_by_array function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_users_base_info_by_array($user_id) {
		$this->db->select("user_profiles.* ,user.userkey,user.username , user.pic ");
		$this->db->from('user_profiles');
		$this->db->join('user' , 'user.id = user_profiles.user_id');
		$this->db->where_in('user_profiles.user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}

	/**
	 * search_user_by_username function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_user_by_username($keyword) {
		
		$this->db->select("id");
		$this->db->from('user');
		$this->db->like('username', $keyword);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
			return $query->result_array();
		}		
		else{
		 return false;
		}
		
	}
	/**
	 * search_user_by_firstname function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_user_by_firstname($keyword) {
		
		$this->db->select("user_id");
		$this->db->from('user_profiles');
		$this->db->like('firstname', $keyword);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
			return $query->result_array();
		}		
		else{
		 return false;
		}
		
	}
	/**
	 * search_user_by_lastname function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_user_by_lastname($keyword) {
		
		$this->db->select("user_id");
		$this->db->from('user_profiles');
		$this->db->like('lastname', $keyword);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
			return $query->result_array();
		}		
		else{
		 return false;
		}
		
	}
	//**********************Feedback**********************

	/**
	 * insert_user_feedback function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_feedback($data) {

		$this->db->insert('feedback', $data);
		return $this->db->insert_id();
	}
	/**
	 * insert_user_problem function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_problem($data) {

		$this->db->insert('problems', $data);
		return $this->db->insert_id();
	}

	/****************************************edit session**************************************
	 * update_user_profile function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_profile($data) {
				
		$this->db->where('user_id',$data['user_id']);
		return $this->db->update('user_profiles', $data);
	}
	/**
	 * delete_user_location_hometown function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_location_hometown($userid) {
		$data = array(
			'refrence_id' => $userid ,
			'type' => 'hometown' 
		);		
		return	$this->db->delete('locations', $data);
	}
	/**
	 * delete_user_location_from function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_location_from($userid) {
		$data = array(
			'refrence_id' => $userid ,
			'type' => 'from' 
		);		
		return	$this->db->delete('locations', $data);
	}
	/**
	 * delete_user_app_session function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_address($userid) {
		$data = array(
			'refrence_id' => $userid ,
			'type' => 'hometown' 
		);		
		return	$this->db->delete('locations', $data);
	}

	/**
	 * insert_user_address function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_address($data) {

		$this->db->insert_batch('locations', $data);
		return $this->db->insert_id();
	}
	/* update_user_profile function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_profile_pic($data) {
				
		$this->db->where('id',$data['id']);
		return $this->db->update('user', $data);
	}


	/**
	 * insert_user_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_skill($data) {

		$this->db->insert('skills', $data);
		return $this->db->insert_id();
	}

	/**
	 * update_user_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_skill($data,$id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->update('skills', $data); 
		
	}
	/**
	 * delete_user_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_skill($id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete('skills'); 
		
	}
	/**
	 * delete_user_skill_location function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_skill_location($id) {

		$this->db->where('type', "skill");
		$this->db->where('refrence_id', $id);
		return $this->db->delete('locations'); 
		
	}
	/**
	 * get_skill_by_skill_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_skill_by_skill_id($id,$user_id) {
		
		$this->db->from('skills');
		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
	}
	/**
	 * get_user_skill_by_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_skills_by_id($id) {
		
		$this->db->from('skills');
		$this->db->where('user_id', $id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
	}
	/**
	 * get_skills_locations function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_skills_locations($refrence_id) {
		
		$myquery="
SELECT `title`,`latlong` FROM `stbl_locations`
 WHERE `type`='skill' and`refrence_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * insert_user_resume function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_resume($data) {

		$this->db->insert('resume', $data);
		return $this->db->insert_id();
	}
	/**
	 * insert_user_skill_address function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_resume_photos($data) {

		$this->db->insert_batch('picture', $data);
		return $this->db->insert_id();
	}
	/**
	 * insert_user_resume_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_resume_skill($data) {

		$this->db->insert_batch('resume_skills', $data);
		return $this->db->insert_id();
	}	
	/**
	 * update_user_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_resume($data,$id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->update('resume', $data); 
		
	}
	/**
	 * delete_user_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_resume($id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete('resume'); 
		
	}
	/**
	 * delete_user_resume_location function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_resume_location($id) {

		$this->db->where('type', "resume");
		$this->db->where('refrence_id', $id);
		return $this->db->delete('locations'); 
		
	}
	/**
	 * delete_user_resume_skils function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_resume_skils($id) {

		$this->db->where('resume_id', $id);
		return $this->db->delete('resume_skills'); 
		
	}
	/**
	 * delete_user_resume_photo function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_resume_photo($id) {

		$this->db->where('type', "resume");
		$this->db->where('refrence_id', $id);
		return $this->db->delete('picture'); 
		
	}
	/**
	 * get_resume_by_resume_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_resume_by_resume_id($id,$user_id) {
		$myquery="
		SELECT stbl_resume.* , re.title as location , re.latlong, re.category FROM `stbl_resume` 
left join (select * from stbl_locations where type='resume') as re on re.refrence_id=stbl_resume.`id`
	WHERE `stbl_resume`.`id` ='".$id."' and `stbl_resume`.`user_id` ='".$user_id."'"  ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
	}

	/**
	 * get_user_resumes_by_user_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_resumes_by_user_id($user_id) {
		
		$myquery="
		SELECT stbl_resume.* , re.title as location , re.latlong FROM `stbl_resume` 
left join (select * from stbl_locations where type='resume') as re on re.refrence_id=stbl_resume.`id`
	WHERE `stbl_resume`.`user_id` ='".$user_id."'" ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
	}
	/**
	 * get_resume_locations function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_resume_locations($refrence_id) {
		
		$myquery="
SELECT `title`,`latlong` FROM `stbl_locations`
 WHERE `type`='resume' and`refrence_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_resume_photo function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_resume_photo($refrence_id) {
		
		$myquery="
SELECT * FROM `stbl_picture`
 WHERE `type`='resume' and`refrence_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_resume_skills function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_resume_skills($refrence_id) {
		
		$myquery="
SELECT id , title as name FROM `stbl_resume_skills`
join stbl_skills on stbl_resume_skills.skill_id = stbl_skills.id
 WHERE `resume_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_skill_resumes function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_skill_resumes($refrence_id) {
		
		$myquery="
SELECT id , title as name FROM `stbl_resume_skills`
join stbl_resume on stbl_resume_skills.resume_id = stbl_resume.id
 WHERE `skill_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}


	/**
	 * insert_user_resume function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_startup($data) {

		$this->db->insert('startup', $data);
		return $this->db->insert_id();
	}

	/**
	 * insert_user_skill_address function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_startup_photos($data) {

		$this->db->insert_batch('picture', $data);
		return $this->db->insert_id();
	}
	/**
	 * insert_user_startup_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_startup_members($data) {

		$this->db->insert_batch('startup_member', $data);
		return $this->db->insert_id();
	}	
	/**
	 * update_user_startup function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_startup($data,$id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->update('startup', $data); 
		
	}
	/**
	 * delete_user_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_startup($id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete('startup'); 
		
	}
	/**
	 * delete_user_startup_location function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_startup_location($id) {

		$this->db->where('type', "startup");
		$this->db->where('refrence_id', $id);
		return $this->db->delete('locations'); 
		
	}
	/**
	 * delete_user_startup_skils function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_startup_members($id) {

		$this->db->where('startup_id', $id);
		return $this->db->delete('startup_member'); 
		
	}
	/**
	 * delete_user_startup_photo function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_startup_photo($id) {

		$this->db->where('type', "startup");
		$this->db->where('refrence_id', $id);
		return $this->db->delete('picture'); 
		
	}
	/**
	 * get_startup_by_startup_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_startup_by_startup_id($id,$user_id) {
		$myquery="
		SELECT stbl_startup.* , re.title as location , re.latlong ,re.category FROM `stbl_startup` 
left join (select * from stbl_locations where type='startup') as re on re.refrence_id=stbl_startup.`id`
	WHERE `stbl_startup`.`id` ='".$id."' and `stbl_startup`.`user_id` ='".$user_id."'"  ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
	}

	/**
	 * get_user_startups_by_user_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_startups_by_user_id($user_id) {
		
		$myquery="
		SELECT stbl_startup.* , re.title as location , re.latlong FROM `stbl_startup` 
left join (select * from stbl_locations where type='startup') as re on re.refrence_id=stbl_startup.`id`
	WHERE `stbl_startup`.`user_id` ='".$user_id."'" ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
	}
	/**
	 * get_startup_locations function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_startup_locations($refrence_id) {
		
		$myquery="
SELECT `title`,`latlong` FROM `stbl_locations`
 WHERE `type`='startup' and`refrence_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_startup_photo function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_startup_photo($refrence_id) {
		
		$myquery="
SELECT * FROM `stbl_picture`
 WHERE `type`='startup' and`refrence_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_startup_members function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_startup_members($refrence_id) {
		
		$myquery="
SELECT id  as name FROM `stbl_startup_member`
join stbl_user on stbl_startup_member.member_id = stbl_user.id
 WHERE `startup_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_member_startups function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_member_startups($refrence_id) {
		
		$myquery="
SELECT id , title as name FROM `stbl_startup_member`
join stbl_startup on stbl_startup_member.startup_id = stbl_startup.id
 WHERE `member_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}

	//**********************contact*****************
		/**
	 * insert_user_contact function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_contact($data) {

		$this->db->insert('contact', $data);
		return $this->db->insert_id();
	}
	/**
	 * update_user_startup function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_contact($data,$id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->update('contact', $data); 
		
	}
	/**
	 * delete_user_contact function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_contact($id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete('contact'); 
		
	}
	/**
	 * delete_user_contact_location function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_contact_location($id) {

		$this->db->where('type', "contact");
		$this->db->where('refrence_id', $id);
		return $this->db->delete('locations'); 
		
	}
	/**
	 * get_user_startups_by_user_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_contacts_by_user_id($user_id,$type) {
		
		$myquery="
		SELECT stbl_contact.* , re.title as location , re.latlong FROM `stbl_contact` 
left join (select * from stbl_locations where type='contact') as re on re.refrence_id=stbl_contact.`id`
	WHERE `stbl_contact`.`user_id` ='".$user_id."' and `stbl_contact`.`type` ='".$type."'";
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
	}






}
