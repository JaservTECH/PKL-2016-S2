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
	public function getLayoutAcara(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view("Controlroom_room/Body_right/Acara.php");
	}
	public function setNewAkademik(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$start = $this->isNullPost('start');
		$end = $this->isNullPost('end');
		$kode = $this->isNullPost('kode');
		$title = htmlspecialchars($this->isNullPost('title'));
		$summary = htmlspecialchars($this->isNullPost('summary'));
		if(md5($kode) != md5("JASERVTECH-CODE-CREATE-NEW-AKADEMIK"))
			exit("0maaf, anda tidak berhak mengakses kedalam halaman ini");
		if(!$this->getCheck($start,"DATE",1))
			exit("0maaf, input data mulai hari ini");
		if(!$this->getCheck($end,"DATE",1))
			exit("0maaf, input data mulai hari ini");
		if(intval(nice_date($start,"Y")) > intval(nice_date($end,"Y")))
			exit("0tanggal mulai harus lebih awal dari tanggal akhir");
		if(intval(nice_date($start,"m")) > intval(nice_date($end,"m")))
			exit("0tanggal mulai harus lebih awal dari tanggal akhir");
		if(intval(nice_date($start,"m")) == intval(nice_date($end,"m")))
			if(intval(nice_date($start,"d")) > intval(nice_date($end,"d")))
				exit("0tanggal mulai harus lebih awal dari tanggal akhir");
			
		return $this->koordinator->setAktifAkademikRegistrasi($start,$end,$title,$summary);
		//return $this->koordinator->setAktifAkademikRegistrasi("2016-4-27","2016-4-30","Data title","Data sumary");
	}
	public function setNewEvent(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
			$start = $this->isNullPost('start');
			$end = $this->isNullPost('end');
			$kode = $this->isNullPost('kode');
			$title = htmlspecialchars($this->isNullPost('title'));
			$summary = htmlspecialchars($this->isNullPost('summary'));
			if(md5($kode) != md5("JASERVTECH-CODE-CREATE-NEW-EVENT-AKADEMIK"))
				exit("0maaf, anda tidak berhak mengakses kedalam halaman ini");
			if(!$this->getCheck($start,"DATE",1))
				exit("0maaf, input data mulai hari ini");
			if(!$this->getCheck($end,"DATE",1))
				exit("0maaf, input data mulai hari ini");
			if(intval(nice_date($start,"Y")) > intval(nice_date($end,"Y")))
				exit("0tanggal mulai harus lebih awal dari tanggal akhir");
			if(intval(nice_date($start,"m")) > intval(nice_date($end,"m")))
				exit("0tanggal mulai harus lebih awal dari tanggal akhir");
			if(intval(nice_date($start,"m")) == intval(nice_date($end,"m")))
				if(intval(nice_date($start,"d")) > intval(nice_date($end,"d")))
					exit("0tanggal mulai harus lebih awal dari tanggal akhir");
										
			return $this->koordinator->setNewAktifAkademikEvent($start,$end,$title,$summary);
									//return $this->koordinator->setAktifAkademikRegistrasi("2016-4-27","2016-4-30","Data title","Data sumary");
	}

	public function setDataEditEvent(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
			$id = $this->isNullPost('id');
			$start = $this->isNullPost('start');
			$end = $this->isNullPost('end');
			$kode = $this->isNullPost('kode');
			$title = htmlspecialchars($this->isNullPost('title'));
			$summary = htmlspecialchars($this->isNullPost('summary'));
			if(md5($kode) != md5("JASERVTECH-CODE-CREATE-NEW-EVENT"))
				exit("0maaf, anda tidak berhak mengakses kedalam halaman ini");
			if(!$this->getCheck($start,"DATE",1))
				exit("0maaf, input data mulai hari ini");
			if(!$this->getCheck($end,"DATE",1))
				exit("0maaf, input data mulai hari ini");
			if(intval(nice_date($start,"Y")) > intval(nice_date($end,"Y")))
				exit("0tanggal mulai harus lebih awal dari tanggal akhir");
			if(intval(nice_date($start,"m")) > intval(nice_date($end,"m")))
				exit("0tanggal mulai harus lebih awal dari tanggal akhir");
			if(intval(nice_date($start,"m")) == intval(nice_date($end,"m")))
				if(intval(nice_date($start,"d")) > intval(nice_date($end,"d")))
					exit("0tanggal mulai harus lebih awal dari tanggal akhir");
	
			return $this->koordinator->setAktifAkademikEvent($start,$end,$title,$summary,$id);
									//return $this->koordinator->setAktifAkademikRegistrasi("2016-4-27","2016-4-30","Data title","Data sumary");
	}
	
	public function getCheck($value=null,$kode=null,$cat=null){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		if($value == null){
			$value = $this->isNullPost('value'); 
		}
		if($kode == null){
			$kode = $this->isNullPost('kode');
		}
		if($cat == null){
			$cat = $this->isNullPost('cat');
		}
		switch ($kode){
			case 'SUMMARY' :
				return $this->koordinator->getCheckSummary($value,$cat);
				break;
			case 'TITLE' :
				return $this->koordinator->getCheckTitle($value,$cat);
				break;
			case 'DATE' :
				$this->load->helper('date');
				$data = nice_date($value,"Y-m-d");
				$Y= nice_date($data,"Y");
				$m=nice_date($data,"m");
				$d=nice_date($data,"d");
				if(intval($Y) < intval(date("Y"))){
					if($cat == 0)
						exit("0maaf, waktu lampau dari akademik yang sedang berjalan");
					else{
						return false;
					}
				}
				if(intval($Y) > intval(date("Y"))){
					if($cat == 0)
						exit("0maaf, waktu melebihi dari akademik yang sedang berjalan");
					else 
						return false;
				}
				if(intval(date("m")) <=6){
					$scopeFirst = 1;
					$scopeEnd = 6;
				}else{
					$scopeFirst = 7;
					$scopeEnd = 12;
				}
				if(intval($m) < $scopeFirst){
					if($cat == 0)
						exit("0maaf, waktu lampau dari akademik yang sedang berjalan");
					else 
						return false;
				}
				if(intval($m) > $scopeEnd){
					if($cat == 0)
						exit("0maaf, waktu melebihi dari akademik yang sedang berjalan");
					else 
						return false;
				}
				if(intval($m) < intval(DATE("m")))
					if($cat == 0)
						exit("0maaf, tanggal dimulai hari ini");
					else 
						return false;
				if(intval($m) == intval(DATE("m"))){
					if(intval($d) < intval(DATE("d")))
						if($cat == 0)
							exit("0maaf, tanggal dimulai hari ini");
						else
							return false;
				}
				if($cat == 0)
					exit("1Valid");
				else 
					return true;
				break;
		}
	}
	public function getTableAcaraNonDefault(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$kode = $this->isNullPost('kode');
		$year = $this->isNullPost('year');
		if(intval($year) == 1000){
			$year = '*';
		}	
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		
		//$year="*";
		$temp = $this->koordinator->getListEventKoordinator($year);
		echo "1";
		if(count($temp) <= 0){
			echo "<tr>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
		</tr>";
		}else{
			$ii = 0;
			foreach ($temp as $value){
				echo "<tr>
					<td>".$value['e_year']."</td>
					<td>".$value['e_semester']."</td>";
				if(intval($value['e_status']) == 1)
				{
					echo"<td id='start-temp-acara'>".$value['e_start']."</td>
						<td id='end-temp-acara'>".$value['e_end']."</td>
						<td>";
					echo "Aktif";
					echo "</td>
						<td>
							<div>
								<div class='col-md-4'>
									<span class='icon-pencil pointer' style='color : green' onclick='editEventAktif(".$value['e_id'].");' title='lakukan perubahan jadwal : ya'></span>
								</div>
								<div class='col-md-4'>
									<span class='icon-ok' style='color:red' title='sudah diarsipkan : tidak'></span>
								</div>
								<div class='col-md-4'>
									<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContentNonDefault(".$value['e_id'].")' style='color:green' title='lihat lebih lengkap'></span>
								</div>
							</div>
						</td>
					</tr>";
				}
				else{
					echo"<td>".$value['e_start']."</td>
						<td>".$value['e_end']."</td>
						<td>";
					echo "Tidak Aktif";
					echo "</td>
						<td>
							<div>
								<div class='col-md-4'>
									<span class='icon-pencil' style='color : red' title='lakukan perubahan jadwal : tidak'></span>
								</div>
								<div class='col-md-4'>
									<span class='icon-ok' style='color:green' title='sudah diarsipkan :ya'></span>
								</div>
								<div class='col-md-4'>
									<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContentNonDefault(".$value['e_id'].")' style='color:green' title='lihat lebih lengkap'></span>
								</div>
							</div>
						</td>
					</tr>";
				}
			}
		}
	}
	// - valid
	public function getTableAcara(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$temp = $this->koordinator->getListEventAcademic();
		echo "1";
		if(count($temp) <= 0){
			echo "<tr>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>";
		}else{
			$ii = 0;
			foreach ($temp as $value){
				if($ii == 0){
					if(intval($value['status']) != 1){
						$m = intval(date("m"));
						if($m > 6){
							$y = date("Y");
							$s = 1;
						}else{
							$y = intval(date("Y"))-1;
							$s = 2;
						}
						echo "<tr>
							<td>".$y."</td>
							<td>".$s."</td>
							<td id='start-temp-acara'>".date("Y-m-d")."</td>
							<td id='end-temp-acara'>".date("Y-m-d")."</td>
							<td>Aktif</td>
							<td>
								<div>
									<div class='col-md-4'>
										<span class='icon-pencil pointer' style='color : green' onclick='editAkademikAktif();' title='lakukan perubahan jadwal : ya'></span>
									</div>
									<div class='col-md-4'>
										<span class='icon-ok' style='color:red' title='sudah diarsipkan : tidak'></span>
									</div>
									<div class='col-md-4'>
										<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContent(".$y.",".$s.")' style='color:green' title='lihat lebih lengkap'></span>
									</div>
								</div>
							</td>
							";
					}
					$ii=1;
				}
				
				echo "<tr>
					<td>".$value['tahun']."</td>
					<td>".$value['semester']."</td>";
				
				if(intval($value['status']) == 1)
				{
					echo"<td id='start-temp-acara'>".$value['start']."</td>
					<td id='end-temp-acara'>".$value['end']."</td>
					<td>";
					echo "Aktif";
					echo "</td>
					<td>
						<div>
							<div class='col-md-4'>
								<span class='icon-pencil pointer' style='color : green' onclick='editAkademikAktif();' title='lakukan perubahan jadwal : ya'></span>
							</div>
							<div class='col-md-4'>
								<span class='icon-ok' style='color:red' title='sudah diarsipkan : tidak'></span>
							</div>
							<div class='col-md-4'>
								<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContent(".$value['tahun'].",".$value['semester'].")' style='color:green' title='lihat lebih lengkap'></span>
							</div>
						</div>
					</td>
				</tr>";
				}
				else{
					echo"<td>".$value['start']."</td>
					<td>".$value['end']."</td>
					<td>";
					echo "Tidak Aktif";
					echo "</td>
					<td>
						<div>
							<div class='col-md-4'>
								<span class='icon-pencil' style='color : red' title='lakukan perubahan jadwal : tidak'></span>
							</div>
							<div class='col-md-4'>
								<span class='icon-ok' style='color:green' title='sudah diarsipkan :ya'></span>
							</div>
							<div class='col-md-4'>
								<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContent(".$value['tahun'].",".$value['semester'].")' style='color:green' title='lihat lebih lengkap'></span>
							</div>
						</div>
					</td>
				</tr>";
				}
				
			}
		}
	}
	// - valid
	public function getJsonDataRegistrasiActive(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$this->sc_ea->getDataRegistrasiAktifNow();
		$temp1='1{"data" : [';
		if($this->sc_ea->getId() == NULL){
			$MONTH = intval(date("m"));
			if($MONTH > 6){
				$YEAR = date("Y");
				$SEMESTER = 1;
			}else{
				$YEAR = intval(date("Y"))-1;
				$SEMESTER = 2;
			}
			$temp1.=($YEAR.",".$SEMESTER.',"'.date("Y-m-d").'","'.date("Y-m-d").'","",""');
		}else{
			$temp1.=($this->sc_ea->getYear().",".$this->sc_ea->getSemester().',"'.$this->sc_ea->getStart().'","'.$this->sc_ea->getEnd().'","'.$this->sc_ea->getJudul().'","'.$this->sc_ea->getIsi().'"');
		}
		$temp1.="]}";
		echo $temp1;
	}
	//valid
	public function getJsonDataEventActive(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
			$TEMP_CODE = $this->isNullPost('kode');
			$TEMP_ID=$this->isNullPost('id');
			if($TEMP_CODE != "JASERVCONTROL")
				exit("0maaf, anda melakukan debugging");
			$this->sc_ea->setId($TEMP_ID);
			$this->sc_ea->getFullDataRegistrasiNonDefault();
			$temp1='1{"data" : [';
			$temp1.=($this->sc_ea->getYear().",".$this->sc_ea->getSemester().',"'.$this->sc_ea->getStart().'","'.$this->sc_ea->getEnd().'","'.$this->sc_ea->getJudul().'","'.$this->sc_ea->getIsi().'"');	
			$temp1.="]}";
			echo $temp1;
	}
	// - valid
	public function getJsonDataRegistrasi(){
		if(!$this->koordinator->getStatusLoginKoordinator()) redirect(base_url().'Gateinout.aspx');
		if($this->isNullPost('kode') != "JASERVCONTROL") exit("0maaf, anda melakukan debugging");
		$this->sc_ea->setYear($this->isNullPost('year'));
		$this->sc_ea->setSemester($this->isNullPost('semester'));
		$temp = $this->sc_ea->getFullDataRegistrasi();
		$temp1='1{"data" : [';
		if($this->sc_ea->getId() == NULL){
			$MONTH = intval(date("m"));
			if($MONTH > 6){
				$YEAR = date("Y");
				$SEMESTER = 1;
			}else{
				$YEAR = intval(date("Y"))-1;
				$SEMESTER = 2;
			}
			$temp1.=($YEAR.",".$SEMESTER.',"'.date("Y-m-d").'","'.date("Y-m-d").'","",""');
		}else{
			$temp1.=($this->sc_ea->getYear().",".$this->sc_ea->getSemester().',"'.$this->sc_ea->getStart().'","'.$this->sc_ea->getEnd().'","'.$this->sc_ea->getJudul().'","'.$this->sc_ea->getIsi().'"');
		}
		$temp1.="]}";
		echo $temp1;
	}
	// - valid
	public function getJsonDataRegistrasiNonDefault(){
		if(!$this->koordinator->getStatusLoginKoordinator()) redirect(base_url().'Gateinout.aspx');
		if($this->isNullPost('kode') != "JASERVCONTROL") exit("0maaf, anda melakukan debugging");
		$this->sc_ea->setId($this->isNullPost('id'));
		$this->sc_ea->getFullDataRegistrasiNonDefault();
		$temp1='1{"data" : [';
		if($this->sc_ea->getId() == NULL){
			$MONTH = intval(date("m"));
			if($MONTH > 6){
				$YEAR = date("Y");
				$SEMESTER = 1;
			}else{
				$YEAR = intval(date("Y"))-1;
				$SEMESTER = 2;
			}
			$temp1.=($YEAR.",".$SEMESTER.',"'.date("Y-m-d").'","'.date("Y-m-d").'","",""');
		}else{
			$temp1.=($this->sc_ea->getYear().",".$this->sc_ea->getSemester().',"'.$this->sc_ea->getStart().'","'.$this->sc_ea->getEnd().'","'.$this->sc_ea->getJudul().'","'.$this->sc_ea->getIsi().'"');
		}
		$temp1.="]}";
		echo $temp1;
	}
	
	public function getTableDosen(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$temp = $this->dosen->getAllListDosen();
		$srt = $this->koordinator->getCodeRegisterAktif()->now();
		$rest="";
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
	public function getPemerataanListMahasiswa(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$temp = $this->mahasiswa->getListMahasiswaPemerataan($this->koordinator->getCodeRegisterAktif()->now());
		$dosen = $this->dosen->getListDosen();
		if(count($temp) <=0)
			echo "nothing to see";
		$i=0;
		echo 1;
		foreach ($temp as $value){
			$i++;
			$tempss="<ul style='list-style:none;'>";
			$tempssN=0;
			echo 
			"<tr><td>".$i."</td>".
			"<td>".$value['nim']."</td>
			<td>".$value['nama']."</td>
			<td>";
			if(intval($value['kategori'])==1)
				echo "Baru";
			else 
				echo "Melanjutkan";
			echo "</td>
			<td>".$value['minat']."</td>
			<td>";
			echo "<select onchange=".'"'."changeDospem('".$value['nim']."',this.value);".'"'." >";
			echo "<option value='0'>Belum ada</option>";
			foreach ($dosen as $values){
				echo "<option value='".$values['id']."'";
				if($values['id'] == $value['nip'])
					echo " selected ";
				echo ">".$values['nama']."</option>";
				if($values['id'] == $value['nipreviews']){
					$tempss.="<li>".$values['nama']."</li>";
					$tempssN++;
					continue;
				}
				if($values['id'] == $value['nipreviewd']){
					$tempss.="<li>".$values['nama']."</li>";
					$tempssN++;
					continue;
				}
				if($values['id'] == $value['nipreviewt']){
					$tempss.="<li>".$values['nama']."</li>";
					$tempssN++;
					continue;
				}
			}
			echo "</select></td>";
			$tomp = $this->mahasiswa->getLastDosenIfExist($this->koordinator->getCodeRegisterAktif()->now(),$value['nim']);
			$scope = 1;
			$tempos = "";
			foreach ($tomp as $tose){
				if($scope > 3)
					continue;
				if(intval($tose['nip']) == 0)
					continue;
				$bobo = $this->dosen->getDosenName($tose['nip']);
					$tempos .= ($bobo['nama']."<br>");
					$scope ++;
			}

			if($tempos == "")
				$tempss.="<li>-</li>";
			else{
				$tempss.="<li>".substr($tempos, 0,strlen($tempos)-4)."</li>";
			}
			$tempss.="</ul>";
			echo "<td>".$tempss."</td><td>";
			$tempDosenReview = $this->mahasiswa->getTableDosenReview($value['nim']);
			$restReview =null;
			foreach ($tempDosenReview as $valueRevi){
				if(intval($valueRevi) != 0){
					if($restReview == null)
						$restReview = $this->dosen->getDosenName($valueRevi)['nama'];
					else
						$restReview .= $this->dosen->getDosenName($valueRevi)['nama'];
				}
			}
			if($restReview == null)
				echo "Belum review dosen";
			else 
				echo $restReview;
			echo "</td></tr>";
		}
	}
	protected function isNullPost($a){
		if($this->input->post($a)===NULL)
			exit('0anda melakukan percobaan terhadap halaman, jangan lakukan itu');
		return $this->input->post($a);
	}
	public function setDospem(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$nim = $this->isNullPost('nim');
		$nip = $this->isNullPost('nip');
		//$nim = "24010313310137";
		//$nip="12345789123456789";
		$kode = $this->isNullPost('kode');
		//$kode="JASERV-CONTROL";
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit("0nim tidak sesuai, anda melakukan debugging");
		if(!$this->dosen->getCheckNip($nip,1)[0])
			exit("0nim tidak sesuai, anda melakukan debugging");
		$srt = $this->koordinator->getCodeRegisterAktif()->now();
		if($this->mahasiswa->setDospemForTA($nim,$nip,$srt))
			echo "1data berhasil dirubah";
		else{
			echo "0data gagal dirubah";
		}
		return;
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
	public function getJsonTableNow(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$kode = $this->isNullPost('kode');
		//$kode="JASERV-CONTROL";
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$temp = $this->dosen->getListDosen();
		$srt = $this->koordinator->getCodeRegisterAktif()->now();
		$temp1 = "";
		$temp2 = "";
		foreach ($temp as $value){
			$temp1 .= '"'.$value['nama'].'",';
			$temp3=$this->mahasiswa->getCountDospem($value['id'],$srt);
			//echo "".$srt." ".$value['id']." ".$value['nama']." ".count($temp3[1])."<br>";
			$temp2 .= count($temp3[1]).",";
		}
		$temp1 = substr($temp1, 0,strlen($temp1)-1);
		$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
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