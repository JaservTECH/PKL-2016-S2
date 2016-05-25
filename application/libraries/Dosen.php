<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once ("Aktor.php");
class Dosen extends Aktor {
	function __construct(){
		parent::__construct();
		$this->setModel("sc_sd");
		$this->setLibrary('inputjaservfilter');
	}
	/*
	public function getAllListDosen(){
		if(!$this->getStatusKey('koordinator'))
			return $this->setCategoryPrintMessage(1, false, "maaf, key koordinator belum di buka");
		return $this->setCategoryPrintMessage(1, true, $this->sc_sd->query("*")->result_array());
		
	}
	*/
	public function getListDosen(){
		return $this->sc_sd->query("s_id as id, s_name as nama","s_status=1")->result_array();
	}
	
	public function setStatusDosen($nip,$stat){
		if($nip == null){
			echo "0maaf, anda melakukan debugging";
			return ;
		}
		$temp = $this->getCheckNip($nip,1);
		if(!$temp[0]){
			echo "0".$temp[1];
			return;
		}
		if($stat == null){
			echo "0maaf, anda melakukan debugging";
			return ;
		}
		if(intval($stat) != 0){
			if(intval($stat) != 1){
				echo "0maaf, anda melakukan debugging";
				return;
			}
		}
		if(!$this->getStatusKey('koordinator'))
			return $this->setCategoryPrintMessage(1, false, "maaf, key koordinator belum di buka");
		$this->sc_sd->update("
				`s_status`='".$stat."'
				","s_id=".$nip);
		echo "1berhasil melakukan perubahan";
	}
	public function getCheckNip($nip="",$cat=0){
		if($nip == "")
			return $this->setCategoryPrintMessage($cat, false, "nip tidak boleh kosong");
		if(!$this->inputjaservfilter->numberFiltering($nip)[0])
			return $this->setCategoryPrintMessage($cat, false, "nip mengandng karakter lain");
		if((strlen($nip)>=17)&&(strlen($nip) <= 20))
			return $this->setCategoryPrintMessage($cat, true, "valid");
		else 
			return $this->setCategoryPrintMessage($cat, false, "nip tidak valid");
	} 
	public function getIsNipExistActive($nip="",$cat=0){
		if(!$this->getCheckNip($nip,1)[0])
			return $this->setCategoryPrintMessage($cat, false, "nip tidak valid");
		$temp = $this->sc_sd->query("s_id as id","s_status=1")->result_array();
		for($i=0;$i<count($temp);$i++){
			if($temp[$i]['id']==$nip){
				return $this->setCategoryPrintMessage($cat, true, "valid");
			}
		}
		return $this->setCategoryPrintMessage($cat, false, "Nip tidak ditemukan dalam dosen yang aktif");
	}
	public function getDosenName($nip){
		return $this->sc_sd->query("s_name as nama","s_id=".$nip."")->row_array();
		
	}
	/*
	public function getDosenInfo($nip){
		if(!$this->getCheckNip($nip,1)[0])
			return $this->getCheckNip($nip,1);
		return array(true,$this->sc_sd->query(
				"s_id as nip,
				s_name as nama,
				s_bidang_riset as bidris,
				s_alamat as alamat,
				s_email as email,
				s_no_telp as notelp",
				"s_id=".$nip
				)->row_array());
		
	}*/
}