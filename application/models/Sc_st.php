<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_st extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_st';
	}
	
	//get TA before
	public function getHaveLastTAInfo(){
		if($this->getNim() == NULL)
			return FALSE;
		if($this->getKode() == NULL)
			return false;
		$TEMP_RESULT_ARRAY = $this->query("*","s_nim='".$this->session->userdata('nim')."' AND s_rt=".$idbefore)->result_array();
		if(count($TEMP_RESULT_ARRAY)<=0){
			$this->resetValue();
			$TEMP_RESULT_ARRAY = NULL;
			$TEMP_INDEX_RESULT_ARRAY = 0;
			return false;
		}else{
			$TEMP_INDEX_RESULT_ARRAY = 0;
			return true;
		}
	} 
	//
	protected function query($select='*',$where=""){
		$query="SELECT ".$select." FROM ".$this->tablename;
		if($where!="")
			$query=$query." WHERE ".$where;
		return $this->db->query($query);
	}
	protected function insert($data){
		return $this->db->insert($this->tablename,$data);
	}
	protected function update($set="",$where=""){
		$query="UPDATE `".$this->tablename."` SET ".$set;
		if($where!="")
			$query=$query." WHERE ".$where;
		$this->db->query($query);
	}
	
	//set automa content
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 's_rt' : $this->setKode($TEMP_ARRAY['s_rt']);break;
				case 's_nim' : $this->setNim($TEMP_ARRAY['s_nim']);break;
				case 's_nip' : $this->setNip($TEMP_ARRAY['s_nip']);break;
				case 's_judul_ta' : $this->setJudulTa($TEMP_ARRAY['s_judul_ta']);break;
				case 's_metode' : $this->setMetode($TEMP_ARRAY['s_metode']);break;
				case 's_ref_s' : $this->setReferensis($TEMP_ARRAY['s_ref_s']);break;
				case 's_ref_d' : $this->setReferensid($TEMP_ARRAY['s_ref_d']);break;
				case 's_ref_t' : $this->setReferensit($TEMP_ARRAY['s_ref_t']);break;
				case 's_lokasi' : $this->setLokasi($TEMP_ARRAY['s_lokasi']);break;
				case 's_name_krs' : $this->setNamaKrs($TEMP_ARRAY['s_name_krs']);break;
				case 's_statue' : $this->setStatus($TEMP_ARRAY['s_statue']);break;
				case 's_data_statue' : $this->setLogStatus($TEMP_ARRAY['s_data_statue']);break;
				case 's_category' : $this->setKategori($TEMP_ARRAY['s_category']);break;
				case 's_data_process' : $this->setDataProses($TEMP_ARRAY['s_data_process']);break;
			}
		}
		$this->setId($TEMP_ARRAY['si_id']);
		$this->setName($TEMP_ARRAY('si_name'));
	}
	//reset all value
	protected function resetValue(){
		$this->setKode(NULL);
		$this->setNim(NULL);
		$this->setNip(NULL);
		$this->setJudulTa(NULL);
		$this->setMetode(NULL);
		$this->setReferensis(NULL);
		$this->setReferensid(NULL);
		$this->setReferensit(NULL);
		$this->setLokasi(NULL);
		$this->setNamaKrs(NULL);
		$this->setStatus(NULL);
		$this->setLogStatus(NULL);
		$this->setKategori(NULL);
		$this->setDataProses(NULL);
	}
	//array Builder
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getKode() != NULL) $TEMP_QUERY["s_rt"] = $this->getKode();
		if($this->getNim() != NULL) $TEMP_QUERY["s_nim"] = $this->getNim();
		if($this->getNip() != NULL) $TEMP_QUERY["s_nip"] = $this->getNip();
		if($this->getJudulTa() != NULL) $TEMP_QUERY["s_judul_ta"] = $this->getJudulTa();
		if($this->getMetode() != NULL) $TEMP_QUERY["s_metode"] = $this->getMetode();
		if($this->getReferensis() != NULL) $TEMP_QUERY["s_ref_s"] = $this->getReferensis();
		if($this->getReferensid() != NULL) $TEMP_QUERY["s_ref_d"] = $this->getReferensid();
		if($this->getReferensit() != NULL) $TEMP_QUERY["s_ref_t"] = $this->getReferensit();
		if($this->getLokasi() != NULL) $TEMP_QUERY["s_lokasi"] = $this->getLokasi();
		if($this->getNamaKrs() != NULL) $TEMP_QUERY["s_name_krs"] = $this->getNamaKrs();
		if($this->getStatus() != NULL) $TEMP_QUERY["s_statue"] = $this->getStatus();
		if($this->getLogStatus() != NULL) $TEMP_QUERY["s_data_statue"] = $this->getLogStatus();
		if($this->getKategori() != NULL) $TEMP_QUERY["s_category"] = $this->getKategori();
		if($this->getDataProses() != NULL) $TEMP_QUERY["s_data_process"] = $this->getDataProses();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
	//query builder
	protected function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getKode() != NULL) $TEMP_QUERY.="s_rt='".$this->getKode()."',";
		if($this->getNim() != NULL) $TEMP_QUERY.="s_nim='".$this->getNim()."',";
		if($this->getNip() != NULL) $TEMP_QUERY.="s_nip='".$this->getNip()."',";
		if($this->getJudulTa() != NULL) $TEMP_QUERY.="s_judul_ta='".$this->getJudulTa()."',";
		if($this->getMetode() != NULL) $TEMP_QUERY.="s_metode='".$this->getMetode()."',";
		if($this->getReferensis() != NULL) $TEMP_QUERY.="s_ref_s='".$this->getReferensis()."',";
		if($this->getReferensid() != NULL) $TEMP_QUERY.="s_ref_d='".$this->getReferensid()."',";
		if($this->getReferensit() != NULL) $TEMP_QUERY.="s_ref_t='".$this->getReferensit()."',";
		if($this->getLokasi() != NULL) $TEMP_QUERY.="s_lokasi='".$this->getLokasi()."',";
		if($this->getNamaKrs() != NULL) $TEMP_QUERY.="s_name_krs='".$this->getNamaKrs()."',";
		if($this->getStatus() != NULL) $TEMP_QUERY.="s_statue='".$this->getStatus()."',";
		if($this->getLogStatus() != NULL) $TEMP_QUERY.="s_data_statue='".$this->getLogStatus()."',";
		if($this->getKategori() != NULL) $TEMP_QUERY.="s_category='".$this->getKategori()."',";
		if($this->getDataProses() != NULL) $TEMP_QUERY.="s_data_process='".$this->getDataProses()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
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
	//attribute
	private $kode;
	private $nim;
	private $nip;
	private $judulta;
	private $metode;
	private $referensis;
	private $referensid;
	private $referensit;
	private $lokasi;
	private $namakrs;
	private $statue;
	private $logstatue;
	private $kategori;
	private $dataproses;
	//setter
	public function setKode($kode){$this->kode = $kode;}
	public function setNim($nim){$this->nim = $nim;}
	public function setNip($nip){$this->nip = $nip;}
	public function setJudulTa($judulta){$this->judulta = $judulta;}
	public function setMetode($metode){$this->metode = $metode;}
	public function setReferensis($referensis){$this->referensis = $referensis;}
	public function setReferensid($referensid){$this->referensid = $referensid;}
	public function setReferensit($referensit){$this->referensit = $referensit;}
	public function setLokasi($lokasi){$this->lokasi = $lokasi;}
	public function setNamaKrs($namakrs){$this->namakrs = $namakrs;}
	public function setStatus($statue){$this->Statue = $statue;}
	public function setLogStatus($logstatue){$this->logstatue = $logstatue;}
	public function setKategori($kategori){$this->kategori = $kategori;}
	public function setDataProses($dataproses){$this->dataproses = $dataproses;}
	//getter
	public function getKode(){$kode = $this->kode; return $kode;}
	public function getNim(){$nim = $this->nim; return $nim;}
	public function getNip(){$nip = $this->nip; return $nip;}
	public function getJudulTa(){$judulta = $this->judulta; return $judulta;}
	public function getMetode(){$metode = $this->metode; return $metode;}
	public function getReferensis(){$referensis = $this->referensis; return $referensis;}
	public function getReferensid(){$referensid = $this->referensid; return $referensid;}
	public function getReferensit(){$referensit = $this->referensit; return $referensit;}
	public function getLokasi(){$lokasi = $this->lokasi; return $lokasi;}
	public function getNamaKrs(){$namakrs = $this->namakrs; return $namakrs;}
	public function getStatus(){$statue = $this->Statue; return $statue;}
	public function getLogStatus(){$logstatue = $this->logstatue; return $logstatue;}
	public function getKategori(){$kategori = $this->kategori; return $kategori;}
	public function getDataProses(){$dataproses = $this->dataproses; return $dataproses;}
}