<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sc_sm_interest extends CI_Model {
	private $tablename;
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->database();
		$this->tablename = 'sc_sm_interest';
		$this->TEMP_RESULT_ARRAY = null;
		$this->TEMP_INDEX_RESULT_ARRAY = null;
		$this->resetValue();
	}
	protected function query($select='*',$where=""){$query="SELECT ".$select." FROM ".$this->tablename;	if($where!="")	$query=$query." WHERE ".$where;	return $this->db->query($query);}
	function getAllData(){
		$this->TEMP_RESULT_ARRAY = $this->sc_sm_interest->query("*")->result_array();
		$this->TEMP_INDEX_RESULT_ARRAY = 0;
	}
	function getCursorNext(){
		if($this->TEMP_RESULT_ARRAY == null) return false;
		if($this->TEMP_INDEX_RESULT_ARRAY == null) return false;
		if(!array_key_exists($this->TEMP_INDEX_RESULT_ARRAY, $this->TEMP_RESULT_ARRAY)){
			$this->resetValue();
			return false;
		}else{
			$this->automaSetContent($this->TEMP_RESULT_ARRAY[$this->TEMP_INDEX_RESULT_ARRAY]);
			return true;
		}
	}
	//kode standard
	protected function automaSetContent($TEMP_ARRAY){
		$this->setId($TEMP_ARRAY['si_id']);
		$this->setName($TEMP_ARRAY('si_name'));
	}
	protected function resetValue(){
		$this->setId(null);
		$this->setName(null);
	}
	private $id;
	private $name;
	function getId() {
		return $this->id;
	}

	function getName() {
		return $this->name;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setName($name) {
		$this->name = $name;
	}
	
}