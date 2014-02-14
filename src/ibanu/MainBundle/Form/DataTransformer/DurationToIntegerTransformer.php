<?php

namespace ibanu\MainBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


/**
 *
 * @author ion
 */
class DurationToIntegerTransformer implements DataTransformerInterface 
{


    public function transform($duration)
    {
        if (null === $duration) {
            return null;
        }
        
        if (!is_int($duration)) {
            throw new TransformationFailedException('Expected two integers.');
        }
        
        $hours      = floor($duration / 60);
        $minutes    = $duration % 60;
        
        
        return  array('hours' => $hours, 'minutes' => $minutes);
    }


    public function reverseTransform($values)
    {
        if (null === $values) {
            return array();
        }
        
        $hours   = $values['hours'];
        $minutes = $values['minutes'];
        
        if (!is_int($hours) && !is_int($minutes)) {
            throw new TransformationFailedException('Expected one integer.');
        }

        return $hours * 60 + $minutes;
    }
}
