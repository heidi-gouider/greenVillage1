<?php

// namespace App\Service\EmailService;
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\File;
// use App\Entity\Contact;

class EmailService
{
private $mailer;

public function __construct(MailerInterface $mailer)
{
$this->mailer = $mailer;
}

public function sendInvoice(string $to, string $invoicePath){

// On crée le mail
$email = (new Email())
->from('green@village.com')
->to($to)
->text('Votre facture de commande')
// ->htmlTemplate("email/$template.html.twig")
// ->context($context);
->attachFromPath($invoicePath);  // Attachement du fichier PDF de la facture

// dd($email);
$this->mailer->send($email);
}
}