<?php

namespace App\Controller;

use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;


class PaymentController extends AbstractController{

    #[Route('/paiement', name: 'app_paiement')]

    public function stripeCheckout(){

    }

}