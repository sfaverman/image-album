<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Assignment 3</title>
	<style>
		form { width: 80%; margin: auto;}
		input[type=submit],input[type=file] {
			background-color: darkseagreen;
			color: #fff;
			padding: 5px;	
		}
		#imgUploaded { margin: 5% 25%; border: solid 1px darkseagreen;}
		#imgFromAlbum { padding: 2.15%;}
		#album {
			width: 80%; 
			margin: auto;
			border: solid 2px purple;
			margin-bottom: 10px;
		}
		h1 {text-align: center; color: purple;}
	</style>
</head>
<body>
      <!-- *** Sofia Faverman
      *** Date: 02/23/2019
      *** Class: PHP MySQL
      *** Assignment: 03 -->

    <?php
	//phpinfo(); //verify file_uploads is on
	
	// UPLOAD FILE 
	
	if ( !empty($_FILES["fileToUpload"]["name"])) {
		//echo("{$_FILES["fileToUpload"]["name"]}"."***");
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		//echo "$imageFileType";
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				// echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		/*if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}*/
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "New image " . basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
				echo '<img id="imgUploaded" src="uploads/'. basename( $_FILES["fileToUpload"]["name"] ) . '" title="My Birthday" height="50%" width="50%" />';
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	
	// DISPLAY FILES IN ALBUM
	function display_album($img_in_album, $title, $width, $height) {
       echo '<img id="imgFromAlbum" src="uploads/' . $img_in_album . '" title="' . $title . '" height="' . $height .'" width="' . $width .'" />';
	}
	echo '<h1> Your ALBUM </h1>';
	echo '<div id="album">';
	$path = "uploads/";
	$files = array_values(array_filter(scandir($path), function($file) use ($path) { 
    return !is_dir($path . '/' . $file);
    }));

	foreach($files as $file){
		/*echo $file;*/
		display_album($file,'My Birthday', '29%', '29%');
	}
	echo '</div>'; // end of album div
	
    ?>
	<form action="album.php" method="post" enctype="multipart/form-data">
		  
		<fieldset>
		    <legend>Upload photos to your album</legend><br>
			<label for="fileToUpload">Select image to upload:</label>
			<input type="file" name="fileToUpload" id="fileToUpload"><br><br>
			<input type="submit" value="Upload Image" name="submit">
		</fieldset>
	</form>
</body>
</html>