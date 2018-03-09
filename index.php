<?php

	// ON SUPPRIME LA QUESTION DANS LA BDD QUESTIONS

	if(isset($_POST['deleteQuestion'])){
		
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
		}
			
		catch (Exception $e){			
			die('Erreur : ' . $e->getMessage());
		}
			
		
		$req = $bdd->prepare('DELETE FROM questions WHERE ID= :id'); 
		
		$req->execute(array(
			'id' => $_POST['supprimer']
		));
		
		$req -> closeCursor();
		
		
		// ON SUPPRIME LA QUESTION DANS LA BDD REPONSES		
	
		$req = $bdd->query('SELECT column_name FROM information_schema.columns WHERE table_name="reponses" AND column_name LIKE "'.$_POST["supprimer"].'_%"');
		
		while ($donnees = $req->fetch()){
						
			$req2 = $bdd->query('ALTER TABLE reponses DROP COLUMN '.$donnees["column_name"]);
			$req2 -> closeCursor();
		}
		
		$req -> closeCursor();
		
	}
	
	
	if(isset($_POST['form0'])){

		if(isset($_POST["mytext"]) && is_array($_POST["mytext"])){
			
			for ($i = 0; $i <= 9; $i++) {
				
				if (!isset($_POST["mytext"][$i])){
					$_POST["mytext"][$i]="";
				}
			}
		}
		
		
		$array_bool = array ('sens_min', 'sens_max');
		
		foreach($array_bool as $element){
			
			if (!isset($_POST[$element])){
				$_POST[$element]="";
			}
		}
			
		// ON AJOUTE LA QUESTION DANS LA BDD QUESTIONS
		
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
		}
			
		catch (Exception $e){			
			die('Erreur : ' . $e->getMessage());
		}
		
		$req0 = $bdd->query('SELECT MAX(ID) FROM questions');
		$max_id = $req0->fetch();
		$new_id = $max_id[0]+1;
			
		
		$req = $bdd->prepare('INSERT INTO questions(ID, intitule, type, choix1, choix2, choix3, choix4, choix5, choix6, choix7, choix8, choix9, choix10, sens_min, sens_max) 
		VALUES(:ID, :intitule, :type, :choix1, :choix2, :choix3, :choix4, :choix5, :choix6, :choix7, :choix8, :choix9, :choix10, :sens_min, :sens_max)');
		
		$req->execute(array(
			'ID' => $new_id,
			'intitule' => $_POST['intitule'],
			'type' => $_POST['type_question'],
			'choix1' => $_POST["mytext"][0],
			'choix2' => $_POST["mytext"][1],
			'choix3' => $_POST["mytext"][2],
			'choix4' => $_POST["mytext"][3],
			'choix5' => $_POST["mytext"][4],
			'choix6' => $_POST["mytext"][5],
			'choix7' => $_POST["mytext"][6],
			'choix8' => $_POST["mytext"][7],
			'choix9' => $_POST["mytext"][8],
			'choix10' => $_POST["mytext"][9],
			'sens_min' => $_POST["sens_min"],
			'sens_max' => $_POST["sens_max"]
		));
		
		$req -> closeCursor();
		
		
		// ON AJOUTE LA QUESTION DANS LA BDD REPONSES
		
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
		}
			
		catch (Exception $e){			
			die('Erreur : ' . $e->getMessage());
		}
		
		
		if($_POST['type_question']=="choix_multiple"){
					
					
			if(isset($_POST["mytext"]) && is_array($_POST["mytext"])){
			
				for ($i = 0; $i <= 9; $i++) {
					
					if (isset($_POST["mytext"][$i])){
						
						$_POST["mytext"][$i] = str_replace(' ', '_', $_POST["mytext"][$i]);
						
						$req2 = $bdd->prepare('ALTER TABLE reponses ADD '.$new_id.'_'.$_POST["mytext"][$i].' VARCHAR(255) NOT NULL');		
						$req2->execute();
						
						$req2 -> closeCursor();
												
					}
				}
			}				  			
		}
		
		if($_POST['type_question']=="choix_simple"){
					
					
			if(isset($_POST["mytext"]) && is_array($_POST["mytext"])){
			
				for ($i = 0; $i <= 9; $i++) {
					
					if (isset($_POST["mytext"][$i])){
						
						$_POST["mytext"][$i] = str_replace(' ', '_', $_POST["mytext"][$i]);
						
						$req2 = $bdd->prepare('ALTER TABLE reponses ADD '.$new_id.'_'.$_POST["mytext"][$i].' VARCHAR(255) NOT NULL');		
						$req2->execute();
						
						$req2 -> closeCursor();
												
					}
				}
			}				  			
		}
		
		if($_POST['type_question']=="echelle"){
						
			$req2 = $bdd->prepare('ALTER TABLE reponses ADD '.$new_id.'_ INTEGER');		
			$req2->execute();
						
			$req2 -> closeCursor();
															  			
		}
		
		if($_POST['type_question']=="champ_numerique"){
						
			$req2 = $bdd->prepare('ALTER TABLE reponses ADD '.$new_id.'_ INTEGER');		
			$req2->execute();
						
			$req2 -> closeCursor();
															  			
		}
		
		if($_POST['type_question']=="champ_texte"){
						
			$req2 = $bdd->prepare('ALTER TABLE reponses ADD '.$new_id.'_ VARCHAR(255)');		
			$req2->execute();
						
			$req2 -> closeCursor();
															  			
		}
	}

?>



<!DOCTYPE html>
<html lang="fr">
    <head>
        
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="css/test.css">
		<link rel="stylesheet" href="css/form.css">
		
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="my_jquery.js"></script>
		
		<title>BARNSDEAL</title>
		
    </head>
	
    <body>
	
		<h2>AJOUT D'UNE QUESTION</h2>
		
		<form action="index.php" method="post">
		
			<div>
				<label class="label">Quel est l'intitulé de votre question ?</label></br>	
				<input class="field" type="text" name="intitule" placeholder="">
			</div>
			
			</br>
			
			<div>					
				<label class="label">Quel est le type de question ?</label></br>
			
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
				<label class="label">Signification du minimum</label></br>	
				<input class="field" type="text" name="sens_min"></br></br>
				<label class="label">Signification du maximum</label></br>	
				<input class="field" type="text" name="sens_max">
			</div>
						
			</br></br>
			
			<div class="submit0">	
				<input type="submit" name="form0" value="Valider" />
			</div>
			
		</form>
		
		</br></br><hr>
		
		<h2>SUPPRESSION D'UNE QUESTION</h2>
		
		<form action="index.php" method="post">
		
			<div>
				<label class="label">ID de la question à supprimer</label></br>	
				<input class="field" type="text" name="supprimer" placeholder="">
			</div>
												
			</br></br>
			
			<div class="submit0">	
				<input type="submit" name="deleteQuestion" value="Valider" />
			</div>
			
		</form>
	
		</br></br><hr>
		
		<h2>LISTE DES QUESTIONS</h2>
		
		<?php
		
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
		}

		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		
		$reponse = $bdd->query('SELECT * FROM questions');

		echo '<div class="show_questions">';
		
		while ($donnees = $reponse->fetch()){
							
			echo '<div>'.$donnees['ID'].' - <label class="label">'.$donnees['intitule'].'</div>';
										
		}
		
		echo '</div>';

		$reponse->closeCursor();
		
		?>
		
		</br></br><hr>
		
		<h2>AFFICHAGE DES QUESTIONS</h2>
		
		<?php
		
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
		}

		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		
		$reponse = $bdd->query('SELECT * FROM questions');
		
		while ($donnees = $reponse->fetch()){
			
			
			// AFFICHAGE DES CHAMPS TEXTES
			
			if($donnees['type'] == "champ_texte"){
				
				echo '<div><label class="label">'.$donnees['intitule'].'</label></br>
					  <input class="field" type="text" name='.$donnees['ID'].'_></div>';
			}
			
			
			// AFFICHAGE DES CHAMPS NUMERIQUES
			
			else if($donnees['type'] == "champ_numerique"){
				
				echo '<div><label class="label">'.$donnees['intitule'].'</label></br>
					  <input class="field" type="text" name='.$donnees['ID'].'_></div>';
			}
			
			
			// AFFICHAGE DES CHOIX MULTIPLES
			
			else if($donnees['type'] == "choix_multiple"){
				
				$array_choix = ['choix1','choix2','choix3','choix4','choix5','choix6','choix7','choix8','choix9','choix10'];
				
				echo '<div><label class="label">'.$donnees['intitule'].'</label></br>';
					  
				foreach($array_choix as $element){
		
					if (!($donnees[$element] == "")){
						
						echo '<input type="checkbox" name="'.$donnees['ID'].'_'.$donnees[$element].'" value=1>
							  <label>'.$donnees[$element].'</label>';	
						  
					}
				}
				
				echo '</div>';
			}
			
			
			// AFFICHAGE DES CHOIX SIMPLES
			
			else if($donnees['type'] == "choix_simple"){
				
				$array_choix = ['choix1','choix2','choix3','choix4','choix5','choix6','choix7','choix8','choix9','choix10'];
				
				echo '<div><label class="label">'.$donnees['intitule'].'</label></br>';
					  
				foreach($array_choix as $element){
				
					if (!($donnees[$element] == "")){
						
						echo '<input type="radio" name="'.$donnees['ID'].'_" value='.$donnees[$element].'>
							  <label>'.$donnees[$element].'</label>';	
						  
					}
				}
				
				echo '</div>';
			}
			
			
			// AFFICHAGE DES ECHELLES
			
			else if($donnees['type'] == "echelle"){
				
				echo '<div><label class="label">'.$donnees['intitule'].'</label></br>';
					  
				echo '<input type="radio" name="'.$donnees['ID'].'_" value=1>
					  <label>'.$donnees['sens_min'].'</label>
					  
					  <input type="radio" name="'.$donnees['ID'].'_" value=2>
					  <label>2</label>
					  
					  <input type="radio" name="'.$donnees['ID'].'_" value=3>
					  <label>3</label>
					  
					  <input type="radio" name="'.$donnees['ID'].'_" value=4>
					  <label>4</label>
					  
					  <input type="radio" name="'.$donnees['ID'].'_" value=5>
					  <label>'.$donnees['sens_max'].'</label>';	
						  
				
				echo '</div>';
			}
							
		}

		$reponse->closeCursor();
		
		?>
		
	
    </body>
</html>