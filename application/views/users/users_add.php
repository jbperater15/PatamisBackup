<div id="container">
	<h1>Add User</h1>

	<div id="body">
		<form id="user_add">
			<input type="text" 	  	name="username" 	placeholder="Username">
			<input type="password" 		name="password" 	placeholder="Password">
			<input type="text" 	  	name="fname" 	placeholder="First Name">
			<input type="text" 	  	name="lname" 	placeholder="Last Name">
			<input type="text" 	  	name="email" 	placeholder="Email Address">
			<input type="text" 	  	name="role_id" 	placeholder="Role">
		</form>
		<button id="submit_user">Submit</button>
	</div>
<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#submit_user').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>/users/user_add',
				method:'POST',
				data:$('#user_add').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('User updated successfully!');
						$('#user_add')[0].reset();
						window.location.href = "<?php echo base_url().'users';?>";
					}
				},
				complete: function(){

				},
				beforeSend: function(){

				},
				error: function(){

				}
			});
		});

	});
</script>
