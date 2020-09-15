<div id="access_table">
	 <div id="body">
	 	<input type="hidden" name="role_id">
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#roleModal" id="open_role_modal">Add Access</button>
	</div>
	<div id="body">
		<table class="table">
				<thead>
					<tr>
						<th>Form Code</th>
						<th>Form Name</th>
						<th>Create</th>
						<th>Read</th>
						<th>Update</th>
						<th>Delete</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="e_acc_list">
				</tbody>
				
			</table>
	</div>
</div>
<!-- MODAL ADD -->
	  <div class="modal fade" id="roleModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Role Access</h4>
	        </div>
	        <div class="modal-body">
	          <form id="role_access">
                <select name="form_id" data-placeholder="Select Form" class="chosen-select">
	            </select>
	            <div>
	            	<label class="">Create</label>
                		<input name="create_cb" type="checkbox" class="i-checks">
	            </div>
	            <div>
	            	<label class="">Read</label>
                		<input name="read_cb" type="checkbox" class="i-checks">
	            </div>
	            <div>
	            	<label class="">Update</label>
                		<input name="update_cb" type="checkbox" class="i-checks">
	            </div>
	            <div>
	            	<label class="">Delete</label>
	   	            	<input name="delete_cb" type="checkbox" class="i-checks">
	            </div>
	          </form>
	        </div>
	        <div class="modal-footer">
	          <a class="btn btn-default" data-dismiss="modal" id="submit_role_access">Submit</a>
	        </div>
	      </div>
	    </div>
	  </div>


<!-- MODAL EDIT -->
	  <div class="modal fade" id="roleModaledit" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Update Role Access</h4>
	        </div>
	        <div class="body" >
	          <form id="e_role_access">
	          		<input type="hidden" name="e_role_acc_id">
	          		<label class="">Form</label>
                	<input name="e_form_acc" type="text" value="" readonly style="width:50%;">
	            <div>
	            	<label class="">Create</label>
                		<input name="e_create_cb" type="checkbox" class="i-checks">
	            </div>
	            <div>
	            	<label class="">Read</label>
                		<input name="e_read_cb" type="checkbox" class="i-checks">
	            </div>
	            <div>
	            	<label class="">Update</label>
                		<input name="e_update_cb" type="checkbox" class="i-checks">
	            </div>
	            <div>
	            	<label class="">Delete</label>
	   	            	<input name="e_delete_cb" type="checkbox" class="i-checks">
	            </div>
	          </form>
	        </div>
	        <div class="modal-footer">
	          <a class="btn btn-default" data-dismiss="modal" id="submit_e_role_access">Submit</a>
	        </div>
	      </div>
	    </div>
	  </div>

	  <script type="text/javascript">





	  	

	  	$(document).ready(function(){
	  		var store_data;
	  		populate_access();

	  		calltoEditAccess = function(id,cnt){
	  			console.log(store_data[cnt].form_code);
	  			$('input[name="e_role_acc_id"]').val(store_data[cnt].role_acc_id);
	  			$('input[name="e_form_acc"]').val(store_data[cnt].form_code);

	  			$('input[name="e_create_cb"]').prop('checked',(store_data[cnt].create_flag == 'Y' ? true : false));
	  			$('input[name="e_read_cb"]').prop('checked',(store_data[cnt].read_flag == 'Y' ? true : false));
	  			$('input[name="e_update_cb"]').prop('checked',(store_data[cnt].update_flag == 'Y' ? true : false));
	  			$('input[name="e_delete_cb"]').prop('checked',(store_data[cnt].delete_flag == 'Y' ? true : false));

	 			$('#roleModaledit').modal('show');	 			
			}

			calltoDeleteAccess = function(id){
				if (confirm('Are you sure you want to delete it?')) {
					    $.ajax({
				 			url:'<?php echo base_url();?>/roles/delete_role_access',
				 			method:'POST',
				 			data:{'role_acc_id' : id},
				 			dataType:'json',
				 			success: function(data){
				 				(data[0].error == 0 ? populate_access() : alert(data[0].msg) );
				 			}
				 		});
				} else {
				    alert('You have cancelled the deletion.');
				}

			}

			function populate_access(){
				$('#e_acc_list').html('');
				$.ajax({
					url:'<?php echo base_url();?>roles/get_role_access',
					method:'POST',
					data:{'role_id' : $('input[name="role_id"]').val()},
					dataType:'json',
					success: function(data){
						var trHTML;
						store_data = data;
						//console.log(store_data);
						$.each(data, function(i, item) {
							trHTML += '<tr>'
								+ '<td>'+data[i].form_code+'</td>'
								+ '<td>'+data[i].form_name+'</td>'
								+ '<td>'+(data[i].create_flag == 'Y' ? 'Enabled' : 'Disabled')+'</td>'
								+ '<td>'+(data[i].read_flag   == 'Y' ? 'Enabled' : 'Disabled')+'</td>'
								+ '<td>'+(data[i].update_flag == 'Y' ? 'Enabled' : 'Disabled')+'</td>'
								+ '<td>'+(data[i].delete_flag == 'Y' ? 'Enabled' : 'Disabled')+'</td>'
								+ '<td><a href="javascript:calltoEditAccess('+data[i].role_acc_id+','+i+');">Edit</a>	<a href="javascript:calltoDeleteAccess('+data[i].role_acc_id+');">Delete</a> </td>';
		                   	});
		               	$('#e_acc_list').append(trHTML);
					}
				});
			}


	  		$('#submit_role_access').click(function(){
	  			$.ajax({
	  				url:'<?php echo base_url(); ?>roles/add_role_access',
	  				method:'POST',
	  				data:$('#role_access').serialize()+'&'+$.param({ 'role_id':  $('input[name="role_id"]').val() }),
	  				dataType:'json',
	  				success : function (data) {
	  					if(data[0].error == 0){
	  						update_select_formfield();
	  						populate_access();

	  					}
	  				}
	  			});
	  		});

	  		$('#submit_e_role_access').click(function(){
	  			$.ajax({
	  				url:'<?php echo base_url();?>roles/edit_role_access',
	  				method:'POST',
	  				data:$('#e_role_access').serialize(),
	  				dataType:'json',
	  				success: function(data){
	  					if(data[0].error == 0){
	  						update_select_formfield();
	  						populate_access();

	  					}
	  				}
	  			});
	  		});


	  		$('#open_role_modal').click(function(){
				update_select_formfield();
			});

			function update_select_formfield(){
				$.ajax({
					url:'<?php echo base_url();?>/roles/get_forms',
					method:'POST',
					data:{'role_id' : $('input[name="role_id"]').val()},
					dataType:'json',
					success: function(data){
						var trHTML;
						// $('input[name="role_id"]').val(role_id);
						$('select[name="form_id"]').html();
		 				$.each(data, function(i, item) {
		 						trHTML += "<option value='"+data[i].form_id+"'>"+data[i].form_name+" ("+data[i].form_code+")</option>";
	                    });
	                    $('select[name="form_id"]').append(trHTML);
					}
				});
			}
	  	});
	  </script>