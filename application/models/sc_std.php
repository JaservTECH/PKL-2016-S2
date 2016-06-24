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
	public function getAllSeminarTAAktif(){
		if($this->getKode() == NULL)
		return false;
		if($this->getKategori() == NULL){
			$this->TEMP_RESULT_ARRAY = $this->query("*","s_status=1")->result_array();
			return $this->neutralizedResultArray();
		}else{
			$this->TEMP_RESULT_ARRAY = $this->query("*","s_status=1 AND s_category='".$this->getKategori()."'")->result_array();
			return $this->neutralizedResultArray();
		}
	}
	//public function
	private function partOfGetDataTableOnThisDay($string){
		$code="";
		$err=0;
		switch ("".$this->getDataProses()."") {
			case '1':
				$code="=1";
				break;
			case '2':
				$code="=2";
				break;
			case '3':
				$code="=3";
				break;
			case '11':
				$code="<>1";
				break;
			case '22':
				$code="<>2";
				break;
			case '33':
				$code="<>3";
				break;
			default:
				$err=1;
				break;
		}
		if($err == 1){
			return $this->failedResultAll();
		}
		//exit("0s_process_data".$code." AND ".$string);
		$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal","s_process_data".$code." AND ".$string)->result_array();
		return $this->neutralizedResultArray();
	}
	public function isRegisteredOnSeminar(){
		if($this->getKode() == null)
			return $this->failedResultAll();
		if($this->getNim() == null)
			return $this->failedResultAll();
		if($this->getKategori() == null){
			return $this->failedResultAll();
		}
		$TEMP_ARRAY = $this->query("*","s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."' AND s_status=1 AND s_category='".$this->getKategori()."'")->row_array();
		if(count($TEMP_ARRAY)>0) 
			return true;
		else
			return $this->failedResultAll();
	}
	public function getDataTabelOnThisDay(){
		$this->load->helper('date');
		if($this->getTanggal() == NULL)
			return $this->failedResultAll();
		$TEMP_DATE = nice_date($this->getTanggal(),"Y-m-d");
		if($this->getKode() == NULL){
			if($this->getKategori() == NULL){
				if($this->dataProcess() == NULL){
					$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal",'s_status=1 AND s_tanggal like "'.$TEMP_DATE.'%"')->result_array();
				}else{
					return $this->partOfGetDataTableOnThisDay("s_tanggal",'s_status=1 AND s_tanggal like "'.$TEMP_DATE.'%"');
				}
			}
			else {
				if($this->dataProcess() == NULL)
					$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal",'s_category='.$this->getKategori().' AND s_status=1 AND s_tanggal like "'.$TEMP_DATE.'%"')->result_array();
				else
					return $this->partOfGetDataTableOnThisDay('s_category='.$this->getKategori().' AND s_status=1 AND s_tanggal like "'.$TEMP_DATE.'%"');
			}
		}else{
			if($this->getKategori()==NULL){
				if($this->dataProcess() == NULL)
					$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal",'s_status=1 AND s_rt="'.$this->getKode().'" AND s_tanggal like "'.$TEMP_DATE.'%"')->result_array();
				else
					return $this->partOfGetDataTableOnThisDay('s_status=1 AND s_rt="'.$this->getKode().'" AND s_tanggal like "'.$TEMP_DATE.'%"');
			}else{
				if($this->getKategori()==NULL)
					$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal",'s_status=1 AND s_category='.$this->getKategori().' AND s_rt="'.$this->getKode().'" AND s_tanggal like "'.$TEMP_DATE.'%"')->result_array();
				else
					return $this->partOfGetDataTableOnThisDay('s_status=1 AND s_category='.$this->getKategori().' AND s_rt="'.$this->getKode().'" AND s_tanggal like "'.$TEMP_DATE.'%"');
			}	
		}
		return $this->neutralizedResultArray();
	}
	public function getDataActiveTabelOnSemester(){
		$this->load->helper('date');
		if($this->getKode() == NULL)
			return false;
		if($this->getKategori() ==NULL){
			if($this->getRuang() == NULL){
				$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal, s_nim",'s_status=1 AND s_rt="'.$this->getKode().'"')->result_array();
				return $this->neutralizedResultArray();
			}else{
				$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal, s_nim","s_ruang='".$this->getRuang()."' AND s_status=1 AND s_rt='".$this->getKode()."'")->result_array();
				return $this->neutralizedResultArray();
			}
		}else{

			if($this->getRuang() == NULL){
				$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal, s_nim",'s_category="'.$this->getKategori().'" AND s_status=1 AND s_rt="'.$this->getKode().'"')->result_array();
				return $this->neutralizedResultArray();
						
			}else{
				$this->TEMP_RESULT_ARRAY = $this->query("s_tanggal, s_nim",'s_ruang="'.$this.getRuang().'" ANDs_category="'.$this->getKategori().'" AND s_status=1 AND s_rt="'.$this->getKode().'"')->result_array();
				return $this->neutralizedResultArray();
				
			}
		}
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
	//log control
	//get jumlah seminar dalam 1 semester to log 
	public function getCountDataPrimary(){
		if($this->getKode() == null)
			return 0;
		if($this->getNim() == null)
			return 0;
		$RESULT_ARRAY = $this->query("*","s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."'")->result_array();
		return count($RESULT_ARRAY);
	}
	//logg data with parameter kode nim
	public function setToLog(){
		if($this->getKode() == null)
			return $this->failedResultAll();
		if($this->getNim() == null)
			return $this->failedResultAll();
		$ROW_ARRAY = $this->query("*","s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."' AND s_status=1")->row_array();
		if(count($ROW_ARRAY) <= 0)
			return FALSE;
		else{
			$this->setStatus(2);
			$this->setLog($this->getCountDataPrimary());
			$this->update($this->queryBuilder(),"s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."' AND s_status=1");
			return TRUE;
		}
	}
	//insert
	//by mahasiswa
	public function insertNewForm(){
		if($this->getKode() == null)
			return $this->failedResultAll();
		if($this->getNim() == null)
			return $this->failedResultAll();
		$this->insert($this->arrayBuilder());
		return true;
	}
	//by dosen
	//update
	public function updateDataProsesTA(){
		if($this->getKode() == null)
			return $this->failedResultAll();
		if($this->getNim() == null)
			return $this->failedResultAll();
		if($this->getKategori() == null)
			return $this->failedResultAll();
		$this->update($this->queryBuilder(),"s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."' AND s_status=1 AND s_category='".$this->getKategori()."'");
		return true;
		
	}
	
	public function updateFormActive(){
		if($this->getKode() == null)
			return $this->failedResultAll();
		if($this->getNim() == null)
			return $this->failedResultAll();
		$this->update($this->queryBuilder(),"s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."' AND s_status=1");
		return true;
		
	}
	public function getCountDataNipS(){
		if($this->getKode() == NULL)
		return 0;
		if($this->getNips() == null)
		return 0;
		if($this->getStatus() == NULL)
			$this->setStatus(1);
		else{
			if(intval($this->getStatus()) < 1 || intval($this->getStatus()) >2)
				$this->setStatus(1);
		}
		$RESULT_ARRAY = $this->query("*","s_rt='".$this->getKode()."' AND s_nip_p_s='".$this->getNips()."' AND s_status='".$this->getStatus()."' AND s_category=2")->result_array(); 
		return count($RESULT_ARRAY);
	}
	public function getCountDataNipD(){
		if($this->getKode() == NULL)
		return 0;
		if($this->getNipd() == null)
		return 0;
		if($this->getStatus() == NULL)
			$this->setStatus(1);
		else{
			if(intval($this->getStatus()) < 1 || intval($this->getStatus()) >2)
				$this->setStatus(1);
		}
		$RESULT_ARRAY = $this->query("*","s_rt='".$this->getKode()."' AND s_nip_p_d='".$this->getNipd()."' AND s_status='".$this->getStatus()."' AND s_category=2")->result_array(); 
		return count($RESULT_ARRAY);
	}
	//
	public function getDataPrimaryActive(){
		if($this->getKode() == null)
			return $this->failedResultAll();
		if($this->getNim() == null){
			return $this->failedResultAll();
		}
		$ROW_ARRAY = $this->query("*","s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."' AND s_status=1")->row_array();
		$this->resetValue();
		if(count($ROW_ARRAY) <= 0){
			return $this->failedResultAll();
		}
		else{
			$this->automaSetContent($ROW_ARRAY);
			return true;
		}
	}
	
	public function getDataPrimaryActiveByKategory(){
		if($this->getKode() == null)
			return $this->failedResultAll();
		if($this->getNim() == null){
			return $this->failedResultAll();
		}
		if($this->getKategori() == NULL)
			return $this->failedResultAll();
		$ROW_ARRAY = $this->query("*","s_rt='".$this->getKode()."' AND s_nim='".$this->getNim()."' AND s_status=1 AND s_category='".$this->getKategori()."'")->row_array();
		$this->resetValue();
		if(count($ROW_ARRAY) <= 0){
			return $this->failedResultAll();
		}
		else{
			$this->automaSetContent($ROW_ARRAY);
			return true;
		}
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
                case 's_doc_p_pengantar' : $this->setDocp($TEMP_ARRAY['s_doc_p_pengantar']);break;
                case 's_doc_p_b_ta' : $this->setDocbta($TEMP_ARRAY['s_doc_p_b_ta']);break;
                case 's_doc_p_p_ta' : $this->setDocpta($TEMP_ARRAY['s_doc_p_p_ta']);break;
                case 's_doc_p_transkrip' : $this->setDocTranskrip($TEMP_ARRAY['s_doc_p_transkrip']);break;
                case 's_tanggal' : $this->setTanggal($TEMP_ARRAY['s_tanggal']);break;
                case 's_doc_p_p_pengantar' : $this->setDocppp($TEMP_ARRAY['s_doc_p_p_pengantar']);break;
                case 's_status' : $this->setStatus($TEMP_ARRAY['s_status']);break;
                case 's_ruang' : $this->setRuang($TEMP_ARRAY['s_ruang']);break;
				case 's_category' : $this->setKategori($TEMP_ARRAY['s_category']);break;
				case 's_log_statue' : $this->setLog($TEMP_ARRAY['s_log_statue']);break;
				case 's_process_data' : $this->setDataProses($TEMP_ARRAY['s_process_data']);break;
			}
		}
	}
    //-valid
	public function resetValue(){
		$this->setKode(null);
		$this->setNim(null);
		$this->setNips(null);
		$this->setNipd(null);
		$this->setDocp(null);
		$this->setDocbta(null);
		$this->setDocpta(null);
		$this->setDocTranskrip(null);
		$this->setTanggal(null);
		$this->setDocppp(null);
		$this->setStatus(null);
		$this->setRuang(null);
		$this->setKategori(null);
		$this->setLog(null);
		$this->setDataProses(NULL);
	}
	private function failedResultAll(){
		$this->resetValue();
		return FALSE;
	}
	public function resetCursor(){
		$this->TEMP_RESULT_ARRAY = NULL;
		$this->TEMP_INDEX_RESULT_ARRAY = null;
	}
    // - valid
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getKode() != NULL) $TEMP_QUERY["s_rt"] = $this->getKode();
		if($this->getNim() != NULL) $TEMP_QUERY["s_nim"] = $this->getNim();
		if($this->getNips() != NULL) $TEMP_QUERY["s_nip_p_s"] = $this->getNips();
		if($this->getNipd() != NULL) $TEMP_QUERY["s_nip_p_d"] = $this->getNipd();
		if($this->getDocp() != NULL) $TEMP_QUERY["s_doc_p_pengantar"] = $this->getDocp();
		if($this->getDocbta() != NULL) $TEMP_QUERY["s_doc_p_b_ta"] = $this->getDocbta();
		if($this->getDocpta() != NULL) $TEMP_QUERY["s_doc_p_p_ta"] = $this->getDocpta();
		if($this->getDocTranskrip() != NULL) $TEMP_QUERY["s_doc_p_transkrip"] = $this->getDocTranskrip();
		if($this->getTanggal() != NULL) $TEMP_QUERY["s_tanggal"] = $this->getTanggal();
		if($this->getDocppp() != NULL) $TEMP_QUERY["s_doc_p_p_pengantar"] = $this->getDocppp();
		if($this->getStatus() != NULL) $TEMP_QUERY["s_status"] = $this->getStatus();
		if($this->getRuang() != NULL) $TEMP_QUERY["s_ruang"] = $this->getRuang();
		if($this->getKategori() != NULL) $TEMP_QUERY["s_category"] = $this->getKategori();
		if($this->getLog() != NULL) $TEMP_QUERY["s_log_statue"] = $this->getLog();
		if($this->getDataProses() != NULL) $TEMP_QUERY["s_process_data"] = $this->getDataProses();
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
        if($this->getDocp() != NULL) $TEMP_QUERY.="s_doc_p_pengantar='".$this->getDocp()."',";
        if($this->getDocbta() != NULL) $TEMP_QUERY.="s_doc_p_b_ta='".$this->getDocbta()."',";
        if($this->getDocpta() != NULL) $TEMP_QUERY.="s_doc_p_p_ta='".$this->getDocpta()."',";
        if($this->getDocTranskrip() != NULL) $TEMP_QUERY.="s_doc_p_transkrip='".$this->getDocTranskrip()."',";
        if($this->getTanggal() != NULL) $TEMP_QUERY.="s_tanggal='".$this->getTanggal()."',";
        if($this->getDocppp() != NULL) $TEMP_QUERY.="s_doc_p_p_pengantar='".$this->getDocppp()."',";
        if($this->getStatus() != NULL) $TEMP_QUERY.="s_status='".$this->getStatus()."',";
        if($this->getRuang() != NULL) $TEMP_QUERY.="s_ruang='".$this->getRuang()."',";
		if($this->getKategori() != NULL) $TEMP_QUERY.="s_category='".$this->getKategori()."',";
		if($this->getLog() != NULL) $TEMP_QUERY.="s_log_statue='".$this->getLog()."',";
		if($this->getDataProses() != NULL) $TEMP_QUERY.="s_process_data='".$this->getDataProses()."',";
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
    private $docp;
    private $docbta;
    private $docpta;
    private $doctranskrip;
    private $tanggal;
    private $docppp;
    private $status;
    private $ruang;
	private $category;
	private $log;
	private $dataprocess;
    //getter
    public function getKode(){$kode = $this->kode; return $kode;}
    public function getNim(){$nim = $this->nim; return $nim;}
    public function getNips(){$nips = $this->nips; return $nips;}
    public function getNipd(){$nipd = $this->nipd; return $nipd;}
    public function getDocp(){$docp = $this->docp; return $docp;}
    public function getDocbta(){$docbta = $this->docbta; return $docbta;}
    public function getDocpta(){$docpta = $this->docpta; return $docpta;}
    public function getDocTranskrip(){$doctranskrip = $this->doctranskrip; return $doctranskrip;}
    public function getTanggal(){$tanggal = $this->tanggal; return $tanggal;}
    public function getDocppp(){$docppp = $this->docppp; return $docppp;}
    public function getStatus(){$status = $this->status; return $status;}
    public function getRuang(){$ruang = $this->ruang; return $ruang;}
	public function getKategori(){$category = $this->category; return $category;}
	public function getLog(){$log = $this->log; return $log;}
	public function getDataProses(){$dataprocess = $this->dataprocess; return $dataprocess;}
    //setter
    public function setKode($kode){$this->kode = $kode;}
    public function setNim($nim){$this->nim = $nim;}
    public function setNips($nips){$this->nips = $nips;}
    public function setNipd($nipd){$this->nipd = $nipd;}
    public function setDocp($docp){$this->docp = $docp;}
    public function setDocbta($docbta){$this->docbta = $docbta;}
    public function setDocpta($docpta){$this->docpta = $docpta;}
    public function setDocTranskrip($doctranskrip){$this->doctranskrip = $doctranskrip;}
    public function setTanggal($tanggal){$this->tanggal = $tanggal;}
    public function setDocppp($docppp){$this->docppp = $docppp;}
    public function setStatus($status){$this->status = $status;}
    public function setRuang($ruang){$this->ruang = $ruang;}
	public function setKategori($category){$this->category = $category;}
	public function setLog($log){$this->log = $log;}
	public function setDataProses($dataprocess){$this->dataprocess = $dataprocess;}
}