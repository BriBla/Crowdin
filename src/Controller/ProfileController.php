<?php

namespace App\Controller;

use App\Entity\UserLangue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ProfileType;
use App\Manager\UserLangManager;
use App\Repository\ProjectRepository;
use App\Repository\UserLangueRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    public function __construct(UserLangManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/profile/add", name="profilAdd")
     * IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function profileAdd(Request $request, UserInterface $user): Response
    {
        $user_lang = new UserLangue();

        $form = $this->createForm(ProfileType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_lang->setLangueName($form->get('langue_name')->getData());
            $user_lang->setUserId($user);

            $this->em->createUserLang($user_lang);
            $this->addFlash(
                'notice',
                'Le choix de langue est correctement enregistré !'
            );
            return $this->redirectToRoute('profile');
        }


        return $this->render('profile/profile.add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile", name="profile")
     * IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function profile(Request $request, UserLangueRepository $userLangueRepository): Response
    {
        $user_id = $this->getUser()->getId();

        $langues = $userLangueRepository->findBy(array('user_id' => $user_id));

        return $this->render('profile/profile.html.twig', compact('langues'));
    }

    /**
     * @Route("/profile/stat", name="stats")
     * IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function stats(Request $request, ProjectRepository $projectRepository): Response
    {
        $id = $this->getUser()->getId();

        $data = $projectRepository->findBy(array('user' => $id));

        $total = count($data);

        return $this->render('profile/stat.html.twig', compact('total'));
    }
}