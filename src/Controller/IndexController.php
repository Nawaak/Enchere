<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CategoryRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CategoryRepository $repo)
    {
        $category = $repo->findAll();

        return $this->render('index/index.html.twig',compact('category'));
    }
}
