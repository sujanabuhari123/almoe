<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["title"])) {  
        $titleErr = "Title is required";  
   } else { 
       $title = $_POST["title"];
       //random filename
       	
   }
   if(empty($_FILES["fileToUpload"]["name"])){
   $imageErr = "Image is required"; 
   }else{
    $target_dir = "image/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    $newfilename = round(microtime(true)).basename($_FILES["fileToUpload"]["name"]);
    // Check if image file is a actual image or fake image
    $check          = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        
        $uploadOk = 1;
      } else {
        $imageErr ="File is not an image.";
        $uploadOk = 0;
      }
      // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $imageErr= "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    $imageErr= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
   // $imageErr= "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_dir .$newfilename)) {
       $r_number = rand(1000000000, 0000);
        //get current date
        $date = date('Ymy');
        $filename = $date."_".$r_number;
        $myFile = "title/files_$filename.txt";
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $title);

        $myFile1 = "image_url/files_$filename.txt";
		    $fh = fopen($myFile1, 'w') or die("can't open file");
		    fwrite($fh, $newfilename);
      
    } else {
        $imageErr="Sorry, there was an error uploading your file.";
    }
  }
    
   }

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<style>
.error{
    color:red;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  
</head>
<body>

<div class="container">
  <h2>Add Details</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="title" class="form-control" id="title" placeholder="Enter title" name="title">
      <span class="error">* <?php  echo $titleErr = (isset($titleErr)) ? $titleErr :''; ?> </span>  
    </div>
    <div class="form-group">
      <label for="Image">Image:</label>
      <input type="file" name="fileToUpload" id="fileToUpload">
      <span class="error">* <?php echo $imageErr = (isset($imageErr)) ? $imageErr :''; ?> </span>  
    </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>


<?php
		$path = 'title/'; // '.' for current
		echo "<br>";
		echo "<table id='my-table' border='2' style='border-collapse:collapse' style='border: 1px solid black;'>";
		echo "<tr class='data-header'> ";
		echo "<td><b>Title<b></td>";
		echo "<td><b>Image</b></td>";
		echo "<td colspan='2' ><b>Actions</b></td>";
		echo "</tr>";
		foreach (new DirectoryIterator($path) as $file)
		{
			if($file->isDot()) continue;

			if($file->isFile())
			{
				echo "<td>".file_get_contents('title/'.$file)."</td>";
        ?>
        <td><img src="image/<?php echo file_get_contents('image_url/'.$file); ?>" alt=""  width="100" height="100" class="img-responsive" /></td>
        <?php

					echo	"<td> <a href='edit.php?filename=$file'>Edit</a></td>";
            ?>
            
            <?php
				echo "<td width='80px'> <a href='delete_file.php?filename=$file'  class='confirmation'>Delete</a>";
				echo "</tr>";
			}
		}
		echo "</table>";
		
		$directory = 'title/';
		$files = glob($directory . '*.txt');

		if ( $files !== false )
		{
			$filecount = count( $files );
			echo "<br><b>Total Number of Records: </b>".$filecount;
		}
		else {
			echo 0;
		}

?>
<script>
$(document).ready( function () {
    $('#my-table').DataTable();
} );
   var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
