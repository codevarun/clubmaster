<?php

namespace Club\ShopBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @Assert\Callback(methods={"isValid"})
 */
class Attribute
{
  /**
   * @Club\ShopBundle\Validator\DateTime()
   */
  public $time_interval;

  /**
   * @Assert\Regex(
   *   pattern="/^\d+$/",
   *   match=true,
   *   message="Not a number"
   * )
   */
  public $ticket;

  public $auto_renewal;

  /**
   * @Assert\Regex(
   *   pattern="/^\d+$/",
   *   match=true,
   *   message="Not a number"
   * )
   */
  public $allowed_pauses;

  /**
   * @Assert\Date()
   */
  public $start_date;

  /**
   * @Assert\Date()
   */
  public $expire_date;

  public $location;

  public $booking;

  public $team;

  public $next_start_date;

  public $next_expire_date;

  public function setNextDates()
  {
    if ($this->next_start_date && $this->expire_date && $this->auto_renewal == 'Y') {
      $this->next_start_date = clone $this->start_date;
      $this->next_expire_date = clone $this->expire_date;

      $interval = $this->next_start_date->diff($this->expire_date);

      $ed = new \DateTime($this->next_start_date->format('Y-m-d H:i:s'));
      $ed->add($interval);

      while ($ed->getTimestamp() < time()) {
        $this->next_start_date->add(new \DateInterval('P1Y'));
        $ed->add(new \DateInterval('P1Y'));
      }

      $this->next_expire_date = $ed;
    } else {
      $this->next_start_date = $this->start_date;
      $this->next_expire_date = $this->expire_date;
    }
  }

  public function getNextStartDate()
  {
    return $this->next_start_date;
  }

  public function getNextExpireDate()
  {
    return $this->next_expire_date;
  }

  public function setStartDate($start_date)
  {
    $this->start_date = new \DateTime($start_date.' 00:00:00');
    $this->setNextDates();
  }

  public function getStartDate()
  {
    return $this->start_date;
  }

  public function setExpireDate($expire_date)
  {
    $this->expire_date = new \DateTime($expire_date.' 23:59:59');
    $this->setNextDates();
  }

  public function getExpireDate()
  {
    return $this->expire_date;
  }

  public function setTicket($ticket)
  {
    $this->ticket = $ticket;
  }

  public function getTicket()
  {
    return $this->ticket;
  }

  public function setTimeInterval($time_interval)
  {
    $this->time_interval = $time_interval;
  }

  public function getTimeInterval()
  {
    return $this->time_interval;
  }

  public function setAutoRenewal($auto_renewal)
  {
    $this->auto_renewal = $auto_renewal;
    $this->setNextDates();
  }

  public function getAutoRenewal()
  {
    return $this->auto_renewal;
  }

  public function setAllowedPauses($allowed_pauses)
  {
    $this->allowed_pauses = $allowed_pauses;
  }

  public function getAllowedPauses()
  {
    return $this->allowed_pauses;
  }

  public function setLocation($location)
  {
    $this->location = $location;
  }

  public function getLocation()
  {
    return $this->location;
  }

  public function setTeam($team)
  {
    $this->team = $team;
  }

  public function getTeam()
  {
    return $this->team;
  }

  public function setBooking($booking)
  {
    $this->booking = $booking;
  }

  public function getBooking()
  {
    return $this->booking;
  }

  public function isValid(ExecutionContext $context)
  {
    if ($this->auto_renewal == 'Y' && $this->time_interval != '')
      $context->addViolation('You are not able to make yearly renewal with a time interval, choose a start date instead.', array(), null);

    if ($this->expire_date != '' && $this->start_date == '')
      $context->addViolation('You are not able to have an expire date without a start date.', array(), null);

    if (($this->team || $this->booking) && !count($this->location))
      $context->addViolation('You have to select a location for booking or teams', array(), null);
  }
}
