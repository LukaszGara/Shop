<?php

    namespace App\Controller;

    use App\Entity\Profile;
    use App\Entity\Products;
    use App\Entity\Purchase;
    use App\Entity\ShoppingCart;
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
    //Home page 
    #[Route('/', name: 'app')]
    public function index(): Response
    {
    //find all products
        $items = $this->getDoctrine()->getRepository(Products::class)->findAll();
        return $this->render('app/index.html.twig', [
            'items' => $items
        ]);
    }
    /**
     * @Route("/current/{user}", name="profile")
     */

    //finds informations about logged user and his purchase history
    public function profile(string $user)
    {
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findprofile($user);
        $history = $this->getDoctrine()->getRepository(Purchase::class)->findhistory($user);
        $current = $this->getUser();
        
        return $this->render('app/profile.html.twig', [
            'profile' => $profile,
            'history' => $history
        ]);
    }
    /**
     * @Route("/profile/add", name="profile_add")
     * @Method({"GET", "POST"})
     */

    // add new profile for logged user
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
        
        //upload image and insert informations about profile into database
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
     * @Route("/profile/edit/{id}", name="profile_edit")
     * @Method({"GET", "POST"})
     */
    //edit profile for current user
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

        //check form validation and save data in database
        if($form->isSubmitted() && $form->isValid()){
        
            
            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->flush();

            return $this->redirectToRoute('app');
        }

        return $this->render('app/profile_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/item/{id}", name="item")
     * @Method({"GET"})
     */

     // finding all information about selected product
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
     * @Route("/item/add/{profile}", name="item_add")
     * @Method({"GET", "POST"})
     */

     // put the product up for sale 
    public function additem( Request $request, int $profile)
    {

        $profile = $this->getDoctrine()->getRepository(Profile::class)->find($profile);
        $item = new Products();
        $item->setSeller($profile);

        $form = $this->createFormBuilder($item)
        ->add('name', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('amount', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('price', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('category', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('image', FileType::class, 
        array('attr' =>array('class' => 'form-control', 'mapped' => false)))
        ->add('description', TextType::class, 
        array('attr' =>array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
            'label' => 'List',
            'attr' =>array('class' => 'btn btn-primary my-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            //upload image and insert product into databse
            $file = $request->files->get('form')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension(); 
            $file->move(
                $uploads_directory,
                $filename
            );
            $item->setImage($filename);
            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->persist($item);
            $entityManeger->flush();

            return $this->redirectToRoute('app');
        }

        return $this->render('app/item_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
     /**
     * @Route("/cart", name="cart")
     * @Method({"GET"})
     */

     //dispaly cart for logged user
    public function cart()
    {
        if ( $this->getUser() !== null ){
            $id = $this->getUser()->getId();
            $profile = $this->getDoctrine()->getRepository(Profile::class)->findProfileUser($id);
            $profile = $profile[0]['id'];
            $cart = $this->getDoctrine()->getRepository(ShoppingCart::class)->findCart($profile);
            $totalprice = 0;
        //total cost calculation
            foreach($cart as $carts){
                settype($carts['price'], 'int');
                settype($carts['amount'], 'int');
                $price = $carts['price'] * $carts['amount'];
                $totalprice += $price;
            }

            return $this->render('app/shopping_cart.html.twig', [
                'cart' => $cart,
                'price' => $totalprice 
            ]);
        } else {
            return $this->render('app/please_login.html.twig', []);
        }
    }
     /**
     * @Route("/cart/add/{item}", name="cart_add")
     * @Method({"GET", "POST"})
     */
    // add new item to cart
    public function cartAdd(int $item)
    {
        if ( $this->getUser() !== null ){
            $user = $this->getUser()->getId();
            $profile = $this->getDoctrine()->getRepository(Profile::class)->findOneBy(['user' => $user]);
            $item_products = $this->getDoctrine()->getRepository(Products::class)->find($item);
            $cart = new ShoppingCart();
            $cart->setProfile($profile);
            $cart->addItem($item_products);

            $entityManeger = $this->getDoctrine()->getManager();
            $entityManeger->persist($cart);
            $entityManeger->flush();

            return $this->redirectToRoute('item', ['id' => $item]);
        } else {
            return $this->render('app/please_login.html.twig');
        }
    }
    /**
     * @Route("/cart/delete/{item}", name="cart_delete")
     * @Method({"GET", "POST"})
     */

    //remove item from cart
    public function cartDelete(Request $request, int $item)
    {
        $user = $this->getUser()->getId();
        $profile = $this->getDoctrine()->getRepository(Profile::class)->find($user)->getId();
        $item_products = $this->getDoctrine()->getRepository(Products::class)->find($item);
        
        $entityManeger = $this->getDoctrine()->getRepository(ShoppingCart::class);
        $entityManeger->removeCart($item, $profile);

        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/seller/{user}", name="seller")
     */
    // page with info abuot seller 
    public function seller(string $user)
    {
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findprofile($user);
        $profile1 = $profile[0]['id'];
        $history = $this->getDoctrine()->getRepository(Purchase::class)->findsellhistory($profile1);
        $current = $this->getUser();
        
        return $this->render('app/seller.html.twig', [
            'profile' => $profile,
            'history' => $history
        ]);
    }
     /**
     * @Route("/buy", name="buy")
     * @Method({"GET", "POST"})
     */
    public function buy()
    {
        $user = $this->getUser();
        if ( $user !== null ){

            // finding ifno about logged user and products in his cart
             $id = $user->getId();
             $profile = $this->getDoctrine()->getRepository(Profile::class)->findProfileUser($id);
             $profile = $profile[0]['id'];
             $cart = $this->getDoctrine()->getRepository(ShoppingCart::class)->findCart($profile);
             foreach ($cart as $carts) {
                //find info about amount of each product and info about seller 
                 $amount = $carts['amount'];
                 $product = $carts['id'];
                 $seller = $carts['seller_id'];
                 $product1 = $this->getDoctrine()->getRepository(Products::class)->find($product);
                 $seller1 = $this->getDoctrine()->getRepository(Profile::class)->find($seller);
                // add transaction information to database
                 $purchase = new Purchase();
                 $purchase->setUser($user);
                 $purchase->setProduct($product1);
                 
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($purchase);
                 $entityManager->flush();
                //update product quantity and clear user cart
                 $entityManager = $this->getDoctrine()->getRepository(ShoppingCart::class);
                 $entityManager->buy($amount, $product);
                 $entityManager->removeCart($product, $profile);    
            }
             
            return $this->redirectToRoute('app');
        } else {
            return $this->render('app/please_login.html.twig');
        }
    }
}
