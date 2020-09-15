<div id="container">
	<h1>Add Project Types</h1>

	<div id="body">
		<form id="prjtype_add">
			<input type="text" 	  	name="prj_type" placeholder="Project Type">
			<input type="text" 		name="prj_name" placeholder="Project Name">
		</form>
		<button id="submit_prjType">Submit</button>
	</div>
	<h1></h1>


<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">

	$(document).ready(function(){
		//$('#requirements_table').hide();
		var role_id=1;
		$('input[name="prjtype_id"]').val(0);

		$('#submit_prjType').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>projecttypes/prjtype_add',
				method:'POST',
				data:$('#prjtype_add').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('Project Type added successfully!');
						$('#requirements_table').show();
						$('input[name="prjtype_id"]').val(data[0].id);
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
