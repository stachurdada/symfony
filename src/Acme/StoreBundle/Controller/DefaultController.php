<?php

namespace Acme\StoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\Category;
use Acme\StoreBundle\Entity\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => $name));
    }


    public function createAction()
    {
        $product = new Product();
        $product->setName("Produkt testowy");
        $product->setDescription("opis produktu");
        $product->setPrice("19.22");

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response("utworzono produkt o id: ".$product->getId());

    }

    public function showAction($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product');


        $product = $repository->find($id);

        $category = "";//$product->getCategory()->getName();

        if (!$product)
        {
             throw $this->createNotFoundException( 'No product found for id '.$id );
        }

        $products = $repository->findAll();


        return $this->render("AcmeStoreBundle:Default:product.html.twig",array("product"=>$product,"products"=>$products,"category"=>$category));
    }


    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);


        $product->setName("Nowa nazwa produktu");
        $em->flush();


        return $this->render("AcmeStoreBundle:Default:product.html.twig",array("product"=>$product));
    }


    public function getProductsByPriceAction($price)
    {
//        $em = $this->getDoctrine()->getManager();
//        $query = $em->createQuery('SELECT p FROM AcmeStoreBundle:Product p WHERE p.price > :price ORDER BY p.price ASC');
//        $query->setParameter("price",$price);
//
//        $products = $query->getResult();


        //$repository = $this->getDoctrine()->getRepository("AcmeStoreBundle:Product");

//        $query = $repository->createQueryBuilder("p")
//            ->where('p.price > :price')
//            ->orderBy('p.price', 'ASC')
//            ->setParameter('price', $price)
//            ->getQuery();
//
//        $products = $query->getResult();


        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("AcmeStoreBundle:Product")->findAllOrderedByName();

        return $this->render("AcmeStoreBundle:Default:products.html.twig",array("products"=>$products));
    }


    public function createProductAction()
    {
        $category = new Category();
        $category->setName("Rowery");

        $product = new Product();
        $product->setName("Rower biegowy");
        $product->setPrice(230.44);
        $product->setDescription("opis rowerka");

        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);

        $em->flush();


        return $this->render("AcmeStoreBundle:Default:Product.html.twig",array("product"=>$product));
    }

    public function showProductsByCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository('AcmeStoreBundle:Category')->find($id);

        // Zwraca obiekty proxy ktore zamieniaja sie na normalne dopiero gdy bedziemy wykonywac na nich operacje np $product->getname()
        $products = $category->getProducts();

        return $this->render("AcmeStoreBundle:Default:Products.html.twig",array("products"=>$products));
    }


    public function getProductWithCategoryJoinedAction($id)
    {
        $query = $this->getDoctrine()->getManager()->createQuery(
            'SELECT p, c FROM AcmeStoreBundle:Product p
            LEFT JOIN p.category c
            WHERE p.id = :id');

        $query->setParameter("id",$id);
        $products = $query->getResult();


        return $this->render("AcmeStoreBundle:Default:Products.html.twig",array("products"=>$products));
    }


}
