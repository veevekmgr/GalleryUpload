<?php
    require_once 'database.php';

	if(isset($_POST['btn-add']))
	{
		$name=$_POST['user_name'];

		$images=$_FILES['profile']['name'];
		$tmp_dir=$_FILES['profile']['tmp_name'];
		$imageSize=$_FILES['profile']['size'];

		$upload_dir='upload/';
		$imgExt=strtolower(pathinfo($images,PATHINFO_EXTENSION));
		$valid_extensions=array('jpeg', 'jpg', 'png', 'gif', 'pdf');
		$picProfile=rand(1000, 1000000).".".$imgExt;
		move_uploaded_file($tmp_dir, $upload_dir.$picProfile);
		$stmt=$conn->prepare('INSERT INTO images(name, images) VALUES (:uname, :upic)');
		$stmt->bindParam(':uname', $name);
		$stmt->bindParam(':upic', $picProfile);
		if($stmt->execute())
		{
			?>
			<script>
				alert("new record successul");
				window.location.href=('index.php');
			</script>
		<?php
		}else 

		{
			?>
			<script>
				alert("Error");
				window.location.href=('index.php');
			</script>
		<?php
		}

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
				<input type="file" name="profile" class="form-control" required="" accept="*/image">
				<br><button type="submit" name="btn-add">Add New </button>
				
			</form>
		</div>
		<hr style="border-top: 2px red solid;">
	</div>	
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