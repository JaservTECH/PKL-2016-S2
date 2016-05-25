<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_sd extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_sd';
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
	public function getAllListDosen(){
		$this->TEMP_RESULT_ARRAY = $this->query("*")->result_array();
		return $this->neutralizedResultArray();
	}
	
	public function getDosenInfo(){
		if($this->getNip() == NULL)
			return false;
		$TEMP_ARRAY = $this->query("*","s_id=".$this->getNip())->row_array();
		if(count($TEMP_ARRAY) > 0){
			$this->automaSetContent($TEMP_ARRAY);
			return true;
		}else{
			$this->resetValue();
			return false;
		}
		
	}
	public function getListDosenActive(){
		$this->TEMP_RESULT_ARRAY = $this->sc_sd->query("s_id, s_name","s_status=1 ORDER BY s_id ASC")->result_array();
		return $this->neutralizedResultArray();
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
	//array Builde
	
	protected function queryBuilder(){
		$TEMP_QUERY = "";
		if($this->getNip() != NULL) $TEMP_QUERY.="s_id='".$this->getNip()."',";
		if($this->getNama() != NULL) $TEMP_QUERY.="s_name='".$this->getNama()."',";
		if($this->getEmail() != NULL) $TEMP_QUERY.="s_email='".$this->getEmail()."',";
		if($this->getAlamat() != NULL) $TEMP_QUERY.="s_alamat='".$this->getAlamat()."',";
		if($this->getBidang() != NULL) $TEMP_QUERY.="s_bidang_riset='".$this->getBidang()."',";
		if($this->getNohp() != NULL) $TEMP_QUERY.="s_no_telp='".$this->getNohp()."',";
		if($this->getStatus() != NULL) $TEMP_QUERY.="s_status='".$this->getStatus()."',";
		if($this->getPassword() != NULL) $TEMP_QUERY.="s_password='".$this->getPassword()."',";
		if($TEMP_QUERY != "")
			return substr($TEMP_QUERY,0,strlen($TEMP_QUERY)-1);
		else
			return $TEMP_QUERY;
	}
	protected function arrayBuilder(){
		$TEMP_QUERY = NULL;
		if($this->getNip() != NULL) $TEMP_QUERY["s_id"] = $this->getNip();
		if($this->getNama() != NULL) $TEMP_QUERY["s_name"] = $this->getNama();
		if($this->getEmail() != NULL) $TEMP_QUERY["s_email"] = $this->getEmail();
		if($this->getAlamat() != NULL) $TEMP_QUERY["s_alamat"] = $this->getAlamat();
		if($this->getBidang() != NULL) $TEMP_QUERY["s_bidang_riset"] = $this->getBidang();
		if($this->getNohp() != NULL) $TEMP_QUERY["s_no_telp"] = $this->getNohp();
		if($this->getStatus() != NULL) $TEMP_QUERY["s_status"] = $this->getStatus();
		if($this->getPassword() != NULL) $TEMP_QUERY["s_password"] = $this->getPassword();
		if(count($TEMP_QUERY) > 0)
			return $TEMP_QUERY;
		else
			return NULL;
	}
	//automaSetContent
	protected function automaSetContent($TEMP_ARRAY){
		$this->resetValue();
		foreach($TEMP_ARRAY as $TEMP_INDEX_ARRAY => $TEMP_VALUE){
			switch($TEMP_INDEX_ARRAY){
				case 's_id' : $this->setNip($TEMP_ARRAY['s_id']);break;
				case 's_name' : $this->setNama($TEMP_ARRAY['s_name']);break;
				case 's_bidang_riset' : $this->setBidang($TEMP_ARRAY['s_bidang_riset']);break;
				case 's_email' : $this->setEmail($TEMP_ARRAY['s_email']);break;
				case 's_alamat' : $this->setAlamat($TEMP_ARRAY['s_alamat']);break;
				case 's_no_telp' : $this->setNohp($TEMP_ARRAY['s_no_telp']);break;
				case 's_status' : $this->setStatus($TEMP_ARRAY['s_status']);break;
				case 's_password' : $this->setPassword($TEMP_ARRAY['s_password']);break;
			}
		}
	}
	//query  Builder
	public function queryBuider(){}
	//reset value to null
	public function resetValue(){
		$this->setNip(NULL);
		$this->setNama(NULL);
		$this->setEmail(NULL);
		$this->setBidang(NULL);
		$this->setAlamat(NULL);
		$this->setNohp(NULL);
		$this->setStatus(NULL);
		$this->setPassword(NULL);
	}
	private $nip;
	private $nama;
	private $email;
	private $bidang;
	private $alamat;
	private $nohp;
	private $status;
	private $password;
	//setter and getter
	public function setNip($nip){$this->nip = $nip;}
	public function setNama($nama){$this->nama = $nama;}
	public function setEmail($email){$this->email = $email;}
	public function setBidang($bidang){$this->bidang = $bidang;}
	public function setAlamat($alamat){$this->alamat = $alamat;}
	public function setNohp($nohp){$this->nohp = $nohp;}
	public function setStatus($status){$this->status = $status;}
	public function setPassword($password){$this->password = $password;}
	public function getNip(){$nip = $this->nip; return $nip;}
	public function getNama(){$nama = $this->nama; return $nama;}
	public function getEmail(){$email = $this->email; return $email;}
	public function getBidang(){$bidang = $this->bidang; return $bidang;}
	public function getAlamat(){$alamat = $this->alamat; return $alamat;}
	public function getNohp(){$nohp = $this->nohp; return $nohp;}
	public function getStatus(){$status = $this->status; return $status;}
	public function getPassword(){$password = $this->password; return $password;}
}