<?php

namespace ibanu\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use ibanu\MainBundle\Form\DataTransformer\DurationToIntegerTransformer;

class DurationType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new DurationToIntegerTransformer();
        
         $builder->add(
            $builder->create('hours', 'integer', array('error_bubbling' => false))
        );
         $builder->add(
            $builder->create('minutes', 'integer', array('error_bubbling' => false))
        );
         $builder->addModelTransformer($transformer);
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
         $resolver->setDefaults(array(
            'hours'          => range(0, 200),
            'minutes'        => range(0, 59),
            'error_bubbling' => false,
            'compound'       => true
        ));
        
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'duration';
    }
}