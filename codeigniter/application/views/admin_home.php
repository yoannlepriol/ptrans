<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?php echo site_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<style> body { padding-top: 70px; } </style>
</head>

<body>

<?php $nav_bar ?>

	<h3>Ajout d'un questionnaire</h3>

<?php
	echo form_open('Form/ajouter');
	
	$data = array(
	'name' => 'new_form',
	'placeholder' => 'Nom du questionnaire'
	);
	echo form_input($data);
	
	echo form_submit('submit', 'Confirmer');
	echo form_close();
?>
<hr>
<h3>Liste des questionnaires</h3>

<?php 

foreach ($forms as $form)
{
	echo '<div style="display:inline-block;">';
	
	echo $form['table_name'] = str_replace("q_", "", $form['table_name']); 
	
	// Bouton pour afficher les réponses
	echo form_open('Form/reponses');
	$data = array('form_name' => $form['table_name']);
	echo form_hidden($data);
	echo form_submit('reponses', 'Réponses', $data);
	echo form_close();
	
	// Bouton pour modifier le questionnaire
	echo form_open('Form/modifier');
	$data = array('modify_form' => $form['table_name']);
	echo form_hidden($data);
	echo form_submit('modifier', 'Modifier');
	echo form_close();
	
	// Bouton pour supprimer le questionnaire
	echo form_open('Form/supprimer');
	$data = array('delete_form' => $form['table_name']);
	echo form_hidden($data);
	echo form_submit('supprimer', 'Supprimer');
	echo form_close();
	
	echo '<div/>';
}
	?>
	
</body>
</html>


