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



if((isset($answers)) && (isset($answers[0]))){ $answers = $answers[0]; }

echo form_open('Form/load_data');

$options = array();

foreach($users as $user)
{
	$tmp = $user['id'];	
	array_push($options, $tmp);
}

//$data = array_flip($data);

echo form_dropdown('select', $options, NULL);


$data = array('form_name' => $form_name, 'options' => $options);

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

}
?>



</body>
</html>

