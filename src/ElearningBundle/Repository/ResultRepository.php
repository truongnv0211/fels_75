<?php

namespace ElearningBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ResultRepository extends EntityRepository
{
    public function getResultFromLesson($lesson)
    {
        $result = $this->createQueryBuilder('r')
            ->select('IDENTITY(r.word)')
            ->where('r.lesson IN (:lesson)')
            ->setParameter('lesson', $lesson)
            ->getQuery()
            ->getResult();

        if ($result == null) {
            return 0;
        }

        return $result;
    }
}
