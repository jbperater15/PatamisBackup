<div id="container">
	<h1>Add Roles</h1>

	<div id="body">
		<form id="role_add">
			<input type="text" 	  	name="r_code" placeholder="Role Code">
			<input type="text" 		name="r_name" placeholder="Role Name">
			<input type="text" 	  	name="r_desc" placeholder="Role Description">
		</form>
		<button id="submit_role">Submit</button>
	</div>
	<h1></h1>


<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$('#access_table').hide();
		var role_id=1;
		$('input[name="role_id"]').val(0);

		$('#submit_role').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>roles/role_add',
				method:'POST',
				data:$('#role_add').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('Role added successfully!');
						$('#access_table').show();
						$('input[name="role_id"]').val(data[0].id);
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
