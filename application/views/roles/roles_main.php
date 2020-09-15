
<div id="container">
	<h1>ROLES</h1>

	<div id="body">
		<div>
			<a href="<?php echo base_url(); ?>roles/add_role">Add Role</a>
		</div>
		<div>
			<table class="table">
				<thead>
					<tr>
						<th>Role Code</th>
						<th>Role Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="role_list">
				</tbody>
				
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">

	

	$(document).ready(function(){

		onload();

		calltoEdit = function(role_id){
	 		$.redirect('<?php echo base_url();?>roles/edit_role', {'roleId': role_id});
	 	}

	 	calltoDelete = function(role_id){
	 		if (confirm('Are you sure you want to delete it?')) {
			    $.ajax({
		 			url:'<?php echo base_url();?>/roles/role_delete',
		 			method:'POST',
		 			data:{'roleId' : role_id},
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
	 		$('#role_list').html('');
	 		$.ajax({
	 			url:'<?php echo base_url();?>/roles/role_list',
	 			method:'POST',
	 			dataType:'json',
	 			success: function(data){
	 				var trHTML;
	 				$.each(data, function(i, item) {
	 						trHTML += '<tr>'
	 								+ '<td>'+data[i].role_code+'</td>'
	 								+ '<td>'+data[i].role_name+'</td>'
	 								+ '<td><a href="javascript:calltoEdit('+data[i].role_id+');">Edit</a>	<a href="javascript:calltoDelete('+data[i].role_id+');">Delete</a> </td>';
                    });
                    $('#role_list').append(trHTML);
	 			}
	 		});
	 	}

	});

</script>
