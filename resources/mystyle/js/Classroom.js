var navbarNavigation = {};
$(document).ready(function(){
	if($(".datepickers").length>0)$(".datepickers").datepicker({nextText:"",prevText:""});
	resetControlNavigasi();
	navbarNavigation['form-control']=0;
	navbarNavigation['home'] = 1;
	setNewContentIntern("Classroom/getLayoutHome",function(){},function(){},function(){});	
	$('#keluar-confirm-exe').on('click',function(){
		modalStaticMultipleButton('Apakah anda yakin ingin keluar',function(){
			$(location).attr('href', "Classroom/signOut.aspx");
		});
	});
	setTimeout(function(){
		noty({text:'Hai '+nama_user+', selamat datang di Sistem Informasi Akademik Tugas Akhir ^_^'});
		setTimeout(function(){
			$.noty.closeAll();
		},5000);
	},3000);
	$('#home-layout').on('click',function(){
		if(navbarNavigation['home'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['home']=1;
				setBreadCrumb({0:'Beranda'});
				setNewContentIntern("Classroom/getLayoutHome",function(){},function(){},function(){});	
			}
		}
	});
	$('#registrasi-baru-layout').on('click',function(){
		if(navbarNavigation['baru'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['baru']=1;
				setBreadCrumb({0:'Registrasi TA',1:"baru"});
				setNewContentIntern(
					"Classregistrasibaru/getLayoutRegistrasiBaru",
					function(){reLoadFormBaru();},
					function(){
						$("#content-intern").slideUp('slow',function(){
							j("#content-intern").setInHtml();
							j("#setAjax").setAjax({
								methode : 'POST',
								url : "Classregistrasibaru/getLayoutRegistrasiBaru.aspx",
								bool : true,
								content : "force=trueJaserv",
								sucOk : function(a){
									j("#content-intern").setInHtml(a.substr(1,a.length-1));
									if(a[0] == '1'){
										$('#content-intern').slideDown('slow',function(){
											reLoadFormBaru();
										});
									}else{
										$('#content-intern').slideDown('slow');
									}
								}
							});
						});
					},
					function(){
						$('#registrasi-lama-layout').trigger('click');
					}
				);
			}
		}
	});
	$('#registrasi-lama-layout').on('click',function(){
		if(navbarNavigation['lama'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['lama']=1;
				setBreadCrumb({0:'Registrasi TA',1:"lama"});
				setNewContentIntern(
					"Classregistrasilama/getLayoutRegistrasiLama",
					function(){reLoadFormLama();},
					function(){
						$("#content-intern").slideUp('slow',function(){
							j("#content-intern").setInHtml();
							j("#setAjax").setAjax({
								methode : 'POST',
								url : "Classregistrasilama/getLayoutRegistrasiLama.aspx",
								bool : true,
								content : "force=trueJaserv",
								sucOk : function(a){
									j("#content-intern").setInHtml(a.substr(1,a.length-1));
									if(a[0] == '1'){
										$('#content-intern').slideDown('slow',function(){
											reLoadFormLama();
										});
									}else{
										$('#content-intern').slideDown('slow');
									}
								}
							});
						});
					},
					function(){
						$('#registrasi-baru-layout').trigger('click');
					}
				);
			}
		}
	});
	$('#seminar-ta1-layout').on('click',function(){
		if(navbarNavigation['t1'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['t1']=1;
				setBreadCrumb({0:'Seminar TA',1:"pertama"});
				setNewContentIntern("Classseminartas/getLayoutTaS",function(){
					SeminarTAS();
				},function(){},function(){});
			}
		}
	});
	$('#seminar-ta2-layout').on('click',function(){
		if(navbarNavigation['t2'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['t2']=1;
				setBreadCrumb({0:'Seminar TA',1:"kedua"});
			}
		}
	});
	$('#lihat-dosen-layout').on('click',function(){
		if(navbarNavigation['dosen'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['dosen']=1;
				setBreadCrumb({0:'Lihat',1:"dosen"});
				setNewContentIntern2("Classdosenpreview/getListDosenAktif",function(){
					mainListDosen();
				});
			}
		}
	});
	$('#lihat-bimbingan-layout').on('click',function(){
		if(navbarNavigation['bimbingan'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['bimbingan']=1;
				setBreadCrumb({0:'Lihat',1:"bimbingan"});
				setNewContentIntern2("Classbimbingan/getLayoutBimbingan",function(){
					mainBimbingan();
				});
			}
		}
	});
	$('#bantuan-layout').on('bantuan',function(){
		if(navbarNavigation['bantuan'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['t1']=1;
				setBreadCrumb({0:'Bantuan'});
			}
		}
	});
});
function resetControlNavigasi(){
	navbarNavigation['home'] = 0;
	navbarNavigation['baru'] = 0;
	navbarNavigation['lama'] = 0;
	navbarNavigation['t1'] = 0;
	navbarNavigation['t2'] = 0;
	navbarNavigation['dosen'] = 0;
	navbarNavigation['bimbingan'] = 0;
	navbarNavigation['bantuan'] = 0;
}
function openLoadingBar(a){
	setLoadingBarMessage(a);
	$('#statusbar-loading').fadeIn('slow');
}
function setLoadingBarMessage(a){
	j('#loading-pesan').setInHtml(a);
}
function closeLoadingBar(){
	$('#statusbar-loading').fadeOut('slow');
}
function setNewContentIntern(data,aa,yes,not){
	openLoadingBar("mengganti layout ...");
	$("#content-intern").slideUp('slow',function(){
		j("#content-intern").setInHtml();
		j("#setAjax").setAjax({
			methode : 'POST',
			url : data+".aspx",
			bool : true,
			content : "",
			sucOk : function(a){
				j("#content-intern").setInHtml(a.substr(1,a.length-1));
				if(a[0] == '1'){
					$('#content-intern').slideDown('slow',function(){
						aa();
					});
				}else if(a[0] == '3'){
					$('#force').on('click',function(){
						yes();
					});
					$('#next').on('click',function(){
						not();
					});
					$('#content-intern').slideDown('slow');
				}else if(a[0] == '4'){
					$('#next').on('click',function(){
						not();
					});
					$('#content-intern').slideDown('slow');
				}else{
					$('#content-intern').slideDown('slow');
				}
				closeLoadingBar()
			}
		});
	});
}


function setNewContentIntern2(data,aa){
	openLoadingBar("mengganti layout ...");
	$("#content-intern").slideUp('slow',function(){
		j("#content-intern").setInHtml();
		j("#setAjax").setAjax({
			methode : 'POST',
			url : data+".aspx",
			bool : true,
			content : "",
			sucOk : function(a){
				j("#content-intern").setInHtml(a.substr(1,a.length-1));
				if(a[0] == '1'){
					$('#content-intern').slideDown('slow',function(){
						aa();
					});
				}else{
					$('#content-intern').slideDown('slow');
				}
				closeLoadingBar()
			}
		});
	});
}