<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once ("Aktor.php");
class Mahasiswa extends Aktor{
	protected $key;
	protected $keyBoolean;
	function __construct() {
		parent::__construct();
		$this->setLibrary("inputjaservfilter");
		$this->setLibrary("session");
		$this->setHelper("url");
		$this->setModel("sc_sm");
		$this->setModel("multi_sc");
		$this->setModel("sc_st");
		$this->setModel("sc_lms");
		$this->setModel("sc_sm_interest");
		$this->setFalseLockPublic();
		$this->setNewDataEncrypt("JaservTech.Mahasiswa.Public.Control.Open");
		$this->setKeyPermissionDefault();
		$this->setFalsePermission('sign-in');
		$this->setFalsePermission('sign-up');
		$this->setFalsePermission('registrasi-con');
		$this->setFalsePermission('registrasi-new');
		$this->setFalsePermission('seminar-ta1');
		$this->setFalsePermission('seminar-ta2');
	}
	/*public*/
	/*login-logout-daftar*/
	/*Lock*/
	protected function setKeyPermissionDefault(){$this->key['sign-in']='JaservTech.Mahasiswa.SignIn.Controls'; $this->key['sign-up']='JaservTech.Mahasiswa.SignUp.Controls'; $this->key['registrasi-con']='JaservTech.Mahasiswa.Reg.Con.Controls'; $this->key['registrasi-new']='JaservTech.Mahasiswa.Reg.New.Controls'; $this->key['seminar-ta1']='JaservTech.Mahasiswa.Sem.Ta.1.Controls'; $this->key['seminar-ta2']='JaservTech.Mahasiswa.Sem.Ta.2.Controls';}
	protected function setTruePermission($a){switch ($a){case 'sign-in' :case 'sign-up' :case 'registrasi-con' :case 'registrasi-new' :	case 'seminar-ta1' : case 'seminar-ta2' :$this->keyBoolean[$a]=true; return true; break; default :return false;	break;}	}
	protected function getStatusLockPermission($a){	$i=false;switch ($a){case 'sign-in' :case 'sign-up' :case 'registrasi-con' :case 'registrasi-new' :case 'seminar-ta1' :	case 'seminar-ta2' :$i = $this->keyBoolean[$a];	break;}	return $i;}	
	protected function setFalsePermission($a){switch ($a){case 'sign-in' :	case 'sign-up' :case 'registrasi-con' :	case 'registrasi-new' :	case 'seminar-ta1' : case 'seminar-ta2' :$this->keyBoolean[$a]=false;return true;break;	default :return false;break;}}
	public function setOpenPermission($cat="",$code=""){$error=0;if($this->getStatusLockPublic()){if($code == "")$error+=1;	if($cat == "")$error+=1;if(md5($code) != md5($this->key[$cat]))	$error+=1;if($error > 0){$this->setFalsePermission($cat);}else{$this->setTruePermission($cat);}	}}
	/*daftar*/
	//ok
	public function getYearNow(){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$year = DATE("Y");
		$month = DATE("m");
		if(intval($month) >= 1 && intval($month)<=6){
			return intval((intval($year)-1)."2");
		}else{
			return intval($year."1");
		}
	}
	//ok
	public function getStatusSignUpMahasiswa($data=""){
		if(!$this->getStatusLockPublic() || $data=="")
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLockPermission('sign-up'))
			return $this->setCategoryPrintMessage(0, false, "class Anda tidak memiliki akses terhadap object mahasiswa sign up, perbaiki key anda.");
		$error = 0;
		$errorMessage = "";
		$temp = $this->getCheckNim($data['nim'],1);
		if(!$temp[0]){
			$error+=1;
			$errorMessage.=$temp[1]."<br>";
		}else{
			$nim = $data['nim'];
			$ff = $this->sc_sm->query('*','s_nim="'.$nim.'"')->row_array();
			if(count($ff) > 0){
				if($ff['s_nim'] == $nim)
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
			$error+=1;
			$errorMessage.=$temp[1]."<br>";
		}else{
			$telephone = $data['telephone'];
		}
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
                $this->sc_sm->unloackAktor("JASERVTECH.MAHASISWA");
		$succ = 0;
                $succ+=$this->sc_sm->signUp();
                /*
		$succ += $this->sc_sm->insert(array(
				's_nim' => $nim,
				's_name' => $name,
				's_password' => md5($password1),
				's_email' => $email,
				's_nohp' => $telephone,
				's_active_year' => $year,
				's_foto_name' => $fotoname,
				's_transcript_name' => $transkripname,
				's_code_cookie' => md5($nim+DATE('Y-m-d'))
		));
                 * */
		//->
                $this->sc_lms->setNim($nim);
                $this->sc_lms->setTanggal(DATE("Y-m-d H:i:s"));
                $this->sc_lms->setEvent("mendaftar baru");
                $succ+=$this->sc_lms->addNew();
                /*
		$succ+=$this->sc_lms->insert(array(
				'l_nim' => $nim,
				'l_date' => DATE("Y-m-d H:i:s"),
				'l_event' => "mendaftar baru"
		));
                 * */
                 
		if($succ == 2)
			return $this->setCategoryPrintMessage(0, true, "Data Berhasil dimasukan ");
		else
			return $this->setCategoryPrintMessage(0, false, "Terjadi kesalahan, silahkan ulangi atau tunggu beberapa saat");
			
	}
	/*login*/
	//ok
	public function getStatusLoginMahasiswa(){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$error = 0;
		if(!$this->session->has_userdata('login'))
			$error+=1;
		else{
			if($this->session->userdata('login') != 'true')
				$error+=1;
		}
		if(!$this->session->has_userdata('nim'))
			$error+=1;
		if(!$this->session->has_userdata('name'))
			$error+=1;
		
		if(!$this->session->has_userdata('pass'))
			$error+=1;
		else{
			if($this->session->userdata('pass') != $this->getResultEncryptMahasiswaString($this->session->userdata('name')))
				$error+=1;
		}
		if($error >0)
			return false;
		else
			return true;
	}
	//ok
	public function setLoginMahasiswa($nim="",$password=""){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLockPermission("sign-in"))
			return $this->setCategoryPrintMessage(0, false, "class anda tidak memiliki akses terhadap object mahasiswa sign in");
		$this->CI->load->model('sc_sm');
		$this->sc_sm = $this->CI->sc_sm;
                
                $this->sc_sm->setNim($nim);
                if(!$this->sc_sm->signIn())
                    return $this->setCategoryPrintMessage(1, false, "nim dan kata kunci tidak terdaftar");
                if($this->sc_sm->getNim() != $nim)
                    return $this->setCategoryPrintMessage(1, false, "nim dan kata kunci tidak terdaftar");
                if($this->sc_sm->getPassword() != md5($password))
                    return $this->setCategoryPrintMessage(1, false, "nim dan kata kunci tidak terdaftar");
                /*
                
		$temp = $this->sc_sm->query("*","s_password='".md5($password)."' AND s_nim='".$nim."'")->row_array();
                    
                if(count($temp) <= 0)
			return $this->setCategoryPrintMessage(1, false, "nim dan kata kunci tidak terdaftar");
		if($temp['s_nim']."" != $nim."")
			return $this->setCategoryPrintMessage(1, false, "Nim salah, tidak terdaftar");
		if($temp['s_password']."" != md5($password)."")
			return $this->setCategoryPrintMessage(1, false, "kata kunci salah, tidak sesuai");
                 * 
                 */
		if($this->getStatusLoginMahasiswa()){
			if($this->session->userdata('nim') == $nim){
				return $this->setCategoryPrintMessage(1,true, "Classroom.aspx");
			}
		}
		$this->session->set_userdata("login",'true');
		$this->session->set_userdata("nim",$temp['s_nim']);
		$this->session->set_userdata("name",$temp['s_name']);
		$this->session->set_userdata("pass",$this->getResultEncryptMahasiswaString($temp['s_name']));
		return $this->setCategoryPrintMessage(1,true,"Classroom.aspx");
	}
	//ok
	public function setStatusLogOutMahasiswa(){
		if(!$this->getStatusLoginMahasiswa())
			return false;
		$this->session->unset_userdata("login");
		$this->session->unset_userdata("nim");
		$this->session->unset_userdata("name");
		$this->session->unset_userdata("pass");
		return true;
	}
	/*form-session*/
	/*
	 * registrasi 
	 * ->0 echo 0
	 * ->1....... return false;
	 * */
	//koor
	public function getListMahasiswaPemerataan($akademik){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$this->multi_sc->initial("sc_st,sc_sm,sc_sm_interest");
		return $this->multi_sc->query("
				sc_sm.s_nim as nim, 
				sc_sm.s_name as nama, 
				sc_sm_interest.si_name as minat,
				sc_sm.s_nip_review_1 as nipreviews,
				sc_sm.s_nip_review_2 as nipreviewd,
				sc_sm.s_nip_review_3 as nipreviewt,
				sc_st.s_category as kategori,
				sc_st.s_nip as nip
			",
			"
				sc_sm.s_nim=sc_st.s_nim AND
				sc_sm.s_statue=1 AND
				sc_st.s_statue=1 AND
				sc_st.s_data_statue=0 AND
				sc_sm_interest.si_id=sc_sm.s_p AND
				sc_st.s_rt=".$akademik." order by sc_sm.s_nim
			"
			)->result_array();
	}
	//ok
	public function getContactFormat($nim=""){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getCheckNim($nim,1)[0]){
			return $this->setCategoryPrintMessage(1, false, "Nim tidak sesuai");
		}
		return $this->setCategoryPrintMessage(1, true, $this->sc_sm->query("s_foto_name as foto, s_name as nama","s_nim='".$nim."'")->row_array());
	}
	//koor
	public function getCountDospem($nip="",$srt=""){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($nip == "")
			return $this->setCategoryPrintMessage(1, false, 'data nip kosong');
		if($srt == "")
			return $this->setCategoryPrintMessage(1, false, 'data akademik kosong');
		return $this->setCategoryPrintMessage(1, true, $this->sc_st->query("*","s_rt=".$srt." AND s_nip=".$nip." AND s_statue=1 AND s_data_statue=0")->result_array());
	}
	//koor
	public function setDospemForTA($nim,$nip,$srt){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getCheckNim($nim,1)[0])
			return false;
		if($nip == "")
			return false;
		if($srt == "")
			return false;
		$temps = $this->sc_st->query("*","s_rt=".$srt." AND s_statue=1 AND s_nim='".$nim."'")->row_array();
		$tempp = $this->sc_st->query("*","s_rt=".$srt." AND s_nim='".$nim."'")->result_array();
		$tempp = count($tempp);
		$temp = $this->sc_st->update(
				"
				`s_statue`='2',
				`s_data_statue`='".$tempp."'
				",
				"
				s_statue=1 AND
				s_rt=".$srt." AND
				s_nim='".$nim."' AND
				s_data_statue=0
				");
		$this->sc_st->insert(array(
				's_rt' => $temps['s_rt'],
				's_nim' => $temps['s_nim'],
				's_nip' => $nip,
				's_judul_ta' => $temps['s_judul_ta'],
				's_metode' => $temps['s_metode'],
				's_ref_s' => $temps['s_ref_s'],
				's_ref_d' => $temps['s_ref_d'],
				's_ref_t' => $temps['s_ref_t'],
				's_lokasi' => $temps['s_lokasi'],
				's_name_krs' => $temps['s_name_krs'],
				's_statue' => $temps['s_statue'],
				's_data_statue' => $temps['s_data_statue'],
				's_category' => $temps['s_category'],
				's_data_process' => $temps['s_data_process']
		));
		return true;
		
	}
	//koor
	public function getLastDosenIfExist($tahunAjaran,$nim){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->sc_st->query("s_nip as nip","s_nim=".$nim." AND s_rt=".$tahunAjaran." AND s_statue=2 ORDER BY s_data_statue desc")->result_array();
		return $temp;
	}
	//koor
	public function setDosenPembimbing($nim,$nip){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$this->sc_st->update("`s_nip`='".$nip."'","s_nim='".$nim."' AND s_statue=1 AND s_data_statue=0");
		return true;
	}
	//ok
	public function getListPeminatan(){//sudah
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->sc_sm_interest->query("si_id as id, si_name as nama")->result_array();
		return $temp;
	} 
	//ok
	public function setRemoveOldFavor($nip){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->getTableDosenReview();
		foreach($temp as $key => $value){
			if($value == $nip){
				$this->sc_sm->update("`".$key."`='0'","s_nim='".$this->session->userdata('nim')."'");
				exit("1berhasil melakukan penghapusan");
			}
		}
		exit("0Maksimal 3 dosen favorite");
	} 
	//ok
	public function setAddNewFavor($nip){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->getTableDosenReview();
		foreach($temp as $value){
			if($value == $nip)
				exit("0Anda melakukan debuging terhadap system");
		}
		foreach($temp as $key=>$value){
			if(intval($value) == 0){
				$this->sc_sm->update("`".$key."`='".$nip."'","s_nim='".$this->session->userdata('nim')."'");
				exit("1berhasil melakukan penambahan");
			}
		}
		exit("0Maksimal 3 dosen favorite");
	}
	//ok
	public function getIsMyDosenReview($nip){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->getTableDosenReview();
		foreach($temp as $key => $value){
			if($value == $nip){
				return true; 
			}
		}
		return false;
	}
	//koor - ok -sc_sm
	public function getTableDosenReview($nim = ''){
		if($nim == '')
			return $this->sc_sm->query("s_nip_review_1 , s_nip_review_2 , s_nip_review_3 "
				,"s_nim='".$this->session->userdata('nim')."'")->row_array();
		else 	
			return $this->sc_sm->query("s_nip_review_1 , s_nip_review_2 , s_nip_review_3 "
					,"s_nim='".$nim."'")->row_array();
	}
	//ok -review
	public function getDataPersonal(){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->sc_sm->query("*","s_nim='".$this->session->userdata('nim')."'")->row_array();
		foreach($temp as $key => $colomn){
			if($colomn != "")
				if($colomn != " ")
					if($colomn != null)
						if(strlen($colomn) > 0){
							if($colomn == '0'){
								$temp2[$key]=null;
								continue;
							}
							$temp2[$key]=$colomn;
							continue;
						}
			$temp2[$key]=null;
							
		}
		return  array(
				'nama' => $temp2['s_name'],
				'nim' => $temp2['s_nim'],
				'nohp' => $temp2['s_nohp'],
				'email' => $temp2['s_email'],
				'ortu' => $temp2['s_name_parent'],
				'nohportu' => $temp2['s_nohp_parent'],
				'minat' =>$temp2['s_p']
		);
	}
	//ok review
	public function getCodeRegLastTA(){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$idNow=$this->getYearNow()."";
		$time = $this->sc_sm->query("s_active_year as codereg","s_nim='".$this->session->userdata('nim')."'")->row_array();
		$time['codereg'] .="";
		$end = substr($idNow, 0,strlen($idNow)-1);
		$endK = $idNow[strlen($idNow)-1];
		if(intval($endK) == 2){
			$endK = "1";
		}else{
			$endK = "2";
			$end = (intval($end)-1);
		}
		$endKV = intval($end."".$endK);
		$start = intval(substr($time['codereg'], 0,strlen($time['codereg'])-1));
		$startK = $time['codereg'][strlen($time['codereg'])-1];
		$startKV = intval($start."".$startK);
		$totalLoor = 0;
		for($i=$end; $i>= $start;$i--){
			for($j=2;$j>=1;$j--){
				$contId = intval($i."".$j);
				if($contId < $endKV && $contId >= $startKV){
					$totalLoor+=1;
				}
				if($contId <= $endKV && $contId >= $startKV){
					if($this->getHaveLastTAInfo("".$contId)[0]){
						return array(true,$contId,$totalLoor);
					}
				}
			}
		}
		return array(false,null,null);
	}
	//ok review
	public function getCheckFormRegistrasiPemission(){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->sc_sm->query("s_new_form as kode_registrasi","s_nim='".$this->session->userdata('nim')."'")->row_array();
		if(intval($temp['kode_registrasi']) == 1){
			return true;
		}else{
			return false;
		}
	}
	//ok review
	public function getHaveLastTAInfo($idbefore){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$temp=$this->sc_st->query("*","s_nim='".$this->session->userdata('nim')."' AND s_rt=".$idbefore)->result_array();
		if(count($temp)==0){
			return array(false,null);
		}
		return array(true,$temp);
	} 
	//ok review
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
	//ok review
	public function getResultForceRegistration($data=1){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		$temp=$this->sc_sm->query("*","s_nim='".$this->session->userdata('nim')."'")->row_array();
		if($data == 1){
			if(intval($temp['s_force_registrasi']) == 1){
				return true;
			}
			return false;
		}else{
			if(intval($temp['s_force_registrasi_lama']) == 1){
				return true;
			}
			return false;
		}
	}
	//ok review
	public function setRegistrasiLama($data){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLockPermission("registrasi-con"))
			return $this->setCategoryPrintMessage(1, false, "class anda tidak dapat mengakses bagian objek ini");
		
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
		$tempsS= $this->getTAInfo($data['codeRegist']."",array(
			'metode',
			'lokasi',
			'ref1',
			'ref2',
			'ref3'
		));
		$krsname = $this->upload->data('file_name');
		$tempsD = $this->getDataPersonal();
		$this->sc_sm->update("
				`s_name`='".$data['nama']."',
				`s_email`='".$data['email']."',
				`s_p`='".$tempsD['minat']."',
				`s_nohp`='".$data['nohp']."',
				`s_nohp_parent`='".$data['nohportu']."',
				`s_name_parent`='".$data['ortu']."',
				`s_new_form`='".$data['newf']."',
				`s_force_registrasi_lama`='2'
				","s_nim='".$this->session->userdata('nim')."'");
		$temps = $this->sc_st->query("*","s_rt=".$data['codereg']." AND s_nim='".$data['nim']."'")->result_array();
		$var = count($temps);
		if($var > 0){
			$this->sc_st->update("`s_statue`='2', `s_data_statue`='".$var."'","s_rt=".$data['codereg']." AND s_nim='".$data['nim']."' AND s_statue=1");
		}
		$this->sc_st->insert(array(
				's_rt' => $data['codereg'],
				's_nim' => $data['nim'],
				's_nip' => $data['dosbing'],
				's_judul_ta' => $data['judulta'],
				's_metode' => $tempsS[1]['metode'],
				's_lokasi' => $tempsS[1]['metode'],
				's_ref_s' => $tempsS[1]['ref1'],
				's_ref_d' => $tempsS[1]['ref2'],
				's_ref_t' => $tempsS[1]['ref3'],
				's_name_krs' => $krsname
		));
		$this->sc_lms->insert(array(
				'l_nim' => $data['nim'],
				'l_date' => DATE("Y-m-d H:i:s"),
				'l_event' => "Rigistrasi Melanjutkan"
		));
		return $this->setCategoryPrintMessage(1, true, "Valid");
		
	}
	//ok review
	public function setRegistrasiBaru($data){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLockPermission("registrasi-new"))
			return $this->setCategoryPrintMessage(1, false, "class anda tidak dapat mengakses bagian objek ini");
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
		$this->sc_sm->update("
				`s_name`='".$data['nama']."',
				`s_email`='".$data['email']."',
				`s_p`='".$data['minat']."',
				`s_nohp`='".$data['nohp']."',
				`s_nohp_parent`='".$data['nohportu']."',
				`s_name_parent`='".$data['ortu']."',
				`s_new_form`='".$data['newf']."',
				`s_force_registrasi`='2'
				","s_nim='".$this->session->userdata('nim')."'");
		$temps = $this->sc_st->query("*","s_rt=".$data['codereg']." AND s_nim='".$data['nim']."'")->result_array();
		$var = count($temps);
		if($var > 0){
			$this->sc_st->update("`s_statue`='2', `s_data_statue`='".$var."'","s_rt=".$data['codereg']." AND s_nim='".$data['nim']."' AND s_statue=1");
		}
		$this->sc_st->insert(array(
			's_rt' => $data['codereg'],
			's_nim' => $data['nim'],
			's_judul_ta' => $data['judulta'],
			's_metode' => $data['metode'],
			's_lokasi' => $data['lokasi'],
			's_ref_s' => $data['ref1'],
			's_ref_d' => $data['ref2'],
			's_ref_t' => $data['ref3'],
			's_name_krs' => $krsname
		));
		$this->sc_lms->insert(array(
			'l_nim' => $data['nim'],
			'l_date' => DATE("Y-m-d H:i:s"),
			'l_event' => "Rigistrasi Baru"
		));
		return $this->setCategoryPrintMessage(1, true, "Valid");
	}
	//ok
	//public use
	public function getCheckNim($nim="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($nim == ""){
			return $this->setCategoryPrintMessage($cat, false, "nim tidak sesuai");
		}	
		if(substr($nim,0,3) == "J2F"){
			if(strlen($nim)!= 9){
				return $this->setCategoryPrintMessage($cat, false, "bukan merupakan standar nim angkatan 2009 kebawah");
			}
			if($this->inputjaservfilter->numberFiltering(substr($nim,3,strlen($nim)-3))[0]){
				return $this->setCategoryPrintMessage($cat, true, "nim disetujui");
			}else{
				return $this->setCategoryPrintMessage($cat, false, "nim mengandung karakter lain");
			}
		}else{
			if(strlen($nim) != 14)
				return $this->setCategoryPrintMessage($cat, false, "bukan merupakan standar nim angkatan 2010 ke atas");
			if($this->inputjaservfilter->numberFiltering($nim)[0]){
				return $this->setCategoryPrintMessage($cat, true, "nim disetujui");
			}else{
				return $this->setCategoryPrintMessage($cat, false, "nim mengandung karakter lain");
			}
		}
	}
	//ok
	public function getIsNimExist($data){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->sc_sm->query("*","s_nim='".$data."'")->row_array();
		if(count($temp) > 0)
			return true;
		return false;
	}
	//ok
	public function getCheckMethode($methode="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($methode == "")
			return $this->setCategoryPrintMessage($cat, false, "Metode tidak boleh kosong");
		$temp = $this->inputjaservfilter->usernameFiltering($methode);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	//ok
	public function getCheckLokasi($lokasi="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($lokasi == "")
			return $this->setCategoryPrintMessage($cat, true, "valid"); //boleh kosong tau tidak
		$temp = $this->inputjaservfilter->usernameFiltering($lokasi);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	//ok
	public function getCheckRefrence($refrence="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($refrence == "")
			return $this->setCategoryPrintMessage($cat, true, "valid"); //boleh kosong tau tidak
		$temp = $this->inputjaservfilter->usernameFiltering($refrence);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	//ok
	public function getCheckInterested($interested="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$interested.="";
		if($interested == "")
			return $this->setCategoryPrintMessage($cat, false, "peminatan tidak booleh kosong"); //boleh kosong tau tidak
		$temp = $this->inputjaservfilter->numberFiltering($interested);
		if($temp[0]){
			if(strlen($interested) == 1)
			{
				if((intval($interested) > 0) && (intval($interested)<5))
				{
					return $this->setCategoryPrintMessage($cat, true, $temp[1]);
				}
				return $this->setCategoryPrintMessage($cat, false, "diwajibkan memilih salah satu");
			}
		}
		return $this->setCategoryPrintMessage($cat, false, "kode anda rubah dari standar");
	}
	//ok
	public function getCheckTitleFinalTask($titleFinalTask="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($titleFinalTask == "")
			return $this->setCategoryPrintMessage($cat, true, "valid"); //boleh kosong tau tidak
		$temp = $this->inputjaservfilter->titleFiltering($titleFinalTask);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	//ok
	public function getCheckPassword($password="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($password == "")
			return $this->setCategoryPrintMessage($cat, false, "password tidak boleh kosong");
		$temp = $this->inputjaservfilter->passwordFiltering($password);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	//ok
	public function getDataMahasiswaLoginInterfaceDefault(){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa()){
			return (array(false,null));
		}
		$temp = $this->session->userdata('nim');
		$temp = $this->sc_sm->query('s_nim as nim, s_name as nama, s_foto_name as foto','s_nim="'.$temp.'"')->row_array();
		if(count($temp) <=0)
			return (array(false,null));
		else
			return (array(true,$temp));
	}
	
	/*protected*/
	/*form-session*/
	/*login-logout-daftar*/
	protected function getResultEncryptMahasiswaString($string){return md5($string."Mahasiswa.Encrypt.String");}
	
	/*private*/
	//ok
	/*Seminar Session*/
	public function isAnyGuysOnThisDay($date,$ta,$srt,$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$this->setHelper('date');
		//$this->setModel('');
		if(nice_date($date,"Y-m-d h:i:s") == 'Invalid Date')
			return $this->setCategoryPrintMessage($cat, false, "anda melakukan debugging terhadap format date");
		$this->setModel('sc_sst');
		$time = nice_date($date,"h:i:s");
		$date = nice_date($date,"Y-m-d");
		//$temp = $this->sc_sst->query("s_time as time","s_date='".$date."'")->result();
		$this->sc_sst->openPermission('mahasiswa',"Lock.Mahasiswa.Open.Methode.JaservTech");
		$temp = $this->sc_sst->getTimeEventRoomOnDate($srt,$date);
		if(isset($temp)){
			foreach ($temp as $value){
				echo $value->timeSeminarTA."<br>";
				$hour = intval(nice_date($value->timeSeminarTA,"h"));
				$minute = intval(nice_date($value->timeSeminarTA,"i"));
				$hourN = intval(nice_date($time,"h"));
				$minuteN = intval(nice_date($time,"i"));
				if($ta == 1 ){
					$jam = 2;
				}else if($ta == 2){
					$jam = 3;
				}else{
					return $this->setCategoryPrintMessage($cat, false, "anda melakukan debugging terhadap input ta");
				}
				if($hour <= $hourN){
					if($hour+$jam > $hourN){
						return $this->setCategoryPrintMessage($cat, false, "jam sudah ada yang mengambil");
					}else if($hour+$jam == $hourN){
						if($minute > $minuteN){
							return $this->setCategoryPrintMessage($cat, false, "Jam sudah ada yang mengambil");
						}
					}
				}else {
					if($hour < $hourN+$jam){
						return $this->setCategoryPrintMessage($cat, false, "jam sudah ada yang mengambil");
					}else if($hour == $hourN+$jam){
						if($minute < $minuteN){
							return $this->setCategoryPrintMessage($cat, false, "Jam sudah ada yang mengambil");
						}
					}
				}
				return $this->setCategoryPrintMessage($cat, true, "valid");
			}
		}
		return $this->setCategoryPrintMessage($cat, true, "valid");
		
	}
	//ok
	protected function getLoadClassInterface($name){
		require_once 'Interface_'.$name;
	}
	//ok
	public function setNewSeminarTA1($data){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLoginMahasiswa())
			header("location:".base_url()."gateinout.aspx");
		if(!$this->getStatusLockPermission("seminar-ta1"))
			return $this->setCategoryPrintMessage(1, false, "class anda tidak dapat mengakses bagian objek ini");
		if(!isset($data))
			return false;
		$data->setNim("24010313130125");
		echo "hohoho".$data->getNim();
	}
}