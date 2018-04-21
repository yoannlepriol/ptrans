<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('Form');
		$this->load->library('Form_validation');
		$this->load->model('Forms');
		$this->load->model('Users');
	}
	
	public function index()
	{
		$this->load->view('Login');
	}
		
	public function connexion()
	{	 
		// Verification des champs
		$this->form_validation->set_rules('id','"Identifiant"','required');
		$this->form_validation->set_rules('password','"Mot de passe"','required');
		$form_validation = $this->form_validation->run();
				
		// Verification des identifiants
		$id = $this->input->post('id');
		$password = $this->input->post('password');		
		$user_validation = $this->Users->user_verification(array('id' => $id, 'password' => $password));
		
		if($form_validation && $user_validation)
		{	
			// On récupère les autorisations de l'utilisateur
			$user_privilege = $this->Users->get_user_privilege($id, $password);			
			$row = $user_privilege->row();
			$user_privilege = $row->privilege;
				
			// On met à jour la session
			$data = array( 'user_id' => $id, 'user_privilege' => $user_privilege);
			$this->session->set_userdata($data);
									
			// On charge la page d'accueil correspondant aux autorisations			
			redirect('Form');
		}
		
		else{ redirect('Login'); }
	}
	
	public function deconnexion()
	{
		session_destroy();
		redirect('Login');
	}
}



