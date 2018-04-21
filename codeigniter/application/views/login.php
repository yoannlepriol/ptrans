<?php 

echo form_open('login/connexion');

$data = array('name' => 'id', 'placeholder' => 'Identifiant');
echo form_input($data);

$data = array('name' => 'password', 'placeholder' => 'Mot de passe');
echo form_password($data);

echo form_submit('submit', 'Confirmer');

echo form_close();

?>

<p>Compte administrateur : 1 / password1</p>
<p>Compte utilisateur : 2 / password2</p>