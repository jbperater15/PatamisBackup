<div id="container">
	<h1>Modify Role</h1>

	<div id="body">
		<form id="role_edit">
			<?php foreach($roles as $role){ ?>
				<input type="hidden" 	name="e_r_id" value="<?php echo $role->role_id;?>">
				<input type="text" 	  	name="e_r_code" placeholder="Role Code"	value="<?php echo $role->role_code;?>">
				<input type="text" 		name="e_r_name" placeholder="Role Name"	value="<?php echo $role->role_name;?>">
				<input type="text" 	  	name="e_r_desc" placeholder="Role Description"	value="<?php echo $role->role_description;?>">
			<?php } ?>
		</form>
		<button id="submit_edit_role">Submit</button>
	</div>
	<h1></h1>


<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">
	//var calltoEdit;
	//populate_access();
	var g_role_id;

	$(document).ready(function(){
		$('#access_table').show();
		var role_id =<?php echo $roles[0]->role_id; ?>;
		$('input[name="role_id"]').val(role_id);

		$('#submit_edit_role').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>roles/role_edit',
				method:'POST',
				data:$('#role_edit').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('Role updated successfully!');
						role_id = data[0].id;
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
