<?php

class ProductController extends ControllerBase
{

    public function newAction()
    {
    	if (!$this->session->get("auth")) {
    		$this->flash->notice('Please login first');
    		$this->response->redirect('Session');
    	}
    	$this->view->user = User::findFirst($this->session->get("auth")['id']);
    }

    public function createAction()
	{

		$product = new Product();
		$product->name = $_POST['name'];
		$product->stock = $_POST['stock'];
		$product->price = $_POST['price'];

		$uploaddir = 'C:\xampp\htdocs\one\public\img\.';
		$uploadfile = $uploaddir . basename($_FILES['photo']['name']);

		if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$product->img_url = $uploadfile;

		}

		if (!$product->save()) {
			foreach ($product->getMessages() as $message) {
				$this->flash->error($message);
				return $this->dispatcher->forward(array(
					"controller" => "Product",
					"action" => "new"
					));
			}
		} else {
			$this->flash->success('Product successfully created.');
			return $this->response->redirect('Index');
		}
	}

	public function confirmAction()
	{
		if (!$this->session->get("auth")) {
    		$this->flash->notice('Please login first');
    		$this->response->redirect('Session');
    	}

    	if (!$_POST['product_id']) {
    		return $this->response->redirect('Index');
    	}

		$user = User::findFirst($this->session->get("auth")['id']);
		if (strlen($user->cart)==0 or is_null($user->cart)) {
			$user->cart = $_POST['product_id'];
		}
		else {
			$user->cart = $user->cart .', '. $_POST['product_id'];
		}
		$user->save();
		$this->flash->success("Product was added successfully to your cart.");
		$this->response->redirect('Index');
	}

	public function invoiceAction()
	{
		$this->view->product = Product::findFirst($_POST['product_id']);
		$this->view->user = User::findFirst($this->session->get("auth")['id']);
	}


}

