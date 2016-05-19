<?php	//query builder - ok
	//arrayBuilder - ok
	//automaSetContent - ok
	//resetValue - ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_sk extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_sk';
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
	private $kode;
	private $password;
	private $email;
	private $nohp;
	public function setKode($TEMP_DATA){$this->kode = $TEMP_DATA;}
	public function setPassword($TEMP_DATA){$this->password = $TEMP_DATA;}
	public function setEmail($TEMP_DATA){$this->email = $TEMP_DATA;}
	public function setNohp($TEMP_DATA){$this->nohp = $TEMP_DATA;}
	public function getKode(){		$TEMP_DATA = $this->kode;		return $TEMP_DATA;	}
	public function getPassword(){		$TEMP_DATA = $this->password;		return $TEMP_DATA;	}
	public function getEmail(){		$TEMP_DATA = $this->email;		return $TEMP_DATA;	}
	public function getNohp(){		$TEMP_DATA = $this->nohp;		return $TEMP_DATA;	}
	public function arrayBuilder(){
		if($this->getKode() != NULL) $TEMP_QUERY["s_kode"] = $this->getKode();
		if($this->getPassword() != NULL) $TEMP_QUERY["s_password"] = $this->getPassword();
		if($this->getEmail() != NULL) $TEMP_QUERY["s_email"] = $this->getEmail();
		if($this->getNohp() != NULL) $TEMP_QUERY["s_contacs"] = $this->getNohp();
		return $TEMP_QUERY;
	}
	public function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getKode() != NULL) $TEMP_QUERY.="s_kode='".$this->getKode()."',";
		if($this->getPassword() != NULL) $TEMP_QUERY.="s_password='".$this->getPassword()."',";
		if($this->getEmail() != NULL) $TEMP_QUERY.="s_email='".$this->getEmail()."',";
		if($this->getNohp() != NULL) $TEMP_QUERY.="s_contacs='".$this->getNohp()."',";

		return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
	}
	public function resetValue(){
		$this->setKode(NULL);
		$this->setPassword(NULL);
		$this->setEmail(NULL);
		$this->setNohp(NULL);
	}
	public function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 's_kode' : $this->setKode($TEMP_ARRAY['s_kode']);break;
				case 's_password' : $this->setPassword($TEMP_ARRAY['s_password']);break;
				case 's_email' : $this->setEmail($TEMP_ARRAY['s_email']);break;
				case 's_contacs' : $this->setNohp($TEMP_ARRAY['s_contacs']);break;
			}
		}
	}
}