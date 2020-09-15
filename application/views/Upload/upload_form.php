
      <?php echo $error;?> 
      <?php echo form_open_multipart('upload/do_upload');?> 
		
      <form action = "" method = "post">
         <input type = "file" name = "userfile" /> 
         <br /><br /> 
         <input type = "submit" value = "upload" /> 
      </form> 