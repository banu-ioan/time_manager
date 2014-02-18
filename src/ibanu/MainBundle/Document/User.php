<?php
// src/Acme/UserBundle/Document/User.php

namespace ibanu\MainBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="Task")
     */
    private $current_tasks;
    
    

    public function __construct()
    {
        parent::__construct();
        $this->current_tasks = new ArrayCollection();
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


    /**
     * Add currentTask
     *
     * @param ibanu\MainBundle\Document\Task $currentTask
     */
    public function addCurrentTask(\ibanu\MainBundle\Document\Task $currentTask)
    {
        $this->current_tasks[] = $currentTask;
    }

    /**
     * Remove currentTask
     *
     * @param ibanu\MainBundle\Document\Task $currentTask
     */
    public function removeCurrentTask(\ibanu\MainBundle\Document\Task $currentTask)
    {
        $this->current_tasks->removeElement($currentTask);
    }

    /**
     * Get currentTasks
     *
     * @return Doctrine\Common\Collections\Collection $currentTasks
     */
    public function getCurrentTasks()
    {
        return $this->current_tasks;
    }
    
    
    public function hasTask(\ibanu\MainBundle\Document\Task $task)
    {
        if (null === $this->getCurrentTasks()) {
            return false;
        }
        foreach ($this->getCurrentTasks() as $currentTask) {
            if ($currentTask->getId() === $task->getId()) {
                return true;
            }
        }
        return false;
    }
}
