<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller
{
		
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('Form');
		$this->load->model('Forms');
		$this->load->model('Questions');
		$this->load->model('Users');
	}
	
	public function index($action = NULL)
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
			
			if (isset($action))
			{ 
				$data['main_content'] = $action; 
				
				if ($action == 'ajouter_utilisateur')
				{
					$data['startups'] = $this->Users->get_startups();
				}
				
				else if ($action == 'supprimer_utilisateur')
				{
					$data['startups'] = $this->Users->get_startups();
				}
			}
			
			else { $data['main_content'] = 'lister_questionnaires'; }
			
			
				
			$this->load->view('admin_home', $data); 
		}
		
		else if($_SESSION['user_privilege'] == 'user')
		{ 
			$all_forms = $this->Forms->get_forms_list();			
			$user_forms = $this->Forms->get_user_forms($all_forms);	
			$user_forms_name = $this->Forms->get_forms_name($user_forms);
			$filled_forms = $this->Forms->get_filled_forms($user_forms);
			$data = array('forms' => $user_forms_name, 'filled_forms' => $filled_forms);
			//$data['nav_bar'] = $this->load->view('nav_bar');
			$this->load->view('user_home', $data);
		}
	}
	
	public function ajouter_start_up()
	{		
		$new_start_up = $this->input->post('new_start_up');
		$this->Users->add_start_up($new_start_up);		
		redirect('Form');
	}
	
	public function ajouter_utilisateur()
	{		
		$user_startup = $this->input->post('start_up');
		$this->Users->add_user($user_startup);		
		redirect('Form');
	}
			
	public function reponses($form_id)
	{
		$data = array();
		
		$answers = $this->session->flashdata('answers');
		$dropdown_values = $this->session->flashdata('dropdown_values');	
		$data['answers'] = $answers;
		$data['dropdown_values'] = $dropdown_values; 					

		$data['form_id'] = $form_id;
		
		$questions = $this->Forms->get_form($form_id);
		$data['questions'] = $questions;
		
		$users = $this->Forms->get_users($form_id);	
		$data['users'] = $users;
		
		$this->load->view('answers', $data);
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
		//$data['nav_bar'] = $this->load->view('nav_bar');		
		$this->load->view('edit_form', $data);
	}
	
	public function ajouter_question()
	{	
		$data_question = $this->input->post();
		$form_id = $data_question['form_id'];
		$this->Questions->add_question($data_question);		
		$this->modifier($form_id); // Doublon ?
		redirect('Form/modifier/'.$form_id);
	}
	
	public function supprimer_question()
	{	
		$id_delete = $this->input->post('id_delete');
		$form_id = $this->input->post('form_id');		
		$this->Questions->delete_question($form_id, $id_delete);	
		redirect('Form/modifier/'.$form_id);		
	}
	
	public function deplacer_question()
	{	
		$move_data = $this->input->post();
		$form_id = $this->input->post('form_id');
		$this->Questions->move_question($move_data);
		redirect('Form/modifier/'.$form_id);
	}
	
	public function modifier_details()
	{	
		$new_details = $this->input->post('details');
		$form_id = $this->input->post('form_id');
		$this->Forms->modify_details($form_id, $new_details);
		redirect('Form/modifier/'.$form_id);
	}
	
	public function repondre($form_id)
	{			
		$form = $this->Forms->get_form($form_id);
		$details = $this->Forms->get_details($form_id);
		$data = array('form_id' => $form_id, 'form' => $form, 'details' => $details);
		$data['nav_bar'] = $this->load->view('nav_bar');	
		$this->load->view('answer_form', $data);		
	}
	
	public function repondre_question()
	{	
		$answer_data = $this->input->post();
		$form_id = $answer_data['form_id'];
		
		var_dump($answer_data);
		
		$data = $this->Questions->alter_data($answer_data);
		
		$ids = array_keys($data);
		for ($i = 0; $i < count($ids); $i++)
		{
			$id = $ids[$i];
			$answer = $data[$id];
			$answer['form_id'] = $form_id;
			$answer['id_question'] = $id;
			$this->Questions->answer_question($answer);		
		}
		
		redirect('Form');
	}
	
	public function load_data()
	{	
		// Récupération des données
		$post = $this->input->post();
		var_dump($post);
		$users = $post['users'];
		$form_id = $post['form_id'];
	
		// Transformation des données
		$fields = array_keys($post);
		$questions_selected = array();
		
		for ($i = 0; $i < count($fields); $i++)
		{
			$result = preg_match("#^dropdown(.*)$#i", $fields[$i]);
			if($result == True)
			{
				$tmp = explode('_', $fields[$i]);
				$question_selected = $tmp[1];
				echo $question_selected;
				
				if($post['dropdown_'.$question_selected] != '0')
				{
					$tmp2 = $fields[$i];
					$tmp3 = $post[$tmp2];
					$questions_selected[$question_selected] = $tmp3;
				}
			}		
		}
		
		var_dump($questions_selected);
		
		$this->session->set_flashdata('dropdown_values', $questions_selected);
		
		// Récupération des réponses
		$answers = array();
		foreach($questions_selected as $question_selected)
		{
			$type = $this->Questions->get_question_type($form_id, $question_selected);
			foreach($users as $user)
			{		
				$user = $user['id'];
				$tmp = $this->Forms->get_user_answer($form_id, $question_selected, $user, $type);
				$answers[$question_selected][$user] = $tmp;
			}
		}
		
		$this->session->set_flashdata('answers', $answers);
		redirect('Form/reponses/'.$form_id);
		
	}
	
}



