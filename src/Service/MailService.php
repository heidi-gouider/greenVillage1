<!-- namespace App\Service\MailService;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Contact;

class MailService
{
private $mailer;

public function __construct(MailerInterface $mailer)
{
$this->mailer = $mailer;
}
public function sendMail($expediteur, $destinataire, $sujet, $message){
// Récupération de l'entité Contact associée au formulaire
$contact = $form->getData();

// Récupération des propriétés de l'entité Contact
$address = $contact->getEmail();
// $subject = $contact->getObjet();
// $content = $contact->getMessage();
$content = 'objet : ' . $contact->getObjet() . "\n";
$content .= 'message : ' . $contact->getMessage();
// dd($contact);

$email = (new Email())
->from($address)
->to('admin@admin.com')
->subject('demande de contact')
->text($content);

// dd($email);
$mailer->send($email); -->


<!-- }
} -->