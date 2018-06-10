<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css')?>" rel="stylesheet">
	<script src="<?php echo site_url('assets/javascript/bootstrap.bundle.js')?>"></script>
	<style> body { padding-top: 62px; background-color: rgb(246, 246, 246); } 
			.main_container{ width: 900px; margin: auto; padding: 20px 0; background-color: white; min-height: 786px;}
	</style>
</head>

<body>
<?php $this->load->view('nav_bar'); ?>	
<div class="main_container">
<h3 style="text-align: center; color:#343a40; font-size:2rem;">Vos questionnaires</h3>

<?php 

	echo '<div class="container" style="padding-top: 30px;">';
	echo '<div class="row">';

	$position = 0;
	
	$forms_id = array_keys($forms);
	
for ($i = 0; $i < count($forms_id); $i++)
{	
	$form_id = $forms_id[$i];
	$form_name = $forms[$form_id];
	$position = $position + 1;
	if($position == 5){ $position = 0; }
	
	echo '<div class="col-md-3" style="padding-bottom: 15px; padding-top: 15px;">';
	
	if(in_array($form_id, $filled_forms)){ echo '<div class="card my_form" style="background-color:  #ba8f77; padding:10px 0;">'; }
	else { echo '<div class="card my_form" style="background-color: #6c6f66; padding:10px 0;">'; }
		
	echo '<div class="form_name">';
	echo $form_name; 
	echo '</div>';
	
	// Bouton pour répondre au questionnaire
	echo form_open('Form/repondre/'.$form_id);
	$data = array('form' => $form_id);
	echo form_hidden($data);
	
	$data = array('class' => 'button button-1 button-1a');
	echo form_submit('submit', 'Répondre', $data);
	echo form_close();
	
	echo '</div>';
	
	echo '</div>';
}

if($position==0){ echo '</div><div class="row">'; }

echo '</div>';
echo '</div>';
echo '</div>';

?>
</div>
<script src="<?php echo site_url('assets/javascript/jquery.min.js')?>"></script>
<script src="<?php echo site_url('assets/javascript/bootstrap.bundle.js')?>"></script>
</body>
</html>
	



