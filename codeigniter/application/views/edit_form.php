<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css')?>" rel="stylesheet">		
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="<?php echo site_url('assets/javascript/my_jquery.js')?>"></script>
	<link href="<?php echo site_url('assets/css/admin_home.css'); ?>" rel="stylesheet">
	<style> body { padding-top: 62px; background-color: rgb(246, 246, 246); } </style>
</head>

<body>
<div class="main_container">
<?php $this->load->view('nav_bar'); ?>

<h3>Modifier champ descriptif</h3>
<div class="container" style="padding: 15px 0 ;">
<?php

echo form_open('Form/modifier_details');

$data = array('name' => 'details', 'rows' => 10, 'cols' => 50, 'placeholder' => 'Expliquez l\'intérêt de ce questionnaire pour le répondant');
echo form_textarea($data);

$data = array('form_id' => $form_id);
echo form_hidden($data);

echo '<div>'.form_submit('submit', 'Modifier').'</div>';
echo form_close();
		
?>
</div>

<h3>Ajout d'une question</h3>
<div class="container" style="padding-top: 15px">
<form action="<?php echo base_url()."Form/ajouter_question";?>" method="post">
		
			<div>
				<label>Quel est l'intitulé de votre question ?</label></br>	
				<input type="text" name="intitule" placeholder="">
			</div>
			
			</br>
			
			<div>					
				<label>Quel est le type de question ?</label></br>
			
				<input type="radio" name="type_question" value="choix_multiple" id="type_choix_multiple" onclick="showField(choix_multiple);">
				<label for="type_choix_multiple">Choix multiple</label>
				
				<input type="radio" name="type_question" value="choix_simple" id="type_choix_simple" onclick="showField(choix_simple);">
				<label for="type_choix_simple">Choix simple</label>
				
				<input type="radio" name="type_question" value="champ_texte" id="type_champ_texte" onclick="showField(champ_texte);">
				<label for="type_champ_texte">Champ texte</label>
				
				<input type="radio" name="type_question" value="champ_numerique" id="type_champ_numerique" onclick="showField(champ_numerique);">
				<label for="type_champ_numerique">Champ numerique</label>
				
				<input type="radio" name="type_question" value="echelle" id="type_echelle" onclick="showField(echelle);">
				<label for="type_echelle">Echelle</label>				
			</div>

			</br>
			
			<div id="choix_multiple" style="display: none">
				<div class="input_fields_wrap">
					<button class="add_field_button">Ajouter des champs</button>
					<div><input type="text" name="mytext[]"></div>
				</div>
			</div>
			
			<div id="echelle" style="display: none">
				<label>Signification du minimum</label></br>	
				<input type="text" name="sens_min"></br></br>
				<label>Signification du maximum</label></br>	
				<input type="text" name="sens_max">
			</div>
						
			</br></br>
						
			<input type="hidden" name="form_id" value="<?php echo $form_id ?>">
			
			<input type="submit" value="Valider"/>

			
		</form>
</div>
<hr>
<h3>Liste des questions</h3>
<div class="container" style="padding-top: 15px">
<?php 
	
	foreach ($form as $question)
	{
		echo '<div class="question_name"><span>'.$question['position']." - ".$question['intitule'].'</span>'; ?></br><?php
		
		// Bouton pour supprimer la question
		echo form_open('Form/supprimer_question');
			$data = array(
			'id_delete' => $question['id'],
			'form_id' => $form_id
			);
		echo form_hidden($data);
		echo form_submit('submit', 'Supprimer','class="edit_supp"');
		echo form_close();
		
		// Champ texte pour déplacer la question
		echo form_open('Form/deplacer_question');
		$data = array('name' => 'new_position', 'placeholder' => 'Position');
		echo form_input($data);	
		$data = array('id_move' => $question['id'], 'form_id' => $form_id, 'old_position' => $question['position']);
		echo form_hidden($data);
		echo form_submit('submit', 'Déplacer').'</div>';
		echo form_close();
		
	}

?>
</div>	
</div>
<script src="<?php echo site_url('assets/javascript/jquery.min.js')?>"></script>
<script src="<?php echo site_url('assets/javascript/bootstrap.bundle.js')?>"></script>
</body>
</html>

