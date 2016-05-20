<?php
	//query builder - Ok
	//arrayBuilder - Ok
	//automaSetContent - Ok
	//resetValue - Ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_lms extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_lms';
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
	protected function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getNim() != NULL) $TEMP_QUERY.="l_nim='".$this->getNim()."',";
		if($this->getTanggal() != NULL) $TEMP_QUERY.="l_date='".$this->getTanggal()."',";
		if($this->getEvent() != NULL) $TEMP_QUERY.="l_event='".$this->getEvent()."',";
		if($this->getKoor() != NULL) $TEMP_QUERY.="l_koor='".$this->getKoor()."',";
		if($this->getMahasiswa() != NULL) $TEMP_QUERY.="l_mahasiswa='".$this->getMahasiswa()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
	}
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getNim() != NULL) $TEMP_QUERY["l_nim"] = $this->getNim();
		if($this->getTanggal() != NULL) $TEMP_QUERY["l_date"] = $this->getTanggal();
		if($this->getEvent() != NULL) $TEMP_QUERY["l_event"] = $this->getEvent();
		if($this->getKoor() != NULL) $TEMP_QUERY["l_koor"] = $this->getKoor();
		if($this->getMahasiswa() != NULL) $TEMP_QUERY["l_mahasiswa"] = $this->getMahasiswa();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 'l_nim' : $this->setNim($TEMP_ARRAY['l_nim']);break;
				case 'l_date' : $this->setTanggal($TEMP_ARRAY['l_date']);break;
				case 'l_event' : $this->setEvent($TEMP_ARRAY['l_event']);break;
				case 'l_koor' : $this->setKoor($TEMP_ARRAY['l_koor']);break;
				case 'l_mahasiswa' : $this->setMahasiswa($TEMP_ARRAY['l_mahasiswa']);break;
			}
		}
	}
	
	public function getNextCursor(){
		if(is_array($TEMP_RESULT_ARRAY)){
			if(array_key_exists($this->TEMP_INDEX_RESULT_ARRAY,$this->TEMP_RESULT_ARRAY)){
				$this->automaSetContent($this->TEMP_RESULT_ARRAY($this->TEMP_INDEX_RESULT_ARRAY));
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
	private $nim; private $tanggal; private $event; private $koor; private $mahasiswa;
	function resetValue(){
		$this->setNim(NULL);
		$this->setTanggal(NULL);
		$this->setEvent(NULL);
		$this->setKoor(NULL);
		$this->setMahasiswa(NULL);
		
	}
	function getNim() {            return $this->nim;        }
	function getTanggal() {            return $this->tanggal;        }
	function getEvent() {            return $this->event;        }
	function getKoor() {            return $this->koor;        }
	function getMahasiswa() {            return $this->mahasiswa;        }
	function setNim($nim) {            $this->nim = $nim;        }
	function setTanggal($tanggal) {            $this->tanggal = $tanggal;        }
	function setEvent($event) {            $this->event = $event;        }
	function setKoor($koor) {            $this->koor = $koor;        }
	function setMahasiswa($mahasiswa) {            $this->mahasiswa = $mahasiswa;        }
	function addNew(){
		return $this->insert(array(
				'l_nim' => $this->getNim(),
				'l_date' => $this->getTanggal(),
				'l_event' => $this->getEvent()
		));
	}
}