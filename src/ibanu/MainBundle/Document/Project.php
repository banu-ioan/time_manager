<?php
namespace ibanu\MainBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="ibanu\MainBundle\Repository\ProjectRepository", collection="projects")
 */
class Project
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;
    
    
    /** 
     * @MongoDB\String
     */
    private $name;
    
    
    /** 
     * @MongoDB\String 
     */
    private $description;

    
    /**
     * @MongoDB\ReferenceMany(targetDocument="Task")
     */
    private $tasks = array();

    
    public function getEstimatedTasks() 
    {
        $tasks          = $this->getTasks();
        $task_estimated = 0;
        
        foreach ($tasks as $task) {
            $task_estimated    += $task->getEstimated();
        }
        
        return $task_estimated;
    }
 
    public function getEstimatedTasksHours()
    {
        return floor( $this->getEstimatedTasks() / 60 );
    }
    
    public function getEstimatedTasksMinutes()
    {
        return sprintf( "%02s", $this->getEstimatedTasks() % 60 );
    }
    
        
    public function getWorkedTasks() 
    {
        $tasks          = $this->getTasks();
        $task_worked = 0;
        
        foreach ($tasks as $task) {
            $task_worked    += $task->getWorked();
        }
        
        return $task_worked;
    }
    
    public function getWorkedTasksHours()
    {
        return floor( $this->getWorkedTasks() / 60 );
    }
    
    public function getWorkedTasksMinutes()
    {
        return sprintf( "%02s", $this->getWorkedTasks() % 60 );
    }
    

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    
    public function setAllTasksInactive()
    {
        foreach ($this->tasks as $task) {
            $task->setIsActive(false);
        }
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add task
     *
     * @param ibanu\MainBundle\Document\Task $task
     */
    public function addTask(\ibanu\MainBundle\Document\Task $task)
    {
        $this->tasks[] = $task;
    }

    /**
     * Remove task
     *
     * @param ibanu\MainBundle\Document\Task $task
     */
    public function removeTask(\ibanu\MainBundle\Document\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return Doctrine\Common\Collections\Collection $tasks
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
