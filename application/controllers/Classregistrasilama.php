<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Classregistrasilama extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('mahasiswa');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->library('view');
		$this->load->library('dosen');
		$this->load->model('sc_st');
		$this->load->model('sc_sm');
		$this->load->model('sc_ea');
		$this->load->helper('url');
		$this->load->helper('html');
		
	}
	//get data for form is exist before
	public function getJsonDataTA(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$temps = $this->mahasiswa->getCodeRegLastTA();
		if($temps[0]){
			$temp = $this->mahasiswa->getTAInfo($temps[1],array('judulta',"dosbing"));
			$temp2="{";
			$temp2.=$this->getGenerateSimpleJson("judulta", $temp[1]['judulta']).",";
			$temp2.=$this->getGenerateSimpleJson("dosbing", $temp[1]['dosbing']);
			$temp2.="}";
			echo $temp2;
			return true;
		}else{
			$temp2="{";
			$temp2.=$this->getGenerateSimpleJson("judulta", null).",";
			$temp2.=$this->getGenerateSimpleJson("dosbing", null);
			$temp2.="}";
			echo $temp2;
			return true;
		}
	}
	//refreshing data form
	public function getJsonDataPersonal(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$temp = $this->mahasiswa->getDataPersonal();
		$temp2="{";
		$temp2.=$this->getGenerateSimpleJson("nama", $temp['nama']).",";
		$temp2.=$this->getGenerateSimpleJson("nim", $temp['nim']).",";
		$temp2.=$this->getGenerateSimpleJson("nohp", $temp['nohp']).",";
		$temp2.=$this->getGenerateSimpleJson("email", $temp['email']).",";
		$temp2.=$this->getGenerateSimpleJson("ortu", $temp['ortu']).",";
		$temp2.=$this->getGenerateSimpleJson("nohportu", $temp['nohportu']).",";
		$temp2.=$this->getGenerateSimpleJson("minat", $temp['minat']);
		$temp2.="}";
		echo $temp2;
		return true;
	}
	
	/*registrasi lama*/
	public function getLayoutRegistrasiLama(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		//check is register permission
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			$TEMP_ARRAY['message'] = "Maaf, anda sudah melakukan registrasi, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return;
		}
		//filter
		$this->sc_sm->getDataNim($this->mahasiswa->getNimSessionLogin());
		$CODE_PERMISSION = "1".$this->sc_sm->getForceRegNew()."".$this->sc_sm->getForceRegLama()."";
		$this->sc_sm->resetValue();
		//check is register Time
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
			echo"0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return ;
		}
		//check data from other semester before
		$ARRAY_CODE = $this->mahasiswa->getCodeRegLastTA();
		//check if is registerer on this Academic Year
		$this->sc_st->resetValue();
		$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
		$this->sc_st->setKode($this->mahasiswa->getYearNow());
		$TEMP_BOOLEAN = $this->sc_st->getHaveLastTAInfo();
		//filltering code
		if(!$ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 111 :
				case 122 :
				//registerasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Judul Ta anda tidak ditemukan dimanapun, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
						'but2' => 'form baru'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
				break;
				case 121 :
				case 112 :
				//neutrallized
				break;
			}
		}else if(!$ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 111 :
				//neutrallized
				break;
				case 121 :
				//registerasi lama
				$TEMP_ARRAY['listdosen'] = $this->dosen->getListDosen();
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_lama",$TEMP_ARRAY);
				return;
				break;
				case 112 :
				//registerasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda diberikan izin perubahan judul, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
						'but2' => 'form baru'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				//registerasi lama
				$TEMP_ARRAY['listdosen'] = $this->dosen->getListDosen();
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_lama",$TEMP_ARRAY);
				return;
				break;
				case 112 :
				//registrasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda diberikan izin perubahan judul, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
						'but2' => 'form baru'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
				break;
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}else if($ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				//registerasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda diberikan izin perubahan judul, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
						'but2' => 'form baru'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
				break;
				case 122 :
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}
	}
	//registrasi lama proses and get result of process
	public function getResultRegistrasiLama(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			exit("0Anda mencoba register secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		//filter
		$this->sc_sm->getDataNim($this->mahasiswa->getNimSessionLogin());
		$CODE_PERMISSION = "1".$this->sc_sm->getForceRegNew()."".$this->sc_sm->getForceRegLama()."";
		$this->sc_sm->resetValue();
		//check is register Time
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
			echo"0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return ;
		}
		//check data from other semester before
		$ARRAY_CODE = $this->mahasiswa->getCodeRegLastTA();
		//check if is registerer on this Academic Year
		$this->sc_st->resetValue();
		$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
		$this->sc_st->setKode($this->mahasiswa->getYearNow());
		$TEMP_BOOLEAN = $this->sc_st->getHaveLastTAInfo();
		//filltering code
		if(!$ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 111 :
				case 122 :
				case 121 :
				case 112 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if(!$ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 111 :
				case 112 :
				//registerasi baru
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				case 122 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}
		//execute
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			exit("0Anda mencoba registrasi secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		$tempDataPersonal = $this->mahasiswa->getDataPersonal();
		$tempDataTa = $this->mahasiswa;
		//Nama
		if($tempDataPersonal['nama'] === NULL){
			$this->view->isNullPost('lama-nama');
			$dataTemp['nama'] = $this->input->post('lama-nama');
			$this->getCheck('lama-nama',$dataTemp['nama'],true);
		}else{
			$dataTemp['nama'] = $tempDataPersonal['nama'];
		}
		//Nim
		if($tempDataPersonal['nim'] === NULL){
			$this->view->isNullPost('lama-nim');
			$dataTemp['nim'] = $this->input->post('lama-nim');
			$this->getCheck('lama-nim',$dataTemp['nim'],true);
		}else{
			$dataTemp['nim'] = $tempDataPersonal['nim'];
		}
		//Email
		if($tempDataPersonal['email'] === NULL){
			$this->view->isNullPost('lama-email');
			$dataTemp['email'] = $this->input->post('lama-email');
			$this->getCheck('lama-email',$dataTemp['email'],true);
		}else{
			$dataTemp['email'] = $tempDataPersonal['email'];
		}
		//nohp
		if($tempDataPersonal['nohp'] === NULL){
			$this->view->isNullPost('lama-nohp');
			$dataTemp['nohp'] = $this->input->post('lam-nohp');
			$this->getCheck('lama-nohp',$dataTemp['nohp'],true);
		}else{
			$dataTemp['nohp'] = $tempDataPersonal['nohp'];
		}
		//nohportu
		if($tempDataPersonal['nohportu'] === NULL){
			$this->view->isNullPost('lama-nohportu');
			$dataTemp['nohportu'] = $this->input->post('lama-nohportu');
			$this->getCheck('lama-nohportu',$dataTemp['nohportu'],true);
		}else{
			$dataTemp['nohportu'] = $tempDataPersonal['nohportu'];
		}
		//ortu
		if($tempDataPersonal['ortu'] === NULL){
			$this->view->isNullPost('lama-ortu');
			$dataTemp['ortu'] = $this->input->post('lama-ortu');
			$this->getCheck('lama-ortu',$dataTemp['ortu'],true);
		}else{
			$dataTemp['ortu'] = $tempDataPersonal['ortu'];
		}
		$temps = $this->mahasiswa->getCodeRegLastTA();
		if(!$temps[0]){
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if(!$this->sc_st->getHaveLastTAInfo($this->mahasiswa->getYearNow())){				
				echo "0Maaf, anda mencoba memasukan paksa form registrasi lama";
				return ;
			}else{
				$temps[1] = $this->mahasiswa->getYearNow();
			}
		}
		$dataTemp['codeRegist'] = $temps[1];
		$dataTemp['codereg'] = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$this->view->isNullPost('lama-judulta');
		$dataTemp['judulta'] = $this->input->post('lama-judulta');
		$this->getCheck('lama-judulta',$dataTemp['judulta'],true);
		$this->view->isNullPost('lama-dosbing');
		$dataTemp['dosbing'] = $this->input->post('lama-dosbing');
		$dataTemp['newf'] = 2;
		$dataTemp['krs'] = 'lama-krs';
		$temp = $this->mahasiswa->setRegistrasiLama($dataTemp);
		if(!$temp[0]){
			echo "0".$temp[1];
		}else{
			echo "1";
			$data['data'] = "Data berhasil dimasukan, terima kasih atas waktunya";
			$this->load->view("Classroom_room/Body_right/success_registrasi",$data);
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
			case 'date-is-available' : 
				if($type){
					
				}else{
					$this->mahasiswa->isAnyGuysOnThisDay($value,1);
				}
				break;
			case 'lama-nim' :
				if($type){
					$temp = $this->mahasiswa->getCheckNim($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckNim($value);
				break;
			case 'lama-nama' : 
			case 'lama-ortu' :
				if($type){
					$temp = $this->mahasiswa->getCheckName($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckName($value);
				break;
			case 'lama-email' :
				if($type){
					$temp = $this->mahasiswa->getCheckEmail($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckEmail($value);
				break;
			case 'lama-nohp' :
			case 'lama-nohportu' :
				if($type){
					$temp = $this->mahasiswa->getCheckNuTelphone($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckNuTelphone($value);
				break;
			case 'lama-dosbing'	:
				if($type){
					if(intval($value) == 0)
						exit("0Tidak boleh kosong");
					$temp = $this->dosen->getIsNipExistActive($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->dosen->getIsNipExistActive($value);
				break;
			case 'lama-judulta' :
				if($type){
					$temp = $this->mahasiswa->getCheckTitleFinalTask($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckTitleFinalTask($value);
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}