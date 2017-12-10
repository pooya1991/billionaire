<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Base_model extends CI_Model {

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

	


}
