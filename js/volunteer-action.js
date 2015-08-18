jQuery(function(){
  $('#volunteerButton').on('click',function(){
        $('div.errors').fadeOut();
        var formValidate = function(dCheck){
           var checkedForm = '';
           dCheck.email = dCheck.email || '';
           dCheck.zipcode   = dCheck.zipcode || '';
           dCheck.phone = dCheck.phone || '';
           if(dCheck.email.length < 4 || dCheck.email.indexOf('@') < 0){
              checkedForm = "Valid email required";
           }else
           if(dCheck.zipcode.length < 2  || !dCheck.zipcode){
              checkedForm = "Valid zipcode required";
           }else
           if(dCheck.phone.length < 4 || !dCheck.phone){
              checkedForm = "Valid phone number required";
           }else{
              checkedForm = false;
           }

           return checkedForm;
        };
	vData = {
  	'email': $('#v_email').val(),
  	'zipcode': $('#v_zip').val(),
  	'phone': $('#v_phone').val(),
  	'first_name': $('#v_first').val(),
  	'last_name': $('#v_last').val(), 
  	'volunteer': ($('#v_volunteer').is(':checked') ? 'Yes' : 'No'),
 	 'source': '' ,
  	'dont_redirect':true,
  	};
        
        var hasErrors = formValidate(vData);
        if(!hasErrors){
	$.post('https://pledge.lessigforpresident.com/r/subscribe',vData,function(res){
   	console.log(res);
	$('#volunteerAreaSignup').parent().parent().fadeOut();
window.scrollTo(0,0);
$('#volunteerConfirm').fadeIn(300);
	});
        }else{
          $('div.errors').text(hasErrors);
          $('div.errors').fadeIn();
        }

  });
});
