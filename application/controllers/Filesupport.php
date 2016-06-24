<?php
if(!defined('BASEPATH')){
	redirect("/Gateinout");
}
class Filesupport extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("mahasiswa");
		$this->load->library("Koordinator");
		$this->load->library("Dosen");
		$this->load->library("Admin");
		$this->load->library("View");
		$this->load->helper("Download");
	}
	//mahasiswa
	public function getPhotoProfil(){
		
	}
	public function getPreviewPDFSeminarTA2($namafile = null){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		if($namafile == null){
			echo "0Maaf file tidak ditemukan";
			exit();
		}
		force_download("\upload\seminarta\seminarta2\pdf\$namafile.pdf",NULL);
	}
}