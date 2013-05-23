<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("projects");
		$this->load->model("project_user");
		$this->load->model("users");
		$this->load->model('posts');
		$this->load->helper('form');
	}

	function index() {
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['id']=$session_data['id'];
			$data['active']='wall';
			$data['id']=$session_data['id'];
			$data['project']=$session_data['project'];
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$data['wallPosts']=$this->posts->getWallPosts($this->session->userdata('PID'));
			$this->load->view('header', $data);
			$this->load->view('home_view', $data);
			$this->load->view('footer');
		}
		else {
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
    /* Post something to the wall */
    function wallPost() {
	$text = $this->input->post('wallPost');
	$PID = $this->session->userdata('PID');
	$UID = $this->session->userdata('UID');
	$this->posts->addPost($text, $PID, $UID);
	redirect('home','refresh');
    }
	function logout() {
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('project');
		$this->session->unset_userdata('noproject');
		session_destroy();
		redirect('home', 'refresh');
	}
	
	function graf() {
		include("pChart/pChart/pData.class");   
		include("pChart/pChart/pChart.class");   
  
		 // Dataset definition    
		 $DataSet = new pData;   
		 $DataSet->ImportFromCSV("pChart/Sample/bulkdata.csv",",",array(1,2,3),FALSE,0);   
		 $DataSet->AddAllSeries();   
		 $DataSet->SetAbsciseLabelSerie();   
		 $DataSet->SetSerieName("January","Serie1");   
		 $DataSet->SetSerieName("February","Serie2");   
		 $DataSet->SetSerieName("March","Serie3");   
		 $DataSet->SetYAxisName("Average age");
		 $DataSet->SetYAxisUnit("µs");
		  
		 // Initialise the graph   
		 $Test = new pChart(700,230);
		 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);   
		 $Test->setGraphArea(70,30,680,200);   
		 $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);   
		 $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);   
		 $Test->drawGraphArea(255,255,255,TRUE);
		 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);   
		 $Test->drawGrid(4,TRUE,230,230,230,50);
		  
		 // Draw the 0 line   
		 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",6);   
		 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);   
		  
		 // Draw the line graph
		 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
		 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);   
		  
		 // Finish the graph   
		 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);   
		 $Test->drawLegend(75,35,$DataSet->GetDataDescription(),255,255,255);   
		 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);   
		 $Test->drawTitle(60,22,"example 1",50,50,50,585);   
		 $Test->Render("pics/graf.png");
	}

}

?>