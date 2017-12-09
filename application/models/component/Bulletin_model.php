<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Bulletin_model extends CI_Model {

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
	 * insert_user_resume function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_user_bulletin($data) {

		$this->db->insert('bulletin', $data);
		return $this->db->insert_id();
	}



	/**
	 * insert_user_bulletin_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_bulletin_viewers($data) {

		$this->db->insert_batch('bulletin_view', $data);
		return $this->db->insert_id();
	}	
	/**
	 * update_user_bulletin function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function update_user_bulletin($data,$id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->update('bulletin', $data); 
		
	}
	/**
	 * delete_user_skill function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_bulletin($id,$user_id) {

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete('bulletin'); 
		
	}
	/**
	 * delete_user_bulletin_location function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_bulletin_location($id) {

		$this->db->where('type', "bulletin");
		$this->db->where('refrence_id', $id);
		return $this->db->delete('locations'); 
		
	}

	/**
	 * get_bulletin_by_bulletin_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_bulletin_by_bulletin_id($id,$user_id) {
		$myquery="
		SELECT stbl_bulletin.* , re.title as location , re.latlong ,re.category , bu.title as bulletintype FROM `stbl_bulletin` 
left join (select * from stbl_locations where type='bulletin') as re on re.refrence_id=stbl_bulletin.`id`
left join (select * from stbl_bulletin_types) as bu on bu.id=stbl_bulletin.`type`
	WHERE `stbl_bulletin`.`id` ='".$id."' and `stbl_bulletin`.`user_id` ='".$user_id."'"  ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
	}
	/**
	 * get_bulletin_by_bulletin_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_bulletin_types() {
		$myquery="
		SELECT * FROM `stbl_bulletin_types`" ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
	}

	/**
	 * get_all_bulletins function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_all_bulletins() {
		
		$myquery="
		SELECT user.userkey,user.pic,p.firstname,p.lastname,p.gender,stbl_bulletin.* , re.title as location , re.latlong  ,re.category, bu.title as bulletintype FROM `stbl_bulletin` 
left join (select * from stbl_locations where type='bulletin') as re on re.refrence_id=stbl_bulletin.`id`
left join (select * from stbl_bulletin_types) as bu on bu.id=stbl_bulletin.`type`
left join (select * from stbl_user) as user on user.id=stbl_bulletin.`user_id`
left join (select * from stbl_user_profiles) as p on p.user_id=stbl_bulletin.`user_id`
" ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
	}
	/**
	 * get_user_bulletins_by_user_id function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user_bulletins_by_user_id($user_id) {
		
		$myquery="
		SELECT stbl_bulletin.* , re.title as location , re.latlong  ,re.category, bu.title as bulletintype FROM `stbl_bulletin` 
left join (select * from stbl_locations where type='bulletin') as re on re.refrence_id=stbl_bulletin.`id`
left join (select * from stbl_bulletin_types) as bu on bu.id=stbl_bulletin.`type`
	WHERE `stbl_bulletin`.`user_id` ='".$user_id."'" ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
	}
	/**
	 * get_bulletin_locations function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_bulletin_locations($refrence_id) {
		
		$myquery="
SELECT `title`,`latlong` FROM `stbl_locations`
 WHERE `type`='bulletin' and`refrence_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}

	/**
	 * get_bulletin_members function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_bulletin_members($refrence_id) {
		
		$myquery="
SELECT id  as name FROM `stbl_bulletin_member`
join stbl_user on stbl_bulletin_member.member_id = stbl_user.id
 WHERE `bulletin_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_member_bulletins function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_member_bulletins($refrence_id) {
		
		$myquery="
SELECT id , title as name FROM `stbl_bulletin_member`
join stbl_bulletin on stbl_bulletin_member.bulletin_id = stbl_bulletin.id
 WHERE `member_id` = ".$refrence_id ;
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}





}
