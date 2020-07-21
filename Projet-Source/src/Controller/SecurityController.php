<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgottenpassType;
use App\Form\ResetPassType;
use App\Form\ValidationCodeType;
use App\Repository\EmailRepository;
use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request,AuthenticationUtils $authenticationUtils): Response
    {
        //dump($this->getUser());
        if ($this->getUser()) {
            $token = new UsernamePasswordToken($this->getUser(), null, 'main', $this->getUser()->getRooles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            if ($this->isGranted('ROLE_ADMIN')) {
                if($this->getUser()->getLogedat())
                return $this->redirect($this->generateUrl('dashboard_admin'));
            }
            if ($this->isGranted('ROLE_USER')) {
                //dump($this->getUser()->getLogedat());die();
                return $this->redirect($this->generateUrl('dashboard_user'));
            }
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/dashboard", name="app_afterlogin")
     * @param AuthenticationUtils $authenticationUtils
     * @param SettingsRepository $settingsRepository
     * @param $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function afterlogin(AuthenticationUtils $authenticationUtils, SettingsRepository $settingsRepository)
    {
        $setting=$settingsRepository->find('1');
        if ($setting->getModeMaintenance()==true)
        {
          if( $this->isGranted('ROLE_ADMIN'))
           {
               return $this->redirectToRoute('settings');
           }
          else
          {
              //$template = $this->render('Settings/maintenance.html.twig');

              // We send our response with a 503 response code (service unavailable)
              //$event->setResponse(new Response('site down',Response::HTTP_SERVICE_UNAVAILABLE));
            //  $event->stopPropagation();
              return $this->render('Settings/maintenance.html.twig');
          }
        }

        if ($this->getUser()) {
            $lasstlog = $this->getUser()->getLogedAt();

            //dump($this->getUser()->getLogedAt());die();

            if (isset($lasstlog)) {
                if ($this->isGranted('ROLE_ADMIN')) {
                    $this->getUser()->setLogedAt(new \DateTime());
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($this->getUser());
                    $manager->flush();
                    return $this->redirectToRoute('dashboard_admin');
                }
                if ($this->isGranted('ROLE_USER')) {
                    $this->getUser()->setLogedAt(new \DateTime());
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($this->getUser());
                    $manager->flush();
                    return $this->redirectToRoute('dashboard_user');
                }

            } else {
                if ($this->isGranted('ROLE_ADMIN')) {
                    $this->getUser()->setLogedAt(new \DateTime());
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($this->getUser());
                    $manager->flush();
                    return $this->redirectToRoute('dashboard_admin');
                }
                if ($this->isGranted('ROLE_USER')) {
                    $this->getUser()->setLogedAt(new \DateTime());
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($this->getUser());
                    $manager->flush();

                    return $this->redirectToRoute('user_profil', [
                        'id' => $this->getUser()->getId()
                    ]);
                }
            }
        }
        return $this->redirectToRoute('app_login');
    }
    /**
     * @Route("/Remail", name="app_remail")
     */
    public function Remail(Request $request,ObjectManager $manager,UserRepository $users,\Swift_Mailer $mailer,EmailRepository $emailRepository): Response
    {
        if ($this->getUser()) {
            $token = new UsernamePasswordToken($this->getUser(), null, 'main', $this->getUser()->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('dashboard_admin'));
            }
            else{
                return $this->redirect($this->generateUrl('app_login'));
            }
        }
        //initialisatoin Emailform du form qui contient une seule input de type email
        $form = $this->createForm(ForgottenpassType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //recuperation de lemail envoyé
            $donnees = $form->getData();
            //la recherche de l email
            $user = $users->findOneByEmail($donnees->getEmail());
            // si aucun user a cet email on l e renvoit vers la mm page
            if ($user === null) {
                echo "<script>alert(\"l'adresse de courriel saisie n'existe pas sur notre base de données,veuillez la verifier puis réessayer \")
                   </script>";
                return $this->render('security/Email.html.twig', [
                    'emailForm' => $form->createView()
                ]);
            }
            // sinon on lui genere un f=token a six chiffre
            $forgotten_token=random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9);
           // $forgotten_token="123456";
            $encoded =md5($forgotten_token);
            $user->setForgottenPassToken($encoded);

            $date=new \DateTime();
            $user->setForgottenPassExpiration($date);
            $date->modify('+120 seconds');
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            // envoi de l email  de confirmation
            $email=$emailRepository->findOneByType("Code de reinitiation");

            $message = (new \Swift_Message($email->getType()))
                ->setFrom($email->getSendFrom())
                ->setTo($user->getEmail())
                ->setBody(
                    $email->getMain(),
                    'text/html'
                )
            ;
            $phrase = $message->getBody();
            $healthy = array('$user');
            $yummy = array($user->getEmail());
            $emailTosend = str_replace($healthy, $yummy, $phrase);
            $message->setBody($emailTosend);
            //envoi de l email de recuperation de mdp
            $email2=$emailRepository->findOneByType("Confirmation code");

            $message2 = (new \Swift_Message($email2->getType()))
                ->setFrom($email2->getSendFrom())
                ->setTo($user->getEmail())
                ->setBody(
                    $email2->getMain(),
                    'text/html'
                )
                ;
            $phrase = $message2->getBody();
            $healthy = array('$user','$forgotten_token');
            $yummy = array($user->getNom()." ".$user->getPrenom(),$forgotten_token);
            $emailTosend = str_replace($healthy, $yummy, $phrase);
            $message2->setBody($emailTosend);
            dump($message2);dump($message);die();
            $mailer->send($message);$mailer->send($message2);
            // si les emails ont ete envoyé je le redirige vers la page validationcode.html.twig pr saisir le token qu'il vient de recevoir passant sont id pr verification

           if ( $mailer->send($message) && $mailer->send($message2)){

               return $this->redirectToRoute('validationCode',[
                   'id'=>$user->getId()
               ]);
           }

        }
        return $this->render('security/Email.html.twig', [
            'emailForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/Remail/validation/{id}",name="validationCode")
     * @param Request $request
     */
    public function validationCode(Request $request,UserRepository $repository)
    {
        $form = $this->createForm(ValidationCodeType::class);
        $form->handleRequest($request);
        $data=$request->attributes->all();
        $user=$repository->find($data['id']);
        if ($form->isSubmitted() && $form->isValid()) {

            $params = $request->request->all();
            $data=$params['validation_code'];
            $code=md5($data['code']);
            $confirmationCode =$user->getForgottenPassToken();
            $CurrentDate=new \DateTime();
        //    $Period=$CurrentDate->diff($user->getForgottenPassExpiration(),false);

           // dump($Period->i);
            //dump($Period->s);die();

            $diff = $user->getForgottenPassExpiration()->getTimestamp() - $CurrentDate->getTimestamp();
            //dump($diff);die();
          if ($diff>0 && $diff<120)
          {
              if($code==$confirmationCode){

                  return $this->redirectToRoute('app_reset_password',[
                      'code'=>$confirmationCode
                  ]);
              }
              else
              {
                  echo "<script>alert(\"Code de validation incorrect  Réssayez à nouveau \")
                   </script>";
              }
            }
            else{
                echo "<script>alert(\"Durée de ce code de validation a été expirée  Réssayez à nouveau \")
                   </script>";
            }
        }
        return $this->render('security/validationCode.html.twig', [
            'ConfirmForm' => $form->createView()
        ]);
    }
    /**
     * @Route("Remail/reset_pass/{code}", name="app_reset_password")
     */
    public function resetPassword(Request $request, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder,\Swift_Mailer $mailer)
    {
        // On cherche un utilisateur avec le token donné
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);
        //dump($form);die();
        $data=$request->attributes->all();
        $user=$repository->findOneBy(array('forgottenPass_token' => $data['code']));
        //dump($user);die();
        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur

            return $this->redirectToRoute('app_login');
        }

        // Si le formulaire est envoyé en méthode post
        if ($request->isMethod('POST')) {
            // On supprime le token
            $user->setForgottenPassToken(null);
            $user->setForgottenPassExpiration(null);
            $params=$request->request->all();
            $pass=$params['reset_pass'];
            // dump($pass['password']);die();
            $user->setPassword($passwordEncoder->encodePassword($user, $pass['password']));

            // On stocke
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // On le connecte automatiquement apres la saisie du mdp

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRooles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
            return $this->redirect($this->generateUrl('app_afterlogin'));
            // On redirige vers la page de connexion
            //return $this->redirectToRoute('app_login');
        }else {
            // Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('security/resetPass.html.twig');
        }

        return $this->render('security/resetPass.html.twig', [
            'ResetForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/activation", name="activation")
     */
    public function activation(Request $request):Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        // On recherche si un utilisateur avec ce token existe dans la base de données
        $users = $this->getDoctrine()->getRepository(User::class);
        $user = $users->findOneBy(['activationToken' => $request->query->get('token')]);
        //dump($user);die();

        // Si aucun utilisateur n'est associé à ce token
        if(!$user){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        // On supprime le token
        $user->setActivationToken(null);
        $user->setEtat(true);
        $entityManager->persist($user);
        $entityManager->flush();

        // On génère un message
        $this->addFlash('message', 'Utilisateur activé avec succès');

        // On le connecte automatiquement apres la saisie du mdp

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        return $this->redirect($this->generateUrl('app_afterlogin'));

        // On retourne à l'accueil
        //return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
       // return $this->redirectToRoute('app_login');
    }

}