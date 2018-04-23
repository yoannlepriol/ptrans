<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css')?>" rel="stylesheet">
	<style> body { padding-top: 70px; } </style>
</head>

<body>

<?php $nav_bar ?>





<?php



$id_intitule = array();
foreach($questions as $question)
{
	$id = $question['id'];
	$intitule = $question['intitule'];
	$id_intitule[$id] = $intitule;
}

function set_option($questions, $i, $id_intitule, $dropdown_values)
{
	
}

$new_answers = array();

if(!(isset($answers))){ $answers = null ; }

if(!(isset($dropdown_values))){ $dropdown_values = null ; }

else 
{ 
	unset($answers['form_id']);
	$fields = array_keys($answers);	
	$flipped_dropdown = array_flip($dropdown_values);

	foreach($fields as $field)
	{
		$x = $flipped_dropdown[$field];
		$new_answers[$x] = $answers[$field];
	}
}



echo '<div class="table-responsive">';
echo '<table class="table">';

echo '<tr>';

echo '<th></th>';

echo form_open('Form/load_data');

// Création des colonnes
for ($i = 1; $i < 4; $i++)
{
	echo '<th>';
	
	$options = array();
	
	array_push($options, 'Sélectionner');
	
	foreach($questions as $question)
	{	
		$tmp = $question['id'];
		//array_push($options, $tmp);
		$options[$tmp] = $question['intitule'];
	}
	
	if(isset($dropdown_values[$i]))
	{ 
		//echo 'Bonjour';
		$id = $dropdown_values[$i];
		//$intitule = $id_intitule[$id];
		//$set_option = $intitule; 
		$set_option = $id;
	}
	else { $set_option = null; }
	
	//echo $set_option;
	
	//$option_selected = set_option($questions, $i, $id_intitule, $dropdown_values);
	echo form_dropdown('dropdown_'.$i, $options, $set_option);
	//echo form_dropdown('dropdown_'.$i, $options);
	echo '</th>';
}

echo '</tr>';


// Création des lignes
foreach($users as $user)
{
	$user = $user['id'];
	
	echo '<tr>';
	
	echo '<td>';
	echo $user;
	echo '</td>';
	
	for ($i = 1; $i < 4; $i++)
	{
		echo '<td>';
			if(isset($new_answers[$i][$user])){ echo $new_answers[$i][$user]; }
			else { echo 'null'; }
		echo '</td>';
	}
	
	echo '</tr>';
	
}

echo '</table>';
echo '</div>';


$questions_id = array();
array_push($questions_id, null);
foreach($questions as $question)
{
	array_push($questions_id, $question['id']);
}


$data = array('form_id' => $form_id, 'questions_id' => $questions_id, 'users' => $users);
echo form_hidden($data);

echo form_submit('submit', 'Confirmer');

echo form_close();








/*if((isset($answers)) && (isset($answers[0]))){ $answers = $answers[0]; }

echo form_open('Form/load_data');

$options = array();

foreach($users as $user)
{
	$tmp = $user['id'];	
	array_push($options, $tmp);
}

//$data = array_flip($data);

echo form_dropdown('select', $options, NULL);


$data = array('form_id' => $form_id, 'options' => $options);

echo form_hidden($data);

echo form_submit('submit', 'Confirmer');

echo form_close();

?>

<?php

if(isset($answers)){

	$questions = array_keys($answers);
			
	echo '<table align="center" style="width:95%">';	
		
	echo '<tr>';	
	for ($i = 0; $i < count($questions); $i++)
	{
		echo '<th>'.$questions[$i].'</th>';
	}	
	echo '</tr>';
		
	echo '<tr>';
	for ($i = 0; $i < count($questions); $i++)
	{
		$question = $questions[$i];
		echo '<td>'.$answers[$question].'</td>';
	}
	echo '</tr>';
			
	echo '</table>';

}*/
?>



</body>
</html>

