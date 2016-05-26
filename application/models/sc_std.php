<?php
//query builder - Ok
	//arrayBuilder - Ok
	//automaSetContent - Ok
	//resetValue - Ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_sm_interest extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_sm_interest';
		$this->TEMP_RESULT_ARRAY = null;
		$this->TEMP_INDEX_RESULT_ARRAY = null;
		$this->resetValue();
	}
	protected function query($select='*',$where=""){$query="SELECT ".$select." FROM ".$this->tablename;	if($where!="")	$query=$query." WHERE ".$where;	return $this->db->query($query);}
	function getAllData(){
		$this->TEMP_RESULT_ARRAY = $this->sc_sm_interest->query("*")->result_array();
		$this->TEMP_INDEX_RESULT_ARRAY = 0;
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
	//kode standard
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 'si_id' : $this->setId($TEMP_ARRAY['si_id']);break;
				case 'si_name' : $this->setName($TEMP_ARRAY['si_name']);break;
			}
		}
		$this->setId($TEMP_ARRAY['si_id']);
		$this->setName($TEMP_ARRAY['si_name']);
	}
	protected function resetValue(){
		$this->setId(null);
		$this->setName(null);
	}
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getId() != NULL) $TEMP_QUERY["si_id"] = $this->getId();
		if($this->getName() != NULL) $TEMP_QUERY["si_name"] = $this->getName();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
	protected function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getId() != NULL) $TEMP_QUERY.="si_id='".$this->getId()."',";
		if($this->getName() != NULL) $TEMP_QUERY.="si_name='".$this->getName()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
	}
	private $kode;
	private $nim;
    private $nips;
    private $nipd;
    private $nipt;
    private $docp;
    private $docbta;
    private $docpta;
    private $doctranskrip;
    private $tanggal;
    private $docppp;
    private $status;
    private $ruang;
    
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getKode(){$kode = $this->kode; return $kode;}
    
    private function setKode($kode){$this->kode = $kode;}
	
}