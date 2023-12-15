<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dental Management System - Schedule</title>

    	<!-- Bootstrap CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    	<!-- Bootstrap CSS -->	
    <link href="./Bootstrap/calendarStyle.css" rel="stylesheet">
    <link href="./Bootstrap/homeStyle.css" rel="stylesheet">
	    
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
	<!-- Moment.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
	
	<!-- FullCalendar CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">

	<!-- TouchSwipe -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js"></script>

	<!-- FullCalendar JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
	
	<!-- Bootstrap Datepicker CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

	<!-- Bootstrap Datepicker JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

	<!-- Bootstrap (Required by Bootstrap Datepicker) -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
	
	<!-- Ajax Hammer -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="home.html" class="logo">Jerrmond Dental Clinic</a>
            <ul class="nav-links">
                <li><a href="home.html">Home</a></li>
                <li><a href="services.html">Services</a></li>
            </ul>
            <a href="schedule.php" class="book-appointment-btn">Book an Appointment</a>
        </nav>
    </header>

	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div data-role="main" class="calendar" id="calendar"></div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="appointmentModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Schedule Appointment</h4>
				</div>
				<div class="modal-body">
					<form action="save_appointment.php" id="appointmentForm" method="post" name="appointmentForm">
						<div class="form-group">
							<label for="firstName">First Name:</label> 
							<input class="form-control" id="firstName" name="firstName" required="" type="text">
						</div>
						<div class="form-group">
							<label for="contactNumber">Contact Number:</label> 
							<input class="form-control" id="contactNumber" name="contactNumber" required="" type="text">
						</div>
						<div class="form-group">
							<label for="hmoBenefactor">HMO Benefactor:</label> 
							<select class="form-control" id="hmoBenefactor" name="hmoBenefactor">
								<option value="No">
									No
								</option>
								<option value="Yes">
									Yes
								</option>
							</select>
						</div>
						<div class="form-group" id="hmoPartnerField">
							<label for="hmoPartner">HMO Partner:</label> 
							<select class="form-control" id="hmoPartner" name="hmoPartner">
								<option value="">
									Select an HMO Partner
								</option>
								<option value="Medicard">
									Medicard
								</option>
								<option value="Maxicare">
									Maxicare
								</option>
								<option value="Intellicare">
									Intellicare
								</option>
								<option value="Cocolife">
									Cocolife
								</option>
								<option value="Avega">
									Avega
								</option>
							</select>
						</div>
						<div class="form-group">
							<label for="appointmentDate">Appointment Date:</label> 
							<input class="form-control datepicker" id="appointmentDate" name="appointmentDate" required="" type="text">
						</div>
						<div class="form-group">
							<label for="appointmentTime">Appointment Time:</label> 
							<input class="form-control timepicker" id="appointmentTime" name="appointmentTime" required="" type="text">
						</div><button class="btn btn-primary" type="submit">Save</button>
					</form>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
	    <footer class="footer">
        <div class="container">
            <p>© 2020 Jerrmond Dental Clinic. All rights reserved.</p>
        </div>
    </footer>
	<script>
	         $(document).ready(function() {
	                   $('#hmoBenefactor').change(function() {
	      var selectedValue = $(this).val();
	      if (selectedValue === 'Yes') {
	        $('#hmoPartnerField').show();
	        $('#hmoPartner').prop('disabled', false);
	      } else {
	        $('#hmoPartnerField').hide();
	        $('#hmoPartner').prop('disabled', true);
	      }
	    });
	   
        var selectedDate = null;
	          
        var calendarElement = document.getElementById('calendar');

        var hammer = new Hammer(calendarElement);
              hammer.get('tap').set({
                time: 300
              });
            
              hammer.on('tap', function(event) {
                var selectedDate = $('#calendar').fullCalendar('getDate');
                console.log('Selected date:', selectedDate.toISOString());
            
                var targetElement = event.target;
                console.log('Tapped element:', targetElement);
            
              });


	           $('#calendar').fullCalendar({
	               defaultView: 'agendaWeek',
	               selectable: true,
	               selectHelper: true,
	               select: function(start, end, jsEvent, view) {
	                   $('.fc-highlight-skeleton').removeClass('fc-highlight-skeleton');
	                   var timeCells = $('.fc-time-grid .fc-slats .fc-time[data-time]').filter(function() {
	                       var cellStart = moment($(this).attr('data-date') + ' ' + $(this).attr('data-time'));
	                       var cellEnd = cellStart.clone().add(view.slotDuration, 'ms');
	                       return cellStart.isBetween(start, end) || cellEnd.isBetween(start, end);
	                   });
	                   timeCells.addClass('fc-highlight-skeleton');
	                   var startTime = moment(start);
	                   var endTime = moment(end);
	                   endTime = endTime.clone().subtract(1, 'minutes').endOf('hour');
	                   $('#calendar').fullCalendar('renderSelection', {
	                       start: startTime,
	                       end: endTime
	                   });
	                   selectedDate = startTime;
	                   $('#appointmentForm')[0].reset();
	                   $('#appointmentDate').datepicker('setDate', moment(start).toDate());
	                   $('#appointmentTime').val(moment(start).format('HH:mm'));
	                   $('#appointmentModal').modal('show');
	                   return false;
	               },
	               unselectAuto: false,
	               slotDuration: '01:00:00',
	               timeFormat: 'h:mm A',
	               defaultTimedEventDuration: '01:00:00',
	               events: 'get_events.php',
	               header: {
	                   left: '',
	                   center: 'prev title next',
	                   right: ''
	               },
	               dayNamesShort: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
	               dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
	               titleFormat: 'MMMM YYYY',
	               allDaySlot: false,
	               eventLimit: true,
	               eventLimitClick: 'popover',
	               contentHeight: 1000,
	               businessHours: [
	                   {
	                       dow: [1, 2, 3, 4, 5, 6, 7],
	                       start: '09:00',
	                       end: '18:00'
	                   }
	               ],
	               views: {
	                   agenda: {
	                       minTime: '09:00:00',
	                       maxTime: '18:00:00'
	                   }
	               }
	           });

	           $('.datepicker').datepicker({
	               format: 'yyyy-mm-dd',
	               autoclose: true,
	               todayHighlight: true
	           });

	           $('.timepicker').timepicker({
	               showMeridian: true,
	               showSeconds: false,
	               defaultTime: false
	           });
	       });
	</script>
</body>
</html>