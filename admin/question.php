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
  if(isset($_POST['submit']))
  {
   $systemrq=$_POST['systemrq'];
   $a1=$_POST['a1'];
   $a2=$_POST['a2'];
   $a3=$_POST['a3'];
   $a4=$_POST['a4'];
   $r_answer=$_POST['r_answer'];

  $sql="insert into q_table(quaction,a1,a2,a3,a4,r_answer) values (:systemrq,:a1,:a2,:a3,:a4,:r_answer)";

  $query = $dbh->prepare($sql);
  $query-> bindParam(':systemrq', $systemrq, PDO::PARAM_STR);
  $query-> bindParam(':a1', $a1, PDO::PARAM_STR);
  $query-> bindParam(':a2', $a2, PDO::PARAM_STR);
  $query-> bindParam(':a3', $a3, PDO::PARAM_STR);
  $query-> bindParam(':a4', $a4, PDO::PARAM_STR);
  $query-> bindParam(':r_answer', $r_answer, PDO::PARAM_STR);
  $query->execute(); 
  $msg="1";
  $msgc="Question Added successfully";
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
 <script src="https://cdn.tiny.cloud/1/bv5a14g71ngqfnetpdy42q9a139li5dutndzg3fdpth22wx5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#systemrq',
    height : "200",
    plugins: 'image code',
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fullscreen',
      plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste imagetools wordcount'
  ],
    
    // without images_upload_url set, Upload tab won't show up
    images_upload_url: 'upload.php',
    
    // override default upload handler to simulate successful upload
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
      
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'upload.php');
      
        xhr.onload = function() {
            var json;
        
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
        
            json = JSON.parse(xhr.responseText);
        
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
        
            success(json.location);
        };
      
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
      
        xhr.send(formData);
    },
});
</script>

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
  <a href="all-question.php"><button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-eye" aria-hidden="true"></i> All Questions</button></a>
      <br>
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Question<span style="color:red">*</span></label>
                <textarea id="systemrq" name="systemrq" class="form-control" placeholder="Enter Question" cols="30" rows="10"></textarea>
            </div>
          <script>var myContent = tinymce.get("systemrq").getContent();</script>

          <div class="form-group">
            <label for="Answer_1">Answer 1</label><span>////</span>
            <input type="radio" name="r_answer" value="1" checked="checked">
            <input type="text" class="form-control" name="a1" placeholder="Enter Answer 1" required>
          </div>

          <div class="form-group">
            <label for="Answer_3">Answer 2</label><span>////</span>
            <input type="radio" name="r_answer" value="2">
            <input type="text" class="form-control" name="a2" placeholder="Enter Answer 2" required>
          </div>

          <div class="form-group">
            <label for="Answer_4">Answer 3</label><span>////</span>
            <input type="radio" name="r_answer" value="3">
            <input type="text" class="form-control" name="a3" placeholder="Enter Answer 3" required>
          </div>

          <div class="form-group">
            <label for="Answer_4">Answer 4</label><span>////</span>
            <input type="radio" name="r_answer" value="4">
            <input type="text" class="form-control" name="a4" placeholder="Enter Answer 4" required>
          </div>

          <button type="submit" name="submit" class="btn btn-primary">ADD</button>
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