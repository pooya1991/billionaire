<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Credit_model extends CI_Model {

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
	 * insert_user_credit function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_credit($data) {

		$this->db->insert('user_credit', $data);
		return $this->db->insert_id();
	}
	/* update_user_credit function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_credit($data) {
				
		$this->db->where('user_id',$data['user_id']);
		return $this->db->update('user_credit', $data);
	}
	/* get_user_credit function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function get_user_credit($id) {
				
		$this->db->from('user_credit');
		$this->db->where('user_id', $id);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
	}
	/**
	 * insert_user_credit function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_invitation($caller,$invited) {
		$data = array(
                'caller_id' =>$caller ,
                'invited_id'=>$invited ,
                'date'=>date('Y-m-j H:i:s')
                );

		$this->db->insert('invitation', $data);
		return $this->db->insert_id();
	}
	/* get_user_credit function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function get_user_insert_invitation($caller,$invited) {
				
		$this->db->from('invitation');
		$this->db->where('caller_id', $caller);
		$this->db->where('invited_id', $invited);
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
	}
	/**
	 * search_skill function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_skill($keyword,$location) {
		$location_query="";
		if(!is_null($location))
		$location_query=" and re.title like '%".$location."%'";		
		$myquery="
SELECT stbl_startup.* , re.title as location , re.latlong, re.category FROM `stbl_startup` 
left join (select * from stbl_locations where type='startup') as re on re.refrence_id=stbl_startup.`id`
	WHERE `stbl_startup`.`title`like '%".$keyword."%' and `stbl_startup`.`security` !=2 ".$location_query."
				";
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}	
	}

		/**
	 * search_users_by_name function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_users_by_name($keyword) {
		
			$myquery="select a.userkey,a.username,a.pic,a.type ,p.*,s.title as skilltitle,st.title as startuptitle from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by date desc)  st on a.id=st.user_id 
where p.firstname like '%$keyword%' or p.lastname like '%$keyword%' or a.username like '%$keyword%'
group by a.id
				";
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}


}
