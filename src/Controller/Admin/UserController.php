<?php

namespace App\Controller\Admin;

use LDAP\Result;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/user')]
#[IsGranted("ROLE_INFO_ADMIN")]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>"Non Lu", 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'messages' => $messages,
            'notifications'=> $notifications
        ]);
    }

    #[Route('/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, UserRepository $userRepository,UserPasswordHasherInterface $passwordHasher, NotificationRepository $notificationRepository,): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $password="passe123";
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setNbConnect(0);
            $user->setPassword(
                $passwordHasher->hashPassword(
                        $user,
                        $password
                    )
                );
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'messages' => $messages,
            'notifications'=> $notifications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_show', methods: ['GET'])]
    public function show(User $user,MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'messages' => $messages,
            'notifications'=> $notifications
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user,MessagesRepository $messagesRepository, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $password = $user->getPassword();
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'messages' => $messages,
            'notifications' => $notifications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_user_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, User $user, UserRepository $userRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/user/delete.html.twig',[
            'user'=>$user,
            'messages' => $messages,
            'notifications'=>$notifications,
        ]);
    }

}
