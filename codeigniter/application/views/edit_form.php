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
	<style> body { padding-top: 70px; } </style>
</head>

<body>

<?php $nav_bar ?>

<h3>Ajout d'une question</h3>

<form action="<?php echo base_url()."Form/ajouter_question";?>" method="post">
		
			<div>
				<label>Quel est l'intitulé de votre question ?</label></br>	
				<input type="text" name="intitule" placeholder="">
			</div>
			
			</br>
			
			<div>					
				<label>Quel est le type de question ?</label></br>
			
				<input type="radio" name="type_question" value="choix_multiple" onclick="showField(choix_multiple);">
				<label>Choix multiple</label>
				
				<input type="radio" name="type_question" value="choix_simple" onclick="showField(choix_simple);">
				<label>Choix simple</label>
				
				<input type="radio" name="type_question" value="champ_texte" onclick="showField(champ_texte);">
				<label>Champ texte</label>
				
				<input type="radio" name="type_question" value="champ_numerique" onclick="showField(champ_numerique);">
				<label>Champ numerique</label>
				
				<input type="radio" name="type_question" value="echelle" onclick="showField(echelle);">
				<label>Echelle</label>				
			</div>

			</br>
			
			<div id="choix_multiple">
				<div class="input_fields_wrap">
					<button class="add_field_button">Ajouter des champs</button>
					<div><input type="text" name="mytext[]"></div>
				</div>
			</div>
			
			<div id="echelle">
				<label>Signification du minimum</label></br>	
				<input type="text" name="sens_min"></br></br>
				<label>Signification du maximum</label></br>	
				<input type="text" name="sens_max">
			</div>
						
			</br></br>
						
			<input type="hidden" name="form_id" value="<?php echo $form_id ?>">
			
			<input type="submit" value="Valider"/>

			
		</form>

<hr>
<h3>Liste des questions</h3>

<?php 
	
	foreach ($form as $question)
	{
		echo $question['position']." - ".$question['intitule']; ?></br><?php
		
		// Bouton pour supprimer la question
		echo form_open('Form/supprimer_question');
			$data = array(
			'id_delete' => $question['id'],
			'form_id' => $form_id
			);
		echo form_hidden($data);
		echo form_submit('submit', 'Supprimer');
		echo form_close();
		
		// Champ texte pour déplacer la question
		echo form_open('Form/deplacer_question');
		$data = array('name' => 'new_position', 'placeholder' => 'Position');
		echo form_input($data);	
		$data = array('id_move' => $question['id'], 'form_id' => $form_id, 'old_position' => $question['position']);
		echo form_hidden($data);
		echo form_submit('submit', 'Déplacer');
		echo form_close();
		
	}

?>
	

    </body>
</html>

