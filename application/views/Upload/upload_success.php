       <h3>Your file was successfully uploaded!</h3>  
		
      <ul> 
        <!--  <?php foreach ($upload_data as $item => $value):?> 
         <li><?php echo $item;?>: <?php echo $value;?></li> 
         <?php endforeach; ?> -->
         <?php foreach ($upload_data as $item):?> 
         <li><?php echo $item;?>: <?php echo $value;?></li> 
         <?php endforeach; ?>
      </ul>  
		
      <p><?php echo anchor('upload', 'Upload Another File!'); ?></p>  
