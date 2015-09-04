<?php

namespace ElearningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Answer
 */
class Answer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $correct;

    /**
     * @var string
     */
    private $content;

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
     * @var \ElearningBundle\Entity\Word
     */
    private $word;

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
     * Set correct
     *
     * @param boolean $correct
     * @return Answer
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * Get correct
     *
     * @return boolean 
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Answer
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
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
     * Set word
     *
     * @param \ElearningBundle\Entity\Word $word
     * @return Answer
     */
    public function setWord(\ElearningBundle\Entity\Word $word = null)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return \ElearningBundle\Entity\Word 
     */
    public function getWord()
    {
        return $this->word;
    }

    public function getCorrectAsText()
    {
        return ($this->correct == true) ? 'Correct' : 'Incorrect';
    }
}
