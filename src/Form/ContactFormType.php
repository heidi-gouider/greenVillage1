<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet')
            ->add('email')

            //ajout d'un label et rendre le champ optionnel en
            // donnant la valeur false à l'attribut required
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Votre message',
                    // rendre le champ optionnel
                    // 'required' => false,
                    'required' => true,

                ]
            )

            ->add(
                'jaccepte',
                CheckboxType::class,
                [
                    'label' => 'J\'accepte les conditions d\'utilisation',
                    'mapped' => false,
                    'constraints' => [
                        new Assert\IsTrue([
                            'message' => 'Vous devez accepter les conditions d\'utilisation.',
                        ]),
                    ],
                ]

            )

                        // les données liées a la checkbox ne seront pas enregistrer dans l'entité ou avec le shema de données, pour le faire il faudra le faire manuellement
            // ->add('agreeTerms', CheckboxType::class, ['mapped' => false])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer le message',
            ]);

    }

    // la méthode configureOptions et l'objet $resolver définissent les options par défaut du formulaire.
    // ici cela indique l'entité associée au formulaire 
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}