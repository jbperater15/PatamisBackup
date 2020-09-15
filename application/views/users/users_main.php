
<div id="container">
	<h1>USERS</h1>

	<div id="body">
		<div>
			<a href="<?php echo base_url(); ?>users/add_user">Add User</a>
		</div>
		<div>
			<table class="table">
				<thead>
					<tr>
						<th>Username</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Role ID</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="user_list">
				</tbody>
				
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">

	

	$(document).ready(function(){

		onload();

		calltoEdit = function(user_id){
	 		$.redirect('<?php echo base_url();?>users/edit_user', {'userId': user_id});
	 	}

	 	calltoDelete = function(user_id){
	 		if (confirm('Are you sure you want to delete it?')) {
			    $.ajax({
		 			url:'<?php echo base_url();?>/users/user_delete',
		 			method:'POST',
		 			data:{'userId' : user_id},
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
	 		$('#user_list').html('');
	 		$.ajax({
	 			url:'<?php echo base_url();?>/users/user_list',
	 			method:'POST',
	 			dataType:'json',
	 			success: function(data){
	 				var trHTML;
	 				$.each(data, function(i, item) {
	 						trHTML += '<tr>'
	 								+ '<td>'+data[i].username+'</td>'
	 								+ '<td>'+data[i].fname+'</td>'
	 								+ '<td>'+data[i].lname+'</td>'
	 								+ '<td>'+data[i].email+'</td>'
	 								+ '<td>'+data[i].role_id+'</td>'
	 								+ '<td><a href="javascript:calltoEdit('+data[i].user_id+');">Edit</a>	<a href="javascript:calltoDelete('+data[i].user_id+');">Delete</a> </td>';
                    });
                    $('#user_list').append(trHTML);
	 			}
	 		});
	 	}

	});

</script>
