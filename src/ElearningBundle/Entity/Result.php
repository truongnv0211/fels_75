<?php

namespace ElearningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Result
 */
class Result
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
     * @var \ElearningBundle\Entity\Lesson
     */
    private $lesson;

    /**
     * @var \ElearningBundle\Entity\Answer
     */
    private $answer;

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
     * Set lesson
     *
     * @param \ElearningBundle\Entity\Lesson $lesson
     * @return Result
     */
    public function setLesson(\ElearningBundle\Entity\Lesson $lesson = null)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Get lesson
     *
     * @return \ElearningBundle\Entity\Lesson 
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * Set answer
     *
     * @param \ElearningBundle\Entity\Answer $answer
     * @return Result
     */
    public function setAnswer(\ElearningBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \ElearningBundle\Entity\Answer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
