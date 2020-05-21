<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codeigniter 3.1.10 Dev - Pagination</title>
  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <h1>Countries</h1>
  <div id="body">
<?php
foreach($results as $data) {
    echo $data->full_name . " - " . $data->voter_id_no . "<br>";
}
?>
   <p>
   <div class="pagination">
   <?php echo $links; ?>
   </div>
   </p>
  </div>
  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
 </div>
  <style>
 .pagination a {
     padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
 }
 .pagination strong{
     z-index: 2;
    color: #fff;
    cursor: default;
    background-color: #428bca;
    border-color: #428bca;
 padding: 6px 16px;
    margin-left: -1px;
    color: #fff;
    text-decoration: none;
 }
 </style>
</body>
</html>
