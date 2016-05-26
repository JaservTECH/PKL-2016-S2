<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Classseminartas extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('mahasiswa');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->library("view");
		$this->load->helper('url');
		$this->load->helper('html');
	}
	//show form
	public function getLayoutTaS(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view("Classroom_room/Body_right/seminar_ta1");
	}
}