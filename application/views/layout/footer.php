



<script type="text/javascript">
	
	function load_access(){
	
		('<?php echo isset($create_acc) ? $create_acc : 'N'; ?>' == 'Y') ? '' : $('.add_link').hide();
		('<?php echo isset($update_acc) ? $update_acc : 'N'; ?>' == 'Y') ? '' : $('.edit_link').hide();
		('<?php echo isset($delete_acc) ? $delete_acc : 'N'; ?>' == 'Y') ? '' : $('.delete_link').hide();

	}


</script>

</body>
</html>
