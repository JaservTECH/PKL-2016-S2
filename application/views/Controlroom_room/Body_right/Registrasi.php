<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
	 

<div class="block">
	<div>
		<div class="block">
			<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
				<div id="controller-diagram" style="min-width: 1000px;">
					<canvas id="canvas" ></canvas>
				</div>
			</div>
		</div>
		<div class="block"> 
			<div class="header"> 
				<h2>Registrasi Pemerataan Mahasiswa</h2>
			</div> 
			<div class="content">
				<div>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-dosen" pattern="[a-zA-Z0-9 @.]{0,50}" placeholder="Nim/Nama ..."/>
					</label>
					<label style="margin : 10px; float: right;">
						<span class="icon-list-alt" style="font-size : 32px; top : 10px; position : relative;">
					</label>
					<label style="margin : 10px; float: right;">
						<span class="icon-list-alt" style="font-size : 32px; top : 10px; position : relative;">
					</label>
				</div> 
				<div style="overflow-x : auto; margin-top : 60px;">
					<table class="table table-striped table-hover "> 
						<thead> 
							<tr> 
								<th>No</th>
								<th>Nim</th> 
								<th>Nama Mahasiswa</th>
								<th>Registrasi</th>   
								<th>Bidang Minat</th> 
								<th>Dosen Pembimbing</th>
								<th>Dosen log</th> 
								<th>Dosen review</th>
							</tr> 
						</thead> 
						<tbody id="tabel-pemerataan-mahasiswa" style="overflow-y : auto; height: 200px;">  
							<tr > 
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td> 
								<td>-</td> 
							</tr> 
						</tbody> 
					</table>
				</div> 
			</div> 
		</div>
	</div>
</div>