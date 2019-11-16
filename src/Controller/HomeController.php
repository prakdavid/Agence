<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(PropertyRepository $propertyRepository)
    {
        $properties =  $propertyRepository->findLatest();
        dump($properties);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $properties
        ]);
    }
}
