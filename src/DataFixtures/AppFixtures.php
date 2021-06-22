<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\OrderLine;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // Créer 2 Catégories
        $category1 = (new Category())->setLabel("fruit");
        $category2 = (new Category())->setLabel("exotic");
        //setProduct
        $manager->persist($category1, $category2);

        // Créer 1 Images
        $picture = new Picture();
        $picture
            ->setUrl("https://dummyimage.com/200x100.png")
            ->setDescription("iezfj");
        $manager->persist($picture);

        // Créer 3 Produits
        $products = [
            "Banana" => 3,
            "Apple" => 2,
            "Grapes" => 4
        ];

        $productEntity = [];

        foreach ($products as $k => $v) {
            $fruit = new Product();
            $fruit
                ->setTitle($k)
                ->setPrice($v)
                ->setRef("773894")
                ->setDescription("tasty fruit")
                ->setInStock(true)
                ->setStockQuantiy(42)
                ->setCategory($category1)
                ->addPicture($picture);

            $productEntity[] = $fruit;
            $manager->persist($fruit);
        }

        // Créer 1 Utilisateur
        $user = new User();
        $user
            ->setEmail("banana@jokes.com")
            ->setPassword("zeiopjJIO%ZEOIJ")
            ->setCreatedAt(new \DateTime())
            ->setFirstName("Joe")
            ->setLastName("Crazy");
        $manager->persist($user);

        // Créer 2 Lignes de commandes
        $orderLine = new OrderLine();
        $orderLine
            ->setQuantity(34);
        $manager->persist($orderLine);

        // Créer 1 Commande
        $order = new Order();
        $order
            ->setCreatedAt(new \DateTime())
            ->setShippingAt(new \DateTime("2021-08-19"))
            ->setTotal(42, 2)
            ->setValid(false)
            ->addOrderLine($orderLine)
            ->setUser($user);

        $manager->persist($order);


        //////

        $manager->flush();
    }
}
