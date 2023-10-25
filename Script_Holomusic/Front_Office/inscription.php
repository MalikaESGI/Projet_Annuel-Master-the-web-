<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../CSS/Style_inscription.css"/>
	<script src="../JS/inscription.js" type="text/javascript" defer></script>
	 <title>Sign up</title> 
</head>
<body>     
		<main>
		<div class="box1">
		  <div class="inner-box">
		  <form action="verification_inscriptions" method="POST" class="sign-up"> 
		 	 <div class="head1">
		     <h1>Sign up</h1>
		     </div> 
			 
			 <div class="progress-bar">
			 
			 <div class="progress" id="progress"></div>
			 
			 <div class="progress-step progress-step-active"></div>
			 <div class="progress-step"></div>
			 <div class="progress-step"></div>
			 </div>
			 
			 
		   <div class="form-step form-step-active">
			
		    <div class="input">
             <input type="text" name="username"  placeholder="Username" class="input-field" value="<?= (isset($_COOKIE['username']) ? $_COOKIE['username'] : '') ?>">
		   </div>
		   
		   <div class="input">
             <input type="text" name="name" placeholder="Firstname" class="input-field"value="<?= (isset($_COOKIE['name']) ? $_COOKIE['name'] : '') ?>">
		   </div> 
		  
			  <?php
            if(isset($_GET['message']) && !empty($_GET['message'])){
                echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
            }

        ?>
            
			<a href="#" class="sign-btn">Next</a>
            
			</div> 
			
			
			
			  <div class="form-step">
		   <div class="input">
             <input type="date" name="date_of_birth" placeholder="Date of birth" class="input-field" value="<?= (isset($_COOKIE['date_of_birth']) ? $_COOKIE['date_of_birth'] : '') ?>">
		   </div> 
		 
		   <div class="input">
             <input type="email" name="email"  placeholder="Email" class="input-field"value="<?= (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
		   </div>
		    <?php
   
            if(isset($_GET['message']) && !empty($_GET['message'])){
                echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
            }


        ?>
		   <div class="btn-grp">
		    <a href="#" class="sign-btn-back">Back</a>
		   <a href="#" class="sign-btn">Next</a>
		   </div> 
		    </div> 
		   
			 <div class="form-step ">
		   <div class="input">
             <input type="password" name="mdp" placeholder="Password" class="input-field">
		   </div> 
		   
		     <div class="input">
             <input type="password" name="mdp-confirm" placeholder="Confirm Password" class="input-field">
		   </div>
		   
		    <?php

            if(isset($_GET['message']) && !empty($_GET['message'])){
                echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
            }
   
        ?>
		   
		   <div class="btn-grp">
		   <a href="#" class="sign-btn-back">Back</a>
		   <input type="submit" value="Sign in" class="sign-btn"> 
			 </div>
		   </div> 
         </form> 
		 
		 
		   </div>
		   
		  <div class="sign-in">
		  <h1>Already a member ?</h1>
          <a href="/connexion" class="sign-in-btn">Sign in</a>
          </div>

		</div>
		
		</div>
		 </div>
		</main>  
</body>
</html>