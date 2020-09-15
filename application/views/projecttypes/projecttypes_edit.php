<div id="container">
	<h1>Project Type Edit</h1>

	<div id="body">
		<form id="prjType_edit">
			<?php foreach($prjType as $pt){ ?>
				<input type="hidden" 	name="e_prjtype_id" value="<?php echo $pt->project_type_id;?>">
				<input type="text" 	  	name="e_prj_type" placeholder="Project Type"	value="<?php echo $pt->project_type;?>">
				<input type="text" 		name="e_prj_name" placeholder="Type Name"		value="<?php echo $pt->type_name;?>">
			<?php } ?>
		</form>
		<button id="submit_edit_prjtype">Submit</button>
	</div>
	<h1></h1>


<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">
	//var calltoEdit;
	//populate_access();
	var g_role_id;

	$(document).ready(function(){
		$('#requirements_table').show();
		var prjType_id =<?php echo $prjType[0]->project_type_id; ?>;
		$('input[name="prjtype_id"]').val(prjType_id);

		$('#submit_edit_prjtype').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>projecttypes/prjtype_edit',
				method:'POST',
				data:$('#prjType_edit').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('Role updated successfully!');
						//role_id = data[0].id;
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