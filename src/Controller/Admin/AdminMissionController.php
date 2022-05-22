<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMissionController extends AbstractController
{
    /**
     * @var MissionRepository
     */
    private $repository;

    private $em;

    /**
     * AdminMissionController constructor.
     * @param MissionRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(MissionRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/mission", name="admin.mission.index")
     */
    public function index(): Response
    {
        $missions = $this->repository->findAll();
        return $this->render('admin/mission/index.html.twig', compact('missions'));
    }

    /**
     * @Route("/admin/mission/create", name="admin.mission.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($mission);
            $this->em->flush();
            $this->addFlash('success', 'Mission crée avec succès !');
            return $this->redirectToRoute('admin.mission.index');
        }

        return $this->render('admin/mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/mission/{id}", name="admin.mission.edit", methods="GET|POST")
     * @param Mission $mission
     * @return Response
     */
    public function edit(Mission $mission, Request $request)
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Mission modifiée avec succès !');
            return $this->redirectToRoute('admin.mission.index');
        }

        return $this->render('admin/mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/mission/{id}", name="admin.mission.delete", methods="DELETE")
     * @param Mission $mission
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Mission $mission, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $mission->getId(), $request->get('_token'))) {
            $this->em->remove($mission);
            $this->em->flush();
            $this->addFlash('success', 'Mission supprimée avec succès');
        }

        return $this->redirectToRoute('admin.mission.index');
    }
}
