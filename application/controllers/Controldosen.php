<?php
	if(!defined("BASEPATH")) exit("You dont have permission");
	class Controldosen extends CI_Controller {
		public function __CONSTRUCT(){
			parent::__CONSTRUCT();
			$this->load->library("koordinator");
			$this->load->library("dosen");
			$this->load->library("mahasiswa");
			$this->load->library("view");
			$this->load->model("sc_ea");
			$this->load->model("sc_sd");
			$this->load->model("sc_st");
		}
		public function getLayoutDosen(){
			if(!$this->koordinator->getStatusLoginKoordinator())
				redirect(base_url().'Gateinout.aspx');
			echo"1";
			$this->load->view("Controlroom_room/Body_right/Dosen.php");
		}
		public function setNewStatusDosen(){
			if(!$this->koordinator->getStatusLoginKoordinator())
				redirect(base_url().'Gateinout.aspx');
			$kode = $this->view->isNullPost('kode');
			if($kode!="JASERVCONTROL")
				exit("0maaf, anda melakukan debugging");
			$nip = $this->view->isNullPost('nip');
			$stat = $this->view->isNullPost('status');
			if(intval($stat) != 0){
				if(intval($stat) != 1){
					exit("0maaf, anda melakukan debugging");
				}
			}
			//exit("0jojojo");
			$temp = $this->dosen->getCheckNip($nip,1);
			if(!$temp[0]){
				echo "0".$temp[1];
				return;
			}
			return $this->dosen->setStatusDosen($nip,$stat);
			
		}
		public function getJsonListMahasiswa(){
			if(!$this->koordinator->getStatusLoginKoordinator())
				redirect(base_url().'Gateinout.aspx');
			$nip = $this->view->isNullPost('nip');
			//$nip = "197905242009121003";
			if(!$this->dosen->getCheckNip($nip,1))
				exit("0Anda melakukan debuging");
			$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
			$rr = $this->dosen->getCheckNip($nip,1);
			if(!$rr[0])
				exit('0maaf, anda melakukan debugging');
			$this->sc_st->resetValue();
			$this->sc_st->setNip($nip);
			$this->sc_st->setKode($srt);
			$temp = $this->sc_st->getCountDosenPembimbing();
			$temp2="";
			if($temp > 0){
				$this->sc_st->getDataDosenPembimbing();
				while($this->sc_st->getNextCursor()){
					$this->sc_sm->resetValue();
					$this->sc_sm->setNim($this->sc_st->getNim());
					$this->sc_sm->getDataNim();
					$temp2.='["'.$this->sc_sm->getName().'",'.$this->sc_sm->getNim().',"upload/foto/'.$this->sc_sm->getFotoname().'"],';
				}
			}
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
			$json = '{"data": ['.$temp;
			$json .= ",[";
			$json .= $temp2;
			$json .= "]]}";
			echo "1".$json;
		}
		public function getTableDosen(){
			if(!$this->koordinator->getStatusLoginKoordinator())
				redirect(base_url().'Gateinout.aspx');
			$kode = $this->view->isNullPost('kode');
			if($kode!="JASERVCONTROL")
				exit("0maaf, anda melakukan debugging");
			//$temp = $this->dosen->getAllListDosen();
			$this->sc_sd->getAllListDosen();
			$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
			$rest="";
			$i=1;
			while($this->sc_sd->getNextCursor()){
				$rest.="<tr>";
				$rest.="<td>".$i."</td>";
				$rest.="<td>".$this->sc_sd->getNip()."</td>";
				$rest.="<td>".$this->sc_sd->getNama()."</td>";
				$rest.="<td>".$this->sc_sd->getBidang()."</td>";
				$rest.="<td>";
				$this->sc_st->resetValue();
				$this->sc_st->setNip($this->sc_sd->getNip());
				$this->sc_st->setKode($srt);
				$rest.="<input type='button' value='lihat (".$this->sc_st->getCountDosenPembimbing().")' class='btn btn-info' onclick='showListMahasiswaAmpuan(".'"'.$this->sc_sd->getNip().'"'.")'>";
				$rest.="</td>";
				$rest.="<td><select onchange='statusDosen(".'"'.$this->sc_sd->getNip().'"'.",this.value);'>";
				if(intval($this->sc_sd->getStatus()) == 1){
					$rest.= "<option value='0'>Tidak Aktif</option>".
							"<option  value='1' selected>Aktif</option>";
				}else{
					$rest.= "<option value='0' selected>Tidak Aktif</option>".
							"<option value='1'>Aktif</option>";
				}
				$rest.="</tr>";
				$i++;
			}
			if($i == 1)
				$rest.="<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
			echo "1".$rest;
		}
	}