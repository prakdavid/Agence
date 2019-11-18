<?php

namespace App\Controller\Admin;

use App\Entity\PropertyOption;
use App\Form\PropertyOptionType;
use App\Repository\PropertyOptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/property/option")
 */
class AdminOptionController extends AbstractController
{
    /**
     * @Route("/", name="admin.property.option.index", methods={"GET"})
     */
    public function index(PropertyOptionRepository $propertyOptionRepository): Response
    {
        return $this->render('admin/option/index.html.twig', [
            'property_options' => $propertyOptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.property.option.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $propertyOption = new PropertyOption();
        $form = $this->createForm(PropertyOptionType::class, $propertyOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($propertyOption);
            $entityManager->flush();

            return $this->redirectToRoute('admin.property.option.index');
        }

        return $this->render('admin/option/new.html.twig', [
            'property_option' => $propertyOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.property.option.show", methods={"GET"})
     */
    public function show(PropertyOption $propertyOption): Response
    {
        return $this->render('admin/option/show.html.twig', [
            'property_option' => $propertyOption,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.property.option.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PropertyOption $propertyOption): Response
    {
        $form = $this->createForm(PropertyOptionType::class, $propertyOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.property.option.index');
        }

        return $this->render('admin/option/edit.html.twig', [
            'property_option' => $propertyOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.property.option.delete", methods={"DELETE"})
     */
    public function delete(Request $request, PropertyOption $propertyOption): Response
    {
        if ($this->isCsrfTokenValid('delete'.$propertyOption->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($propertyOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.property.option.index');
    }
}
