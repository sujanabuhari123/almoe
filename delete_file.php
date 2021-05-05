
<?php 
$get_filename = $_GET['filename'];

unlink('title/'.$get_filename);
unlink('image_url/'.$get_filename);
echo "<script>window: location='index.php'</script>";	
?>