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
	//public function
	public function getDataTabelOnThisDay(){
		$this->load->helper('date');
		if($this->getTanggal() == NULL)
			return false;
		$TEMP_DATE = nice_date($this->getTanggal(),"Y-m-d");
		if($this->getKode() == NULL){
			$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal",'s_tanggal like "'.$TEMP_DATE.'%"')->result_array();
		}else{
			$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal",'s_rt="'.$this->getKode().'" AND s_tanggal like "'.$TEMP_DATE.'%"')->result_array();
		}
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
	public function resetValue(){
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
    public function getKode(){$kode = $this->kode; return $kode;}
    public function getNim(){$nim = $this->nim; return $nim;}
    public function getNips(){$nips = $this->nips; return $nips;}
    public function getNipd(){$nipd = $this->nipd; return $nipd;}
    public function getNipt(){$nipt = $this->nipt; return $nipt;}
    public function getDocp(){$docp = $this->docp; return $docp;}
    public function getDocbta(){$docbta = $this->docbta; return $docbta;}
    public function getDocpta(){$docpta = $this->docpta; return $docpta;}
    public function getDocTranskrip(){$doctranskrip = $this->doctranskrip; return $doctranskrip;}
    public function getTanggal(){$tanggal = $this->tanggal; return $tanggal;}
    public function getDocppp(){$docppp = $this->docppp; return $docppp;}
    public function getStatus(){$status = $this->status; return $status;}
    public function getRuang(){$ruang = $this->ruang; return $ruang;}
    //setter
    public function setKode($kode){$this->kode = $kode;}
    public function setNim($nim){$this->nim = $nim;}
    public function setNips($nips){$this->nips = $nips;}
    public function setNipd($nipd){$this->nipd = $nipd;}
    public function setNipt($nipt){$this->nipt = $nipt;}
    public function setDocp($docp){$this->docp = $docp;}
    public function setDocbta($docbta){$this->docbta = $docbta;}
    public function setDocpta($docpta){$this->docpta = $docpta;}
    public function setDocTranskrip($doctranskrip){$this->doctranskrip = $doctranskrip;}
    public function setTanggal($tanggal){$this->tanggal = $tanggal;}
    public function setDocppp($docppp){$this->docppp = $docppp;}
    public function setStatus($status){$this->status = $status;}
    public function setRuang($ruang){$this->ruang = $ruang;}
    
	
}