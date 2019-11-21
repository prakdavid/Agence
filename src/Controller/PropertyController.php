<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Contact;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    private $contactNotification;

    public function __construct(PropertyRepository $repository, ContactNotification $contactNotification)
    {
        $this->repository = $repository;
        $this->contactNotification = $contactNotification;
    }

    /**
     * @Route("/property", name="property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);

        $properties = $paginator->paginate($this->repository->findAllVisibleQuery($propertySearch),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('property/index.html.twig', [
            'properties' => $properties,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/property/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @param Request $request
     * @return Response
     */
    public function show(Property $property, string $slug, Request $request): Response
    {
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($contact);
            $this->contactNotification->notify($contact);
            $this->addFlash('success', 'Email envoyé.');
        }

        if ($property->getSlug() !== $slug) {
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }
}
