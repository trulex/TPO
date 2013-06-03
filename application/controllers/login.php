<!-- controllers/login.php -->
<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
	parent::__construct();
    }
    
    function index() {
		if( $this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['rights'] = $session_data['rights'];
// 			if($data['rights']) {
// 				$data['active']='administration';
// 				redirect('administration','refresh');
// 			}
			redirect('home','refresh');
		} else {
			$this->load->view('header_login');
			$this->load->helper(array('form'));
			$this->load->view('login_view');
			$this->load->view('footer');
		}
    }
}
