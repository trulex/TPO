<!-- controllers/progressReport.php -->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ProgressReport extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("projects");
		$this->load->model("stories");
		$this->load->model("tasks");
		$this->load->model("work");
		$this->load->model("project_user");
		$this->load->model("stories_day");
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
			$data['hoursTotal']=$this->stories->getHours($this->session->userdata('PID'));
			$data['hoursWorked']=$this->work->getTimeSum($this->session->userdata('PID'))/3600;
			$data['startDate']=$this->sprints->getProjectStart($this->session->userdata('PID'));
			
			if($this->sprints->getProjectStart($this->session->userdata('PID')) != 0){
				$this->graf();
			}else{
				$this->grafPrazen();
			}
			
			
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
		
		$hoursTotal=$this->stories->getHours($this->session->userdata('PID')); // skupno stevilo ur vseh zgodb v tem projektu
		$today=$this->stories_day->getDays($this->session->userdata('PID'));
		$start=$this->sprints->getProjectStart($this->session->userdata('PID')); // datum, kdaj zacne prvi sprint oz projekt
		$finish=$this->sprints->getProjectEnd($this->session->userdata('PID')); // datum, kdaj konca zadnji sprint oz projekt
		
		$userdata=array(
					'date'=>date("Y-m-d"),
					'ocene_sum'=>$hoursTotal,
					'PID'=>$this->session->userdata('PID')
					);
		
		$bob=0;
		foreach($today as $day){
			if(strtotime($day->date)==strtotime(date("Y-m-d"))){
				$bob++;
			}
		}
		
		if($bob==0){
			$this->db->insert('stories_day', $userdata);
		}else{
			$this->db->where('date', date("Y-m-d"));
			$this->db->update('stories_day', $userdata);
		}
		
		$deloArray=$this->work->getTime($this->session->userdata('PID')); // podatki dneva in koliko ur se je delalo na dolocen dan
		
		$dolzina=(strtotime(date("Y-m-d"))-strtotime($start))/86400; //dolzina tabele za graf
		$dolzinaMax=(strtotime($finish)-strtotime($start))/86400; //dolzina tabele za cel projekt
		if($dolzina >= $dolzinaMax){
			$dolzina=$dolzinaMax;
		}
		
		$zelenaCrta=array(); // tabela, ki bo vsebovala vrednosti za zeleno crto
		$rdecaCrta=array(); // tabela, ki bo vsebovala vrednosti za rdeco crto
		$delo=array($dolzina); // tabela, ki vsebuje ure dela za posamezen dan
		
		for($i=0; $i<=$dolzina; $i++){
			$delo[$i]=0;
		}
		
		foreach($today as $danes){
			if((strtotime($danes->date)-strtotime($start))==0){
				$rdecaCrta[0]=$danes->ocene_sum;
			}
		}
		
		$today=$this->stories_day->getDays($this->session->userdata('PID'));
		$datica=strtotime($start);
		//$sumica=0;
		foreach($today as $danes){
			if((strtotime($danes->date)-$datica)/86400 > 1){
				$meja=(strtotime($danes->date)-$datica)/86400;
				for($i=1; $i<$meja; $i++){
					$vsota=$datica+($i*86400);
					$userdata=array(
						'date' => date("Y-m-d",$vsota),
						'ocene_sum' => $sumica,
						'PID' => $this->session->userdata('PID')
					);
					$this->db->insert('stories_day', $userdata);
					$index=(strtotime($danes->date)-strtotime($start))/86400-$i; // indeks, kam se bo vpisalo delo
					$rdecaCrta[$index+1]=$sumica;
				}
			}
			$index=(strtotime($danes->date)-strtotime($start))/86400; // indeks, kam se bo vpisalo delo
			$rdecaCrta[$index+1]=$danes->ocene_sum;
			$datica=strtotime($danes->date);
			$sumica=$danes->ocene_sum;
		}
		
		foreach($deloArray as $polje){
			$index=(strtotime($polje->date)-strtotime($start))/86400; // indeks, kam se bo vpisalo delo
			$delo[$index]=($polje->timeSum)/3600;
		}
		for($i=0; $i<=$dolzina+1; $i++){
			$deloUre=0;
			if($i==0){
				$zelenaCrta[$i]=$rdecaCrta[$i];
			}else{
				for($j=0; $j<$i; $j++){
					$deloUre=$deloUre+$delo[$j];
				}
				$zelenaCrta[$i]=$rdecaCrta[$i]-$deloUre;
			}
		}
		
		//foreach($zelenaCrta as $polje){
		//	echo $polje;
		//	echo "\n";
		//}
		//foreach($rdecaCrta as $polje){
		//	echo $polje;
		//	echo "\n";
		//}
		
		$DataSet->AddPoint($zelenaCrta,"Serie1");
		$DataSet->AddPoint($rdecaCrta,"Serie2");

		$DataSet->AddAllSeries();
		$DataSet->SetAbsciseLabelSerie();
		$DataSet->SetSerieName("Work remaining","Serie1");
		$DataSet->SetSerieName("Workload","Serie2");

		// Initialise the graph
		$Test = new pChart(720,400);
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,360);
		$Test->drawFilledRoundedRectangle(7,7,720,400,5,240,240,240);
		$Test->drawRoundedRectangle(5,5,720,400,5,230,230,230);
		$Test->drawGraphArea(255,255,255,TRUE);
		$razlika=90-(max($zelenaCrta) % 90);
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),$Test->setFixedScale(0,$zelenaCrta[0]+$razlika,9),150,150,150,TRUE,0,0);
		$Test->drawGrid(4,TRUE,230,230,230,50);

		// Draw the 0 line
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,143,55,72,TRUE,TRUE);

		// Draw the line graph
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);

		// Set labels
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$sprinti=$this->sprints->getProjectSprints(1);
		$i=1;
		foreach($sprinti as $sprint){
			$razlika=(strtotime($sprint->start_date)-strtotime($start))/86400;
			if($dolzina > $razlika){
				$serija="Sprint ".$i;
				$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1",$razlika,$serija,221,230,174);
				$i++;
			}
		}
		//$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","0","Sprint 1",221,230,174);
		//$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","5","Sprint 2",221,230,174);

		// Finish the graph
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Burn down chart",50,50,50,585);
		$Test->Render("pics/graf.png");
	}
	
	function grafPrazen(){
		// Dataset definition
		$DataSet = new pData;
		$DataSet->AddPoint(array(0),"Serie1");
		$DataSet->AddPoint(array(0),"Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbsciseLabelSerie();
		$DataSet->SetSerieName("Work remaining","Serie1");
		$DataSet->SetSerieName("Workload","Serie2");
		   
		// Initialise the graph   
		$Test = new pChart(720,400);
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,360);
		$Test->drawFilledRoundedRectangle(7,7,720,400,5,240,240,240);
		$Test->drawRoundedRectangle(5,5,720,400,5,230,230,230);
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
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Burn down chart",50,50,50,585);
		$Test->Render("pics/graf.png");
	}
}
?>