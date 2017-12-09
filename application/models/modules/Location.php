<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Location extends CI_Model {

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
	 * get_location_by_latlong function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_location_by_latlong($latlong) {
		
		
		$geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlong.'&sensor=false');
		
        $output= json_decode($geocode);
    	for($j=count($output->results[0]->address_components)-1;$j>0;$j--){
                
    		if( in_array('locality', $output->results[0]->address_components[$j]->types) )
    			$result['city']= $output->results[0]->address_components[$j]->long_name;
    		if(	in_array('administrative_area_level_1', $output->results[0]->address_components[$j]->types) )
    			$result['area']= $output->results[0]->address_components[$j]->long_name;
    		if(	in_array('country', $output->results[0]->address_components[$j]->types)){
    			$result['iso']= $output->results[0]->address_components[$j]->short_name;
    		 	$result['country']= $output->results[0]->address_components[$j]->long_name;	
    		}
        }   
		 return $result;
		
		
		
	}
	/**
	 * get_location_by_latlong function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_latlong_by_location($value) {
		
		
		$url = "http://maps.google.com/maps/api/geocode/json?address=$value&sensor=false";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);
		$lat = $response_a->results[0]->geometry->location->lat;
		$long = $response_a->results[0]->geometry->location->lng; 
		$result['latlong'] =$lat.','.$long;
		$result['iso']=$response_a->results[0]->address_components[count($response_a->results[0]->address_components)-1]->short_name;
		 return $result;
		
		
		
	}


}
