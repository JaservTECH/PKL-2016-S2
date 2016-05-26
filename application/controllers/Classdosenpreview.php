<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Classdosenpreview extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('dosen');
		$this->load->model('sc_sd');
		$this->load->model('sc_sm');
		$this->load->library('mahasiswa');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->library("view");
		$this->load->helper('url');
		$this->load->helper('html');
		
	}
	// - valid
	public function getListDosenAktif(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view('Classroom_room/Body_right/lihat_dosen');
	}
	// - valid
	public function getTableListDosen(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->view->isNullPost('kode');
		$kode = $this->input->post('kode');
		if($kode != 'JASERVTECH-KODE')
			exit("0anda melakukan debugging terhadap system");
		
		$i=1;
		$strings="";
		if($this->sc_sd->getListDosenActive()){
			while($this->sc_sd->getNextCursor()){
				$strings .= "<tr><td>".$i."</td><td>";
				$strings .= $this->sc_sd->getNip()."</td><td>" ;
				$strings .= $this->sc_sd->getNama()."</td>" ;
				$strings .= "
							<td>
								<div style='text-align : center;'>
									<div class='col-md-6'>
										<span class='icon-eye-open pointer' onclick='seeThisGuys(".'"'.$this->sc_sd->getNip().'"'.");' style='color : green' title='Lihat Profil Dosen : ya'></span>
									</div>
									";
				if($this->mahasiswa->getIsMyDosenReview($this->sc_sd->getNip()))
					$strings .=	"
									<div class='col-md-6'>
										<span class='icon-thumbs-up pointer' onclick='beNotMyFavorThisGuys(".'"'.$this->sc_sd->getNip().'"'.",2)' style='color:green' title='Dosen Favorit : ya'></span>
									</div>
									";
				else 

					$strings .=	"
									<div class='col-md-6'>
										<span class='icon-thumbs-up pointer' onclick='beMyFavorThisGuys(".'"'.$this->sc_sd->getNip().'"'.",2)' style='color:red' title='Dosen Favorit : tidak'></span>
									</div>
									";
				$strings .= "
								</div>
							</td></tr>
						";
				$i++;
			}
			echo "1".$strings;
		}else{
			exit("0Data Kosong, dosen tidak ada yang aktif");
		}
	}
	// -- valid
	public function getInfoDosenFull(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		//$_POST['nip'] = "197601102009122002";
		//$_POST['kode'] = "JASERVTECH-KODE";
		$this->view->isNullPost('kode');
		$this->view->isNullPost('nip');
		$temp = $this->input->post('kode');
		
		if($temp != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$this->dosen->getCheckNip($this->input->post('nip'),1)[0])
			exit('0anda melakukan debugging terhadap system');
		
		$this->sc_sd->setNip($this->input->post('nip'));
		if(!$this->sc_sd->getDosenInfo()){
			exit("0anda melakukan debugging terhadap system");
		}
		$intNo = 1;
		$yourTable = null;
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getTableDosenReview()){
			exit("0anda melakukan debugging terhadap system");
		}
		if(intval($this->sc_sm->getNipReview1()) != 0){
			$yourTable['nip_1'][0] = $intNo;
			$yourTable['nip_1'][1] = $this->sc_sm->getNipReview1();
			$this->sc_sd->resetValue();
			$this->sc_sd->setNip($this->sc_sm->getNipReview1());
			$this->sc_sd->getDosenInfo();
			$yourTable['nip_1'][2] = $this->sc_sd->getNama();
			$intNo++;
		}
		if(intval($this->sc_sm->getNipReview2()) != 0){
			$yourTable['nip_2'][0] = $intNo;
			$yourTable['nip_2'][1] = $this->sc_sm->getNipReview2();
			$this->sc_sd->resetValue();
			$this->sc_sd->setNip($this->sc_sm->getNipReview2());
			$this->sc_sd->getDosenInfo();
			$yourTable['nip_2'][2] = $this->sc_sd->getNama();
			$intNo++;
		}
		if(intval($this->sc_sm->getNipReview3()) != 0){
			$yourTable['nip_3'][0] = $intNo;
			$yourTable['nip_3'][1] = $this->sc_sm->getNipReview3();
			$this->sc_sd->resetValue();
			$this->sc_sd->setNip($this->sc_sm->getNipReview3());
			$this->sc_sd->getDosenInfo();
			$yourTable['nip_3'][2] = $this->sc_sd->getNama();
			$intNo++;
		}
		$this->sc_sd->resetValue();
		$this->sc_sd->setNip($this->input->post('nip'));
		$this->sc_sd->getDosenInfo();
		$data = array(
				'nip' => $this->sc_sd->getNip(),
				'nama' => $this->sc_sd->getNama(),
				'bidris' => $this->sc_sd->getBidang(),
				'alamat' => $this->sc_sd->getAlamat(),
				'email' => $this->sc_sd->getEmail(),
				'notelp' => $this->sc_sd->getNohp(),
				'mydosen' => $this->mahasiswa->getIsMyDosenReview($this->sc_sd->getNip()),
				'favorite' => $yourTable
		);
		echo "1";
		$this->load->view('Classroom_room/Body_right/Info_dosen_view',$data);
	}
	//like this guys - valid
	public function setLikeThisGuys(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$nip = $this->view->isNullPost('nip');
		$kode = $this->view->isNullPost('kode');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap program');
		$temp = $this->dosen->getCheckNip($nip,1);
		if(!$temp[0])
			exit("0".$temp[1]);
		$temp = $this->mahasiswa->setAddNewFavor($nip);
	}
	//unlike this guy - valid
	public function setNotLikeThisGuys(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$nip = $this->view->isNullPost('nip');
		$kode = $this->view->isNullPost('kode');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap program');
		$temp = $this->dosen->getCheckNip($nip,1);
		if(!$temp[0])
			exit("0".$temp[1]);
		$temp = $this->mahasiswa->setRemoveOldFavor($nip);
	}
	//end session dosen review
	
}