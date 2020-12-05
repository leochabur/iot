<?php

namespace GestionBundle\Entity\segVial\opciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * CalidadUnidad
 *
 * @ORM\Table(name="seg_vialopciones_calidad_unidad")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\segVial\opciones\CalidadUnidadRepository")
 */
class CalidadUnidad
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="calidad", type="string", length=255)
     */
    private $calidad;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set calidad
     *
     * @param string $calidad
     *
     * @return CalidadUnidad
     */
    public function setCalidad($calidad)
    {
        $this->calidad = $calidad;

        return $this;
    }

    /**
     * Get calidad
     *
     * @return string
     */
    public function getCalidad()
    {
        return $this->calidad;
    }
}
