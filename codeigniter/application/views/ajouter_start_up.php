<h3>Ajout d'une start-up</h3>

<?php

	echo '<div class="container" style="padding-top: 15px">';

	echo form_open('Form/ajouter_start_up');
	
	$data = array('name' => 'new_start_up', 'placeholder' => 'Quel est le nom de la start-up ?');
	echo '<div id="start_up_name">'.form_input($data).'</div>';
		
	echo '<div id="form_sub">'.form_submit('submit', 'Ajouter').'</div>';
	echo form_close();
	echo '</div>';
?>