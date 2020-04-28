<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{

    private $security;
    private $user;

    public function __construct(
        Security $security
    )
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        /*
         * @var \App\Entity\User $user
         */
        $user = $this->getUser();
        $this->user = $this->security->getUser();

        if ($user == null) {
            // If user not authenticated
            // return $this->redirectToRoute('login');
            return $this->redirect('/login');
        } else {
            $hasAccess = in_array('ROLE_USER', $user->getRoles());
            if ($hasAccess) {
                // Else if user authenticated with "USER" role & have permission
                return $this->render('index/index.html.twig', [
                    'controller_name' => 'IndexController',
                ]);
            } else {
                // Else if user role not in "ROLE_USER" list
                // return $this->redirectToRoute('login');
                return $this->redirect('/login');
            }
        }

    }
}
