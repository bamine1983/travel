<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserCreationType;
use App\Repository\EmailRepository;
use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use http\Params;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     * @param Request $request
     * @param SettingsRepository $settingsRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param UserRepository $userRepository
     * @param UserAuthenticator $authenticator
     * @param \Swift_Mailer $mailer
     * @param $emailRepository
     * @return Response
     */
    public function inscription(Request $request, SettingsRepository $settingsRepository, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserRepository $userRepository, UserAuthenticator $authenticator, \Swift_Mailer $mailer, EmailRepository $emailRepository):Response
    {
        if ($settingsRepository->find('1')->getInscription()==false){
            return $this->render('/Settings/maintenance.html.twig');
        }
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('password', PasswordType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('Sauvegarder', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                )))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setInscription(new \DateTime());
            $user->setRole("Editeur");
            $user->addRole('ROLE_USER');
            $user->setEtat(false);
            $user->setStatus(true);
            // On génère un token et on l'enregistre
            $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        }

        // On crée le message
        $email1=$emailRepository->findOneByType("Activation");
        $message = (new \Swift_Message('Nouveau compte'))
            // On attribue l'expéditeur
            ->setFrom($email1->getSendFrom())
            // On attribue le destinataire
            ->setTo($user->getEmail())
            // On crée le texte avec la vue
            ->setBody($email1->getMain().
                $this->renderView(
                    'emails/activation.html.twig', ['token' => $user->getActivationToken()]
                ),
                'text/html'
            )
        ;
        $admins=$userRepository->findByRole('Administrateur');
        $email=$emailRepository->findOneByType("Nouveau compte cree");

        foreach ($admins as $admin) {
            $notif = (new \Swift_Message($email->getType()))
                // On attribue l'expéditeur
                ->setFrom($email->getSendFrom())
                // On crée le texte avec la vue
                ->setBody(
                    $email->getMain(),
                    'text/html'
                );
            $notif->setTo($admin->getEmail());
            $phrase = $notif->getBody();
            $healthy = array('$user','$Newuser');
            $yummy = array($admin->getNom()." ".$admin->getPrenom(),$user->getEmail());
            $emailTosend = str_replace($healthy, $yummy, $phrase);
            $notif->setBody($emailTosend);
            //dump($notif);
            $mailer->send($notif);
        }
        $mailer->send($message);
        return $this->render('/inscription/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }


}
