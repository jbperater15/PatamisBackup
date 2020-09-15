<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/DataTables/datatables.css">
<div class="container">
  <h2>Files</h2>
  <p>The .table-hover class enables a hover state on table rows:</p>            
  <table id="myTable" class="table display stripe">
    <thead>
      <tr>
        <th>Icon</th>
        <th>Link</th>
        <th>Title</th>
        <th>Open</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($files['items'] as $item) { ?>
      <tr>
        <td><img src="<?php echo $item['iconLink'] ?>" alt=""></td>
        <td><a href="<?php echo $item['alternateLink']?>">Link</a></td>
        <td><?php echo $item['title'] ?></td>
        <td><a href="<?php echo base_url().'files/folderlist/'?><?php echo($item["id"])?>">Link</a></td>
      </tr>
      <?php } ?> 
    </tbody>
  </table>
</div>
<script type="text/javascript" charset="utf8" src="<?php echo base_url()?>/assets/DataTables/datatables.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
    $('#myTable').DataTable( {
      //ajax: '<?php echo base_url()?>files/files'
    } );
} );
</script>