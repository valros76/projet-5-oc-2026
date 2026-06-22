<?php
#[AllowDynamicProperties]
class UserController extends BaseController
{
  public function Login()
  {
    $this->view("login");
  }

  public function Authenticate($login, $password) {
    $userManager = new UserManager(BDD::getInstance(Config::getConfig()));
    $user = $userManager->getByMail($login);
    $this->view("profile");
  }
}