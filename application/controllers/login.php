<?php
class Login extends Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		if($this->Employee->is_logged_in())
		{
			redirect('home');
		}

		$this->form_validation->set_rules('username', 'lang:login_username', 'callback_login_check');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->_render_login(FALSE);
		}
		else
		{
			redirect('home');
		}
	}

	function register()
	{
		if($this->Employee->is_logged_in())
		{
			redirect('home');
		}
		
		$this->_render_login(TRUE);
	}

	function create_account()
	{
		if($this->Employee->is_logged_in())
		{
			redirect('home');
		}

		$this->form_validation->set_rules('first_name', 'lang:common_first_name', 'required');
		$this->form_validation->set_rules('last_name', 'lang:common_last_name', 'required');
		$this->form_validation->set_rules('register_email', 'lang:common_email', 'valid_email');
		$this->form_validation->set_rules('register_username', 'lang:login_username', 'required|min_length[5]|callback_username_available');
		$this->form_validation->set_rules('register_password', 'lang:login_password', 'required|min_length[8]');
		$this->form_validation->set_rules('register_password_confirm', 'lang:login_confirm_password', 'required|matches[register_password]');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$this->_render_login(TRUE);
			return;
		}

		$person_data = array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'email'=>$this->input->post('register_email'),
			'phone_number'=>$this->input->post('phone_number'),
			'address_1'=>'',
			'address_2'=>'',
			'city'=>'',
			'state'=>'',
			'zip'=>'',
			'country'=>'',
			'comments'=>''
		);

		$employee_data = array(
			'username'=>$this->input->post('register_username'),
			'password'=>md5($this->input->post('register_password'))
		);

		$permission_data = array();
		foreach($this->Module->get_all_modules()->result() as $module)
		{
			$permission_data[] = $module->module_id;
		}

		if($this->Employee->save($person_data, $employee_data, $permission_data, -1))
		{
			$this->Employee->login($employee_data['username'], $this->input->post('register_password'));
			redirect('home');
		}
		else
		{
			$this->_render_login(TRUE, $this->lang->line('login_registration_failed'));
		}
	}
	
	function login_check($username)
	{
		$password = $this->input->post("password");	
		
		if(!$this->Employee->login($username,$password))
		{
			$this->form_validation->set_message('login_check', $this->lang->line('login_invalid_username_and_password'));
			return false;
		}
		return true;		
	}

	function username_available($username)
	{
		$query = $this->db->get_where('employees', array('username' => $username), 1);
		if ($query->num_rows() == 0)
		{
			return true;
		}

		$this->form_validation->set_message('username_available', $this->lang->line('login_username_taken'));
		return false;
	}

	function _render_login($show_register = FALSE, $registration_error = '')
	{
		$data = array(
			'show_register' => $show_register,
			'registration_error' => $registration_error
		);
		$this->load->view('login', $data);
	}
}
?>
