<?php	//query builder - ok
	//arrayBuilder - ok
	//automaSetContent - ok
	//resetValue - ok
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_sk extends CI_Model {
	//function focus
	public function getSignIn(){
		if($this->getKode() == NULL)
			return false;
		if($this->getPassword() == NULL)
			return false;
		$TEMP_ARRAY = $this->query("*","s_kode='".$this->getKode()."' AND s_password='".$this->getPassword()."'")->row_array();
		$this->resetValue();
		$this->automaSetContent($TEMP_ARRAY);
		if($this->getKode() == NULL)
			return false;
		else
			return true;
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
	
	//
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
		$TEMP_QUERY = NULL;
		if($this->getKode() != NULL) $TEMP_QUERY["s_kode"] = $this->getKode();
		if($this->getPassword() != NULL) $TEMP_QUERY["s_password"] = $this->getPassword();
		if($this->getEmail() != NULL) $TEMP_QUERY["s_email"] = $this->getEmail();
		if($this->getNohp() != NULL) $TEMP_QUERY["s_contacs"] = $this->getNohp();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
	public function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getKode() != NULL) $TEMP_QUERY.="s_kode='".$this->getKode()."',";
		if($this->getPassword() != NULL) $TEMP_QUERY.="s_password='".$this->getPassword()."',";
		if($this->getEmail() != NULL) $TEMP_QUERY.="s_email='".$this->getEmail()."',";
		if($this->getNohp() != NULL) $TEMP_QUERY.="s_contacs='".$this->getNohp()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
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