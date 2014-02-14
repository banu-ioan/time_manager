<?php

namespace ibanu\MainBundle\Service;

use Symfony\Component\Security\Core\SecurityContext;
use Problematic\AclManagerBundle\Domain\AclManager;


/**
 * @author ion
 */
class Filter {
    protected $securityContext;
    protected $aclManager;
    
    public function __construct(SecurityContext $securityContext, AclManager $aclManager)
    {
        $this->securityContext = $securityContext;
        $this->aclManager = $aclManager;
    }
    
    
    public function filterView($objects)
    {
        $this->aclManager->preloadAcls($objects);
        
        $allowedObjects    = array();
        foreach ($objects as $object) {
            if ($this->securityContext->isGranted('VIEW', $object)) {
                $allowedObjects[]  = $object;
            } 
        }
        return $allowedObjects;
    }
}
