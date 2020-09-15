


<div id="container">
	<h1>Project Types</h1>

	<div id="body">
		<div>
			<a href="<?php echo base_url(); ?>projecttypes/add_prjtype">Add Project Type</a>
		</div>
		<div>
			<table class="table">
				<thead>
					<tr>
						<th>Project Types</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="prj_type_list">
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

		calltoEditPrj = function(prjType_id){
			//alert("Ready for Edit");
	 		$.redirect('<?php echo base_url();?>projecttypes/edit_prjtype', {'prjType_id': prjType_id});
	 	}

	 	calltoDeletePrj = function(project_type_id){
	 		// alert("Ready for Delete");
	 		if (confirm('Are you sure you want to delete it?')) {
			    $.ajax({
		 			url:'<?php echo base_url();?>/projecttypes/projecttype_delete',
		 			method:'POST',
		 			data:{'projecttypeId' : project_type_id},
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
	 		$('#prj_type_list').html('');
	 		$.ajax({
	 			url:'<?php echo base_url();?>/projecttypes/prjtype_list',
	 			method:'POST',
	 			dataType:'json',
	 			success: function(data){
	 				var trHTML;
	 				$.each(data, function(i, item) {
	 						trHTML += '<tr>'
	 								+ '<td>'+data[i].project_type+'</td>'
	 								+ '<td>'+data[i].type_name+'</td>'
	 								+ '<td><a href="javascript:calltoEditPrj('+data[i].project_type_id+');">Edit</a>	<a href="javascript:calltoDeletePrj('+data[i].project_type_id+');">Delete</a> </td>';
                    });
                    $('#prj_type_list').append(trHTML);
	 			}
	 		});
	 	}
	});
</script>
