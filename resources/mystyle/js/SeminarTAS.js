function SeminarTAS(){
	refreshCalendar();
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
				center:"title",
				right:"month,agendaWeek,agendaDay"}
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
				allDay:false},
			{
				title:"Click for Google",
				start:new Date(r,n,28),
				end:new Date(r,n,29),
				url:"http://google.com/"}],
			droppable:false,
			selectable:true,
			selectHelper:false,
			eventStartEditable : false,
			eventDurationEditable : false,
			disableResizing : true,
			select:function(e,t,n){
				var r=prompt("Event Title:");
				if(r){
					Calenders.fullCalendar("renderEvent",{
						title:r,
						start:e,
						end:t,
						allDay:n},true)
				}
			Calenders.fullCalendar("unselect")
			Object.freeze();
			},
			//	update Event
		    eventClick: function(event, element) {
				alert(event.id);
		        event.title = "CLICKED!";
				//event = null;
		        //$('#calendar').fullCalendar('updateEvent', event);
				$('#calendar').fullCalendar('removeEvents', event.id);
		   	}
		})
	}
}
// 