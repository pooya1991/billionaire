<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends Syn_Controller {

    public function __construct() {

            parent::__construct(); 
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

		$f = file_get_contents("http://dunro.com/search?q=%DA%A9%D8%A7%D9%81%D9%87%20%D9%88%20%D8%B1%D8%B3%D8%AA%D9%88%D8%B1%D8%A7%D9%86");
		echo $f;
		
	}	



}



// var response = data.bulletintypes;
//   if(response){
//     $.each(response, function (index, object) {
//           console.log(object.name);
//     });
//   }
