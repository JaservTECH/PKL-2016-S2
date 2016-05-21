/**
 * Author : Jafar Abdurrahan Albasyir
 * nama file : gateinout.js
 * file module : jquery.min.js
 */
//variabel global
var daftar = {};
var daftarMessage = {};
var daftarId = {
		0:'daftar-nim',
		1:'daftar-nama',
		2:'daftar-kunci',
		3:"daftar-kuncire",
		4:'daftar-apes',
		5:'daftar-ntelp',
		6:'daftar-foto',
		7:'daftar-trans',
		8:'login-akun',
		9:'login-nim',
		10:'login-password'
};
var daftarIdMessage = {
		0:'Nim anda belum dimasukan',
		1:'Nama anda belum di masukan',
		2:'Kata kunci anda belum di masukan',
		3:"Kata kunci konfirmasi harus di masukan",
		4:'Alamat email anda belum dimasukan',
		5:'No telefon anda belum dimasukan',
		6:'Anda belum memilih foto Apapun',
		7:'Transkrip belum anda sertakan',
		8:'kode akun anda tidak terdaftar',
		9:'nim anda belum dimasukan',
		10:'password anda belum dimasukan'
};
//initializing global
$(document).ready(function(){
	initializingMasuk();
	initializingDaftar();
	j('#signin-layout-active').setOnClick(function(){
		$('#signInLayout').slideDown('slow');
		$('#signUpLayout').slideUp('slow');
	});
	j('#signup-layout-active').setOnClick(function(){
		$('#signInLayout').slideUp('slow');
		$('#signUpLayout').slideDown('slow');
	});
	/*change*/
	$('#login-nim').on('change',function(){
		checkInput('login-nim',$(this).val(),'gateinout/getCheck',true);
	});
	$('#login-password').on('change',function(){
		checkInput('login-password',$(this).val(),'gateinout/getCheck',true);
	});
	$('#login-akun').on('change',function(){
		checkInput('login-akun',$(this).val(),'gateinout/getCheck',true);
	});
	$('#daftar-nim').on('change',function(){
		checkInput('daftar-nim',$(this).val(),'gateinout/getCheck',true);
	});
	$('#daftar-nama').on('change',function(){
		checkInput('daftar-nama',$(this).val(),'gateinout/getCheck',true);
	});
	$('#daftar-apes').on('change',function(){
		checkInput('daftar-apes',$(this).val(),'gateinout/getCheck',true);
	});
	$('#daftar-kunci').on('change',function(){
		checkInput('daftar-kunci',$(this).val(),'gateinout/getCheck',true);
		compareValueInput('daftar-kunci','daftar-kuncire','Kata Kunci harus sama dengan kata kunci konfirmasi');
	});
	$('#daftar-kuncire').on('change',function(){
		checkInput('daftar-kuncire',$(this).val(),'gateinout/getCheck',true);
		compareValueInput('daftar-kuncire','daftar-kunci','Kata Kunci konfirmasi harus sama dengan kata kunci');
	});
	$('#daftar-ntelp').on('change',function(){
		checkInput('daftar-ntelp',$(this).val(),'gateinout/getCheck',true);
	});
	/*blur*/
	/*foto dan trans*/
	$('#daftar-foto').on('click',function(){
		$('#daftar-foto-exe').trigger('click');
	});
	$('#daftar-trans').on('click',function(){
		$('#daftar-trans-exe').trigger('click');
	});
	$("#daftar-foto-exe").change(function () {
        if (typeof (FileReader) != "undefined") {
            var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.png|.jpg)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 0.5){
						daftar['daftar-foto'] = 0;
						daftarMessage['daftar-foto'] = file[0].name+" , memiliki ukuran lebih dari 500kb";
						j('#daftar-foto-exe').setValue(null);
						openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
						return false;
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							j("#preview-foto").getObject().src = e.target.result;
							daftar['daftar-foto'] = 1;
							daftarMessage['daftar-foto'] = "Valid";
							return true;
						}
						reader.readAsDataURL(file[0]);	
					}
                } else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.JPG' || t.toLowerCase()==".jpg" || t=='.PNG' || t.toLowerCase()==".png"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 0.5){
								daftar['daftar-foto'] = 0;
								daftarMessage['daftar-foto'] = file[0].name+" , memiliki ukuran lebih dari 500kb";
								j('#daftar-foto-exe').setValue(null);
								openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
								return false;
							}else{							
								j("#preview-foto").getObject().src = e.target.result;
								daftar['daftar-foto'] = 1;
								daftarMessage['daftar-foto'] = "Valid";
								return true;	
							}
						}else{
							daftar['daftar-foto'] = 0;
							daftarMessage['daftar-foto'] = file[0].name+" , format file yang di dukung jpg atau png";
							j('#daftar-foto-exe').setValue(null);
							openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
							return false;
						}
                }
            });
        } else {
			daftar['daftar-foto'] = 0;
			daftarMessage['daftar-foto'] = "Browser anda tidak mendukung HTML5 FileReader";
			j('#daftar-foto-exe').setValue(null);
			openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
			return false;
        }
    });

	$("#daftar-trans-exe").change(function () {
        if (typeof (FileReader) != "undefined") {
            var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						daftar['daftar-trans'] = 0;
						daftarMessage['daftar-trans'] = file[0].name+" , memiliki ukuran lebih dari 1 mb";
						j('#daftar-trans-exe').setValue(null);
						openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
						return false;
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							
							daftar['daftar-trans'] = 1;
							daftarMessage['daftar-trans'] = "Valid";
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
                } else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.PDF' || t.toLowerCase()==".pdf"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
								daftar['daftar-trans'] = 0;
								daftarMessage['daftar-trans'] = file[0].name+" , memiliki ukuran lebih dari 1 mb";
								j('#daftar-trans-exe').setValue(null);
								openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
								return false;
							}else{
								//j("#preview-trans").getObject().src = e.target.result;
								daftar['daftar-trans'] = 1;
								daftarMessage['daftar-trans'] = "Valid";
								return true;
							}
						}else{
							daftar['daftar-trans'] = 0;
							daftarMessage['daftar-trans'] = file[0].name+" , format file yang di dukung pdf";
							j('#daftar-trans-exe').setValue(null);
							openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
							return false;
						}
                }
            });
        } else {
			daftar['daftar-trans'] = 0;
			daftarMessage['daftar-trans'] = "Browser anda tidak mendukung HTML5 FileReader";
			j('#daftar-trans-exe').setValue(null);
			openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
			return false;
        }
    });
	/**/
	$('#login-exe').on('click',function(){
		$(this).prop('disabled','true');
		setTimeout(function(){
			checkInput('login-nim',$('#login-nim').val(),'gateinout/getCheck',true);
			checkInput('login-password',$('#login-password').val(),'gateinout/getCheck',true);
			checkInput('login-akun',$('#login-akun').val(),'gateinout/getCheck',true);
			var zz='Kesalahan terjadi pada saat proses masuk(<i><b>login</b></i>) : <br>';
			if(totalValiditySignIn()){
				$('#masuk-form-validation').trigger('submit');
			}else{
				zz+="<ol>";
				for(var i=8;i<11;i++){
					if(daftar[daftarId[i]] == 0){
						zz+="<li>"+daftarMessage[daftarId[i]]+"</li>";
					}
				}
				$('#login-exe').removeAttr('disabled');
				zz+="</ol>Silahkan lengkapi atau perbaiki inputan anda, bacalah <a id='peraturan-link' class='text-center pointer'>peraturan</a> untuk informasi lebi lengkap";
				openAlertDialog(zz);
				$('#peraturan-link').on('click',function(){
					$('#user-alert').modal('hide');
					$('#user-term').modal('show');
				});
			}
		},500);
	});
	$('#daftar-exe').on('click',function(){
		$(this).prop('disabled','true');
		setTimeout(function(){
			checkInput('daftar-nim',$('#daftar-nim').val(),'gateinout/getCheck',true);
			checkInput('daftar-nama',$('#daftar-nama').val(),'gateinout/getCheck',true);
			checkInput('daftar-apes',$('#daftar-apes').val(),'gateinout/getCheck',true);
			checkInput('daftar-kunci',$('#daftar-kunci').val(),'gateinout/getCheck',true);
			checkInput('daftar-kuncire',$('#daftar-kuncire').val(),'gateinout/getCheck',true);
			checkInput('daftar-ntelp',$('#daftar-ntelp').val(),'gateinout/getCheck',true);
			if(j('#daftar-foto-exe').getValue() == ""){
				daftar['daftar-foto'] = 0;
				daftarMessage['daftar-foto'] = "foto belum di pilih sama sekali";
			}
			if(j('#daftar-trans-exe').getValue() == ""){
				daftar['daftar-trans'] = 0;
				daftarMessage['daftar-trans'] = "transkrip belum di pilih sama sekali";
			}
			var qq='Kesalahan terjadi pada saat proses pendaftaran : <br>';
			if(totalValidity()){
				if($('#daftar-check-exe div').attr('aria-checked') == "true"){
					$('#daftar-form-validation').trigger('submit');
				}else{
					$('#daftar-exe').removeAttr('disabled');
					qq+="Anda harus menyutujui peraturan yang berlaku, jika anda belum membaca peraturan tersebut, silahkan baca baca <a id='peraturan-link' class='text-center pointer'>disini</a>"
					openAlertDialog(qq);
					$('#peraturan-link').on('click',function(){
						$('#user-alert').modal('hide');
						$('#user-term').modal('show');
					});
				}
			}else{
				qq+="<ol>";
				for(var i=0;i<8;i++){
					if(daftar[daftarId[i]] == 0){
						qq+="<li>"+daftarMessage[daftarId[i]]+"</li>";
					}
				}
				$('#daftar-exe').removeAttr('disabled');
				qq+="</ol>Silahkan lengkapi atau perbaiki inputan anda, bacalah <a id='peraturan-link' class='text-center pointer'>peraturan</a> untuk informasi lebi lengkap";
				openAlertDialog(qq);
				$('#peraturan-link').on('click',function(){
					$('#user-alert').modal('hide');
					$('#user-term').modal('show');
				});
			}
		},500);
	});
	$('#masuk-form-validation').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnReponse = response.html();
			iframe.unbind('load');
			if(parseInt(returnReponse[0]) == 1){
				initializingMasuk();
				$('body').slideUp('slow',function(){
					$(location).attr('href', returnReponse.substr(1,returnReponse.length-1));
				});
			}else{
				openAlertDialog(returnReponse.substr(1,returnReponse.length-1));
			}
			$('#login-exe').removeAttr('disabled');
			setTimeout(function ()
			{
				response.html('');
			}, 1);
		});
	});
	$('#daftar-form-validation').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnReponse = response.html();
			iframe.unbind('load');
			if(parseInt(returnReponse[0]) == 1){
				openAlertDialog(returnReponse.substr(1,returnReponse.length-1));
				$('#signInLayout').slideDown('slow');
				$('#signUpLayout').slideUp('slow');
				initializingDaftar();
			}else{
				openAlertDialog(returnReponse.substr(1,returnReponse.length-1));
			}
			$('#daftar-exe').removeAttr('disabled');
			setTimeout(function ()
			{
				response.html('');
			}, 1);
		});
	});
});
/*function*/
function totalValiditySignIn(){
	var temp = 0;
	for(var i=8;i<11;i++){
		temp += daftar[daftarId[i]];
	}
	if(temp == 3)
		return true;
	else
		return false;
	
}
function totalValidity(){
	var temp = 0;
	for(var i=0;i<8;i++){
		temp += daftar[daftarId[i]];
	}
	if(temp == 8)
		return true;
	else
		return false;
}
function initializingMasuk(){
	for(var i=8;i<11;i++){
		daftar[daftarId[i]]=0;
		daftarMessage[daftarId[i]]=daftarIdMessage[i];
		j("#"+daftarId[i]).setValue("");
		$('#'+daftarId[i]).css('border-color',"#d2d6de");
	}
}
function initializingDaftar(){
	for(var i=0;i<6;i++){
		daftar[daftarId[i]]=0;
		daftarMessage[daftarId[i]]=daftarIdMessage[i];
		j("#"+daftarId[i]).setValue("");
		$('#'+daftarId[i]).css('border-color',"#d2d6de");
	}
	j("#preview-foto").getObject().src = "http://localhost/siataiiiS/image/mhs/siata_core_image_default.png";
	j('#daftar-foto-exe').setValue(null);
	daftar[daftarId[6]] = 0;
	daftarMessage[daftarId[6]]=daftarIdMessage[6];
	j('#daftar-trans-exe').setValue(null);
	daftar[daftarId[7]] = 0;
	daftarMessage[daftarId[7]]=daftarIdMessage[7];
}

function compareValueInput(id1,id2,message){
	if($('#'+id2).val()!=""){
		if($('#'+id1).val()!=$('#'+id2).val()){
			daftar[id1]=0;
			daftarMessage[id1]=message;
			openAlertDialogWithFunc(daftarMessage[id1],function(){$('#'+id1).focus().css('border-color','red');});
		}else{
			daftar[id1]=1;
			daftarMessage[id1]='valid';
			$('#'+id1).css('border-color',"green");
			daftar[id2]=1;
			daftarMessage[id2]='valid';
			$('#'+id2).css('border-color',"green");
		}
	}
}
function openAlertDialog(message){
	j("#user-alert-message").setInHtml(message);
	$('#user-alert').modal({backdrop:'static'});
	var dataCloseAlert = function(){
		$("#user-alert").modal('hide');
		j("#user-alert-message").setInHtml("");
		$('#user-alert-close').unbind('click',dataCloseAlert);
	}
	$('#user-alert-close').bind('click',dataCloseAlert).focus();
}
function openAlertDialogWithFunc(message,func){
	j("#user-alert-message").setInHtml(message);
	$('#user-alert').modal({backdrop:'static'});
	var dataCloseAlert = function(){
		$("#user-alert").modal('hide');
		setTimeout(function(){
			func();
			$('#user-alert-close').unbind('click',dataCloseAlert);
			j("#user-alert-message").setInHtml("");
		},100);
	}
	$('#user-alert-close').bind('click',dataCloseAlert).focus();
}
function openAlertDialogWithClick(message,id){
	j("#user-alert-message").setInHtml(message);
	$('#user-alert').modal({backdrop:'static'});
	var dataCloseAlert = function(){
		$("#user-alert").modal('hide');
		$('#'+id).trigger('click');
		$('#user-alert-close').unbind('click',dataCloseAlert);
		j("#user-alert-message").setInHtml("");
	}
	$('#user-alert-close').bind('click',dataCloseAlert).focus();
}
function addAlertValidasiInput(message,object){
	var a=object.parentNode;
	a.childNodes[1].innerHTML = 
		"<div style='opacity: 0.87; position: absolute; top: 0px; left: 10px; margin-top: -27px;' class='alert-validation-content'>"+
		"<div class='formErrorConten'>"+message+"<br>"+
		"</div>"+
	"</div>";
}
function removeAlertValidateInput(object){
	var a=object.parentNode;
	a.childNodes[1].innerHTML = "";
}
function checkInput(switchs,value,url,kodealert){
	j("#setAjax").setAjax({
		methode : 'POST',
		url : url+".aspx",
		bool : true,
		content : "variabel="+switchs+"&value="+value,
		sucOk : function(a){
			daftar[switchs]= parseInt(a[0]);
			daftarMessage[switchs]=a.substr(1,a.length-1);
			if(daftar[switchs] == 0){
				if(kodealert){
					addAlertValidasiInput(daftarMessage[switchs],j('#'+switchs).getObject());
					$('#'+switchs).focus().css('border-color','red');
				}
					//openAlertDialogWithFunc(daftarMessage[switchs],function(){$('#'+switchs).focus().css('border-color','red');});
				else
					$('#'+switchs).css('border-color',"red");
			}else{
				removeAlertValidateInput(j('#'+switchs).getObject());
				$('#'+switchs).css('border-color',"green");
			}
		}
	});
}