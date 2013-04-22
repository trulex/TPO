<!-- table "users": [id|username|password|name|surname|email|rights] -->
<?php
Class Users extends CI_Model {
    function login($username, $password) {
	$this -> db -> select('id, username, password, name, rights');
	$this -> db -> from('users');
	$this -> db -> where('username', $username);
	$this -> db -> where('password', MD5($password));
	$this -> db -> limit(1);
	
	$query=$this->db->get();
	if($query -> num_rows() == 1) {
		return $query->result();
	} else {
		return false;
	}
    }
    /* Get surname and email, required for editing profile. */
    function getSurnameEmail($userId) {
	$query = $this->db->query("SELECT surname,email FROM users WHERE id=$userId");
	return $query->row();
    }
    
	function getAll(){
		$query = $this->db->query("SELECT * FROM projects");
		return $query->result();
	}
	
	function getUserName($id){
		$query = $this->db->query("SELECT username FROM users WHERE id=$id");
		return $query->row()->username;
	}
	
	function getID($uname){
		$query = $this->db->query("SELECT id FROM users WHERE username='$uname'");
		return $query->row()->id;
	}	
	function storeLastPID($PID, $UID){
		$this->db->query("UPDATE users SET lastPID=$PID WHERE id=$UID");
	}
	
	function getLastPID($UID){
		$query = $this->db->query("SELECT lastPID FROM users WHERE id='$UID'");
		return $query->row()->lastPID;
	}
} 
?>