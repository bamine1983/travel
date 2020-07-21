<?php

namespace App\Controller;

use App\Entity\Agences;
use App\Entity\Countries;
use App\Entity\Email;
use App\Entity\Sent;
use App\Entity\Services;
use App\Entity\Settings;
use App\Entity\User;
use App\Form\AgenceCreationType;
use App\Form\GestionEmailsType;
use App\Form\ProfilType;
use App\Form\SettingsType;
use App\Form\UserCreationType;
use App\Repository\AgencesRepository;
use App\Repository\CitiesRepository;
use App\Repository\CountriesRepository;
use App\Repository\EmailRepository;
use App\Repository\PaysRepository;
use App\Repository\SentRepository;
use App\Repository\ServicesRepository;
use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use App\Repository\VillesRepository;
use Doctrine\Persistence\ObjectManager;
use Exception;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\File;

class DashboardController extends Controller
    {
    /**
     * @Route("/dashboard/admin", name="dashboard_admin")
     * @param UserRepository $repository
     * @return Response
     */
    public function indexAdmin()
    {
        return $this->render('dashboard/index.html.twig', [
        ]);
    }
        /**
         * @Route("/dashboard/admin/utilisateurs", name="utilisateurs")
         * @param UserRepository $repository
         * @return Response
         */
        public function utilisateurs(UserRepository $repository)
        {
            $users=$repository->findAll();
            return $this->render('dashboard/utilisateurs.html.twig', [
                'users' =>$users ,
                'admin'=>true
            ]);
        }
        /**
         * @Route("/dashboard/user", name="dashboard_user")
         * @param UserRepository $repository
         * @return Response
         */
        public function indexUser(UserRepository $repository,SettingsRepository $settingsRepository,AgencesRepository $agencesRepository)
        {
            $setting=$settingsRepository->find('1');
            if ($setting->getModeMaintenance()==true)
            {
                if( $this->isGranted('ROLE_USER'))
                {
                    return $this->render('Settings/maintenance.html.twig');
                }
            }
            $users=$repository->findAll();
            $this->getUser()->setLogedAt(new \DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($this->getUser());
            $manager->flush();
            return $this->render('dashboard/index.html.twig', [
                'users' =>$users ,
                'admin'=>false
            ]);
        }

        /**
         * @Route("/dashboard/asmin/agences", name="agences")
         * @param UserRepository $repository
         * @param AgencesRepository $agencesRepository
         * @param VillesRepository $villesRepository
         * @return Response
         */
        public function agenceListing(UserRepository $repository,AgencesRepository $agencesRepository , CitiesRepository $villesRepository,SettingsRepository $settingsRepository)
        {
            $setting=$settingsRepository->find('1');
            if ($setting->getModeMaintenance()==true)
            {

                return $this->render('Settings/maintenance.html.twig');

            }
            $users=$repository->findAll();
            $villes=$villesRepository->findAll();
            $agences=$agencesRepository->findAll();
            //dump($villes);die();
            return $this->render('dashboard/agences.html.twig', [
                'users' =>$users ,
                'agences'=>$agences,
                'villes'=>$villes
            ]);
        }

        /**
         * @Route("/admin/agences/Profil/{id}", name="profil")
         * @param $request
         * @param $repository
         * @return Response
         */
        public function Profil(Request $request,UserRepository $repository,AgencesRepository $agencesRepository,SettingsRepository $settingsRepository)
        {
            $setting=$settingsRepository->find('1');
            if ($setting->getModeMaintenance()==true)
            {
                    return $this->render('Settings/maintenance.html.twig');
            }

            $form = $this->createForm(ProfilType::class);
            $form->handleRequest($request);
            $data=$request->attributes->all();
            $user=$repository->find($data['id']);
            $agence=$agencesRepository->findOneBy(['Utilisateur' => $data['id']]);

            $agences=$agencesRepository->findAll();
            return $this->render('dashboard/Profil.html.twig', [
                'ProfilForm' => $form->createView(),
                'user'=>$user,
                'agences'=>$agences,
                'agence'=>$agence
            ]);

        }

        /**
         * @Route("/dashboard/user/{id}",name="user_profil")
         */
        public function userProfil(Request $request, UserPasswordEncoderInterface $encoder,User $user,\Swift_Mailer $mailer,SettingsRepository $settingsRepository)
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
                    return $this->render('Settings/maintenance.html.twig');
                }
            }
            $users = $this->getDoctrine()->getRepository(User::class);
            $data=$request->attributes->all();
            $Olduser = $users->findOneBy(['id' => $data['id']]);
            $oldPass=$Olduser->getPassword();

            $modif=true;
            if ($this->getUser()==$user){
                $modif=false;
            }
            $form = $this->createForm(UserCreationType::class, $user,['disabled'=>$modif]);
            $form->handleRequest($request);
            $data=$form->getData();
            $params = $request->request->all();
            if ($form->isSubmitted() && $form->isValid()) {
                dump("oldpass".$oldPass);
                $newpass=$params['user_creation']['password'];
                if ($newpass!=$oldPass){
                    $hash = $encoder->encodePassword($user,$newpass);
                    $user->setPassword($hash);
                }
                else{
                    $user->setPassword($oldPass);
                }
                $role=$data->getRole();
                if($role=="Administrateur"){
                    $user->addRole('ROLE_ADMIN');

                }
                elseif ($role=="Editeur"){
                    $user->addRole('ROLE_USER');
                }

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
                //return $this->redirectToRoute('dashboard');
                }
                return $this->render('dashboard/modifier.html.twig', [
                    'form' => $form->createView(),
                    'user'=>$user,
                    'oldpassword'=>$oldPass,

                ]);

        }
    /**
     * @Route("/dashboard/user/Agence/{id}", name="userAgence")
     */
    public function userAgence(Request $request,AgencesRepository $agencesRepository,UserRepository $userRepository,CountriesRepository $paysRepository,CitiesRepository $villesRepository, UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer)
    {
        $data=$request->attributes->all();
        //dump($data['id']);die();
        $user=$userRepository->find($data['id']);
        //dump($user);die();
        $agence=$agencesRepository->findOneByUser($this->getUser());
        $agences = $this->getDoctrine()->getRepository(Agences::class);
        $form = $this->createForm(AgenceCreationType::class, $agence);
        $form->handleRequest($request);
        $data=$form->getData();
        $params = $request->request->all();
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('logo')->getData();
            if (isset($imageFile)){
                $newFilename = md5(uniqid()).'.'.$imageFile->getExtension();
            }
            try {
                if (isset($imageFile)){
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                }
            } catch (FileException $e) {
                dump("error");die();
            }
            if (isset($imageFile)){
                $agence->setLogo($newFilename);
            }
            $ville=$params['Ville'];
            $pays=$params['Pays'];
            $p=$paysRepository->findOneByName($pays);
            $v=$villesRepository->findOneByName($ville);
            $agence->setPays($p);
            $agence->setVille($v);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($agence);
            $manager->flush();
            return $this->redirectToRoute('userAgence',[
                'id'=>$user->getId()
            ]);
        }
        return $this->render('dashboard/modifierAgence.html.twig', [
            'form' => $form->createView(),
            'agence'=>$agence,
            'pays'=>$paysRepository->findAll(),
            'villes'=>$villesRepository->findAll(),
            'user'=>$agence->getUtilisateur()
        ]);
    }
        /**
         * @Route("/dashboard/admin/createUser", name="createUser")
         * @param Request $request
         * @param UserPasswordEncoderInterface $encoder
         * @param \Swift_Mailer $mailer
         * @return Response
         * @throws Exception
         */
        public function createUser(EmailRepository $emailRepository,Request $request,UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
        {
            $user = new User();
            $form = $this->createForm(UserCreationType::class, $user);

            $form->handleRequest($request);
            $data=$form->getData();

            if ($form->isSubmitted() && $form->isValid()) {
                $params = $request->request->all();
                $message=$params['message'];
                //dump($request);die();
                //dump($params['user_creation']['password']);die();
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setEtat(true);
                $user->setStatus(true);
                $role=$data->getRole();
                if($role=="Administrateur"){
                    $user->addRole('ROLE_ADMIN');
                }
                elseif ($role=="Editeur"){
                    $user->addRole('ROLE_USER');
                }

                $email=$emailRepository->findOneByType("Creation du compte");
                $user->setInscription(new \DateTime());
                if($message=="on"){
                    $msg = (new \Swift_Message($email->getType()))
                        ->setFrom($email->getSendFrom())
                        ->setTo($user->getEmail())
                        ->setBody(
                            $email->getMain(),
                            'text/html'
                        )
                    ;
                    $phrase = $msg->getBody();
                    $healthy = array('$user','$email','$password');
                    $yummy = array($user->getNom()." ".$user->getPrenom(),$user->getEmail(),$params['user_creation']['password']);
                    $emailTosend = str_replace($healthy, $yummy, $phrase);
                    $msg->setBody($emailTosend);
                    //dump($emailTosend);die();
                    // On envoie l'e-mail
                    $mailer->send($msg);
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
               // return $this->redirectToRoute('app_afterlogin');
            }

            return $this->render('dashboard/creationUser.html.twig', [
                'form' => $form->createView(),
            ]);
    }
    /**
     * @Route("/dashboard/admin/servicesListing", name="servicesListing")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @return Response
     * @throws Exception
     */
    public function servicesListing(Request $request,ServicesRepository $servicesRepository)
    {
       $services=$servicesRepository->findAll();

        return $this->render('dashboard/servicesListing.html.twig', [
            'services' => $services
        ]);
    }
    /**
     * @Route("/dashboard/admin/createService", name="createService")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @return Response
     * @throws Exception
     */
    public function createService(Request $request, \Swift_Mailer $mailer)
    {
        $service = new Services();
        $form = $this->createFormBuilder($service)
            ->add('name', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('image',FileType::class, [
                'label' => 'Logo (image)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                    ])
                ],
            ])
            ->add('Sauvegarder', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                )))
            ->getForm();

        $form->handleRequest($request);
        $data=$form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($data);die();
            $imageFile = $form->get('image')->getData();
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = md5(uniqid()).'.'.$imageFile->getExtension();

            // Move the file to the directory where brochures are stored
            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                dump("error");die();
            }
            $service->setImage($newFilename);
            $service->setStatus(true);


            /*$email=$emailRepository->findOneByType("Creation du compte");
            $user->setInscription(new \DateTime());
            if($message=="on"){
                $msg = (new \Swift_Message($email->getType()))
                    ->setFrom($email->getSendFrom())
                    ->setTo($user->getEmail())
                    ->setBody(
                        $email->getMain(),
                        'text/html'
                    )
                ;
                $phrase = $msg->getBody();
                $healthy = array('$user','$email','$password');
                $yummy = array($user->getNom()." ".$user->getPrenom(),$user->getEmail(),$params['user_creation']['password']);
                $emailTosend = str_replace($healthy, $yummy, $phrase);
                $msg->setBody($emailTosend);
                //dump($emailTosend);die();
                // On envoie l'e-mail
                $mailer->send($msg);
            }*/
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute('servicesListing');
        }

        return $this->render('dashboard/creationService.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/admin/createAgence", name="createAgence")
     */
    public function createAgence(Request $request,CountriesRepository $paysRepository,CitiesRepository $villesRepository,AgencesRepository $agencesRepository,UserRepository $userRepository)
    {
        $agence = new Agences();
        $form = $this->createForm(AgenceCreationType::class, $agence);
        $form->handleRequest($request);
        $data=$form->getData();
            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('logo')->getData();
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = md5(uniqid()).'.'.$imageFile->getExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dump("error");die();
                }
                $agence->setLogo($newFilename);
                $params = $request->request->all();
                $ville=$params['Ville'];
                $pays=$params['Pays'];
                $p=$paysRepository->findOneByName($pays);
                $v=$villesRepository->findOneByName($ville);
                $u=$params['userAg'];
                $Utilisateur=$userRepository->find($u);
                //dump($userRepository->find($u));die();

                //dump($v);die();
                $agence->setUtilisateur($Utilisateur);
                $agence->setPays($p);
                $agence->setVille($v);
                $agence->setEtat(false);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($agence);
                $manager->flush();
                }

        return $this->render('dashboard/creationAgence.html.twig', [
            'form' => $form->createView(),
            'pays'=>$paysRepository->findAll(),
            'villes'=>$villesRepository->findAll(),
            'users'=>$userRepository->findByExampleField()

        ]);
    }
    /**
     * @Route("/dashboard/admin/editservice/{id}", name="editService")
     */
    public function editService(Request $request,ServicesRepository $servicesRepository,Services $service, \Swift_Mailer $mailer)
    {
        $agences = $this->getDoctrine()->getRepository(Services::class);
        $data=$request->attributes->all();
        $form = $this->createForm(AgenceCreationType::class, $service);
        $form->handleRequest($request);
        $data=$form->getData();
        $params = $request->request->all();
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('logo')->getData();
            //$originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            if (isset($imageFile)){
                $newFilename = md5(uniqid()).'.'.$imageFile->getExtension();
            }
            // Move the file to the directory where brochures are stored
            try {
                if (isset($imageFile)){
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                }
            } catch (FileException $e) {
                dump("error");die();
            }
            if (isset($imageFile)){
                $agence->setLogo($newFilename);
            }
            $ville=$params['Ville'];
            $pays=$params['Pays'];
            $p=$paysRepository->findOneByName($pays);
            $v=$villesRepository->findOneByName($ville);
            $agence->setPays($p);
            $agence->setVille($v);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($agence);
            $manager->flush();
            return $this->redirectToRoute('agences');
        }
        return $this->render('dashboard/modifierAgence.html.twig', [
            'form' => $form->createView(),
            'agence'=>$agence,
            'pays'=>$paysRepository->findAll(),
            'villes'=>$villesRepository->findAll(),
            'user'=>$agence->getUtilisateur()
        ]);
    }

    /**
     * @Route("/dashboard/admin/editAgence/{id}", name="editAgence")
     */
    public function editAgence(Request $request,CountriesRepository $paysRepository,CitiesRepository $villesRepository, UserPasswordEncoderInterface $encoder,Agences $agence,\Swift_Mailer $mailer)
    {
        $agences = $this->getDoctrine()->getRepository(Agences::class);
        $data=$request->attributes->all();
        $form = $this->createForm(AgenceCreationType::class, $agence);
        $form->handleRequest($request);
        $data=$form->getData();
        $params = $request->request->all();
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('logo')->getData();
            //$originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            if (isset($imageFile)){
                $newFilename = md5(uniqid()).'.'.$imageFile->getExtension();
            }
            // Move the file to the directory where brochures are stored
            try {
                if (isset($imageFile)){
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                }
            } catch (FileException $e) {
                dump("error");die();
            }
            if (isset($imageFile)){
                $agence->setLogo($newFilename);
            }
            $ville=$params['Ville'];
            $pays=$params['Pays'];
            $p=$paysRepository->findOneByName($pays);
            $v=$villesRepository->findOneByName($ville);
            $agence->setPays($p);
            $agence->setVille($v);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($agence);
            $manager->flush();
            return $this->redirectToRoute('agences');
        }
        return $this->render('dashboard/modifierAgence.html.twig', [
            'form' => $form->createView(),
            'agence'=>$agence,
            'pays'=>$paysRepository->findAll(),
            'villes'=>$villesRepository->findAll(),
            'user'=>$agence->getUtilisateur()
        ]);
    }
    /**
     * @Route("/dashboard/admin/gestionemail", name="gestionemail")
     * @param EmailRepository $repository
     * @return Response
     */
    public function listeemail(EmailRepository $repository, UserRepository $repo)
    {
        // print_r($this->get('email_service.class')->sendEmail("Subject", "ayoub@wave.ma", "Mail Content 2"));
        $emails = $repository->findAll();
        $users=$repo->findAll();
        return $this->render('dashboard/indexEmail.html.twig', [
            'emails' => $emails,
            'users'=>$users
        ]);
    }
    /**
     * @Route("/dashboard/admin/editeEmail/{id}", name="editeEmail")
     */
    public function editeEmail(Request $request,EmailRepository $emailRepository,Email $email)
    {
        $form = $this->createForm(GestionEmailsType::class, $email,['required'=>false]);
        $form->handleRequest($request);
        $data=$form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($data);die();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($email);
            $manager->flush();
            return $this->redirectToRoute('gestionemail');
        }
        return $this->render('dashboard/Email.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/admin/gestionemail/sendEmail",name="sendEmail")
     * @param Request $request
     */
    public function sendEmail(Request $request,UserRepository $userRepository,EmailRepository $emailRepository,\Swift_Mailer $mailer)
    {
        $req=$request->request->keys();
        $id=$req[0];
        $emails=$request->request->all();
        $params=$request->request->keys();
        $idEmail=$emailRepository->find($emails[$id]);
        foreach($params as $param){
            $sent=new Sent();
            $user=$userRepository->find($param);
            $manager = $this->getDoctrine()->getManager();
            $sent->setDateEnvoie(new \DateTime());
            $sent->setIdEmail($idEmail);
            $sent->setIdUser($user);
            $manager->persist($sent);
            $manager->flush();

            $msg = (new \Swift_Message($idEmail->getType()))
                ->setFrom('votre@adresse.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $idEmail->getMain(),
                    'text/html'
                )
            ;
            // On envoie l'e-mail
            $mailer->send($msg);
         }
       return $this->redirectToRoute('gestionemail');
    }
    /**
     * @Route("/dashboard/admin/edit/{id}", name="editUser")
     */
    public function editUser(Request $request, UserPasswordEncoderInterface $encoder,User $user,\Swift_Mailer $mailer)
    {
        $users = $this->getDoctrine()->getRepository(User::class);
        $data=$request->attributes->all();
        $Olduser = $users->findOneBy(['id' => $data['id']]);
        $oldPass=$Olduser->getPassword();

        $form = $this->createForm(UserCreationType::class, $user,['required'=>false]);
        $form->handleRequest($request);
        $data=$form->getData();
        $params = $request->request->all();
        if ($form->isSubmitted() && $form->isValid()) {
           // dump("oldpass".$oldPass);
            $newpass=$params['user_creation']['password'];
            if ($newpass!=$oldPass){
                $hash = $encoder->encodePassword($user,$newpass);
                $user->setPassword($hash);
            }
            else{
                $user->setPassword($oldPass);
            }
            $role=$data->getRole();
            if($role=="Administrateur"){
                $user->addRole('ROLE_ADMIN');

            }
            elseif ($role=="Editeur"){
                $user->addRole('ROLE_USER');
            }
            /*if($message=="on"){
                $msg = (new \Swift_Message('Creation Compte'))
                    ->setFrom('votre@adresse.fr')
                    ->setTo($user->getEmail())
                    ->setBody(
                        "Bonjour,<br><br>Bonjour Un compte est créé pour vous, merci de se connecter en cliquant sur le lien suivant : <a href='127.0.0.1:8000'>Se Connecter</a><br>
                                    Vos Cordonnées D'authentification: <br><label for='email'></label><b id='email'>".$user->getEmail()."</b><br><label for='password'><b>".$params['user_creation']['password']."</b></label>",
                        'text/html'
                    )
                ;
                // On envoie l'e-mail
                $mailer->send($msg);
            }*/

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            //return $this->redirectToRoute('dashboard');
        }
        return $this->render('dashboard/modifier.html.twig', [
            'form' => $form->createView(),
            'user'=>$user,
            'oldpassword'=>$oldPass,
            'firstlog'=>false
        ]);
    }
    /**
     * @Route("/dashboard/admin/gestionemail/getuser/{type}",name="gestionemailuser")
     * @param Request $request
     * @param EmailRepository $emailRepository
     * @param UserRepository $userRepository
     */
    public function EmailUser(Request $request, EmailRepository $emailRepository,  UserRepository $userRepository)
    {
        $response = array();
        $users = $userRepository->findAll();
        $emails = $emailRepository->findAll();

        foreach ($emails as $email) {
            foreach ($users as $user) {
                if ($user->getRole() == $request->attributes->get('type') && $email->getUser() == $request->attributes->get('type')) {

                    array_push($response, $user);

                } elseif ($user->getRole() == $request->attributes->get('type') && $email->getUser() == $request->attributes->get('type')) {

                    array_push($response, $user);
                }
            }
        }
        //dump($response);die();
        return $this->json(['code' => 200, 'table' => $response], 200);
    }

    /**
     * @Route("/dashboard/admin/user/{id}/isActive", name="isActive")
     * @param UserRepository $repository
     * @return Response
     */
    public function isActive(User $user,Request $request,UserRepository $repository,AgencesRepository $agencesRepository)
    {
        $data=$request->attributes->all();
        $user=$data['user'];

        if($user->getEtat()==true){
            $user->setEtat(false);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->json(['code'=>200,'etat'=>'false','userid'=>$user->getId()],200);
        }
        elseif ($user->getEtat()==false){
            $user->setEtat(true);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->json(['code'=>200,'etat'=>'true','userid'=>$user->getId()],200);
        }
        else{ return $this->json(['code'=>403,'message'=>'erro'],200);}

    }

        /**
         * @Route("dashboard/admin/agences/{id}/isAGactive", name="isAGactive")
         * @param AgencesRepository $repository
         * @return Response
         */
        public function isAGative(Agences $agence,Request $request,AgencesRepository $agencesRepository)
        {
            $data=$request->attributes->all();
            // dump($data);die();
            $agence=$data['agence'];
            if($agence->getEtat()==true){
                $agence->setEtat(false);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($agence);
                $manager->flush();
                return $this->json(['code'=>200,'etat'=>'false','agenceid'=>$agence->getId()],200);
            }
            elseif ($agence->getEtat()==false){
                $agence->setEtat(true);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($agence);
                $manager->flush();
                return $this->json(['code'=>200,'etat'=>'true','agenceid'=>$agence->getId()],200);
            }
            else{ return $this->json(['code'=>403,'message'=>'erro'],200);}

        }
        /**
         * @Route("/genegerPass", name="genPass")
         */
        public function generatePassword()
        {
                $characters = 'abcdefghijklmnopqrstuvwxyz';
                $num = '0123456789';
                $charmaj='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $numLength = strlen($num);
                $charmajLength = strlen($charmaj);
                $randomString = '';
                for ($i = 0; $i < 3; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)].$num[rand(0, $numLength - 1)].$charmaj[rand(0, $charmajLength - 1)];
                }
                //dump($randomString);die();
                return $this->json(['code'=>200,'RandPass'=>$randomString],200);
        }

        /**
         * @Route("/dashboard/admin/settings", name="settings")
         */
        public function settings(Request $request,SettingsRepository $settingsRepository)
        {
            //dump('test');die();
            $data=$request->attributes->all();
            $setting = $settingsRepository->find('1');
            $form = $this->createForm(SettingsType::class, $setting);
            $form->handleRequest($request);
            $data=$form->getData();
            $params = $request->request->all();
            if ($form->isSubmitted() && $form->isValid()){

                    $logoFile = $form->get('Logo')->getData();
                    $faviconFile = $form->get('Favicon')->getData();
                    //$originallogo = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                    //$originalfavicon = pathinfo($faviconFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    if (isset($logoFile)){
                        $newLogo = md5(uniqid()).'.'.$logoFile->getExtension();
                    }
                    if (isset($faviconFile)){
                        $newFavicon = md5(uniqid()).'.'.$faviconFile->getExtension();
                    }


                    // Move the file to the directory where brochures are stored
                    try {
                        if (isset($logoFile)){
                            $logoFile->move(
                                $this->getParameter('images_directory'),
                                $newLogo
                            );
                        }
                        if (isset($faviconFile)){
                            $faviconFile->move(
                                $this->getParameter('images_directory'),
                                $newFavicon
                            );
                        }
                    } catch (FileException $e) {
                        dump("error");die();
                    }
                if (isset($logoFile)){
                    $setting->setLogo($newLogo);
                }
                if (isset($faviconFile)){
                    $setting->setFavicon($newFavicon);
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($setting);
                $manager->flush();
                //dump($setting);die();
            }

            return $this->render('dashboard/settings.html.twig',[
               'setting'=>$setting,
                'form'=>$form->createView()
            ]);

        }

        /**
         * @Route("dashboard/admin/settings/maintenance", name="maintenance")
         * @param Request $request
         * @param SettingsRepository $settingsRepository
         * @param $event
         * @return \Symfony\Component\HttpFoundation\JsonResponse
         */
        public function maintenance(Request $request, SettingsRepository $settingsRepository)
        {

            $setting=$settingsRepository->find('1');
           // dump($setting);die();
            if($setting->getModeMaintenance()==true){
                $setting->setModeMaintenance(false);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($setting);
                $manager->flush();
                return $this->json(['code'=>200,'ModeMaintenance'=>'false'],200);
            }
            elseif ($setting->getModeMaintenance()==false){
                $setting->setModeMaintenance(true);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($setting);
                $manager->flush();
               return $this->json(['code'=>200,'ModeMaintenance'=>'true'],200);

            }
            return $this->json(['code'=>403,'message'=>'erro'],200);

        }
    /**
     * @Route("dashboard/admin/settings/isInscriptionActive", name="isInscriptionActive")
     * @param Request $request
     * @param SettingsRepository $settingsRepository
     * @param $event
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function isInscriptionActive(Request $request, SettingsRepository $settingsRepository)
    {

        $setting=$settingsRepository->find('1');
        // dump($setting);die();
        if($setting->getInscription()==true){
            $setting->setInscription(false);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($setting);
            $manager->flush();
            return $this->json(['code'=>200,'inscription'=>'false'],200);
        }
        elseif ($setting->getInscription()==false){
            $setting->setInscription(true);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($setting);
            $manager->flush();
            return $this->json(['code'=>200,'inscription'=>'true'],200);

        }
        return $this->json(['code'=>403,'message'=>'erro'],200);

    }
        /**
         * @Route("/paysDiv/{pays}",name="paysDiv")
         * @param Request $request
         * @param VillesRepository $villesRepository
         * @param PaysRepository $paysRepository
         */
        public function paysDiv(Request $request,VillesRepository $villesRepository,PaysRepository $paysRepository)
        {
            $country=array();
            $pays=$paysRepository->findByName($request->attributes->get('pays'));
            $villes=$villesRepository->findByPays($pays);
            foreach ($villes as $ville)
            {
                array_push($country,$ville->getNomVille());
            }
            return $this->json(['code'=>200,'villes'=>$country],200);
        }

    /**
     * @Route("/forcer", name="forcer")

     * @param SettingsRepository $settingsRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function forcer( SettingsRepository $settingsRepository)
    {
        $setting = $settingsRepository->find('1');
        if ($setting->getModeMaintenance() == true)
            {
                //$template = $this->render('Settings/maintenance.html.twig');

                // We send our response with a 503 response code (service unavailable)
                //$event->setResponse(new Response('site down',Response::HTTP_SERVICE_UNAVAILABLE));
                //  $event->stopPropagation();
                return $this->render('Settings/maintenance.html.twig');
            }
    }
    /**
     * @Route("/dashboard/admin/user/{id}/supp", name="suppUser")
     * @param UserRepository $repository
     * @return Response
     */
    public function suppUser(User $user,Request $request,UserRepository $repository,AgencesRepository $agencesRepository,SentRepository $sentRepository)
    {

        $data=$request->attributes->all();
        $user=$data['user'];
        $manager = $this->getDoctrine()->getManager();
        $agence=$agencesRepository->findOneByUser($user);
        $sents=$sentRepository->findByUser($user);
        foreach($sents as $sent){
            $manager->remove($sent);
        }
        if(isset($agence)){
            $manager->remove($agence);
            $manager->remove($user);


        }else{
            $manager->remove($user);
            $manager->flush();
        }
        $manager->flush();
         return $this->json(['code'=>403,'message'=>'success'],200);

    }
    /**
     * @Route("/dashboard/admin/user/{id}/archive", name="archiveUser")
     * @param UserRepository $repository
     * @return Response
     */
    public function archiveUser(User $user,Request $request,UserRepository $repository,AgencesRepository $agencesRepository)
    {
            $data=$request->attributes->all();
            $user=$data['user'];
            //dump($user);die();
            $user->setStatus(false);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

         return $this->json(['code'=>403,'message'=>'success'],200);
    }

  }
