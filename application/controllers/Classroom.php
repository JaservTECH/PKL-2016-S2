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
				"resources/taurus/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js",
				"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
				"resources/taurus/js/plugins/knob/jquery.knob.js",
				"resources/taurus/js/plugins/sparkline/jquery.sparkline.min.js",
				"resources/taurus/js/plugins/flot/jquery.flot.js",
				"resources/taurus/js/plugins/flot/jquery.flot.resize.js",
				"resources/taurus/js/plugins/select2/select2.min.js",
				"resources/taurus/js/plugins/tagsinput/jquery.tagsinput.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui-timepicker-addon.js",
				"resources/taurus/js/plugins/ibutton/jquery.ibutton.js",
				"resources/taurus/js/plugins/validationengine/languages/jquery.validationEngine-en.js",
				"resources/taurus/js/plugins/validationengine/jquery.validationEngine.js",
				"resources/taurus/js/plugins/maskedinput/jquery.maskedinput.min.js",
				"resources/taurus/js/plugins/stepy/jquery.stepy.min.js",
				"resources/taurus/js/plugins/fullcalendar/fullcalendar.min.js",
				"resources/taurus/js/js.js",
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
				"resources/mystyle/js/list-dosen-mahasiswa.js"
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				"resources/mystyle/css/classroom.css"
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
	//registrasi
	
	
	public function getJsonDataPersonal(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$temp = $this->mahasiswa->getDataPersonal();
		$temp2="{";
		$temp2.=$this->getGenerateSimpleJson("nama", $temp['nama']).",";
		$temp2.=$this->getGenerateSimpleJson("nim", $temp['nim']).",";
		$temp2.=$this->getGenerateSimpleJson("nohp", $temp['nohp']).",";
		$temp2.=$this->getGenerateSimpleJson("email", $temp['email']).",";
		$temp2.=$this->getGenerateSimpleJson("ortu", $temp['ortu']).",";
		$temp2.=$this->getGenerateSimpleJson("nohportu", $temp['nohportu']).",";
		$temp2.=$this->getGenerateSimpleJson("minat", $temp['minat']);
		$temp2.="}";
		echo $temp2;
		return true;
	}
	public function getJsonDataTA(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$temps = $this->mahasiswa->getCodeRegLastTA();
		if($temps[0]){
			$temp = $this->mahasiswa->getTAInfo($temps[1],array('judulta',"dosbing"));
			$temp2="{";
			$temp2.=$this->getGenerateSimpleJson("judulta", $temp[1]['judulta']).",";
			$temp2.=$this->getGenerateSimpleJson("dosbing", $temp[1]['dosbing']);
			$temp2.="}";
			echo $temp2;
			return true;
		}else{
			$temp2="{";
			$temp2.=$this->getGenerateSimpleJson("judulta", null).",";
			$temp2.=$this->getGenerateSimpleJson("dosbing", null);
			$temp2.="}";
			echo $temp2;
			return true;
		}
	}
	public function getListDosenAktif(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view('Classroom_room/Body_right/lihat_dosen');
	}
	public function getTableListDosen(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->isNullPost('kode');
		$kode = $this->input->post('kode');
		if($kode != 'JASERVTECH-KODE')
			exit("0anda melakukan debugging terhadap system");
		$temp = $this->dosen->getListDosen();
		$i=1;
		$strings="";
		foreach($temp as $value){
			$strings .= "<tr><td>".$i."</td><td>";
			$strings .= $value['id']."</td><td>" ;
			$strings .= $value['nama']."</td>" ;
			$strings .= "
						<td>
							<div style='text-align : center;'>
								<div class='col-md-6'>
									<span class='icon-eye-open pointer' onclick='seeThisGuys(".'"'.$value['id'].'"'.");' style='color : green' title='Lihat Profil Dosen : ya'></span>
								</div>
								";
			if($this->mahasiswa->getIsMyDosenReview($value['id']))
				$strings .=	"
								<div class='col-md-6'>
									<span class='icon-thumbs-up pointer' onclick='beNotMyFavorThisGuys(".'"'.$value['id'].'"'.",2)' style='color:green' title='Dosen Favorit : ya'></span>
								</div>
								";
			else 

				$strings .=	"
								<div class='col-md-6'>
									<span class='icon-thumbs-up pointer' onclick='beMyFavorThisGuys(".'"'.$value['id'].'"'.",2)' style='color:red' title='Dosen Favorit : tidak'></span>
								</div>
								";
			$strings .= "
							</div>
						</td></tr>
					";
			$i++;
		}
		echo "1".$strings;
	}
	public function getInfoDosenFull(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->isNullPost('kode');
		$this->isNullPost('nip');
		$temp = $this->input->post('kode');
		if($temp != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$this->dosen->getCheckNip($this->input->post('nip'),1)[0])
			exit('0anda melakukan debugging terhadap system');
		$temp = $this->dosen->getDosenInfo($this->input->post('nip'));
		if(!$temp[0])
			exit("0anda melakukan debugging terhadap system");
		$intNo = 1;
		$yourTable = null;
		foreach ($this->mahasiswa->getTableDosenReview() as $key => $value){
			if(intval($value) != 0){
				$yourTable[$key][0] = $intNo;
				$yourTable[$key][1] = $value;
				$yourTable[$key][2] = $this->dosen->getDosenName($value)['nama'];
				$intNo++;
			}
		}
		$data = array(
				'nip' => $temp[1]['nip'],
				'nama' => $temp[1]['nama'],
				'bidris' => $temp[1]['bidris'],
				'alamat' => $temp[1]['alamat'],
				'email' => $temp[1]['email'],
				'notelp' => $temp[1]['notelp'],
				'mydosen' => $this->mahasiswa->getIsMyDosenReview($temp[1]['nip']),
				'favorite' => $yourTable
		);
		echo "1";
		$this->load->view('Classroom_room/Body_right/Info_dosen_view',$data);
	}
	public function setLikeThisGuys(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$nip = $this->isNullPost('nip');
		$kode = $this->isNullPost('kode');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap program');
		$temp = $this->dosen->getCheckNip($nip,1);
		if(!$temp[0])
			exit("0".$temp[1]);
		$temp = $this->mahasiswa->setAddNewFavor($nip);
	}
	public function setNotLikeThisGuys(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$nip = $this->isNullPost('nip');
		$kode = $this->isNullPost('kode');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap program');
		$temp = $this->dosen->getCheckNip($nip,1);
		if(!$temp[0])
			exit("0".$temp[1]);
		$temp = $this->mahasiswa->setRemoveOldFavor($nip);
	}
	protected function getGenerateSimpleJson($a,$b){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if($b === NULL){
			return '"'.$a.'" : { "status" : false, "value" : null}';
		}else{
			return '"'.$a.'" : { "status" : true, "value" : "'.$b.'"}';
		}
	}
	public function getLayoutTaS(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view("Classroom_room/Body_right/seminar_ta1");
	}
	//registrasi baru
	public function getLayoutRegistrasiBaru(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			$TEMP_ARRAY['message'] = "Maaf, anda sudah melakukan registrasi, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return;
		}
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
			echo"0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return ;
		}
		
		$ARRAY_CODE = $this->mahasiswa->getCodeRegLastTA();
		if($ARRAY_CODE[0]){//valid
			$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
			if($this->sc_sm->getResultForceRegistration()){
				$TEMP_ARRAY = NULL;
				$TEMP_ARRAY['peminatan'] = $this->mahasiswa->getListPeminatan(); 
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_baru",$TEMP_ARRAY);	
			}else{
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Telah ditemukan data Ta anda, anda yakin ingin membuat baru? konsultasikan dengan dosen pembimbing anda. dan kontak admin(mbak nisa untuk mengaktifkan perubahan)',
						'but2' => 'form lama'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
			}
		}else{	
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if($this->sc_st->getHaveLastTAInfo()){
				$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
				if($this->sc_sm->getResultForceRegistration()){
					$TEMP_ARRAY = NULL;
					$TEMP_ARRAY['peminatan'] = $this->mahasiswa->getListPeminatan(); 
					echo "1";
					$this->load->view("Classroom_room/Body_right/registrasi_baru",$TEMP_ARRAY);	
				}else{
					echo "3";
					$TEMP_ARRAY = array(
							'message' => 'Anda sudah melakukan registrasi pada semster ini, silahkan lanjut ke registrasi TA lama karena anda adalah mahasiswa TA lama',
							'but2' => 'form lama'
					);
					$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
					return ;
				}
			}else{		
				$TEMP_ARRAY = NULL;
				$TEMP_ARRAY['peminatan'] = $this->mahasiswa->getListPeminatan(); 
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_baru",$TEMP_ARRAY);	
			}		
		}
	}
	/*registrasi lama*/
	public function getLayoutRegistrasiLama(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			$TEMP_ARRAY['message'] = "Maaf, anda sudah melakukan registrasi, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return;
		}
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
			echo"0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return ;
		}
		$ARRAY_CODE = $this->mahasiswa->getCodeRegLastTA();
		if($ARRAY_CODE[0]){ //true if have last data before
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if($this->sc_st->getHaveLastTAInfo()){
				$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
				if($this->sc_sm->getResultForceRegistration(2)){
					$TEMP_ARRAY['listdosen'] = $this->dosen->getListDosen();
					echo "1";
					$this->load->view("Classroom_room/Body_right/registrasi_lama",$TEMP_ARRAY);
				}else{
					echo "3";
					$TEMP_ARRAY = array(
							'message' => 'Judul Ta anda tidak ditemukan dimanapun, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
							'but2' => 'form baru'
					);
					$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
					return ;
				}
			}else{			
				$TEMP_ARRAY['listdosen'] = $this->dosen->getListDosen();
				echo "1";
				$this->load->view("Classroom_room/Body_right/registrasi_lama",$TEMP_ARRAY);
			}
		}else{
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if($this->sc_st->getHaveLastTAInfo()){
				$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
				if($this->sc_sm->getResultForceRegistration(2)){
					$TEMP_ARRAY['listdosen'] = $this->dosen->getListDosen();
					echo "1";
					$this->load->view("Classroom_room/Body_right/registrasi_lama",$TEMP_ARRAY);
				}else{
					echo "3";
					$TEMP_ARRAY = array(
							'message' => 'Judul Ta anda tidak ditemukan dimanapun, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
							'but2' => 'form baru'
					);
					$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
					return ;
				}
			}else{					
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Judul Ta anda tidak ditemukan dimanapun, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa) lihat petunjuk registrasi lama dan baru pada bantuan',
						'but2' => 'form baru'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
			}
		}
	}
	/**/
	//methode return view of Home - vaid 
	public function getLayoutHome(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->load->view("Classroom_room/Body_right/home");
	}
	//check any post is NULL , and if not NULL will be return - valid
	protected function isNullPost($a){
		if($this->input->post($a)===NULL)
			exit('0anda melakukan percobaan terhadap halaman, jangan lakukan itu');
		return $this->input->post($a);
	}
	//registrasi lama proses and get result of process
	public function getResultRegistrasiLama(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			exit("0Anda mencoba register secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		//filter
		$ARRAY_CODE = $this->mahasiswa->getCodeRegLastTA();
		if($ARRAY_CODE[0]){ //true if have last data before
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if($this->sc_st->getHaveLastTAInfo()){
				$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
				if(!$this->sc_sm->getResultForceRegistration(2)){
					echo "0Anda melakukan perubahan secara paksa menggunakan form yang berbeda";
					return;
				}
			}
		}else{
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if($this->sc_st->getHaveLastTAInfo()){
				$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
				if(!$this->sc_sm->getResultForceRegistration(2)){
					echo "0Anda melakukan perubahan secara paksa menggunakan form yang berbeda";
					return;
				}
			}else{
					echo "0Anda melakukan perubahan secara paksa menggunakan form yang berbeda";
					return;
			}
		}
		//execute
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			exit("0Anda mencoba registrasi secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		$tempDataPersonal = $this->mahasiswa->getDataPersonal();
		$tempDataTa = $this->mahasiswa;
		//Nama
		if($tempDataPersonal['nama'] === NULL){
			$this->isNullPost('lama-nama');
			$dataTemp['nama'] = $this->input->post('lama-nama');
			$this->getCheck('lama-nama',$dataTemp['nama'],true);
		}else{
			$dataTemp['nama'] = $tempDataPersonal['nama'];
		}
		//Nim
		if($tempDataPersonal['nim'] === NULL){
			$this->isNullPost('lama-nim');
			$dataTemp['nim'] = $this->input->post('lama-nim');
			$this->getCheck('lama-nim',$dataTemp['nim'],true);
		}else{
			$dataTemp['nim'] = $tempDataPersonal['nim'];
		}
		//Email
		if($tempDataPersonal['email'] === NULL){
			$this->isNullPost('lama-email');
			$dataTemp['email'] = $this->input->post('lama-email');
			$this->getCheck('lama-email',$dataTemp['email'],true);
		}else{
			$dataTemp['email'] = $tempDataPersonal['email'];
		}
		//nohp
		if($tempDataPersonal['nohp'] === NULL){
			$this->isNullPost('lama-nohp');
			$dataTemp['nohp'] = $this->input->post('lam-nohp');
			$this->getCheck('lama-nohp',$dataTemp['nohp'],true);
		}else{
			$dataTemp['nohp'] = $tempDataPersonal['nohp'];
		}
		//nohportu
		if($tempDataPersonal['nohportu'] === NULL){
			$this->isNullPost('lama-nohportu');
			$dataTemp['nohportu'] = $this->input->post('lama-nohportu');
			$this->getCheck('lama-nohportu',$dataTemp['nohportu'],true);
		}else{
			$dataTemp['nohportu'] = $tempDataPersonal['nohportu'];
		}
		//ortu
		if($tempDataPersonal['ortu'] === NULL){
			$this->isNullPost('lama-ortu');
			$dataTemp['ortu'] = $this->input->post('lama-ortu');
			$this->getCheck('lama-ortu',$dataTemp['ortu'],true);
		}else{
			$dataTemp['ortu'] = $tempDataPersonal['ortu'];
		}
		$temps = $this->mahasiswa->getCodeRegLastTA();
		if(!$temps[0]){
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if(!$this->sc_st->getHaveLastTAInfo($this->mahasiswa->getYearNow())){				
				echo "0Maaf, anda mencoba memasukan paksa form registrasi lama";
				return ;
			}else{
				$temps[1] = $this->mahasiswa->getYearNow();
			}
		}
		$dataTemp['codeRegist'] = $temps[1];
		$dataTemp['codereg'] = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		/*
		$temp = $this->mahasiswa->getTAInfo($temps[1],array('judulta',"dosbing"));
		if($temp[1]['judulta'] === NULL){
			$this->isNullPost('lama-judulta');
			$dataTemp['judulta'] = $this->input->post('lama-judulta');
			$this->getCheck('lama-judulta',$dataTemp['judulta'],true);
		}else{
			$dataTemp['judulta'] = $temp[1]['judulta'];
		}*/
		$this->isNullPost('lama-judulta');
		$dataTemp['judulta'] = $this->input->post('lama-judulta');
		$this->getCheck('lama-judulta',$dataTemp['judulta'],true);
		/*
		if($temp[1]['dosbing'] === NULL){
			$this->isNullPost('lama-dosbing');
			$dataTemp['dosbing'] = $this->input->post('lama-dosbing');
			$this->getCheck('lama-dosbing',$dataTemp['dosbing'],true);
		}else{
			$dataTemp['dosbing'] = $temp[1]['dosbing'];
		}
		*/
		//$this->isNullPost('lama-dosbing');
		$dataTemp['dosbing'] = $this->input->post('lama-dosbing');
		$dataTemp['newf'] = 2;
		$dataTemp['krs'] = 'lama-krs';
		//$this->getCheck('lama-dosbing',$dataTemp['dosbing'],true);
		
		//foreach($dataTemp as $key=>$value)
			//echo $key." = ".$value."<br>";
		//exit("0jojojo");
		$temp = $this->mahasiswa->setRegistrasiLama($dataTemp);
		if(!$temp[0]){
			echo "0".$temp[1];
		}else{
			echo "1";
			$data['data'] = "Data berhasil dimasukan, terima kasih atas waktunya";
			$this->load->view("Classroom_room/Body_right/success_registrasi",$data);
		}
	}
	public function getResultRegistrasiBaru(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			exit("0Anda mencoba register secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		$ARRAY_CODE = $this->mahasiswa->getCodeRegLastTA();
		if($ARRAY_CODE[0]){//valid
			$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
			if(!$this->sc_sm->getResultForceRegistration()){
				echo "0Anda melakukan perubahan secara paksa menggunakan form yang berbeda";
				return;
			}
		}else{
			$this->sc_st->resetValue();
			$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_st->setKode($this->mahasiswa->getYearNow());
			if($this->sc_st->getHaveLastTAInfo()){
				$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
				if(!$this->sc_sm->getResultForceRegistration()){
					echo "0Anda melakukan perubahan secara paksa menggunakan form yang berbeda";
					return;
				}
			}
		}		
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			exit("0Anda mencoba registrasi secara paksa, tolong jangan lakukan itu, terima kasih");
		}
		$tempDataPersonal = $this->mahasiswa->getDataPersonal();
		//Nama
		if($tempDataPersonal['nama'] === NULL){
			$this->isNullPost('baru-nama');
			$dataTemp['nama'] = $this->input->post('baru-nama');
			$this->getCheck('baru-nama',$dataTemp['nama'],true);	
		}else{
			$dataTemp['nama'] = $tempDataPersonal['nama'];		
		}
		//Nim
		if($tempDataPersonal['nim'] === NULL){
			$this->isNullPost('baru-nim');
			$dataTemp['nim'] = $this->input->post('baru-nim');
			$this->getCheck('baru-nim',$dataTemp['nim'],true);
		}else{
			$dataTemp['nim'] = $tempDataPersonal['nim'];
		}
		//Email
		if($tempDataPersonal['email'] === NULL){
			$this->isNullPost('baru-email');
			$dataTemp['email'] = $this->input->post('baru-email');
			$this->getCheck('baru-email',$dataTemp['email'],true);
		}else{
			$dataTemp['email'] = $tempDataPersonal['email'];
		}
		//minat
		if($tempDataPersonal['minat'] === NULL){
			$this->isNullPost('baru-minat');
			$dataTemp['minat'] = $this->input->post('baru-minat');
			$this->getCheck('baru-minat',$dataTemp['minat'],true);
		}else{
			$dataTemp['minat'] = $tempDataPersonal['minat'];
		}
		//nohp
		if($tempDataPersonal['nohp'] === NULL){
			$this->isNullPost('baru-nohp');
			$dataTemp['nohp'] = $this->input->post('baru-nohp');
			$this->getCheck('baru-nohp',$dataTemp['nohp'],true);
		}else{
			$dataTemp['nohp'] = $tempDataPersonal['nohp'];
		}
		//nohportu
		if($tempDataPersonal['nohportu'] === NULL){
			$this->isNullPost('baru-nohportu');
			$dataTemp['nohportu'] = $this->input->post('baru-nohportu');
			$this->getCheck('baru-nohportu',$dataTemp['nohportu'],true);
		}else{
			$dataTemp['nohportu'] = $tempDataPersonal['nohportu'];
		}
		//ortu
		if($tempDataPersonal['ortu'] === NULL){
			$this->isNullPost('baru-ortu');
			$dataTemp['ortu'] = $this->input->post('baru-ortu');
			$this->getCheck('baru-ortu',$dataTemp['ortu'],true);
		}else{
			$dataTemp['ortu'] = $tempDataPersonal['ortu'];
		}
		//
		$this->isNullPost('baru-judulta');
		$dataTemp['judulta'] = $this->input->post('baru-judulta');
		$this->getCheck('baru-judulta',$dataTemp['judulta'],true);

		$this->isNullPost('baru-lokasi');
		$dataTemp['lokasi'] = $this->input->post('baru-lokasi');
		$this->getCheck('baru-lokasi',$dataTemp['lokasi'],true);
		
		$this->isNullPost('baru-metode');
		$dataTemp['metode'] = $this->input->post('baru-metode');
		$this->getCheck('baru-metode',$dataTemp['metode'],true);
		$this->isNullPost('baru-ref1');
		$dataTemp['ref1'] = $this->input->post('baru-ref1'); 
		$this->getCheck('baru-ref1',$dataTemp['ref1'],true);
		if($this->input->post('baru-ref2') === null)
			$dataTemp['ref2'] = "";
		else {
			$dataTemp['ref2'] = $this->input->post('baru-ref2');
			if($dataTemp['ref2'] != "")
				$this->getCheck('baru-ref2',$dataTemp['ref2'],true);
		}
		if($this->input->post('baru-ref3') === null)
			$dataTemp['ref3'] = ""; 
		else {
			$dataTemp['ref3'] = $this->input->post('baru-ref3');
			if($dataTemp['ref3'] != "")
				$this->getCheck('baru-ref3',$dataTemp['ref3'],true);	
		}
		$dataTemp['krs'] = 'baru-krs';
		$dataTemp['codereg'] = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		
		$this->sc_sm->getDataNim($this->session->userdata('nim'));
		if(intval($this->sc_sm->getForceRegLama()) == 1){
			$dataTemp['newf'] = 1;
		}else{
			$dataTemp['newf'] = 2;
		}
		//foreach($dataTemp as $k => $value){
		//	echo $k." ".$value."<br>";
		//}
		$temp = $this->mahasiswa->setRegistrasiBaru($dataTemp);
		if(!$temp[0]){
			echo "0".$temp[1];
		}else{
			echo "1";
			$data['data'] = "Data berhasil dimasukan, terima kasih atas waktunya";
			$this->load->view("Classroom_room/Body_right/success_registrasi",$data);
		}
		//echo 'succes';
		return;
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
			case 'lama-nim' :
			case 'baru-nim' :
				if($type){
					$temp = $this->mahasiswa->getCheckNim($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckNim($value);
				break;
			case 'lama-nama' : 
			case 'baru-nama' :
			case 'baru-ortu' :
			case 'lama-ortu' :
				if($type){
					$temp = $this->mahasiswa->getCheckName($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckName($value);
				break;
			case 'lama-email' :
			case 'baru-email' :
				if($type){
					$temp = $this->mahasiswa->getCheckEmail($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckEmail($value);
				break;
			case 'baru-nohp' :
			case 'lama-nohp' :
			case 'baru-nohportu' :
			case 'lama-nohportu' :
				if($type){
					$temp = $this->mahasiswa->getCheckNuTelphone($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckNuTelphone($value);
				break;
			case 'lama-dosbing'	:
				if($type){
					if(intval($value) == 0)
						exit("0Tidak boleh kosong");
					$temp = $this->dosen->getIsNipExistActive($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->dosen->getIsNipExistActive($value);
				break;
			case 'baru-minat' :
				if($type){
					$temp = $this->mahasiswa->getCheckInterested($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckInterested($value);
				break;
			case 'baru-ref1' :
			case 'baru-ref2' :
			case 'baru-ref3' :
				if($type){
					$temp = $this->mahasiswa->getCheckRefrence($value,1);
					if(!$temp[0]){
						exit("0jj".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckRefrence($value);
				break;
			case 'baru-judulta' :
			case 'lama-judulta' :
				if($type){
					$temp = $this->mahasiswa->getCheckTitleFinalTask($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckTitleFinalTask($value);
				break;
			case 'baru-metode' :
				if($type){
					$temp = $this->mahasiswa->getCheckMethode($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckMethode($value);
				break;
			case 'baru-lokasi' :
				if($type){
					$temp = $this->mahasiswa->getCheckLokasi($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckLokasi($value);
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}