<!--<div>
  <div class="header1" style="background-image: url('images/parallax1.png')">
  </div>  
</div>-->

<main>
	
<div class="row">
    <div class="col s12">
<a class="waves-effect waves-light btn" href="info.php"><i class="material-icons left">info</i>About</a>
<a class="waves-effect waves-light btn" href="archive.php"><i class="material-icons left">archive</i>Archive</a>
<a class="waves-effect waves-light btn" target="_blank" href="https://myanimelist.net/"><i class="material-icons left">web</i>blog</a>
	</div>
</div>


 <div class="row">
	 
		<!--1th half-->
	<div class="col s12 m6">
  <ul class="collapsible" style="overflow: hidden; background-color: white;">
    <li>
      <div class="collapsible-header"><i class="material-icons">person</i>Human</div>
      <div class="collapsible-body"><span><form method="post">
	
	<div class="row">
	<div class="col s3">
		<label><div style="min-width:160px;">Gender Select</div></label>
	  <select class="browser-default" name="select" required style="min-width:160px;">
		<option value="" disabled selected>Choose your Gender</option>
	    <option value="1">Male</option>
	    <option value="2">Female</option>
	  </select>
	 </div>
	 </div>

		<div class="row">
        <div class="col s12">
          Weight:
          <div class="input-field inline">
            <input id="weight" type="number" required name="number1" class="validate">
            <label for="weight">kg</label>
          </div><div class="row">
        <div class="col s12">
          Height:
          <div class="input-field inline">
            <input id="height" type="number" required name="number2" class="validate">
            <label for="height">cm</label>
          </div><div class="row">
        <div class="col s12">
		  Age:
          <div class="input-field inline">
            <input id="age" type="number" required name="number3" class="validate">
            <label for="age">years</label>
          </div>
		<div>
			<button class="btn waves-effect waves-light" type="submit" name="submit">Calculate
			<i class="material-icons right">send</i>
			</button>
		</div>
</form></span></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">pets</i>Pets</div>
      <div class="collapsible-body"><span><form method="post">
	
	<div class="row">
	<div class="col s2">
		<label><div style="min-width:160px;">Pet Select</div></label>
	  <select class="browser-default" name="select" required style="min-width:160px;">
		<option value="" disabled selected>Choose your Pet</option>
		<option value="3">Dog</option>
		<option value="4">Cat</option>
	  </select>
	 </div>
	 </div>

		<div class="row">
        <div class="col s12">
          Weight:
          <div class="input-field inline">
            <input id="weight1" type="number" required name="number1" class="validate">
            <label for="weight1">kg</label>
          </div><div class="row">
        <div class="col s12">
          Height:
          <div class="input-field inline">
            <input id="height1" type="number" required name="number2" class="validate">
            <label for="height1">cm</label>
          </div>
		<div>
			<button class="btn waves-effect waves-light" type="submit" name="submit">Calculate
			<i class="material-icons right">send</i>
			</button>
		</div>
</form></span></div>
    </li>
    <li  class="active">
      <div class="collapsible-header"><i class="material-icons">whatshot</i>Results</div>
      <div class="collapsible-body">
		  <span>
		   <?php 
			include 'math.php';
		   ?>
		  </span>
	  </div>
    </li>
   </ul>
		  
  </div>
		<!--1th half-->
		  
		<!--2th half-->
	<div class="col s12 m6">
	  <div class="z-depth-3">  
 		

	<div class="card" style="overflow: hidden;">
			 <div class="card-image waves-effect waves-block waves-light">
			 <img class="activator" src="https://cdn.wallpapersafari.com/8/60/1HYcW5.jpg">
    		 </div>
    <div class="card-content">
      <span class="card-title activator grey-text text-darken-4">Sport and Health<i class="material-icons right">more_vert</i></span>
      <p><a href="article1.php">More info</a></p>
    </div>
	<div class="card-reveal">
       <span class="card-title grey-text text-darken-4">Benefits of Exercise and Sport<i class="material-icons right">close</i></span>
       <p>Playing a sport helps you build your character. It teaches you to bide by the rules and follow them. Sports also teach you how to succeed with class and to lose with dignity. Sports teach kids work ethic, teamwork, social skills, cooperation, authority, respect, responsibility, passion, skill, etc.</p>
       <span class="card-title grey-text text-darken-4">Healthy Foods and Why does it Matter</span>
       <p>Organic food is a huge trend: it promises a healthier and better life. But can Organic food really live up to the expectations or is it just baloney?</p>
        
	   <div class="video-container">
       <iframe width="560" height="315" src="https://www.youtube.com/embed/8PmM6SUn7Es" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
       </div>
	</div>
   </div>
  
	  </div>
	</div>
		<!--2th half-->
		  
 </div>

</main>

