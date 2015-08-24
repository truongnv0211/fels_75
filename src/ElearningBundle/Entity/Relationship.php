<?php

namespace ElearningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Relationship
 */
class Relationship
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    /**
     * @var \ElearningBundle\Entity\User
     */
    private $follower;

    /**
     * @var \ElearningBundle\Entity\User
     */
    private $followee;

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
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set follower
     *
     * @param \ElearningBundle\Entity\User $follower
     * @return Relationship
     */
    public function setFollower(\ElearningBundle\Entity\User $follower = null)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
     * Get follower
     *
     * @return \ElearningBundle\Entity\User 
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Set followee
     *
     * @param \ElearningBundle\Entity\User $followee
     * @return Relationship
     */
    public function setFollowee(\ElearningBundle\Entity\User $followee = null)
    {
        $this->followee = $followee;

        return $this;
    }

    /**
     * Get followee
     *
     * @return \ElearningBundle\Entity\User 
     */
    public function getFollowee()
    {
        return $this->followee;
    }
}
