<?php session_start();

 include 'conn.php';
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

	<title>La liste des eleves present</title>


</head>
<body>

	<style>

body {font-family: "Lato", sans-serif;
	  text-decoration: red;
	  background: lightgray;
}

.sidebar {
  height: 100%;
  width: 230px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: darkgray;
  overflow-x: hidden;
  padding-top: 16px;
}

.sidebar a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
}

.sidebar a:hover {
  color: #f1f1f1;
}


@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}

nav{font-family: "lato", cooper;

      background: black;


}

h1{
	width: 800px;
	height: 50px;
  color: white;

}
th{

  color: red;
}

td{

  color: black;
}


</style>

<div class="sidebar ">
  <a href="logout.php"><i class="fas fa-sign-in" style="font-size:60px "></i> Deconnexion</a>
</div>


<center>

  <nav>

 	    <h1>LA LISTE DES ELEVES PRESENT</h1>

  </nav><br><br>
 


<?php

$datesign = "";
$post_at_to_date = "";
  
  $queryCondition = "";
  if(!empty($_POST["search"]["datesign"])) {      
    $datesign = $_POST["search"]["datesign"];
    list($fiy,$fim,$fid) = explode("-",$datesign);
    
    $post_at_todate = date('Y-m-d');
    if(!empty($_POST["search"]["post_at_to_date"])) {
      $post_at_to_date = $_POST["search"]["post_at_to_date"];
      list($tiy,$tim,$tid) = explode("-",$_POST["search"]["post_at_to_date"]);
      $post_at_todate = "$tiy-$tim-$tid";
    }
    
    $queryCondition .= "WHERE datesign BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
  }

  $sql = "SELECT * from attendance " . $queryCondition . " ORDER BY time";
      $result = mysqli_query($conn,$sql);

mysqli_close($conn);
      
?>

  
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  
  <body>
    <div class="demo-content">
  <form name="frmSearch" method="post" action="">
   <p class="search_input">
    <input type="text" placeholder="De la date" id="datesign" name="search[datesign]"  value="<?php echo $datesign; ?>" class="input-control" />
      <input type="text" placeholder="à la date" id="post_at_to_date" name="search[post_at_to_date]" style="margin-left:10px"  value="<?php echo $post_at_to_date; ?>" class="input-control"  />       
    <input type="submit" name="go" value="Recherche" >
  </p>
<?php if(!empty($result))  { ?>
  <div class="container sm-3">
<table class="table table-bordered table-hovered">
          <thead>
        
        <tr>
                      
            <th>NOM & PRENOMS</th>          
            <th>EMAIL</th>      
            <th>DATE DE PRESENCE</th>
            <th>HEURE DE SIGNATURE</th>

        </tr>

      </thead>
    <tbody>
  <?php
    while($row = mysqli_fetch_array($result)) {
  ?>
    <tr>
      <td><?php echo $row["username"]; ?></td>
      <td><?php echo $row["email"]; ?></td>
      <td><?php echo $row["datesign"]; ?></td>
      <td><?php echo $row["time"]; ?></td>

    </tr>
   <?php
    }
   ?>
   <tbody>
  </table>
<?php } ?>
  </form>
  </div>
  </div>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$.datepicker.setDefaults({
showOn: "button",
buttonImage: "datepicker.png",
buttonText: "Date Picker",
buttonImageOnly: true,
dateFormat: 'yy-mm-dd'  
});
$(function() {
$("#datesign").datepicker();
$("#post_at_to_date").datepicker();

});
</script>


 </center>
</body>
</html>