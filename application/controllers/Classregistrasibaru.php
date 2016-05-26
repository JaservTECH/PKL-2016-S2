<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Classregistrasibaru extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('mahasiswa');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->library('view');
		$this->load->model('sc_st');
		$this->load->model('sc_sm');
		$this->load->model('sc_ea');
		$this->load->helper('url');
		$this->load->helper('html');
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
	//registrasi baru
	public function getLayoutRegistrasiBaru(){
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
				$TEMP_ARRAY = NULL;
				$TEMP_ARRAY['peminatan'] = $this->mahasiswa->getListPeminatan(); 
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_baru",$TEMP_ARRAY);	
				return;
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
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda mahasiswa lama , silahkan melanjutkan registrasi lama TA anda',
						'but2' => 'form lama'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
				break;
				case 112 :
				//registerasi baru
				$TEMP_ARRAY = NULL;
				$TEMP_ARRAY['peminatan'] = $this->mahasiswa->getListPeminatan(); 
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_baru",$TEMP_ARRAY);	
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				//registerasi lama
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Telah ditemukan data Ta anda, anda yakin ingin membuat baru? konsultasikan dengan dosen pembimbing anda. dan kontak admin(mbak nisa untuk mengaktifkan perubahan)',
						'but2' => 'form lama'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
				break;
				case 112 :
				//registrasi baru
				$TEMP_ARRAY = NULL;
				$TEMP_ARRAY['peminatan'] = $this->mahasiswa->getListPeminatan(); 
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_baru",$TEMP_ARRAY);	
				return;
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
				$TEMP_ARRAY = NULL;
				$TEMP_ARRAY['peminatan'] = $this->mahasiswa->getListPeminatan(); 
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_baru",$TEMP_ARRAY);	
				return;
				break;
				case 122 :
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}
	}
	public function getResultRegistrasiBaru(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			exit("0Anda mencoba register secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		//session filter
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
				case 121 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}
		
		//		
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			exit("0Anda mencoba registrasi secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		$tempDataPersonal = $this->mahasiswa->getDataPersonal();
		//Nama
		if($tempDataPersonal['nama'] === NULL){
			$this->view->isNullPost('baru-nama');
			$dataTemp['nama'] = $this->input->post('baru-nama');
			$this->getCheck('baru-nama',$dataTemp['nama'],true);	
		}else{
			$dataTemp['nama'] = $tempDataPersonal['nama'];		
		}
		//Nim
		if($tempDataPersonal['nim'] === NULL){
			$this->view->isNullPost('baru-nim');
			$dataTemp['nim'] = $this->input->post('baru-nim');
			$this->getCheck('baru-nim',$dataTemp['nim'],true);
		}else{
			$dataTemp['nim'] = $tempDataPersonal['nim'];
		}
		//Email
		if($tempDataPersonal['email'] === NULL){
			$this->view->isNullPost('baru-email');
			$dataTemp['email'] = $this->input->post('baru-email');
			$this->getCheck('baru-email',$dataTemp['email'],true);
		}else{
			$dataTemp['email'] = $tempDataPersonal['email'];
		}
		//minat
		if($tempDataPersonal['minat'] === NULL){
			$this->view->isNullPost('baru-minat');
			$dataTemp['minat'] = $this->input->post('baru-minat');
			$this->getCheck('baru-minat',$dataTemp['minat'],true);
		}else{
			$dataTemp['minat'] = $tempDataPersonal['minat'];
		}
		//nohp
		if($tempDataPersonal['nohp'] === NULL){
			$this->view->isNullPost('baru-nohp');
			$dataTemp['nohp'] = $this->input->post('baru-nohp');
			$this->getCheck('baru-nohp',$dataTemp['nohp'],true);
		}else{
			$dataTemp['nohp'] = $tempDataPersonal['nohp'];
		}
		//nohportu
		if($tempDataPersonal['nohportu'] === NULL){
			$this->view->isNullPost('baru-nohportu');
			$dataTemp['nohportu'] = $this->input->post('baru-nohportu');
			$this->getCheck('baru-nohportu',$dataTemp['nohportu'],true);
		}else{
			$dataTemp['nohportu'] = $tempDataPersonal['nohportu'];
		}
		//ortu
		if($tempDataPersonal['ortu'] === NULL){
			$this->view->isNullPost('baru-ortu');
			$dataTemp['ortu'] = $this->input->post('baru-ortu');
			$this->getCheck('baru-ortu',$dataTemp['ortu'],true);
		}else{
			$dataTemp['ortu'] = $tempDataPersonal['ortu'];
		}
		//
		$this->view->isNullPost('baru-judulta');
		$dataTemp['judulta'] = $this->input->post('baru-judulta');
		$this->getCheck('baru-judulta',$dataTemp['judulta'],true);

		$this->view->isNullPost('baru-lokasi');
		$dataTemp['lokasi'] = $this->input->post('baru-lokasi');
		$this->getCheck('baru-lokasi',$dataTemp['lokasi'],true);
		
		$this->view->isNullPost('baru-metode');
		$dataTemp['metode'] = $this->input->post('baru-metode');
		$this->getCheck('baru-metode',$dataTemp['metode'],true);
		$this->view->isNullPost('baru-ref1');
		$dataTemp['ref1'] = $this->input->post('baru-ref1'); 
		$this->getCheck('baru-ref1',$dataTemp['ref1'],true);
		if($this->input->post('baru-ref2') === null)
			$dataTemp['ref2'] = "";
		else {
			$dataTemp['ref2'] = $this->input->post('baru-ref2');
			if($dataTemp['ref2'] != "")
				$this->getCheck('baru-ref2',$dataTemp['ref2'],true);
		}
		
		if($this->input->post('baru-ref3') === null)
			$dataTemp['ref3'] = ""; 
		else {
			$dataTemp['ref3'] = $this->input->post('baru-ref3');
			if($dataTemp['ref3'] != "")
				$this->getCheck('baru-ref3',$dataTemp['ref3'],true);	
		}
		$dataTemp['krs'] = 'baru-krs';
		$dataTemp['codereg'] = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		//exit("0".$dataTemp['codereg']);
		$this->sc_sm->getDataNim($this->session->userdata('nim'));
		if(intval($this->sc_sm->getForceRegLama()) == 1){
			$dataTemp['newf'] = 1;
		}else{
			$dataTemp['newf'] = 2;
		}
		//foreach($dataTemp as $k => $value){
		//	echo $k." ".$value."<br>";
		//}
		$temp = $this->mahasiswa->setRegistrasiBaru($dataTemp);
		if(!$temp[0]){
			echo "0".$temp[1];
		}else{
			echo "1";
			$data['data'] = "Data berhasil dimasukan, terima kasih atas waktunya";
			$this->load->view("Classroom_room/Body_right/success_registrasi",$data);
		}
		//echo 'succes';
		return;
	}
	//
	public function getCheck($variabel=null,$value=null,$type=false){
		if($variabel == null){
			$this->isNullPost('variabel');
			$variabel = $this->input->post('variabel');
			$variabel.="";
		}
		if($value == null){
			$this->isNullPost('value');
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
			case 'baru-nim' :
				if($type){
					$temp = $this->mahasiswa->getCheckNim($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckNim($value);
				break;
			case 'baru-nama' :
			case 'baru-ortu' :
				if($type){
					$temp = $this->mahasiswa->getCheckName($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckName($value);
				break;
			case 'baru-email' :
				if($type){
					$temp = $this->mahasiswa->getCheckEmail($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckEmail($value);
				break;
			case 'baru-nohp' :
			case 'baru-nohportu' :
				if($type){
					$temp = $this->mahasiswa->getCheckNuTelphone($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckNuTelphone($value);
				break;
			case 'baru-minat' :
				if($type){
					$temp = $this->mahasiswa->getCheckInterested($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckInterested($value);
				break;
			case 'baru-ref1' :
			case 'baru-ref2' :
			case 'baru-ref3' :
				if($type){
					$temp = $this->mahasiswa->getCheckRefrence($value,1);
					if(!$temp[0]){
						exit("0jj".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckRefrence($value);
				break;
			case 'baru-judulta' :
				if($type){
					$temp = $this->mahasiswa->getCheckTitleFinalTask($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckTitleFinalTask($value);
				break;
			case 'baru-metode' :
				if($type){
					$temp = $this->mahasiswa->getCheckMethode($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckMethode($value);
				break;
			case 'baru-lokasi' :
				if($type){
					$temp = $this->mahasiswa->getCheckLokasi($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckLokasi($value);
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}