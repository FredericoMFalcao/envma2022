<?php 
if (isset($_GET['id']))
{
        $days = 360;
        $expire=time()+60*60*24*$days;
        setcookie("loginID", $_GET['id'], $expire,"/");
}
else
{
        die("ERROR: Invalid loginID provided!");
    
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>ENVMA 2022</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
<body>
Vai ser redirecionado ...    

<script>
        window.location = '/';
</script>
</body>
</html>