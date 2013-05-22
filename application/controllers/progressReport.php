<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ProgressReport extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("projects");
		$this->load->model("project_user");
		include("pChart/pChart/pData.class");
		include("pChart/pChart/pChart.class");
	}

	function index() {
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['id']=$session_data['id'];
			$data['active']='progressReport';
			$data['id']=$session_data['id'];
			$data['project']=$session_data['project'];
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			
			$this->graf();
			
			$this->load->view('header', $data);
			$this->load->view('progressReport', $data);
			$this->load->view('footer');
		}
		else {
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function graf(){
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->AddPoint(array(90,80,70,60,50,40,30,20,10,0),"Serie1");
		$DataSet->AddPoint(array(80,80,80,80,80,80,80,80,80,80),"Serie2");

		$DataSet->AddAllSeries();
		$DataSet->SetAbsciseLabelSerie();
		$DataSet->SetSerieName("Work remaining","Serie1");
		$DataSet->SetSerieName("Workload","Serie2");

		// Initialise the graph
		$Test = new pChart(720,230);
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,200);
		$Test->drawFilledRoundedRectangle(7,7,720,230,5,240,240,240);
		$Test->drawRoundedRectangle(5,5,720,230,5,230,230,230);
		$Test->drawGraphArea(255,255,255,TRUE);
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);
		$Test->drawGrid(4,TRUE,230,230,230,50);

		// Draw the 0 line
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,143,55,72,TRUE,TRUE);

		// Draw the line graph
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);

		// Set labels
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","0","Sprint 1",221,230,174);
		$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","5","Sprint 2",221,230,174);

		// Finish the graph
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Burn down chart",50,50,50,585);
		$Test->Render("pics/graf.png");
	}
}

?>