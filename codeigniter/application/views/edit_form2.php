<!DOCTYPE html>
<html lang="fr">
<head>  
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<link rel="stylesheet" href="<?php echo site_url('assets/css/form.css')?>">
				
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="<?php echo site_url('assets/javascript/my_jquery.js')?>"></script>
			
</head>
	
<body>

	<h2>AJOUT D'UNE QUESTION</h2>

	<?php 

	echo form_open('login/connexion');


	$data = array('name' => 'intitule', 'placeholder' => 'Intitulé de votre question');
	echo form_input($data);


	$js = array('onClick' => 'showField(choix_multiple);');
	$data = array('name' => 'type_question', 'id' => 'choix_multiple');
	echo form_radio('type_question', 'choix_multiple', FALSE, $js); // Name, Value, Checked, Function
	echo form_label('Choix multiple', 'choix_multiple');


	$js = array('onClick' => 'showField(choix_simple);');
	$data = array('name' => 'type_question', 'id' => 'choix_simple');
	echo form_radio('type_question', 'choix_simple', FALSE, $js);
	echo form_label('Choix simple', 'choix_simple');


	$js = array('onClick' => 'showField(champ_texte);');
	$data = array('name' => 'type_question', 'id' => 'champ_texte');
	echo form_radio('type_question', 'champ_texte', FALSE, $js);
	echo form_label('Champ texte', 'champ_texte');


	$js = array('onClick' => 'showField(champ_numerique);');
	$data = array('name' => 'type_question', 'id' => 'champ_numerique');
	echo form_radio('type_question', 'champ_numerique', FALSE, $js);
	echo form_label('Champ numérique', 'champ_numerique'); 


	$js = array('onClick' => 'showField(echelle);');
	$data = array('name' => 'type_question', 'id' => 'echelle');
	echo form_radio('type_question', 'echelle', FALSE, $js);
	echo form_label('Echelle', 'echelle');


	?>
				
	<div id="choix_multiple">
		<div class="input_fields_wrap">
		
			<?php	
					
			$data = array('class' => 'add_field_button');
			echo form_button($data, 'Ajouter des champs');
		
			?>
			
			<div><?php form_input('mytext[]') ?></div>		
			
		</div>
	</div>
			
			
	<div id="echelle">

		<?php

		$data = array('name' => 'sens_min', 'id' => 'sens_min', 'placeholder' => '');
		echo form_input($data);
		echo form_label('Signification du minimum', 'sens_min');
		
		
		$data = array('name' => 'sens_min', 'id' => 'sens_max', 'placeholder' => '');
		echo form_input($data);
		echo form_label('Signification du maximum', 'sens_max');

		?>
		
	</div>
			
	<?php
			
	echo form_submit('submit', 'Confirmer');

	echo form_close();

	?>

	<h2>LISTE DES QUESTIONS</h2>

	<?php 


	?>
	

</body>
</html>

