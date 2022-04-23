<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
//$page_num = '1';
$msg = '0';
if(isset($_GET['edit']))
  {
    $editid=$_GET['edit'];
  }
if(isset($_GET['success']))
  {
    $msg=$_GET['success'];
    $msgc="Updated successfully";
  }
  if(isset($_POST['submit']))
  {
  $h_name=$_POST['h_name'];
  $idedit=$_POST['idedit'];

  $sql="UPDATE houses SET h_name=(:h_name) WHERE id=(:idedit)";

  $query = $dbh->prepare($sql);
  $query-> bindParam(':h_name', $h_name, PDO::PARAM_STR);
  $query-> bindParam(':idedit', $idedit, PDO::PARAM_STR);
  $query->execute();
  $msg="1";
  $msgc="House Name Edit successfully";
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

  <?php
      $sql = "SELECT * from houses where id = :editid";
      $query = $dbh -> prepare($sql);
      $query->bindParam(':editid',$editid,PDO::PARAM_INT);
      $query->execute();
      $result=$query->fetch(PDO::FETCH_OBJ);
      $cnt=1; 
  ?>

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

        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="exampleInputEmail1">Enter House Name</label>
            <input type="text" class="form-control" name="h_name" placeholder="Enter New House Name" value="<?php echo htmlentities($result->h_name);?>">
          </div>
          <input type="hidden" name="idedit" value="<?php echo htmlentities($result->id);?>" >
          <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
	 	</div>
  </div>
</div>
<!-- Modal Area -->


<footer class="container-fluid">
  <p>&copy; <?php echo date("Y"); ?> Developed By <a style="color: #FFFFFF;" href="https://alexlanka.com/" target="_blank">alexlanka.com</a></p>
</footer>
</body>
</html>
<?php } ?>