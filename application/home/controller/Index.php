<?php
namespace app\home\controller;

use think\Controller;

class Index extends Controller {

	public function index(){
		echo '<pre>';
		print_r(input());
	}
}
