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
		$this->load->model('sc_sm');
	}
	//show form
	public function getLayoutTaS(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if($this->sc_sm->getCheckSeminarPermission()){
			echo "1";
			$this->load->view("Classroom_room/Body_right/seminar_ta1"); 			
		}else{
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 1, dikarenakan anda sudah pernah, atau anda sudah harus lanjut ke seminar ta 2. Terima kasih";
			echo "0";
			$this->load->view("Classroom_room/Body_right/warning-no-button-seminar-ta",$DATA);
		}
	}
	public function getCheck($variabel=null,$value=null,$type=false){
		if($variabel == null){
			$this->view->isNullPost('variabel');
			$variabel = $this->input->post('variabel');
			$variabel.="";
		}
		if($value == null){
			$this->view->isNullPost('value');
			$value = $this->input->post('value');
		}
		$value.="";
		switch ($variabel){
			case 'TA1' : 
				$this->mahasiswa->isAvailableRoomTASOn($value);
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}