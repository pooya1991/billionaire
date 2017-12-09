<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actions extends Bil_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('component/user_model'); 
        $this->load->model('component/search_model');
        $this->load->helper('file');


    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		die('404 error');
	}
	public function risk_items()
	{
		header('Content-type: application/json; charset=utf-8');
		$url = base_url('component/exceltojson/index.php');
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
		  echo curl_error($ch);
		  echo "\n<br />";
		  $contents = '';
		} else {
		  curl_close($ch);
		}

		if (!is_string($contents) || !strlen($contents)) {
		echo "Failed to get contents.";
		$contents = '';
		}

		$json=$contents;
		$obj = json_decode($json);
		$error=$data="";
		$user_info = array(
		    'risknum' => (isset($_POST["data"]['risk'])) ? $_POST["data"]['risk'] : "" ,
        );

        /* Email Validation */
        // if ($user_info['ownuserkey']!= $this->session->userdata('billogged_in')['userkey']) {
        // 	$error[] = "hehe...!";
        // }
        if ($user_info['risknum']=="") {
        	$error[] = "hehe...!";
        }
		
		//*******don't have error*****
		if (!is_array($error)) {
            foreach ($obj as $key => $value) {
            	if ($value['0']==$user_info['risknum']) {
            		$data=$value;
            	}
            }
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		echo json_encode(array('result'=>$result));
	}

	public function portfolio_risks($num=0)
	{
		header('Content-type: application/json; charset=utf-8');
		$url = base_url('component/portfolio/portfoliorisks.txt');
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
		  echo curl_error($ch);
		  echo "\n<br />";
		  $contents = '';
		} else {
		  curl_close($ch);
		}

		if (!is_string($contents) || !strlen($contents)) {
		echo "Failed to get contents.";
		$contents = '';
		}

		$json=$contents;
		$obj = json_decode($json,true);
		$error=$data="";
		$user_info = array(
		    'risknum' => (isset($num)) ? $num : 0 
        );


        if ($user_info['risknum']=="" and $user_info['risknum']==0) {
        	$error[] = "hehe...!";
        }else{
        	if(!isset($obj[$user_info['risknum']])){
				$error[] = "Not range";
			}
        }
		$data['strength']=0;
		//*******don't have error*****
		if (!is_array($error)) {
            foreach ($obj as $key => $value) {
            	if ($value['risknumber'] == $user_info['risknum']) {
            		if($data['strength'] < $value['strength']){
            		$data=$value;
            		}	
            	}
            }
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		return $result;
	}


	public function portfolios($id=0)
	{
		header('Content-type: application/json; charset=utf-8');
		$url = base_url('component/portfolio/portfolios.txt');
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
		  echo curl_error($ch);
		  echo "\n<br />";
		  $contents = '';
		} else {
		  curl_close($ch);
		}

		if (!is_string($contents) || !strlen($contents)) {
		echo "Failed to get contents.";
		$contents = '';
		}

		$json=$contents;
		$obj = json_decode($json,true);
		$error=$data="";
		$user_info = array(
		    'id' => (isset($id)) ? $id : 0 
        );
        if ($user_info['id']=="" and $user_info['id']==0) {
        	$error[] = "hehe...!";
        }else{
        	if(!isset($obj[$user_info['id']-1])){
				$error[] = "Not range";
			}
        }

		//*******don't have error*****
		if (!is_array($error)) {
            foreach ( $obj[$user_info['id']-1] as $key => $value) {
            	if ($value !=0 and $key!= 'id') {
            		$data[]= array(
            			'code' => $key ,
            			'percent'=> $value
            		 );
            	}
            }
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		return $result;
	}
	public function stocks_history($num)
	{
		header('Content-type: application/json; charset=utf-8');
		$url = base_url('component/stocks/stockhistory.txt');
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
		  echo curl_error($ch);
		  echo "\n<br />";
		  $contents = '';
		} else {
		  curl_close($ch);
		}

		if (!is_string($contents) || !strlen($contents)) {
		echo "Failed to get contents.";
		$contents = '';
		}

		$json=$contents;
		$obj = json_decode($json,true);
		$error=$data="";
		$user_info = array(
		    'risknum' => ($num!="") ? $num : '0'
        );
        if ( $user_info['risknum']=='0') {
        	$error[] = "hehe...!";
        }
		
		//*******don't have error*****
		if (!is_array($error)) {
			foreach ($obj as $key => $value) {
				if(isset($value[$user_info['risknum']])){
			   		$data=$value[$user_info['risknum']]['close'];
				}
			}

		}
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		return $result;
	}
	public function stocks_history_update($num=0)
	{
		header('Content-type: application/json; charset=utf-8');
		$json = file_get_contents('https://xtrader.ir/data/history/');
		$obj = $json;
		$error=$data="";
		$user_info = array(
		    'risknum' => (isset($num)) ? $num : 0 
        );


        if ($user_info['risknum']!="627926") {
        	$error[] = "hehe...!";
        }
		//*******don't have error*****
		if (!is_array($error)) {
			    if ( !write_file('component/stocks/stockhistory.txt', $obj))
			    {
			            $data= 'Unable to update the file';
			    }
			    else
			    {
			            $data= 'File updated!';
			    }
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		echo json_encode(array('result'=>$result));
	}
	public function addwatchlist()
	{
		header('Content-type: application/json; charset=utf-8');
		$error=$data="";
		$user_info = array(
		    'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "",
		    'keyword' => (isset($_POST["data"]['keyword'])) ? $_POST["data"]['keyword'] : "" 
        );
        if ($user_info['keyword']=="") {
        	$error[] = "keyword error!";
        }
        $link=$this->session->userdata('billogged_in')['userkey'];
        if ($user_info['userkey']!=$link) {
            $error[] = "hehe....!";
        }
		//*******don't have error*****
		if (!is_array($error)) {
			$user_profile_info=$this->user_model->get_user_full_info_by_userkey($link);
			$watch_data = array(
				'user_id' => $user_profile_info['user_id'] ,
				'title'=>$user_info['keyword']
			);
	        $watch_id=$this->user_model->insert_user_watchlist($watch_data);
				$data['watchid']=$watch_id;
				$data['title']=$user_info['keyword'];
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		echo json_encode(array('result'=>$result));
	}
	public function addtowatchlist()
	{
		header('Content-type: application/json; charset=utf-8');
		$error=$data="";
		$user_info = array(
		    'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "",
		    'wathid' => (isset($_POST["data"]['wathid'])) ? $_POST["data"]['wathid'] : "", 
		    'symbol' => (isset($_POST["data"]['symbol'])) ? $_POST["data"]['symbol'] : "" 
        );
        if ($user_info['symbol']=="") {
        	$error[] = "symbol error!";
        }
        $link=$this->session->userdata('billogged_in')['userkey'];
        if ($user_info['userkey']!=$link) {
            $error[] = "hehe....!";
        }
		//*******don't have error*****
		if (!is_array($error)) {
			$user_profile_info=$this->user_model->get_user_full_info_by_userkey($link);
			$watch_data = array(
				'watchlist_id' => $user_info['wathid'] ,
				'stock_id'=>$this->user_model->get_stock_info($user_info['symbol'])['stock_id']
			);

	        $watch_id=$this->user_model->insert_user_watchlist_details($watch_data);
				$data['watchid']=$watch_id;

        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		echo json_encode(array('result'=>$result));
	}

	public function rebalencing()
	{
		header('Content-type: application/json; charset=utf-8');
		$error=$data="";
		$user_info = array(
		    'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "",
		    'amount' => (isset($_POST["data"]['amount'])) ? $_POST["data"]['amount'] : "" ,
		    'risknum' => (isset($_POST["data"]['risknum'])) ? $_POST["data"]['risknum'] : "" 

        );
        if ($user_info['risknum']=="" and $user_info['risknum']==0) {
        	$error[] = "hehe...!";
        }
        $link=$this->session->userdata('billogged_in')['userkey'];
        if ($user_info['userkey']!=$link) {
            $error[] = "hehe....!";
        }
        $user_info['amount']=str_replace(',', '', $user_info['amount']);
		//*******don't have error*****
		if (!is_array($error)) {
			$user_profile_info=$this->user_model->get_user_full_info_by_userkey($link);
	        $portfolio_risks= $this->portfolio_risks($user_info['risknum']);
	        $portfolios= $this->portfolios($portfolio_risks['data']['id'])['data'];
	        $code="";
	        foreach ($portfolios as $key => $value) {
	        	$code[]=$value['code'];
	        }
	        $code=$this->user_model->get_stocks_info($code);
	        $suggest_data = array(
	        	'user_id' => $user_profile_info['user_id'],
	        	'suggestion_code' => $portfolio_risks['data']['id']
	        	);
	        $suggest_id=$this->user_model->insert_portfolio_suggestion($suggest_data);

	        $suggest_details="";
	        foreach ($code as $key => $value) {
	        	$row="";
	        	foreach ($portfolios as $key1 => $value1) {
	        		if($value['code']==$value1['code'])
	        			$row=$key1;
	        	}
	        	$percent=$portfolios[$row]['percent'];
	        	$price=end($this->stocks_history($value['code'])['data']);
	        	if($percent!=0 )
	        	$suggest_details[] = array(
	        		'suggestion_id' => $suggest_id, 
	        		'code' => $value['code'], 
	        		'percent' => $percent, 
	        		'amount' => floor(($percent*$user_info['amount'])/$price), 
	        		'price' => $price, 
	        		);
	        }
	        if($this->user_model->insert_portfolio_suggestion_details($suggest_details))
	        {
	        	$data=$suggest_id;
	        }
          
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		echo json_encode(array('result'=>$result));
	}

	public function trebalencing()
	{
		header('Content-type: application/json; charset=utf-8');
		$error=$data="";
		$user_info = array(
		    'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "",
		    'amount' => (isset($_POST["data"]['amount'])) ? $_POST["data"]['amount'] : 100000 ,
		    'risknum' => (isset($_POST["data"]['risknum'])) ? $_POST["data"]['risknum'] : 63 

        );
        if ($user_info['risknum']=="" and $user_info['risknum']==0) {
        	$error[] = "hehe...!";
        }
        $user_info['amount']=str_replace(',', '', $user_info['amount']);
		//*******don't have error*****
		if (!is_array($error)) {
			//$user_profile_info=$this->user_model->get_user_full_info_by_userkey($link);
	        $portfolio_risks= $this->portfolio_risks($user_info['risknum']);
	        $portfolios= $this->portfolios($portfolio_risks['data']['id'])['data'];
	        $code1="";
	        foreach ($portfolios as $key => $value) {
	        	$code1[]=$value['code'];
	        }
	        $code=$this->user_model->get_stocks_info($code1);
	        $suggest_data = array(
	        	//'user_id' => $user_profile_info['user_id'],
	        	'suggestion_code' => $portfolio_risks['data']['id']
	        	);
	        $suggest_id=8;
	        $data['sum']=0;
	        $suggest_details="";
	        foreach ($code as $key => $value) {
	        	$row="";
	        	foreach ($portfolios as $key1 => $value1) {
	        		if($value['code']==$value1['code'])
	        			$row=$key1;
	        	}
	        	$percent=$portfolios[$row]['percent'];
	        	$price=end($this->stocks_history($value['code'])['data']);
	        	if($percent!=0 )
	        	$suggest_details[] = array(
	        		'suggestion_id' => $suggest_id, 
	        		'code' => $value['code'], 
	        		'percent' => $percent, 
	        		'amount' => floor(($percent*$user_info['amount'])/$price), 
	        		'price' => $price, 
	        		);
	        	$data['sum']+=$percent;
	        }
	        // if($this->user_model->insert_portfolio_suggestion_details($suggest_details))
	        // {
	        // 	$data=$suggest_id;
	        // }
	        $data['suggest_details']=$suggest_details;
	        $data['portfolios']=$portfolios;
	        $data['code']=$code;
			$data['code1']=$code1;
			$data['suggestion_code']= $portfolio_risks['data']['id'];
          
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		echo json_encode(array('result'=>$result));
	}

	public function ssearch()
	{
		
        header('Content-type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $obj = json_decode($json , true);
        $error=$data="";
        // set user info
        $user_info = array(
            'keyword' => (isset($_POST["data"]['keyword'])) ? $_POST["data"]['keyword'] : "" ,
            'userkey' => (isset($_POST["data"]['userkey'])) ? $_POST["data"]['userkey'] : "" 
        );
        $link=$this->session->userdata('billogged_in')['userkey'];
        if ($user_info['userkey']!=$link) {
            $error[] = "hehe....!";
        }
        /* Email Validation */
        if (empty($user_info["keyword"])) {
        $error[] = "keyword problem...";
        }
        //*******don't have error*****
        if (!is_array($error)) {
            
            $stocks=$this->search_model->search_stocks($user_info["keyword"]);
            foreach ($stocks as $key => $value) {
            	$market = ($value['market']=='1') ? 'بورس' : 'فرابورس' ;
            	$data[]= array(
            		'link' => base_url()."home/index/".$value['code'],
            		'code' =>$value['code'],
            		'name' => $value['name'],
            		'title_fa' => $value['title_fa'],
            		'name_en' => $value['name_en'],
            		'market' => $market
            		 );
            }

        }
        else{
            $error[]="Fetch faild..";
        }
        //*************return result************
        $result = array(
            'error' =>  (is_array($error)) ? 1 : 0 ,
            'error_detalis'=>$error,
            'data'=>$data
             );
        echo json_encode(array('result'=>$result));
	}

	public function test($id=0)
	{
		$user_info = array(
		    'id' => (isset($id)) ? $id : 0 
        );
		header('Content-type: application/json; charset=utf-8');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://xtrader.ir/data/get-data/IRO7VIRP0001/');
		curl_setopt($ch, CURLOPT_ENCODING ,"iso");
		//$result1 = curl_exec($ch);
		$page = utf8_decode(curl_exec($ch));
		curl_close($ch);
		$page= mb_convert_encoding($page,'ISO-8859-1','utf-8');
		$obj = json_decode($page);


		$error=$data="";

		//*******don't have error*****
		if (!is_array($error)) {
            $data=$obj;
        }
        else{
            $error[]="Fetch faild..";
        }

		$result = array(
		        'error' =>  (is_array($error)) ? 1 : 0 ,
		        'error_detalis'=>$error,
		        'data'=>$data
		         );
		echo json_encode($result);
	}


}
