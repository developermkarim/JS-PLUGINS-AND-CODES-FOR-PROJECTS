## Session cannot be started after headers have already been sent in path.

Solution by Stack OverFlow
You're outputting HTML before the session_start(). Put your PHP code above the HTML code Like the following. 
```php
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>

```
**But Not Like The Following:** It will be exucute error like Warning: session_start(): Session cannot be started after headers have already been sent in (path).
and Undefined variable *$_SESSION['username']*.

```php
<li class="dropdown">
<a class="dropdown-toggle" href="#" data-toggle="dropdown">
<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
if(isset($_SESSION["user_role"])){ ?>
Hello <?php echo $_SESSION["username"]; ?><i class="caret"></i>
<?php  }else{ ?>
<i class="fa fa-user"></i>
<?php  } ?>

</a>
<ul class="dropdown-menu">
<!-- Trigger the modal with a button -->
<?php
if(isset($_SESSION["user_role"])){ ?>
    <li><a href="user_profile.php" class="" >My Profile</a></li>
    href="javascript:void()" class="user_logout" >Logout</a></li>
<?php  }else{ ?>
    <li><a data-toggle="modal" data-target="#userLogin_form" href="#">login</a></li>
    <li><a href="register.php">Register</a></li>
<?php  } ?>

</ul>
</li>
```
