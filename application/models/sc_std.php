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
		if($this->getKode() != NULL) $TEMP_QUERY.="s_rt='".$this->getKode()."',";
        if($this->getNim() != NULL) $TEMP_QUERY.="s_nim='".$this->getNim()."',";
        if($this->getNips() != NULL) $TEMP_QUERY.="s_nip_p_s='".$this->getNips()."',";
        if($this->getNipd() != NULL) $TEMP_QUERY.="s_nip_p_d='".$this->getNipd()."',";
        if($this->getNipt() != NULL) $TEMP_QUERY.="s_nip_p_t='".$this->getNipt()."',";
        if($this->getDocp() != NULL) $TEMP_QUERY.="s_doc_p_pengantar='".$this->getDocp()."',";
        if($this->getDocbta() != NULL) $TEMP_QUERY.="s_doc_p_b_ta='".$this->getDocbta()."',";
        if($this->getDocpta() != NULL) $TEMP_QUERY.="s_doc_p_p_ta='".$this->getDocpta()."',";
        if($this->getDocTranskrip() != NULL) $TEMP_QUERY.="s_doc_p_transkrip='".$this->getDocTranskrip()."',";
        if($this->getTanggal() != NULL) $TEMP_QUERY.="s_tanggal='".$this->getTanggal()."',";
        if($this->getDocppp() != NULL) $TEMP_QUERY.="s_doc_p_p_pengantar='".$this->getDocppp()."',";
        if($this->getStatus() != NULL) $TEMP_QUERY.="s_status='".$this->getStatus()."',";
        if($this->getRuang() != NULL) $TEMP_QUERY.="s_ruang='".$this->getRuang()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
	}
    //atribut
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
    //getter
    private function getKode(){$kode = $this->kode; return $kode;}
    private function getNim(){$nim = $this->nim; return $nim;}
    private function getNips(){$nips = $this->nips; return $nips;}
    private function getNipd(){$nipd = $this->nipd; return $nipd;}
    private function getNipt(){$nipt = $this->nipt; return $nipt;}
    private function getDocp(){$docp = $this->docp; return $docp;}
    private function getDocbta(){$docbta = $this->docbta; return $docbta;}
    private function getDocpta(){$docpta = $this->docpta; return $docpta;}
    private function getDocTranskrip(){$doctranskrip = $this->doctranskrip; return $doctranskrip;}
    private function getTanggal(){$tanggal = $this->tanggal; return $tanggal;}
    private function getDocppp(){$docppp = $this->docppp; return $docppp;}
    private function getStatus(){$status = $this->status; return $status;}
    private function getRuang(){$ruang = $this->ruang; return $ruang;}
    //setter
    private function setKode($kode){$this->kode = $kode;}
    private function setNim($nim){$this->nim = $nim;}
    private function setNips($nips){$this->nips = $nips;}
    private function setNipd($nipd){$this->nipd = $nipd;}
    private function setNipt($nipt){$this->nipt = $nipt;}
    private function setDocp($docp){$this->docp = $docp;}
    private function setDocbta($docbta){$this->docbta = $docbta;}
    private function setDocpta($docpta){$this->docpta = $docpta;}
    private function setDocTranskrip($doctranskrip){$this->doctranskrip = $doctranskrip;}
    private function setTanggal($tanggal){$this->tanggal = $tanggal;}
    private function setDocppp($docppp){$this->docppp = $docppp;}
    private function setStatus($status){$this->status = $status;}
    private function setRuang($ruang){$this->ruang = $ruang;}
    
	
}