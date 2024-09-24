<?php

      $host = 'localhost';
      $username = 'root';
      $password = '';
      $database = 'grocery';


        // Connect to your database
        $conn = mysqli_connect("localhost", "username", "password", "database");

        // Check if the connection was successful
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // Retrieve the category names from the database
        $query = "SELECT categoryname FROM category";
        $result = mysqli_query($conn, $query);

        // Check if there are any categories
        if (mysqli_num_rows($result) > 0) {
          // Fetch the category names and store them in an array
          $categories = array();
          while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['categoryname'];
          }

          // Randomly select one category
          $randomCategory = $categories[array_rand($categories)];

          // Display the randomly selected category as a text input field
          echo '<input type="text" id="categoryName" name="categoryname" value="' . $randomCategory . '" readonly>';
        } else {
          echo "No categories found.";
        }

        // Close the database connection
        mysqli_close($conn);
      ?>