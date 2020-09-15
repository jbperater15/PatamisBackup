<div id="container">
	<h1>Modify Form</h1>

	<div id="body">
		<form id="form_edit">
			<?php foreach($forms as $frm) { ?>
				<input type="hidden"	name="e_f_id"   value="<?php echo $frm->form_id;?>">
				<input type="text" 	  	name="e_f_code" value="<?php echo $frm->form_code;?>"			placeholder="Form Code">
				<input type="text" 		name="e_f_name" value="<?php echo $frm->form_name;?>"			placeholder="Form Name">
				<input type="text" 	  	name="e_f_desc" value="<?php echo $frm->form_description;?>"	placeholder="Form Description">
			<?php } ?>
		</form>
		<button id="submit_edit_form">Submit</button>
	</div>
<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#submit_edit_form').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>/forms/form_edit',
				method:'POST',
				data:$('#form_edit').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('Form updated successfully!');
						window.location.href = "<?php echo base_url().'forms';?>";
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
