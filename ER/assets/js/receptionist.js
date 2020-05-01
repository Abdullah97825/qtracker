//jQuery Ready Event---->>
$(document).ready(function() {
//this part hides the appointment and patient folder classes
//When you load the page, you start off in the queue tab
  $('.appointmentblock').hide();
  $('.patientblock').hide();
//this is for when you click the appointment tab on the sidebar
//It hides the other classes and shows the appointment class


  $('#appointtab').click(function(event) {
    $('.queueblock').hide();
    $('.patientblock').hide();
    $('.appointmentblock').show();
    $('#queueBtn').hide();
    $('#patientBtn').hide();
    $('#appointBtn').show();
  });
//this is for when you click the patient folder tab on the sidebar
//It hides the other classes and shows the patient folders class
  $('#patienttab').click(function(event) {
    $('.queueblock').hide();
    $('.appointmentblock').hide();
    $('.patientblock').show();
    $('#queueBtn').hide();
    $('#appointBtn').hide();
    $('#patientBtn').show();

  });
//this is for when you click the queue tab on the sidebar
//It hides the other classes and shows the queue class
  $('#queuetab').click(function(event) {
    $('.appointmentblock').hide();
    $('.patientblock').hide();
    $('.queueblock').show();
    $('#patientBtn').hide();
    $('#appointBtn').hide();
    $('#queueBtn').show();
  });


});
