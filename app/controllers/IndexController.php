<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
    	$this->view->products = Product::find();
    	if ($this->session->get("auth")) {
    		$this->view->user = User::findFirst($this->session->get("auth")['id']);
    	}
    }

}

