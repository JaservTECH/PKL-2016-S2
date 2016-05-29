<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once ("Aktor.php");
class Admin extends Aktor {
	function __construct(){
		parent::__construct();
		$this->setModel("sc_sd");
		$this->setLibrary('inputjaservfilter');
	}
}