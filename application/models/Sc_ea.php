<?php
	//query builder - Ok
	//arrayBuilder - Ok
	//automaSetContent - Ok
	//resetValue - Ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_ea extends CI_Model {
	
	
	//getAktiveEventRegistrasi
	public function getEventActiveRegister(){
		$TEMP_ARRAY = $this->query("*","e_status=1 AND e_event=1")->row_array();
		$this->automaSetContent($TEMP_ARRAY);
	}
	public function setUpdateEventActiveRegister(){
		if($this->queryBuilder() == "")
			return false;
		if($this->update($this->queryBuilder(),"e_status=1 AND e_event=1"))
			return true;
		else
			return false;
	}
	public function setNewEventActiveRegister(){
		if(count($this->arrayBuilder()) <=0)
			return false;
		if($this->sc_ea->insert($this->arrayBuilder()))
			return true;
		else
			return false;
	}
	public function setUpdateEventKoordinator($TEMP_ID=""){
		if($id == "")
			return false;
		if($this->queryBuilder() == "")
			return false;
		if($this->update($this->queryBuilder(),"e_id=".$TEMP_ID." AND e_event=3"))
			return true;
		else
			return false;
	}
	public function setNewEventKoordinator(){
		if(count($this->arrayBuilder()) <= 0)
			return false;
		
		if($this->insert($this->arrayBuilder()))
			return true;
		else
			return false;
	}
	//
	public function resetValue(){
		$this->setId(NULL);
		$this->setYear(NULL);
		$this->setSemester(NULL);
		$this->setStatus(NULL);
		$this->setStart(NULL);
		$this->setEnd(NULL);
		$this->setCategory(NULL);
		$this->setJudul(NULL);
		$this->setIsi(NULL);
	}
	//protected
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 'e_id' : $this->setId($TEMP_ARRAY['e_id']);break;
				case 'e_year' : $this->setYear($TEMP_ARRAY['e_year']);break;
				case 'e_semester' : $this->setSemester($TEMP_ARRAY['e_semester']);break;
				case 'e_status' : $this->setStatus($TEMP_ARRAY['e_status']);break;
				case 'e_start' : $this->setStart($TEMP_ARRAY['e_start']);break;
				case 'e_end' : $this->setEnd($TEMP_ARRAY['e_end']);break;
				case 'e_event' : $this->setCategory($TEMP_ARRAY['e_event']);break;
				case 'e_title' : $this->setJudul($TEMP_ARRAY['e_title']);break;
				case 'e_summary' : $this->setIsi($TEMP_ARRAY['e_summary']);break;
			}
		}
	}
	protected function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getId() != NULL) $TEMP_QUERY.="e_id='".$this->getId()."',";
		if($this->getYear() != NULL) $TEMP_QUERY.="e_year='".$this->getYear()."',";
		if($this->getSemester() != NULL) $TEMP_QUERY.="e_semester='".$this->getSemester()."',";
		if($this->getStatus() != NULL) $TEMP_QUERY.="e_status='".$this->getStatus()."',";
		if($this->getStart() != NULL) $TEMP_QUERY.="e_start='".$this->getStart()."',";
		if($this->getEnd() != NULL) $TEMP_QUERY.="e_end='".$this->getEnd()."',";
		if($this->getCategory() != NULL) $TEMP_QUERY.="e_event='".$this->getCategory()."',";
		if($this->getJudul() != NULL) $TEMP_QUERY.="e_title='".$this->getJudul()."',";
		if($this->getIsi() != NULL) $TEMP_QUERY.="e_summary='".$this->getIsi()."',";
		return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
	}
	protected function arrayBuilder(){
		if($this->getId() != NULL) $TEMP_QUERY["e_id"] = $this->getId();
		if($this->getYear() != NULL) $TEMP_QUERY["e_year"]=$this->getYear();
		if($this->getSemester() != NULL) $TEMP_QUERY[e_semester] = $this->getSemester();
		if($this->getStatus() != NULL) $TEMP_QUERY["e_status"] = $this->getStatus();
		if($this->getStart() != NULL) $TEMP_QUERY["e_start"] = $this->getStart();
		if($this->getEnd() != NULL) $TEMP_QUERY["e_end"] = $this->getEnd();
		if($this->getCategory() != NULL) $TEMP_QUERY["e_event"] = $this->getCategory();
		if($this->getJudul() != NULL) $TEMP_QUERY["e_title"] = $this->getJudul();
		if($this->getIsi() != NULL) $TEMP_QUERY["e_summary"] = $this->getIsi();
		return $TEMP_QUERY;
	}
	//private
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//protected
	public function now(){
		if($this->codeAkademik[0]){
			return ("".$this->codeAkademik[1]['y'].$this->codeAkademik[1]['s']);
		}else{
			return null;
		}
	}
	public function previous($data=1){
		if($this->codeAkademik[0]){
			$a=intval($data/2);
			$b=intval($data%2);
			if(intval($this->codeAkademik[1]['s'])-$b ==0){
				$c=2;
			}else{
				$c=intval($this->codeAkademik[1]['s'])-$b;
			}
			return ("".(intval($this->codeAkademik[1]['y'])-$a)."".$c);
		}else{
			return null;
		}
	}
	//code
	public function next($data=1){
		if($this->codeAkademik[0]){
			$a=intval($data/2);
			$b=intval($data%2);
			$d=intval($this->codeAkademik[1]['y'])+$a;
			if(intval($this->codeAkademik[1]['s'])+$b > 2){
				$c=1;
				$d+=1;
			}else{
				$c=2;
			}
			return ("".$d."".$c);
		}else{
			return null;
		}
	}
	public function getCodeRegistrasiAkademik(){
		$temp = $this->query("e_year as y, e_semester as s","e_event=1 AND e_status=1")->row_array();
		$this->codeAkademik[0] = true;
		$this->codeAkademik[1] = $temp;
		return $this;
	}
	public function getCodeSeminarAkademik(){
		$temp = $this->query("e_year as y, e_semester as s","e_event=2 AND e_status=1")->row_array();
		$this->codeAkademik[0] = true;
		$this->codeAkademik[1] = $temp;
		return $this;
	}
	//code
	public function getStatusTimeInActiveRegistrasi($data='2000-05-3'){
		$temp = $this->query("e_start as s, e_end as e","e_event=1 AND e_status=1")->row_array();
		$this->load->helper('date');
		$this->stiar[0] = true;
		$this->stiar[1] = nice_date($data,"Y-m-d");
		$this->stiar[2] = $temp;
		return $this;
	}
	public function isEnd(){
		if(!$this->stiar[0]){
			return false;
		}
		if(intval(nice_date($this->stiar[1],"Y"))>intval(nice_date($this->stiar[2]['e'],"Y")))
			return true;
		if(intval(nice_date($this->stiar[1],"m"))>intval(nice_date($this->stiar[2]['e'],"m")))
			return true;
		if(intval(nice_date($this->stiar[1],"d"))>intval(nice_date($this->stiar[2]['e'],"d")))
			return true;
		return false;
	}
	public function isIn(){
		if(!$this->stiar[0]){
			return false;
		}
		if((!$this->isEnd()) && (!$this->isSoon()))
			return true;
		return false;
	}
	public function isSoon(){
		if(!$this->stiar[0]){
			return false;
		}
		$code=0;
		if(intval(nice_date($this->stiar[1],"Y")) <= intval(nice_date($this->stiar[2]['s'],"Y")))
			$code+=1;
		if(intval(nice_date($this->stiar[1],"m")) <= intval(nice_date($this->stiar[2]['s'],"m")))
		{
			$code+=1;
		}
		if(intval(nice_date($this->stiar[1],"d")) < intval(nice_date($this->stiar[2]['s'],"d")))
		{
			if($code == 2)
				return true;
		}
		return false;
	}
	//public
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_ea';
		$this->codeAkademik=array(false,null);
		$this->stiar=array(false,null);
	}
	public function query($select='*',$where=""){
		$query="SELECT ".$select." FROM ".$this->tablename;
		if($where!="")
			$query=$query." WHERE ".$where;
		return $this->db->query($query);
	}
	public function insert($data){
		return $this->db->insert($this->tablename,$data);
	}
	public function update($set="",$where=""){
		$query="UPDATE `".$this->tablename."` SET ".$set;
		if($where!="")
			$query=$query." WHERE ".$where;
		$this->db->query($query);
	}
	
	
	
	//public realease
	public function getIsRegisterTime($data){
		if(!$this->isMahasiswaKeyAllowed())
			return false;
		$this->getStatusTimeInActiveRegistrasi($data)->isIn();
	}
	
	public function getDataRegistrasiAktifNow(){
		if(!$this->isKoordinatorKeyAllowed())
			return false;
		if(intval(DATE("m")) > 6){
			$y = intval(date("Y"));
			$s = 1;
		}else {
			$y = intval(date("Y"))-1;
			$s = 2;
		}
		return $this->sc_ea->query("*","e_year=".$y." AND e_semester=".$s." AND e_status=1 AND e_event=1")->row_array();
	}
	//end code
	//end code
	//private
	private $tablename;
	private $codeAkademik;
	private $stiar;
	private $keyMahasiswa;
	private $keyKoordinator;
	private $keyPublic;
	//stucture table
	private $id;
	private $year;
	private $semester;
	private $status;
	private $start;
	private $end;
	private $category;
	private $judul;
	private $isi;
	//standard control
	//setter
	public function setId($id){$this->id = $id;}
	public function setYear($year){$this->year = $year;}
	public function setSemester($semester){$this->semester = $semester;}
	public function setStatus($status){$this->status = $status;}
	public function setStart($start){$this->start = $start;}
	public function setEnd($end){$this->end = $end;}
	public function setCategory($category){$this->category = $category;}
	public function setJudul($judul){$this->judul = $judul;}
	public function setIsi($isi){$this->isi = $isi;}
	//getter
	public function getId(){$id = $this->id; return $id;}
	public function getYear(){$year = $this->year; return $year;}
	public function getSemester(){$this->semester = $semester;}
	public function getStatus(){$status = $this->status; return $status;}
	public function getStart(){$start = $this->start; return $start;}
	public function getEnd(){$end = $this->end; return $end;}
	public function getCategory(){$category = $this->category; return $category;}
	public function getJudul(){$judul = $this->judul; return  $judul;}
	public function getIsi(){$isi = $this->isi; return $isi;}
}