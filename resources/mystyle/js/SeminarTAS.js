var tanggalSewaRuangTA1;
var tanggalSewaRuangDefault;
var uploadFileState = {
	satu : false,
	dua : false,
	tiga : false,
	empat : false
}
var idTanggal = null;
var templateCalendarTAS = 
	'<div style=" color:#333333;">'+
		'<div class=form-row> '+
			'<div class=col-md-3>Jam : </div> '+
			'<div class=col-md-9> '+
				'<div class=input-group> '+
					'<div class=input-group-addon>'+
						'<span class=icon-time></span>'+
					'</div> '+
					'<input id="jam-rung-tas" type=text class="timepicker form-control" value="12:17"/> '+
				'</div>'+ 
			'</div>'+ 
		'</div>'+
		'<div>'+
		'<h6 style="font-size : 0.8em;">*Silahkan masukan sesuai dengan kondisi yang berlaku</h6>'+
		'</div>'+
	'</div>'
;
function SeminarTAS(){
	refreshCalendar();
	refreshButton();
	//alert("ok = "+$(".datetimepicker").length);
	if($(".datetimepicker").length>0)$(".datetimepicker").datetimepicker({nextText:"",prevText:""});
	var xx = new Date();
	tanggalSewaRuangTA1 = xx.getDate()+"/"+xx.getMonth()+"/"+xx.getFullYear()+" "+xx.getHours()+":"+xx.getMinutes()+":"+xx.getSeconds();
	tanggalSewaRuangDefault = true;
	uploadFileState.satu = false;
	uploadFileState.dua = false;
	uploadFileState.tiga = false;
	uploadFileState.empat = false
}
function refreshButton(){
	$("#exec-s-k-bimbingan").click(function(){$("#s-k-bimbingan").trigger('click');});
	$("#s-k-bimbingan").change(function () {
		if (typeof (FileReader) != "undefined") {
			var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.png|.PNG)$/;
			$($(this)[0].files).each(function () {
				var file = $(this);
				if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						j("#s-k-bimbingan").setValue(null);
						$("#exec-s-k-bimbingan").css({
							"backgroundColor" : "red"
						});
						uploadFileState.dua = false;
						modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
						return false;
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							uploadFileState.dua = true;
							$("#exec-s-k-bimbingan").css({
								"backgroundColor" : "green"
							});
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
				} else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.PDF' || t.toLowerCase()==".pdf"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
								j("#s-k-bimbingan").setValue(null);
								$("#exec-s-k-bimbingan").css({
									"backgroundColor" : "red"
								});
								uploadFileState.dua = false;
								modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
								return false;		
							}else{
								uploadFileState.dua = true;
								$("#exec-s-k-bimbingan").css({
									"backgroundColor" : "green"
								});
								return true;
							}
						}else{
							j("#s-k-bimbingan").setValue(null);
							$("#exec-s-k-bimbingan").css({
								"backgroundColor" : "red"
							});
							uploadFileState.dua = false;
							modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
							return false;
						}
				}
			});
		} else {
			j("#s-k-bimbingan").setValue(null);
			$("#exec-s-k-bimbingan").css({
				"backgroundColor" : "red"
			});
			uploadFileState.dua = false;
			modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
			return false;
		}
	});
	$("#exec-s-k-peserta").click(function(){$("#s-k-peserta").trigger('click');});
	$("#s-k-peserta").change(function () {
		if (typeof (FileReader) != "undefined") {
			var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.png|.PNG)$/;
			$($(this)[0].files).each(function () {
				var file = $(this);
				if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						j("#s-k-peserta").setValue(null);
						$("#exec-s-k-peserta").css({
							"backgroundColor" : "red"
						});
						uploadFileState.tiga = false;
						modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
						return false;
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							uploadFileState.tiga = true;
							$("#exec-s-k-peserta").css({
								"backgroundColor" : "green"
							});
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
				} else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.PDF' || t.toLowerCase()==".pdf"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
								j("#s-k-peserta").setValue(null);
								$("#exec-s-k-peserta").css({
									"backgroundColor" : "red"
								});
								uploadFileState.tiga = false;
								modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
								return false;		
							}else{
								uploadFileState.tiga = true;
								$("#exec-s-k-peserta").css({
									"backgroundColor" : "green"
								});
								return true;
							}
						}else{
							j("#s-k-peserta").setValue(null);
							$("#exec-s-k-peserta").css({
								"backgroundColor" : "red"
							});
							uploadFileState.tiga = false;
							modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
							return false;
						}
				}
			});
		} else {
			j("#s-k-peserta").setValue(null);
			$("#exec-s-k-peserta").css({
				"backgroundColor" : "red"
			});
			uploadFileState.tiga = false;
			modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.png)");
			return false;
		}
	});
	$("#exec-s-transkrip").click(function(){$("#s-transkrip").trigger('click');});
	$("#s-transkrip").change(function () {
		if (typeof (FileReader) != "undefined") {
			var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
			$($(this)[0].files).each(function () {
				var file = $(this);
				if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						j("#s-transkrip").setValue(null);
						$("#exec-s-transkrip").css({
							"backgroundColor" : "red"
						});
						uploadFileState.empat = false;
						modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
						return false;	
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							uploadFileState.empat = true;
							$("#exec-s-transkrip").css({
								"backgroundColor" : "green"
							});
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
				} else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.PDF' || t.toLowerCase()==".pdf"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
								j("#s-transkrip").setValue(null);
								$("#exec-s-transkrip").css({
									"backgroundColor" : "red"
								});
								uploadFileState.empat = false;
								modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
								return false;			
							}else{
								uploadFileState.empat = true;
								$("#exec-s-transkrip").css({
									"backgroundColor" : "green"
								});
								return true;
							}
						}else{
							j("#s-transkrip").setValue(null);
							$("#exec-s-transkrip").css({
								"backgroundColor" : "red"
							});
							uploadFileState.empat = false;
							modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
							return false;	
						}
				}
			});
		} else {
			j("#s-transkrip").setValue(null);
			$("#exec-s-transkrip").css({
				"backgroundColor" : "red"
			});
			uploadFileState.empat = false;
			modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
			return false;	
		}
	});
	$("#exec-s-pengantar").click(function(){$("#s-pengantar").trigger('click');});
	$("#s-pengantar").change(function () {
		if (typeof (FileReader) != "undefined") {
			var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
			$($(this)[0].files).each(function () {
				var file = $(this);
				if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						j("#s-pengantar").setValue(null);
						$("#exec-s-pengantar").css({
							"backgroundColor" : "red"
						});
						uploadFileState.satu = false;
						modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
						return false;	
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							uploadFileState.satu = true;
							$("#exec-s-pengantar").css({
								"backgroundColor" : "green"
							});
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
				} else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.PDF' || t.toLowerCase()==".pdf"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
								j("#s-pengantar").setValue(null);
								$("#exec-s-pengantar").css({
									"bgColor" : "red"
								});
								uploadFileState.satu = false;
								modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
								return false;
							}else{
								uploadFileState.satu = true;
								$("#exec-s-pengantar").css({
									"backgroundColor" : "green"
								});
								return true;
							}
						}else{
							j("#s-pengantar").setValue(null);
							$("#exec-s-pengantar").css({
								"backgroundColor" : "red"
							});
							uploadFileState.satu = false;
							modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
							return false;
						}
				}
			});
		} else {
			j("#s-pengantar").setValue(null);
			$("#exec-s-pengantar").css({
				"backgroundColor" : "red"
			});
			uploadFileState.satu = false;
			modalStaticSingleWarning("Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)");
			return false;
		}
	});
}
function refreshCalendar(){
	if($("#calendar").length>0){
		var e=new Date();
		var t=e.getDate();
		var n=e.getMonth();
		var r=e.getFullYear(); //2016
		$("#external-events .external-event").each(function(){
			var e={title:$.trim($(this).text())};$(this).data("eventObject",e);
		$(this).draggable({zIndex:999,revert:true,revertDuration:0})});
		
		var Calenders = $("#calendar").fullCalendar({
			header:{
				left:"prev,next today",
				center:"",
				right : ""
				//center:"title",
				//right:"month,agendaWeek,agendaDay"
				}
			,editable:true,events:[
			{
				title:"All Day Event",
				start:new Date(r,n,1)},
			{
				title:"Long Event",
				start:new Date(r,n,t-5),
				end:new Date(r,n,t-2)},
			{
				id:999,title:"Repeating Event",
				start:new Date(r,n,t-3,16,0),
				allDay:false},
			{
				id:999,
				title:"Repeating Event",
				start:new Date(r,n,t+4,16,0),
				allDay:false},
			{
				title:"Meeting",
				start:new Date(r,n,t,10,30),
				allDay:false},
			{
				title:"Meeting2",
				start:new Date(r,n,t,22,30),
				allDay:false},
			{
				title:"Lunch",
				start:new Date(r,n,t,12,0),
				end:new Date(r,n,t,14,0),
				allDay:false},
			{
				title:"Birthday Party",
				start:new Date(r,n,t+1,19,0),
				end:new Date(r,n,t+1,22,30),
				allDay:false}],
			droppable:false,
			selectable:true,
			selectHelper:false,
			eventStartEditable : false,
			eventDurationEditable : false,
			disableResizing : true,
			select:function(e,t,n){
				modalStaticBodyMultipleButton("Masukan jam seminar anda",templateCalendarTAS,function(){
					var TEMP_TIME = new Date();
					var test4 = new  Date(TEMP_TIME.getFullYear(),test.getMonth(),test.getDate(),test2.getHours()+2,test2.getMinutes(),0,0);
					if(idTanggal == null){
						idTanggal = "aktifNow";	
						Calenders.fullCalendar("renderEvent",{
							id:idTanggal,
							title:"hohoho",
							start: test3,
							end:test4,
							allDay:n},true)
					}else{
						$('#calendar').fullCalendar('removeEvents', idTanggal);
						Calenders.fullCalendar("renderEvent",{
							id:idTanggal,
							title:"hohoho",
							start:test3,
							end:test4,
							allDay:n},true)
					}
				},function(){
					$('#jam-rung-tas').on('blur', function(){
						getCheckJam($(this).val(),function(){
							$('#jam-rung-tas').css({
								"borderColor" : "green",
							});
						},function(){
							$('#jam-rung-tas').css({
								"borderColor" : "red",
							});
							var TEMP_DATE = new Date();
							$("#jam-rung-tas").val(TEMP_DATE.getHours()+":"+TEMP_DATE.getMinutes());
							$('#jam-rung-tas').css({
								"borderColor" : "green",
							});
						});
					});
				});
				if($(".timepicker").length>0)$(".timepicker").timepicker();
				if($(".datepicker").length>0)$(".datepicker").datepicker({nextText:"",prevText:""});
				//if(r){
					
				//}
			//Calenders.fullCalendar("unselect")
			//Object.freeze();
			},
			//	update Event
		    /*
			eventClick: function(calEvent, jsEvent, view) {
				modalStaticMultipleButton(message,a);
				$('#calendar').fullCalendar('removeEvents', event.id);
		   	}
			*/
			eventClick: function(calEvent, jsEvent, view) {
				if(idTanggal != null){
					if(calEvent.id == idTanggal)
						modalStaticMultipleButton("Anda ingin menghapus even ini ",function(){
							$('#calendar').fullCalendar('removeEvents', calEvent.id);
						});
				}
			}
		});
	}
}
function getCheckJam(jam,tr,fl){
	var xx = Date.parse(jam);
	xx = new Date(xx);
	if(isNaN(xx.getHours()) || isNaN(xx.getMinutes())){
		fl();
		return false;
	}
	tr();
	return true;
}
// 