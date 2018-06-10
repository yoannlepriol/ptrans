<h3>Ajout d'un questionnaire</h3>

<?php

	echo '<div class="container" style="padding-top: 15px">';

	echo form_open('Form/ajouter');
	
	$data = array('name' => 'new_form', 'placeholder' => 'Nom du questionnaire');
	echo '<div id="form_name">'.form_input($data).'</div>';
	
	$data = array('name' => 'details', 'rows' => 10, 'cols' => 50, 'placeholder' => 'Expliquez l\'intérêt de ce questionnaire pour le répondant');
	echo '<div id="form_desc">'.form_textarea($data).'</div>';
	
	echo '<div id="form_sub">'.form_submit('submit', 'Confirmer').'</div>';
	echo form_close();
	echo '</div>';
?>