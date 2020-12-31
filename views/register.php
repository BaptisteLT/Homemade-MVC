<?php
  
?>

<h1>Register</h1>



<form action="" method="post">
  
<div class="row">
    <div class="col">
        <div class="form-group">
            <label>Firstname</label>
            <input type="text" class="form-control" name="firstname">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" name="lastname">
        </div>
    </div>
</div>

  <div class="form-group">
    <label>Email</label>
    <input type="text" class="form-control" name="email">
  </div>

  <div class="form-group">
    <label>Password</label>
    <textarea type="password" class="form-control" name="password"></textarea>
  </div>

  <div class="form-group">
    <label>Confirm Password</label>
    <textarea type="password" class="form-control" name="confirmPassword"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>