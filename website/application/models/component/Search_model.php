<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Search_model extends CI_Model {

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
	 * search_user_by_lastname function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_user_by_name($keyword,$location) {
		$location_query="";
		if(!is_null($location))
		$location_query=" and h_ad.title like '%".$location."%'";
		if($keyword!="")
		$keyword=" and `firstname` like '%".$keyword."%' or `lastname` like '% ".$keyword."%' ";		
		$myquery="
select  a.id as user_id,a.is_confirmed,a.pic,a.username , a.userkey ,a.category as category ,p.*,h_ad.title as live ,h_ad.latlong as livelatlong ,h_ad.security as livesecurity , h_ad.category as livecity ,h_ad.iso as liveflag
from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_locations where type='hometown')  h_ad on a.id=h_ad.refrence_id 
where a.category='1' ".$keyword.$location_query."
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
		/**
	 * search_user_by_job function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_user_by_job($keyword,$location) {
		$location_query="";
		if(!is_null($location))
		$location=" and h_ad.title like '%".$location."%'";
		if(!is_null($keyword))
		$keyword=" and `job` like '%".$keyword."%'";		
		$myquery="
select  a.id as user_id,a.is_confirmed,a.pic,a.username , a.userkey ,a.category as category ,p.*,h_ad.title as live ,h_ad.latlong as livelatlong ,h_ad.security as livesecurity , h_ad.category as livecity ,h_ad.iso as liveflag
from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_locations where type='hometown')  h_ad on a.id=h_ad.refrence_id 
where a.category='1'  ".$keyword.$location."
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
		/**
	 * search_user_by_lastname function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_expo_by_name($keyword,$location) {
		$location_query="";
		if(!is_null($location))
		$location_query=" and h_ad.title like '%".$location."%'";
		if(!is_null($keyword))
		$keyword=" and `firstname` like '%".$keyword."%' or `lastname` like '% ".$keyword."%' ";			
		$myquery="
select  a.id as user_id,a.is_confirmed,a.pic,a.username , a.userkey ,a.category as category,p.*,h_ad.title as live ,h_ad.latlong as livelatlong ,h_ad.security as livesecurity , h_ad.category as livecity ,h_ad.iso as liveflag
from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_locations where type='hometown')  h_ad on a.id=h_ad.refrence_id 
where a.category='2' ".$keyword.$location_query."
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
	/**
	 * search_user_by_username function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_user_by_username($keyword) {
		
		$myquery="
select  a.id as user_id,a.is_confirmed,a.pic,a.username , a.userkey ,p.*,h_ad.title as live ,h_ad.latlong as livelatlong ,h_ad.security as livesecurity , h_ad.category as livecity ,h_ad.iso as liveflag
from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_locations where type='hometown')  h_ad on a.id=h_ad.refrence_id 
where username like '%".$keyword."%' 
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

	/**
	 * search_resume function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_resumes($keyword,$location) {
		$location_query="";
		if(!is_null($location))
		$location_query=" and re.title like '%".$location."%'";		
		$myquery="
SELECT stbl_resume.* , re.title as location , re.latlong, re.category FROM `stbl_resume` 
left join (select * from stbl_locations where type='resume') as re on re.refrence_id=stbl_resume.`id`
	WHERE `stbl_resume`.`title`like '%".$keyword."%' and `stbl_resume`.`security` !=2 ".$location_query."
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
	 * search_startup function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_startup($keyword,$location) {
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
	 * search_skill function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_skills($keyword,$location) {
		$location_query="";
		if(!is_null($location))
		$location_query=" and re.title like '%".$location."%'";		
		$myquery="
SELECT stbl_skills.* , re.title as location , re.latlong, re.category FROM `stbl_skills` 
left join (select * from stbl_locations where type='skill') as re on re.refrence_id=stbl_skills.`id`
	WHERE `stbl_skills`.`title`like '%".$keyword."%' and `stbl_skills`.`security` !=1 ".$location_query."
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
	/**
	 * search_user_by_lastname function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_location($keyword) {
		
		$myquery="select title from stbl_locations where `title` like '%".$keyword."%'
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
	 * search_skill function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_skill($keyword) {
		
		$myquery="select title from stbl_skills where `title` like '%".$keyword."%'
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
	 * search_skill function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_resume($keyword) {
		
		$myquery="select title from stbl_resume where `title` like '%".$keyword."%'
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
	 * search_skill function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function search_user($keyword) {
		
		$myquery="select firstname,lastname from stbl_user_profiles where `firstname` like '%".$keyword."%' or `lastname` like '%".$keyword."%'
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
