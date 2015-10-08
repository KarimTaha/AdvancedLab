<?php

class UserController extends ControllerBase
{

	public function newAction()
	{

	}

	public function createAction()
	{
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		if (!password_verify($_POST['repeatPassword'], $password)) {
			$this->flash->error('Passwords do not match');
			return $this->dispatcher->forward(array(
				"controller" => "User",
				"action" => "new"
				));
		}

		$user = new User();
		$user->username = $_POST['username'];
		$user->password = $password;
		$user->first_name = $_POST['first_name'];
		$user->last_name = $_POST['last_name'];
		$user->email = $_POST['email'];
		$user->created_at = new Phalcon\Db\RawValue('now()');

		$uploaddir = 'C:\xampp\htdocs\one\public\img\.';
		$uploadfile = $uploaddir . basename($_FILES['photo']['name']);

		if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$user->avatar = $uploadfile;

		}

		if (!$user->save()) {
			foreach ($user->getMessages() as $message) {
				$this->flash->error($message);
				return $this->dispatcher->forward(array(
					"controller" => "User",
					"action" => "new"
					));
			}
		} else {
			$this->flash->success('Thanks for registering, please proceed to log in');
			return $this->response->redirect('Session/index');
		}
	}

	public function editAction()
	{
		if (!$this->session->get("auth")) {
			$this->flash->notice('Please login first');
			$this->response->redirect('Session');
		}

		$this->view->user = User::findFirst($this->session->get("auth")['id']);
	}

	public function saveAction()
	{

		$user = User::findFirst($this->session->get("auth")['id']);

		$user->first_name = $_POST['first_name'];
		$user->last_name = $_POST['last_name'];
		$user->username = $_POST['username'];
		$user->email = $_POST['email'];

		if (strlen($_POST['password']) > 0) {
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			if (password_verify($_POST['repeatPassword'], $password)) {
				$user->password = $password;
			}
		}

		if (!$user->save()) {

			foreach ($user->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(array(
				"controller" => "User",
				"action" => "edit"
				));
		}

		$this->flash->success("Your profile was updated successfully");

		return $this->response->redirect('User/profile');
	}

	public function profileAction()
	{
		if (!$this->session->get("auth")) {
			$this->flash->notice('Please login first');
			$this->response->redirect('Session');
		}

		$user = User::findFirst($this->session->get("auth")['id']);
		$purchases = Purchase::find();
		$user_purchases = array();

		foreach ($purchases as $purchase) {
			if ($purchase->user_id == $user->id) {
				array_push($user_purchases, $purchase);
			}
		}

		$this->view->user = $user;
		$this->view->user_purchases = $user_purchases;
	}

	public function changeAvatarAction()
	{
		$this->view->user = User::findFirst($this->session->get("auth")['id']);
	}

	public function saveAvatarAction()
	{
		$user = User::findFirst($this->session->get("auth")['id']);
		$uploaddir = 'C:\xampp\htdocs\one\public\img\.';
		$uploadfile = $uploaddir . basename($_FILES['photo']['name']);

		if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$user->avatar = $uploadfile;
			$user->save();
			$this->flash->success('Avatar changed');
		}
		return $this->response->redirect('Index');
	}

	public function cartAction()
	{
		if (!$this->session->get("auth")) {
			$this->flash->notice('Please login first');
			$this->response->redirect('Session');
		}

		$user = User::findFirst($this->session->get("auth")['id']);
		$products_ids = explode(", ", $user->cart);
		$products = array();
		foreach ($products_ids as $id) {
			$temp = Product::findFirst($id);
			array_push($products, $temp);
		}

		$this->view->user = $user;
		$this->view->products = $products;
	}

	public function removeItemAction()
	{
		if (!$_POST['product_id']) {
			return $this->response->redirect('Index');
		}
		
		$product = $_POST['product_id'];
		$user = User::findFirst($this->session->get("auth")['id']);
		$updated_cart = array();

		$cart = explode(", ", $user->cart);
		foreach ($cart as $item) {
			if ($item != $product) {
				array_push($updated_cart, $item);
			}
			else {
				$product = -1;
			}
		}

		$user->cart = implode(", ", $updated_cart);
		$user->save();
		$this->response->redirect('User\cart');
		$this->flash->success("Item was successfully removed from cart");
	}

	public function checkoutAction()
	{
		//check if there is a logged in user
		if (!$this->session->get("auth")) {
			$this->flash->notice('Please login first');
			$this->response->redirect('Session');
		}

		//get logged in user instance and a list of the ids of the products in his cart
		$user = User::findFirst($this->session->get("auth")['id']);
		$products_ids = explode(", ", $user->cart);

		//check if cart is empty
		if (strlen($user->cart)<1) {
			$this->response->redirect("Index");
			return $this->flash->notice("Cart is empty!");
		}

		//check if someone bought an item he already had in his cart
		foreach ($products_ids as $id) {
			$temp = Product::findFirst($id);
			if ($temp->stock <= 0) {
				$this->flash->notice("Error, please re-add items to your cart!");
				$user->cart = '';
				$user->save();
				return $this->response->redirect("Index");
			}
		}

		$products = array();

		$purchase = new Purchase();
		$purchase->user_id = $user->id;
		$purchase->time = new Phalcon\Db\RawValue('now()');

		//decrement each product's stock, and add purchase record data
		foreach ($products_ids as $id) {
			$temp = Product::findFirst($id);

			//added more items to cart than in stock, so only purchase available ones
			if ($temp->stock <= 0) {
				$this->flash->notice("Error, some items in your cart were not successfully purchased, please check your history");
				$user->cart = '';
				$user->save();
				$purchase->save();
				return $this->response->redirect("Index");
			}

			$temp->stock--;
			$temp->save();

			if (strlen($purchase->products)==0 or is_null($purchase->products)) {
				$purchase->products = $id;
			}
			else {
				$purchase->products = $purchase->products .', '. $id;
			}

			$purchase->price += $temp->price;
		}

		//check if there is an error with saving the record
		if (!$purchase->save()) {
			foreach ($purchase->getMessages() as $message) {
				$this->flash->error($message);
			}
		}
		else {
			//empty cart and save
			$user->cart = '';
			$user->save();
		}
		$this->response->redirect("Index");
		$this->flash->success("Checkout successful!");
	}


}

