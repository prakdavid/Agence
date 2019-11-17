<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PropertyController extends AbstractController
{

    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/property", name="property.index")
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $properties = $paginator->paginate($this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            12);
        return $this->render('property/index.html.twig', compact('properties'));
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
