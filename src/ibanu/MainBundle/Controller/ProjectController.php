<?php

namespace ibanu\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;


use JMS\SecurityExtraBundle\Annotation\SecureParam;

use ibanu\MainBundle\Document\Project;


/**
 * @Route("/project")
 */
class ProjectController extends Controller
{
    
    
    /**
     * @Route("/show", name="project_show")
     * @Template()
     */
    public function showAction()
    {
        $projects   = $this->get('doctrine_mongodb')
                ->getRepository('ibanuMainBundle:Project')
                ->findAll();
        
        
        $filteredProjects   = $this->get('ibanu.filter_for_view')
                ->filterView($projects);
        
        
        
        return array('projects' => $filteredProjects);
    }
    
    
    
    /**
     * @Route("/create", name="project_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $project    = new Project();
        $projectForm = $this->createForm('project', $project);
        
        $projectForm->handleRequest($request);

        if ($projectForm->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($project);
            $dm->flush();
            
            $aclManager = $this->get('problematic.acl_manager');
            $aclManager->addObjectPermission($project, MaskBuilder::MASK_OWNER);
            
            return $this->redirect(
                $this->generateUrl('home')
            ); 
        }
        
        return array('projectForm' => $projectForm->createView());
    }
    
    /**
     * @Route("/edit/{project}", name="project_edit")
     * @Method({"GET", "POST"})
     * @SecureParam(name="project", permissions="EDIT")
     * @Template()
     */
    public function editAction(Request $request, Project $project)
    {
        $projectForm = $this->createForm('project', $project);
        
        $projectForm->handleRequest($request);
        if ($projectForm->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($project);
            $dm->flush();
        } 
        
        return array('projectForm' => $projectForm->createView());
    }

    
    /**
     * @Route("/delete/{project}", name="project_delete")
     * @Method({"GET", "POST"})
     * @SecureParam(name="project", permissions="DELETE")
     */
    public function deleteAction(Project $project)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $aclManager = $this->get('problematic.acl_manager');
        
        $aclManager->deleteAclFor($project);
        
        $dm->remove($project);
        $dm->flush();
        

        
        return $this->redirect($this->generateUrl('home'));
    }
}
