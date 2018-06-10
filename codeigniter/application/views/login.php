<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css'); ?>" rel="oldest stylesheet">
	<link href="<?php echo site_url('assets/css/login.css'); ?>" rel="oldest stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript"></script>
</head>
<body>
<h1>Barnsdeal</h1>
<div class="login_content">
<div class="login_form">
<?php 

echo form_open('Login/connexion');

$data = array('name' => 'id', 'placeholder' => 'Identifiant');

echo '<div class="login_input"><i style="font-size:20px" class="fa">&#xf0c0;</i>'.form_input($data).'</div>';

$data = array('name' => 'password', 'placeholder' => 'Mot de passe');
echo '<div class="login_input"><i style="font-size:25px" class="fa">&#xf023;</i>'.form_password($data).'</div>';

echo '<div id="submit">'.form_submit('submit', 'Confirmer').'</div>';

echo form_close();

?>

</div>
<div class="login_desc">
<p>Compte administrateur : 1 / password1</p>
<p>Compte utilisateur : 2 / password2</p>
</div>
</div>

</body>
</html>
