<div id="container">
	<h1>Modify User</h1>

	<div id="body">
		<form id="user_edit">
			<?php foreach($users as $user){ ?>
				<input type="hidden" 	name="e_u_id" value="<?php echo $user->user_id;?>">
				<input type="text" 	  	name="e_username" placeholder="Username"	value="<?php echo $user->username;?>">
				<input type="password" 		name="e_password" placeholder="Password"	value="<?php echo $user->password;?>">
				<input type="text" 	  	name="e_fname" placeholder="First Name"	value="<?php echo $user->fname;?>">
				<input type="text" 	  	name="e_lname" placeholder="Last Name"	value="<?php echo $user->lname;?>">
				<input type="text" 	  	name="e_email" placeholder="Email Address"	value="<?php echo $user->email;?>">
				<input type="text" 	  	name="e_r_id" placeholder="Role ID"	value="<?php echo $user->role_id;?>">
			<?php } ?>
		</form>
		<button id="submit_edit_user">Submit</button>
	</div>
	<h1></h1>


<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">
	//var calltoEdit;
	//populate_access();
	var g_user_id;

	$(document).ready(function(){
		$('#access_table').show();
		var user_id =<?php echo $users[0]->user_id; ?>;
		$('input[name="user_id"]').val(user_id);

		$('#submit_edit_user').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>users/user_edit',
				method:'POST',
				data:$('#user_edit').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('user updated successfully!');
						user_id = data[0].id;
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
