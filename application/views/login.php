<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div id="container">
	<h1>PATAMIS LOGIN</h1>

	<div id="body">
		<form id="log_form">
			<input type="text" 	  	name="uname" placeholder="Username">
			<input type="password" 	name="upass" placeholder="Password">
		</form>
		<button id="submit_log">Submit</button>
	</div>
<!-- 	<a id="linkni">Google Login</a> -->
	
</div>

<script type="text/javascript">

$(document).ready(function(){
	
	$('#submit_log').click(function(){

	      $.ajax({
                     url: '<?php echo base_url(); ?>/login/req_login',
                     method:'post',
                     data:{'uname': $('input[name="uname"]').val(), 'pass':$('input[name="upass"]').val()},
                     dataType:'json',
                     success: function (data) {
                            $('#log_form')[0].reset();
                            if(data.msg == 'success'){
                            	alert('Success');
                            	window.location.href = "http://localhost/patamis/login/check_session";
                            }else{
                            	alert('Fail')
                            }
                     },
                     complete: function() {
                     },
                     beforeSend: function(){
                     },
                     error: function(response, status, xhr) {
                     }
              });
	});

});

</script>
