<?php

namespace ElearningBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WordRepository extends EntityRepository
{
    public function getWordsForLesson($category, $result)
    {
        return $this->createQueryBuilder('w')
            ->where('w.id NOT IN (:result)')
            ->andWhere('w.category = :category')
            ->setParameter('category', $category)
            ->setParameter('result', $result)
            ->getQuery()
            ->getResult();
    }
}
