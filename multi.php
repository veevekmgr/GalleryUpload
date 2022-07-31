<?php
	require_once 'database.php';

	if(isset($_POST['btn-add'])){
		  // Count total files
		  $countfiles=array();
  		$countfiles = count($_FILES['profile']['name']);
 
  		// Prepared statement
  		$query = "INSERT INTO images (name,images) VALUES(?,?)";

  		$statement = $conn->prepare($query);

 		 // Loop all files
  		for($i=0;$i<$countfiles;$i++){

    	// File name
    	$filename = $_FILES['profile']['name'][$i];

    	// Location
    	$target_file = 'upload/'.$filename;

    	// file extension
    	$file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
    	$file_extension = strtolower($file_extension);

    	// Valid image extension
    	$valid_extension = array("png","jpeg","jpg");

    	if(in_array($file_extension, $valid_extension)){

       // Upload file
       if(move_uploaded_file($_FILES['profile']['tmp_name'][$i],$target_file)){

        // Execute query
	 	 $statement->execute(array($filename,$target_file));

       }
    }
 
  }
  echo "File upload successfully";
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
</head>
<body>
<div class="container">
		<div class="add-form">
			<h1 class="text-center">Upload Your Images</h1>
			<hr style="border-top: 2px red solid;">
			<form method="post" enctype="multipart/form-data">
				<label>User Name</label>
				<input type="text" name="user_name" class="form-control" required="">
				<label class="text-center">Picture Profile</label>
				<input type="file" name="profile[]" multiple class="form-control">
				<br><button type="submit" name="btn-add">Add New </button>
				
			</form>
		</div>
		<hr style="border-top: 2px red solid;">
		<div class="container">
			<div class="view-form">
				<h1 class="text-center">GALLERY</h1>
				<hr style="border-top: 2px red solid;">
				<div class="row">
				<?php 
					$stmt=$conn->prepare('SELECT * FROM images ORDER BY id DESC');
					$stmt->execute();
					if($stmt->rowCount()>0)
					{
						while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{
					extract($row);
				?>
			<div class="col-sm-3">
			<p><?php echo $name ?></p>
			<img src="upload/<?php echo $row['images']?>"><br><br>	
			</div>

			<?php 

				}
			}
			?>
		</div>

	</div>
</div>
</body>
</html>