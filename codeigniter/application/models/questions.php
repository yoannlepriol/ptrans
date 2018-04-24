<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions extends CI_Model
{
	
	public function add_question($data_question)
	{
		$table = $data_question['form_id'];
		
		// Permet de supprimer les champs réponses non utilisés
		if(isset($data_question["mytext"]) && is_array($data_question["mytext"])){
			
			for ($i = 0; $i <= 9; $i++) {
				
				if (!isset($data_question["mytext"][$i])){
					$data_question["mytext"][$i]="";
				}
			}
		}
		
		$array_bool = array('sens_min', 'sens_max');
		
		foreach($array_bool as $element){
			
			if (!isset($data_question[$element])){
				$data_question[$element]="";
			}
		}
		
		// On récupère l'ID max et on l'incrémente
		$req = $this->db->query('SELECT MAX(ID) FROM q_'.$table);
		$req = $req->result_array();
		$max_id = $req[0]['MAX(ID)'];
				
		if(is_null($max_id)){ $new_id = 1; }		
		else { $new_id = $max_id+1; }
		
		// On récupère la position max et on l'incrémente
		$req = $this->db->query('SELECT MAX(position) FROM q_'.$table);
		$req = $req->result_array();
		$max_pos = $req[0]['MAX(position)'];
				
		if(is_null($max_pos)){ $new_pos = 1; }		
		else { $new_pos = $max_pos+1; }
		
		// On ajoute la question dans la BDD q_				
		$sql = "INSERT INTO q_".$table."(ID, intitule, type, choix1, choix2, choix3, choix4, choix5, choix6, choix7, choix8, choix9, choix10, sens_min, sens_max, position )
		VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		$this->db->query($sql, array(
		$new_id, 
		$data_question['intitule'], 
		$data_question['type_question'], 
		$data_question["mytext"][0],
		$data_question["mytext"][1],
		$data_question["mytext"][2],
		$data_question["mytext"][3],
		$data_question["mytext"][4],
		$data_question["mytext"][5],
		$data_question["mytext"][6],
		$data_question["mytext"][7],
		$data_question["mytext"][8],
		$data_question["mytext"][9],
		$data_question["sens_min"],
		$data_question["sens_max"],
		$new_pos
		));
		
		// On ajoute la question dans la BDD r_
		if($data_question['type_question']=="choix_multiple")
		{										
			if(isset($data_question["mytext"]) && is_array($data_question["mytext"]))
			{	
				for ($i = 0; $i <= 9; $i++)
				{	
					if ($data_question["mytext"][$i] != '')
					{						
						$data_question["mytext"][$i] = str_replace(' ', '_', $data_question["mytext"][$i]);							
						$this->db->query('ALTER TABLE r_'.$table.' ADD '.$new_id.'_'.$i.' BOOLEAN');
					}
				}
			}				  			
		}
		
		if($data_question['type_question']=="choix_simple")
		{									
			if(isset($data_question["mytext"]) && is_array($data_question["mytext"]))
			{		
				for ($i = 0; $i <= 9; $i++)
				{				
					if ($data_question["mytext"][$i] != '')
					{						
						$data_question["mytext"][$i] = str_replace(' ', '_', $data_question["mytext"][$i]);							
						$this->db->query('ALTER TABLE r_'.$table.' ADD '.$new_id.'_'.$i.' BOOLEAN');
					}
				}
			}				  			
		}
		
		if($data_question['type_question']=="echelle")
		{		
			$this->db->query('ALTER TABLE r_'.$table.' ADD '.$new_id.'_ INTEGER');															  			
		}
		
		if($data_question['type_question']=="champ_numerique")
		{
			$this->db->query('ALTER TABLE r_'.$table.' ADD '.$new_id.'_ INTEGER');																	  			
		}
		
		if($data_question['type_question']=="champ_texte")
		{
			$this->db->query('ALTER TABLE r_'.$table.' ADD '.$new_id.'_ VARCHAR(255)');									  			
		}
	}
	
	
	public function delete_question($form_id, $id_delete)
	{
		// On récupère la position de la question
		$req = $this->db->query("SELECT position FROM q_".$form_id." WHERE id = ".$id_delete);
		$req = $req->result_array();
		$position = $req[0]['position'];
		
		// Supprimer de la table q_
		$this->db->query("DELETE FROM q_".$form_id." WHERE id = ".$id_delete);
		
		// Supprimer de la table r_
		$req = $this->db->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'r_".$form_id."' AND column_name LIKE '".$id_delete."_%'");
		$req = $req->result_array();
		
		foreach($req as $e)
		{
			$this->db->query("ALTER TABLE r_".$form_id." DROP COLUMN ".$e['column_name']);
		}
		
		// On réorganise les positions dans la table q_
		$req = $this->db->query("SELECT id FROM q_".$form_id." WHERE position > ".$position);
		$req = $req->result_array();
		
		foreach($req as $e)
		{
			$pos = $this->db->query("SELECT position FROM q_".$form_id." WHERE id = ".$e['id']);
			$pos = $pos->result_array();
			$pos = $pos[0]['position']-1;					
			$this->db->query("UPDATE q_".$form_id." SET position = ".$pos." WHERE id = ".$e['id']);
		}
	}
	
	public function alter_data($answer_data)
	{
		$fields = array_keys($answer_data);
		$types_list = array();
		
		for ($i = 0; $i < count($fields); $i++)
		{
			$result = preg_match("#^type_question_(.*)$#i", $fields[$i]);
			if($result == True)
			{
				array_push($types_list, $fields[$i]);
			}		
		}
		
		foreach($types_list as $type)
		{
			$tmp = explode('_', $type);
			$id_question = $tmp[2];
			$data[$id_question]['type_question'] = $answer_data[$type];
		}
		
		$fields2 = array_keys($data);
		
		foreach($fields2 as $id)
		{
			if($data[$id]['type_question'] == 'choix_multiple')
			{
				for ($i = 0; $i < count($fields); $i++)
				{
					$result = preg_match("#^".$id."_(.*)$#i", $fields[$i]);
					if($result == True)
					{
						$tmp = $fields[$i];
						$data[$id][$tmp] = 1;
					}
				}
			}
			
			else if($data[$id]['type_question'] == 'choix_simple')
			{
				$tmp = $answer_data[$id.'_'];
				$data[$id][$id.'_'.$tmp] = 1;
			}
			
			else if(($data[$id]['type_question'] == 'champ_texte') || ($data[$id]['type_question'] == 'champ_numerique') || ($data[$id]['type_question'] == 'echelle'))
			{
				$data[$id][$id.'_'] = $answer_data[$id.'_'];
			}
		}
			
		return $data;
	}
	
	public function answer_question($answer_data)
	{
		$table = $answer_data['form_id'];
		$user_id = $_SESSION['user_id'];
		$id_question = $answer_data['id_question'];
		
		$req = $this->db->query("SELECT COUNT(id) FROM r_".$table." WHERE id = ".$user_id);
		$req = $req->result_array();
		$req = $req[0];
		$req = $req['COUNT(id)'];
				
		if($req == 0)
		{
			$this->db->query("INSERT INTO r_".$table." (id) VALUES(".$user_id.")");
		}
		
		if(($answer_data['type_question']=="choix_multiple"))
		{		
			$data = array_keys($answer_data);
			$answers = array();
	
			for ($i = 0; $i < count($data); $i++)
			{
				$result = preg_match("#^".$id_question."_(.*)$#i", $data[$i]);
				if($result == True)
				{
					array_push($answers, $data[$i]);
				}	
			}
				
			$req = $this->db->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'r_".$table."' AND column_name LIKE '".$id_question."_%'");
			$req = $req->result_array();
			
			foreach($req as $e)
			{
				$this->db->query("UPDATE r_".$table." SET ".$e['column_name']." = false WHERE id = ".$user_id);
			}
				
				
			foreach($answers as $answer)
			{	
				$this->db->query("UPDATE r_".$table." SET ".$answer." = true WHERE id = ".$user_id);
			}				  			
		}

		if($answer_data['type_question']=="choix_simple")
		{
			$data = array_keys($answer_data);
			$answers = array();
	
			for ($i = 0; $i < count($data); $i++)
			{
				$result = preg_match("#^".$id_question."_(.*)$#i", $data[$i]);
				if($result == True)
				{
					array_push($answers, $data[$i]);
				}	
			}
			
			$req = $this->db->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'r_".$table."' AND column_name LIKE '".$id_question."_%'");
			$req = $req->result_array();
						
			foreach($req as $e)
			{
				$this->db->query("UPDATE r_".$table." SET ".$e['column_name']." = false WHERE id = ".$user_id);
			}
			
			foreach($answers as $answer)
			{	
				$this->db->query("UPDATE r_".$table." SET ".$answer." = 1 WHERE id = ".$user_id);
			}	
		}

		if(($answer_data['type_question']=="champ_texte") || ($answer_data['type_question']=="champ_numerique") || ($answer_data['type_question']=="echelle"))
		{
			$id_question2 = $id_question."_";
			$this->db->query("UPDATE r_".$table." SET ".$id_question2." = '".$answer_data[$id_question2]."' WHERE id = ".$user_id);		
		}
	}
	
	
	public function move_question($move_data)
	{
		$table = $move_data['form_id'];
		$old_position = $move_data['old_position'];
		$new_position = $move_data['new_position'];
		$id = $move_data['id_move'];
		
		if($old_position < $new_position)
		{
			$this->db->query("UPDATE q_".$table." SET position = NULL WHERE id = ".$id);
			
			$req = $this->db->query("SELECT id FROM q_".$table." WHERE  position > ".$old_position." AND position <= ".$new_position);
			$req = $req->result_array();
			
			foreach($req as $e)
			{
				$pos = $this->db->query("SELECT position FROM q_".$table." WHERE id = ".$e['id']);
				$pos = $pos->result_array();
				$pos = $pos[0]['position']-1;				
				
				$this->db->query("UPDATE q_".$table." SET position = ".$pos." WHERE id = ".$e['id']);
			}
			
			$this->db->query("UPDATE q_".$table." SET position = ".$new_position." WHERE id = ".$id);
		}
		
		elseif($old_position > $new_position)
		{
			$this->db->query("UPDATE q_".$table." SET position = NULL WHERE id = ".$id);
			
			$req = $this->db->query("SELECT id FROM q_".$table." WHERE  position < ".$old_position." AND position >= ".$new_position);
			$req = $req->result_array();
			
			foreach($req as $e)
			{
				$pos = $this->db->query("SELECT position FROM q_".$table." WHERE id = ".$e['id']);
				$pos = $pos->result_array();
				$pos = $pos[0]['position']+1;				
				
				$this->db->query("UPDATE q_".$table." SET position = ".$pos." WHERE id = ".$e['id']);
			}
			
			$this->db->query("UPDATE q_".$table." SET position = ".$new_position." WHERE id = ".$id);
		}
	}
	
	// On récupère le type de la question
	public function get_question_type($form_id, $question_selected)
	{		
		$query = $this->db->query('SELECT type FROM q_'.$form_id.' WHERE id = '.$question_selected);
		$type = $query->result_array();
		return $type[0]['type'];
	}
}
	