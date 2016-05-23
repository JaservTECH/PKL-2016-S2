<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Gateinout extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('mahasiswa');
		$this->load->library('inputjaservfilter');
		$this->load->library('koordinator');
		if($this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url()."Classroom.aspx");
		
		if($this->koordinator->getStatusLoginKoordinator())
			redirect(base_url()."Controlroom.aspx");
	}
	// default - valid
	public function index(){
		$TEMP_ARRAY['url_script'] = array(
				"resources/mystyle/js/gateinout.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js"
		);
		$TEMP_ARRAY['url_link'] = array(
				"resources/mystyle/css/gateinout.css",
				"resources/mystyle/css/global-style.css"
		);
		$this->load->view('Gateinout_layout',$TEMP_ARRAY);
	}
	//sign session - valid
	public function getSignIn(){
		$this->isNullPost('login-akun');
		switch ($this->input->post('login-akun')){
			case 'mhs' :
				$this->isNullPost('login-nim');
				$this->isNullPost('login-password');
				$this->mahasiswa->setLoginMahasiswa($this->input->post('login-nim'),$this->input->post('login-password'));
				break;
			case 'dos' :
				break;
			case 'kor' :
				$this->isNullPost('login-nim');
				$this->isNullPost('login-password');
				$this->koordinator->setLoginKoordinator($this->input->post('login-nim'),$this->input->post('login-password'));
				break;
			case 'adm' :
				break;
		}
	}
	//check null condition - valid
	protected function isNullPost($TEMP_NAME){
		if($this->input->post($TEMP_NAME) === NULL)
			exit('0'.$TEMP_NAME." bernilai null");
	}
	//sign Up session - valid
	public function getSignUp(){
		$this->isNullPost('daftar-nim');
		$this->isNullPost('daftar-nama');
		$this->isNullPost('daftar-apes');
		$this->isNullPost('daftar-kunci');
		$this->isNullPost('daftar-kuncire');
		$this->isNullPost('daftar-ntelp');
		$TEMP_ARRAY = array(
				"nim" => $this->input->post('daftar-nim')."",
				"name" => $this->input->post('daftar-nama')."",
				"email" => $this->input->post('daftar-apes')."",
				"password" => $this->input->post('daftar-kunci')."",
				"password1" => $this->input->post('daftar-kuncire')."",
				"telephone" => $this->input->post('daftar-ntelp')."",
				"foto" => 'daftar-foto-exe',
				"trans" => 'daftar-trans-exe'
		);
		$this->mahasiswa->getStatusSignUpMahasiswa($TEMP_ARRAY);
	}
	//check Type of input - valid
	public function getCheck(){
			$this->isNullPost('variabel');
			$TEMP_NAME_VARIABLE = $this->input->post('variabel');
			$TEMP_NAME_VARIABLE.="";
			$this->isNullPost('value');
			$TEMP_NAME_VALUE = $this->input->post('value');
			$TEMP_NAME_VALUE.="";
		switch ($TEMP_NAME_VARIABLE){
			case 'login-nim' :
				$TEMP_ARRAY = $this->mahasiswa->getCheckNim($TEMP_NAME_VALUE,1);
				if($TEMP_ARRAY[0]){
					echo "1".$TEMP_ARRAY[1];
				}else{
					$TEMP_ARRAY = $this->koordinator->getCheckKodeUsername($TEMP_NAME_VALUE,1);
					if($TEMP_ARRAY[0]){
						echo "1".$TEMP_ARRAY[1];
					}else{
						echo "0".$TEMP_ARRAY[1];
					}
				}
				break;
			case 'daftar-nim' :
				$TEMP_ARRAY = $this->mahasiswa->getCheckNim($TEMP_NAME_VALUE,1);
				if(!$TEMP_ARRAY[0]){
					echo "0".$TEMP_ARRAY[1];
					return ;
				}
				if($this->mahasiswa->getIsNimExist($TEMP_NAME_VALUE)){ //methode repaired
					echo "0Nim sudah ada yang menggunakan, mohon gunakan nim yang lain";
				}else{
					echo "1Valid";
				}
				break;
			case 'login-password' :
				$TEMP_ARRAY = $this->koordinator->getCheckPassword($TEMP_NAME_VALUE,1);
				if($TEMP_ARRAY[0])
					echo "1".$TEMP_ARRAY[1];
				else {
					$TEMP_ARRAY = $this->mahasiswa->getCheckPassword($TEMP_NAME_VALUE,1);
					if($TEMP_ARRAY[0]){
						echo "1".$TEMP_ARRAY[1];
						break;
					}else{
						echo "0".$TEMP_ARRAY[1];
					}
				}
				break;
			case 'daftar-kunci' :
			case 'daftar-kuncire' :
				$this->mahasiswa->getCheckPassword($TEMP_NAME_VALUE);
				break;
			case 'daftar-nama' :
				$this->mahasiswa->getCheckName($TEMP_NAME_VALUE);
				break;
			case 'daftar-apes' :
				$this->mahasiswa->getCheckEmail($TEMP_NAME_VALUE);
				break;
			case 'daftar-ntelp' :
				$this->mahasiswa->getCheckNuTelphone($TEMP_NAME_VALUE);
				break;
			case 'login-akun' :
				switch ($TEMP_NAME_VALUE) {
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