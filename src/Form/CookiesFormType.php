<?php

namespace TwinElements\GDPRCookiesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TwinElements\GDPRCookiesBundle\Entity\CookiesForm;

class CookiesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('base', CheckboxType::class,[
                'label_attr' => [
                    'class' => 'switch-custom'
                ],
                'label' => 'translations.cookies.base_cookies',
            ])
            ->add('analytic', CheckboxType::class,[
                'label_attr' => [
                    'class' => 'switch-custom'
                ],
                'label' => 'translations.cookies.analytic_cookies',
                'required' => false
            ])
            ->add('marketing', CheckboxType::class,[
                'label_attr' => [
                    'class' => 'switch-custom'
                ],
                'label' => 'translations.cookies.marketing_cookies',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => CookiesForm::class,
            'translation_domain' => 'translations'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'cookies_type';
    }
}
