<?php
/**
* 
*/
class Expo_model extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
	}
	/**
	 * get_user_id_from_userkey function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_all_free_expos_info($page) {
		
		$myquery="
select  a.id as user_id,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education,se.last_online ,h_ad.title as live ,h_ad.latlong as livelatlong,h_ad.security as livesecurity ,f_ad.title as born ,f_ad.latlong as bornlatlong,f_ad.security as bornsecurity , h_ad.category as livecity, f_ad.category as borncity,h_ad.iso as liveflag
from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id
left outer join
(select * from stbl_sessions ) se on a.id=se.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
left outer join
(select * from stbl_locations where type='hometown')  h_ad on a.id=h_ad.refrence_id 
left outer join
(select * from stbl_locations where type='from')  f_ad on a.id=f_ad.refrence_id 
where a.`category` = 1
group by a.id
ORDER BY a.created DESC 
LIMIT ".$page['from']." , ".$page['to']."
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
	 * get_user_id_from_userkey function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_expo_info_by_key($userkey) {
		
		$myquery="
select  a.id as user_id,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education,se.last_online ,h_ad.title as live ,h_ad.latlong as livelatlong,h_ad.security as livesecurity ,f_ad.title as born ,f_ad.latlong as bornlatlong,f_ad.security as bornsecurity , h_ad.category as livecity, f_ad.category as borncity,h_ad.iso as liveflag
from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id
left outer join
(select * from stbl_sessions ) se on a.id=se.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
left outer join
(select * from stbl_locations where type='hometown')  h_ad on a.id=h_ad.refrence_id 
left outer join
(select * from stbl_locations where type='from')  f_ad on a.id=f_ad.refrence_id 
where a.userkey = '".$userkey."' 
group by a.id

				";
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
		
	}
	/**
	 * get_user_info_by_id function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_expo_info_by_id($user_id) {
		
		$myquery="
select  a.id as user_id,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education,se.last_online ,h_ad.title as live ,h_ad.latlong as livelatlong ,h_ad.security as livesecurity ,f_ad.title as born ,f_ad.latlong as bornlatlong,f_ad.security as bornsecurity , h_ad.category as livecity, f_ad.category as borncity,h_ad.iso as liveflag
from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id
left outer join
(select * from stbl_sessions ) se on a.id=se.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
left outer join
(select * from stbl_locations where type='hometown')  h_ad on a.id=h_ad.refrence_id 
left outer join
(select * from stbl_locations where type='from')  f_ad on a.id=f_ad.refrence_id
where a.id = '".$user_id."' 
group by a.id

				";
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array()[0];
		}
		else{
		 return false;
		}
		
	}
	public function get_all_free_expos_info_sort_visit() {
		
		$myquery="select a.id as user_id, a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education ,se.last_online from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id 
left outer join
(select * from stbl_sessions ) se on a.id=se.user_id
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where a.`category` = 1
group by a.id
order by p.visitor desc

				";
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	public function get_all_free_expos_info_sort_rate() {
		
		$myquery="select a.id as user_id,a.* ,p.*,s.title as skilltitle,st.title as startuptitle ,COALESCE(ed.grade, 0) as education ,se.last_online from `stbl_user` as a 
join stbl_user_profiles as p on a.id=p.user_id
left outer join
(select * from stbl_skills order by date desc)  s on a.id=s.user_id
left outer join
(select * from stbl_startup order by startdate desc)  st on a.id=st.user_id
left outer join
(select * from stbl_sessions ) se on a.id=se.user_id 
left outer join
(select * from stbl_resume where type='education' order by startdate desc)  ed on a.id=ed.user_id 
where a.`category` = 1
group by a.id
order by p.rate desc

				";
		
		$query = $this->db->query($myquery);
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}
	public function get_all_free_expos_info_sort_location() {
		
		$this->db->select("user_profiles.*,user.pic,,user.userkey,user.username");
		$this->db->from('user');
		$this->db->join('user_profiles' , 'user.id = user_profiles.user_id');
		$query = $this ->db->get();
		if($query->num_rows() != 0 ){
		 return $query->result_array();
		}
		else{
		 return false;
		}
		
	}

}
?>