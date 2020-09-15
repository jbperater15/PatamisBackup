<div id="container">
	<h1>Add Forms</h1>

	<div id="body">
		<form id="form_add">
			<input type="text" 	  	name="f_code" 	placeholder="Form Code">
			<input type="text" 		name="f_name" 	placeholder="Form Name">
			<input type="text" 		name="filename" placeholder="File Name">
			<input type="text" 	  	name="f_desc" 	placeholder="Form Description">
		</form>
		<button id="submit_form">Submit</button>
	</div>
<!-- 	<a id="linkni">Google Login</a> -->
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#submit_form').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>/forms/form_add',
				method:'POST',
				data:$('#form_add').serialize(),
				dataType:'json',
				success: function(data){
					if(data[0].error == '0'){
						alert('Form updated successfully!');
						$('#form_add')[0].reset();
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
