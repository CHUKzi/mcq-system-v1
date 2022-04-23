<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
$page_num = '4';
$msg = '0';
if(isset($_GET['success']))
  {
    $msg=$_GET['success'];
    $msgc="Updated successfully";
  }
  if(isset($_POST['submit']))
  {
   $site_title=$_POST['site_title'];
   $stats=$_POST['stats'];
   $fb=$_POST['fb'];
   $yt=$_POST['yt'];
   $teli=$_POST['teli'];
   $wa=$_POST['wa'];

  $sql="UPDATE  settings Set site_title=(:site_title),stats=(:stats),fb=(:fb),yt=(:yt),teli=(:teli),wa=(:wa) WHERE id=6";

  $query = $dbh->prepare($sql);
  $query-> bindParam(':site_title', $site_title, PDO::PARAM_STR);
  $query-> bindParam(':stats', $stats, PDO::PARAM_STR);
  $query-> bindParam(':fb', $fb, PDO::PARAM_STR);
  $query-> bindParam(':yt', $yt, PDO::PARAM_STR);
  $query-> bindParam(':teli', $teli, PDO::PARAM_STR);
  $query-> bindParam(':wa', $wa, PDO::PARAM_STR);
  $query->execute(); 
  $msg="1";
  $msgc="Update successfully";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard - Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .row.content {height: 700px;}
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
      text-align: center;
    }
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  	#myInput {
  	  background-image: url('https://www.w3schools.com/css/searchicon.png');
  	  background-position: 10px 10px;
  	  background-repeat: no-repeat;
  	  width: 100%;
  	  font-size: 14px;
  	  padding: 10px 18px 10px 38px;
  	  border: 1px solid #ddd;
  	  margin-bottom: 12px;
  	}
    .modal-body {
    padding: 4%;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row content">
  <?php include('includes/left-bar.php');?>


  <div class="col-sm-9">
      <center>
      	<!--<h1>Welcome TO VIDUNETHA Admin Dashboard</h1>-->
      </center>
	<div class="panel panel-default">
	  <div class="panel-heading">

      <?php
  if ($msg == 1) {?>
    <div class="alert alert-success alert-dismissible fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Success!</strong> <?php echo $msgc; ?>
    </div>
  <?php }?>
      <br>
<?php
$sql = "SELECT * from settings where id=6";
$query = $dbh -> prepare($sql);
$query->execute();
$result=$query->fetch(PDO::FETCH_OBJ);
?>
        <form method="post" enctype="multipart/form-data">

          <div class="form-group">
            <label for="Answer_1">Site Title</label>
            
            <input type="text" class="form-control" name="site_title" placeholder="Set Title" value="<?php echo $result->site_title;?>" required>
          </div>

          <div class="form-group">
            <input type="radio" name="stats" value="0" id="site1" <?php if ($result->stats == 0) { ?>checked="checked"<?php } ?>>
            <label for="site1">Site ON</label><span><br>
            <input type="radio" name="stats" id="site2" value="1" <?php if ($result->stats == 1) { ?>checked="checked"<?php } ?>>
            <label for="site2">Site OFF</label><span>
          </div>


          <div class="form-group">
            <label for="Answer_1">Facebook Link</label>
            
            <input type="text" class="form-control" name="fb" placeholder="Set Link" value="<?php echo $result->fb;?>" required>
          </div>

          <div class="form-group">
            <label for="Answer_3">Youtube Link</label>
            <input type="text" class="form-control" name="yt" placeholder="Set Link" value="<?php echo $result->yt;?>" required>
          </div>

          <div class="form-group">
            <label for="Answer_4">Telegram link</label>
            <input type="text" class="form-control" name="teli" placeholder="Set Link" value="<?php echo $result->teli;?>" required>
          </div>

          <div class="form-group">
            <label for="Answer_4">Whatsapp Link</label>
            <input type="text" class="form-control" name="wa" placeholder="Set Link" value="<?php echo $result->wa;?>" required>
          </div>

          <button type="submit" name="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
	 	</div>
  </div>
</div>
</div>
<!-- Modal Area -->

<script>
 $(document).ready(function() {
    var max_fields = 10;
    var wrapper = $(".container1");
    var add_button = $(".add_form_field");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append('<div><input type="text" class="form-control" name="mytext[]"/><a href="#" class="delete">Delete</a></div>');
        } else {
            alert('You Reached the limits')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
}); 
</script>

<footer class="container-fluid">
  <p>&copy; <?php echo date("Y"); ?> Developed By <a style="color: #FFFFFF;" href="https://alexlanka.com/" target="_blank">alexlanka.com</a></p>
</footer>
</body>
</html>
<?php } ?>