<h3>Suppression d'un utilisateur</h3>

<?php

	echo '<div class="container" style="padding-top: 15px">';

	echo form_open('Form/supprimer_utilisateur');
	
	$options = array();
	
	array_push($options, 'Sélectionner');
	
	foreach($startups as $startup)
	{	
		$tmp = $startup['id'];
		$options[$tmp] = $startup['nom'];
	}
	
	echo form_dropdown('start_up', $options);

	
	echo '<div id="form_sub">'.form_submit('submit', 'Confirmer').'</div>';
	echo form_close();
	echo '</div>';
?>