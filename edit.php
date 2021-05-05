
<?php 
$get_filename = $_GET['filename'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $set=0;

$open = fopen("title/$get_filename","w+");


if (empty($_POST["title"])) {  
    $titleErr = "Title is required"; 

} else { 
   $fullname_text = $_POST["title"];
   fwrite($open, $fullname_text);
   fclose($open);
}


//$address_text = $_POST['address'];

    $target_dir = "image/";
   $imgFile = $_FILES['fileToUpload']['name'];
    if(!empty($imgFile)){
    
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
   
  } else {
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_dir .$newfilename)) {
       
      $open_image = fopen("image_url/$get_filename","w+");
      fwrite($open_image, $newfilename);
      fclose($open_image);
      }
  }
}
echo "<script>window: location='index.php'</script>";
}elseif(isset($_POST['Cancel'])) {
	echo "<script>window: location='index.php'</script>";
}

$title = file("title/$get_filename");
$image = file("image_url/$get_filename");


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
  <h2>Edit Details</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="<?php foreach($title as $fullname_text) { echo $fullname_text; } ?>">
      <span class="error">* <?php  echo $titleErr = (isset($titleErr)) ? $titleErr :''; ?> </span>  
    </div>
    <div class="form-group">
      <label for="Image">Image:</label>
      <input type="file" name="fileToUpload" id="fileToUpload" value="<?php echo $image[0]; ?>">
      <img src="image/<?php echo $image[0]; ?>" alt="" title="<?php echo $image[0]; ?>" width="100" height="100" class="img-responsive" />
      <span class="error">* <?php echo $imageErr = (isset($imageErr)) ? $imageErr :''; ?> </span>  
    </div>
    
    <input type="submit" name="Submit" value="Update" style="width: 70px;">
	<input type="submit" name="Cancel" value="Cancel" style="width: 70px;">
  </form>
</div>

</body>
</html>
