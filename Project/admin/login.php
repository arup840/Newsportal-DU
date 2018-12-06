<?php

if(isset($_POST['form_login'])) 
{
	
	try {
	
		
		if(empty($_POST['username'])) {
			throw new Exception('Username can not be empty');
		}
		
		if(empty($_POST['password'])) {
			throw new Exception('Password can not be empty');
		}
	
		
		$password = $_POST['password']; // admin
		$password = md5($password);
	
	
		include('../config.php');
		$num=0;
		
		
		$statement = $db->prepare("select * from admin where username=? and password=?");
		$statement->execute(array($_POST['username'],$password));		
		
		$num = $statement->rowCount();
		
		if($num>0) 
		{
			session_start();
			$_SESSION['name'] = "admin";
			header("location: index.php");
		}
		else
		{
			throw new Exception('Invalid Username and/or password');
		}
	
	
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
	
}

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet" type="text/css"  media="all" />
        <link href="css/style_admin.css" rel="stylesheet" type="text/css"  media="all" />
       
        <title>Login Admin panel || PSTU News Portal</title>
        <style>
            a:hover{
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="wrapperLogin">
                <div class="row" style="margin-left:20px;margin-top:20px;">
                    
					<?php
						if(isset($error_message))
						{
							echo "<div class='error'>".$error_message."</div>";
						}
					?>
					
					<form class="" name="form_login" action="login.php" method="post">
                        
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">User name</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" class="form-control"  style="width: 60%;margin-bottom: 20px;" placeholder="Admin Username"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control"  style="width: 60%;margin-bottom: 20px;" placeholder="Admin password"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2  col-sm-10" >

                                <button type="submit" class="btn btn-primary" name="form_login" >Login</button>

                            </div>

                        </div>


                    </form>
                </div>
            </div>

        </div>

    </body>
</html>