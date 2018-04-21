<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<style> body { padding-top: 70px; } </style>
</head>

<body>

<?php $nav_bar ?>

	<h3>Ajout d'un questionnaire</h3>

<?php
echo '<div class="container" style="padding-top: 30px">';

	echo form_open('Form/ajouter');
	
	$data = array('name' => 'new_form', 'placeholder' => 'Nom du questionnaire');
	echo form_input($data);
	
	echo form_submit('submit', 'Confirmer');
	echo form_close();
?>
<hr>
<h3>Liste des questionnaires</h3>

<?php 


echo '<div class="row">';

$position = 0;

$forms_id = array_keys($forms);

for ($i = 0; $i < count($forms_id); $i++)
{
	$form_id = $forms_id[$i];
	$form_name = $forms[$form_id];
	$position = $position + 1;
	if($position == 7){ $position = 0; }
	
	echo '<div class="col-md-2" style="padding-bottom: 15px; padding-top: 15px;">';
	echo '<div class="card my_form" style="background-color: orange !important;">';
	
	echo '<div class="form_name">';
	echo $form_name;
	echo '</div>';
	
	// Bouton pour afficher les réponses
	echo form_open('Form/reponses');
	$data = array('form_id' => $form_id);
	echo form_hidden($data);
	echo form_submit('reponses', 'Réponses', $data);
	echo form_close();
	
	// Bouton pour modifier le questionnaire
	echo form_open('Form/modifier');
	$data = array('modify_form' => $form_id);
	echo form_hidden($data);
	echo form_submit('modifier', 'Modifier');
	echo form_close();
	
	// Bouton pour supprimer le questionnaire
	echo form_open('Form/supprimer');
	$data = array('delete_form' => $form_id);
	echo form_hidden($data);
	echo form_submit('supprimer', 'Supprimer');
	echo form_close();
	
	echo '</div>';
	echo '</div>';
}
if($position==0){ echo '</div><div class="row">'; }

echo '</div>';
echo '</div>';

?>
	
</body>
</html>


