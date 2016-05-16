<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_lms extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_lms';
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
        private $nim; private $tanggal; private $event; private $koor; private $mahasiswa;
        function getNim() {            return $this->nim;        }
        function getTanggal() {            return $this->tanggal;        }
        function getEvent() {            return $this->event;        }
        function getKoor() {            return $this->koor;        }
        function getMahasiswa() {            return $this->mahasiswa;        }
        function setNim($nim) {            $this->nim = $nim;        }
        function setTanggal($tanggal) {            $this->tanggal = $tanggal;        }
        function setEvent($event) {            $this->event = $event;        }
        function setKoor($koor) {            $this->koor = $koor;        }
        function setMahasiswa($mahasiswa) {            $this->mahasiswa = $mahasiswa;        }
        function addNew(){
		return $this->insert(array(
				'l_nim' => $this->getNim(),
				'l_date' => $this->getTanggal(),
				'l_event' => $this->getEvent()
		));
        }
}