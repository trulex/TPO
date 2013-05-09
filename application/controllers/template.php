<!-- avtor: Lovrenc -->
<!-- Template za nove viewe -->

<?php
// First things first, zavrne dostop če se dostopa nepravilno
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Deklaracija razreda. Kar imaš tu notr se naslavlja z $this.
// Ne pozabt Spremenit ime da bo enak imenu datoteke, samo da bo z VELIKO začetnico(datoteka ni treba da je z veliko)
class Template extends CI_Controller {
	
// 	konstruktor, pomembna zadevca. tukej lahko notr vržeš, če boš nalagal kakšne modele, še posebno je fino, da ti ni to treba delat v več funkcijah
	public function __construct()	{
		parent::__construct();
// 		Tale dva modela rabmo, da lahko naložimo potrebne podatke za header
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("projects");
	}
	
	
// 	Funkcija index se po defaultu naloži, dela se tukej notr

	public function index()	{	
// 		Če mora imeti uporabnik že izbran projekt, ga v primeru, da ga nima tole pošlje domov
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		
// 		Tukej preverimo, če je uporabnik prijavljen, če ni, ga pošljemo na prijavo
		if($this->session->userdata('logged_in')) {
		
// 			Ti podatki so potrebni, da se uspešno naloži header:
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			
// 			Če je ta stran namenjena le administratorjem, se tukaj preusmeri uporabnika domov:
			
			if(!$data['rights']) {
					redirect('home','refresh');
			}
			
// 			Katera stran je aktivna. omembno, da se pravi link na strani obarva
			$data['active']='productBacklog';
			
// 			In potem loadaš viewe. Najprej header nato tvoj view, na koncu footer
			$this->load->view('header', $data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
}
?>