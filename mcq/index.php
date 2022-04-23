<?php
session_start();
include('includes/connection.php');
require_once('includes/functions.php');
//$_SESSION['q_panel']='';
$s_msg = 0;
if (empty($_SESSION['q_panel'])) {
    $_SESSION['q_panel']='';
}
if (empty($_SESSION['time_out'])) {
    $_SESSION['time_out']='';
}
if (empty($_SESSION['user_s_time'])) {
    $_SESSION['user_s_time']='';
}

$q_panel   = 0;
$msgc      = "";

$errors    = array();
$name      = '';
$nick_name = '';
$email     = '';
$house_id  = '';
$subscribe = '';
$er1       = '';

  if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $nick_name = $_POST['nick_name'];
    $email = $_POST['email'];
    $house_id = $_POST['house_id'];
    // checking required fields
    $req_fields = array('name','nick_name','email','house_id');

    foreach ($req_fields as $field) {
      if (empty(trim($_POST[$field]))) {
        $errors[] = $field . ' is required';
      }
    }

    // checking max length
    $max_len_fields = array('name' => 50, 'nick_name' => 50, 'email' => 50);

    foreach ($max_len_fields as $field => $max_len) {
      if (strlen(trim($_POST[$field])) > $max_len) {
        $s_msg = '1';
        $errors[] = $field . ' must be less than ' . $max_len . ' characters';
      }
    }
    // checking email address

    if (!is_email($_POST['email'])) {
        $s_msg = '1';
      $errors[] = 'Email address is invalid.';
    }
    // checking if email address already exists
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $query = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";

    $result_set = mysqli_query($connection, $query);

    //$result_user = mysqli_fetch_assoc($result_set);

    //$do_again = $result_user["id"];

    if ($result_set) {
      if (mysqli_num_rows($result_set) == 1) {
        $s_msg = '1';
        $errors[] = 'You have already done this activity';

	/*$errors[] = 'You have already done this activity</br> if you want to do this activity again <a href="index.php?re='. $do_again .'">click here</a>';*/
      }
    }
      if (empty($errors)) {
      // no errors found... adding new record
      //$email = mysqli_real_escape_string($connection, $_POST['email']);
      // email address is already sanitized
      //$s_time1 = '0000-00-00 00:00:00';


      date_default_timezone_set("Asia/Colombo");
	  $s_time1 = date("Y-m-d H:i:s");

      $query = "INSERT INTO users ( ";
      $query .= "name, nick_name, email, house_id, s_time";
      $query .= ") VALUES (";
      $query .= "'{$name}','{$nick_name}','{$email}','{$house_id}','{$s_time1}'";
      $query .= ")";

      $result = mysqli_query($connection, $query);

      if ($result) {
         $_SESSION['q_panel'] = 1;
    $query = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";

    $result_set = mysqli_query($connection, $query);
    $result_r_user = mysqli_fetch_assoc($result_set);

    $_SESSION['user_id'] = $result_r_user["id"];

        // query successful... redirecting to users page
      } else {
        $s_msg = '1';
        $errors[] = 'Register failed';
      }
    }
  }
  if (isset($_POST['start'])) { 

    $query = "UPDATE users SET s_time = NOW() WHERE id = '{$_SESSION['user_id']}'";
    $result = mysqli_query($connection, $query);


        $query = "SELECT * from q_table ";
        $results_que_count = mysqli_query($connection, $query);
        $row_results_que=mysqli_num_rows ($results_que_count);

        //echo ;

        $query = "SELECT * from q_table ORDER BY RAND()";
        $results_que = mysqli_query($connection, $query);
        $row_results=mysqli_num_rows ($results_que);
        $cnt=0;
        if ($results_que) {
        $movies_id = array();
        while ($result_q = mysqli_fetch_assoc($results_que)) {

        $movies_id[$cnt] = $result_q["id"];

        $cnt=$cnt+1;

        }
        $_SESSION['name_here'] = $movies_id;
    }


    if ($result) {
     //code

        } else {
        $s_msg = '1';
        $errors[] = 'Start failed';
      }

    $query = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}' LIMIT 1";

    $result_set = mysqli_query($connection, $query);
    $result_s_user = mysqli_fetch_assoc($result_set);

    if ($_SESSION['q_panel']==2) {
        $_SESSION['q_panel'] = 2;
    } else {
        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['q_panel'] = 2;
            $_SESSION['CREATED'] = time();
            $_SESSION['user_s_time'] = $result_s_user["s_time"];
        }
    }

  }

$query = "SELECT * from q_table ";
$results_que_count = mysqli_query($connection, $query);
$row_results_que=mysqli_num_rows ($results_que_count);

if (empty($_SESSION['next_count'])) {
    $_SESSION['next_count'] = 0;
}
    $u_id = '';
    $q_id = '';
    $q_answer = '';

  if (isset($_POST['set'])) { 

    $_SESSION['next_count'] ++;



    if ($_SESSION['time_out']==1) {
       $_SESSION['q_panel'] = 3;
    } else {

    	if ($row_results_que==0) {
        $s_msg = '1';
        $errors[] = 'No quaction Yet';
        unset($_SESSION['user_id']);
        $_SESSION['user_id']='';
        unset($_SESSION['q_panel']);
        $_SESSION['q_panel']='';
        unset($_SESSION['time_out']);
        $_SESSION['time_out']='';
        unset($_SESSION['user_s_time']);
        unset($_SESSION['CREATED']);
        $_SESSION['next_count'] = 0;
    	}


    $u_id = $_SESSION['user_id'];
    $q_id = $_POST['q_id'];

/*    $query = "SELECT * FROM a_table WHERE q_id = '{$q_id}' AND u_id = '{$u_id}' LIMIT 1";

    $result_set_s = mysqli_query($connection, $query);

    if ($result_set_s) {
      if (mysqli_num_rows($result_set_s) == 1) {
        $s_msg = '1';
        $errors[] = 'You have already done this quaction';
        //$_SESSION['next_count'] ++;
      }
    }*/


    if(isset($_POST['q_answer'])) {
        $q_answer = $_POST['q_answer'];
    }else{
        $q_answer = "0";
    }

      $query = "INSERT INTO a_table ( ";
      $query .= "u_id, q_id, q_answer";
      $query .= ") VALUES (";
      $query .= "'{$u_id}','{$q_id}','{$q_answer}'";
      $query .= ")";

      $result = mysqli_query($connection, $query);

      if ($result) { 

        if ($_SESSION['next_count'] == $row_results_que) {
            $_SESSION['q_panel'] = 3;
        }

      } else {
        $s_msg = '1';
        //printf($query);
        $errors[] = 'connection failed';

      }

    }

  }
    $query = "SELECT * FROM settings WHERE id = 6 LIMIT 1";

    $result_sett = mysqli_query($connection, $query);
    $result_settings = mysqli_fetch_assoc($result_sett);

    if ($result_settings["stats"]==1) {
        $_SESSION['q_panel'] = 4;
    } else {
    	if ($_SESSION['q_panel'] == 4) {
    		$_SESSION['q_panel']='';    	}
        //$_SESSION['q_panel']='';
    }

if (!empty($_SESSION['user_id'])) {
    $query = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}' LIMIT 1";

    $result_set_check_active = mysqli_query($connection, $query);

    if ($result_set_check_active) {
      if (mysqli_num_rows($result_set_check_active) == 0) {
        $s_msg = '1';
        $errors[] = 'YOU ARE REMOVED FROM THE SECTION';
        unset($_SESSION['user_id']);
        $_SESSION['user_id']='';
        unset($_SESSION['q_panel']);
        $_SESSION['q_panel']='';
        unset($_SESSION['time_out']);
        $_SESSION['time_out']='';
        unset($_SESSION['user_s_time']);
        unset($_SESSION['CREATED']);
        $_SESSION['next_count'] = 0;
        
      }
    }
}
?>
<!doctype html>
<html>
    <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title><?php echo htmlentities($result_settings["site_title"]);?></title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href='' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            background-color: #333
        }

        .container {
            background-color: #555;
            color: #ddd;
            border-radius: 10px;
            padding: 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            max-width: 800px
        }

        .container>p {
            font-size: 32px
        }

        .question {
            width: 75%
        }

        .options {
            position: relative;
            padding-left: 40px
        }

        #options label {
            display: block;
            margin-bottom: 15px;
            font-size: 14px;
            cursor: pointer
        }

        .options input {
            opacity: 0
        }

        .checkmark {
            position: absolute;
            top: -1px;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #555;
            border: 1px solid #ddd;
            border-radius: 50%
        }

        .options input:checked~.checkmark:after {
            display: block
        }

        .options .checkmark:after {
            content: "";
            width: 10px;
            height: 10px;
            display: block;
            background: white;
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: 300ms ease-in-out 0s
        }

        .options input[type="radio"]:checked~.checkmark {
            background: #21bf73;
            transition: 300ms ease-in-out 0s
        }

        .options input[type="radio"]:checked~.checkmark:after {
            transform: translate(-50%, -50%) scale(1)
        }

        .btn-primary {
            background-color: #555;
            color: #ddd;
            border: 1px solid #ddd
        }

        .btn-primary:hover {
            background-color: #21bf73;
            border: 1px solid #21bf73
        }

        .btn-success {
            padding: 5px 25px;
            background-color: #21bf73
        }

        @media(max-width:576px) {
            .question {
                width: 100%;
                word-spacing: 2px
            }
        }
        .footer {
           position: fixed;
           left: 0;
           bottom: 0;
           width: 100%;
           color: white;
           text-align: left;

        }
    </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 </head>
    <body oncontextmenu='return false' class='snippet-body'>
<!-- <nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="#">
    <img src="img/logo1.webp" width="70" class="d-inline-block align-top" alt="">
    <img src="img/logo2.webp" width="70" class="d-inline-block align-top" alt="">
  </a>
</nav> -->
<div class="text-right">
    <img src="../img/logo1.webp" width="100" class="d-inline-block align-top" alt="">
    <img src="../img/logo2.webp" width="100" class="d-inline-block align-top" alt="">
</div>
<?php if (empty($_SESSION['q_panel'])) { ?>
    <div class="container mt-sm-5 my-1">
        <div class="question ml-sm-5 pl-sm-5 pt-2">
           <form method="post" enctype="multipart/form-data">
            <?php if ($s_msg == 1) {?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error </strong><br> <?php if (!empty($errors)) {foreach ($errors as $error) {echo ': ' . $error . '<br>';}} $email = '';?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php }?>
              <div class="form-group">
                <label for="name">Enter Your Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="<?php echo $name;?>" autofocus>
              </div>
              <div class="form-group">
                <label for="nick">Enter Nickname</label>
                <input type="text" name="nick_name" id="nick" class="form-control" value="<?php echo $nick_name;?>" placeholder="Nickname">
              </div>
              <div class="form-group">
                <label for="email">Enter Email address</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $email;?>" aria-describedby="emailHelp" placeholder="Enter email">
                <!-- <small id="emailHelp" style="color:red">We'll never share your email with anyone else.</small> -->
              </div>
              <div class="form-group">
                <label for="house">Select Your House</label>
                <select class="form-control" name="house_id" id="house">
                    <option value="">Select</option>
                <?php 
                $query = "SELECT * from houses";
                $results = mysqli_query($connection, $query);
                $row_results=mysqli_num_rows ($results);
                if ($results) {
                $cnt=0;
                while ($result = mysqli_fetch_assoc($results)) {?>
                  <option value="<?php echo htmlentities($result["id"]);?>"><?php echo htmlentities($result["h_name"]);?></option>
                <?php $cnt=$cnt+1; }} ?>
                <?php if ($row_results == 0) { ?><option>No house found yet</option><?php } ?>
                </select>
              </div>
            <!--   <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div> -->
              <button type="submit" name="submit" class="btn btn-primary" id="load" onclick="myFunction()">Next</button>
            </form>
        </div>
    </div>

    <br><br><br>
    <?php } ?>
<?php if ($_SESSION['q_panel']==1) {?>
    <div class="container mt-sm-5 my-1">
        <div class="question text-center ml-sm-5 pl-sm-5 pt-2">
        <div class="py-2 h5"><b>You Have few minutes for Do this activity</b></div>
        <p style="color: red;">You can't change your answers again <br>
        You can't do this activity again</p>
        <form method="post" enctype="multipart/form-data">
        <button class="btn btn-success" name="start" id="load" onclick="myFunction()">Start Now</button>
        </form>
        </div>
    </div>
<?php } ?>

<?php if ($_SESSION['q_panel']==2) {

    if (time() - $_SESSION['CREATED'] > 295) {
        session_regenerate_id(true);
        if ($_SESSION['time_out']==0) {
            $_SESSION['CREATED'] = time();
        }
        $_SESSION['time_out'] = 1;
    }

    ?>

    <div class="container mt-sm-5 my-1">
        <div class="text-right"><p id="demo"><i class="fa fa-refresh fa-spin" style="font-size:24px"></i></p></div><hr style="background-color:#fff;">
        <div class="question ml-sm-5 pl-sm-5 pt-2">

<?php
/*echo $row_results_que;
echo "<br>";*/
	$qu_id = $_SESSION['next_count'];
	$quaction_id = $_SESSION['name_here'][$qu_id];
    $query = "SELECT * FROM q_table WHERE id = '{$quaction_id}'";
    $result_quection = mysqli_query($connection, $query);
    $result_all_que = mysqli_fetch_assoc($result_quection);

include('../admin/includes/config.php');

      $sql = "SELECT * FROM q_table WHERE id = '{$quaction_id}'";
      $query = $dbh -> prepare($sql);
      $query->execute();
      $result=$query->fetch(PDO::FETCH_OBJ);

?>
<style>  
    img {
      max-width: 25%;
      height: auto;
    }
</style>

 <div class="py-2 h5"><?php echo $result->quaction;?></div>
        <form method="post" enctype="multipart/form-data">
            <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
                <input type="hidden" name="q_id" value="<?php echo ($result_all_que["id"]);?>" >
                <label class="options"><?php echo htmlentities($result->a1);?><input type="radio" name="q_answer" value="1"> <span class="checkmark"></span> </label> 
                <label class="options"><?php echo htmlentities($result->a2);?><input type="radio" name="q_answer" value="2"> <span class="checkmark"></span> </label>
                <label class="options"><?php echo htmlentities($result->a3);?><input type="radio" name="q_answer" value="3"> <span class="checkmark"></span> </label>
                <label class="options"><?php echo htmlentities($result->a4);?><input type="radio" name="q_answer" value="4"> <span class="checkmark"></span> </label> 
            </div>
        </div>

        <div class="d-flex align-items-center pt-3">
            <button class="btn btn-success" name="set" id="load" onclick="myFunction()">Next</button>
        </div>
        </form>
    </div>
    <br>
    <br>
    <br>
<?php } ?>

<?php if ($_SESSION['q_panel']==3) { ?>


    <div class="container mt-sm-5 my-1">

<?php 
$query = "SELECT * from a_table WHERE u_id = '{$_SESSION['user_id']}' ";
$results_re = mysqli_query($connection, $query);
$row_results_re=mysqli_num_rows ($results_re);
if ($results_re) {
$cnt=0;
$writed = 0;
$my_c_answ = 0; 
while ($result_re = mysqli_fetch_assoc($results_re)) {?>

<?php 
    $query = "SELECT * FROM q_table WHERE id = '{$result_re["q_id"]}'";
    $result_quection_re = mysqli_query($connection, $query);
    $result_all_re = mysqli_fetch_assoc($result_quection_re);
?>

<?php 

/*echo($result_re["q_id"]);
echo "quaction :";
echo($result_all_re["r_answer"]);
echo "my :";
echo($result_re["q_answer"]);
echo "</br>";*/

         if (!$result_re["q_answer"]==0) {
            $writed++;
            if ($result_all_re["r_answer"]==$result_re["q_answer"]) {
                $my_c_answ++;
            }
         }

        $cnt=$cnt+1; 
    }
} 

$my_h_re = $my_c_answ / $writed * 100;
 
/* echo $my_h_re;
echo "</br>";*/

/*$date_r = new DateTime($_SESSION['CREATED']);
$extime_r = $date_r->format('Y-m-d H:i:s');*/

/*date_default_timezone_set("Asia/Colombo");
$extime_r = date("Y-m-d H:i:s");

$date_s = new DateTime($_SESSION['user_s_time']);
$extime_s = $date_s->format('Y-m-d H:i:s');

echo $extime_r. "</br>";

echo $extime_s. "</br>";

$to_time = strtotime("2008-12-13 10:42:00");
$from_time = strtotime("2008-12-13 10:21:00");
echo round(abs($to_time - $from_time) / 60,2). " minute";*/

?>

        <div class="text-right"><!-- <p id="demo"><i class="fa fa-refresh fa-spin" style="font-size:24px"></i> --></div><hr style="background-color:#fff;">

        <div class="question text-center ml-sm-5 pl-sm-5 pt-2">
        
        <div class="py-2 h5"><b>You Have Total marks For this activity : <?php echo intval($my_h_re); ?>%</b></div>
            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo intval($my_h_re); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo intval($my_h_re); ?>%"></div>
            </div>
        </div>
    </br>

<?php 
    $query = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}' LIMIT 1";

    $result_set = mysqli_query($connection, $query);
    $result_get_user = mysqli_fetch_assoc($result_set);

    $query = "SELECT * FROM houses WHERE id = '{$result_get_user["house_id"]}' LIMIT 1";

    $result_h = mysqli_query($connection, $query);
    $result_get_user_h = mysqli_fetch_assoc($result_h);

?>
            <table>
                <tr>
                    <td>User ID</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo $result_get_user["id"]; ?></td>
                </tr>
                <tr>
                    <td>User Name</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo $result_get_user["name"]; ?></td>
                </tr>
                <tr>
                    <td>User Nick Name</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo $result_get_user["nick_name"]; ?></td>
                </tr>
                <tr>
                    <td>User Email</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo $result_get_user["email"]; ?></td>
                </tr>
                <tr>
                    <td>User House</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo $result_get_user_h["h_name"]; ?></td>
                </tr>
                <tr>
                    <td>Number of questions encountered</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo $_SESSION['next_count']; ?></td>
                </tr>
                <tr>
                    <td>Final Result</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo $my_c_answ;?>/<?php echo $writed;?></td>
                </tr>
            </table>
            <hr style="background-color:#fff;">
    </div>

<?php } ?>
<?php if ($_SESSION['q_panel']==4) {?>
    <div class="container mt-sm-5 my-1">
        <div class="question text-center ml-sm-5 pl-sm-5 pt-2">
        	<img src="../img/under_construction_PNG38.png" width="250">
        <div class="py-2 h5"><b>Under Construction, Please check back later</b></div>
        <a href="https://alexlanka.com/"><button class="btn btn-success" id="load" onclick="myFunction()">OK</button></a>
        </div>
    </div>
<?php } ?>
<div class="footer bg-dark">
<!-- Facebook -->
<a class="btn btn-primary" style="background-color: #3b5998;" href="<?php echo htmlentities($result_settings["fb"]);?>" target=”_blank” role="button"
  ><i class="fab fa-facebook-f"></i
></a>
<!-- Youtube -->
<a class="btn btn-primary" style="background-color: #ed302f;" href="<?php echo htmlentities($result_settings["yt"]);?>" target=”_blank” role="button"
  ><i class="fab fa-youtube"></i
></a>

<a class="btn btn-primary" style="background-color: #00C1FF;" href="<?php echo htmlentities($result_settings["teli"]);?>" target=”_blank” role="button"
  ><i class="fab fa-telegram"></i
></a>
<!-- Whatsapp -->
<a class="btn btn-primary" style="background-color: #25d366;" href="<?php echo htmlentities($result_settings["wa"]);?>" target=”_blank” role="button"
  ><i class="fab fa-whatsapp"></i
></a>
</div>
<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>

<?php 

    /*$get_visitor_ip = '182.161.8.217';*/ //$_SERVER['REMOTE_ADDR'];
   /* $ip = $get_visitor_ip;*/
    // Use JSON encoded string and converts 
    // it into a PHP variable 
/*    $ipdat = @json_decode(file_get_contents( 
        "http://www.geoplugin.net/json.gp?ip=" . $ip)); */




?>
<?php 
/*echo $_SESSION['user_s_time'];
echo "</br>";*/
		$time_zone = "asia/Colombo";

       $r_alex_sv_time = $_SESSION['user_s_time'];

       $alex_sv_time = new DateTime($r_alex_sv_time);
       $sv_time = $alex_sv_time->format('Y-m-d H:i:s') . "<br/>";

       $la_time = new DateTimeZone($time_zone);
       $alex_sv_time->setTimezone($la_time);
       $user_time_s = $alex_sv_time->format('Y-m-d H:i:s');

       //echo $user_time_s;


	$date = new DateTime($user_time_s);
	$date->add(new DateInterval('P0Y0M0DT0H5M0S'));
	$extime = $date->format('Y-m-d H:i:s');

//echo $extime . "</br>" . $_SESSION['user_s_time'] . "</br></br></br></br>";


/*       $r_alex_sv_time = $extime;

       $alex_sv_time = new DateTime($r_alex_sv_time);
       $sv_time = $alex_sv_time->format('Y-m-d H:i:s') . "<br/>";

       $la_time = new DateTimeZone($time_zone);
       $alex_sv_time->setTimezone($la_time);
       $user_time = $alex_sv_time->format('Y-m-d H:i:s');*/


		//echo htmlentities($user_time). "</br>";

?>
<script>
function myFunction() {
  document.getElementById("load").innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>';
}
</script>
<script>
// Set the date we're counting down to
var countDownDate = new Date('<?php echo $extime;?>').getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "ACTIVITY TIME OUT";
  }
}, 1000);
</script>
</body>
</html>
<?php mysqli_close($connection); ?>