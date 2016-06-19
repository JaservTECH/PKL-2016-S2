<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Classseminartad extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('mahasiswa');
		$this->load->library('view');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->helper('url');
		$this->load->helper('html');
		
		$this->prosesOpen = false;
		$ERROR_PROSSES_OPEN = 0;
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckSeminarPermission(2))
			$ERROR_PROSSES_OPEN++;
		$this->load->model('sc_st');
		$this->sc_st->resetValue();
		$this->sc_st->setKode($this->mahasiswa->getYearNow());
		$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_st->isHaveRegisteredOnThisSemesterAndValid())
			$ERROR_PROSSES_OPEN++;
		if($ERROR_PROSSES_OPEN == 0)
			$this->prosesOpen = true;
		
	}
	public function getLayoutTaD(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		
		
		
		if($this->prosesOpen){			
			$pengantar_upload_state = true;
			$this->sc_std->resetValue();
			$this->sc_std->setKode($this->mahasiswa->getYearNow());
			$this->sc_std->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_std->getDataPrimaryActive();
			if($this->sc_std->getKode() != NULL){
				if(intval($this->sc_std->getDocppp()) == 2){
					if(intval($this->sc_std->getKategori()) == 1){
						$pengantar_upload_state = false;
					}
				}
			}
			$data['pengantar'] = $pengantar_upload_state;
			echo "1";
			//send kode that is have pengantar or not to javascript for understanding
			if($pengantar_upload_state)
				echo "1";
			else
				echo "2";
			$this->load->view("Classroom_room/Body_right/seminar_ta2",$data); 			
		}else{
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 1, dikarenakan anda sudah pernah, atau anda sudah harus lanjut ke seminar ta 2. Terima kasih";
			echo "03";
			$this->load->view("Classroom_room/Body_right/warning-no-button-seminar-ta",$DATA);
		}
		
		
		/* 
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if($this->sc_sm->getCheckSeminarPermission(2)){
			echo "1";
			$this->load->view("Classroom_room/Body_right/seminar_ta2"); 			
		}else{
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan belum pernah, atau anda tidak ada izin seminar ta 2, kontak admin (mbak nisa). Terima kasih";
			echo "0";
			$this->load->view("Classroom_room/Body_right/warning-no-button-seminar-ta",$DATA);
		} */
	}
	public function setSeminarTA2(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if(!$this->prosesOpen){
			echo "0maaf anda tidak memiliki izin set seminar secara paksa";
			exit();
		}
		$this->view->isNullPost("s_tanggald");
		$DATE_SEMINAR = $this->input->post('s_tanggald');
		$this->view->isNullPost('s_ruangd');
		$ROOM_SEMINAR = $this->input->post('s_ruangd');
		//exit("0".$DATE_SEMINAR." ".$this->getCheck($ROOM_SEMINAR,$DATE_SEMINAR,true)[1]."");
		//echo "0kokok";
		if(!$this->getCheck($ROOM_SEMINAR,$DATE_SEMINAR,true)[0]){
			echo "0Inputan anda tidak valid, anda melakukan debugging";
			exit();
		}
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckSeminarPermission(2)){
			echo "0anda sudah tidak memiliki hak seminar TA 1, karena anda sudah mendaftar dan sedang di proses";
			exit();
		}
		switch($ROOM_SEMINAR){
			case 'TA1' :
			$ROOM_SEMINAR = 1;
			break;
			case 'TA2' :
			$ROOM_SEMINAR = 2;
			break;
			case 'MAT' :
			$ROOM_SEMINAR = 3;
			break;
			default :
			echo "0anda sudah tidak memiliki hak seminar TA 1, karena anda sudah mendaftar dan sedang di proses";
			exit();
			break;
		}
		$this->sc_st->resetValue();
		$this->sc_st->setKode($this->mahasiswa->getYearNow());
		$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
		$this->sc_st->getNipRegisteredOnThisSemesterAndValid();
		$DATA_ARRAY = array(
		'pengantar' => 's-pengantard',
		'transkrip' => 's-transkripd',
		'kartbim' => 's-k-bimbingand',
		'kartsemta' => 's-k-pesertad',
		'datestart' => $DATE_SEMINAR,
		'ruang' => $ROOM_SEMINAR,
		'dosen' => $this->sc_st->getNip()
		);
		//exit("0ready to mahasiswa");
		$ff = $this->mahasiswa->setSeminarTA2($DATA_ARRAY);
		if(intval($ff[0]) == 1){
			echo "1";
			$this->load->view("Classroom_room/Body_right/success_registrasi",array("data"=> "Terima kasih, Data Anda berhasil dimasukan, status diproses seleksi dosen penguji")); 
		}else{
			echo "0".$ff[1];
		}
		//process to mahasiswa
		
		/* 
		
		
		
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->view->isNullPost("DATE_SEMINAR");
		$DATE_SEMINAR = $this->input->post('DATE_SEMINAR');
		$this->view->isNullPost('ROOM_SEMINAR');
		$ROOM_SEMINAR = $this->input->post('ROOM_SEMINAR');
		if(!$this->getCheck($ROOM_SEMINAR,$DATE_SEMINAR,true)[0]){
			echo "0Inputan anda tidak valid, anda melakukan debugging";
			exit();
		}
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckSeminarPermission(2)){
			echo "0anda sudah tidak memiliki hak seminar TA 2, karena anda sudah mendaftar dan sedang di proses";
			exit();
		}
		//process to mahasiswa */
		
	}
	public function getJSONDataSeminarTA1AndTA2(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa()){
			echo "0Slilahkan refresh halaman untuk melanjutkan proses anda";
			return;
		}
		$this->sc_std->resetValue();
		$this->sc_std->setKode($this->mahasiswa->getYearNow());
		$this->sc_std->setRuang(1);
		//$this->sc_std->setKategori(1);		
		$data[1]['kode'] = false;
		$i=0;
		if($this->sc_std->getDataActiveTabelOnSemester()){
			$data[1]['kode'] = true;
			while($this->sc_std->getNextCursor()){
				$this->sc_sm->resetValue();
				$this->sc_sm->setNim($this->sc_std->getNim());
				$this->sc_sm->getDataNim();
				$data[1][$i]['nama'] = $this->sc_sm->getName();
				$data[1][$i]['tanggal'] = $this->sc_std->getTanggal();
				$i++;
			}
			
		}
		$this->load->model("sc_arte");
		$this->sc_arte->resetValue();
		if($this->sc_arte->getAllData(1)){
			$data[1]['kode'] = true;
			while($this->sc_arte->getNextCursor()){
				$data[1][$i]['nama'] = $this->sc_arte->getName();
				$data[1][$i]['tanggal'] = $this->sc_arte->getTanggal();
				$i++;
			}
		}
		$data[1]['content'] = $i;
		$i=0;
		$this->sc_std->resetValue();
		$this->sc_std->setKode($this->mahasiswa->getYearNow());
		//$this->sc_std->setKategori(2);		
		$this->sc_std->setRuang(2);
		$data[2]['kode'] = false;
		$i=0;
		if($this->sc_std->getDataActiveTabelOnSemester()){
			$data[2]['kode'] = true;
			while($this->sc_std->getNextCursor()){
				$this->sc_sm->resetValue();
				$this->sc_sm->setNim($this->sc_std->getNim());
				$this->sc_sm->getDataNim();
				$data[2][$i]['nama'] = $this->sc_sm->getName();
				$data[2][$i]['tanggal'] = $this->sc_std->getTanggal();
				$i++;
			}
			
		}
		$this->sc_arte->resetValue();
		if($this->sc_arte->getAllData(2)){
			$data[2]['kode'] = true;
			while($this->sc_arte->getNextCursor()){
				$data[2][$i]['nama'] = $this->sc_arte->getName();
				$data[2][$i]['tanggal'] = $this->sc_arte->getTanggal();
				$i++;
			}
		}
		$data[2]['content'] = $i;
		echo "1".json_encode($data);
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
		/* $variabel = "TA2";
		$value = "2016-06-15 09:00:00"; */
		$value.="";
		switch ($variabel){
			case 'TA1' : 
				if($type)
					return $this->mahasiswa->isAvailableRoomTASOn($value,1,NULL,1);
				else
					$this->mahasiswa->isAvailableRoomTASOn($value,1,NULL,0);
				break;
			case 'TA2' : 
				if($type)
					return $this->mahasiswa->isAvailableRoomTASOn($value,2,NULL,1);
				else
					$this->mahasiswa->isAvailableRoomTASOn($value,2,NULL,0);
				break;
			case 'MAT' :
				$ERROR = 0;
				$this->load->helper('date');
				if(nice_date($value,"Y-m-d H:i:s") == "Invalid Date"){
					if($type)
						return array(false,"data tidak valid");
					else
						return "0Anda melakukan percobaan Inputan";
				}
				$value = nice_date($value,"Y-m-d H:i:s");
				if(intval(nice_date($value,"H")) < intval(date("H"))){
					$ERROR += 1;
				}else if(intval(nice_date($value,"H")) == intval(nice_date("H"))){
					if(intval(nice_date($value,"m")) < intval(nice_date("m"))){
						$ERROR+=1;
					}else if(intval(nice_date($value,"m")) == intval(nice_date("m"))){
						if(intval(nice_date($value,"d")) < intval(nice_date("d"))+1){
							$ERROR+=1;
						}
					}
				}
				if($ERROR > 0){
					if($type)
						return array(false,"data tidak valid");
					else
						return "0Anda melakukan percobaan Inputan";
				}else{
					if($type)
						return array(true,"waktu valid");
					else
						return "1waktu valid";
				}
				//$this->mahasiswa->isAvailableRoomTASOn($value,1,NULL,0);
				break;
			default :
				if($type)
					return array(false,"kode tidak valid");
				else
					echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}