<!DOCTYPE html>
<html lang="en">
<head>
  <title>Codeigniter Crud By Crud Generator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://crudegenerator.in">Codeigniter Crud By Crud Generator</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="<?php echo site_url(); ?>manage-user">Manage User</a></li>
        <li><a href="<?php echo site_url(); ?>add-user">Add User</a></li>
      </ul>
  </div>
</nav>

<div class="container">

  <h2>Update User</h2>
<form role="form" method="post" action="<?php echo site_url()?>edit-user-post" enctype="multipart/form-data">

 <input type="hidden" value="<?php echo $user[0]->id ?>"   name="user_id">


      <div class="form-group">
    <label for="id">Id:</label>
    <input type="number" value="<?php echo $user[0]->id ?>" class="form-control" id="id" name="id">
  </div>
    <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" value="<?php echo $user[0]->name ?>" class="form-control" id="name" name="name">
  </div>
    <div class="form-group">
    <label for="loginid">Loginid:</label>
    <input type="text" value="<?php echo $user[0]->loginid ?>" class="form-control" id="loginid" name="loginid">
  </div>
    <div class="form-group">
    <label for="gender">Gender:</label>
    <input type="text" value="<?php echo $user[0]->gender ?>" class="form-control" id="gender" name="gender">
  </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</body>
</html>
