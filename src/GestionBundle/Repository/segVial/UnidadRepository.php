<?php

namespace GestionBundle\Repository\segVial;

/**
 * UnidadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UnidadRepository extends \Doctrine\ORM\EntityRepository
{
	public function getUnidadesEmpresa(\AppBundle\Entity\Empresa $empresa) 
	{ 
			return $this->createQueryBuilder('u')
						->where('u.empresa = :empresa')
						->setParameter('empresa', $empresa)
						->orderBy('u.interno')
						->getQuery()
						->getResult();
	} 
}
