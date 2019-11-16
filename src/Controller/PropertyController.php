<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="property.index")
     */
    public function index()
    {
        $rep = $this->getDoctrine()->getRepository(Property::class);
        $property = $rep->findAllVisible();
        dump($property);


        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
        ]);
    }

    /**
     * @Route("/property/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }
        dump($property);
/*        $rep = $this->getDoctrine()->getRepository(Property::class);
        $property = $rep->find($id);*/
        return $this->render('property/show.html.twig', [
            'controller_name' => 'PropertyController',
            'property' => $property,
        ]);
    }
}
