<?php
    //query builder - Ok
	//arrayBuilder - Ok
	//automaSetContent - Ok
	//resetValue - Ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_std extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_std';
		$this->TEMP_RESULT_ARRAY = null;
		$this->TEMP_INDEX_RESULT_ARRAY = null;
		$this->resetValue();
	}
    //protected
	protected function query($select='*',$where=""){$query="SELECT ".$select." FROM ".$this->tablename;	if($where!="")	$query=$query." WHERE ".$where;	return $this->db->query($query);}
	protected function insert($data){ return $this->db->insert($this->tablename,$data);}
	protected function update($set="",$where=""){$query="UPDATE `".$this->tablename."` SET ".$set;if($where!="")$query=$query." WHERE ".$where;	$this->db->query($query);}
    //-valid
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
	//kode standard - valid
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 's_rt' : $this->setKode($TEMP_ARRAY['s_rt']);break;
                case 's_nim' : $this->setNim($TEMP_ARRAY['s_nim']);break;
                case 's_nip_p_s' : $this->setNips($TEMP_ARRAY['s_nip_p_s']);break;
                case 's_nip_p_d' : $this->setNipd($TEMP_ARRAY['s_nip_p_d']);break;
                case 's_nip_p_t' : $this->setNipt($TEMP_ARRAY['s_nip_p_t']);break;
                case 's_doc_p_pengantar' : $this->setDocp($TEMP_ARRAY['s_doc_p_pengantar']);break;
                case 's_doc_p_b_ta' : $this->setDocbta($TEMP_ARRAY['s_doc_p_b_ta']);break;
                case 's_doc_p_p_ta' : $this->setDocpta($TEMP_ARRAY['s_doc_p_p_ta']);break;
                case 's_doc_p_transkrip' : $this->setDocTranskrip($TEMP_ARRAY['s_doc_p_transkrip']);break;
                case 's_tanggal' : $this->setTanggal($TEMP_ARRAY['s_tanggal']);break;
                case 's_doc_p_p_pengantar' : $this->setDocppp($TEMP_ARRAY['s_doc_p_p_pengantar']);break;
                case 's_status' : $this->setStatus($TEMP_ARRAY['s_status']);break;
                case 's_ruang' : $this->setRuang($TEMP_ARRAY['s_ruang']);break;
			}
		}
	}
    //-valid
	protected function resetValue(){
		$this->setKode(null);
		$this->setNim(null);
		$this->setNips(null);
		$this->setNipd(null);
		$this->setNipt(null);
		$this->setDocp(null);
		$this->setDocbta(null);
		$this->setDocpta(null);
		$this->setDocTranskrip(null);
		$this->setTanggal(null);
		$this->setDocppp(null);
		$this->setStatus(null);
		$this->setRuang(null);
	}
    // - valid
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getKode() != NULL) $TEMP_QUERY["s_rt"] = $this->getKode();
		if($this->getNim() != NULL) $TEMP_QUERY["s_nim"] = $this->getNim();
		if($this->getNips() != NULL) $TEMP_QUERY["s_nip_p_s"] = $this->getNips();
		if($this->getNipd() != NULL) $TEMP_QUERY["s_nip_p_d"] = $this->getNipd();
		if($this->getNipt() != NULL) $TEMP_QUERY["s_nip_p_t"] = $this->getNipt();
		if($this->getDocp() != NULL) $TEMP_QUERY["s_doc_p_pengantar"] = $this->getDocp();
		if($this->getDocbta() != NULL) $TEMP_QUERY["s_doc_p_b_ta"] = $this->getDocbta();
		if($this->getDocpta() != NULL) $TEMP_QUERY["s_doc_p_p_ta"] = $this->getDocpta();
		if($this->getDocTranskrip() != NULL) $TEMP_QUERY["s_doc_p_transkrip"] = $this->getDocTranskrip();
		if($this->getTanggal() != NULL) $TEMP_QUERY["s_tanggal"] = $this->getTanggal();
		if($this->getDocppp() != NULL) $TEMP_QUERY["s_doc_p_p_pengantar"] = $this->getDocppp();
		if($this->getStatus() != NULL) $TEMP_QUERY["s_status"] = $this->getStatus();
		if($this->getRuang() != NULL) $TEMP_QUERY["s_ruang"] = $this->getRuang();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
    // - valid
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