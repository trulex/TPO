<!--avtor:Lovrenc-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddTask extends CI_Controller {

	public function __construct()	{
		parent::__construct();
	}

	public function index()	{
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['id']=$session_data['id'];
			if(strcmp($data['rights'],'user')==0){
					redirect('home','refresh');
			}
			$data['active']='addtask';
			$this->load->model("stories");
			$data['stories']= $this->stories->getAll();			
			$this->load->view('header', $data);
			$this->load->helper(array('form'));
			$this->load->view('addtask',$data);
			$this->load->view('footer');
		} 
		else{
			redirect('login', 'refresh');
		}

	}
	

}