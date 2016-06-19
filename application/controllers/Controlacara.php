<?php
if(!defined('BASEPATH'))
	exit("You dont have permission on this siite");
Class Controlacara extends CI_Controller{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("Koordinator");
		$this->load->library("View");
		$this->load->model('Sc_ea');
	}
	public function getLayoutAcara(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view("Controlroom_room/Body_right/Acara.php");
	}
	
	
	// - valid
	public function getJsonDataRegistrasi(){
		if(!$this->koordinator->getStatusLoginKoordinator()) redirect(base_url().'Gateinout.aspx');
		if($this->view->isNullPost('kode') != "JASERVCONTROL") exit("0maaf, anda melakukan debugging");
		$this->sc_ea->setYear($this->view->isNullPost('year'));
		$this->sc_ea->setSemester($this->view->isNullPost('semester'));
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
	public function setNewAkademik(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$start = $this->view->isNullPost('start');
		$end = $this->view->isNullPost('end');
		$kode = $this->view->isNullPost('kode');
		$title = htmlspecialchars($this->view->isNullPost('title'));
		$summary = htmlspecialchars($this->view->isNullPost('summary'));
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
			$start = $this->view->isNullPost('start');
			$end = $this->view->isNullPost('end');
			$kode = $this->view->isNullPost('kode');
			$title = htmlspecialchars($this->view->isNullPost('title'));
			$summary = htmlspecialchars($this->view->isNullPost('summary'));
			if(md5($kode) != md5("JASERVTECH-CODE-CREATE-NEW-EVENT-AKADEMIK"))
				exit("0maaf, anda tidak berhak mengakses kedalam halaman ini");
			
			/* $start = "2016-6-22";
			$end = "2016-6-23";
			$title = "kokoko";
			$summary = "sasassa"; */
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
			$id = $this->view->isNullPost('id');
			$start = $this->view->isNullPost('start');
			$end = $this->view->isNullPost('end');
			$kode = $this->view->isNullPost('kode');
			$title = htmlspecialchars($this->view->isNullPost('title'));
			$summary = htmlspecialchars($this->view->isNullPost('summary'));
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
			$value = $this->view->isNullPost('value'); 
		}
		if($kode == null){
			$kode = $this->view->isNullPost('kode');
		}
		if($cat == null){
			$cat = $this->view->isNullPost('cat');
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
	
	//valid
	public function getJsonDataEventActive(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
			$TEMP_CODE = $this->view->isNullPost('kode');
			$TEMP_ID=$this->view->isNullPost('id');
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
	public function getJsonDataRegistrasiNonDefault(){
		if(!$this->koordinator->getStatusLoginKoordinator()) redirect(base_url().'Gateinout.aspx');
		//if($this->view->isNullPost('kode') != "JASERVCONTROL") exit("0maaf, anda melakukan debugging");
		$this->sc_ea->setId($this->view->isNullPost('id'));
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
	public function getTableAcaraNonDefault(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$kode = $this->view->isNullPost('kode');
		$year = $this->view->isNullPost('year');
		//$year = '1000';
		if(intval($year) == 1000){
			$year = '*';
		}	
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		
		//$year="*";
		//$temp = $this->koordinator->getListEventKoordinator($year);
		
		
		
		//$temp = $this->sc_ea->query("*","e_event=3 AND e_status=1")->result_array();
		$BOOL = $this->sc_ea->getEventKoordinatorActive();
		$TEMP_SC_EA = $this->sc_ea;
		
		if($BOOL){
			$this->load->helper('date');
			while($TEMP_SC_EA->getNextCursor()){
				$error = 0;
				if(intval(nice_date($TEMP_SC_EA->getEnd(),"Y")) < intval(DATE("Y")))
					$error += 1;
				if(intval(nice_date($TEMP_SC_EA->getEnd(),"m")) < intval(DATE("m")))
					$error += 1;
				else{
					if(intval(nice_date($TEMP_SC_EA->getEnd(),"m")) == intval(DATE("m")))
						if(intval(nice_date($TEMP_SC_EA->getEnd(),"d")) < intval(DATE("d")))
							$error += 1;
				}
				if($error > 0){
					$this->sc_ea->resetValue();
					$this->sc_ea->setStatus(2);
					$this->sc_ea->setId($TEMP_SC_EA->getId());
					$this->sc_ea->setUpdateEventKoordinator();
				}
				
			}
		}
		$this->sc_ea->resetValue();
		if($year == '*'){
			$BOOL = $this->sc_ea->getEventKoorWithStyle();
		}else{
			$this->sc_ea->setYear($year);
			$BOOL = $this->sc_ea->getEventKoorWithStyle();
		}
		
		
		
		
		
		echo "1";
		if(!$BOOL){
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
			while($this->sc_ea->getNextCursor()){
				echo "<tr>
					<td>".$this->sc_ea->getYear()."</td>
					<td>".$this->sc_ea->getSemester()."</td>";
				if(intval($this->sc_ea->getStatus()) == 1)
				{
					echo"<td id='start-temp-acara'>".$this->sc_ea->getStart()."</td>
						<td id='end-temp-acara'>".$this->sc_ea->getEnd()."</td>
						<td>";
					echo "Aktif";
					echo "</td>
						<td>
							<div>
								<div class='col-md-4'>
									<span class='icon-pencil pointer' style='color : green' onclick='editEventAktif(".$this->sc_ea->getId().");' title='lakukan perubahan jadwal : ya'></span>
								</div>
								<div class='col-md-4'>
									<span class='icon-ok' style='color:red' title='sudah diarsipkan : tidak'></span>
								</div>
								<div class='col-md-4'>
									<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContentNonDefault(".$this->sc_ea->getId().")' style='color:green' title='lihat lebih lengkap'></span>
								</div>
							</div>
						</td>
					</tr>";
				}
				else{
					echo"<td>".$this->sc_ea->getStart()."</td>
						<td>".$this->sc_ea->getEnd()."</td>
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
									<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContentNonDefault(".$this->sc_ea->getId().")' style='color:green' title='lihat lebih lengkap'></span>
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
		//$kode = $this->view->isNullPost('kode');
		//if($kode!="JASERVCONTROL")
		//	exit("0maaf, anda melakukan debugging");
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
	// - valid
	public function getTableAcara(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$kode = $this->view->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		//$temp = $this->koordinator->getListEventAcademic();
		echo "1";
		
		if(!$this->sc_ea->getListAkademicActive()){
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
			while($this->sc_ea->getNextCursor()){
				if($ii == 0){
					if(intval($this->sc_ea->getStatus()) != 1){
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
					<td>".$this->sc_ea->getYear()."</td>
					<td>".$this->sc_ea->getSemester()."</td>";
				
				if(intval($this->sc_ea->getStatus()) == 1)
				{
					echo"<td id='start-temp-acara'>".$this->sc_ea->getStart()."</td>
					<td id='end-temp-acara'>".$this->sc_ea->getEnd()."</td>
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
								<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContent(".$this->sc_ea->getYear().",".$this->sc_ea->getSemester().")' style='color:green' title='lihat lebih lengkap'></span>
							</div>
						</div>
					</td>
				</tr>";
				}
				else{
					echo"<td>".$this->sc_ea->getStart()."</td>
					<td>".$this->sc_ea->getEnd()."</td>
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
								<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContent(".$this->sc_ea->getYear().",".$this->sc_ea->getSemester().")' style='color:green' title='lihat lebih lengkap'></span>
							</div>
						</div>
					</td>
				</tr>";
				}
				
			}
		}
	}
}