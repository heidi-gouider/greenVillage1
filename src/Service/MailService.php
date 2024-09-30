<?php

namespace App\Service\MailService;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Contact;

class MailService
{
private $mailer;

public function __construct(MailerInterface $mailer)
{
// $this->mailer = $mailer;
}
// public function sendMail( $expediteur, $destinataire, $sujet, $message){
// Récupération de l'entité Contact associée au formulaire
// $contact = $form->getData();

// Récupération des propriétés de l'entité Contact
// $address = $contact->getEmail();
// $subject = $contact->getObjet();
// $content = $contact->getMessage();
// $content = 'objet : ' . $contact->getObjet() . "\n";
// $content .= 'message : ' . $contact->getMessage();
public function sendMail(
string $from,
string $to,
string $subject,
string $template,
array $context
): void
{
// dd($contact);

// On crée le mail
$email = (new Email())
->from($from)
->to($to)
->subject($subject)
->htmlTemplate("email/$template.html.twig")
->context($context);

// Envoie du mail
// dd($email);
$this->mailer->send($email);


}
}