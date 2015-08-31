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

    public function getWordsByCategory($category)
    {
        $queryBuilder = $this->createQueryBuilder('w')
        if ($category) {
            $queryBuilder->andWhere('w.category = :category')
                         ->setParameter('category', $category);
        }

        return $queryBuilder;
    }

    public function getLearnedWord($category, $result)
    {
        $queryBuilder = $this->createQueryBuilder('w')
                             ->where('w IN (:result)')
                             ->setParameter('result', $result);
        if ($category) {
            $queryBuilder->andWhere('w.category = :category')
                         ->setParameter('category', $category);
        }

        return $queryBuilder;
    }

    public function getNotLearnedWord($category, $result)
    {
        $queryBuilder = $this->createQueryBuilder('w')
                             ->where('w IN (:result)')
                             ->setParameter('result', $result);

        if ($category) {
            $queryBuilder->andWhere('w.category = :category')
                         ->setParameter('category', $category);
        }

        return $queryBuilder;
    }
}
