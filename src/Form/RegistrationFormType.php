<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom_client')
            ->add('adresse_client')
            ->add('telephone_client')
            ->add('code_postal_client')
            // ->add('reference_client')
            ->add('coef_client', ChoiceType::class, [
                'choices'  => [
                    'Particulier' => 'particulier',
                    'Professionnel' => 'professionnel',
                ],
                'label' => 'Type de Client'
            ])
            ->add('email')


            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre mot de passe',
                    ]),
                    
                    new Length([
                        'min' => 6,
                        'minMessage' => 'YVotre mot de passe doit çétre supérieur à 6 caractères {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            // ->add('confirmPassword', PasswordType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Veuillez confirmer votre mot de passe',
            //         ]),
            //         new EqualTo([
            //             'propertyPath' => 'plainPassword',
            //             'message' => 'Les mots de passe doivent correspondre',
            //         ]),
            //     ],
            //     'attr' => ['autocomplete' => 'new-password'],
            // ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
'constraints' => [
    new IsTrue([
        'message' => 'Jaccepte les termes.',
    ]),
],
])

        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
