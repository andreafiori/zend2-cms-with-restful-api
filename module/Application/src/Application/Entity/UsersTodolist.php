<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersTodolist
 *
 * @ORM\Table(name="users_todolist")
 * @ORM\Entity
 */
class UsersTodolist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="taskname", type="string", length=50, nullable=true)
     */
    private $taskname = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=50, nullable=true)
     */
    private $state = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="timelapsed", type="string", length=50, nullable=true)
     */
    private $timelapsed = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiredate", type="datetime", nullable=true)
     */
    private $expiredate = '2013-01-01 01:01:01';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId = '0';



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set taskname
     *
     * @param string $taskname
     * @return UsersTodolist
     */
    public function setTaskname($taskname)
    {
        $this->taskname = $taskname;

        return $this;
    }

    /**
     * Get taskname
     *
     * @return string 
     */
    public function getTaskname()
    {
        return $this->taskname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return UsersTodolist
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return UsersTodolist
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set timelapsed
     *
     * @param string $timelapsed
     * @return UsersTodolist
     */
    public function setTimelapsed($timelapsed)
    {
        $this->timelapsed = $timelapsed;

        return $this;
    }

    /**
     * Get timelapsed
     *
     * @return string 
     */
    public function getTimelapsed()
    {
        return $this->timelapsed;
    }

    /**
     * Set expiredate
     *
     * @param \DateTime $expiredate
     * @return UsersTodolist
     */
    public function setExpiredate($expiredate)
    {
        $this->expiredate = $expiredate;

        return $this;
    }

    /**
     * Get expiredate
     *
     * @return \DateTime 
     */
    public function getExpiredate()
    {
        return $this->expiredate;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return UsersTodolist
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
