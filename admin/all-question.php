<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
$page_num = '2';
$msg = '0';
if(isset($_GET['success']))
  {
    $msg=$_GET['success'];
    $msgc="Updated successfully";
  }
if(isset($_GET['del']))
{
$id=$_GET['del'];

$sql = "delete from q_table WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="1";
$msgc="Data Deleted successfully";
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
        <?php $sql = "SELECT * from q_table"; //WHERE is_delete=0
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        if($query->rowCount() > 0)
        {
        foreach($results as $result)
        {               ?>

        <style>
          
img {
  max-width: 20%;
  height: auto;
}
        </style>

          <?php echo "<b>Quaction : </b>" . $cnt; ?>
          <?php echo ($result->quaction);?>

          <?php if ($result->r_answer==1) {?>
            <b style="color: green;"><u><?php echo htmlentities("1. " .$result->a1);?></u></b>
          <?php } else {  ?>
            <?php echo htmlentities("1. " .$result->a1);?>
          <?php } ?>
<br>


          <?php if ($result->r_answer==2) {?>
            <b style="color: green;"><u><?php echo htmlentities("2. " .$result->a2);?></u></b>
          <?php } else {  ?>
            <?php echo htmlentities("2. " .$result->a2);?>
          <?php } ?>

<br>

          <?php if ($result->r_answer==3) {?>
            <b style="color: green;"><u><?php echo htmlentities("3. " .$result->a3);?></u></b>
          <?php } else {  ?>
            <?php echo htmlentities("3. " .$result->a3);?>
          <?php } ?>

<br>

          <?php if ($result->r_answer==4) {?>
            <b style="color: green;"><u><?php echo htmlentities("4. " .$result->a4);?></u></b>
          <?php } else {  ?>
            <?php echo htmlentities("4. " .$result->a4);?>
          <?php } ?>

          <br>
          <a href="all-question.php?del=<?php echo $result->id;?>"><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#staticBackdrop" onclick="return confirm('Are you sure want to Delete this quaction?');"><i class="fa fa-trash"></i>&nbsp;DELETE</button></a>
          <hr style="height:2px;border-width:0;color:gray;background-color:gray">

        <?php $cnt=$cnt+1; }} else {echo "<p><center>No Question yet</center></p>";}?>

      <br>

        
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