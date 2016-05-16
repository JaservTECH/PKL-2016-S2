<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIATA Di bangun ulang | Masuk</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url();?>resources/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>resources/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url();?>resources/plugins/iCheck/square/blue.css">

	<?php
		for($i=0;array_key_exists($i,$url_link);$i++)
			echo link_tag($url_link[$i]); 
	?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
  </head>
  <body class="">
    <div class="login-box">
      <div class="login-logo">
        <a class="white-blur"><b>SIATA</b> - INFORMATIKA</a>
      </div><!-- /.login-logo -->
      <div id="signInLayout"  class="login-box-body">
        <p class="login-box-msg">Masuk untuk anggota</p>
        <form target='frame-layout' id="masuk-form-validation" action="<?php echo htmlspecialchars(base_url()."gateinout/getSignIn.aspx");?>" method="post" >
          <div class="form-group has-feedback">
          	<div>
          		
          	</div>
            <select class="form-control" id="login-akun" name="login-akun" placeholder="pilih hak akses">
            	<option value="mhs" selected>Mahasiswa</option>
            	<option value="kor">Koordinator</option>
            	<option value="dos">Dosen</option>
            	<option value="adm">Administrator</option>
            </select>
          </div>
          <div class="form-group has-feedback">
          <div></div>
            <input type="text" class="form-control" id="login-nim" name="login-nim" placeholder="Nim/Nip/ID">
            <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="password" class="form-control" placeholder="Password" id="login-password" name="login-password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
          <div class="col-xs-8">
          
          <!-- 
              <div class="checkbox icheck">
                <label >
                  <input type="checkbox"> Ingatkan saya
                </label>
              </div>
              -->
            </div><!-- /.col -->
           
            <div class="col-xs-4">
              <button type="button" class="btn btn-primary btn-block btn-flat" id="login-exe">Masuk</button>
            </div><!-- /.col -->
          </div>
        </form>
        <a class="text-center pointer" data-toggle="modal" data-target="#user-forgot">saya lupa password</a><br>
        <a class="text-center pointer" id="signup-layout-active">Ingin mendaftar</a>

      </div><!-- /.login-box-body -->
	
      <div id="signUpLayout" class="register-box-body">
        <p class="login-box-msg">Daftar anggota baru</p>
        <form target="frame-layout" id="daftar-form-validation" action="<?php echo htmlspecialchars(base_url()."gateinout/getSignUp.aspx");?>" method="post" enctype="multipart/form-data" >
          <div class="form-group has-feedback">
          	<div></div>
            <input type="text" class="form-control" pattern="{8,14}"  required id="daftar-nim" name="daftar-nim" placeholder="Nomor induk mahasiswa">
            <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="text" class="form-control" pattern="[a-zA-Z ]{1,50}"  required id="daftar-nama" name="daftar-nama" placeholder="Nama lengkap">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="email" class="form-control" required id="daftar-apes" pattern="[a-zA-Z0-9.-]{1,50}[@]{1}[a-zA-Z0-9]{1,10}[.]{1}[a-zA-Z]{1,10}"  name="daftar-apes"  placeholder="alamat pesan">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="password" class="form-control" required id="daftar-kunci" pattern="[a-zA-Z0-9]{8,18}" name="daftar-kunci" placeholder="Kata Kunci">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="password" class="form-control" required id="daftar-kuncire" pattern="[a-zA-Z0-9]{8,18}" name="daftar-kuncire" placeholder="tulis ulang kata kunci">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="text" class="form-control" required id="daftar-ntelp" pattern="[0-9]{10,13}"name="daftar-ntelp" placeholder="Nomor telepon">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div>
			<div style="width : 100%;" class="center">
				<img id="preview-foto" style="max-width : 84px; max-height : 126px; background-color : rgba(225,225,225,0.6); margin-bottom : 20px;" src="http://localhost/siataiiiS/image/mhs/siata_core_image_default.png">
		  	</div>
		  </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="file" class="hidden" id="daftar-foto-exe" accept=".png,.jpg" name="daftar-foto-exe">
            <input type="button" class="btn btn-block btn-flat" required id="daftar-foto" name="daftar-foto" value="Unggah foto(.jpg, .png)">
            <span class="glyphicon glyphicon-upload form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="file" class="hidden" id="daftar-trans-exe" accept=".pdf" name="daftar-trans-exe">
            <input type="button" class="btn btn-block btn-flat" required id="daftar-trans" name="daftar-trans" value="Unggah transkrip(.pdf)">
            <span class="glyphicon glyphicon-upload form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label  id="daftar-check-exe">
                  <input type="checkbox" id='daftar-agreement'> Saya setuju dengan <a class="pointer" data-toggle="modal" data-target="#user-term">peraturan</a>
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="button" id='daftar-exe' class="btn btn-primary btn-block btn-flat">Daftar</button>
            </div><!-- /.col -->
          </div>
        </form>
        <a class="text-center pointer" id="signin-layout-active">Sudah memiliki akun ?</a>
      </div><!-- /.form-box -->
      
      <p class="login-box-msg"><a class="text-center pointer" id="panduan-style" data-toggle="modal" data-target="#user-panduan">panduan</a></p>
    </div><!-- /.login-box -->
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>resources/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>resources/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>resources/plugins/iCheck/icheck.min.js"></script>
    
	<?php
		for($i=0;array_key_exists($i,$url_script);$i++)
			echo "<script type='text/javascript' src='".base_url().$url_script[$i]."'></script>";
	?>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
    
  <div class="modal fade" id="user-term" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title center">Peraturan</h4>
        </div>
        <div class="modal-body">
          <h3>Peraturan yang berlaku sebelum anda melakukan daftar akun</h3>
          <div>
			<p>Sisi Pendidikan</p>
			<ol>
				<li>Anda mengambal mata kuliah tugas akhir</li>
				<li>Berlaku untuk TA lama, TA baru</li>
				<li>Gunakan data yang valid dan terdaftar pada akademik institusi</li>
				<li>Dilarang mendaftarkan akun yang bukan akun anda</li>
				<li>Lakukan sesuai dengan grade kuliah anda terhadap sistem ini</li>
			</ol>
			<p>Sisi Developer</p>
			<ol>
				<li>Jangan melakukan hhal yang diluar akal logika pada segala macam proses yang terjadi pada sistem</li>
				<li>Sangat mendukung banyak umpan balik, agar sistem lebih nyaman digunakan</li>
				<li>Melakukan tindakan yang diluar developer merupakan pelanggaran tanpa seizin pihak institusi</li>
			</ol>
          </div>
        </div>
        <div class="modal-footer bottom-space">
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="user-forgot" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title center">Lupa password</h4>
        </div>
        <div class="modal-body">
			
        </div>
        <div class="modal-footer bottom-space">
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="user-alert" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title center">Pemberitahuan</h4>
        </div>
        <div class="modal-body" id="user-alert-message">
			
        </div>
        <div class="modal-footer bottom-space">
        	<button class="btn btn-primary btn-flat" id="user-alert-close" >Tutup</button>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="user-panduan" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title center">Panduan</h3>
        </div>
        <div class="modal-body">
<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="center">Alur Pendaftaran Tugas Akhir :</h4>
							</div>
							<div class="panel-body">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="center">Pendaftaran Akun :</h5>
									</div>
									<div class="panel-body">
										<ol>
											<li>Klik daftar pada halaman utama</li>
											<li>Masukkan NIM, masukkan username dan password dengan alphabet, kemudian klik daftar pada bagian bawah</li>
											<li>Halaman Konfirmasi akun akan muncul menandakan pendaftaran akun anda telah berhasil, kemudian klik kembali</li>
										</ol>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="center">Registrasi TA Baru :</h5>
									</div>
									<div class="panel-body">
										<ol>
											<li>Masukkan username dan password akun yang telah anda daftarkan</li>
											<li>Klik daftar Registrasi TA pada menu bagian atas</li>
											<li>Klik Registrasi TA</li>
											<li>Kemudian isikan form Registrasi TA berdasarkan data anda, kemudian klik daftar</li>
											<li>Halaman Konfirmasi akan munncul menandakan proses registrasi TA anda sedang diproses, Kemudian klik kembali</li>
											<li>Silahkan serahkan lampiran registrasi TA kepada bagian Administrasi Jurusan (Mbak nisa)</li>
											<li>Konfirmasi status registrasi TA dapat dilihat melalui web siata pada halaman beranda dan email anda</li>
											<li>Apabila status registrasi anda tidak terkonfirmasi, silahkan temui koordinator TA</li>
										</ol> 
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="center">Lampiran Registrasi TA baru</h5>
									</div>
									<div class="panel-body">
										<ol>
											<li>Photocopy KRS</li>
											<li>Transkrip nilai terakhir</li>
										</ol>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="center">Registrasi Perpanjangan TA :</h5>
									</div>
									<div class="panel-body">
										<ol>
											<li>Masukkan username dan password akun yang telah anda daftarkan</li>
											<li>Klik daftar Registrasi TA pada menu bagian atas</li>
											<li>Klik Registrasi TA</li>
											<li>Kemudian isikan form Registrasi TA berdasarkan data anda, kemudian klik daftar</li>
											<li>Halaman Konfirmasi akan munncul menandakan proses registrasi TA anda sedang diproses, Kemudian klik kembali</li>
											<li>Silahkan serahkan lampiran registrasi TA kepada bagian Administrasi Jurusan (Mbak nisa)</li>
											<li>Konfirmasi status registrasi TA dapat dilihat melalui web siata pada halaman beranda dan email anda</li>
											<li>Apabila status registrasi anda tidak terkonfirmasi, silahkan temui koordinator TA</li>
										</ol>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="center">Lampiran Registrasi Perpanjangan TA</h5>
									</div>
									<div class="panel-body">
										<ol>
											<li>Photocopy KRS</li>
											<li>Form Perpanjangan</li>
										</ol>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="center">Download Area</h5>
									</div>
									<div class="panel-body">
										<ol>
											<li><a href="http://localhost/siataiiiS/index.php/downloadArea/download.aspx">Alur Registrasi TA</a></li>
											<li><a href="http://localhost/siataiiiS/index.php/downloadArea/download1.aspx">Form Perpanjangan TA</a></li>
											<li><a href="http://localhost/siataiiiS/index.php/downloadArea/download3.aspx">Form Perpanjangan TA (2 Pembimbing)</a></li>
											<li><a href="http://localhost/siataiiiS/index.php/downloadArea/download2.aspx">Pengumuman Distribusi Ulang</a></li>
										</ol>
									</div>
								</div>
							</div>
						</div>
        </div>
        <div class="modal-footer bottom-space">
        </div>
      </div>
      
    </div>
  </div>
      <footer>
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0.1 Beta
        </div>
        <strong>Copyright &copy; 2014-<?php echo DATE('Y')?> <a>Jaserv Studio</a>.</strong> All rights reserved.
      </footer>
      <div class="background-page">
      	<div class="layer-background-page"></div>
      	<div class="image-background-page"></div>
      </div>
      <iframe class="hidden" id="frame-layout" name="frame-layout"></iframe>
  </body>
</html>
