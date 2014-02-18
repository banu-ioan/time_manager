<?php

namespace ibanu\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/current_tasks", name="current_tasks")
     * @Template()
     */
    public function currentTasksAction()
    {
        $currentTasks   = $this->getUser()->getCurrentTasks();
        
        return array('currentTasks' => $currentTasks);
    } 
    
}
