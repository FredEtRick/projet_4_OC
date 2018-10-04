<?php

namespace Fmd\PersonneBundle\Repository;

/**
 * PersonneRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonneRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPersonnesViaMail($mail)
    {
        $query = $this->_em->createQuery("SELECT p FROM FmdPersonneBundle:Personne p WHERE p.id IN (SELECT DISTINCT b.personne_id FROM FmdBookingManagementBundle:Billet b WHERE b.reservation_id IN (SELECT r.id FROM FmdBookingManagementBundle:Reservation r WHERE r.mail = ':mail'))");
        $query->setParameter('mail', $mail);

        //print_r();

        return $query->getResult();
    }
}
