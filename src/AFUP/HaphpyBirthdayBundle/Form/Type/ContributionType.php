<?php

namespace AFUP\HaphpyBirthdayBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ContributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file')
            ->add('websiteCreditWanted', 'choice', [
                'expanded'    => true,
                'choices'     => [
                    0 => 'website_credit_wanted.no',
                    1 => 'website_credit_wanted.yes',
                ],
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AFUP\HaphpyBirthdayBundle\Form\Model\Contribution',
        ));
    }

    public function getName()
    {
        return 'contribution';
    }
}
