<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/css/admin_home.css')?>" rel="stylesheet">
	<style> body { padding-top: 62px; background-color: rgb(246, 246, 246); } </style>
</head>

<body>
	<?php $this->load->view('nav_bar'); ?>
	<div class="main_container">	
	<div class="container" style="padding-top: 15px;margin: 0 30px;">

<?php

//var_dump($users);

$id_intitule = array();
foreach($questions as $question)
{
	$id = $question['id'];
	$intitule = $question['intitule'];
	$id_intitule[$id] = $intitule;
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
		$new_answers[$x]['type'] = $questions[$x-1]['type']; 
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
		$options[$tmp] = $question['intitule'];
	}
	
	if(isset($dropdown_values[$i]))
	{ 
		$id = $dropdown_values[$i];
		$set_option = $id;
	}
	else { $set_option = null; }
		
	echo form_dropdown('dropdown_'.$i, $options, $set_option);
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
			if(isset($new_answers[$i][$user])){ 
					
				echo $new_answers[$i][$user];
		
			}
			else { echo ''; }
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


?>
</div>
</div>
<script src="<?php echo site_url('assets/javascript/jquery.min.js')?>"></script>
<script src="<?php echo site_url('assets/javascript/bootstrap.bundle.js')?>"></script>
</body>
</html>

