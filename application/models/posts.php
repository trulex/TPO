<!-- table "posts": [id|text|PID|UID|date] -->
<?php
Class Posts extends CI_Model {
    /* Add a wall post */
    function addPost($text, $PID, $UID, $ParentID) {
	if(strcmp($text,'')!=0) {
	    $data = array(
	    'text' => $text,
	    'PID' => $PID,
	    'UID' => $UID,
	    'ParentID' => $ParentID,
	    'date' => date('Y-m-d H:i:s') );
	    $this->db->insert('posts', $data);
	    return true;
	}
	return false;
    }
    /* Get all wall posts for current project */
    function getWallPosts($PID) {
	$this->db->select('posts.id,text,UID,date,username,ParentID');
	$this->db->from('posts');
	$this->db->join('users', 'posts.UID = users.id', 'left');
	$this->db->where('PID', $PID);
	$this->db->order_by('date', 'desc');
	$query=$this->db->get();
	if ($query -> num_rows() <= 0) {
	    return array();
	} else {
	    return $query->result();
	}
    }
}
