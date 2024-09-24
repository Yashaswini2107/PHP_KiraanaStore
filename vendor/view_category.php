<table>
  <thead>
    <tr>
      <th>Category ID</th>
      <th>Category Name</th>
     
    </tr>
  </thead>

  <?php
  $connection = mysqli_connect("localhost", "root", "", "grocery");

  if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
    
  $query = "SELECT * FROM category";
  $query_run = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_array($query_run)) {
    ?>
    <tr>
      <td><?php echo $row['category_id']; ?></td>
      <td><?php echo $row['categoryname']; ?></td>
    </tr>
  <?php
  }
  mysqli_close($connection);
  ?>
</table>