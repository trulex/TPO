<!-- table "users": [id|username|password|name|surname|email|rights] -->
<?php
Class Users extends CI_Model {
    function login($username, $password) {
	$this -> db -> select('id, username, password, name, rights, deactivated');
	$this -> db -> from('users');
	$this -> db -> where('username', $username);
	$this -> db -> where('password', MD5($password));
	$this -> db -> limit(1);
	
	$query=$this->db->get();
	if($query -> num_rows() == 1) {
		return $query->row();
	} else {
		return false;
	}
    }
    function getPassword($userId) {
	$this -> db -> select('password');
	$this -> db -> from('users');
	$this -> db -> where('id', $userId);
	$query=$this->db->get();
	/*if($query -> num_rows() > 0) {
	  */  $row=$query->result();
	    return $row->password;
	/*} else {
	    return false;
	}*/
    }
    	/* Return usernames,names and surnames of active users, except the current user's, for administrative user editing */
	function getActiveUsers($username) {
	    $this->db->select('username,name,surname');
	    $this->db->from('users');
	    $this->db->where('username !=', $username);
	    $this->db->where('deactivated', 0);
	    $this->db->order_by("username", "asc"); 
	    
	    $query=$this->db->get();
	    if($query -> num_rows() > 0) {
		return $query->result();
	    } else {
		return array();
	    }
    }
    function getInactiveUsers() {
	$this->db->select('username,name,surname');
	$this->db->from('users');
	$this->db->where('deactivated', 1);
	$this->db->order_by("username", "asc");
	$query=$this->db->get();
	if($query -> num_rows() > 0) {
	    return $query->result();
	} else {
	    return array();
	}
    }
    /* Get data for profile editing */
    function getData($userId) {
	$query = $this->db->query("SELECT username,name,surname,email FROM users WHERE id=$userId");
	return $query->row();
    }
    /* Get all user data for user with $userId, required for administrative editing. */
    function getAllData($userId) {
	$this->db->select('username,name,surname,email,rights');
	$this->db->from('users');
	$this->db->where('id', $userId); 
	$query=$this->db->get();
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
		if ($query->row()->lastPID){
		    return $query->row()->lastPID;
		} else {
		    return 0;
		}
	}
} 
?>