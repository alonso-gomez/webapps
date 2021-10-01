<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation - User register </title>

<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' />

<link href="css_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
<!--
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
//-->
</script>
</head>

<body>
<div id="main">


<!-- HEADER END -->

<?php include("includes/header.php"); ?>
<div class="txt_navbar" id="navbar"><strong>You are here:</strong> Home
</div>

<div id="content" class="txt_content">
  <h2>User register</h2>
  <p>Use the form below to register a new user.</p>

  <table>
    <tr>
      <td>
        <label for="name">Name:*</label>
      </td>
      <td><input type="text" name="name"></td>
    </tr>
    <tr>
      <td>
        <label for="lastname">Lastname:*</label>
      </td>
      <td><input type="text" name="lastname"></td>
    </tr>
    <tr>
      <td>
        <label for="email">Email:*</label>
      </td>
      <td><input type="text" name="email"></td>
    </tr>
    <tr>
      <td>
        <label for="password">Password:*</label>
      </td>
      <td><input type="text" name="password"></td>
    </tr>
    <tr>
      <td>
        <label for="phone">Phone:</label>
      </td>
      <td><input type="text" name="phone"></td>
    </tr>
    <tr>
      <td>
        <label for="role">Role:</label>
      </td>
      <td><input type="text" name="role"></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit"></td>
    </tr>
  </table>
  
</div>

<!--CONTENT END -->


<?php include("includes/sidebar.php"); ?>
<!-- SIDEBAR END -->
<div style="clear: both;"></div>

<?php include("includes/footer.php"); ?>
</div>

</body>
</html>
