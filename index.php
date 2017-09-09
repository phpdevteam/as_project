<?php

   session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {	
        
		echo "<script type='text/javascript'>window.location='./intranet/login.php';</script>";
    }
	else
	{	
		echo "<script type='text/javascript'>window.location='./intranet/main.php';</script>";
	}
?>