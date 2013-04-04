<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index() {
    if($this->session->userdata('logged_in')) {
	$session_data = $this->session->userdata('logged_in');
	$data['username'] = $session_data['username'];
	$data['name'] = $session_data['name'];
	$data['rights'] = $session_data['rights'];
	$data['active']='';
	$this->load->view('header', $data);
	$this->load->view('home_view', $data);
	$this->load->view('footer');
    }
    else {
     //If no session, redirect to login page
     redirect('login', 'refresh');
    }
 }

 function logout() {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

}

?>