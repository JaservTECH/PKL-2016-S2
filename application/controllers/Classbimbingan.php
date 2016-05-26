<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Classbimbingan extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('mahasiswa');
		$this->load->library('dosen');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->library('view');
		$this->load->model('sc_st');
		$this->load->model('sc_sm');
		$this->load->model('sc_sd');
		$this->load->helper('url');
		$this->load->helper('html');
	}
	//sessi bimbingan
	public function getLayoutBimbingan(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->sc_st->resetValue();
		$this->sc_st->setKode($this->mahasiswa->getYearNow());
		$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
		$this->sc_st->getHaveLastTAInfo();
		if(intval($this->sc_st->getNip()) == 0){
			$TEMP_ARRAY['TEMP_NIP'] = "Belum tersedia";
			$TEMP_ARRAY['TEMP_NAMA'] = "Belum tersedia"; 
			$TEMP_ARRAY['TEMP_BIDANG'] = "Belum tersedia";
			$TEMP_ARRAY['TEMP_DATA'][0] = array(
				'NO' => "-",
				'NIM' => "-",
				'NAMA' => "-",
				'TITLE' => "-",
				'STATUE' => "-"
			); 			
		}else{
			$this->sc_sd->setNip($this->sc_st->getNip());
			$this->sc_sd->getDosenInfo();
			$TEMP_ARRAY['TEMP_NIP'] = $this->sc_sd->getNip();
			$TEMP_ARRAY['TEMP_NAMA'] = $this->sc_sd->getNama(); 
			$TEMP_ARRAY['TEMP_BIDANG'] = $this->sc_sd->getBidang();
			$this->sc_st->resetValue();
			$this->sc_st->setNip($this->sc_sd->getNip());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if($this->sc_st->getAllDateTABimbingan()){
				$i=0;
				while($this->sc_st->getNextCursor()){
					$TEMP_CAT = "lama"; 
					if(intval($this->sc_st->getKategori()) == 1)
						$TEMP_CAT = 'baru';
					$this->sc_sm->getDataNim($this->sc_st->getNim());
					$TEMP_ARRAY['TEMP_DATA'][$i] = array(
						'NO' =>$i+1,
						'NIM' => $this->sc_st->getNim(),
						'NAMA' => $this->sc_sm->getName(),
						'TITLE' => $this->sc_st->getJudulTa(),
						'STATUE' => $TEMP_CAT
					);
					$i++;
				}
			}else{
				$TEMP_ARRAY['TEMP_DATA'][0] = array(
					'NO' => "-",
					'NIM' => "-",
					'NAMA' => "-",
					'TITLE' => "-",
					'STATUE' => "-"
				); 				
			}
		}
		$this->sc_sd->getListDosenActive();
		$i=0;
		while($this->sc_sd->getNextCursor()){
			$TEMP_ARRAY['DATA_DOSEN'][$i] = array(
				'NO' => $i+1,
				'NIP' => $this->sc_sd->getNip(),
				'NAMA' => $this->sc_sd->getNama()
			);
			$i++;
		}
		echo "1";
		$this->load->view("Classroom_room/Body_right/bimbingan",$TEMP_ARRAY);
	}
	//get contact list
	public function getJsonListMahasiswa(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->view->isNullPost('nip');
		$nip = $this->input->post('nip');
		if(!$this->dosen->getCheckNip($nip,1))
			exit("0Anda melakukan debuging");
		$this->sc_st->resetValue();
		$this->sc_st->setNip($nip);
		$this->sc_st->setKode($this->mahasiswa->getYearNow());
		$tes = 0;
		$temp2="";
		if($this->sc_st->getAllDateTABimbingan()){
			$i=0;
			while($this->sc_st->getNextCursor()){$tes +=1;
				$this->sc_sm->getDataNim($this->sc_st->getNim());
				$temp2.='["'.$this->sc_sm->getName().'",'.$this->sc_sm->getNim().',"upload/foto/'.$this->sc_sm->getFotoname().'"],';
			}
		}else{
			$temp2.='["-","-","upload/foto/-user.jpg"],';			
		}
		$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": ['.$tes;
		$json .= ",[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	
}