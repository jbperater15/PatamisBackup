<div class="container">
  <h2>Hover Rows</h2>
  <p>The .table-hover class enables a hover state on table rows:</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Icon</th>
        <th>Link</th>
        <th>Title</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($files['items'] as $item) { ?>
      <tr>
        <td><img src="<?php echo $item['iconLink'] ?>" alt=""></td>
        <td><a href="<?php echo $item['alternateLink']?>">Link</a></td>
        <td><?php echo $item['title'] ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>