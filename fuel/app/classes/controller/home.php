<?php

/**
 * The Home Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Home extends Controller_Template {

	/**
	 * The index action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_index()
	{
		$this->title = 'Welcome';
	}

	

	/*
	 $form = Fieldset::factory('edit_user')
				->add_model('View_Admin_Users', $user, 'set_edit_form')
				->repopulate();

		if ($form->validation()->run())
		{
			if (View_Admin_Users::process_form($form, $user))
			{
				Session::set_flash('success', 'User successfully updated.');
				Response::redirect('admin/users');
			}
			else
			{
				Session::set_flash('error', 'Something went wrong, please try again!');
			}

			Response::redirect('admin/users/edit/'.$user->id);
		}
	 */


	//TODO move this to an other controller??
	public function action_signup()
	{
        if (Auth::check())
        {
            Response::redirect('/');
        }

		$form = Model_User_Validation::signup();
        if ($form->validation()->run())
        {
            if (Auth::instance()
					->create_user(	$form->validated('username'),
									$form->validated('password'),
									$form->validated('email'),
									Auth::group()->get_group('Users')))
            {
                Session::set_flash('success', 'Thanks for registering!');
                Response::redirect('/');
            }
            else
            {
                throw new Exception('An unexpected error occurred. Please try again.');
            }
        }

		$this->title = 'Sign up';
		$this->data['form'] = $form;
	}

    public function action_login()
	{
		if (Auth::check())
        {
            Response::redirect('dashboard');
        }

		$val = Validation::factory('login_user');
        $val->add('username', 'Username')
			->add_rule('required')
			->add_rule('min_length', 3)
			->add_rule('max_length', 20)
			->add_rule('trim')
			->add_rule('valid_string', array('alpha', 'numeric', 'dashes', 'dots'));


		$val->add('password', 'Password')
			->add_rule('required')
			->add_rule('min_length', 3)
			->add_rule('max_length', 20)
			->add_rule('trim')
			->add_rule('valid_string',
				array('utf8', 'alpha', 'numeric', 'spaces', 'punctuation', 'dashes'));

        if ($val->run())
        {
            if (Auth::instance()->login($val->validated('username'), $val->validated('password')))
            {
                Response::redirect('home');
            }
			else
			{
				Session::set_flash('error', 'Incorrect username or password.');

				Response::redirect('home/login');
			}
        }

        $this->title = 'Login';
		$this->data['val'] = Validation::instance('login_user');
	}

	public function action_logout()
	{
		Auth::instance()->logout();

        Response::redirect('home');
	}
}

/* End of file welcome.php */

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  void
	 */
/*	public function action_404()
	{
		$messages = array('Aw, crap!', 'Bloody Hell!', 'Uh Oh!', 'Nope, not here.', 'Huh?');
		$data['title'] = $messages[array_rand($messages)];

		// Set a HTTP 404 output header
		$this->response->status = 404;
		$this->response->body = View::factory('welcome/404', $data);
	}
*/