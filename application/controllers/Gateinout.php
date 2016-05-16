<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Gateinout extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('mahasiswa');
		//$this->mahasiswa->setLockToUsePublic("JaservTech.Mahasiswa.Public.Control.Open");
		//$this->mahasiswa->setOpenPermission('sign-in',"JaservTech.Mahasiswa.SignIn.Controls");
		//$this->mahasiswa->setOpenPermission('sign-up',"JaservTech.Mahasiswa.SignUp.Controls");
		$this->load->library('inputjaservfilter');
		//$this->load->library('koordinator');
		//$this->koordinator->setLockToUsePublic("JaservTech.Koordinator.Public.Control.Open");
		if($this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url()."Classroom.jsp");
		
		//if($this->koordinator->getStatusLoginKoordinator())
		//	redirect(base_url()."Controlroom.jsp");
	}
	public function index(){
		$data['url_script'] = array(
				"resources/mystyle/js/gateinout.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js"
		);
		$data['url_link'] = array(
				"resources/mystyle/css/gateinout.css",
				"resources/mystyle/css/global-style.css"
		);
		$this->load->view('Gateinout_layout',$data);
	}
	public function getSignIn(){
		$this->isNullPost('login-akun');
		switch ($this->input->post('login-akun')){
			case 'mhs' :
				$this->isNullPost('login-nim');
				$this->isNullPost('login-password');
				$temp = $this->mahasiswa->setLoginMahasiswa($this->input->post('login-nim'),$this->input->post('login-password'));
				if($temp[0])
					echo "1".$temp[1];
				else
					echo "0".$temp[1];
				break;
			case 'dos' :
				break;
			case 'kor' :
				$this->isNullPost('login-nim');
				$this->isNullPost('login-password');
				$temp = $this->koordinator->setLoginKoordinator($this->input->post('login-nim'),$this->input->post('login-password'));
				if($temp[0])
					echo "1".$temp[1];
				else
					echo "0".$temp[1];
				break;
			case 'adm' :
				break;
		}
	}
	protected function isNullPost($a){
		if($this->input->post($a)===NULL)
			exit('0anda melakukan percobaan terhadap halaman, jangan lakukan itu');
	}
	public function getSignUp(){
		$this->isNullPost('daftar-nim');
		$this->isNullPost('daftar-nama');
		$this->isNullPost('daftar-apes');
		$this->isNullPost('daftar-kunci');
		$this->isNullPost('daftar-kuncire');
		$this->isNullPost('daftar-ntelp');
		$data = array(
				"nim" => $this->input->post('daftar-nim')."",
				"name" => $this->input->post('daftar-nama')."",
				"email" => $this->input->post('daftar-apes')."",
				"password" => $this->input->post('daftar-kunci')."",
				"password1" => $this->input->post('daftar-kuncire')."",
				"telephone" => $this->input->post('daftar-ntelp')."",
				"foto" => 'daftar-foto-exe',
				"trans" => 'daftar-trans-exe'
		);
		$this->mahasiswa->getStatusSignUpMahasiswa($data);
	}
	public function getCheck(){
			$this->isNullPost('variabel');
			$variabel = $this->input->post('variabel');
			$variabel.="";
			$this->isNullPost('value');
			$value = $this->input->post('value');
			$value.="";
		switch ($variabel){
			case 'login-nim' :
				$tempss = $this->mahasiswa->getCheckNim($value,1);
				if($tempss[0]){
					echo "1".$tempss[1];
				}else{
					$tempss = $this->koordinator->getCheckKodeUsername($value,1);
					if($tempss[0]){
						echo "1".$tempss[1];
					}else{
						echo "0".$tempss[1];
					}
				}
				break;
			case 'daftar-nim' :
				$temp = $this->mahasiswa->getCheckNim($value,1);
				if(!$temp[0]){
					echo "0".$temp[1];
					return ;
				}
				if($this->mahasiswa->getIsNimExist($value)){
					echo "0Nim sudah ada yang menggunakan, mohon gunakan nim yang lain";
				}else{
					echo "1Valid";
				}
				break;
			case 'login-password' :
				$tempss = $this->koordinator->getCheckPassword($value,1);
				if($tempss[0])
					echo "1".$tempss[1];
				else {
					$tempss = $this->mahasiswa->getCheckPassword($value,1);
					if($tempss[0]){
						echo "1".$tempss[1];
						break;
					}else{
						echo "0".$tempss[1];
					}
				}
				break;
			case 'daftar-kunci' :
			case 'daftar-kuncire' :
				$this->mahasiswa->getCheckPassword($value);
				break;
			case 'daftar-nama' :
				$this->mahasiswa->getCheckName($value);
				break;
			case 'daftar-apes' :
				$this->mahasiswa->getCheckEmail($value);
				break;
			case 'daftar-ntelp' :
				$this->mahasiswa->getCheckNuTelphone($value);
				break;
			case 'login-akun' :
				switch ($value) {
					case 'mhs' :
					case 'dos' :
					case 'kor' :
					case 'adm' :
						echo '1valid';
						break;
					default:
						echo '0anda merubah default kategori';
				}
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}