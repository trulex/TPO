<!-- models/installation.php -->
<!-- Created by lovrenc -->

<?php
class Install extends CI_Model{
// 	Delete all tables
	function dumpData(){
		$query = $this->db->query("DROP TABLE IF EXISTS posts, work, project_user, sprints, sprint_story, stories, stories_day, tasks, users, projects");
	}
	
// 	Create all tables
	function initializeDatabase(){
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS posts( id INT(10) AUTO_INCREMENT PRIMARY KEY UNIQUE KEY, text VARCHAR(500) DEFAULT '', PID INT(10) DEFAULT 0, UID INT(10) DEFAULT 0, ParentID INT(10) DEFAULT 0, date datetime)");	
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS projects( id INT(10) AUTO_INCREMENT PRIMARY KEY UNIQUE KEY, name VARCHAR(30) DEFAULT '', description TEXT DEFAULT '', documentation LONGTEXT DEFAULT '')");
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS project_user(PID INT(10), UID INT(10), role INT(1) DEFAULT 0, PRIMARY KEY(PID, UID, role))"); 
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS sprints(id INT(10) AUTO_INCREMENT UNIQUE KEY PRIMARY KEY, start_date DATE, finish_date DATE, velocity INT(5) DEFAULT 0, PID INT(10))"); 
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS sprint_story(StID INT(10), SpID INT(10), PRIMARY KEY(StID, SpID))"); 
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS stories(id INT(10) AUTO_INCREMENT PRIMARY KEY UNIQUE KEY, name VARCHAR(40) DEFAULT '', text VARCHAR(500) DEFAULT '', tests VARCHAR(500) DEFAULT '', difficulty DECIMAL(10,2) DEFAULT 0, priority VARCHAR(12) DEFAULT 0, busvalue INT(11) DEFAULT 0, PID INT(10), note VARCHAR(500) DEFAULT '', finished TINYINT(1) DEFAULT 0)"); 
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS stories_day(id INT(10) PRIMARY KEY AUTO_INCREMENT UNIQUE KEY, PID INT(10), date DATE, ocene_sum INT(11))"); 
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS tasks(id INT(10) AUTO_INCREMENT PRIMARY KEY UNIQUE KEY, name VARCHAR(50), StID INT(10), text VARCHAR(500) DEFAULT '', time_estimate DECIMAL(5,2) DEFAULT 0, UID INT(10) DEFAULT 0, accepted TINYINT(1) DEFAULT 0, start_time DATETIME, end_time DATETIME, time_sum INT(11) DEFAULT 0,active TINYINT(1) DEFAULT 0, completed TINYINT(1) DEFAULT 0)"); 
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS users(id INT(10) AUTO_INCREMENT PRIMARY KEY UNIQUE KEY, username VARCHAR(10), password VARCHAR(100), name VARCHAR(30) DEFAULT '', surname VARCHAR(30) DEFAULT '', email VARCHAR(40) DEFAULT '', rights TINYINT(1) DEFAULT 0, lastPID INT(10) DEFAULT 0, deactivated TINYINT(1) DEFAULT 0)"); 
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS work(id INT(5) AUTO_INCREMENT PRIMARY KEY UNIQUE KEY, date DATE, TID INT(10) DEFAULT 0, time_sum INT(11) DEFAULT 0, remaining INT(11) DEFAULT 0, PID INT(10)) ");
	}

}
?>