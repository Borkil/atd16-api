<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController
{
  public function __construct(private Security $security)
  {}

  public function __invoke()
  {
    $user = $this->security->getUser();
    return $user;
  }
}
