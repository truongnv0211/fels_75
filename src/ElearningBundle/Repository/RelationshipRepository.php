<?php

namespace ElearningBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RelationshipRepository extends EntityRepository
{
    public function getFolloweeIds($user)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT IDENTITY(p.followee) FROM ElearningBundle:Relationship p WHERE p.follower = :follower')
            ->setParameter('follower', $user->getId())
            ->getResult();
    }
}
