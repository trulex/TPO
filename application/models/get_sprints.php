<!--avtor:BOSTJAN-->
<?php

class Get_sprints extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM sprints");
		return $query->result();
	}
	
}

?>