<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CategoryRepository $repo
     * @return Response
     */
    public function index(CategoryRepository $repo): Response
    {
        $category = $repo->findAll();
        return $this->render('index/index.html.twig',compact('category'));
    }
}
