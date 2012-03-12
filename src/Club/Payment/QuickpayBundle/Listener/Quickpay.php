<?php

namespace Club\Payment\QuickpayBundle\Listener;

class Quickpay
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onPaymentMethodGet(\Club\ShopBundle\Event\FilterPaymentMethodEvent $event)
  {
    $name = 'Credit card';
    $service = 'club.payment.quickpay';

    $method = $this->em->getRepository('ClubShopBundle:PaymentMethod')->findOneBy(array(
      'payment_method_name' => $name
    ));

    if (!$method) {
      $method = new \Club\ShopBundle\Entity\PaymentMethod();
      $method->setPaymentMethodName($name);
      $method->setPage(<<<EOF
<h2>Thank you</h2>
<p>Your order has been successful completed.</p><p>We will complete your order as soon as we receive the payment.</p>
EOF
);

      $this->em->persist($method);
      $this->em->flush();
    }

    $event->setMethod($method);
  }
}