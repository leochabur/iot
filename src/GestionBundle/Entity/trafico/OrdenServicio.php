<?php

namespace GestionBundle\Entity\trafico;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrdenServicio
 *
 * @ORM\Table(name="trafico_orden_servicio")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\OrdenServicioRepository")
 */
class OrdenServicio
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="salida", type="datetime")
     */
    private $salida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="llegada", type="datetime")
     */
    private $llegada;

    /**
     * @var bool
     *
     * @ORM\Column(name="activa", type="boolean")
     */
    private $activa = true;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\trafico\Turno")
     * @ORM\JoinColumn(name="id_turno", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $turno;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\segVial\Unidad")
     * @ORM\JoinColumn(name="id_unidad", referencedColumnName="id", nullable=true)
     */
    private $unidad;


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
     * Set salida
     *
     * @param \DateTime $salida
     *
     * @return OrdenServicio
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get salida
     *
     * @return \DateTime
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * Set llegada
     *
     * @param \DateTime $llegada
     *
     * @return OrdenServicio
     */
    public function setLlegada($llegada)
    {
        $this->llegada = $llegada;

        return $this;
    }

    /**
     * Get llegada
     *
     * @return \DateTime
     */
    public function getLlegada()
    {
        return $this->llegada;
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     *
     * @return OrdenServicio
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return bool
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Set turno
     *
     * @param \GestionBundle\Entity\trafico\Turno $turno
     *
     * @return OrdenServicio
     */
    public function setTurno(\GestionBundle\Entity\trafico\Turno $turno = null)
    {
        $this->turno = $turno;

        return $this;
    }

    /**
     * Get turno
     *
     * @return \GestionBundle\Entity\trafico\Turno
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return OrdenServicio
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set unidad
     *
     * @param \GestionBundle\Entity\segVial\Unidad $unidad
     *
     * @return OrdenServicio
     */
    public function setUnidad(\GestionBundle\Entity\segVial\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \GestionBundle\Entity\segVial\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }
}
