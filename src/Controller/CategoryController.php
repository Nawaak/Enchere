<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BiddingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="category.show")
     * @param Category $category
     * @param BiddingRepository $repo
     * @return Response
     */
    public function show(Category $category, BiddingRepository $repo): Response
    {
        $biddings = $repo->findBiddingsWithCategory($category->getId());
        return $this->render('category/show.html.twig',compact('category','biddings'));
    }

}
