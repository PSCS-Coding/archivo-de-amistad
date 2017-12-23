<?php
//fetch.php
require_once("connection.php");
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($db_server, $_POST["query"]);
 $query = "
  SELECT * FROM memes 
  WHERE memeTitle LIKE '%".$search."%'
  LIMIT 6
 ";
}
else
{
 $query = "
  SELECT * FROM memes ORDER BY memeId LIMIT 6
 ";
}
$result = mysqli_query($db_server, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
<div class="row">
 ';
 while($row = mysqli_fetch_array($result))
 {
  $better_date = new DateTime($row['dateAdded']);
  $output .= '
  <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class="card" style="width: 20rem;">
<img class="card-img-top" src="'.$row["memeTitle"].'" alt="Image failed to load.">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Name: '.$row["memeTitle"].'</li>
    <li class="list-group-item">Date added: '.$better_date->format('M jS, Y').'</li>
  </ul>
      <div class="card-footer">
      <small class="text-muted">Tags: Coming Soon.</small>
    </div>
</div>
</div>
  ';
 }
     $output .= '
</div>
 ';
 echo $output;
}
else
{
 echo '<div class="alert alert-danger" role="alert">
  <strong>Oh nooooo!</strong> No images were found.
  <a href="#" id="goButton">WOW</a>
</div>';
}

?>
