<?php

namespace ElearningBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ElearningBundle\Entity\Word;
use ElearningBundle\Entity\Lesson;

class WordRepository extends EntityRepository
{
    public function getWordsForLesson($category, $count)
    {
        return $this->createQueryBuilder('w')
                    ->where('w.category = :category')
                    ->setFirstResult(rand(0, $count - Lesson::WORDS_PER_CATEGORY - 1))
                    ->setMaxResults(Lesson::WORDS_PER_CATEGORY)
                    ->setParameter('category', $category)
                    ->getQuery()
                    ->getResult();
    }
}
