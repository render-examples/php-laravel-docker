<?php  

	if(isset($_POST['submit']))  
    {
		$number1 = $_POST['number1'];  
		$number2 = $_POST['number2'];  
		$number3 = $_POST['number3'];
		$select  = $_POST['select'];
		$bmi     = $_POST['submit'];
		$submit  = $_POST['submit'];
		
	switch ($select) {
		case 1:
        	$submit =  66+(13.7*$number1)+(5*$number2)-(6.8*$number3);
			$bmi =  $number1 / ($number2*$number2);
			echo "<div class='row'><div class='col s2'><div class='input-field inline' style='min-width:160px;'>Calorie Consumption : <input disabled value='$submit' id='disabled' type='number' class='validate'></div>";
			echo "<div class='row'><div class='col s2'><div class='input-field inline' style='min-width:160px;'>BMI Consumption : <input disabled value='$bmi' id='disabled' type='number' class='validate'></div>";
			break;
		case 2:
			$submit =  655+(9.6*$number1)+(1.7*$number2)-(4.7*$number3);
			$bmi =  $number1 / ($number2*$number2);
			echo "<div class='row'><div class='col s2'><div class='input-field inline' style='min-width:160px;'>Calorie Consumption : <input disabled value='$submit' id='disabled' type='number' class='validate'></div>";
			echo "<div class='row'><div class='col s2'><div class='input-field inline' style='min-width:160px;'>BMI Consumption : <input disabled value='$bmi' id='disabled' type='number' class='validate'></div>";
			break;
		case 3:
        	$submit = ($number1/0.45)/($number2/2.54);
			echo "<div class='row'><div class='col s2'><div class='input-field inline' style='min-width:160px;'>Calorie Consumption : <input disabled value='$submit' id='disabled' type='number' class='validate'></div>";
			break;
		case 4:
			$submit = ($number1/0.45)/($number2/2.54);
			echo "<div class='row'><div class='col s2'><div class='input-field inline' style='min-width:160px;'>Calorie Consumption : <input disabled value='$submit' id='disabled' type='number' class='validate'></div>";
			break;
	} 
	} 
	


?>  

