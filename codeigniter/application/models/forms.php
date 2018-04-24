<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms extends CI_Model
{
	// Renvoie la liste de tous les questionnaires
	public function get_forms_list()
	{
		$this->db->list_tables();
		$this->db->like('name', 'field');
		
		$query = $this->db->query("SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = 'codeigniter' AND table_name LIKE 'q_%'");
		return $query->result_array();		 	
	}
	
	public function get_user_forms($all_forms)
	{	
		$user_forms = array();
	
		foreach($all_forms as $form)
		{
			$form = $form['table_name'];		
			$query = $this->db->query("SELECT ".$form." FROM users WHERE id = ".$_SESSION['user_id']);
			$query = $query->result_array();
			$query = $query[0][$form];
			if($query == 1){ array_push($user_forms, $form); }
		}
			
		return $user_forms;
	}
	
	public function get_forms_name($forms)
	{	
		$forms_name = array();
	
		foreach($forms as $form)
		{		
			$form = str_replace("q_", "", $form);	
			$query = $this->db->query("SELECT intitule FROM forms WHERE id = ".$form);
			$query = $query->result_array();
			$query = $query[0]['intitule'];
			$forms_name[$form] = $query;
		}
			
		return $forms_name;
	}
	
	public function get_filled_forms($forms)
	{
		$filled_forms = array();
		
		foreach($forms as $form)
		{
			$form_is_filled = true;
			$form = str_replace("q_", "", $form);
			$query = $this->db->query("SELECT * FROM r_".$form." WHERE id = ".$_SESSION['user_id']);
			$query = $query->result_array();
			if(isset($query[0]))
			{ 
				$query = $query[0]; 			
				
				foreach($query as $answer)
				{
					if($answer == NULL){ $form_is_filled = false; }
				}
				
				if($form_is_filled == true){ array_push($filled_forms, $form); }
			}
		}
	
		return $filled_forms;
	}
	
	public function get_form($form_id)
	{		
		$query = $this->db->query("SELECT * FROM q_".$form_id." ORDER BY position"); 
		$form = $query->result_array();
				
		return $form;
	}
	
	public function get_details($form_id)
	{		
		$query = $this->db->query("SELECT details FROM forms WHERE id = ".$form_id);
		$details = $query->result_array();
		$details = $details[0];
		
		return $details;
	}
	
	
	public function get_answers($form_id)
	{		
		$query = $this->db->query("SELECT * FROM r_".$form_id." ORDER BY id");
		return $query->result_array();		 	
	}
	
	public function get_users($form_id)
	{		
		$query = $this->db->query('SELECT id FROM users WHERE '.$form_id.' = 1 AND privilege = "user" ORDER BY id');
		return $query->result_array();		 	
	}
	
	public function get_user_answer($form_id, $question_selected, $user, $type)
	{	
		if(($type == 'champ_texte') || ($type == 'champ_numerique') || ($type == 'echelle'))
		{
			$query = $this->db->query('SELECT '.$question_selected.'_ FROM r_'.$form_id.' WHERE id = '.$user);
			$answer = $query->result_array();
			
			if(isset($answer[0]))
			{
				$answer = $answer[0][$question_selected.'_'];
				
				if ($type == 'echelle') { return $answer.'/5'; }
				
				else { return $answer; }
			}
		}
		
		else if ($type == 'choix_simple')
		{		
			$req = $this->db->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'r_".$form_id."' AND column_name LIKE '".$question_selected."_%'");
			$req = $req->result_array();
	
			for ($i = 0; $i < count($req); $i++)
			{
				$query = $this->db->query('SELECT '.$question_selected.'_'.$i.' FROM r_'.$form_id.' WHERE id = '.$user);
				$answer = $query->result_array();
				if (isset($answer[0]))
				{
					$value = $answer[0][$question_selected.'_'.$i];
					if ($value == 1)
					{
						$choix = $i+1;
						$query = $this->db->query('SELECT choix'.$choix.' FROM q_'.$form_id.' WHERE id = '.$question_selected);
						$answer_text = $query->result_array();
						return $answer_text[0]['choix'.$choix];
					}
				}
			}
		}
		
		else if ($type == 'choix_multiple')
		{		
			$req = $this->db->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'r_".$form_id."' AND column_name LIKE '".$question_selected."_%'");
			$req = $req->result_array();
			$list_options = '';
			
			for ($i = 0; $i < count($req); $i++)
			{
				$query = $this->db->query('SELECT '.$question_selected.'_'.$i.' FROM r_'.$form_id.' WHERE id = '.$user);
				$answer = $query->result_array();
				if (isset($answer[0]))
				{
					$value = $answer[0][$question_selected.'_'.$i];
					if ($value == 1)
					{
						$choix = $i+1;
						$query = $this->db->query('SELECT choix'.$choix.' FROM q_'.$form_id.' WHERE id = '.$question_selected);
						$answer_text = $query->result_array();
						if ($list_options == ''){ $list_options = $list_options.''.$answer_text[0]['choix'.$choix]; }
						else { $list_options = $list_options.' | '.$answer_text[0]['choix'.$choix]; }
					}
				}
			}
			return $list_options;
		}
	}
	
	public function add_form($form_name, $form_details)
	{
		// On récupère l'id max
		$req = $this->db->query('SELECT MAX(ID) FROM forms');
		$req = $req->result_array();
		$max_id = $req[0]['MAX(ID)'];
		$new_id = $max_id + 1;
				
		// On ajoute dans la table forms
		$this->db->query('INSERT INTO forms(id, intitule, details) VALUES('.$new_id.', "'.$form_name.'", "'.$form_details.'")');
		
		// Création de la table q_ du formulaire
		$sql = "CREATE TABLE q_".$new_id." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				intitule VARCHAR(120), 
				type VARCHAR(30), 
				choix1 VARCHAR(60), 	
				choix2 VARCHAR(60), 
				choix3 VARCHAR(60), 
				choix4 VARCHAR(60), 
				choix5 VARCHAR(60), 
				choix6 VARCHAR(60), 
				choix7 VARCHAR(60), 
				choix8 VARCHAR(60), 
				choix9 VARCHAR(60), 
				choix10 VARCHAR(60), 
				sens_min VARCHAR(120), 
				sens_max VARCHAR(120),
				position INT(6)
				)";
		
		$this->db->query($sql);
		
		
		// Création de la table r_ du formulaire
		$sql = "CREATE TABLE r_".$new_id." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
				)";
		
		$this->db->query($sql);
		
		
		// Ajouter colomne dans la table users
		$this->db->query('ALTER TABLE users ADD q_'.$new_id.' BOOLEAN default 1'); // To-Do : attribuer les questionnaires aux bons utilisateurs
	}
	
	
	public function delete_form($form_id)
	{
		// On supprime dans la table forms
		$this->db->query("DELETE FROM forms WHERE id = ".$form_id);
		
		// Suppression de la table q_ du formulaire
		$this->db->query("DROP TABLE q_".$form_id);
				
		// Suppression de la table r_ du formulaire
		$this->db->query("DROP TABLE r_".$form_id);
		
		// Suppression de la table users
		$this->db->query("ALTER TABLE users DROP COLUMN q_".$form_id);
	}
	
	
	public function modify_details($form_id, $new_details)
	{
		echo $new_details;
		$this->db->query('UPDATE forms SET details = "'.$new_details.'" WHERE id = '.$form_id);
	}
		
}
	