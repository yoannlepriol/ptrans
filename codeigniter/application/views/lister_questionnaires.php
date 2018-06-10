<h3>Liste des questionnaires</h3>
<div class="container" style="padding-top: 10px">
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
	
	echo '<div class="col-md-2" style="padding-bottom: 15px; padding-top: 15px; min-width:200px;">';
	echo '<div class="card my_form" style="background-color: #6c6f66;">';
	
	echo '<div class="form_name">';
	echo $form_name;
	echo '</div>';
	
	// Bouton pour afficher les réponses
	echo form_open('Form/reponses/'.$form_id);
	echo form_submit('reponses', 'Réponses');
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

?>