<?php
namespace ibanu\MainBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="ibanu\MainBundle\Repository\TaskRepository", collection="tasks")
 * @MongoDB\HasLifecycleCallbacks()
 */
class Task
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
     *
     * @MongoDB\Date 
     */
    private $start;
    
    /**
     *
     * @MongoDB\Boolean
     */
    private $is_active;
    
    /**
     *
     * @MongoDB\int
     */
    private $worked;
    
    /**
     *
     * @MongoDB\int
     */
    private $estimated;

    
    public function getEstimatedHours()
    {
        return floor( $this->estimated / 60 );
    }
    
    public function getEstimatedMinutes()
    {
        return sprintf( "%02s", $this->estimated % 60 );
    }
    
    public function getWorkedHours()
    {
        return floor( $this->worked / 60 );
    }
    
    public function getWorkedMinutes()
    {
        return sprintf( "%02s", $this->worked % 60 );
    }
    
    /**
     * Get isActive
     *
     * @return boolean $isActive
     */
    public function isActive()
    {
        return $this->is_active;
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

    /**
     * Set start
     *
     * @param date $start
     * @return self
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * Get start
     *
     * @return date $start
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return self
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean $isActive
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set worked
     *
     * @param int $worked
     * @return self
     */
    public function setWorked($worked)
    {
        $this->worked = $worked;
        return $this;
    }

    /**
     * Get worked
     *
     * @return int $worked
     */
    public function getWorked()
    {
        return $this->worked;
    }

    /**
     * Set estimated
     *
     * @param int $estimated
     * @return self
     */
    public function setEstimated($estimated)
    {
        $this->estimated = $estimated;
        return $this;
    }

    /**
     * Get estimated
     *
     * @return int $estimated
     */
    public function getEstimated()
    {
        return $this->estimated;
    }
}
