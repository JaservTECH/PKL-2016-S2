<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
class Aktor{
	static $data;
	protected $lockPublick;
	protected $dataEncrypt;
	protected $dataKeyAccess;
	protected $dataResultAccess;
	protected function setNewKey($index=null,$value=null){
		if(array_key_exists($index, $this->dataKeyAccess))
			return false;
		$this->dataKeyAccess[$index] = $value;
		$this->dataResultAccess[$index] = false;
	}
	
	public function setOpenKey($index,$value){
		if(!array_key_exists($index, $this->dataKeyAccess))
			return false;
		if(sha1($value) != sha1($this->dataKeyAccess[$index]))
			return false;
		$this->dataResultAccess[$index] = true;
		return true;
	}
	public function getStatusKey($index){
		if(!array_key_exists($index, $this->dataResultAccess))
			return false;
		if($this->dataResultAccess[$index])
			return true;
		else 
			return false;
	}
	public function setModel($a){
		$this->CI->load->model($a);
		$this->$a = $this->CI->$a;
	}
	public function setHelper($a){
		$this->CI->load->helper($a);
		
	}
	public function setLibrary($a){
		$this->CI->load->library($a);
		$this->$a = $this->CI->$a;
	}
	function __construct(){
		$this->CI = &get_instance();
		$this->dataKeyAccess['openKey']="JASERVTECH-UNDIP";
		$this->dataResultAccess['openKey']=true;
	}
	/*lock public*/
	
	public function getStatusLockPublic(){
		return $this->lockPublick;
	}
	public function getCheckNuTelphone($telphone="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($telphone == "")
			return $this->setCategoryPrintMessage($cat, false, "nama tidak boleh kosong");
		$temp = $this->inputjaservfilter->numberFiltering($telphone);
		if($temp[0]){
			if(strlen($telphone) > 9 && strlen($telphone) < 14)
				return $this->setCategoryPrintMessage($cat, true, "no telefon valid");
			else
				return $this->setCategoryPrintMessage($cat, false, "no telefon tidak valid");
		}else
			return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	public function getCheckEmail($email="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($email == "")
			return $this->setCategoryPrintMessage($cat, false, "nama tidak boleh kosong");
		$temp = $this->inputjaservfilter->emailFiltering($email);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	public function getCheckName($name="",$cat=0){
		if(!$this->getStatusLockPublic())
			header("location:".base_url()."gateinout.aspx");
		if($name == "")
			return $this->setCategoryPrintMessage($cat, false, "nama tidak boleh kosong");
		$temp = $this->inputjaservfilter->usernameFiltering($name);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	public function setLockToUsePublic($code=""){
		$error=0;
		if($code == "")
			$error+=1;
			if(md5($code) != md5($this->dataEncrypt))
				$error+=1;
				if($error > 0){
					$this->setFalseLockPublic();
					header("location:".base_url()."gateinout.aspx");
				}else{
					$this->setTrueLockPublic();
				}
	}
	/*public*/
	/*protected*/
	protected function setFalseLockPublic(){$this->lockPublick = false;}
	protected function setTrueLockPublic(){$this->lockPublick = true;}
	protected function setNewDataEncrypt($dataEncrypt){$this->dataEncrypt = $dataEncrypt;}
	/*form-session*/
	protected function setCategoryPrintMessage($cat,$status,$message){
		if($cat==0){
			if($status){
				echo "1".$message;
				return ;
			}else{
				echo "0".$message;
				return ;
			}
		}else{
			return array($status,$message);
		}
	}
	/*private*/
}