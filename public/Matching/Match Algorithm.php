<?php
//need to generate a associative array from the table in profile page.
//critical and Hobby and user_state. Hobby is reversed.
//every users'Detail.
function main(){

$array_D = file_get_contents("teampData.json");
$Detail = json_decode($array_D,true);

$array_C = file_get_contents("Critical.json");
$Critical = json_decode($array_C,true);

$array_H = file_get_contents("Hobby.json");
$Hobby = json_decode($array_H,true);

$User_Flight_Time = user_state['Fight_Time'];
$User_Flight = user_state['Filght'];

//Filter all the people who neither take the same flight with users nor have the same flight time.
foreach ($Detail as $person) {
	if($person['Flight_Time'] == $User_Flight_Time || $person['Filght'] == $User_Flight)
		unset($Detail[$person]);
}

//Filter all the people who do not meet the critical selection.
foreach ($Critical as $Cinfo) {
	foreach ($Detail as $person) {
		if($person[(array_keys($Cinfo))[0]]) != (array_values($Cinfo))[0]){
			unset($Detail[$person]);
		}
	}
}

//According to the selection of hobbies from the users, we give weight to each hobby
$Weight_Hobby  = array();

for ($i=0; $i < sizeof($Hobby); $i++) { 
	array_push($Weight_Hobby,($Hobby[i] => 10*($i+1)));
}


//According to the selection of hobbies of all the users give them a mark of "Matching Hobby" to every users.
$ID_weight_Pair = array();

foreach($Weight_Hobby as $hobby =>$weight){
	foreach ($Detail as $person) {
		if(in_array($hobby, $person['Hobby'])){
			$temp = $ID_weight_Pair[$person['id']];
			if(is_null($temp)){
				$ID_weight_Pair[$person['id']] = $weight;
			}
			else{
				$increased = $temp + $weight;
			    $ID_weight_Pair[$person['id']] = $increased;
			}
		}
	}
}

ksort($ID_weight_Pair);

echo '<table>';
echo '<tr>';
  echo '<th> Name </th><th> Flight_Time </th><th> Filght </th><th> Hobby </th>';
echo'</tr>';

foreach ($ID_weight_Pair as $ID => $weight) {
	foreach ($Detail as $person) {
		if($person['id'] == $ID){
			 echo'<tr>';
             echo '<td>' . $info["Name"] . '</td>';
             echo '<td>' . $group["Flight_Time"] . '</td>';
             echo '<td>' . $group["Filght"] . '</td>';
             echo '<td>' . print_r($info['Hobby']) . '</td>';
             echo'</tr>';
	    }
    }
}

}


?>



<!DOCTYPE html>
<html>
<head>
	<title> Test </title>
</head>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
<body>
<?php
echo main(); 
?>
</body>
</html>