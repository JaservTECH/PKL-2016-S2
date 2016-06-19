<?php
if(!defined('BASEPATH'))
	exit("Sorry");
class Controlregistrasi extends CI_Controller {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("Koordinator");
		$this->load->library("Mahasiswa");
		$this->load->library("Dosen");
		$this->load->model('sc_st');
		$this->load->model('sc_ea');
		$this->load->library("View");
	}
	public function getLayoutRegistrasi(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		echo "1";
		$this->load->view("Controlroom_room/Body_right/Registrasi.php");
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
			$temp2 .= $this->sc_st->getCountDosenPembimbing().",";
			//$temp3=$this->mahasiswa->getCountDospem($value['id'],$srt);
			//echo "".$srt." ".$value['id']." ".$value['nama']." ".count($temp3[1])."<br>";
			//$temp2 .= count($temp3[1]).",";
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
	
	public function setDospem(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		$nim = $this->view->isNullPost('nim');
		$nip = $this->view->isNullPost('nip');
		//$nim = "24010313130007";
		//$nip="12345789123456789";
		$kode = $this->view->isNullPost('kode');
		//$kode="JASERVCONTROL";
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit("0nim tidak sesuai, anda melakukan debugging");
		if(!$this->dosen->getCheckNip($nip,1)[0])
			exit("0nim tidak sesuai, anda melakukan debugging");
		$srt = $this->sc_ea->getCodeRegistrasiAkademik()->now();
		//$this->sc_st->resetValue();
		//$this->sc_st->setNim($nim);
		//$this->sc_st->setNip($nip);
		//$this->sc_st->setKode($srt);
		//if($this->sc_st->setUpdateActive()){
		if($this->mahasiswa->setDospemForTA($nim,$nip,$srt)){
			echo "1data berhasil dirubah";
		}else{
			echo "0data gagal dirubah";
		}
		return;
	}
	public function getPemerataanListMahasiswa(){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		
		$temp = $this->mahasiswa->getListMahasiswaPemerataan($this->sc_ea->getCodeRegistrasiAkademik()->now());
		
		$dosen = $this->dosen->getListDosen();
		//if(count($temp) <=0)
			//echo "nothing to see";
		echo 1;
		for ($i=0;$i<$temp['length'];$i++){
			
			$tempssN=0;
			echo 
			"<tr><td>".$i."</td>".
			"<td>".$temp[$i]['nim']."</td>
			<td>".$temp[$i]['nama']."</td>
			<td>";
			if(intval($temp[$i]['kategori'])==1)
				echo "Baru";
			else 
				echo "Melanjutkan";
			echo "</td>
			<td>".$temp[$i]['minat']."</td>
			<td>";
			echo "<select onchange=".'"'."changeDospem('".$temp[$i]['nim']."',this.value);".'"'." >";
			echo "<option value='0'>Belum ada</option>";
			$nipreview="";
			for ($j = 0 ; $j < $dosen['length'];$j++){
				echo "<option value='".$dosen[$j]['id']."'";
				if($dosen[$j]['id'] == $temp[$i]['nip'])
					echo " selected ";
				echo ">".$dosen[$j]['nama']."</option>";
				
				if($dosen[$j]['id'] == $temp[$i]['nipreviews']){
					$nipreview.="<li>".$dosen[$j]['nama']."</li>";
					$tempssN++;
					continue;
				}
				if($dosen[$j]['id'] == $temp[$i]['nipreviewd']){
					$nipreview.="<li>".$dosen[$j]['nama']."</li>";
					$tempssN++;
					continue;
				}
				if($dosen[$j]['id'] == $temp[$i]['nipreviewt']){
					$nipreview.="<li>".$dosen[$j]['nama']."</li>";
					$tempssN++;
					continue;
				}
				
			}
			echo "</select></td>";
			//there
			
			$this->sc_st->resetValue();
			$this->sc_st->setNim($temp[$i]['nim']);
			$this->sc_st->setKode($this->sc_ea->getCodeRegistrasiAkademik()->now());
			$this->sc_st->getLastDosenIfExist();
			$scope = 1;
			$tempos = "";
			//$coco="";
			// echo var_dump($this->sc_st->TEMP_RESULT_ARRAY);
			while($this->sc_st->getNextCursor()){
				if($scope > 3)
					break;
				if($this->sc_st->getNip() == "0")
					continue;
				
				if(intval($this->sc_st->getNip()) == "")
					continue;
				//tehrererer
				$this->sc_sd->resetValue();
				$this->sc_sd->setNip($this->sc_st->getNip());
				$this->sc_sd->getDosenInfo();			
				$tempos .= $scope ." : ".$this->sc_sd->getNama()."<br>";
				$scope ++;
			}
			
			$tempss="<ul style='list-style:none;padding : 0; margin : 0;'>";
			if($tempos == "")
				$tempss.="<li>-</li>";
			else{
				$tempss.="<li>".substr($tempos, 0,strlen($tempos)-4)."</li>";
			}
			$tempss.="</ul>";
			echo "<td>".$tempss."</td><td>";
			
			/* 
			$restReview =null;
			if(intval($temp[$i]['nipreviews']) != 0){
				if($restReview == null){
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($temp[$i]['nipreviews']);
					$this->sc_sd->getDosenInfo();			
					$restReview = $this->sc_sd->getNama();
				}else{
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($temp[$i]['nipreviews']);
					$this->sc_sd->getDosenInfo();			
					$restReview .= $this->sc_sd->getNama();
				}
			}
			if(intval($temp[$i]['nipreviewd']) != 0){
				if($restReview == null){
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($temp[$i]['nipreviewd']);
					$this->sc_sd->getDosenInfo();			
					$restReview = $this->sc_sd->getNama();
				}else{
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($temp[$i]['nipreviewd']);
					$this->sc_sd->getDosenInfo();			
					$restReview .= $this->sc_sd->getNama();
				}
			}
			if(intval($temp[$i]['nipreviewt']) != 0){
				if($restReview == null){
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($temp[$i]['nipreviewt']);
					$this->sc_sd->getDosenInfo();			
					$restReview = $this->sc_sd->getNama();
				}else{
					$this->sc_sd->resetValue();
					$this->sc_sd->setNip($temp[$i]['nipreviewt']);
					$this->sc_sd->getDosenInfo();			
					$restReview .= $this->sc_sd->getNama();
				}
			}
			 */
			
			if($nipreview == "")
				echo "<ul style='list-style:none; margin-left : 0; left : 0; padding :0;'><li >Belum review dosen</li></ul>";
			else 
				echo "<ul style='list-style:none; margin-left : 0; left : 0; padding: 0;'>".$nipreview."</ul>";
		//echo $restReview;
			
			echo "</td></tr>";
		}
	}
}