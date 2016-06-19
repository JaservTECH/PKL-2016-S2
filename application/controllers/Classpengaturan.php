<?php
	if(!defined('BASEPATH'))
		exit("You don't have accsees to this site");
	class Classpengaturan extends CI_Controller {
		public function __CONSTRUCT(){
			parent::__CONSTRUCT();
			$this->load->library("mahasiswa");
			$this->load->library("view");
			$this->load->helper("url");
			$this->load->model("sc_sm");
		}
		public function getJsonProfile(){
			if(!$this->mahasiswa->getStatusLoginMahasiswa())
				redirect(base_url().'Gateinout.aspx');
			$this->sc_sm->resetValue();
			$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
			$data['state'] = false;
			if($this->sc_sm->getDataNim()){
				$data['nama'] = $this->sc_sm->getName();
				$data['nim'] = $this->sc_sm->getNim();
				$data['email'] = $this->sc_sm->getEmail();
				$data['nohp'] = $this->sc_sm->getNohp();
				$data['ortu'] = $this->sc_sm->getNamaOrtu();
				$data['nohportu'] = $this->sc_sm->getNoHpOrtu();
				$data['state'] = true;
			}
			echo json_encode($data);
		}
		public function setNewPassword(){
			if(!$this->mahasiswa->getStatusLoginMahasiswa())
				redirect(base_url().'Gateinout.aspx');
			$passwordLama = $this->view->isNullPost("password-old");
			$passwordNew = $this->view->isNullPost("password-new");
			$passwordNewCon = $this->view->isNullPost("password-new-confirm");
			$ERROR = 0;
			$ERRORMESSAGE = "";
			if(!$this->mahasiswa->getCheckPassword($passwordLama,1)[0]){
				$ERRORMESSAGE .= "password lama tidak valid,";
				$ERROR += 1;	
			}
			if(!$this->mahasiswa->getCheckPassword($passwordNew,1)[0]){
				$ERRORMESSAGE .= "password baru tidak valid,";
				$ERROR += 1;	
			}
			if(!$this->mahasiswa->getCheckPassword($passwordNewCon,1)[0]){
				$ERRORMESSAGE .= "password baru confirmasi tidak valid,";
				$ERROR += 1;	
			}
			if($ERROR > 0)
				exit("0".$ERRORMESSAGE);
			if($passwordNew != $passwordNewCon){
				exit("0Password baru tidak sama dengan password confiirmasinya");
			}
			$this->sc_sm->resetValue();
			$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
			if(!$this->sc_sm->getDataNim()){
				redirect(base_url().'Gateinout.aspx');
			}
			if($this->sc_sm->getPassword() != md5($passwordLama)){
				exit("0Password lama anda tidak sesuai");
			}
			$this->sc_sm->resetValue();
			$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_sm->setPassword(md5($passwordNew));
			if(!$this->sc_sm->updateData()){
				exit("0Gagal melakukan perubahan terhadap password");
			}
			exit("1Proses perubahan berhasil");
		}
		public function setNewProfile(){
			if(!$this->mahasiswa->getStatusLoginMahasiswa())
				redirect(base_url().'Gateinout.aspx');
			if(!$this->mahasiswa->getCheckName($dataNama,1)[0]){
				exit("0Nama anda tidak sesuai dengan format nama");
			}
			$filename = "";
			if($this->input->post("data-gambar") !== NULL){			
				$conPic['upload_path'] = './upload/foto/';	
				$conPic['allowed_types'] = 'png|jpg'; 
				$conPic['file_name'] = $this->mahasiswa->getNimSessionLogin()."-foto";	
				$conPic['overwrite'] = true; 
				$conPic['remove_spaces'] = true; 
				$conPic['max_size'] = 500;	
				$conPic['max_width'] = 800;	
				$conPic['max_height'] = 600; 
				$this->load->library('upload');
				//$this->load->library('upload',$conPic);
				$this->upload->initialize($conPic);
				if(!$this->upload->do_upload($data['foto'])){
					exit('0Gagal upload foto, format yang didukung png dan jpg, maksimal resolusi 800 x 600 pixel, dengan ukuran file 500kb');		
				}	
				$filename = $this->upload->data('file_name');
			}
			if($filename == ""){
				exit("0data kosong, silahkan pilih jika ingin merubah");
			}
			$this->sc_sm->resetValue();
			$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_sm->setFotoname($filename);
			$this->sc_sm->updateData();
			exit("1data berhasil dirubah");
		}
		public function dataSupport(){
			if(!$this->mahasiswa->getStatusLoginMahasiswa())
				redirect(base_url().'Gateinout.aspx');
			$email = $this->view->isNullPost("support-email");
			$nohp = $this->view->isNullPost("support-no-hp");
			$namaortu = $this->view->isNullPost("support-nama-ortu");
			$otunohp = $this->view->isNullPost("support-no-hp-ortu");
			if(!$this->mahasiswa->getCheckEmail($email,1)[0]){
				exit("0Email tidak valid");
			}
			if(!$this->mahasiswa->getCheckNuTelphone($nohp,1)[0]){
				exit("0No hp anda tidak valid");
			}
			if(!$this->mahasiswa->getCheckNuTelphone($otunohp,1)[0]){
				exit("0No hp orang tua anda tidak valid");
			}
			if(!$this->mahasiswa->getCheckName($namaortu,1)[0]){
				exit("0Format nama tidak valid");
			}
			$this->sc_sm->resetValue();
			$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
			$this->sc_sm->setNohp($nohp);
			$this->sc_sm->setNamaOrtu($namaortu);
			$this->sc_sm->setNoHpOrtu($otunohp);
			$this->sc_sm->setEmail($email);
			$this->sc_sm->updateData();
			exit("1data berhasl dirubah");
		}
	}