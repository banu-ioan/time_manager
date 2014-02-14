<?php 

namespace ibanu\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('estimated', 'duration')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'task';
    }
}