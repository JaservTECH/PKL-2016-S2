<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once ("Aktor.php");
class Koordinator extends Aktor{
	//constructor - valid
	function __construct() {
		parent::__construct();
		$this->setLibrary('session');
		$this->setLibrary('inputjaservfilter');
		$this->setHelper('url');
		$this->setModel("sc_ea");
		$this->setModel("sc_sk");
	}
	//event registrasi control - valid 
	public function setAktifAkademikRegistrasi($TEMP_START,$TEMP_END,$TEMP_TITLE,$TEMP_SUMMARY){
		$this->sc_ea->getEventActiveRegister();
		if(intval(DATE("m")) > 6){
			$YEAR = intval(date("Y"));
			$SEMESTER = 1;
		}else {
			$YEAR = intval(date("Y"))-1;
			$SEMESTER = 2;
		}
		if($this->sc_ea->getId() != NULL){
			if((intval($this->sc_ea->getYear()) == $YEAR) && (intval($this->sc_ea->getSemester()) == $SEMESTER)){
				$this->sc_ea->resetValue();
				$this->sc_ea->setStart($TEMP_START);
				$this->sc_ea->setEnd($TEMP_END);
				$this->sc_ea->setJudul($TEMP_TITLE);
				$this->sc_ea->setIsi($TEMP_SUMMARY);	
				if($this->sc_ea->setUpdateEventActiveRegister())
					return $this->setCategoryPrintMessage(0, TRUE, "Success, input data");
				else
					return $this->setCategoryPrintMessage(0, FALSE, "Gagal, input data");
					
			}else{
				$this->sc_ea->resetValue();
				$this->sc_ea->setStatus(2);
				if($this->sc_ea->setUpdateEventActiveRegister()){
					$this->sc_ea->resetValue();
					$this->sc_ea->setYear($YEAR);
					$this->sc_ea->setSemester($SEMESTER);
					$this->sc_ea->setStart($TEMP_START);
					$this->sc_ea->setEnd($TEMP_END);
					$this->sc_ea->setStatus("1");
					$this->sc_ea->setCategory("1");
					$this->sc_ea->setIsi($TEMP_SUMMARY);
					$this->sc_ea->setJudul($TEMP_TITLE);
					if($this->sc_ea->setNewEventActiveRegister())
						return $this->setCategoryPrintMessage(0, TRUE, "Success, input data");
					else
						return $this->setCategoryPrintMessage(0, FALSE, "Gagal, input data");
				}else
					return $this->setCategoryPrintMessage(0, FALSE, "Gagal, input data");
			}
		}else{
			$this->sc_ea->resetValue();
			$this->sc_ea->setYear($YEAR);
			$this->sc_ea->setSemester($SEMESTER);
			$this->sc_ea->setStart($TEMP_START);
			$this->sc_ea->setEnd($TEMP_END);
			$this->sc_ea->setStatus("1");
			$this->sc_ea->setCategory("1");
			$this->sc_ea->setIsi($TEMP_SUMMARY);
			$this->sc_ea->setJudul($TEMP_TITLE);
			if($this->sc_ea->setNewEventActiveRegister())
				return $this->setCategoryPrintMessage(0, TRUE, "Success, input data");
			else
				return $this->setCategoryPrintMessage(0, FALSE, "Gagal, input data");
		}
	}
	public function setAktifAkademikEvent($TEMP_START,$TEMP_END,$TEMP_TITLE,$TEMP_SUMMARY,$TEMP_ID){
		$this->sc_ea->resetValue();
		$this->sc_ea->setStart($TEMP_START);
		$this->sc_ea->setEnd($TEMP_END);
		$this->sc_ea->setJudul($TEMP_TITLE);
		$this->sc_ea->setIsi($TEMP_SUMMARY);
		if($this->sc_ea->setUpdateEventKoordinator($TEMP_ID))
			return $this->setCategoryPrintMessage(0, TRUE, "Success, input data");
		else
			return $this->setCategoryPrintMessage(0, FALSE, "Gagal, input data");
	}
	public function setNewAktifAkademikEvent($TEMP_START,$TEMP_END,$TEMP_TITLE,$TEMP_SUMMARY){
		if(intval(DATE("m")) > 6){
			$YEAR = intval(date("Y"));
			$SEMESTER = 1;
		}else {
			$YEAR = intval(date("Y"))-1;
			$SEMESTER = 2;
		}
		$this->sc_ea->resetValue();
		$this->sc_ea->setYear($YEAR);
		$this->sc_ea->setSemester($SEMESTER);
		$this->sc_ea->setStart($TEMP_START);
		$this->sc_ea->setEnd($TEMP_END);
		$this->sc_ea->setJudul($TEMP_TITLE);
		$this->sc_ea->setIsi($TEMP_SUMMARY);
		$this->sc_ea->setStatus("1");
		$this->sc_ea->setCategory("3");
		if($this->sc_ea->setNewEventKoordinator())
			return $this->setCategoryPrintMessage(0, TRUE, "Success, input data");
		else
			return $this->setCategoryPrintMessage(0, FALSE, "Gagal, input data");
	}
	//cursor edit in here <<<<<<<<<<<<<---------------------
	public function getFullDataRegistrasi($year,$semester){
		return $this->sc_ea->query("*","e_year=".$year." AND e_semester=".$semester." AND e_event=1")->row_array();
		$this->sc_ea->resetValue();
		$this->sc_ea->setYear();
		$this->sc_ea->setSemester();
	}
	public function getFullDataRegistrasiNonDefault($id){
		return $this->sc_ea->query("*","e_id=".$id." AND e_event=3")->row_array();
	}
	
	public function getListEventkoordinator($key){
		$temp = $this->sc_ea->query("*","e_event=3 AND e_status=1")->result_array();
		if(count($temp) > 0){
			$this->setHelper('date');
			foreach ($temp as $value){
				$error = 0;
				if(intval(nice_date($value['e_end'],"Y")) < intval(DATE("Y")))
					$error += 1;
				if(intval(nice_date($value['e_end'],"m")) < intval(DATE("m")))
					$error += 1;
				else{
					if(intval(nice_date($value['e_end'],"m")) == intval(DATE("m")))
						if(intval(nice_date($value['e_end'],"d")) < intval(DATE("d")))
							$error += 1;
				}
				if($error > 0){
					$this->sc_ea->update(
							"`e_status`='2'"
							,"e_id=".$value['e_id']."");
				}
				
			}
		}
		if($key == '*'){
			return $this->sc_ea->query("*","e_event=3 order by e_year desc, e_semester desc")->result_array();	
		}else{
			return $this->sc_ea->query("*","e_event=3 AND e_year=".$key." order by e_year desc,e_semester desc")->result_array();
		}
	}
	public function getListEventAcademic(){
		return $this->sc_ea->query("*","e_event=1 order by e_id desc")->result_array();
	}
	public function getCodeRegisterAktif(){
		return $this->sc_ea->getCodeRegistrasiAkademik();
		
	}
	public function getCheckKodeUsername($value="",$cat=0){
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		if(!preg_match("/^[A-Z-]*$/",$value))
			return $this->setCategoryPrintMessage($cat,false,"username mengandung karakter yang tidak diizinkan");
		if(!strpos($value, "-"))
			return $this->setCategoryPrintMessage($cat, false, "Username tidak valid");
		if(!$this->inputjaservfilter->isContainAlphabetUpper($value))
			return $this->setCategoryPrintMessage($cat, false, "Username tidak valid");
		return $this->setCategoryPrintMessage($cat, true, "valid");
	}
	public function getCheckTitle($value="",$cat){
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputjaservfilter->titleFiltering($value);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	public function getCheckSummary($value="",$cat){
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputjaservfilter->textFiltering($value);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	public function getCheckPassword($value="",$cat=0){
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputjaservfilter->passwordFiltering($value);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
		
	}
	public function getStatusLoginKoordinator(){
		$error = 0;
		if(!$this->session->has_userdata('nama'))
			$error+=0;
		else{
			if($this->session->userdata('nama') != "koordinator")
				$error+=1;
		}
		if(!$this->session->has_userdata('kode'))
			$error+=1;
		else{
			if($this->session->userdata('kode') != $this->encrypt("koordinator"))
				$error+1;
		}
		if($error == 0)
			return true;
		else 
			return false;
	}

	public function setStatusLogOutKordinator(){
		if(!$this->getStatusLoginKoordinator())
			return false;
			$this->session->unset_userdata("nama");
			$this->session->unset_userdata("kode");
			return true;
	}
	public function setLoginKoordinator($username="",$password=""){
		if($this->getStatusLoginKoordinator()){
			redirect(base_url()."Controlroom/");
		}
		if($username == "")
			return $this->setCategoryPrintMessage(0, false, "Anda melakukan debugging terhadap username");
		if($password == "")
			return $this->setCategoryPrintMessage(0, false, "Anda melakukan debugging teerhadap password");
		$this->sc_sk->query("*","s_kode='".$username."' AND s_password='".$password."'")->row_array();
		if(!$this->getCheckKodeUsername($username,1)[0])
			return $this->setCategoryPrintMessage(0,false,"Anda melakukan debugging");
		if(!$this->getCheckPassword($password,1)[0])
			return $this->setCategoryPrintMessage(0,false,"Anda melakukan debugging");
		$temp = $this->sc_sk->query("*","s_kode='".$username."' AND s_password='".$password."'")->row_array();
		if(count($temp)<=0)
			return $this->setCategoryPrintMessage(0, false, "Kombinasi username dan password tidak cocok");
		if($temp['s_kode'] != $username)
			return $this->setCategoryPrintMessage(0, false, "Username tidak cocok");
		if($temp['s_password'] != $password)
			return $this->setCategoryPrintMessage(0, false, "Password tiidak cocok");
		$this->session->set_userdata("nama","koordinator");
		$this->session->set_userdata("kode",$this->encrypt("koordinator"));
		if($this->getStatusLoginKoordinator()){
			return $this->setCategoryPrintMessage(0,true, "Controlroom.aspx");
		}else
			return $this->setCategoryPrintMessage(0,false, "Terjadi kesalahan saat proses login");
	}
	private function encrypt($string=""){
		return sha1(md5($string."jaservFilter"));
	}
	public function setStatusLogOutKoordinator(){
		
	}
}