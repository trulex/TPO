<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddStory extends CI_Controller { 
    function __construct(){
	parent::__construct();
    } 

    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_storyname_check');
	    $this->form_validation->set_rules('text', 'Text', 'trim|required');
	    $this->form_validation->set_rules('tests', 'Tests', 'trim|required');
	    $this->form_validation->set_rules('business_value', 'Business value', 'trim|required|is_natural_no_zero');
	    
	    if ($this->form_validation->run() == FALSE) {
		$data['message']='';
		$this->load->view('addstory_view',$data);
	    } else {
		$name=$this->input->post('name');
		$text=$this->input->post('text');
		$tests=$this->input->post('tests');
		$priority=$this->input->post('priority');
		$business_value=$this->input->post('business_value');
		/*if (strcmp($priority,"Must have")==0) {
		    $priority='musthave';
		} else if (strcmp($priority,"Could have")==0) {
		    $priority='couldhave';
		} else if (strcmp($priority,"Should have")==0){
		    $priority='shouldhave';
		} else {
		    $priority='wonthave';
		}*/
		$userdata=array(
		    'name'=>$name,
		    'text'=>$text,
		    'tests'=>$tests,
		    'priority'=>$priority,
		    'busvalue'=>$business_value );
		$this->db->insert('stories', $userdata);
		$data['message']='Story successfully added.';
		$this->load->view('addstory_view',$data);
	    }
	    $this->load->view('footer');
	} else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}
    }
    public function storyname_check($str) {
    	$this->db->select('name');
	$this->db->from('stories');
	$this->db->where('name', $str);
	$query=$this->db->get();
	if ($query->num_rows() > 0) {
	    $this->form_validation->set_message('storyname_check', 'The story already exists.');
	return FALSE;
	} else {
	    return TRUE;
	}
    }
}