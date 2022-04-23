    <div class="col-sm-3 sidenav">
      <h4>Admin Dashboard 5.21.v</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="<?php if ($page_num == 1) { echo "active"; } ?>"><a href="dashboard.php">Home</a></li>
        <li class="<?php if ($page_num == 2) { echo "active"; } ?>"><a href="question.php">Questions</a></li>
        <li class="<?php if ($page_num == 3) { echo "active"; } ?>"><a href="admins.php">Admins</a></li>
        <li class="<?php if ($page_num == 4) { echo "active"; } ?>"><a href="settings.php">Settings</a></li>
      </ul><br>
      <a href="logout.php"><button type="button" class="btn btn-danger btn-lg btn-block"><i class="fa fa-sign-out"></i>Logout</button></a>
    </div>