<?php
// src/Acme/UserBundle/Document/User.php

namespace ibanu\MainBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

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
     * @MongoDB\ReferenceOne(targetDocument="Task")
     */
    private $current_task;
    
    

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set currentTask
     *
     * @param ibanu\MainBundle\Document\Task $currentTask
     * @return self
     */
    public function setCurrentTask(\ibanu\MainBundle\Document\Task $currentTask)
    {
        $this->current_task = $currentTask;
        return $this;
    }

    /**
     * Get currentTask
     *
     * @return ibanu\MainBundle\Document\Task $currentTask
     */
    public function getCurrentTask()
    {
        return $this->current_task;
    }
}
