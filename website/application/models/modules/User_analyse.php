<?php
/**
* 
*/
class User_analyse extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
	}
	/**
	 * insert_invator_email function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return insert user id
	 */
	public function insert_rss($data) {

		$this->db->insert('rss', $data);
		return $this->db->insert_id();
	}
	

}
?>