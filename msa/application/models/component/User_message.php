<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_message extends CI_Model {

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
	 * save_user_send_message function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function save_user_send_message($owner,$guest,$keyword) {
				
		$data = array(
			'guest' => $guest ,
			'owner' => $owner ,
			'text'=>$keyword,
			'date' => date("Y-m-d H:i:s") , 
			'type' => '1'
		);
			$this->db->insert('message', $data);
			return $this->db->insert_id();
	}
	/**
	 * get_users_conversation function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function get_users_conversation($owner,$guest,$num) {
				
		$sql=" 
			SELECT * FROM `stbl_message` 
			WHERE `guest`=$guest and `owner`=$owner or `owner` =$guest and `guest` =$owner 
			ORDER BY `date` DESC
			limit $num ";
		$query=$this->db->query($sql);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}

	}
	/**
	 * get_users_conversation function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function get_users_last_massage($id,$num) {
				
		$sql=" 			
			SELECT a.pic,a.userkey,p.lastname,p.firstname,s.* FROM `stbl_user` a
			join stbl_user_profiles as p on a.id=p.user_id
			join
			(select * from stbl_message    
			WHERE `guest`=$id or `owner`=$id
            ORDER BY `date` asc)as s on (`guest` = $id AND a.id = s.owner) OR (`owner` = $id AND a.id = s.guest)
            GROUP BY `guest`,`owner`
            limit $num ";
		$query=$this->db->query($sql);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}

	}
	/**
	 * delete_user_massage_by_id function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_user_massage_by_id($owner,$id) {
				
		$data = array(
			'id' => $id ,
			'owner' => $owner 
		);
		return	$this->db->delete('message', $data);
	}
	/**
	 * get_users_conversation function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function delete_users_conversation($owner,$guest) {
				
		$sql=" 
			DELETE FROM `stbl_message` 
			WHERE `guest`=$guest and `owner`=$owner or `owner` =$guest and `guest` =$owner 
			";
		$query=$this->db->query($sql);
		 return $query;
		

	}


}
