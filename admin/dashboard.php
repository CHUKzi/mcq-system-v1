<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
$page_num = '1';
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

$sql = "delete from users WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="1";
$msgc="User Deleted successfully";

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

      <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-pulse" aria-hidden="true"></i>+ HOUSES</button>
      <br>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search User names.." title="Type in a name"></div>
	 	<div class="panel-body">
	 		<table id="myTable" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	 			<thead>
	 				<tr>
            <th>#</th>
            <th>Name</th>
            <th>Nick name</th>
            <th>Email</th>
            <th>House</th>
            <th>Result</th>
            <th>Action</th>
	 				</tr>
	 			</thead>
	 			<tbody>
        <?php $sql = "SELECT * from users order by time DESC";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        if($query->rowCount() > 0)
        {
        foreach($results as $result)

        {               
        $sql = "SELECT * from houses where id = '{$result->house_id}'";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $result_house=$query->fetch(PDO::FETCH_OBJ);


      $sql = "SELECT * from a_table WHERE u_id = '{$result->id}' "; //WHERE is_delete=0
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results_answer=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        $writed = 0;
        $my_c_answ = 0; 
        $skiped = 0; 
        if($query->rowCount() > 0)
        {
        foreach($results_answer as $answer)
        {  


          
            $sql = "SELECT * from q_table where id = '{$answer->q_id}'";
            $query = $dbh -> prepare($sql);
            $query->execute();
            $result_my=$query->fetch(PDO::FETCH_OBJ);


            if (!$answer->q_answer == 0) {
              $writed++;
              if ($result_my->r_answer==$answer->q_answer) {
                $my_c_answ++;
              }
            } else {
              $skiped++;
            }

          }
        }
        $my_h_re = $my_c_answ / $writed * 100; 

        ?>



          	<tr>
            <td><?php echo($cnt);?></td>
	 					<td><?php echo htmlentities($result->name);?></td>
            <td><?php echo htmlentities($result->nick_name);?></td>
            <td><?php echo htmlentities($result->email);?></td>
            <td><?php echo htmlentities($result_house->h_name);?></td>



            <td>
              <center><?php echo intval($my_h_re); ?>%<br>[<?php echo $my_c_answ;?>/<?php echo $writed;?>]<br>
              (SKIPED : <?php echo $skiped; ?>)<br></center>
            </td>

            <td>
              <center>


<a href="result_view.php?id=<?php echo $result->id;?>"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-eye"></i>&nbsp;Result</button></a>

               <a href="dashboard.php?u_del=<?php echo $result->id;?>"><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#staticBackdrop" onclick="return confirm('Are you sure want to Delete this?');"><i class="fa fa-trash"></i>&nbsp;DELETE</button></a>
              </center>
            </td>
	 				</tr>
          <?php 

        $writed = 0;
        $my_c_answ = 0;
        $skiped = 0;


          ?>
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
            <label for="recipient-name" class="col-form-label">House:</label>
            <input type="text" class="form-control" name="h_name" placeholder="Enter House Name" required>
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