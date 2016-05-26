
var idTanggal = null;
function SeminarTAS(){
	refreshCalendar();
	refreshButton();
	$('#datetimepicker2').datetimepicker({
			locale: 'id'
		});
}
function refreshButton(){
	$("#exec-s-k-bimbingan").click(function(){$("#s-k-bimbingan").trigger('click');});
	$("#s-k-bimbingan").change(function () {
		if (typeof (FileReader) != "undefined") {
			var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
			$($(this)[0].files).each(function () {
				var file = $(this);
				if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						j("#s-k-bimbingan").setValue(null);
						return false;						
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
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
								return false;								
							}else{
								return true;
							}
						}else{
							j("#s-k-bimbingan").setValue(null);
							return false;
						}
				}
			});
		} else {
			j("#s-k-bimbingan").setValue(null);
			return false;
		}
	});
	$("#exec-s-k-peserta").click(function(){$("#s-k-peserta").trigger('click');});
	$("#s-k-peserta").change(function () {
		if (typeof (FileReader) != "undefined") {
			var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
			$($(this)[0].files).each(function () {
				var file = $(this);
				if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						j("#s-k-peserta").setValue(null);
						return false;						
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
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
								return false;								
							}else{
								return true;
							}
						}else{
							j("#s-k-peserta").setValue(null);
							return false;
						}
				}
			});
		} else {
			j("#s-k-peserta").setValue(null);
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
						return false;						
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
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
								return false;								
							}else{
								return true;
							}
						}else{
							j("#s-transkrip").setValue(null);
							return false;
						}
				}
			});
		} else {
			j("#s-transkrip").setValue(null);
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
						return false;						
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
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
								return false;								
							}else{
								return true;
							}
						}else{
							j("#s-pengantar").setValue(null);
							return false;
						}
				}
			});
		} else {
			j("#s-pengantar").setValue(null);
			return false;
		}
	});
}
function refreshCalendar(){
	if($("#calendar").length>0){
		var e=new Date;
		var t=e.getDate();
		var n=e.getMonth();
		var r=e.getFullYear();
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
				var r=prompt("Event Title:");
				if(r){
					if(idTanggal == null){
						idTanggal = "aktifNow";	
						Calenders.fullCalendar("renderEvent",{
							id:idTanggal,
							title:r,
							start:e,
							end:t,
							allDay:n},true)
					}else{
						$('#calendar').fullCalendar('removeEvents', idTanggal);
						Calenders.fullCalendar("renderEvent",{
							id:idTanggal,
							title:r,
							start:e,
							end:t,
							allDay:n},true)
					}
				}
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
						modalStaticMultipleButton("",function(){
						
						});
				}
			}
		});
	}
}
// 