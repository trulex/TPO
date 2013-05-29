	
<?php
class Stories_day extends CI_Model{

	function getDays(){
		$query=$this->db->query("SELECT date, ocene_sum FROM stories_day ORDER BY date");	
		return $query->result();
	}
}
?>