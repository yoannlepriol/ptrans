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
			$all_forms = array();
			
			foreach($forms as $form)
			{
				$tmp = $form['table_name'];
				array_push($all_forms, $tmp);
			}
			
			$all_forms_name = $this->Forms->get_forms_name($all_forms);
			$data = array('forms' => $all_forms_name);
			$data['nav_bar'] = $this->load->view('Nav_bar');
			$this->load->view('Admin_home', $data); 
		}
		
		else if($_SESSION['user_privilege'] == 'user')
		{ 
			$all_forms = $this->Forms->get_forms_list();			
			$user_forms = $this->Forms->get_user_forms($all_forms);	
			$user_forms_name = $this->Forms->get_forms_name($user_forms);
			$filled_forms = $this->Forms->get_filled_forms($user_forms);
			$data = array('forms' => $user_forms_name, 'filled_forms' => $filled_forms);
			$data['nav_bar'] = $this->load->view('Nav_bar');
			$this->load->view('User_home', $data);
		}
	}
			
	public function reponses()
	{
		$data = array();
		
		if($this->session->flashdata('answers') == NULL){ $form_id = $this->input->post('form_id'); }
		else 
		{ 
			$answers = $this->session->flashdata('answers');
			$form_id = $answers['form_id']; 
			$data['answers'] = $answers; 
		} 
					
		$users = $this->Forms->get_users($form_id);	
		$data['form_id'] = $form_id;
		$data['users'] = $users;	
		$data['nav_bar'] = $this->load->view('Nav_bar');
									
		$this->load->view('Answers', $data);
	}
	
	public function ajouter()
	{		
		$form_name = $this->input->post('new_form');
		$form_details = $this->input->post('details');
		$this->Forms->add_form($form_name, $form_details);		
		redirect('Form');
	}
	
	public function supprimer()
	{		
		$form_id = $this->input->post('delete_form');		
		$this->Forms->delete_form($form_id);		
		redirect('Form');
	}
	
	public function modifier($form_id = NULL) // Paramètre optionnel
	{		
		if($form_id == NULL) { $form_id = $this->input->post('modify_form'); }
		$form = $this->Forms->get_form($form_id);				
		$data = array('form_id' => $form_id, 'form' => $form);
		$data['nav_bar'] = $this->load->view('Nav_bar');		
		$this->load->view('edit_form', $data);
	}
	
	public function ajouter_question()
	{	
		$data_question = $this->input->post();
		$form_id = $data_question['form_id'];
		$this->Forms->add_question($data_question);		
		$this->modifier($form_id); // Doublon ?
		redirect('Form/modifier/'.$form_id);
	}
	
	public function supprimer_question()
	{	
		$id_delete = $this->input->post('id_delete');
		$form_id = $this->input->post('form_id');		
		$this->Forms->delete_question($form_id, $id_delete);	
		redirect('Form/modifier/'.$form_id);		
	}
	
	public function deplacer_question()
	{	
		$move_data = $this->input->post();
		$form_id = $this->input->post('form_id');
		$this->Forms->move_question($move_data);
		redirect('Form/modifier/'.$form_id);
	}
	
	public function repondre($form_id)
	{			
		$form = $this->Forms->get_form($form_id);
		$details = $this->Forms->get_details($form_id);
		$data = array('form_id' => $form_id, 'form' => $form, 'details' => $details);
		$data['nav_bar'] = $this->load->view('Nav_bar');	
		$this->load->view('Answer_form', $data);		
	}
	
	public function repondre_question()
	{	
		$answer_data = $this->input->post();
		$form_id = $answer_data['form_id'];
		
		var_dump($answer_data);
		
		$data = $this->Forms->alter_data($answer_data);
		
		$ids = array_keys($data);
		for ($i = 0; $i < count($ids); $i++)
		{
			$id = $ids[$i];
			$answer = $data[$id];
			$answer['form_id'] = $form_id;
			$answer['id_question'] = $id;
			$this->Forms->answer_question($answer);		
		}
		
		redirect('Form');
	}
	
	public function load_data()
	{			
		$post = $this->input->post();
		$options = $this->input->post('options');
		$form_id = $post['form_id'];
		$answers = $this->Forms->get_user_answer($post);
		$answers['form_id'] = $form_id;
		$this->session->set_flashdata('answers', $answers);
		redirect('Form/reponses');
		
	}
	
}



