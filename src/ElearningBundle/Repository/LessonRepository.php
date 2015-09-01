<?php

namespace ElearningBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LessonRepository extends EntityRepository
{
    public function getActivityForUser($user, $followee)
    {
        return $this->createQueryBuilder('l')
                    ->where('l.user IN (:followee)')
                    ->orWhere('l.user = :user')
                    ->orderBy('l.created_at', 'DESC')
                    ->setParameter('user', $user)
                    ->setParameter('followee', $followee);
    }
}
