<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	

<div class="block"> 
	<ul class="nav nav-tabs"> 
		<li class="active grey-back tip" title="tabel seminar ta 1">
			<a href="#tab5" data-toggle="tab" ><span class="icon-table"></span></a>
		</li>
		<li class="grey-back tip" title="tabel seminar ta 2">
			<a href="#tab6" data-toggle="tab" id="seminar-ta2-pemerataan" ><span class="icon-table"></span></a>
		</li>		
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 	 
			<div class="block"> 
				<div class="header"> 
					<h2>Seminar TA1</h2>
				</div> 
				<div class="content">
				<!--
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
					</div> -->
					<div style="overflow-x : auto;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>No</th>
									<th>Nim</th> 
									<th>Nama Mahasiswa</th>
									<th>Bidang Minat</th>    
									<th>Dosen Pembimbing</th>
									<th>Status kelengkapan</th>
									<th>Aksi</th>
								</tr> 
							</thead> 
							<tbody id="tabel-pemerataan-seminar-ta1" style="overflow-y : auto; height: 200px;">  
								<tr > 
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
		<div class="tab-pane" id="tab6">
			<div class="block"> 
				<ul class="nav nav-tabs nav-justified"> 
					<li class="active" onclick="reloadChartSeminarAll(1);"><a href="#tab11" data-toggle="tab">Total Bimbingan</a></li> 
					<li class="" onclick="reloadChartSeminarAll(2);"><a href="#tab12" data-toggle="tab">Total penguji 1</a></li> 
					<li class="" onclick="reloadChartSeminarAll(3);"><a href="#tab13" data-toggle="tab">Total penguji 2</a></li> 
				</ul> 
				<div class="content content-transparent tab-content">
					<div class="tab-pane active" id="tab11"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-1" style="min-width: 1000px;">
									<canvas id="canvas1" ></canvas>
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab12"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-2" style="min-width: 1000px;">
									<canvas id="canvas2" ></canvas>
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab13"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-3" style="min-width: 1000px;">
									<canvas id="canvas3"></canvas>
								</div>
							</div>
						</div>
					</div> 
				</div> 
			</div>
			<div class="block"> 
				<div class="header"> 
					<h2>Seminar TA 2 pemerataan</h2>
				</div> 
				<div class="content">
				<!--
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
						-->
					<div style="overflow-x : auto; ">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>No</th>
									<th>Nim</th> 
									<th>Nama Mahasiswa</th>
									<th>Penguji 1</th>
									<th>Penguji 2</th>
									<th>Dosen Pembimbing</th>
									<th>Status kelengkapan</th>
									<th>Aksi</th> 
									<th></th>
								</tr> 
							</thead> 
							<tbody id="tabel-pemerataan-seminar-ta2" style="overflow-y : auto; height: 200px;">  
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
		<div class="tab-pane" id="tab6"> 
		 koko
		</div> 
		<div class="tab-pane" id="tab7"> 
			kiki
		</div> 
	</div> 
</div>