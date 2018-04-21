<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css'); ?>" rel="oldest stylesheet">
	<link href="<?php echo site_url('assets/css/full-slider.css'); ?>" rel="oldest stylesheet">
</head>

<body class="form">

	<?php $nav_bar ?>
	
	<?php 
	
	function displayQuestion($question, $form_id){
				
			echo '<div class="question" id="div_'.$question['id'].'">';
						
			// AFFICHAGE DES CHAMPS TEXTES
			if($question['type'] == "champ_texte")
			{								
				$attributes = array('class' => 'label_form');
				echo form_label($question['intitule'], 'div_'.$question['id'], $attributes);		
				$data = array('name' => $question['id'].'_', 'id' => $question['id'], 'class' => 'text_field', 'placeholder' => '');
				echo form_input($data);
				$data = array('type_question_'.$question['id'] => 'champ_texte');
				echo form_hidden($data);				
			}
													
			// AFFICHAGE DES CHAMPS NUMERIQUES			
			else if($question['type'] == "champ_numerique")
			{				
				$attributes = array('class' => 'label_form');
				echo form_label($question['intitule'], 'div_'.$question['id'], $attributes);		
				$data = array('name' => $question['id'].'_', 'id' => $question['id'], 'class' => 'text_field', 'placeholder' => '');
				echo form_input($data);
				$data = array('type_question_'.$question['id'] => 'champ_numerique');
				echo form_hidden($data);
			}
								
			// AFFICHAGE DES CHOIX MULTIPLES			
			else if($question['type'] == "choix_multiple")
			{				
				$attributes = array('class' => 'label_form');
				echo form_label($question['intitule'], 'div_'.$question['id'], $attributes);
				
				$array_choix = ['choix1','choix2','choix3','choix4','choix5','choix6','choix7','choix8','choix9','choix10'];
				
				$i = 0;
				foreach($array_choix as $element)
				{
					if ($question[$element] != "") // To-Do : Afficher les résultats sur plusieurs lignes
					{
						$data_checkbox = array('name' => $question['id'].'_'.$i, 'value' => 1);
						echo form_checkbox($data_checkbox);
						$attributes = array('class' => 'label_checkbox');
						echo form_label($question[$element], $question['id'].'_'.$i, $attributes);
						$i = $i+1;
					}
				}
				
				$data = array('type_question_'.$question['id'] => 'choix_multiple');
				echo form_hidden($data);
			}
										
			// AFFICHAGE DES CHOIX SIMPLES		
			else if($question['type'] == "choix_simple")
			{				
				$attributes = array('class' => 'label_form');
				echo form_label($question['intitule'], 'div_'.$question['id'], $attributes);
				
				$array_choix = ['choix1','choix2','choix3','choix4','choix5','choix6','choix7','choix8','choix9','choix10'];
				
				$i = 0;
				foreach($array_choix as $element)
				{
					if ($question[$element] != "")
					{	
						$data_radio = array('name' => $question['id'].'_', 'value' => $i, 'id' => $question['id'].'_'.$i);
						echo form_radio($data_radio);
						$attributes = array('class' => 'label_checkbox');
						echo form_label($question[$element], $question['id'].'_'.$i, $attributes);
						$i = $i+1;
					}
				}
				
				$data = array('type_question_'.$question['id'] => 'choix_simple');
				echo form_hidden($data);	
			}
			
							
			// AFFICHAGE DES ECHELLES		
			else if($question['type'] == "echelle")
			{								
				$attributes = array('class' => 'label_form');
				echo form_label($question['intitule'], 'div_'.$question['id'], $attributes);
			
				$data_radio = array('name' => $question['id'].'_', 'value' => 1, 'id' => $question['id'].'_1');
				echo form_radio($data_radio);
				$attributes = array('class' => 'label_checkbox');
				echo form_label($question['sens_min'], $question['id'].'_1', $attributes);
			
				$data_radio = array('name' => $question['id'].'_', 'value' => 2, 'id' => $question['id'].'_2');
				echo form_radio($data_radio);
				$attributes = array('class' => 'label_checkbox');
				echo form_label('2', $question['id'].'_2', $attributes);
			
				$data_radio = array('name' => $question['id'].'_', 'value' => 3, 'id' => $question['id'].'_3');
				echo form_radio($data_radio);
				$attributes = array('class' => 'label_checkbox');
				echo form_label('3', $question['id'].'_3', $attributes);
				
				$data_radio = array('name' => $question['id'].'_', 'value' => 4, 'id' => $question['id'].'_4');
				echo form_radio($data_radio);
				$attributes = array('class' => 'label_checkbox');
				echo form_label('4', $question['id'].'_4', $attributes);
				
				$data_radio = array('name' => $question['id'].'_', 'value' => 5, 'id' => $question['id'].'_5');
				echo form_radio($data_radio);
				$attributes = array('class' => 'label_checkbox');
				echo form_label($question['sens_max'], $question['id'].'_5', $attributes);
				
				$data = array('type_question_'.$question['id'] => 'echelle');
				echo form_hidden($data);
			}
					
		echo '</div>';
	}

	?>
	
	<?php $nb_slides = count($form)+1;  ?>
	
	<header>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
		  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" id="indicator_0"></li>		  
		 
		 <?php 

		  foreach ($form as $question)
		  { 
			echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$question['position'].'" id="indicator_'.$question['position'].'"></li>'; 
		  } 
		  
		  ?> 
		<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $nb_slides; ?>" id="indicator_<?php echo $nb_slides; ?>">
        </ol>
		
        <div class="carousel-inner" role="listbox">
		
		<?php echo '<form action="'.base_url().'form/repondre_question" method="post">'; ?>
			         
          <div class="carousel-item active" style="background-color: #343a40" id="carousel_0">
            <div class="text_form">
              <h3><?php echo $form_id; ?></h3>
              <p><?php echo $details['details']; ?></p>
            </div>
          </div>
		  
		 
		  
<?php 	 foreach ($form as $question){ 
			echo '<div class="carousel-item" style="background-color: #343a40" id="carousel_'.$question['position'].'"><div>';
			displayQuestion($question, $form_id);													
			echo '</div></div>'; 
		  } ?>
		  		  
		 <div class="carousel-item" style="background-color: #343a40" id="carousel_<?php echo $nb_slides; ?>">
            <div class="carousel-caption d-none d-md-block"> <h3>Last slide</h3> <p>Thank you for answering this form.</p> 
			<?php echo '<input type="hidden" name="form_id" value="'.$form_id.'">
			<input type="submit" value="Confirmer"/></form>'; ?> 
			
			</div>
          </div>
		  
        </div>
       <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </header>

		
<script src="<?php echo site_url('assets/javascript/jquery.min.js')?>"></script>
<script src="<?php echo site_url('assets/javascript/bootstrap.bundle.js')?>"></script>

</body>
</html>

