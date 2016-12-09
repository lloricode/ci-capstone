<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function index() {
        $this->load->view('home');
    }

}
// yo PRE.
/*
Suggestion lang, what if ganito ang controllers mo para mas simple?

sample:
controller
 -> action A
 -> action B

 Suggestion:

 HomeController (For info pages)
 -> index
 -> about
 -> contact

 AccountController (For account related pages)
 ->login
 ->logout
 ->signup
 ->index (account dashboard, pag hindi authenticated redirect to login action) 


*/