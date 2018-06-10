<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Model
{
	protected $table = 'users';
	
	
	// Fonctions pour générer des mots de passe
	function getRandomBytes($nbBytes = 32)
	{
		$bytes = openssl_random_pseudo_bytes($nbBytes, $strong);
		if (false !== $bytes && true === $strong) {
			return $bytes;
		}
		else {
			throw new \Exception("Unable to generate secure token from OpenSSL.");
		}
	}
	
	function generatePassword($length){
		return substr(preg_replace("/[^a-zA-Z0-9]/", "", base64_encode($this->getRandomBytes($length+1))),0,$length);
	}
	
	
	// On vérifie les identifiants fournis dans la page d'authentification
	public function user_verification($where = array())
	{		
		$nb_results = (int) $this->db->where($where)
						             ->count_all_results($this->table);
														 
		if($nb_results == 1){ return True; }		
		elseif($nb_results == 0){ return False; }
	}
	
	// On récupère les autorisations de l'utilisateur	
	public function get_user_privilege($id, $password)
	{		
		return $this->db->query('SELECT privilege FROM '.$this->table.' WHERE id = '.$id.' AND password = "'.$password.'"');	
	}			
	
	
	public function add_start_up($name)
	{	
		$req = $this->db->query('SELECT MAX(ID) FROM startups');
		$req = $req->result_array();
		$max_id = $req[0]['MAX(ID)'];
		$new_id = $max_id + 1;
		
		$this->db->query('INSERT INTO startups(id, nom) VALUES('.$new_id.', "'.$name.'")');	
	}
	
	public function get_startups()
	{	
		$query = $this->db->query('SELECT * FROM startups');
		return $query->result_array();
				
	}
	
	
	public function add_user($startup)
	{	
		$password = $this->generatePassword(8);
		echo $password;
		
		$req = $this->db->query('SELECT MAX(ID) FROM users');
		$req = $req->result_array();
		$max_id = $req[0]['MAX(ID)'];
		$new_id = $max_id + 1;
		
		$this->db->query('INSERT INTO users(id, password, startup, privilege) VALUES('.$new_id.', "'.$password.'", "'.$startup.'", "user")');
	}
	
	
}
	