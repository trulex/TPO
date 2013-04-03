<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addsprint extends CI_Controller { 

    function __construct() {
		parent::__construct();
    }
	
	function index() {
	
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='productbacklog';
			$this->load->view('header', $data);
			$this->load->helper(array('form'));
			$this->load->view('addsprint_view',$data);
			$this->load->view('footer');
		} else {
		//If no session, redirect to login page
		redirect('login', 'refresh');
		}
    }
}
?>