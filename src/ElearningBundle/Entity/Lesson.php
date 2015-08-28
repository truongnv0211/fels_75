<?php

namespace ElearningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Lesson
 */
class Lesson
{
    const WORDS_PER_CATEGORY = 20;
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $correctTotal = 0;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $results;

    /**
     * @var \ElearningBundle\Entity\User
     */
    private $user;

    /**
     * @var \ElearningBundle\Entity\Category
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set correctTotal
     *
     * @param integer $correctTotal
     * @return Lesson
     */
    public function setCorrectTotal($correctTotal)
    {
        $this->correctTotal = $correctTotal;

        return $this;
    }

    /**
     * Get correctTotal
     *
     * @return integer
     */
    public function getCorrectTotal()
    {
        return $this->correctTotal;
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
     * Add results
     *
     * @param \ElearningBundle\Entity\Result $results
     * @return Lesson
     */
    public function addResult(\ElearningBundle\Entity\Result $results)
    {
        $this->results[] = $results;

        return $this;
    }

    /**
     * Remove results
     *
     * @param \ElearningBundle\Entity\Result $results
     */
    public function removeResult(\ElearningBundle\Entity\Result $results)
    {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set user
     *
     * @param \ElearningBundle\Entity\User $user
     * @return Lesson
     */
    public function setUser(\ElearningBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ElearningBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category
     *
     * @param \ElearningBundle\Entity\Category $category
     * @return Lesson
     */
    public function setCategory(\ElearningBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ElearningBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
