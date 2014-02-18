<?php


namespace ibanu\MainBundle\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use ibanu\MainBundle\Document\Task;
use ibanu\MainBundle\Document\Project;

/**
 *
 * @author ion
 */
class TaskManager {
    protected $dm;
    
    public function __construct(DocumentManager $documentManager)
    {
        $this->dm = $documentManager;
    }
    
    public function stopAllTasks(Project $project)
    {
        $tasks  = $project->getTasks();
        foreach ($tasks as $task) {
            $this->stop($task);
        }
        
        return $this;
    }
    
    public function start(Task $task, Project $project)
    {
        $project->setAllTasksInactive();
        $task->setIsActive(true);
        $task->setStart( new \DateTime() );
        
        $this->dm->persist($task);
        $this->dm->flush();
        
        return $this;
    }
    
    public function stop(Task $task)
    {
        if ($task->isActive()) {
            $task->setIsActive(false);

            $now    = new \DateTime();
            $interval = $now->diff($task->getStart());
            $task->setWorked($task->getWorked() + $interval->days * 24 * 60 + $interval->h * 60 + $interval->i);

            $this->dm->persist($task);
            $this->dm->flush();
        }
        
        return $this;
    }
    
}
