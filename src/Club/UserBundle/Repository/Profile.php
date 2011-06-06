<?php

namespace Club\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Profile
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Profile extends EntityRepository
{
  public function getDefaultAddress(\Club\UserBundle\Entity\Profile $profile)
  {
    $address = $this->_em->getRepository('\Club\UserBundle\Entity\ProfileAddress')->findOneBy(array(
      'profile' => $profile->getId(),
      'is_default' => 1
    ));

    return $address;
  }

  public function getDefaultEmail(\Club\UserBundle\Entity\Profile $profile)
  {
    $email = $this->_em->getRepository('\Club\UserBundle\Entity\ProfileEmail')->findOneBy(array(
      'profile' => $profile->getId(),
      'is_default' => 1
    ));

    return $email;
  }

}
