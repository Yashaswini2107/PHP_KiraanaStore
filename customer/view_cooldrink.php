<table>
  <thead>
    <tr>
      <th>productImage</th>
      <th>productName</th>
      <th>productPrice</th>
      <th>productDescription</th>
    </tr>
  </thead>

  <?php
  $connection = mysqli_connect("localhost", "root", "", "grocery");
  $category=$_POST['category'];
  echo $category ;
  if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
    
  $query = "SELECT * FROM products WHERE productCategory='Cooldrinks and Juice'";
  $query_run = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_array($query_run)) {
    ?>
    <tr>
      <td>
        <div >
            <img height="100px" src="imageview.php?productID=<?php echo $row['productID']; ?>" alt="imagename" style="width:100px; height: 100px;">
        </div>
      </td>
      <td><?php echo $row['productName']; ?></td>
      <td><?php echo $row['productPrice']; ?></td>
      <td><?php echo $row['productDescription']; ?></td>
    </tr>
  <?php
  }
  mysqli_close($connection);
  ?>
</table>