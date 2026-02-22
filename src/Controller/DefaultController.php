<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class DefaultController extends AbstractController
{
    function __construct(
        protected readonly Environment $twig,
    ) {}

    #[Route("/", name: "app_info_home")]
    function index(): Response
    {
        return $this->render("pages/home.html.twig");
    }
}
