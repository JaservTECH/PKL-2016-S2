<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

class Classroom extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("sc_ea");
		$this->load->model("sc_sm");
		$this->load->model("sc_st");
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('mahasiswa');
		$this->load->library('koordinator');
		$this->load->library('Dosen');
		//$this->data['koordinator'] = 9;
		//$this->koordinator = new Mahasiswa();
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
	}
	public function index(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$temp = $this->mahasiswa->getDataMahasiswaLoginInterfaceDefault();
		$data['url_script'] = array(
				"resources/taurus/js/plugins/jquery/jquery.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui.min.js",
				"resources/taurus/js/plugins/jquery/jquery-migrate.min.js",
				"resources/taurus/js/plugins/jquery/globalize.js",
				"resources/taurus/js/plugins/bootstrap/bootstrap.min.js",
				//"resources/taurus/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js",
				"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
				//"resources/taurus/js/plugins/knob/jquery.knob.js",
				//"resources/taurus/js/plugins/sparkline/jquery.sparkline.min.js",
				//"resources/taurus/js/plugins/flot/jquery.flot.js",
				//"resources/taurus/js/plugins/flot/jquery.flot.resize.js",
				"resources/taurus/js/plugins/select2/select2.min.js",
				"resources/taurus/js/plugins/tagsinput/jquery.tagsinput.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui-timepicker-addon.js",
				//"resources/taurus/js/plugins/ibutton/jquery.ibutton.js",
				//"resources/taurus/js/plugins/validationengine/languages/jquery.validationEngine-en.js",
				//"resources/taurus/js/plugins/validationengine/jquery.validationEngine.js",
				//"resources/taurus/js/plugins/maskedinput/jquery.maskedinput.min.js",
				//"resources/taurus/js/plugins/stepy/jquery.stepy.min.js",
				"resources/taurus/js/plugins/fullcalendar/fullcalendar.min.js",
				//"resources/taurus/js/js.js",
				"resources/taurus/js/settings.js",
				"resources/taurus/js/plugins/noty/jquery.noty.js",
				"resources/taurus/js/plugins/noty/layouts/topCenter.js",
				"resources/taurus/js/plugins/noty/layouts/topLeft.js",
				"resources/taurus/js/plugins/noty/layouts/topRight.js",
				"resources/taurus/js/plugins/noty/themes/default.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js",
				"resources/mystyle/js/global-style.js",
				"resources/mystyle/js/SeminarTAS.js",
				"resources/mystyle/js/Classroom.js",
				"resources/mystyle/js/RegistrasiBaru.js",
				"resources/mystyle/js/RegistrasiLama.js",
				"resources/mystyle/js/list-dosen-mahasiswa.js",
				"resources/mystyle/js/Bimbingan.js"
				//"resources/dist/date/bootstrap.min.js",
				//"resources/dist/date/moment-with-locales.js",
				//"resources/dist/date/bootstrap-datetimepicker.js"
				//"resources/dist/js/bootstrap-datetimepicker.js",
				//"resources/dist/js/locales/bootstrap-datetimepicker.fr.js"
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				
				"resources/mystyle/css/classroom.css",
				//"resources/dist/date/bootstrap.min.css",
				//"resources/dist/date/bootstrap-datetimepicker.css"
				
				//"resources/dist/css/bootstrap-datetimepicker.min.css"
		);
		$data['nim'] = $temp[1]['nim'];
		$data['nama'] = $temp[1]['nama'];
		$data['title'] = "Beranda | Mahasiswa";
		$this->load->view('Classroom_room/Header',$data);
		$this->load->view('Classroom_room/Body_top');
		$dataleft['image'] = 'upload/foto/'.$temp[1]['foto'];
		$this->load->view('Classroom_room/Body_left',$dataleft);
		$this->load->view('Classroom_room/Body_right/Body_right');
		$this->load->view('Classroom_room/Body_plug');
		$dataFoot['url_script'] = array(
				"resources/plugins/calender/underscore-min.js",
				"resources/plugins/calender/moment-2.2.1.js",
				"resources/plugins/calender/clndr.js",
				"resources/plugins/calender/site.js"
		);
		$dataFoot['url_link'] = array(
				"resources/plugins/calender/clndr.css"
		);
		$this->load->view('Classroom_room/Footer',$dataFoot);
	}
	public function signOut(){
		$this->mahasiswa->setStatusLogOutMahasiswa();
		redirect(base_url()."Gateinout.aspx");
	}
	//end sesi bimbbingan
	
	
	//registrasi
	
	
	
	protected function getGenerateSimpleJson($a,$b){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if($b === NULL){
			return '"'.$a.'" : { "status" : false, "value" : null}';
		}else{
			return '"'.$a.'" : { "status" : true, "value" : "'.$b.'"}';
		}
	}
	/**/
	//methode return view of Home - vaid 
	public function getLayoutHome(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->view("Classroom_room/Body_right/home");
	}
	public function test(){
		//success
		$this->mahasiswa->isAnyGuysOnThisDay("2016-04-12 10:21:13","1","20152");
		//test
		$this->load->library('interface_sc_sst');
		$this->mahasiswa->setOpenPermission("seminar-ta1","JaservTech.Mahasiswa.Sem.Ta.1.Controls");
		$this->mahasiswa->setNewSeminarTA1($this->interface_sc_sst);
		/*$this->classGeneraotr("Interface_sc_sm", array(
				"Nim" => "s_nim",
				"Password" => "s_pass",
				"Date" => "s_date"
		));*/
	}
	public function classGeneraotr($namaClass,$atribut){
		
		$class = "class ".$namaClass." {<br>";
		$set = "";
		$atr = "";
		$get ="";
		foreach ($atribut as $key => $value){
			$atr .=" private $".$value.";<br>";
			$set .="public function set".$key."($"."temp){<br>".
			"$"."this->".$value."=$"."temp;<br>".
			"}<br>";
			$get .="public function get".$key."(){<br>".
					"$"."temp=$"."this->".$value.";<br>".
					"return $"."temp;<br>".
					"}<br>";
		}
		$class .= $atr.$set.$get;
		$class .= "}"; 
		echo $class;
		
	}
	public function getCheck($variabel=null,$value=null,$type=false){
		if($variabel == null){
			$this->isNullPost('variabel');
			$variabel = $this->input->post('variabel');
			$variabel.="";
		}
		if($value == null){
			$this->isNullPost('value');
			$value = $this->input->post('value');
		}
		$value.="";
		switch ($variabel){
			case 'date-is-available' : 
				if($type){
					
				}else{
					$this->mahasiswa->isAnyGuysOnThisDay($value,1);
				}
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}