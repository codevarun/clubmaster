<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TeamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamRepository extends EntityRepository
{
  public function getTeamByUser(\Club\UserBundle\Entity\User $user)
  {
    $team = $this->_em->createQueryBuilder()
      ->select('t')
      ->from('ClubMatchBundle:Team', 't')
      ->leftJoin('t.users', 'u')
      ->where('u.id = :user')
      ->setParameter('user', $user->getId())
      ->getQuery()
      ->getOneOrNullResult();

    if (!$team) {
      $team = new \Club\MatchBundle\Entity\Team();
      $team->addUser($user);
      $this->_em->persist($team);
    }

    return $team;
  }
}
