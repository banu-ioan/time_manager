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
use ibanu\MainBundle\Document\Task;


/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * @Route("/show_by_project/{project}", name="task_show_by_project")
     * @SecureParam(name="project", permissions="EDIT")
     * @Template("ibanuMainBundle:Task:show.html.twig")
     */
    public function showByProjectAction(Project $project)
    {
        return array('tasks' => $project->getTasks());
    }

    
        
    /**
     * @Route("/create/{project}", name="task_create")
     * @SecureParam(name="project", permissions="EDIT")
     * @Template()
     */
    public function createAction(Request $request, Project $project)
    {
        $task    = new Task();
        $taskForm = $this->createForm('task', $task);
        
        $taskForm->handleRequest($request);

        if ($taskForm->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($task);
            $project->addTask($task);
            $dm->flush();
            
            $aclManager = $this->get('problematic.acl_manager');
            $aclManager->addObjectPermission($task, MaskBuilder::MASK_OWNER);
            
            return $this->redirect(
                $this->generateUrl('task_show_by_project', array('project' => $project->getId()))
            ); 
        }
        
        return array('taskForm' => $taskForm->createView());
    }
    
    
    /**
     * @Route("/edit/{project}/{task}", name="task_edit")
     * @Method({"GET", "POST"})
     * @SecureParam(name="project", permissions="EDIT")
     * @SecureParam(name="task", permissions="OWNER")
     * @Template()
     */
    public function editAction(Request $request, Project $project, Task $task)
    {
        $taskForm = $this->createForm('task', $task);
        
        $taskForm->handleRequest($request);
        if ($taskForm->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($task);
            $dm->flush();
        } 
        
        return array('taskForm' => $taskForm->createView());
    }

    
    /**
     * @Route("/delete/{project}/{task}", name="task_delete")
     * @Method({"GET", "POST"})
     * @SecureParam(name="project", permissions="EDIT, DELETE")
     * @SecureParam(name="task", permissions="OWNER")
     */
    public function deleteAction(Project $project, Task $task)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $aclManager = $this->get('problematic.acl_manager');
        
        $aclManager->deleteAclFor($task);
        
        $project->removeTask($task);
        $dm->remove($task);
        $dm->flush();
                
        return $this->redirect($this->generateUrl('task_show_by_project', array(
            'project'  => $project->getId()
        )));
    }
    
    
    /**
     * @Route("/start/{project}/{task}", name="task_start")
     * @Method({"GET", "POST"})
     * @SecureParam(name="project", permissions="EDIT, DELETE")
     * @SecureParam(name="task", permissions="EDIT")
     */
    public function startAction(Project $project, Task $task)
    {
        $this->get('ibanu.task_manager')
                ->stopAllTasks($project)
                ->start($task, $project);

        return $this->redirect($this->generateUrl('task_show_by_project', array(
            'project'  => $project->getId()
        )));
    }
    
        
    /**
     * @Route("/stop/{project}/{task}", name="task_stop")
     * @Method({"GET", "POST"})
     * @SecureParam(name="project", permissions="EDIT, DELETE")
     * @SecureParam(name="task", permissions="EDIT")
     */
    public function stopAction(Project $project, Task $task)
    {
        $this->get('ibanu.task_manager')
                ->stop($task);
        
        return $this->redirect($this->generateUrl('task_show_by_project', array(
            'project'  => $project->getId()
        )));
    }

    
    
}
