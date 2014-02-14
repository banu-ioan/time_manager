<?php
namespace ibanu\MainBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ibanu\MainBundle\Document\Task;

/**
 *
 * @author ion
 */
class AddTaskToUser
{
    protected $container;
    
    public function __construct( ContainerInterface $container )
    {
        $this->container    = $container;
    }


    public function preUpdate(PreUpdateEventArgs $args)
    {
        $document = $args->getDocument();
        
        if ($document instanceof Task) {
            if ($eventArgs->hasChangedField('is_active')) {
                $securityContext    = $this->container->get('security.context');
                $dm                 = $this->container->get('doctrine_mongodb.odm.document_manager');

                $user = $securityContext->getToken()->getUser();
                $user->setCurrentTask( $document );
                $dm->persist($user);
                $dm->flush();
            }
        }
    }
}