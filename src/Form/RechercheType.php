<?php

namespace App\Form;


use App\Entity\Categorie;
use App\Repository\CategorieRepository; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\RechercheType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        // liste déroulante
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'libelle_categorie',  // propriété 'libelle' dans l'entité Categorie
                'placeholder' => 'Toutes les catégories',
                'required' => false,
                'query_builder' => function (CategorieRepository $er) {
                    return $er->createQueryBuilder('c')
                              ->where('c.parent_categorie IS NULL');
                },
            ])

            // Ajout du champ de recherche texte
            ->add('query', TextType::class, [
            // ->add('query', RechercheType::class, [
                'attr' => [
                    'class' => 'form-control-sm mr-sm-2',
                    'placeholder' => 'recherche',
                    'aria-label' => 'Recherche'
                ],
                'required' => false,
            ])

            // Ajout du bouton de soumission
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success my-2 my-sm-0',
                ],
                'label' => 'Recherche',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
