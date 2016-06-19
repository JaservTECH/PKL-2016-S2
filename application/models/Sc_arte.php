<?php
	//query builder - Ok
	//arrayBuilder - Ok
	//automaSetContent - Ok
	//resetValue - Ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_arte extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_arte';
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
		if($this->getKode() != NULL) $TEMP_QUERY.="rte_rt='".$this->getKode()."',";
		if($this->getTanggal() != NULL) $TEMP_QUERY.="rte_tanggal='".$this->getTanggal()."',";
		if($this->getName() != NULL) $TEMP_QUERY.="rte_nama_acara='".$this->getName()."',";
		if($this->getPenanggungjawab() != NULL) $TEMP_QUERY.="rte_penanggung_jawab='".$this->getPenanggungjawab()."',";
		if($this->getRuang() != NULL) $TEMP_QUERY.="rte_ruang='".$this->getRuang()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
	}
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getKode() != NULL) $TEMP_QUERY["rte_rt"] = $this->getKode();
		if($this->getTanggal() != NULL) $TEMP_QUERY["rte_tanggal"] = $this->getTanggal();
		if($this->getName() != NULL) $TEMP_QUERY["rte_nama_acara"] = $this->getName();
		if($this->getPenanggungjawab() != NULL) $TEMP_QUERY["rte_penanggung_jawab"] = $this->getPenanggungjawab();
		if($this->getRuang() != NULL) $TEMP_QUERY["rte_ruang"] = $this->getRuang();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 'rte_rt' : $this->setKode($TEMP_ARRAY['rte_rt']);break;
				case 'rte_tanggal' : $this->setTanggal($TEMP_ARRAY['rte_tanggal']);break;
				case 'rte_nama_acara' : $this->setName($TEMP_ARRAY['rte_nama_acara']);break;
				case 'rte_penanggung_jawab' : $this->setPenanggungjawab($TEMP_ARRAY['rte_penanggung_jawab']);break;
				case 'rte_ruang' : $this->setRuang($TEMP_ARRAY['rte_ruang']);break;
			}
		}
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
    private $kode;
    private $tanggal;
    private $namaacara;
    private $penanggungjawab;
    private $ruang;
	function resetValue(){
		$this->setKode(NULL);
		$this->setTanggal(NULL);
		$this->setName(NULL);
		$this->setPenanggungjawab(NULL);
		$this->setRuang(NULL);
		
	}
    //get all data * for all 1 for ta 1and 2 for ta2
    public function getAllData($kode="*"){
		if($this->getTanggal() == NULL){
			if($kode == "*"){
				$this->TEMP_RESULT_ARRAY = $this->query("*")->result_array();
				return $this->neutralizedResultArray();
			}else if(intval($kode) == 1){
				$this->TEMP_RESULT_ARRAY = $this->query("*","rte_ruang=1")->result_array();
				return $this->neutralizedResultArray();
			}else {

				$this->TEMP_RESULT_ARRAY = $this->query("*","rte_ruang=2")->result_array();
				return $this->neutralizedResultArray();
			}
		}else{
			$this->load->helper('date');
			$TEMP_DATE = nice_date($this->getTanggal(),"Y-m-d");
			if($kode == "*"){
				$this->TEMP_RESULT_ARRAY = $this->query("*",'rte_tanggal like "'.$TEMP_DATE.'%"')->result_array();
				return $this->neutralizedResultArray();
			}else if(intval($kode) == 1){
				$this->TEMP_RESULT_ARRAY = $this->query("*",'rte_ruang=1 AND rte_tanggal like "'.$TEMP_DATE.'%"')->result_array();
				return $this->neutralizedResultArray();
			}else {
				$this->TEMP_RESULT_ARRAY = $this->query("*",'rte_ruang=2 AND rte_tanggal like "'.$TEMP_DATE.'%"')->result_array();
				return $this->neutralizedResultArray();
			}
		}
		
    }
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
	function getKode() {            return $this->kode;        }
	function getTanggal() {            return $this->tanggal;        }
	function getName() {            return $this->namaacara;        }
	function getPenanggungjawab() {            return $this->penanggungjawab;        }
	function getRuang() {            return $this->ruang;        }
	function setKode($kode) {            $this->kode = $kode;        }
	function setTanggal($tanggal) {            $this->tanggal = $tanggal;        }
	function setName($namaacara) {            $this->namaacara = $namaacara;        }
	function setPenanggungjawab($penanggungjawab) {            $this->penanggungjawab = $penanggungjawab;        }
	function setRuang($ruang) {            $this->ruang = $ruang;        }
}