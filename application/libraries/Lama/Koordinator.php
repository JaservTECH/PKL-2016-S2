<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once ("Aktor.php");
class Koordinator extends Aktor{
	function __construct() {
		parent::__construct();
		$this->setLibrary('session');
		$this->setLibrary('inputjaservfilter');
		$this->setHelper('url');
		$this->setModel("sc_ea");
		$this->setModel("sc_sk");
		$this->setNewDataEncrypt("JaservTech.Koordinator.Public.Control.Open");
		
		//$this->load->library('session');
		//$this->load->model("sc_ea");
		//$this->setNewDataEncrypt("JaservTech.Koordinator.Public.Control.Open");
	}
	/*
	public function getIsRegisterTime($data='2000-05-3'){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		return $this->sc_ea->getStatusTimeInActiveRegistrasi($data)->isIn();
	}
	*/
	public function setAktifAkademikRegistrasi($start,$end,$title,$summary){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		$temp = $this->sc_ea->query("*","e_status=1 AND e_event=1")->row_array();
		if(intval(DATE("m")) > 6){
			$y = intval(date("Y"));
			$s = 1;
		}else {
			$y = intval(date("Y"))-1;
			$s = 2;
		}
		if(count($temp) > 0){
			if((intval($temp['e_year']) == $y) && (intval($temp['e_semester']) == $s)){
				$this->sc_ea->update("
					e_start='".$start."',
					e_end='".$end."',
					e_title='".$title."',
					e_summary='".$summary."'"
					,"e_status=1 AND e_event=1");	
			}else{
				$this->sc_ea->update("
						e_status='2'"
					,"e_status=1 AND e_event=1");	
				$this->sc_ea->insert(array(
						'e_year' => $y,
						'e_semester' => $s,
						'e_status' => "1",
						'e_event' => "1",
						'e_start' => $start,
						'e_end' => $end,
						'e_title' => $title,
						'e_summary' => $summary
				));
			}
		}else{
			$this->sc_ea->insert(array(
					'e_year' => $y,
					'e_semester' => $s,
					'e_status' => "1",
					'e_event' => "1",
					'e_start' => $start,
					'e_end' => $end,
					'e_title' => $title,
					'e_summary' => $summary
			));
		}
		return $this->setCategoryPrintMessage(0, true, "Success, input data");
	}
	public function setAktifAkademikEvent($start,$end,$title,$summary,$id){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
			if(intval(DATE("m")) > 6){
				$y = intval(date("Y"));
				$s = 1;
			}else {
				$y = intval(date("Y"))-1;
				$s = 2;
			}
			$this->sc_ea->update(
					"e_start='".$start."',".
					"e_end='".$end."',".
					"e_title='".$title."',".
					"e_summary='".$summary."'"
					,"e_id=".$id." AND e_event=3");
			return $this->setCategoryPrintMessage(0, true, "Success, input data");
	}
	public function setNewAktifAkademikEvent($start,$end,$title,$summary){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
			if(intval(DATE("m")) > 6){
				$y = intval(date("Y"));
				$s = 1;
			}else {
				$y = intval(date("Y"))-1;
				$s = 2;
			}
			$this->sc_ea->insert(array(
					'e_year' => $y,
					'e_semester' => $s,
					'e_start' => $start,
					'e_end' =>$end,
					'e_title' => $title,
					'e_summary' => $summary,
					'e_status' => '1',
					'e_event' => '3'
			));
			return $this->setCategoryPrintMessage(0, true, "Success, input data");
	}
	public function getFullDataRegistrasi($year,$semester){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		return $this->sc_ea->query("*","e_year=".$year." AND e_semester=".$semester." AND e_event=1")->row_array();
	}
	public function getFullDataRegistrasiNonDefault($id){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		return $this->sc_ea->query("*","e_id=".$id." AND e_event=3")->row_array();
	}
	
	public function getListEventkoordinator($key){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
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
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		return $this->sc_ea->query("*","e_event=1 order by e_id desc")->result_array();
	}
	public function getCodeRegisterAktif(){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		return $this->sc_ea->getCodeRegistrasiAkademik();
		
	}
	public function getCheckKodeUsername($value="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
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
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputjaservfilter->titleFiltering($value);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	public function getCheckSummary($value="",$cat){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputjaservfilter->textFiltering($value);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	public function getCheckPassword($value="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
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
			return $this->setCategoryPrintMessage(1, false, "Anda melakukan debugging terhadap username");
		if($password == "")
			return $this->setCategoryPrintMessage(1, false, "Anda melakukan debugging teerhadap password");
		$this->sc_sk->query("*","s_kode='".$username."' AND s_password='".$password."'")->row_array();
		if(!$this->getCheckKodeUsername($username,1)[0])
			return $this->setCategoryPrintMessage(1,false,"Anda melakukan debugging");
		if(!$this->getCheckPassword($password,1)[0])
			return $this->setCategoryPrintMessage(1,false,"Anda melakukan debugging");
		$temp = $this->sc_sk->query("*","s_kode='".$username."' AND s_password='".$password."'")->row_array();
		if(count($temp)<=0)
			return $this->setCategoryPrintMessage(1, false, "Kombinasi username dan password tidak cocok");
		if($temp['s_kode'] != $username)
			return $this->setCategoryPrintMessage(1, false, "Username tidak cocok");
		if($temp['s_password'] != $password)
			return $this->setCategoryPrintMessage(1, false, "Password tiidak cocok");
		$this->session->set_userdata("nama","koordinator");
		$this->session->set_userdata("kode",$this->encrypt("koordinator"));
		if($this->getStatusLoginKoordinator()){
			return $this->setCategoryPrintMessage(1,true, "Controlroom.aspx");
		}else
			return $this->setCategoryPrintMessage(1,false, "Terjadi kesalahan saat proses login");
	}
	private function encrypt($string=""){
		return sha1(md5($string."jaservFilter"));
	}
	public function setStatusLogOutKoordinator(){
		
	}
}