<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Controlroom extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library("Koordinator");
		$this->load->library("Dosen");
		$this->load->library("Mahasiswa");
		$this->load->helper('url');
		$this->load->model('sc_ea');
		$this->load->helper('html');
	}
	function index(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$data['url_script'] = array(
				"resources/taurus/js/plugins/jquery/jquery.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui.min.js",
				"resources/taurus/js/plugins/jquery/jquery-migrate.min.js",
				"resources/taurus/js/plugins/jquery/globalize.js",
				"resources/taurus/js/plugins/bootstrap/bootstrap.min.js",
				"resources/taurus/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js",
				"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
				"resources/taurus/js/plugins/knob/jquery.knob.js",
				"resources/taurus/js/plugins/sparkline/jquery.sparkline.min.js",
				"resources/taurus/js/plugins/flot/jquery.flot.js",
				"resources/taurus/js/plugins/flot/jquery.flot.resize.js",
				"resources/taurus/js/plugins/select2/select2.min.js",
				"resources/taurus/js/plugins/tagsinput/jquery.tagsinput.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui-timepicker-addon.js",
				"resources/taurus/js/plugins/ibutton/jquery.ibutton.js",
				"resources/taurus/js/plugins/validationengine/languages/jquery.validationEngine-en.js",
				"resources/taurus/js/plugins/validationengine/jquery.validationEngine.js",
				"resources/taurus/js/plugins/maskedinput/jquery.maskedinput.min.js",
				"resources/taurus/js/plugins/stepy/jquery.stepy.min.js",
				"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
				"resources/taurus/js/plugins/noty/jquery.noty.js",
				"resources/taurus/js/plugins/noty/layouts/topCenter.js",
				"resources/taurus/js/plugins/noty/layouts/topLeft.js",
				"resources/taurus/js/plugins/noty/layouts/topRight.js",
				"resources/taurus/js/plugins/noty/themes/default.js",
				"resources/taurus/js/js.js",
				"resources/taurus/js/settings.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js",
				"resources/mystyle/js/global-style.js",
				"resources/mystyle/js/Controlroom.js",
				"resources/mystyle/js/registrasi-pemerataan.js",
				"resources/mystyle/js/dosen-koordinator.js",
				"resources/mystyle/js/acara-koordinator.js",
				"resources/Chart/Chart.js"
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				"resources/mystyle/css/Controlroom.css"
		);
		$data['nim'] = "";
		$data['nama'] = "Koordinator TA";
		$data['title'] = "Acara | Koordinator";
		$this->load->view('Controlroom_room/Header',$data);
		$this->load->view('Controlroom_room/Body_top');
		$dataleft['image'] = 'resources/mystyle/image/koor.png';
		$this->load->view('Controlroom_room/Body_left',$dataleft);
		$this->load->view('Controlroom_room/Body_right/Body_right');
		$this->load->view('Controlroom_room/Body_plug');
		$dataFoot['url_script'] = array(
				"resources/plugins/calender/underscore-min.js",
				"resources/plugins/calender/moment-2.2.1.js",
				"resources/plugins/calender/clndr.js",
				"resources/plugins/calender/site.js"
		);
		$dataFoot['url_link'] = array(
				"resources/plugins/calender/clndr.css"
		);
		$this->load->view('Controlroom_room/Footer',$dataFoot);
	}
	public function signOut(){
		$this->koordinator->setStatusLogOutKordinator();
		redirect(base_url()."Gateinout.aspx");
	}
	public function getLayoutRegistrasi(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view("Controlroom_room/Body_right/Registrasi.php");
	}
	
	
	
	
	public function getTableDosen(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		//$temp = $this->dosen->getAllListDosen();
		$this->sc_sd->getAllListDosen();
		$srt = $this->koordinator->getCodeRegisterAktif()->now();
		$rest="";
		while($this->sc_sd->getCursorNext()){
			$rest.="<tr>";
			$rest.="<td>".$i."</td>";
			$rest.="<td>".$this->sc_sd->getNip()."</td>";
			$rest.="<td>".$this->sc_sd->getNama()."</td>";
			$rest.="<td>".$this->sc_sd->getBidang()."</td>";
			$rest.="<td>";
			$rest.="<input type='button' value='lihat (".count($this->mahasiswa->getCountDospem($value['s_id'],$srt)[1]).")' class='btn btn-info' onclick='showListMahasiswaAmpuan(".'"'.$value['s_id'].'"'.")'>";
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
		if($temp[0]){
			$i=1;
			foreach ($temp[1] as $value){
				$rest.="<tr>";
				$rest.="<td>".$i."</td>";
				$rest.="<td>".$value['s_id']."</td>";
				$rest.="<td>".$value['s_name']."</td>";
				$rest.="<td>".$value['s_bidang_riset']."</td>";
				$rest.="<td>";
				$rest.="<input type='button' value='lihat (".count($this->mahasiswa->getCountDospem($value['s_id'],$srt)[1]).")' class='btn btn-info' onclick='showListMahasiswaAmpuan(".'"'.$value['s_id'].'"'.")'>";
				$rest.="</td>";
				$rest.="<td><select onchange='statusDosen(".'"'.$value['s_id'].'"'.",this.value);'>";
				if(intval($value['s_status']) == 1){
					$rest.= "<option value='0'>Tidak Aktif</option>".
							"<option  value='1' selected>Aktif</option>";
				}else{
					$rest.= "<option value='0' selected>Tidak Aktif</option>".
							"<option value='1'>Aktif</option>";
				}
				$rest.="</tr>";
				$i++;
			}
		}else{
			$rest.="<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
		}
		echo "1".$rest;
	}
	public function getLayoutDosen(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		echo"1";
		$this->load->view("Controlroom_room/Body_right/Dosen.php");
	}
	protected function isNullPost($a){
		if($this->input->post($a)===NULL)
			exit('0anda melakukan percobaan terhadap halaman, jangan lakukan itu');
		return $this->input->post($a);
	}
	public function setNewStatusDosen(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$nip = $this->isNullPost('nip');
		$stat = $this->isNullPost('status');
		if(intval($stat) != 0){
			if(intval($stat) != 1){
				exit("0maaf, anda melakukan debugging");
			}
		}
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
		$nip = $this->isNullPost('nip');
		if(!$this->dosen->getCheckNip($nip,1))
			exit("0Anda melakukan debuging");
		$srt = $this->koordinator->getCodeRegisterAktif()->now();
		$rr = $this->dosen->getCheckNip($nip,1);
		if(!$rr[0])
			exit('0maaf, anda melakukan debugging');
		$temp = $this->mahasiswa->getCountDospem($nip,$srt);
		if(!$temp[0])
			exit("0gagal mengambil data");
		$temp2="";
		foreach ($temp[1] as $value){
			$temps = $this->mahasiswa->getContactFormat($value['s_nim']);
			$temp2.='["'.$temps[1]['nama'].'",'.$value['s_nim'].',"upload/foto/'.$temps[1]['foto'].'"],';
		}
		$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": ['.count($temp[1]);
		$json .= ",[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
}