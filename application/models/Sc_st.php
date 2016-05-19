<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_st extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_st';
	}
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
	protected function resetValue(){
		$this->setId(null);
		$this->setName(null);
	}
	protected function arrayBuilder(){
		//if($this->getId() != NULL) $TEMP_QUERY["si_id"] = $this->getId();
		//if($this->getName() != NULL) $TEMP_QUERY["si_name"] = $this->getName();
		//return $TEMP_QUERY;
	}
	protected function queryBuilder(){
		$TEMP_QUERY = "";
		//if($this->getId() != NULL) $TEMP_QUERY.="si_id='".$this->getId()."',";
		//if($this->getName() != NULL) $TEMP_QUERY.="si_name='".$this->getName()."',";
		return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
	}
	//setter and getter
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
}