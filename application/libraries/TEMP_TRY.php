<?php
	public function getLayoutRegistrasiLama(){
		if(!$this->mahasiswa->getStatusLoginMahasiswa())
			redirect(base_url().'Gateinout.aspx');
		$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
		//check is register permission
		if(!$this->sc_sm->getCheckFormRegistrasiPemission()){
			$TEMP_ARRAY['message'] = "Maaf, anda sudah melakukan registrasi, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return;
		}
		$CODE_PERMISSION = "1";
		//check is register Time
		if(!$this->sc_ea->getIsRegisterTime(date("Y-m-d"))){
			$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
			echo"0";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return ;
		}
		//check data from other semester before
		$ARRAY_CODE = $this->mahasiswa->getCodeRegLastTA();
		if($ARRAY_CODE[0]){
			$CODE_PERMISSION .= "1"; 
		}else{
			$CODE_PERMISSION .= "2";
		}
		//check if is registerer on this Academic Year
		$this->sc_st->resetValue();
		$this->sc_st->setNim($this->mahasiswa->getNimSessionLogin());
		$this->sc_st->setKode($this->mahasiswa->getYearNow());
		$TEMP_BOOLEAN = $this->sc_st->getHaveLastTAInfo();
		if($TEMP_BOOLEAN){
			$CODE_PERMISSION .= "1";
		}else{
			$CODE_PERMISSION .= "2";
		}
		//filltering code
		if(!$TEMP_ARRAY[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 111 :
				case 122 :
				//registerasi baru
				break;
				case 121 :
				case 112 :
				//neutrallized
				break;
			}
		}else if(!$TEMP_ARRAY[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 111 :
				//neutrallized
				break;
				case 121 :
				//registerasi lama
				break;
				case 112 :
				//registerasi baru
				break;
			}
		}else if($TEMP_ARRAY[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				//registerasi lama
				break;
				case 112 :
				//registrasi baru
				break;
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}else if($TEMP_BOOLEAN && $TEMP_ARRAY[0]){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				//registerasi baru
				break;
				case 122 :
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}
		
		
		if($ARRAY_CODE[0]){ //true if have last data before
		//exit("0ARRAY_CDOE = ".$ARRAY_CODE[1]);
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
				if($this->sc_sm->getResultForceRegistration()){
					echo "3";
					$TEMP_ARRAY = array(
							'message' => 'Anda diberi wewenang melakukan perubahan TA baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
							'but2' => 'form baru'
					);
					$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
					return ;
				}else{
					$TEMP_ARRAY['listdosen'] = $this->dosen->getListDosen();
					echo "1";
					$this->load->view("Classroom_room/Body_right/registrasi_lama",$TEMP_ARRAY);
				}
			}else{		
				$this->sc_sm->setNim($this->mahasiswa->getNimSessionLogin());
				if($this->sc_sm->getResultForceRegistration()){
					echo "3";
					$TEMP_ARRAY = array(
							'message' => 'Anda diberi wewenang melakukan perubahan TA baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa)',
							'but2' => 'form baru'
					);
					$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
					return ;
				}else{
					$TEMP_ARRAY['listdosen'] = $this->dosen->getListDosen();
					echo "1";
					$this->load->view("Classroom_room/Body_right/registrasi_lama",$TEMP_ARRAY);
				}
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
						'message' => 'Judul Ta anda aaaaa tidak ditemukan dimanapun, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi akademik(Mbak Nisa) lihat petunjuk registrasi lama dan baru pada bantuan',
						'but2' => 'form baru'
				);
				$this->load->view("Classroom_room/Body_right/warning-one-button-registrasi",$TEMP_ARRAY);
				return ;
			}
		}
	}