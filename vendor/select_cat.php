<td>
  <select id="productCategory" name="productCategory">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "grocery";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql2= "SELECT * from category ";
    $result2= mysqli_query($conn,$sql2);
    while($fetch2= mysqli_fetch_assoc($result2)){
      ?>
      <option value="<?php echo $fetch2['category_id']?>"><?php echo $fetch2['categoryname']?></option>
    <?php
    }

    mysqli_close($conn);
    ?>
  </select>
</td>
