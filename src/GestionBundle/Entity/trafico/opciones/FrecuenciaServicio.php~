<?php

namespace GestionBundle\Entity\trafico\opciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * FrecuenciaServicio
 *
 * @ORM\Table(name="trafico_opciones_frecuencia_servicio")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\opciones\FrecuenciaServicioRepository")
 */

////////////////Regular - Temporario - Eventual
class FrecuenciaServicio
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
     * @ORM\Column(name="frecuencia", type="string", length=255, unique=true)
     */
    private $frecuencia;
    

    public function __toString()
    {
        return strtoupper($this->frecuencia);
    }

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
     * Set frecuencia
     *
     * @param string $frecuencia
     *
     * @return FrecuenciaServicio
     */
    public function setFrecuencia($frecuencia)
    {
        $this->frecuencia = $frecuencia;

        return $this;
    }

    /**
     * Get frecuencia
     *
     * @return string
     */
    public function getFrecuencia()
    {
        return $this->frecuencia;
    }
}
