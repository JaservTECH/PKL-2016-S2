<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>

<div class="block">
	<div class=header> 
		<h2>Registrasi Seminar TA Satu</h2> 
	</div> 
	<div class="content controls">
		<div class=form-row>
			<div class="col-md-3">Nama </div>
			<div class="col-md-9"> </div>
		</div> 
		<div class=form-row>
			<div class="col-md-3">Surat Pegantar </div>
			<div class="col-md-3">
				<button  id="exec-s-pengantar" class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
			</div>
			<div class="col-md-3">
				<a style="color : #666;"> : Data kosong</a>
			</div>
			<div class="col-md-3" style="font-size : 13px;">
				<div class="col-md-6">
					<span class="icon-ok pointer" title="data telah masuk" style="color : green"></span>
				</div>
				<div class="col-md-6">
					<span class="icon-remove pointer" title="data belum masuk" style="color : red"></span>
				</div>
			</div>
		</div> 
		<div class=form-row>
			<div class="col-md-3">Scan Kartu Bimbingan TA </div>
			<div class="col-md-3">
				<button  id="exec-s-k-bimbingan"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.png)</button>
			</div>
			<div class="col-md-3">
				<a style="color : #666;"> : Data kosong</a>
			</div>
			<div class="col-md-3" style="font-size : 13px;">
				<div class="col-md-6">
					<span class="icon-ok pointer" title="data telah masuk" style="color : green"></span>
				</div>
				<div class="col-md-6">
					<span class="icon-remove pointer" title="data belum masuk" style="color : red"></span>
				</div>
			</div>
		</div> 
		<div class=form-row>
			<div class="col-md-3">Scan Kartu Peserta TA </div>
			<div class="col-md-3">
				<button  id="exec-s-k-peserta"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.png)</button>
			</div>
			<div class="col-md-3">
				<a style="color : #666;"> : Data kosong</a>
			</div>
			<div class="col-md-3" style="font-size : 13px;">
				<div class="col-md-6">
					<span class="icon-ok pointer" title="data telah masuk" style="color : green"></span>
				</div>
				<div class="col-md-6">
					<span class="icon-remove pointer" title="data belum masuk" style="color : red"></span>
				</div>
			</div>
		</div> 
		<div class=form-row>
			<div class="col-md-3">Transkrip </div>
			<div class="col-md-3">
				<button  id="exec-s-transkrip"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
			</div>
			<div class="col-md-3">
				<a style="color : #666;"> : Data kosong</a>
			</div>
			<div class="col-md-3" style="font-size : 13px;">
				<div class="col-md-6">
					<span class="icon-ok pointer" title="data telah masuk" style="color : green"></span>
				</div>
				<div class="col-md-6">
					<span class="icon-remove pointer" title="data belum masuk" style="color : red"></span>
				</div>
			</div>
		</div> 
		<div class=form-row>
			<div class="col-md-3">Validasi Koordinator </div>
			<div class="col-md-9">
				Valid
			</div>
		</div> 
		<div class="form-row">
			<div class="block"> 
				<div class="header"> 
					<h2>Controls</h2> 
					<div class="side pull-right"> 
						<ul class="buttons"> 
							<li class="btn-group"> 
								<a href="#" class="dropdown-toggle tip" title="" data-toggle="dropdown" data-original-title="Dropdown"><span class="icon-align-justify"></span></a>
								<ul class="dropdown-menu" role="menu"> 
									<li>
										<a href="#">Some action</a>
									</li> 
									<li>
										<a href="#">Other action</a>
									</li>
									<li>
										<a href="#">Last action</a>
									</li>
								</ul> 
							</li>
							<li>
								<a href="#" class="block-toggle tip" title="" data-original-title="Toggle content"><span class="icon-chevron-up"></span></a>
							</li>
							<li>
								<a href="#" class="block-remove tip" title="" data-original-title="Remove block"><span class="icon-remove"></span></a>
							</li> 
						</ul> 
					</div> 
				</div> 
				<div class="content" style="display: none;"> Default block content 
				</div> 
				<div class="footer" style="display: none;"> Default block footer 
				</div> 
			</div>
		</div>
	</div>
	<form class="hidden">
		<input class="hidden" type="file" id="s-pengantar" accept=".pdf">
		<input class="hidden" type="file" id="s-k-bimbingan" accept=".png">
		<input class="hidden" type="file" id="s-k-peserta"  accept=".png">
		<input class="hidden" type="file" id="s-transkrip" accept=".pdf">
	</form>
	<div id='calendar'></div> 
	<div class="container">
	<div class=form-row> 
		<div class=col-md-3>Time:</div> 
		<div class=col-md-9> 
			<div class=input-group>
				<div class=input-group-addon>
					<span class=icon-time></span>
				</div>
				<input type=text class="datetimepicker form-control" value="12:17"/>
			</div>
		</div>
	</div>
     
</div>

	
</div>
