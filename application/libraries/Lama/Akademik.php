<?php
if(!defined('BASEPATH'))
	exit("You dont have permission on this site");
require_once ("Aktor.php");
class Akademik extends Aktor{
	function __construct(){
		parent::__construct();
		$this->setNewDataEncrypt("JaservTech.Akademik.Public.Control.Open");
		$this->setModel("sc_sst");
		$this->setLibrary('inputjaservfilter');
		$this->setNewKey("koordinator","JASERVTECH-KOORDINATOR-SESSION");
	}
	
}