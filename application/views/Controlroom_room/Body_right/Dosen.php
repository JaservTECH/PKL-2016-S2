<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
<div class="block"> 
	<div class="header"> 
		<div>
			<h2>Daftar Dosen</h2>
		</div>
	</div> 
	<div class="content">
		<div>
			<label style="margin : 10px; float: right;">
				<input type="text" id="search-dosen" pattern="[a-zA-Z0-9 @.]{0,50}" placeholder="Cari Dosen ..."/>
			</label>
		</div>
		<div style=""  class="table-responsive">
			<table class="table table-striped table-hover"> 
			<thead> 
				<tr> 
					<th>No</th> 
					<th>Nip</th> 
					<th>Nama Dosen</th> 
					<th>Bidang</th> 
					<th>Mahasiswa Bimbingan</th>
					<th>Status</th> 
				</tr> 
			</thead> 
			<tbody id="data-table-dosen">  
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tbody> 
		</table>
		</div>  
	</div> 
</div>
<div class="block">
	
</div>