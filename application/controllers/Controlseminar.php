<?php
if(!defined("BASEPATH")) exit("You don't have permission");
class Controlseminar extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("koordinator");
		$this->load->library("dosen");
		$this->load->library("mahasiswa");
		$this->load->library("view");
		$this->load->model("sc_st");
		$this->load->model("sc_std");
		$this->load->model("sc_sd");
		$this->load->model("sc_sm");
		$this->load->model("sc_sm_interest");
	}
	public function getLayoutSeminar(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		echo"1";
		$this->load->view("Controlroom_room/Body_right/Seminar.php");
	}
	public function getTableSeminarTA1(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$this->sc_std->resetValue();
		$this->sc_std->setKode($srt);
		$this->sc_std->setKategori(1);
		$data="";
		if($this->sc_std->getAllSeminarTAAktif()){
			$i=1;
			if($this->sc_std->getNextCursor()){
				//exit(var_dump($this->sc_std->TEMP_RESULT_ARRAY));
				$data .= "<tr>";
				$this->sc_sm->resetValue();
				$this->sc_sm->setNim($this->sc_std->getNim());
				$this->sc_sm->getDataNim();
				$this->sc_sm_interest->resetValue();
				$this->sc_sm_interest->setId($this->sc_sm->getPeminatan());
				$this->sc_sm_interest->getMinat();
				$this->sc_st->resetValue();
				$this->sc_st->setKode($this->sc_std->getKode());
				$this->sc_st->setNim($this->sc_sm->getNim());
				$this->sc_st->getDataActiveRegister();
				$this->sc_sd->resetValue();
				$this->sc_sd->setNip($this->sc_st->getNip());
				$this->sc_sd->getDosenInfo();
				$data.="<td>".$i."</td><td>".$this->sc_sm->getNim()."</td><td>".$this->sc_sm->getName()."</td><td>".$this->sc_sm_interest->getName()."</td><td>".$this->sc_sd->getNama()."</td><td><div class='row'>";
				if($this->sc_std->getDocppp() == '2'){
				$data .= "<div class='col-md-3'>".
				"<span style='color : green;' title='rekomendasi'><i class='icon-map-marker'></i></span></div>";
				}else{
				$data .= "<div class='col-md-3'>".
				"<span style='color : red;' title='tidak direkomendasikan'><i class='icon-map-marker'></i></span></div>";
				}
				if($this->sc_std->getDocp() != "" && $this->sc_std->getDocp() != " "){
				$data.="<div class='col-md-2'>".
				"<span style='color : green;' class='pointer' title='sudah mengumpulkan surat pengantar'  onclick='showPdfTA1(".'"'.$this->sc_std->getDocp().'"'.")'><i class='icon-file-alt'></i></span>".
				"</div>";	
				}else{
				$data.="<div class='col-md-2'>".
				"<span style='color : red;' title='belum mengumpulkan surat pengantar'><i class='icon-file-alt'></i></span>".
				"</div>";		
				}
				if($this->sc_std->getDocbta() != "" && $this->sc_std->getDocbta() != " "){
				$data.="<div class='col-md-2'>".
				"<span style='color:green' class='pointer'  title='sudah mengumpulkan kartu bimbingan' onclick='showImageTA1(".'"'.$this->sc_std->getDocbta().'"'.")'><i class='icon-picture'></i></span>".
				"</div>";	
				}else{
				$data.="<div class='col-md-2'>".
				"<span style='color:red' title='belum mengumpulkan kartu bimbingan'><i class='icon-picture'></i></span>".
				"</div>";	
				}
				if($this->sc_std->getDocpta() != "" && $this->sc_std->getDocpta() != " "){
				$data .= "<div class='col-md-2'>".
				"<span style='color : green;' class='pointer'  title='sudah mengumpulkan kartu ikut seminar' onclick='showImageTA1(".'"'.$this->sc_std->getDocpta().'"'.")'><i class='icon-picture'></i></span>".
				"</div>";	
				}else{
				$data .= "<div class='col-md-2'>".
				"<span style='color : red;' title='belum mengumpulkan kartu ikut seminar'><i class='icon-picture'></i></span>".
				"</div>";	
				}
				if($this->sc_std->getDocTranskrip() != "" && $this->sc_std->getDocTranskrip() != " "){
				$data.="<div class='col-md-3'>".
				"<span style='color : green;' class='pointer'  title='sudah mengumpulkan transkrip' onclick='showPdfTA1(".'"'.$this->sc_std->getDocTranskrip().'"'.")'><i class='icon-file-alt'></i></span>".
				"</div>";
				}else{
				$data.="<div class='col-md-3'>".
				"<span style='color : red;' title='belum mengumpulkan transkrip'><i class='icon-file-alt'></i></span>".
				"</div>";
				}
				$data.="</div></td><td>";
				$data.="<select onchange='seminarTA1Agreement(".'"'.$this->sc_sm->getNim().'"'.",this)'>";
				if($this->sc_std->getDataProses() == '1'){
					$data.="<option value='1' selected>menunggu</option>";
				}else{
					$data.="<option value='1'>menunggu</option>";
				}
				if($this->sc_std->getDataProses() == '2'){
					$data.="<option value='2' selected>disetujui</option>";
				}else{
					$data.="<option value='2'>disetujui</option>";
				}
				if($this->sc_std->getDataProses() == '3'){
					$data.="<option value='3' selected>ditolak</option>";
				}else{
					$data.="<option value='3'>ditolak</option>";
				}
				$data.="</select>";
				$data.="</td>";
				$data.="</tr>";
				$i++;
				
				while($this->sc_std->getNextCursor()){
					$data .= "<tr>";
					$this->sc_sm->resetValue();
					$this->sc_sm->setNim($this->sc_std->getNim());
					$this->sc_sm->getDataNim();
					$this->sc_sm_interest->resetValue();
					$this->sc_sm_interest->setId($this->sc_sm->getPeminatan());
					$this->sc_sm_interest->getMinat();
					$this->sc_st->resetValue();
					$this->sc_st->setKode($this->sc_std->getKode());
					$this->sc_st->setNim($this->sc_sm->getNim());
					$this->sc_st->getDataActiveRegister();
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($this->sc_st->getNip());
					$this->sc_sd->getDosenInfo();
					$data.="<td>".$i."</td><td>".$this->sc_sm->getNim()."</td><td>".$this->sc_sm->getName()."</td><td>".$this->sc_sm_interest->getName()."</td><td>".$this->sc_sd->getNama()."</td><td><div class='row'>";
					if($this->sc_std->getDocppp() == '2'){
					$data .= "<div class='col-md-3'>".
					"<span style='color : green;' title='rekomendasi'><i class='icon-map-marker'></i></span></div>";
					}else{
					$data .= "<div class='col-md-3'>".
					"<span style='color : red;' title='tidak direkomendasikan'><i class='icon-map-marker'></i></span></div>";
					}
					if($this->sc_std->getDocp() != "" && $this->sc_std->getDocp() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan surat pengantar' onclick='showPdfTA1(".'"'.$this->sc_std->getDocp().'"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan surat pengantar'><i class='icon-file-alt'></i></span>".
					"</div>";		
					}
					if($this->sc_std->getDocbta() != "" && $this->sc_std->getDocbta() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color:green' class='pointer'  title='sudah mengumpulkan kartu bimbingan' onclick='showImageTA1(".'"'.$this->sc_std->getDocbta().'"'.")'><i class='icon-picture'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color:red' title='belum mengumpulkan kartu bimbingan'><i class='icon-picture'></i></span>".
					"</div>";	
					}
					if($this->sc_std->getDocpta() != "" && $this->sc_std->getDocpta() != " "){
					$data .= "<div class='col-md-2'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan kartu ikut seminar' onclick='showImageTA1(".'"'.$this->sc_std->getDocpta().'"'.")'><i class='icon-picture'></i></span>".
					"</div>";	
					}else{
					$data .= "<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan kartu ikut seminar'><i class='icon-picture'></i></span>".
					"</div>";	
					}
					if($this->sc_std->getDocTranskrip() != "" && $this->sc_std->getDocTranskrip() != " "){
					$data.="<div class='col-md-3'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan transkrip'  onclick='showPdfTA1(".'"'.$this->sc_std->getDocTranskrip().'"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";
					}else{
					$data.="<div class='col-md-3'>".
					"<span style='color : red;' title='belum mengumpulkan transkrip'><i class='icon-file-alt'></i></span>".
					"</div>";
					}
					$data.="</div></td><td>";
					$data.="<select onchange='seminarTA1Agreement(".'"'.$this->sc_sm->getNim().'"'.",this)'>";
					if($this->sc_std->getDataProses() == '1'){
						$data.="<option value='1' selected>menunggu</option>";
					}else{
						$data.="<option value='1'>menunggu</option>";
					}
					if($this->sc_std->getDataProses() == '2'){
						$data.="<option value='2' selected>disetujui</option>";
					}else{
						$data.="<option value='2'>disetujui</option>";
					}
					if($this->sc_std->getDataProses() == '3'){
						$data.="<option value='3' selected>ditolak</option>";
					}else{
						$data.="<option value='3'>ditolak</option>";
					}
					$data.="</select>";
					$data.="</td>";
					$data.="</tr>";
					$i++;
				}	
			}else{
				$data.="<tr>";
				$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
				$data.="</tr>";
			}
		}else{
			$data.="<tr>";
			$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
			$data.="</tr>";
		}
		echo "1".$data;
		
		
	}
	
	public function getTableSeminarTA2(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$this->sc_std->resetValue();
		$this->sc_std->setKode($srt);
		$this->sc_std->setKategori(2);
		$select2 = "<option value='0'>Belum dipilih</option>";
		$data="";
		if($this->sc_std->getAllSeminarTAAktif()){
			$i=1;
			if($this->sc_std->getNextCursor()){
				//exit(var_dump($this->sc_std->TEMP_RESULT_ARRAY));
				$data .= "<tr>";
				$this->sc_sm->resetValue();
				$this->sc_sm->setNim($this->sc_std->getNim());
				$this->sc_sm->getDataNim();
				$this->sc_sm_interest->resetValue();
				$this->sc_sm_interest->setId($this->sc_sm->getPeminatan());
				$this->sc_sm_interest->getMinat();
				$this->sc_st->resetValue();
				$this->sc_st->setKode($this->sc_std->getKode());
				$this->sc_st->setNim($this->sc_sm->getNim());
				$this->sc_st->getDataActiveRegister();
				$this->sc_sd->resetValue();
				$this->sc_sd->setNip($this->sc_st->getNip());
				$this->sc_sd->getDosenInfo();
				$TEMP_NIP = $this->sc_sd->getNip();
				$TEMP_NAME = $this->sc_sd->getNama();
				$this->sc_sd->resetValue();
				$this->sc_sd->getListDosenActive();
				
				$selectPS = $select2;
				//echo "<br>".var_dump($TEMP_DOSEN_PS->TEMP_RESULT_ARRAY)."<br>";
				while($this->sc_sd->getNextCursor()){
					if($this->sc_sd->getNip() != $TEMP_NIP){
						if($this->sc_sd->getNip() == $this->sc_std->getNips())
							$selectPS .= "<option selected value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";
						else
							$selectPS .= "<option value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";	
					}
				}
			
				$this->sc_sd->resetValue();
				$this->sc_sd->getListDosenActive();
				$selectPD = $select2;
				while($this->sc_sd->getNextCursor()){
					if($this->sc_sd->getNip() != $TEMP_NIP){
						if($this->sc_sd->getNip() == $this->sc_std->getNipd())
							$selectPD .= "<option selected value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";
						else
							$selectPD .= "<option value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";	
					}
				}
				$data.="<td>".$i."</td><td>".$this->sc_sm->getNim()."</td><td>".$this->sc_sm->getName()."</td><td>"."<select onchange='changePenguji1(".'"'.$this->sc_sm->getNim().'"'.",this)'>".$selectPS."</select>"."</td><td>"."<select onchange='changePenguji2(".'"'.$this->sc_sm->getNim().'"'.",this)'>".$selectPD."</select>"."</td><td>".$TEMP_NAME."</td><td><div class='row'>";
				if($this->sc_std->getDocppp() == '2'){
				$data .= "<div class='col-md-3'>".
				"<span style='color : green;' title='rekomendasi'><i class='icon-map-marker'></i></span></div>";
				}else{
				$data .= "<div class='col-md-3'>".
				"<span style='color : red;' title='tidak direkomendasikan'><i class='icon-map-marker'></i></span></div>";
				}
				if($this->sc_std->getDocp() != "" && $this->sc_std->getDocp() != " "){
				$data.="<div class='col-md-2'>".
				"<span style='color : green;' class='pointer' title='sudah mengumpulkan surat pengantar'  onclick='showPdfTA1(".'"'.$this->sc_std->getDocp().'"'.")'><i class='icon-file-alt'></i></span>".
				"</div>";	
				}else{
				$data.="<div class='col-md-2'>".
				"<span style='color : red;' title='belum mengumpulkan surat pengantar'><i class='icon-file-alt'></i></span>".
				"</div>";		
				}
				if($this->sc_std->getDocbta() != "" && $this->sc_std->getDocbta() != " "){
				$data.="<div class='col-md-2'>".
				"<span style='color:green' class='pointer'  title='sudah mengumpulkan kartu bimbingan' onclick='showImageTA1(".'"'.$this->sc_std->getDocbta().'"'.")'><i class='icon-picture'></i></span>".
				"</div>";	
				}else{
				$data.="<div class='col-md-2'>".
				"<span style='color:red' title='belum mengumpulkan kartu bimbingan'><i class='icon-picture'></i></span>".
				"</div>";	
				}
				if($this->sc_std->getDocpta() != "" && $this->sc_std->getDocpta() != " "){
				$data .= "<div class='col-md-2'>".
				"<span style='color : green;' class='pointer'  title='sudah mengumpulkan kartu ikut seminar' onclick='showImageTA1(".'"'.$this->sc_std->getDocpta().'"'.")'><i class='icon-picture'></i></span>".
				"</div>";	
				}else{
				$data .= "<div class='col-md-2'>".
				"<span style='color : red;' title='belum mengumpulkan kartu ikut seminar'><i class='icon-picture'></i></span>".
				"</div>";	
				}
				if($this->sc_std->getDocTranskrip() != "" && $this->sc_std->getDocTranskrip() != " "){
				$data.="<div class='col-md-3'>".
				"<span style='color : green;' class='pointer'  title='sudah mengumpulkan transkrip' onclick='showPdfTA1(".'"'.$this->sc_std->getDocTranskrip().'"'.")'><i class='icon-file-alt'></i></span>".
				"</div>";
				}else{
				$data.="<div class='col-md-3'>".
				"<span style='color : red;' title='belum mengumpulkan transkrip'><i class='icon-file-alt'></i></span>".
				"</div>";
				}
				$data.="</div></td><td>";
				$data.="<select onchange='seminarTA2Agreement(".'"'.$this->sc_sm->getNim().'"'.",this)'>";
				if($this->sc_std->getDataProses() == '1'){
					$data.="<option value='1' selected>menunggu</option>";
				}else{
					$data.="<option value='1'>menunggu</option>";
				}
				if($this->sc_std->getDataProses() == '2'){
					$data.="<option value='2' selected>disetujui</option>";
				}else{
					$data.="<option value='2'>disetujui</option>";
				}
				if($this->sc_std->getDataProses() == '3'){
					$data.="<option value='3' selected>ditolak</option>";
				}else{
					$data.="<option value='3'>ditolak</option>";
				}
				$data.="</select>";
				$data.="</td>";
				$data.="</tr>";
				$i++;
				
				while($this->sc_std->getNextCursor()){
					$data .= "<tr>";
					$this->sc_sm->resetValue();
					$this->sc_sm->setNim($this->sc_std->getNim());
					$this->sc_sm->getDataNim();
					$this->sc_sm_interest->resetValue();
					$this->sc_sm_interest->setId($this->sc_sm->getPeminatan());
					$this->sc_sm_interest->getMinat();
					$this->sc_st->resetValue();
					$this->sc_st->setKode($this->sc_std->getKode());
					$this->sc_st->setNim($this->sc_sm->getNim());
					$this->sc_st->getDataActiveRegister();
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($this->sc_st->getNip());
					$this->sc_sd->getDosenInfo();
					$TEMP_NIP = $this->sc_sd->getNip();
					$TEMP_NAME = $this->sc_sd->getNama();
					$this->sc_sd->resetValue();
					$this->sc_sd->getListDosenActive();
					
					$selectPS = $select2;
					//echo "<br>".var_dump($TEMP_DOSEN_PS->TEMP_RESULT_ARRAY)."<br>";
					while($this->sc_sd->getNextCursor()){
						if($this->sc_sd->getNip() != $TEMP_NIP){
							if($this->sc_sd->getNip() == $this->sc_std->getNips())
								$selectPS .= "<option selected value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";
							else
								$selectPS .= "<option value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";	
						}
					}
				
					$this->sc_sd->resetValue();
					$this->sc_sd->getListDosenActive();
					$selectPD = $select2;
					while($this->sc_sd->getNextCursor()){
						if($this->sc_sd->getNip() != $TEMP_NIP){						
							if($this->sc_sd->getNip() == $this->sc_std->getNipd())
								$selectPD .= "<option selected value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";
							else
								$selectPD .= "<option value='".$this->sc_sd->getNip()."'>".$this->sc_sd->getNama()."</option>";	
						}
					}
					$data.="<td>".$i."</td><td>".$this->sc_sm->getNim()."</td><td>".$this->sc_sm->getName()."</td><td>"."<select onchange='changePenguji1(".'"'.$this->sc_sm->getNim().'"'.",this)'>".$selectPS."</select>"."</td><td>"."<select onchange='changePenguji2(".'"'.$this->sc_sm->getNim().'"'.",this)'>".$selectPD."</select>"."</td><td>".$TEMP_NAME."</td><td><div class='row'>";
					if($this->sc_std->getDocppp() == '2'){
					$data .= "<div class='col-md-3'>".
					"<span style='color : green;' title='rekomendasi'><i class='icon-map-marker'></i></span></div>";
					}else{
					$data .= "<div class='col-md-3'>".
					"<span style='color : red;' title='tidak direkomendasikan'><i class='icon-map-marker'></i></span></div>";
					}
					if($this->sc_std->getDocp() != "" && $this->sc_std->getDocp() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan surat pengantar' onclick='showPdfTA1(".'"'.$this->sc_std->getDocp().'"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan surat pengantar'><i class='icon-file-alt'></i></span>".
					"</div>";		
					}
					if($this->sc_std->getDocbta() != "" && $this->sc_std->getDocbta() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color:green' class='pointer'  title='sudah mengumpulkan kartu bimbingan' onclick='showImageTA1(".'"'.$this->sc_std->getDocbta().'"'.")'><i class='icon-picture'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color:red' title='belum mengumpulkan kartu bimbingan'><i class='icon-picture'></i></span>".
					"</div>";	
					}
					if($this->sc_std->getDocpta() != "" && $this->sc_std->getDocpta() != " "){
					$data .= "<div class='col-md-2'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan kartu ikut seminar' onclick='showImageTA1(".'"'.$this->sc_std->getDocpta().'"'.")'><i class='icon-picture'></i></span>".
					"</div>";	
					}else{
					$data .= "<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan kartu ikut seminar'><i class='icon-picture'></i></span>".
					"</div>";	
					}
					if($this->sc_std->getDocTranskrip() != "" && $this->sc_std->getDocTranskrip() != " "){
					$data.="<div class='col-md-3'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan transkrip'  onclick='showPdfTA1(".'"'.$this->sc_std->getDocTranskrip().'"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";
					}else{
					$data.="<div class='col-md-3'>".
					"<span style='color : red;' title='belum mengumpulkan transkrip'><i class='icon-file-alt'></i></span>".
					"</div>";
					}
					$data.="</div></td><td>";
					$data.="<select onchange='seminarTA2Agreement(".'"'.$this->sc_sm->getNim().'"'.",this)'>";
					if($this->sc_std->getDataProses() == '1'){
						$data.="<option value='1' selected>menunggu</option>";
					}else{
						$data.="<option value='1'>menunggu</option>";
					}
					if($this->sc_std->getDataProses() == '2'){
						$data.="<option value='2' selected>disetujui</option>";
					}else{
						$data.="<option value='2'>disetujui</option>";
					}
					if($this->sc_std->getDataProses() == '3'){
						$data.="<option value='3' selected>ditolak</option>";
					}else{
						$data.="<option value='3'>ditolak</option>";
					}
					$data.="</select>";
					$data.="</td>";
					$data.="</tr>";
					$i++;
				}	
			}else{
				$data.="<tr>";
				$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
				$data.="</tr>";
			}
		}else{
			$data.="<tr>";
			$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
			$data.="</tr>";
		}
		echo "1".$data;
		
		
	}
	public function setNewPenguji(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$nim = "".$this->view->isNullPost('nim')."";
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("0Nim tidak valid");
		}
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($nim);
		if(!$this->sc_sm->isNimExist()){
			exit("0Nim tidak terdaftar");
		}
		$nip = "".$this->view->isNullPost('nip')."";
		if(!$this->dosen->getCheckNip($nip,1)[0]){
			exit("0Nip tidak valid");
		}
		//valid
		$this->sc_std->resetValue();
		$this->sc_std->setNim($nim);
		$this->sc_std->setKode($srt);
		$this->sc_std->setKategori(2);
		if(!$this->sc_std->getDataPrimaryActiveByKategory()){
			exit("0Nim tidak mendaftar seminar ta");
		}
		$this->sc_st->resetValue();
		$this->sc_st->setNim($nim);
		$this->sc_st->setKode($srt);
		$this->sc_st->getDataActiveRegister();
		$this->sc_sd->resetValue();
		$this->sc_sd->setNip($nip);
		if(!$this->sc_sd->isNipExist()){
			exit("0Nip tidak terdaftar");
		}
		if($this->sc_sd->getNip() == $this->sc_st->getNip()){
			exit("0Nip bimbingan, tidak boleh penguji dari yang di bimbing");
		}
		$penguji = $this->view->isNullPost('penguji');
		/*
		$nim='24010313130007';
		$status=2;
		$ta=1;
		*/
		switch(intval($penguji)){
			case 1 : 
			case 2 :
			break;
			default :
			exit("0kode ta tidak valid");
			break;
		}
		//$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		//exit("0helllo"+"");
		$this->sc_std->resetValue();
		$this->sc_std->setNim($nim);
		$this->sc_std->setKode($srt);
		$this->sc_std->setKategori(2);
		if(intval($penguji) == 1){
			$this->sc_std->setNips($nip);
		}else{
			$this->sc_std->setNipd($nip);
		}
		if($this->sc_std->updateDataProsesTA())
			exit("1Status berhasil dirubah");
		else{
			exit("0Status gagal dirubah");
		}
	}
	public function setNewStatusSeminarTA(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$nim = $this->view->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("0Nim tidak valid");
		}
		$this->sc_sm->resetValue();
		$this->sc_sm->setNim($nim);
		if(!$this->sc_sm->isNimExist()){
			exit("0Nim tidak terdaftar");
		}
		$status = $this->view->isNullPost('status');
		$ta = $this->view->isNullPost('ta');
		/*
		$nim='24010313130007';
		$status=2;
		$ta=1;
		*/
		switch(intval($ta)){
			case 1 : 
			case 2 :
			$ta = intval($ta);
			switch(intval($status)){
				case 1 :
				case 2 :
				case 3 :
				$status = intval($status);
				break;
				default:
				exit("kode status tidak valid");
			}
			break;
			default :
			exit("0kode ta tidak valid");
			break;
		}
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$this->sc_std->resetValue();
		$this->sc_std->setNim($nim);
		$this->sc_std->setKode($srt);
		$this->sc_std->setKategori($ta);
		$this->sc_std->setDataProses($status);
		if($this->sc_std->updateDataProsesTA())
			exit("1Status berhasil dirubah");
		else{
			exit("Status gagal dirubah");
		}
	}
	public function getJsonTableNow(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		//$kode = $this->view->isNullPost('kode');
		//$kode="JASERV-CONTROL";
		//if($kode!="JASERVCONTROL")
		//	exit("0maaf, anda melakukan debugging");
		$temp = $this->dosen->getListDosen();
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$temp1 = "";
		$temp2 = "";
		for ($i = 0 ; $i < $temp['length'];$i++){
			$temp1 .= '"'.$temp[$i]['nama'].'",';
			$this->sc_st->resetValue();
			$this->sc_st->setNip($temp[$i]['id']);
			$this->sc_st->setKode($srt);
			$countData = 0;
			if($this->sc_st->getDataDosenPembimbing()){
				while($this->sc_st->getNextCursor()){
					$this->sc_std->resetValue();
					$this->sc_std->setNim($this->sc_st->getNim());
					$this->sc_std->setKode($srt);
					$this->sc_std->setKategori(2);
					if($this->sc_std->isRegisteredOnSeminar())
						$countData += 1;
				}
			}
			$temp2 .= $countData.",";
		}
		$temp1 = substr($temp1, 0,strlen($temp1)-1);
		$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	
	public function getJsonTableTesterS(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		//$kode = $this->view->isNullPost('kode');
		//$kode="JASERV-CONTROL";
		//if($kode!="JASERVCONTROL")
		//	exit("0maaf, anda melakukan debugging");
		$temp = $this->dosen->getListDosen();
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$temp1 = "";
		$temp2 = "";
		for ($i = 0 ; $i < $temp['length'];$i++){
			$temp1 .= '"'.$temp[$i]['nama'].'",';
			$this->sc_std->resetValue();
			$this->sc_std->setNips($temp[$i]['id']);
			$this->sc_std->setKode($srt);
			$temp2 .= $this->sc_std->getCountDataNipS().",";
		}
		$temp1 = substr($temp1, 0,strlen($temp1)-1);
		$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	
	public function getJsonTableTesterD(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		//$kode = $this->view->isNullPost('kode');
		//$kode="JASERV-CONTROL";
		//if($kode!="JASERVCONTROL")
		//	exit("0maaf, anda melakukan debugging");
		$temp = $this->dosen->getListDosen();
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		$temp1 = "";
		$temp2 = "";
		for ($i = 0 ; $i < $temp['length'];$i++){
			$temp1 .= '"'.$temp[$i]['nama'].'",';
			$this->sc_std->resetValue();
			$this->sc_std->setNipd($temp[$i]['id']);
			$this->sc_std->setKode($srt);
			$temp2 .= $this->sc_std->getCountDataNipD().",";
		}
		$temp1 = substr($temp1, 0,strlen($temp1)-1);
		$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
}