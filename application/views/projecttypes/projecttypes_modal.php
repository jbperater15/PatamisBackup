<div id="requirements_table">
	 <div id="body">
	 	<input type="hidden" name="prjtype_id">
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#reqModal" id="open_req_modal">Add Requirements</button>
	</div>
	<div id="body">
		<table class="table">
				<thead>
					<tr>
						<th>Requirements</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="e_req_list">
				</tbody>
				
			</table>
	</div>
</div>
<!-- MODAL ADD -->
	  <div class="modal fade" id="reqModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Requirements</h4>
	        </div>
	        <div class="modal-body">
	          <form id="prj_req">
	          	<div>
	          		<input style="width:100%" type="text" name="req_item" placeholder="Requirement Item">
	          	</div>
	          </form>
	        </div>
	        <div class="modal-footer">
	          <a class="btn btn-default" data-dismiss="modal" id="submit_prj_req">Submit</a>
	        </div>
	      </div>
	    </div>
	  </div>


<!-- MODAL EDIT -->
	  <div class="modal fade" id="reqModaledit" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Update Requirements</h4>
	        </div>
	        <div class="body" >
	          <form id="e_prj_req">
	          	<input type="hidden" name="e_req_id">
	          	<div>
	          		<input style="width:100%" type="text" name="e_req_item" placeholder="Requirement Item">
	          	</div>
	          </form>
	        </div>
	        <div class="modal-footer">
	          <a class="btn btn-default" data-dismiss="modal" id="e_submit_prj_req">Submit</a>
	        </div>
	      </div>
	    </div>
	  </div>

	  <script type="text/javascript">





	  	

	  	$(document).ready(function(){
	  		var reqstore_data;
	   		populate_reqs();

	  		calltoEditReq = function(id,cnt){
				$('input[name="e_req_id"]').val(reqstore_data[cnt].checklist_id);
	  			$('input[name="e_req_item"]').val(reqstore_data[cnt].requirement_item);

	 			$('#reqModaledit').modal('show');	 
			}

			calltoDeleteReq = function(id){
				if (confirm('Are you sure you want to delete it?')) {
					    $.ajax({
				 			url:'<?php echo base_url();?>/projecttypes/delete_req',
				 			method:'POST',
				 			data:{'checklist_id' : id},
				 			dataType:'json',
				 			success: function(data){
				 				(data[0].error == 0 ? populate_reqs() : alert(data[0].msg) );
				 			}
				 		});
				} else {
				    alert('You have cancelled the deletion.');
				}	
			}

			function populate_reqs(){
				$('#e_req_list').html('');
				$.ajax({
					url:'<?php echo base_url();?>projecttypes/get_reqs',
					method:'POST',
					data:{'prjtype_id' : $('input[name="prjtype_id"]').val()},
					dataType:'json',
					success: function(data){
						var trHTML;
						reqstore_data = data;
						//console.log(store_data);
						$.each(data, function(i, item) {
							trHTML += '<tr>'
								+ '<td>'+data[i].requirement_item+'</td>'
								+ '<td><a href="javascript:calltoEditReq('+data[i].checklist_id+','+i+');">Edit</a>	<a href="javascript:calltoDeleteReq('+data[i].checklist_id+');">Delete</a> </td>';
		                   	});
		               	$('#e_req_list').append(trHTML);
					}
				});
			}


	  		$('#submit_prj_req').click(function(){
	  			$.ajax({
	  				url:'<?php echo base_url(); ?>projecttypes/add_req',
	  				method:'POST',
	  				data:$('#prj_req').serialize()+'&'+$.param({ 'prjtype_id':  $('input[name="prjtype_id"]').val() }),
	  				dataType:'json',
	  				success : function (data) {
	  					if(data[0].error == 0){
	  						//update_select_formfield();
	  						populate_reqs();

	  					}
	  				}
	  			});
	  		});

	  		$('#e_submit_prj_req').click(function(){
	  			$.ajax({
	  				url:'<?php echo base_url();?>projecttypes/edit_req',
	  				method:'POST',
	  				data:$('#e_prj_req').serialize(),
	  				dataType:'json',
	  				success: function(data){
	  					if(data[0].error == 0){
	  						//update_select_formfield();
	  						populate_reqs();

	  					}
	  				}
	  			});
	  		});


	  // 		$('#open_role_modal').click(function(){
			// 	update_select_formfield();
			// });

	  	});
	  </script>