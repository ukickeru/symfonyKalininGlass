<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController extends AbstractController
{

  /**
   * @Route("/api/test", name="testApi", methods={"GET", "POST", "OPTIONS"})
   */
  public function testApi()
  {
    $response = new JsonResponse('Api works great!');
    return $response;
  }

}