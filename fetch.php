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
    $name = explode("/", $row['memeTitle'])[1];
    $name = explode(".", $name)[0];
    $better_date = new DateTime($row['dateAdded']);
    $output .= '
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="card" style="width: 20rem;">
            <a href="'.$row["memeTitle"].'" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="900" data-max-height="750" data-title="'.$name.'" data-footer="'.$row['comments'].'">
    <img class="card-img-top img-fluid" src="'.$row["memeTitle"].'" alt="Image failed to load.">
    </a>
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
</div>';
}

?>
