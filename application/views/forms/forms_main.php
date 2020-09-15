


<div id="container">
	<h1>FORMS</h1>

	<div id="body">
		<div>
			<div class="add_link"><a href="<?php echo base_url(); ?>forms/add_form">Add Form</a></div>
		</div>
		<div>
			<table class="table">
				<thead>
					<tr>
						<th>Form Code</th>
						<th>Form Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="form_list">
				</tbody>
				
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">

	var calltoEdit;
	var calltoDelete;

	$(document).ready(function(){

		onload();


		calltoEdit = function(form_id){
	 		$.redirect('<?php echo base_url();?>forms/edit_form', {'formId': form_id});
	 	}

	 	calltoDelete = function(form_id){
	 		if (confirm('Are you sure you want to delete it?')) {
			    $.ajax({
		 			url:'<?php echo base_url();?>/forms/form_delete',
		 			method:'POST',
		 			data:{'formId' : form_id},
		 			dataType:'json',
		 			success: function(data){
		 				(data[0].error == 0 ? onload() : alert(data[0].msg) );
		 			}
		 		});
			} else {
			    alert('You have cancelled the deletion.');
			}
	 		//$.redirect('<?php echo base_url();?>forms/delete_form',{'formId': form_id});
	 	}
 
	 	function onload(){
	 		$('#form_list').html('');
	 		$.ajax({
	 			url:'<?php echo base_url();?>/forms/form_list',
	 			method:'POST',
	 			dataType:'json',
	 			success: function(data){
	 				var trHTML;
	 				$.each(data, function(i, item) {
	 						trHTML += '<tr>'
	 								+ '<td>'+data[i].form_code+'</td>'
	 								+ '<td>'+data[i].form_name+'</td>'
	 								+ '<td><a class="edit_link" href="javascript:calltoEdit('+data[i].form_id+');">Edit</a>'
	 								+ ' | <a class="delete_link" href="javascript:calltoDelete('+data[i].form_id+');">Delete</a> </td>';
	 								console.log('1');

                    });
                    $('#form_list').append(trHTML);
                    console.log('1');
                    load_access();
	 			}
	 		});
	 		
	 	}

	 	

	});
</script>
