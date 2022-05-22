<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Mission;
use App\Form\SearchForm;
use App\Repository\MissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionsController extends AbstractController
{
    /**
     * @var MissionRepository
     */
    private $repository;

    public function __construct(MissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/missions", name="mission.index")
     */
    public function index(MissionRepository $repository, PaginatorInterface $paginator,Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        //dd($data);
        $missions = $repository->findSearch($data);

        /*  $paginator->paginate(
              $this->repository->findAllVisibleQuery(),
              $request->query->getInt('page', 1),
              12
        ); */
        return $this->render('pages/index.html.twig', [
            'current_menu' => 'missions',
            'missions' => $missions,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/missions/{slug}-{id}", name="mission.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Mission $mission, string $slug): Response
    {
        if($mission->getSlug() !== $slug) {
            return $this->redirectToRoute('mission.show', [
                'id' => $mission->getId(),
                'slug' => $mission->getSlug()
            ], 301);
        }
        return $this->render('pages/show.html.twig', [
            'mission' => $mission,
            'current_menu' => 'missions'
        ]);
    }
}
