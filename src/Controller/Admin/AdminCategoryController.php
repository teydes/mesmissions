<?php

namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    private $em;

    /**
     * AdminMissionController constructor.
     * @param CategoryRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(CategoryRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/categorie", name="admin.categorie.index")
     */
    public function index(): Response
    {
        $categories = $this->repository->findAll();
        return $this->render('admin/categorie/index.html.twig', compact('categories'));
    }

    /**
     * @Route("/admin/categorie/create", name="admin.categorie.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $categorie = new Category();
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Catégorie crée avec succès !');
            return $this->redirectToRoute('admin.categorie.index');
        }

        return $this->render('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/categorie/{id}", name="admin.categorie.edit", methods="GET|POST")
     * @param Category $category
     * @param Request $request
     * @return Response
     * @internal param $Category
     */
    public function edit(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès !');
            return $this->redirectToRoute('admin.categorie.index');
        }

        return $this->render('admin/categorie/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/categorie/{id}", name="admin.categorie.delete", methods="DELETE")
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Category $category, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $category->getId(), $request->get('_token'))) {
            $this->em->remove($category);
            $this->em->flush();
            $this->addFlash('success', 'Catégorie supprimée avec succès');
        }

        return $this->redirectToRoute('admin.categorie.index');
    }
}
