<?php

namespace app\api\controller;

use think\Controller;

class User extends Controller
{
    public function index()
    {
        return $this->fetch('user');
}
}