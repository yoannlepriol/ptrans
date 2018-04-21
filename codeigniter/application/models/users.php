<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Model
{
	protected $table = 'users';
	
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
	
}
	