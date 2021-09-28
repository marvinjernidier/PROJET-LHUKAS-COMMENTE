<?php

require_once('bd/connect.php');
session_start();


$i =0;
$IDtrainers = 72;

$sql3 = "SELECT * FROM subject WHERE IDtrainers =  $IDtrainers";
$p3 = $co->query($sql3);

while ($row3 = $p3->fetch_assoc()) {
  $i++;
 ${'SubjectTrainers'.$i}=$row3['Subject'];
 ${'SubjectTrainersDuration'.$i}=0;

 $Subject = $row3['Subject'];

 
      $sql4 = "SELECT * FROM offers WHERE IDtrainers = $IDtrainers AND Subject = '$Subject'";
      $p4 = $co->query($sql4);
      while ($row4 = $p4->fetch_assoc()) {
        ${'SubjectTrainersDuration'.$i}+=$row4['Duration'];
        $ID = $row4['IDoffers'];
        echo $row4['IDoffers']."///////////";


        $sql2 = "SELECT * FROM offerssecond WHERE IDoffers = $ID  AND IDtrainers =  $IDtrainers";
        $p2 = $co->query($sql2);
        while ($row2 = $p2->fetch_assoc()) {
          ${'SubjectTrainersDuration'.$i}+=$row2['Duration'];
          echo $row2['IDofferSeconde']."///////////";
      }

     
        
      }
       $sql5 = "SELECT * FROM offerssecond WHERE IDtrainers =  $IDtrainers AND IDoffers in (SELECT IDoffers FROM offers WHERE Status = 'Untreated' AND Subject = '$Subject') ";
        $p5 = $co->query($sql5);
        while ($row5 = $p5->fetch_assoc()) {
          ${'SubjectTrainersDuration'.$i}+=$row5['Duration'];
          echo $row5['IDofferSeconde']."///////////";

      }
  }

    $dataPoints = array();
    
  if(isset($SubjectTrainers1)){
    array_push( $dataPoints,array("label"=> "$SubjectTrainers1","y"=> $SubjectTrainersDuration1) );
}

if(isset($SubjectTrainers2)){
  array_push( $dataPoints,array("label"=> "$SubjectTrainers2","y"=> $SubjectTrainersDuration2) );
}
if(isset($SubjectTrainers3)){
  array_push( $dataPoints,array("label"=> "$SubjectTrainers3","y"=> $SubjectTrainersDuration3) );
}




	
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "test"
	},
	axisY: {
		title: "nombre heures"
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>                              