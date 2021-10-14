<?php

    namespace App\Controller;

    use App\Entity\Profile;
    use App\Entity\Products;
    use App\Entity\Purchase;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class AppController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index(): Response
    {
        $items = $this->getDoctrine()->getRepository(Products::class)->findAll();
        return $this->render('app/index.html.twig', [
            'items' => $items
        ]);
    }
    /**
     * @Route("/profile/add", name="profile_add")
     * @Method({"GET", "POST"})
     */

    public function addprofile( Request $request)
    {

        $user = $this->getUser();
        $profile = new Profile();
        $profile->setUser($user);

        $form = $this->createFormBuilder($profile)
        ->add('nick', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('name', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('surname', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('avatar', FileType::class, 
        array('attr' =>array('class' => 'form-control', 'mapped' => false)))
        ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' =>array('class' => 'btn btn-primary my-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        
            $file = $request->files->get('form')['avatar'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension(); 
            $file->move(
                $uploads_directory,
                $filename
            );
            $profile->setAvatar($filename);
            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->persist($profile);
            $entityManeger->flush();

            return $this->redirectToRoute('app');
        }

        return $this->render('app/profile_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/item/{id}", name="item")
     * @Method({"GET", "POST"})
     */

    public function showitem( int $id)
    {
        $item = $this->getDoctrine()->getRepository(Products::class)->find($id);
        $seller = $this->getDoctrine()->getRepository(Products::class)->findseller($id);


        return $this->render('app/item_page.html.twig', [
            'item' => $item, 
            'seller' => $seller
        ]);
    }
    /**
     * @Route("/current/{user}", name="profile")
     */

    public function profile(string $user)
    {
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findprofile($user);
        $history = $this->getDoctrine()->getRepository(Purchase::class)->findhistory($user);

        return $this->render('app/profile.html.twig', [
            'profile' => $profile,
            'history' => $history
        ]);
    }
    /**
     * @Route("/profile/edit/{id}", name="profile_edit")
     * @Method({"GET", "POST"})
     */
    public function editprofile(string $id, Request $request)
    {
        $user = $this->getUser();
        $profile = new Profile();
        $profile->setUser($user);
        
        $profile = $this->getDoctrine()->getRepository(Profile::class)->find($id);
        $form = $this->createFormBuilder($profile)
        ->add('nick', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('name', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('surname', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' =>array('class' => 'btn btn-primary my-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        
            
            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->flush();

            return $this->redirectToRoute('app');
        }

        return $this->render('app/profile_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
