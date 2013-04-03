<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Productbacklog extends CI_Controller { 
    function __construct() {
	parent::__construct();
    }
	
	function index() {
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$this->load->view('header', $data);
			$this->load->view('productbacklog');
			$this->load->view('footer');
		}
	}
}