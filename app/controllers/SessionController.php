<?php

class SessionController extends ControllerBase
{

	public function indexAction()
	{

	}

	private function _registerSession(User $user)
	{
		$this->session->set('auth', array(
			'id' => $user->id,
			'first_name' => $user->first_name,
			'email' => $user->email,
			'username' => $user->username
			));
	}

	public function startAction()
	{
			$email = $_POST['email'];
			$password = $_POST['password'];

			$user = User::findFirst(array(
                "(email = :email: OR username = :email:)",
                'bind' => array('email' => $email)
            ));
			if (password_verify($password, $user->password)) {
				$this->_registerSession($user);
				$this->flash->success('Welcome ' . $user->name);
				return $this->response->redirect('index');
			}

			$this->flash->error('Wrong email/password');

		return $this->response->redirect('Session/index');
	}

	public function endAction()
	{
		$this->session->remove('auth');
		$this->flash->success('Goodbye!');
		return $this->response->redirect('index');
	}

}

