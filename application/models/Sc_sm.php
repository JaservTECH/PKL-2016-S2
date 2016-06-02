<?php
	//query builder - Ok
	//arrayBuilder - Ok
	//automaSetContent - Ok
	//resetValue - Ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_sm extends CI_Model {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_sm';
        $this->resetValue();
		$this->load->library('session');
		$this->TEMP_RESULT_ARRAY = NULL;
		$this->TEMP_INDEX_RESULT_ARRAY = 0;
	}
	//is could do seminar TA?
	public function getCheckSeminarPermission($code=1){
		if($this->getNim() == NULL)
			return false;
		$TEMP_ARRAY = $this->query("s_seminar_ta1,s_seminar_ta2","s_nim='".$this->getNim()."'")->row_array();
		$this->automaSetContent($TEMP_ARRAY);
		if($code == 1){
			if($this->getSeminarTA1() == NULL)
				return false;
			if(intval($this->getSeminarTA1()) == 1){
				return true;
			}else{
				return FALSE;
			}
		}else{
			if($this->getSeminarTA2() == NULL)
				return false;
			if(intval($this->getSeminarTA2()) == 1){
				return true;
			}else{
				return FALSE;
			}
		}
	}
	//registrasi form permission
	public function getCheckFormRegistrasiPemission(){
		if($this->getNim() == NULL)
			return false;
		$TEMP_ARRAY = $this->query("s_new_form","s_nim='".$this->getNim()."'")->row_array();
		$this->automaSetContent($TEMP_ARRAY);
		if($this->getOpenForm() == NULL)
			return false;
		if(intval($this->getOpenForm()) == 1){
			return true;
		}else{
			return FALSE;
		}
	}
	//getResult force registrasi permission
	public function getResultForceRegistration($TEMP_DATA=1){
		if($this->getNim() == NULL)
			return FALSE;
		$TEMP_ARRAY = $this->query("*","s_nim='".$this->getNim()."'")->row_array();
		$this->automaSetContent($TEMP_ARRAY);
		if($TEMP_DATA == 1){
			if(intval($this->getForceRegNew()) == 1){
				return TRUE;
			}
			return FALSE;
		}else{
			if(intval($this->getForceRegLama()) == 1){
				return TRUE;
			}
			return FALSE;
		}
	}
	public function setGetAktiveYear(){
		if($this->getNim() == NULL)
			return false;
		$TEMP_ARRAY = $this->query("s_active_year","s_nim='".$this->getNim()."'")->row_array();
		if(count($TEMP_ARRAY) <= 0){
			$this->resetValue();
			return false;
		}else{
			$this->automaSetContent($TEMP_ARRAY);
			return true;
		}
	} 
    //operasi
	public function signUp(){
		if(!$this->mahasiswa)
			return 0;
		return $this->insert($this->arrayBuilder());
	}
	public function getAllData(){
		$this->TEMP_RESULT_ARRAY = $this->query('*')->result_array();
		return $this->neutralizedResultArray();
	}
	//neutralizedResultArray
	protected function neutralizedResultArray(){
		$this->TEMP_INDEX_RESULT_ARRAY = 0;
		if(!is_array($this->TEMP_RESULT_ARRAY)){
			$this->TEMP_RESULT_ARRAY = NULL;
			return FALSE;
		}
		if(count($this->TEMP_RESULT_ARRAY) <= 0){
			$this->TEMP_RESULT_ARRAY = NULL;
			return FALSE;
		}
		return TRUE;
		
		
	}
	public function getNextCursor(){
		if(is_array($this->TEMP_RESULT_ARRAY)){
			if(array_key_exists($this->TEMP_INDEX_RESULT_ARRAY,$this->TEMP_RESULT_ARRAY)){
				$this->automaSetContent($this->TEMP_RESULT_ARRAY[$this->TEMP_INDEX_RESULT_ARRAY]);
				$this->TEMP_INDEX_RESULT_ARRAY+=1;
				return true;
			}else{
				$this->resetValue();
				return false;
			}
		}else{
			$this->resetValue();
			return false;
		}
	}
	
	public function getDataNim($TEMP_VALUE_NIM=""){
		if($TEMP_VALUE_NIM == ""){
			return false;
		}else{
			$TEMP_ROW_ARRAY = $this->query('*','s_nim="'.$TEMP_VALUE_NIM.'"')->row_array();
			if(count($TEMP_ROW_ARRAY) > 0){	$this->automaSetContent($TEMP_ROW_ARRAY); return true; }else{ $this->resetValue(); return false;}
		}
	}
	public function updateData(){
		if($this->getNim() == NULL)
			return FALSE;
		$TEMP_NIM = $this->getNim();
		$this->setNim(NULL);
		if($this->queryBuilder() == "")
			return FALSE;
		$this->update($this->queryBuilder(),"s_nim='".$TEMP_NIM."'");
		return true;
	}
	//session NIP
	protected function getAllNipReview(){	return $this->query("s_nip_review_1 , s_nip_review_2 , s_nip_review_3 ","s_nim='".$this->getNim()."'")->row_array(); }
	public function dropNipPreview($TEMP_VALUE_NIP){
		if($this->getNim() == NULL)
			return false;
		$TEMP_ROW_ARRAY = $this->getAllNipReview();
		foreach($TEMP_ROW_ARRAY as $TEMP_INDEX_KEY => $TEMP_VALUE){
			if($TEMP_VALUE == $TEMP_VALUE_NIP){
				$this->update("`".$TEMP_INDEX_KEY."`='0'","s_nim='".$this->getNim()."'");
				return true;
			}
		}
		return false;
	}
	
	public function isInThisNipInReview($TEMP_VALUE_NIP){
		if($this->getNim() == NULL){
			return false;
		}
		$TEMP_ROW_ARRAY = $this->getAllNipReview();
		foreach($TEMP_ROW_ARRAY as $TEMP_VALUE){
			if($TEMP_VALUE == $TEMP_VALUE_NIP){
				return true;
			}
		}
		return false;
	}
	
	//on review
	public function addNipPreview($TEMP_VALUE_NIP){
		if($this->getNim() == NULL){
			return false;
		}
		$TEMP_ROW_ARRAY = $this->getAllNipReview();
		foreach($TEMP_ROW_ARRAY as $TEMP_INDEX_KEY => $TEMP_VALUE){
			if($TEMP_VALUE == $TEMP_VALUE_NIP){
				return false;
			}
		}
		foreach($TEMP_ROW_ARRAY as $TEMP_INDEX_KEY => $TEMP_VALUE){
			if(intval($TEMP_VALUE) == 0){
				$this->update("`".$TEMP_INDEX_KEY."`='".$TEMP_VALUE_NIP."'","s_nim='".$this->getNim()."'");
				return true;
			}
		}
		return false;
	}
	public function getTableDosenReview(){
		if($this->getNim() == NULL) return false;
		$TEMP_ARRAY = $this->getAllNipReview();
		$this->automaSetContent($TEMP_ARRAY);
		return true;
	}
	//end session
	/*
	public function getTableDosenReview(){
		if($this->getNim() == null){
			$TEMP_ROW_ARRAY = $this->query("s_nip_review_1 , s_nip_review_2 , s_nip_review_3 ","s_nim='".$this->session->userdata('nim')."'")->row_array();
		}else{
			$TEMP_ROW_ARRAY = $this->query("s_nip_review_1 , s_nip_review_2 , s_nip_review_3 ","s_nim='".$nim."'")->row_array();
		}
		$this->setNipReview1($TEMP_ROW_ARRAY['s_nip_review_1']);
		$this->setNipReview2($TEMP_ROW_ARRAY['s_nip_review_2']);
		$this->setNipReview3($TEMP_ROW_ARRAY['s_nip_review_3']);
	}
	public function remove{
		$this->sc_sm->update("`".$key."`='0'","s_nim='".$this->session->userdata('nim')."'");
	}
    public function signIn(){
		if($this->getNim() == null)
			return false;
		$temp = $this->query("s_nim, s_password, s_name","s_nim='".$this->getNim()."'")->row_array();
		if(count($temp)<=0)
			return false;
		$this->setName($temp['s_name']);
		$this->setPassword($temp['s_password']);
		$this->setNim($temp['s_nim']);
		return true;
	}
	*/
	public function resetValue(){
		$this->category = null;
		$this->setName(null);  $this->setNim(null); $this->setPassword(NULL); $this->setEmail(null);
		$this->setStatus(null); $this->setPeminatan(null); $this->setNohp(null); $this->setAktifTahun(null);
		$this->setNamaOrtu(null); $this->setNoHpOrtu(null); $this->setSemester(null); $this->setOpenForm(null);
		$this->setForceRegLama(null); $this->setForceRegNew(null); $this->setSeminarTA1(null); $this->setSeminarTA2(null);
		$this->setFotoname(null); $this->setTranskripName(null); $this->setCodeCokie(null); $this->setNipReview1(null);
		$this->setNipReview2(null); $this->setNipReview3(null); $this->setForceSemTog(null);
	}

	//protected
	protected function query($select='*',$where=""){
		$query="SELECT ".$select." FROM ".$this->tablename;
		if($where!="")
			$query=$query." WHERE ".$where;
		return $this->db->query($query);
	}
	protected function insert($data){
		return $this->db->insert($this->tablename,$data);
	}
	protected function update($set="",$where=""){
		$query="UPDATE `".$this->tablename."` SET ".$set;
		if($where!="")
			$query=$query." WHERE ".$where;
		$this->db->query($query);
	}
	
	//Query builder
	protected function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getNim() != NULL) $TEMP_QUERY.="s_nim='".$this->getNim()."',";
		if($this->getName() != NULL) $TEMP_QUERY.="s_name='".$this->getName()."',";
		if($this->getPassword() != NULL) $TEMP_QUERY.="s_password='".$this->getPassword()."',";
		if($this->getEmail() != NULL) $TEMP_QUERY.="s_email='".$this->getEmail()."',";
		if($this->getStatus() != NULL) $TEMP_QUERY.="s_statue='".$this->getStatus()."',";
		if($this->getPeminatan() != NULL) $TEMP_QUERY.="s_p='".$this->getPeminatan()."',";
		if($this->getNohp() != NULL) $TEMP_QUERY.="s_nohp='".$this->getNohp()."',";
		if($this->getAktifTahun() != NULL) $TEMP_QUERY.="s_active_year='".$this->getAktifTahun()."',";
		if($this->getNamaOrtu() != NULL) $TEMP_QUERY.="s_name_parent='".$this->getNamaOrtu()."',";
		if($this->getNoHpOrtu() != NULL) $TEMP_QUERY.="s_nohp_parent='".$this->getNoHpOrtu()."',";
		if($this->getSemester() != NULL) $TEMP_QUERY.="s_semester='".$this->getSemester()."',";
		if($this->getOpenForm() != NULL) $TEMP_QUERY.="s_new_form='".$this->getOpenForm()."',";
		if($this->getForceRegLama() != NULL) $TEMP_QUERY.="s_force_registrasi_lama='".$this->getForceRegLama()."',";
		if($this->getForceRegNew() != NULL) $TEMP_QUERY.="s_force_registrasi='".$this->getForceRegNew()."',";
		if($this->getSeminarTA1() != NULL) $TEMP_QUERY.="s_seminar_ta1='".$this->getSeminarTA1()."',";
		if($this->getSeminarTA2() != NULL) $TEMP_QUERY.="s_seminar_ta2='".$this->getSeminarTA2()."',";
		if($this->getFotoname() != NULL) $TEMP_QUERY.="s_foto_name='".$this->getFotoname()."',";
		if($this->getTranskripName() != NULL) $TEMP_QUERY.="s_transcript_name='".$this->getTranskripName()."',";
		if($this->getCodeCokie() != NULL) $TEMP_QUERY.="s_code_cookie='".$this->getCodeCokie()."',";
		if($this->getNipReview1() != NULL) $TEMP_QUERY.="s_nip_review_1='".$this->getNipReview1()."',";
		if($this->getNipReview2() != NULL) $TEMP_QUERY.="s_nip_review_2='".$this->getNipReview2()."',";
		if($this->getNipReview3() != NULL) $TEMP_QUERY.="s_nip_review_3='".$this->getNipReview3()."',";
		if($this->getForceSemTog() != NULL) $TEMP_QUERY.="s_force_seminar_together='".$this->getForceSemTog()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
	}
	//array Builder 
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getNim() != NULL) $TEMP_QUERY["s_nim"] = $this->getNim();
		if($this->getName() != NULL) $TEMP_QUERY["s_name"] = $this->getName();
		if($this->getPassword() != NULL) $TEMP_QUERY["s_password"] = $this->getPassword();
		if($this->getEmail() != NULL) $TEMP_QUERY["s_email"] = $this->getEmail();
		if($this->getStatus() != NULL) $TEMP_QUERY["s_statue"] = $this->getStatus();
		if($this->getPeminatan() != NULL) $TEMP_QUERY["s_p"] = $this->getPeminatan();
		if($this->getNohp() != NULL) $TEMP_QUERY["s_nohp"] = $this->getNohp();
		if($this->getAktifTahun() != NULL) $TEMP_QUERY["s_active_year"] = $this->getAktifTahun();
		if($this->getNamaOrtu() != NULL) $TEMP_QUERY["s_name_parent"] = $this->getNamaOrtu();
		if($this->getNoHpOrtu() != NULL) $TEMP_QUERY["s_nohp_parent"] = $this->getNoHpOrtu();
		if($this->getSemester() != NULL) $TEMP_QUERY["s_semester"] = $this->getSemester();
		if($this->getOpenForm() != NULL) $TEMP_QUERY["s_new_form"] = $this->getOpenForm();
		if($this->getForceRegNew() != NULL) $TEMP_QUERY["s_force_registrasi"] = $this->getForceRegNew();
		if($this->getForceRegLama() != NULL) $TEMP_QUERY["s_force_registrasi_lama"] = $this->getForceRegLama();
		if($this->getSeminarTA1() != NULL) $TEMP_QUERY["s_seminar_ta1"] = $this->getSeminarTA1();
		if($this->getSeminarTA2() != NULL) $TEMP_QUERY["s_seminar_ta2"] = $this->getSeminarTA2();
		if($this->getFotoname() != NULL) $TEMP_QUERY["s_foto_name"] = $this->getFotoname();
		if($this->getTranskripName() != NULL) $TEMP_QUERY["s_transcript_name"] = $this->getTranskripName();
		if($this->getCodeCokie() != NULL) $TEMP_QUERY["s_code_cookie"] = $this->getCodeCokie();
		if($this->getForceSemTog() != NULL) $TEMP_QUERY["s_force_seminar_together"] = $this->getForceSemTog();
		if($this->getNipReview1() != NULL) $TEMP_QUERY["s_nip_review_1"] = $this->getNipReview1();
		if($this->getNipReview2() != NULL) $TEMP_QUERY["s_nip_review_2"] = $this->getNipReview2();
		if($this->getNipReview3() != NULL) $TEMP_QUERY["s_nip_review_3"] = $this->getNipReview3();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
	//set Automa setting from array
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 's_nim' : $this->setNim($TEMP_ARRAY['s_nim']);break;
				case 's_name' : $this->setName($TEMP_ARRAY['s_name']);break;
				case 's_password' : $this->setPassword($TEMP_ARRAY['s_password']);break;
				case 's_email' : $this->setEmail($TEMP_ARRAY['s_email']);break;
				case 's_statue' : $this->setStatus($TEMP_ARRAY['s_statue']);break;
				case 's_p' : $this->setPeminatan($TEMP_ARRAY['s_p']);break;
				case 's_nohp' : $this->setNohp($TEMP_ARRAY['s_nohp']);break;
				case 's_active_year' : $this->setAktifTahun($TEMP_ARRAY['s_active_year']);break;
				case 's_name_parent' : $this->setNamaOrtu($TEMP_ARRAY['s_name_parent']);break;
				case 's_nohp_parent' : $this->setNoHpOrtu($TEMP_ARRAY['s_nohp_parent']);break;
				case 's_semester' : $this->setSemester($TEMP_ARRAY['s_semester']);break;
				case 's_new_form' : $this->setOpenForm($TEMP_ARRAY['s_new_form']);break;
				case 's_force_registrasi' : $this->setForceRegNew($TEMP_ARRAY['s_force_registrasi']);break;
				case 's_force_registrasi_lama' : $this->setForceRegLama($TEMP_ARRAY['s_force_registrasi_lama']);break;
				case 's_seminar_ta1' : $this->setSeminarTA1($TEMP_ARRAY['s_seminar_ta1']);break;
				case 's_seminar_ta2' : $this->setSeminarTA2($TEMP_ARRAY['s_seminar_ta2']);break;
				case 's_foto_name' : $this->setFotoname($TEMP_ARRAY['s_foto_name']);break;
				case 's_transcript_name' : $this->setTranskripName($TEMP_ARRAY['s_transcript_name']);break;
				case 's_code_cookie' : $this->setCodeCokie($TEMP_ARRAY['s_code_cookie']);break;
				case 's_nip_review_1' : $this->setNipReview1($TEMP_ARRAY['s_nip_review_1']);break;
				case 's_nip_review_2' : $this->setNipReview2($TEMP_ARRAY['s_nip_review_2']);break;
				case 's_nip_review_3' : $this->setNipReview3($TEMP_ARRAY['s_nip_review_3']);break;
				case 's_force_seminar_together' : $this->setForceSemTog($TEMP_ARRAY['s_force_seminar_together']);break;
			}
		}
	}
	//private
    private $nim; private $name; private $password;	private $email;	private $status; private $peminatan;
	private $nohp; private $aktifTahun; private $namaOrtu; private $noHpOrtu; private $semester; private $openForm;
	private $forceRegNew; private $forceRegLama; private $seminarTA1; private $seminarTA2; private $fotoname;
	private $transkripName;	private $codeCokie; private $nipReview1; private $nipReview2; private $nipReview3;
	private $forceSemTog; 
	
	private $tablename;

	//setter and getter    
	function getTablename() { return $this->tablename;   }
	function getNim() {            return $this->nim;        }
	function getName() {            return $this->name;        }
	function getPassword() {            return $this->password;        }
	function getEmail() {            return $this->email;        }
	function getStatus() {            return $this->status;        }
	function getPeminatan() {            return $this->peminatan;        }
	function getNohp() {            return $this->nohp;        }
	function getAktifTahun() {            return $this->aktifTahun;        }
	function getNamaOrtu() {            return $this->namaOrtu;        }
	function getNoHpOrtu() {            return $this->noHpOrtu;        }
	function getSemester() {            return $this->semester;        }
	function getOpenForm() {            return $this->openForm;        }
	function getForceRegNew() {            return $this->forceRegNew;        }
	function getForceRegLama() {            return $this->forceRegLama;        }
	function getSeminarTA1() {            return $this->seminarTA1;        }
	function getSeminarTA2() {            return $this->seminarTA2;        }
	function getFotoname() {            return $this->fotoname;        }
	function getTranskripName() {            return $this->transkripName;        }
	function getCodeCokie() {            return $this->codeCokie;        }
	function getNipReview1() {            return $this->nipReview1;        }
	function getNipReview2() {            return $this->nipReview2;        }
	function getNipReview3() {            return $this->nipReview3;        }
	function getForceSemTog() {            return $this->forceSemTog;        }
	function setTablename($tablename) {            $this->tablename = $tablename;        }
	function setNim($nim) {            $this->nim = $nim;        }
	function setName($name) {            $this->name = $name;        }
	function setPassword($password) {            $this->password = $password;        }
	function setEmail($email) {            $this->email = $email;        }
	function setStatus($status) {            $this->status = $status;        }
	function setPeminatan($peminatan) {            $this->peminatan = $peminatan;        }
	function setNohp($nohp) {            $this->nohp = $nohp;        }
	function setAktifTahun($aktifTahun) {            $this->aktifTahun = $aktifTahun;        }
	function setNamaOrtu($namaOrtu) {            $this->namaOrtu = $namaOrtu;        }
	function setNoHpOrtu($noHpOrtu) {            $this->noHpOrtu = $noHpOrtu;        }
	function setSemester($semester) {            $this->semester = $semester;        }
	function setOpenForm($openForm) {            $this->openForm = $openForm;        }
	function setForceRegNew($forceRegNew) {            $this->forceRegNew = $forceRegNew;        }
	function setForceRegLama($forceRegLama) {            $this->forceRegLama = $forceRegLama;        }
	function setSeminarTA1($seminarTA1) {            $this->seminarTA1 = $seminarTA1;        }
	function setSeminarTA2($seminarTA2) {            $this->seminarTA2 = $seminarTA2;        }
	function setFotoname($fotoname) {            $this->fotoname = $fotoname;        }
	function setTranskripName($transkripName) {            $this->transkripName = $transkripName;        }
	function setCodeCokie($codeCokie) {            $this->codeCokie = $codeCokie;        }
	function setNipReview1($nipReview1) {            $this->nipReview1 = $nipReview1;        }
	function setNipReview2($nipReview2) {            $this->nipReview2 = $nipReview2;        }
	function setNipReview3($nipReview3) {            $this->nipReview3 = $nipReview3;        }
	function setForceSemTog($forceSemTog) {            $this->forceSemTog = $forceSemTog;        }
}