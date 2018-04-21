<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller
{
		
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('Form');
		$this->load->model('Forms');
	}
	
	public function index()
	{
		if($_SESSION['user_privilege'] == 'admin')
		{ 
			$forms = $this->Forms->get_forms_list();
			$data = array('forms' => $forms);
			$data['nav_bar'] = $this->load->view('Nav_bar');
			$this->load->view('Admin_home', $data); 
		}
		
		elseif($_SESSION['user_privilege'] == 'user')
		{ 
			$all_forms = $this->Forms->get_forms_list();
			$user_forms = $this->Forms->get_user_forms($all_forms);
			$filled_forms = $this->Forms->get_filled_forms($user_forms);
			$data = array('forms' => $user_forms, 'filled_forms' => $filled_forms);
			$data['nav_bar'] = $this->load->view('Nav_bar');
			$this->load->view('User_home', $data);
		}
	}
			
	public function reponses()
	{
		$data = array();
		
		if($this->session->flashdata('answers') == NULL){ $form_name = $this->input->post('form_name'); }
		else 
		{ 
			$answers = $this->session->flashdata('answers');
			$form_name = $answers['form_name']; 
			$data['answers'] = $answers; 
		} 
					
		$users = $this->Forms->get_users($form_name);	
		$data['form_name'] = $form_name;
		$data['users'] = $users;	
		$data['nav_bar'] = $this->load->view('Nav_bar');
									
		$this->load->view('Answers', $data);
	}
	
	public function ajouter()
	{		
		$form_name = $this->input->post('new_form');		
		$this->Forms->add_form($form_name);		
		redirect('Form');
	}
	
	public function supprimer()
	{		
		$form_name = $this->input->post('delete_form');		
		$this->Forms->delete_form($form_name);		
		redirect('Form');
	}
	
	public function modifier($form_name = NULL) // Paramètre optionnel
	{		
		if($form_name == NULL) { $form_name = $this->input->post('modify_form'); }
		$form = $this->Forms->get_form($form_name);				
		$data = array('form_name' => $form_name, 'form' => $form);
		$data['nav_bar'] = $this->load->view('Nav_bar');		
		$this->load->view('edit_form', $data);
	}
	
	public function ajouter_question()
	{	
		$data_question = $this->input->post();
		$form_name = $data_question['form_name'];
		$this->Forms->add_question($data_question);		
		$this->modifier($form_name);
		redirect('Form/modifier/'.$form_name);
	}
	
	public function supprimer_question()
	{	
		$id_delete = $this->input->post('id_delete');
		$form_name = $this->input->post('form_name');		
		$this->Forms->delete_question($form_name, $id_delete);	
		redirect('Form/modifier/'.$form_name);		
	}
	
	public function deplacer_question()
	{	
		$move_data = $this->input->post();
		$form_name = $this->input->post('form_name');
		$this->Forms->move_question($move_data);
		redirect('Form/modifier/'.$form_name);
	}
	
	public function repondre($form_name)
	{			
		$form = $this->Forms->get_form($form_name);
		$data = array('form_name' => $form_name, 'form' => $form);
		$data['nav_bar'] = $this->load->view('Nav_bar');	
		$this->load->view('Answer_form', $data);		
	}
	
	public function repondre_question()
	{	
		$answer_data = $this->input->post();
		$form_name = $answer_data['form_name'];
		
		var_dump($answer_data);
		
		$data = $this->Forms->alter_data($answer_data);
		
		$ids = array_keys($data);
		for ($i = 0; $i < count($ids); $i++)
		{
			$id = $ids[$i];
			$answer = $data[$id];
			$answer['form_name'] = $form_name;
			$answer['id_question'] = $id;
			$this->Forms->answer_question($answer);		
		}
		
		redirect('Form');
	}
	
	public function load_data()
	{			
		$post = $this->input->post();
		$options = $this->input->post('options');
		$form_name = $post['form_name'];
		$answers = $this->Forms->get_user_answer($post);
		$answers['form_name'] = $form_name;
		$this->session->set_flashdata('answers', $answers);
		redirect('Form/reponses');
		
	}
	
}



