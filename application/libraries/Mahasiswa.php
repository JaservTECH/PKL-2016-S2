<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once ("Aktor.php");
class Mahasiswa extends Aktor{
	//public
	public function __CONSTRUCT(){
		PARENT::__CONSTRUCT();
		$this->setLibrary('session');
		$this->setModel('sc_sm');
		$this->setModel('sc_st');
		$this->setModel('sc_sm_interest');
		$this->setModel('sc_lms');
		$this->setModel('sc_std');
	}
	//get code year now - valid
	public function getYearNow(){ 
		$year = DATE("Y"); 
		$month = DATE("m"); 
		if(intval($month) >= 1 && intval($month)<=6){
			return intval((intval($year)-1)."2");
		}else{
			return intval($year."1");
		}
	}
	//nim exist - valid
	public function getIsNimExist($nim){ if(!$this->sc_sm->getDataNim($nim))	return false; if($this->sc_sm->getNim() != NULL){ if($this->sc_sm->getNim() == $nim) return true;	else return false;}else{return false;}	}
	//try sign up new account - valid
	public function getStatusSignUpMahasiswa($data=""){
		$error = 0;	
		$errorMessage = "";	
		$temp = $this->getCheckNim($data['nim'],1);
		if(!$temp[0]){	
			$error+=1;	$errorMessage.=$temp[1]."<br>";
		}else{	
			$nim = $data['nim']; 
			$this->sc_sm->getDataNim($nim); 
			if($this->getIsNimExist($nim)){	
				return $this->setCategoryPrintMessage(0, false, "Maaf, nim anda sudah digunakan oleh mahasiswa lain, mohon maaf sebelumnya. pilih menu lupa password jika anda sudah daftar ssebelumnya");	
			}
		}
		$temp = $this->getCheckName($data['name'],1);
		if(!$temp[0]){	
			$error+=1;	
			$errorMessage.=$temp[1]."<br>";	
		}else{
			$name = $data['name'];
		} 
		$temp = $this->getCheckPassword($data['password'],1);
		if(!$temp[0]){
			$error+=1;
			$errorMessage.=$temp[1]."<br>";
		}else{
			$password1 = $data['password']; 
		} 
		$temp = $this->getCheckPassword($data['password1'],1);
		if(!$temp[0]){
			$error+=1;
			$errorMessage.=$temp[1]."<br>";	
		}else{	
			$password2 = $data['password1'];
		} 
		if($password1 != $password2){
			$error+=1;
			$errorMessage.="Password konfirmasi tidak sama dengan password utama<br>";
		} 
		$temp = $this->getCheckEmail($data['email'],1);
		if(!$temp[0]){
			$error+=1;
			$errorMessage.=$temp[1]."<br>";	
		}else{
			$email = $data['email']; 
		}
		$temp = $this->getCheckNuTelphone($data['telephone'],1);
		if(!$temp[0]){
			$error+=1;	$errorMessage.=$temp[1]."<br>";	}else{	$telephone = $data['telephone'];}
		if($error > 0){
			return $this->setCategoryPrintMessage(0, false, $errorMessage);	
		}
		$year = $this->getYearNow();
		/*upload-foto*/
		$conPic['upload_path'] = './upload/foto/';	
		$conPic['allowed_types'] = 'png|jpg'; 
		$conPic['file_name'] = $nim."-foto";	
		$conPic['overwrite'] = true; 
		$conPic['remove_spaces'] = true; 
		$conPic['max_size'] = 500;	
		$conPic['max_width'] = 800;	
		$conPic['max_height'] = 600; 
		$this->setLibrary('upload');
		//$this->load->library('upload',$conPic);
		$this->upload->initialize($conPic);
		if(!$this->upload->do_upload($data['foto'])){
			return $this->setCategoryPrintMessage(0, false, 'gagal upload foto, format yang didukung png dan jpg, maksimal resolusi 800 x 600 pixel, dengan ukuran file 500kb');		
		}
		$fotoname = $this->upload->data('file_name');
		/*upload-translrip*/
		$conTrans['upload_path'] = './upload/transkrip/'; 
		$conTrans['file_name'] = $nim."-transkrip"; 
		$conTrans['allowed_types'] = 'pdf|PDF'; 
		$conTrans['max_size'] = 1024;	
		$conTrans['overwrite'] = true; 
		$conTrans['remove_spaces'] = true;
		$this->upload->initialize($conTrans);
		if(!$this->upload->do_upload($data['trans'])){
			return $this->setCategoryPrintMessage(0, false, "gagal upload transkrip, format yang didukung transkrip adalah pdf, dengan maksimum ukuran file 1 mb");		
		}
		$transkripname = $this->upload->data('file_name');
		/*upload-data-support*/
		
		$this->sc_sm->setNim($nim);	
		$this->sc_sm->setName($name); 
		$this->sc_sm->setPassword(md5($password1)); 
		$this->sc_sm->setEmail($email);	
		$this->sc_sm->setNoHp($telephone); 
		$this->sc_sm->setAktifTahun($year); 
		$this->sc_sm->setFotoname($fotoname); 
		$this->sc_sm->setTranskripName($transkripname); 
		$this->sc_sm->setCodeCokie(md5($nim+DATE('Y-m-d'))); 
		$succ = 0;
		//exit("0hohohkokokoohlokk");
		$succ+=$this->sc_sm->signUp();
		$this->sc_lms->resetValue();
		$this->sc_lms->setNim($nim); 
		$this->sc_lms->setTanggal(DATE("Y-m-d H:i:s")); 
		$this->sc_lms->setEvent("mendaftar baru");
		$succ+=$this->sc_lms->addNew();
        /*check success*/
		if($succ == 2)
			return $this->setCategoryPrintMessage(0, true, "Data Berhasil dimasukan ");	
		else 
			return $this->setCategoryPrintMessage(0, false, "Terjadi kesalahan, silahkan ulangi atau tunggu beberapa saat");
	}
	//check status login - valid
	public function getStatusLoginMahasiswa(){
		$TEMP_ERROR = 0;
		if(!$this->session->has_userdata('login')) $TEMP_ERROR += 1; else{	
			if($this->session->userdata('login') != 'true')	$TEMP_ERROR += 1;}
		if(!$this->session->has_userdata('nim')) $TEMP_ERROR += 1;	
		if(!$this->session->has_userdata('name')) $TEMP_ERROR += 1;
		if(!$this->session->has_userdata('pass')) $TEMP_ERROR += 1; else{ 
			if($this->session->userdata('pass') != $this->getResultEncryptMahasiswaString($this->session->userdata('name'))) $TEMP_ERROR += 1;	}
		if($TEMP_ERROR >0) return false;	else return true;
	}
	//try login and make session - valid
	public function setLoginMahasiswa($TEMP_NIM="",$TEMP_PASSWORD=""){   
		if(!$this->sc_sm->getDataNim($TEMP_NIM))	return $this->setCategoryPrintMessage(0, false, "nim dan kata kunci tidak terdaftar");
		if($this->sc_sm->getNim() != $TEMP_NIM)	return $this->setCategoryPrintMessage(0, false, "nim dan kata kunci tidak terdaftar");
		if($this->sc_sm->getPassword() != md5($TEMP_PASSWORD))	return $this->setCategoryPrintMessage(0, false, "nim dan kata kunci tidak terdaftar");
		if($this->getStatusLoginMahasiswa()){
			if($this->session->userdata('nim') == $TEMP_NIM){ return $this->setCategoryPrintMessage(0,true, "Classroom.aspx");}
		}
		$this->session->set_userdata("login",'true');
		$this->session->set_userdata("nim",$this->sc_sm->getNim());
		$this->session->set_userdata("name",$this->sc_sm->getName());
		$this->session->set_userdata("pass",$this->getResultEncryptMahasiswaString($this->sc_sm->getName()));
		return $this->setCategoryPrintMessage(0,true,"Classroom.aspx");
	}
	//logout - valid
	public function setStatusLogOutMahasiswa(){
		if(!$this->getStatusLoginMahasiswa()) return false;
		$this->session->unset_userdata("login"); $this->session->unset_userdata("nim");	$this->session->unset_userdata("name"); $this->session->unset_userdata("pass");	return true;
	}
	//get list peminatan - valid
	public function getListPeminatan(){
		$this->sc_sm_interest->getAllData();
		$TEMP_INDEX_ARRAY = 0;
		while($this->sc_sm_interest->getNextCursor()){
			$TEMP_ARRAY[$TEMP_INDEX_ARRAY]['id'] = $this->sc_sm_interest->getId();
			$TEMP_ARRAY[$TEMP_INDEX_ARRAY]['nama'] = $this->sc_sm_interest->getName();
			$TEMP_INDEX_ARRAY += 1;
		}
		return $TEMP_ARRAY;
	} 
	//remove dosenfavorite - valid
	public function setRemoveOldFavor($TEMP_VALUE_NIP,$TEMP_VALUE_NIM = ""){
		if($TEMP_VALUE_NIM == "")
			$TEMP_VALUE_NIM = $this->getNimSessionLogin();
		$this->sc_sm->setNim($TEMP_VALUE_NIM);
		if($this->sc_sm->dropNipPreview($TEMP_VALUE_NIP))
			return $this->setCategoryPrintMessage(0,true,"Berhasil menghapus data");
		else
			return $this->setCategoryPrintMessage(0,false,"Gagal menghapus data");
	} 
	//add dosen favorite - 
	public function setAddNewFavor($TEMP_VALUE_NIP,$TEMP_VALUE_NIM=""){
		if($TEMP_VALUE_NIM == "")
			$TEMP_VALUE_NIM = $this->getNimSessionLogin();
		$this->sc_sm->setNim($TEMP_VALUE_NIM);
		if($this->sc_sm->addNipPreview($TEMP_VALUE_NIP))
			return $this->setCategoryPrintMessage(0,true,"Berhasil memasukan data");
		else
			return $this->setCategoryPrintMessage(0,false,"Gagal menambahkan data");
	}
	//check is dosen review - valid
	public function getIsMyDosenReview($TEMP_VALUE_NIP,$TEMP_VALUE_NIM = ""){
		if($TEMP_VALUE_NIM == "")
			$TEMP_VALUE_NIM = $this->getNimSessionLogin();
		$this->sc_sm->setNim($TEMP_VALUE_NIM);
		return $this->sc_sm->isInThisNipInReview($TEMP_VALUE_NIP);
	}
	//nim check - format - valid
	public function getCheckNim($TEMP_VALUE_NIM="",$TEMP_CATEGORY=0){
		if($TEMP_VALUE_NIM == ""){
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "Nim tidak sesuai");
		}	
		if(substr($TEMP_VALUE_NIM,0,3) == "J2F"){
			if(strlen($TEMP_VALUE_NIM)!= 9){
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "Nim tidak sesuai");
			}
			if($this->inputjaservfilter->numberFiltering(substr($TEMP_VALUE_NIM,3,strlen($TEMP_VALUE_NIM)-3))[0]){
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, true, "Nim sesuai");
			}else{
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "Nim tidak sesuai");
			}
		}else{
			if(strlen($TEMP_VALUE_NIM) != 14)
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "Nim tidak sesuai");
			if($this->inputjaservfilter->numberFiltering($TEMP_VALUE_NIM)[0]){
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, true, "Nim sesuai");
			}else{
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "Nim tidak sesuai");
			}
		}
	}
	//check methode - format - valid
	public function getCheckMethode($TEMP_VALUE_METHODE = "",$TEMP_CATEGORY = 0){
		if($TEMP_VALUE_METHODE == "")
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "Metode tidak boleh kosong");
		$TEMP_VALUE_METHODE = $this->inputjaservfilter->usernameFiltering($TEMP_VALUE_METHODE);
		return $this->setCategoryPrintMessage($TEMP_CATEGORY, $TEMP_VALUE_METHODE[0], $TEMP_VALUE_METHODE[1]);
	}
	//check lokasi - format - valid
	public function getCheckLokasi($TEMP_VALUE_LOCATION = "",$TEMP_CATEGORY = 0){
		if($TEMP_VALUE_LOCATION == "")
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, true, "valid"); //boleh kosong tau tidak
		$TEMP_VALUE_LOCATION = $this->inputjaservfilter->usernameFiltering($TEMP_VALUE_LOCATION);
		return $this->setCategoryPrintMessage($TEMP_CATEGORY, $TEMP_VALUE_LOCATION[0], $TEMP_VALUE_LOCATION[1]);
	}
	//check refrences - format - valid
	public function getCheckRefrence($TEMP_VALUE_REFERENCE = "",$TEMP_CATEGORY = 0){
		if($TEMP_VALUE_REFERENCE == "")
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, true, "valid"); //boleh kosong tau tidak
		$TEMP_VALUE_REFERENCE = $this->inputjaservfilter->usernameFiltering($TEMP_VALUE_REFERENCE);
		return $this->setCategoryPrintMessage($TEMP_CATEGORY, $TEMP_VALUE_REFERENCE[0], $TEMP_VALUE_REFERENCE[1]);
	}
	//check peminatan - format - valid
	public function getCheckInterested($TEMP_VALUE_INTEREST = "",$TEMP_CATEGORY = 0){
		$TEMP_VALUE_INTEREST.="";
		if($TEMP_VALUE_INTEREST == "")
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "peminatan tidak booleh kosong"); //boleh kosong tau tidak
		$TEMP_ARRAY = $this->inputjaservfilter->numberFiltering($TEMP_VALUE_INTEREST);
		if($TEMP_ARRAY[0]){
			if(strlen($TEMP_VALUE_INTEREST) == 1)
			{
				if((intval($TEMP_VALUE_INTEREST) > 0) && (intval($TEMP_VALUE_INTEREST)<5))
				{
					return $this->setCategoryPrintMessage($TEMP_CATEGORY, true, $TEMP_ARRAY[1]);
				}
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "diwajibkan memilih salah satu");
			}
		}
		return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "kode anda rubah dari standar");
	}
	//check title - format - valid
	public function getCheckTitleFinalTask($TEMP_VALUE_TITLE="",$TEMP_CATEGORY=0){
		if($TEMP_VALUE_TITLE == "")
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, true, "valid"); //boleh kosong tau tidak
		$TEMP_VALUE_TITLE = $this->inputjaservfilter->titleFiltering($TEMP_VALUE_TITLE);
		return $this->setCategoryPrintMessage($TEMP_CATEGORY, $TEMP_VALUE_TITLE[0], $TEMP_VALUE_TITLE[1]);
	}
	//check password - format - valid
	public function getCheckPassword($TEMP_VALUE_PASS="",$TEMP_CATEGORY=0){
		if($TEMP_VALUE_PASS == "")
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, false, "password tidak boleh kosong");
		$TEMP_VALUE_PASS = $this->inputjaservfilter->passwordFiltering($TEMP_VALUE_PASS);
		return $this->setCategoryPrintMessage($TEMP_CATEGORY, $TEMP_VALUE_PASS[0], $TEMP_VALUE_PASS[1]);
	}
	//interface default - valid
	public function getDataMahasiswaLoginInterfaceDefault(){
		if(!$this->getStatusLoginMahasiswa()){
			return (array(FALSE,NULL));
		}
		$TEMP_VALUE_NIM = $this->session->userdata('nim');
		if($this->sc_sm->getDataNim($TEMP_VALUE_NIM)){
			$TEMP_ARRAY['nim'] = $this->sc_sm->getNim();
			$TEMP_ARRAY['foto'] = $this->sc_sm->getFotoname();
			$TEMP_ARRAY['nama'] = $this->sc_sm->getName();
			return (array(TRUE,$TEMP_ARRAY));
		}
		return (array(FALSE,NULL));
	}
	//encrypt - valid
	protected function getResultEncryptMahasiswaString($TEMP_VALUE_STRING){return md5($TEMP_VALUE_STRING."Mahasiswa.Encrypt.String");}
	
	//check nim - valid
	public function getContactFormat($TEMP_VALUE_NIM = ""){
		if(!$this->getCheckNim($TEMP_VALUE_NIM,1)[0]){
			return $this->setCategoryPrintMessage(1, false, "Nim tidak sesuai");
		}
		if($this->sc_sm->getDataNim($TEMP_VALUE_NIM)){			
			$TEMP_ARRAY['foto'] = $this->sc_sm->getFotoname();
			$TEMP_ARRAY['nama'] = $this->sc_sm->getName();
			return $this->setCategoryPrintMessage(1, true, $TEMP_ARRAY);
		}
		return $this->setCategoryPrintMessage(1, false, "Nim tidak sesuai");
	}
	/*Seminar Session*/
	// - valid
	public function isAnyGuysOnThisDay($TEMP_DATE,$TEMP_TA,$TEMP_CODE,$TEMP_CATEGORY = 0){
		$this->setHelper('date');
		if(nice_date($TEMP_DATE,"Y-m-d H:i:s") == 'Invalid Date')
			return $this->setCategoryPrintMessage($TEMP_CATEGORY, FALSE, "Format waktu tidak sesuai");
		$this->setModel('sc_sst');
		$TEMP_VALUE_TIME = nice_date($TEMP_DATE,"H:i:s");
		$TEMP_VALUE_DATE = nice_date($TEMP_DATE,"Y-m-d");
		$TEMP_ARRAY = $this->sc_sst->getTimeEventRoomOnDate($TEMP_CODE,$TEMP_VALUE_DATE);
		if(isset($TEMP_ARRAY)){
			foreach ($TEMP_ARRAY as $TEMP_VALUE){
				echo $TEMP_VALUE->timeSeminarTA."<br>";
				$HOUR = intval(nice_date($TEMP_VALUE->timeSeminarTA,"H"));
				$MINUTE = intval(nice_date($TEMP_VALUE->timeSeminarTA,"i"));
				$HOUR_N = intval(nice_date($TEMP_VALUE_TIME,"H"));
				$MINUTE_N = intval(nice_date($TIME_VALUE_TIME,"i"));
				if($TEMP_TA == 1 ){
					$TEMP_HOUR= 2;
				}else if($TEMP_TA == 2){
					$TEMP_HOUR = 3;
				}else{
					return $this->setCategoryPrintMessage($TEMP_CATEGORY, FALSE, "anda melakukan debugging terhadap input ta");
				}
				if($HOUR <= $HOUR_N){
					if($HOUR + $TEMP_HOUR > $HOUR_N){
						return $this->setCategoryPrintMessage($TEMP_CATEGORY, FALSE, "Jam sudah ada yang mengambil");
					}else if($HOUR + $TEMP_HOUR == $HOUR_N){
						if($MINUTE > $MINUTE_N){
							return $this->setCategoryPrintMessage($TEMP_CATEGORY, FALSE, "Jam sudah ada yang mengambil");
						}
					}
				}else {
					if($HOUR < $HOUR_N + $TEMP_HOUR){
						return $this->setCategoryPrintMessage($TEMP_CATEGORY, FALSE, "Jam sudah ada yang mengambil");
					}else if($hour == $hourN+$jam){
						if($MINUTE < $MINUTE_N){
							return $this->setCategoryPrintMessage($TEMP_CATEGORY, FALSE, "Jam sudah ada yang mengambil");
						}
					}
				}
				return $this->setCategoryPrintMessage($TEMP_CATEGORY, TRUE, "valid");
			}
		}
		return $this->setCategoryPrintMessage($TEMP_CATEGORY, TRUE, "valid");
		
	}
	//load interface model
	//protected function getLoadClassInterface($name){
	//	require_once 'Interface_'.$name;
	//}	
	//still review
	//get is have any last TA info, from last semester or las last last other - valid
	public function getCodeRegLastTA(){
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$TEMP_YEAR=$this->getYearNow()."";
		
		$this->sc_sm->setNim($this->session->userdata('nim'));
		if(!$this->sc_sm->setGetAktiveYear())
			return array(false,NULL,NULL);
		$TEMP_END = substr($TEMP_YEAR, 0,strlen($TEMP_YEAR)-1);
		$TEMP_END_K = $TEMP_YEAR[strlen($TEMP_YEAR)-1];
		if(intval($TEMP_END_K) == 2){
			$TEMP_END_K = "1";
		}else{
			$TEMP_END_K = "2";
			$TEMP_END = (intval($TEMP_END)-1);
		}
		$TEMP_END_K_V = intval($TEMP_END."".$TEMP_END_K);
		$TEMP_START = intval(substr($this->sc_sm->getAktifTahun(), 0,strlen($this->sc_sm->getAktifTahun())-1));
		$TEMP_START_K = $this->sc_sm->getAktifTahun()[strlen($this->sc_sm->getAktifTahun())-1];
		$TEMP_START_K_V = intval($TEMP_START."".$TEMP_START_K);
		$TEMP_TOTAL_LOOR = 0;
		for($i=$TEMP_END; $i>= $TEMP_START;$i--){
			for($j=2;$j>=1;$j--){
				$TEMP_ID_BEFORE = intval($i."".$j);
				if($TEMP_ID_BEFORE < $TEMP_END_K_V && $TEMP_ID_BEFORE >= $TEMP_START_K_V){
					$TEMP_TOTAL_LOOR+=1;
				}
				if($TEMP_ID_BEFORE <= $TEMP_END_K_V && $TEMP_ID_BEFORE >= $TEMP_START_K_V){
					$this->sc_st->resetValue();
					$this->sc_st->setNim($this->getNimSessionLogin());
					$this->sc_st->setKode($TEMP_ID_BEFORE);
					if($this->sc_st->getHaveLastTAInfo(FALSE)){
						return array(true,$TEMP_ID_BEFORE,$TEMP_TOTAL_LOOR);
					}
				}
			}
		}
		return array(false,null,null);
	}
	//get nim login session aktif - valid
	public function getNimSessionLogin(){
		if(!$this->getStatusLoginMahasiswa())
			return NULL;
		return $this->session->userdata('nim');
	}
	
	public function getTAInfo($srt,$data=null){
		$temp = $this->sc_st->query("*","s_rt=".$srt." AND s_nim='".$this->session->userdata('nim')."'")->row_array(); 
		if(count($temp)<=0)
			return array(false,'data tidak di teukan pada code akademik');
		if($data == null)
			return array(false,"anda tidak memilih data apapun");
		if(!is_array($data))
			return array(false,"data berupa array");
		foreach ($data as $in => $index){
			switch ($index){
				case 'judulta' :
					$temp2['judulta'] = $temp['s_judul_ta'];
					break;
				case 'dosbing' :
					$temp2['dosbing'] = $temp['s_nip'];
					break;
				case 'nim' :
					$temp2['nim'] = $temp['s_nim'];
					break;
				case 'metode' :
					$temp2['metode'] = $temp['s_metode'];
					break;
				case 'lokasi' :
					$temp2['lokasi'] = $temp['s_lokasi'];
					break;
				case 'ref1' :
					$temp2['ref1'] = $temp['s_ref_s'];
					break;
				case 'ref2' :
					$temp2['ref2'] = $temp['s_ref_d'];
					break;
				case 'ref3' :
					$temp2['ref3'] = $temp['s_ref_t'];
					break;
				default:
					$temp2[$index] = null;
			}
		}
		return array(true,$temp2);
	}
	//Registrasi Lama proses
	public function setRegistrasiLama($data){
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$conPic['upload_path'] = './upload/krs/';
		$conPic['allowed_types'] = 'pdf';
		$conPic['file_name'] = $data['codereg']."-".$data['nim']."-krs";
		$conPic['overwrite'] = true;
		$conPic['remove_spaces'] = true;
		$conPic['max_size'] = 1024;
		$this->setLibrary('upload');
		$this->upload->initialize($conPic);
		if(!$this->upload->do_upload($data['krs'])){
			return $this->setCategoryPrintMessage(1, false, 'file yang di upload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$this->sc_st->resetValue();
		$this->sc_st->setNim($this->getNimSessionLogin());
		$this->sc_st->setKode($data['codeRegist']);
		if(!$this->sc_st->getHaveLastTAInfo())
			return $this->setCategoryPrintMessage(1,false,"data tidak dtemukan untuk ta sebelumnya, lihat panduan registrasi");
		$TEMP_ARRAY = array(
			'METODE' => $this->sc_st->getMetode(),
			'LOKASI' => $this->sc_st->getLokasi(),
			'REF_S' => $this->sc_st->getReferensis(),
			'REF_D' => $this->sc_st->getReferensid(),
			'REF_T' => $this->sc_st->getReferensit()
		);
		$krsname = $this->upload->data('file_name');
		$tempsD = $this->getDataPersonal();
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($tempsD['nim']);
		$this->sc_sm->setName($data['nama']);
		$this->sc_sm->setEmail($data['email']);
		$this->sc_sm->setPeminatan($tempsD['minat']);
		$this->sc_sm->setNohp($data['nohp']);
		$this->sc_sm->setNoHpOrtu($data['nohportu']);
		$this->sc_sm->setNamaOrtu($data['ortu']);
		$this->sc_sm->setOpenForm($data['newf']);
		$this->sc_sm->setForceRegLama('2');
		if(!$this->sc_sm->updateData())
			return $this->setCategoryPrintMessage(1,FALSE,"Terjadi kesalahan saat proses data");
		//Log data
		$this->sc_st->setNim($this->getNimSessionLogin());
		$this->sc_st->setKode($data['codeRegist']);
		if($this->sc_st->getHaveLastTAInfo(FALSE)){
			$TEMP_COUNT = $this->sc_st->getCount();
			$this->sc_st->resetValue();
			$this->sc_st->setKode($data['codeRegist']);
			$this->sc_st->setNim($this->getNimSessionLogin());
			$this->sc_st->setLogStatus($TEMP_COUNT);
			$this->sc_st->setLog();
		}
		//add new item
		$this->sc_st->resetValue();
		$this->sc_st->setNim($this->getNimSessionLogin());
		$this->sc_st->setKode($data['codereg']);
		$this->sc_st->setJudulTa($data['judulta']);
		$this->sc_st->setNip($data['dosbing']);
		$this->sc_st->setMetode($TEMP_ARRAY['METODE']);
		$this->sc_st->setLokasi($TEMP_ARRAY['LOKASI']);
		$this->sc_st->setReferensis($TEMP_ARRAY['REF_S']);
		$this->sc_st->setReferensid($TEMP_ARRAY['REF_D']);
		$this->sc_st->setReferensit($TEMP_ARRAY['REF_T']);
		$this->sc_st->setNamaKrs($krsname);
		$this->sc_st->setKategori("2");
		$this->sc_st->setNewData();
		//log
		$this->sc_lms->resetValue();
		$this->sc_lms->setNim($this->getNimSessionLogin()); 
		$this->sc_lms->setTanggal(DATE("Y-m-d H:i:s")); 
		$this->sc_lms->setEvent("Registrasi Lama");
		$this->sc_lms->addNew();
		return $this->setCategoryPrintMessage(1, true, "Valid");
	}
	//Registerasi Baru proses
	public function setRegistrasiBaru($data){
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$conPic['upload_path'] = './upload/krs/';
		$conPic['allowed_types'] = 'pdf';
		$conPic['file_name'] = $data['codereg']."-".$data['nim']."-krs";
		$conPic['overwrite'] = true;
		$conPic['remove_spaces'] = true;
		$conPic['max_size'] = 1024;
		$this->setLibrary('upload');
		$this->upload->initialize($conPic);
		if(!$this->upload->do_upload($data['krs'])){
			return $this->setCategoryPrintMessage(1, false, 'file yang di upload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$krsname = $this->upload->data('file_name');
		
		//update data
		$this->sc_sm->setNim($this->getNimSessionLogin());
		$this->sc_sm->setName($data['nama']);
		$this->sc_sm->setEmail($data['email']);
		$this->sc_sm->setPeminatan($data['minat']);
		$this->sc_sm->setNohp($data['nohp']);
		$this->sc_sm->setNamaOrtu($data['ortu']);
		$this->sc_sm->setNoHpOrtu($data['nohportu']);
		$this->sc_sm->setForceRegNew("2");
		$this->sc_sm->setOpenForm($data['newf']);
		if(!$this->sc_sm->updateData())
			return $this->setCategoryPrintMessage(1,false,"Terjadi kesalahan pada saat registrasi baru");
		
		//log data
		$this->sc_st->setNim($this->getNimSessionLogin());
		$this->sc_st->setKode($data['codereg']);
		if($this->sc_st->getHaveLastTAInfo(FALSE)){
			if($data['codereg'] == $this->getYearNow()){				
				$TEMP_COUNT = $this->sc_st->getCount();
				$this->sc_st->resetValue();
				$this->sc_st->setKode($data['codereg']);
				$this->sc_st->setNim($this->getNimSessionLogin());
				$this->sc_st->setLogStatus($TEMP_COUNT);
				$this->sc_st->setLog();
			}
		}
		//add new item
		$this->sc_st->resetValue();
		$this->sc_st->setNim($this->getNimSessionLogin());
		$this->sc_st->setKode($data['codereg']);
		$this->sc_st->setJudulTa($data['judulta']);
		$this->sc_st->setMetode($data['metode']);
		$this->sc_st->setLokasi($data['lokasi']);
		$this->sc_st->setReferensis($data['ref1']);
		$this->sc_st->setReferensid($data['ref2']);
		$this->sc_st->setReferensit($data['ref3']);
		$this->sc_st->setNamaKrs($krsname);
		$this->sc_st->setNewData();
		//log
		$this->sc_lms->resetValue();
		$this->sc_lms->setNim($this->getNimSessionLogin()); 
		$this->sc_lms->setTanggal(DATE("Y-m-d H:i:s")); 
		$this->sc_lms->setEvent("Registrasi Baru");
		$this->sc_lms->addNew();
		return $this->setCategoryPrintMessage(1, true, "Valid");
	}
	// -- valid
	protected function filterContentDataPersonal($TEMP_DATA){
		if($TEMP_DATA != "")
			if($TEMP_DATA != " ")
				if($TEMP_DATA != null)
					if(strlen($TEMP_DATA) > 0){
						if($TEMP_DATA == '0'){
							return null;
							continue;
						}
						return $TEMP_DATA;
					}
		return null;
	} 
	//-- valid
	public function getDataPersonal(){
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$this->sc_sm->getDataNim($this->getNimSessionLogin());
		return  array(
				'nama' => $this->filterContentDataPersonal($this->sc_sm->getName()),
				'nim' => $this->filterContentDataPersonal($this->sc_sm->getNim()),
				'nohp' => $this->filterContentDataPersonal($this->sc_sm->getNohp()),
				'email' => $this->filterContentDataPersonal($this->sc_sm->getEmail()),
				'ortu' => $this->filterContentDataPersonal($this->sc_sm->getNamaOrtu()),
				'nohportu' => $this->filterContentDataPersonal($this->sc_sm->getNoHpOrtu()),
				'minat' => $this->filterContentDataPersonal($this->sc_sm->getPeminatan())
		);
	}
	//Seminar TA
	//Seminar TA 1
	//-valid
	public function setNewSeminarTA1($data){
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLockPermission("seminar-ta1"))
			return $this->setCategoryPrintMessage(1, false, "class anda tidak dapat mengakses bagian objek ini");
		if(!isset($data))
			return false;
		$data->setNim("24010313130125");
		echo "hohoho".$data->getNim();
	}

	//-valid 
	public function isAvailableRoomTASOn($TEMP_DATE_TIME,$TEMP_ROOM_NUMBER=1,$SRT = NULL,$CAT=0){
		$this->setHelper('date');
		//echo "koko ".nice_date($TEMP_DATE_TIME,"Y-m-d H:i:s");
		//return;
		if(nice_date($TEMP_DATE_TIME,"Y-m-d H:i:s") == "Invalid Date"){
			return $this->setCategoryPrintMessage($CAT, false, "Anda melakuan debugging dengan format tanggal");
		}
		exit("0 ".nice_date($TEMP_DATE_TIME,"Y-m-d H:i:s"));
		$TEMP_DATE_TIME = nice_date($TEMP_DATE_TIME,"Y-m-d H:i:s");
		$OUR_HOUR = nice_date($TEMP_DATE_TIME,"H");
		$OUR_MINUTE = nice_date($TEMP_DATE_TIME,"i");
		if($SRT == NULL)
			$SRT = $this->getYearNow();
		$this->sc_std->resetValue();
		$this->sc_std->setKode($SRT);
		$this->sc_std->setTanggal($TEMP_DATE_TIME);
		if(!$this->sc_std->getDataTabelOnThisDay())
			return $this->setCategoryPrintMessage($CAT,true,"VALID");
		$ERROR = 0;
		while($this->sc_std->getNextCursor()){
			$OTHER_HOUR = nice_date($this->sc_std->getTanggal(),"H");
			$OTHER_MINUTE = nice_date($this->sc_std->getTanggal(),"i");
			$OUR_AFTER_HOUR = $OUR_HOUR+2;
			$OUR_AFTER_MINUTE = $OUR_MINUTE+30;
			if($OUR_AFTER_MINUTE > 59){
				$OUR_AFTER_MINUTE -= 59;
				$OUR_AFTER_HOUR +=1;
			}
			if(intval($OUR_HOUR) > intval($OTHER_HOUR)){
				if(intval($OUR_HOUR) == intval($OTHER_HOUR)+3){
					if(intval($OTHER_MINUTE) > intval($OUR_MINUTE))
						$ERROR += 1;
				}else if(intval($OUR_HOUR) < intval($OTHER_HOUR)+3){
					$ERROR += 1;
				}
			}else{
				if(intval($OUR_AFTER_HOUR) == intval($OTHER_HOUR)){
					if(intval($OTHER_MINUTE) < intval($OUR_AFTER_MINUTE))
						$ERROR += 1;
				}else if(intval($OUR_AFTER_MINUTE) > intval($OTHER_HOUR)){
					$ERROR += 1;
				}
			}
		}
		//echo "hello".$ERROR;
		if($ERROR > 0)
			return $this->setCategoryPrintMessage($CAT,FALSE,"Maaf, sudah ada yang menempati tanggal tersebut");
		if(intval($OUR_HOUR) < 7){
			$ERROR += 1;
		}else{
			echo intval($OUR_HOUR).intval($OUR_MINUTE);
			if(intval($OUR_HOUR) == 7){
				if(intval($OUR_MINUTE) < 30)
					$ERROR += 1;
			}
		}
		if($ERROR > 0)
			return $this->setCategoryPrintMessage($CAT,FALSE,"Maaf, 07.30 adalah waktu paling pagi");
		
		
		if(intval($OUR_HOUR) > 14){
			$ERROR += 1;
		}else{
			if(intval($OUR_HOUR)+3 == 15){
				if(intval($OUR_MINUTE) > 30)
					$ERROR += 1;
			}else if(intval($OUR_HOUR)+3 > 15){
				$ERROR += 1;
			}
		}
		
		if($ERROR > 0)
			return $this->setCategoryPrintMessage($CAT,FALSE,"Maaf, 02.00 adalah waktu paling sore");
		return $this->setCategoryPrintMessage($CAT,true,"VALID");
	}
	//waiting
	/*
	*/
	//protected
	//private
}