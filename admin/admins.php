<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
$page_num = '3';
$msg = '0';
if(isset($_GET['success']))
  {
    $msg=$_GET['success'];
    $msgc="Updated successfully";
  }
  if(isset($_POST['submit']))
  {
  $h_name=$_POST['h_name'];

  $sql="insert into houses(h_name) values (:h_name)";

  $query = $dbh->prepare($sql);
  $query-> bindParam(':h_name', $h_name, PDO::PARAM_STR);
  $query->execute(); 
  $msg="1";
  $msgc="House Added successfully";
  }
if(isset($_GET['u_del']))
{
$id=$_GET['u_del'];

  $is_delete = '1';

  $sql="UPDATE users SET is_delete=(:is_delete) WHERE id=(:id)";

  $query = $dbh->prepare($sql);
  $query-> bindParam(':is_delete', $is_delete, PDO::PARAM_STR);
  $query-> bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $msg="1";
  $msgc="deleted successfully";

}
if(isset($_GET['del']))
{
$id=$_GET['del'];

$sql = "delete from houses WHERE id=:id";
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

      <!-- <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-pulse" aria-hidden="true"></i>+ Add New Admin</button> -->
      <br>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search User names.." title="Type in a name"></div>
	 	<div class="panel-body">
	 		<table id="myTable" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	 			<thead>
	 				<tr>
            <th>#</th>
            <th>UserName</th>
            <th>Email</th>
            <th>Last login</th>
	 				</tr>
	 			</thead>
	 			<tbody>
        <?php $sql = "SELECT * from admin order by last_login DESC"; //WHERE is_delete=0
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        if($query->rowCount() > 0)
        {
        foreach($results as $result)
        {               ?>
	 				<tr>
            <td><?php echo($cnt);?></td>
	 					<td><?php echo htmlentities($result->username);?><?php if ($result->admin_level==1) { ?>
              <button type="button" class="btn btn-success btn-sm" disabled>Server Admin</button>
            <?php } ?></td>
            <td><?php echo htmlentities($result->email);?></td>

<?php 

       $time_zone = "asia/Colombo";

       $r_alex_sv_time = $result->last_login;

       $alex_sv_time = new DateTime($r_alex_sv_time);
       $sv_time = $alex_sv_time->format('Y-m-d H:i:s') . "<br/>";

       $la_time = new DateTimeZone($time_zone);
       $alex_sv_time->setTimezone($la_time);
       $user_time_s = $alex_sv_time->format('Y-m-d H:i:s');


?>

            <td><?php echo htmlentities($user_time_s);?></td>
	 				</tr>
        <?php $cnt=$cnt+1; }} else {echo "<td colspan='7'><center>No users yet</center></td>";}?>
	 			</tbody>
	 		</table>
	 	   </div>
	   </div>
    </div>
  </div>
</div>
<!-- Modal Area -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add House</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal" enctype="multipart/form-data">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">User Name:</label>
            <input type="text" class="form-control" name="username" placeholder="Enter House Name" required>
          </div>
          <?php $sql = "SELECT * from houses";
          $query = $dbh -> prepare($sql);
          $query->execute();
          $results=$query->fetchAll(PDO::FETCH_OBJ);
          $cnt=1;
          if($query->rowCount() > 0)
          {
          foreach($results as $result)
          {               ?>

          <p><?php echo htmlentities($result->h_name);?>&nbsp;<a href="house-edit.php?edit=<?php echo $result->id;?>"><i class="fa fa-pencil"></i></a>////

            <a href="dashboard.php?del=<?php echo $result->id;?>" onclick="return confirm('Are you sure want to Delete this?');"><i class="fa fa-trash" style="color:red"></i></a></p>

          <?php $cnt=$cnt+1; }} else {echo "<td colspan='7'><center>No House yet</center></td>";}?>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Add Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<footer class="container-fluid">
  <p>&copy; <?php echo date("Y"); ?> Developed By <a style="color: #FFFFFF;" href="https://alexlanka.com/" target="_blank">alexlanka.com</a></p>
</footer>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
</html>
<?php } ?>