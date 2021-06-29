<?php

namespace App\Controller;

use App\Entity\Source;
use App\Entity\Project;
use App\Entity\Traduction;
use App\Form\ProjectType;
use App\Form\TraductionType;
use App\Manager\ProjectManager;
use App\Repository\ProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\SourceRepository;
use App\Form\ProjectEditType;
use App\Form\SourceType;
use App\Repository\UserLangueRepository;
use App\Form\SourceFileType;

class ProjectsController extends AbstractController
{
    public function __construct(ProjectManager $em)
    {
        $this->em = $em;
    }

    #[Route('/listing', name: 'listing')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function listing(
        ProjectRepository $projectRepository,
        UserLangueRepository $userLangueRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $projectRepository->findAll();
        $user_id = $this->getUser()->getId();
        $userlangues = $userLangueRepository->findBy(array('user_id' => $user_id));

        $projects = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('projects/listing.html.twig', [
            'data' => $data,
            'projects' => $projects,
            'userlangues' => $userlangues
        ]);
    }

    #[Route('/create', name: 'create')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function create(Request $request, UserInterface $user): Response
    {

        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $project->setUser($user);
            $file = $form->get('source')->getData();

            if (($handle = fopen($file->getPathname(), "r")) !== false) {
                $flag = true;
                while (($data = fgetcsv($handle, 10000, ";")) !== false) {
                    if ($flag) {
                        $flag = false;
                        continue;
                    }

                    $source = new Source();

                    $source->setSourcekey($data[0]);
                    $source->setTranslation($data[1]);
                    $source->setProject($project);
                    $this->em->createSource($source);
                }
            }
            $this->em->createProject($project);
            $this->addFlash(
                'notice',
                'Votre projet est correctement enregistré !'
            );
            return $this->redirectToRoute('listing');
        }

        return $this->render('projects/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/todolist', name: 'todolist')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function todolist(
        ProjectRepository $projectRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $id = $this->getUser()->getId();
        $data = $projectRepository->findBy(array('user' => $id));

        $projects = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('projects/todolist.html.twig', compact('projects'));
    }

    #[Route('/delete/{id}', name: 'delete', methods: ["DELETE"])]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]

    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $this->em->deleteProject($project);
            $this->addFlash(
                'notice',
                'Votre projet a été supprimé !'
            );
        }

        return $this->redirectToRoute('todolist');
    }

    #[Route('/block/{id}', name: 'block')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]

    public function blockProject(int $id, ProjectRepository $projectRepository)
    {
        $project = $projectRepository->find($id);
        $project->setBlock(1);
        $this->em->createProject($project);
        $this->addFlash(
            'notice',
            'Votre projet a été bloqué !'
        );


        return $this->redirectToRoute('todolist');
    }

    #[Route('/active/{id}', name: 'active')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]

    public function activeProject(int $id, ProjectRepository $projectRepository)
    {
        $project = $projectRepository->find($id);
        $project->setBlock(0);
        $this->em->createProject($project);
        $this->addFlash(
            'notice',
            'Votre projet a été débloqué !'
        );

        return $this->redirectToRoute('todolist');
    }


    #[Route('/show/{id}', name: 'show')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]

    public function show(Request $request, int $id, SourceRepository $sourceRepository, ProjectRepository $projectRepository, UserInterface $user): Response
    {
        $sources = $sourceRepository
            ->findBy(array('Project' => $id));
        $projects = $projectRepository
            ->findBy(array('id' => $id));

        $traduction = new Traduction();

        $form = $this->createForm(TraductionType::class, $traduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $project = $projectRepository->findOneBy(array('id' => $id));
            $traduction->setProject($project);
            $this->em->createTraduction($traduction);

            $this->addFlash(
                'notice',
                'Votre traduction est correctement enregistré !'
            );
            return $this->redirectToRoute('listing');
        }

        return $this->render('projects/show.html.twig', [
            'form' => $form->createView(),
            'sources' => $sources,
            'projects' => $projects,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]

    public function edit(Request $request, Project $project, int $id): Response
    {
        $form = $this->createForm(ProjectEditType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->createProject($project);

            $this->addFlash(
                'notice',
                'Votre modification est correctement enregistrée !'
            );
            return $this->redirectToRoute('todolist');
        }

        $source = new Source();

        $form2 = $this->createForm(SourceType::class, $source);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $form2->getData();
            $source->setProject($project);

            $this->em->createSourceOnly($source);

            $this->addFlash(
                'notice',
                'Votre source est correctement enregistrée !'
            );
            return $this->redirectToRoute('edit', [
                'id' => $id,
            ]);
        }


        $form3 = $this->createForm(SourceFileType::class, $source);
        $form3->handleRequest($request);

        if ($form3->isSubmitted() && $form3->isValid()) {

            $form3->getData();
            $file = $form3->get('source')->getData();

            if (($handle = fopen($file->getPathname(), "r")) !== false) {
                $flag = true;
                while (($data = fgetcsv($handle, 10000, ";")) !== false) {
                    if ($flag) {
                        $flag = false;
                        continue;
                    }

                    $source = new Source();

                    $source->setSourcekey($data[0]);
                    $source->setTranslation($data[1]);
                    $source->setProject($project);
                    $this->em->createSource($source);
                }
                $this->em->valideSource();
                $this->addFlash(
                    'notice',
                    'Votre fichier est correctement enregistré !'
                );
                return $this->redirectToRoute('edit', [
                    'id' => $id,
                ]);
            }
        }

        return $this->render('projects/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
        ]);
    }
}
