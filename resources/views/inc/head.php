 <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
	  <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  <title>Calorie Calculator</title>
	  <?php error_reporting(0); ?>
	
	  <!--Search Bar-->
	  <link type="text/css" rel="stylesheet" href="css/searchbar.css"  media="screen,projection"/>
	  <script src="js/searchbar.js"></script>
    </head>
	  
	
    <body>

<!-- Navigation -->

<nav class="nav-extended">
	
	<!-- Side Nav -->
	<div>
  <ul id="slide-out" class="sidenav">
    <li><div class="user-view">
      <div class="background">
        <img src="images/nav-bg.png">
      </div>
      <a href="#user"><img class="circle" src="images/logo.png"></a>
      <a href="#name"><span class="white-text name">Name</span></a>
      <a href="#email"><span class="white-text email">mail@exampel.com</span></a>
    </div></li>
	<li><a href="index.php"><i class="material-icons">home</i>Home</a></li>
    <li><a href="#!"><i class="material-icons">cloud</i>Account</a></li>
    <li><a href="#!">Status</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">info</a></li>
    <li><a class="waves-effect" href="#!">Login</a></li>
  </ul>
  	<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
	</div>
	<!-- Side Nav -->
	
    <div class="nav-wrapper">
		<div class="z-depth-5">
      	<div class="left-align"><a href="index.php" class="brand-logo left hide-on-med-and-down" style="padding-left: 20px;">Calorie Calculator</a></div>
	  <ul class="right hide-on-med-and-down">
		<li><a class="waves-light modal-trigger" href="#modal1"><i class="material-icons">view_module</i></a></li>
        <li><a href="index.php"><i class="material-icons">refresh</i></a></li>
        <li><a href="#" class='dropdown-trigger btn btn-floating' href='#' data-target='dropdown1'><i class="material-icons">more_vert</i></a></li>
		<li></li>
      </ul>
			
	<!-- Modal Structure -->
  	<div id="modal1" style="background-color: #2196f3; margin: 0; height: 100%; overflow: hidden ; margin: 0; height: 100%;" class="modal bottom-sheet">
     <div class="modal-content">
		 
      <h4>Category
		  <a href="#!" style="background-color: green; color: white;" class="modal-close waves-effect right waves-green btn-flat">Close</a>
 	  </h4>
		<?php include 'slide.php';?>
		 <div class="owl-carousel owl-theme mt-5">
        <div class="item"><h4>1</h4></div>
        <div class="item"><h4>2</h4></div>
        <div class="item"><h4>3</h4></div>
        <div class="item"><h4>4</h4></div>
        <div class="item"><h4>5</h4></div>
        <div class="item"><h4>6</h4></div>
        <div class="item"><h4>7</h4></div>
        <div class="item"><h4>8</h4></div>
        <div class="item"><h4>9</h4></div>
        <div class="item"><h4>10</h4></div>
		<div class="item"><h4>11</h4></div>
		<div class="item"><h4>12</h4></div>
		 </div>
     </div>
     <div class="modal-footer" style="background-color: #2196f3;">
      </div>
  	</div>
			
	<!-- search -->
	<form action="" class="browser-default right">
       <input id="search-input" placeholder="Search" type="text" class="browser-default search-field" name="q" value="" autocomplete="off" aria-label="Search box">
       <label for="search-input"><i class="material-icons search-icon">search</i></label> 
        <i class="material-icons search-close-icon">cancel</i>
        <div class="search-popup">
         <div class="search-content">
           <label class="search-heading">Most Visited</label>
           <ul class="popup-list">
           <li class=""><a class="grey-text" href="#">Google</a></li>
          </ul>
         </div>
       </div>
     </form>
	<!-- search -->
		
    </div>
   </div>
</nav>
		
	<!-- dot button -->
  <ul id='dropdown1' class='dropdown-content'>
    <li><a href="#login" class="modal-trigger"><i class="material-icons"></i>Login</a></li>
    <li><a href="#register" class="modal-trigger">Register</a></li>
    <li class="divider" tabindex="-1"></li>
    <li><a href="#help" class="modal-trigger">Help</a></li>
    <li><a href="#contact" class="modal-trigger"><i class="material-icons"></i>contact</a></li>
    <li><a href="#feedback" class="modal-trigger"><i class="material-icons"></i>feedback</a></li>
  </ul>
	<!-- dot button -->
		

	<!--login-->


<div id="login" class="modal">
  <h5 class="modal-close" style="padding-left: 20px;">&#10005;</h5>
  <div class="modal-content center">
    <h4>Login Form</h4>
    <br>

    <form action="#">

      <div class="input-field">
        <i class="material-icons prefix">person</i>
        <input type="text" id="name">
        <label for="name">Username</label>
      </div>
      <br>

      <div class="input-field">
        <i class="material-icons prefix">lock</i>
        <input type="password" id="pass">
        <label for="pass">Password</label>
      </div>
      <br>

      <label class="left">
        <input  type="checkbox" id="check">
         <span for="check">Remember Me</span>
      </label>
      <br>
		<br>
      
      <input type="submit" value="Login" class="btn btn-large">
		
       <div class="row">
          <div class="input-field col s6 m6 l6">
            <p class="margin left medium-small"><a href="#">Register Now!</a></p>
          </div>
          <div class="input-field col s6 m6 l6">
              <p class="margin right-align medium-small"><a href="#">Forgot password?</a></p>
          </div>          
        </div>
    </form>
  </div>
</div>	
		
	<!--login-->

		
	<!--register-->	

		<div class="container">
<div class="row">
	<div id="register" class="modal">
	<h5 class="modal-close" style="padding-left: 20px;">&#10005;</h5>
     <div class="modal-content">
    <form class="col s12" id="reg-form">
      <div class="row">
        <div class="input-field col s6">
          <input id="first_name" type="text" class="validate" required>
          <label for="first_name">First Name</label>
        </div>
        <div class="input-field col s6">
          <input id="last_name" type="text" class="validate" required>
          <label for="last_name">Last Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" class="validate" required>
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password" type="password" class="validate" minlength="6" required>
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <label style="padding-left: 100px">
        <input name="group1" type="radio"/>
        <span>Female</span>
      </label>
          <label>
        <input name="group1" type="radio"/>
        <span>Male</span>
      </label>
        </div>
</div>
        <div class="input-field col s6 right">
          <button class="btn btn-large btn-register waves-effect waves-light" type="submit" name="action">Register
            <i class="material-icons right">done</i>
          </button>
        </div>
      
    </form>
  </div>
</div>
	</div>
		</div>
		
	<!--register-->
	
	<!--help-->
		
	<div id="help" class="modal">
  <h5 class="modal-close" style="padding-left: 20px;">&#10005;</h5>
  <div class="modal-content center">
	 
	<img src="images/icons/help.png" style="width:15%; height:15%" draggable="false">
		  
    <h4>Need Help?</h4>
    <br>
	  
	<p>
	If you need any help please contact us at example@mail.com ,
	</p>
	<p>
	or you can use our feadback field to share your infos.
	</p>	  
    
  </div>
</div>
		
		<!--help-->
		
		<!--contact-->
	<div id="contact" class="modal">
  <h5 class="modal-close" style="padding-left: 20px;">&#10005;</h5>
  <div class="modal-content">
	 
	
    <h4 class="center">Looking for more?</h4>
	  
	
	<h5 class="center">
	here you can find us in social Media!
	</h5>
	<br>

	  <form>
		<div class="row">
        <div class="col s12">
    <a class="col s3 m3" href="#!">
      <div class="card blue darken-1">
        <div class="card-content white-text">
          <span class="card-title">Twitter</span>
          <p>Check our Twitter page!</p>
        </div>
      </div>
  </a>
			
    <a class="col s3 m3" href="#!">
      <div class="card red darken-1">
        <div class="card-content white-text">
          <span class="card-title">YouTube</span>
          <p>Follow us in Youtube!</p>
        </div>
      </div>
    </a>
			
    <a class="col s3 m3" href="#!">
      <div class="card orange darken-1">
        <div class="card-content white-text">
          <span class="card-title">Reddit</span>
          <p>Check us in our reddit page!</p>
        </div>
    </div>
  </a>
			
    <a class="col s3 m3" href="#!">
      <div class="card indigo accent-3">
        <div class="card-content white-text">
          <span class="card-title">Discord</span>
          <p>Become part of our Commiunity!</p>
        </div>
      </div>
  </a>
		
   	 </div>
     </div>
   </form>
	  
  <br>
	 
  </div>
 </div>
		
		<!--contact-->
		
		
		<!--Feedback-->
		
	<div id="feedback" class="modal">
  <h5 class="modal-close" style="padding-left: 20px;">&#10005;</h5>
  <div class="modal-content center">
	 
		  
    <h4>Have you got any idea?</h4>
    <br>
	  
	<p>
	We would like to know your thoughts.
	</p>
  
	<div class="row">
    <form class="col s12">
      <div class="row">

		<div class="input-field col s6">
          <i class="material-icons prefix">person</i>
          <input id="feedbackname" type="text" class="validate">
          <label for="feedbackname">Name</label>
        </div>
		  
		<div class="input-field col s6">
          <i class="material-icons prefix">email</i>
          <input id="feedbackmail" type="email" class="validate" required>
          <label for="feedbackmail">mail</label>
        </div>
		  
        <div class="input-field col s12">
          <i class="material-icons prefix">mode_edit</i>
          <textarea id="icon_prefix2" class="materialize-textarea" required></textarea>
          <label for="icon_prefix2">Feedback</label>
        </div>
		    
      </div>
  		<button class="btn waves" type="submit" name="action">Submit
   	 	<i class="material-icons right">send</i>
  		</button>	
    </form>

  </div>
    
  </div>
</div>
		
		<!--Feedback-->