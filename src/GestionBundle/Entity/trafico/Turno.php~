<?php

namespace GestionBundle\Entity\trafico;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Turno
 *
 * @ORM\Table(name="trafico_turnos")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\TurnoRepository")
 */
class Turno
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
     * @ORM\ManyToOne(targetEntity="Servicio", inversedBy="turnos")
     * @ORM\JoinColumn(name="id_servicio", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $servicio;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\trafico\opciones\TurnoCliente")
     * @ORM\JoinColumn(name="id_turno", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $turno;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaInicial", type="time")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $horaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duracion", type="time")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $duracion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", options={"default": true})
     */
    private $activo = true;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $tipo;

    public function getVistaDiagrama()
    {
        return $this->servicio->getCliente().' - '.$this->servicio->getNombre().' -> '.$this->horaInicial->format('H:i');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set horaInicial
     *
     * @param \DateTime $horaInicial
     *
     * @return Turno
     */
    public function setHoraInicial($horaInicial)
    {
        $this->horaInicial = $horaInicial;

        return $this;
    }

    /**
     * Get horaInicial
     *
     * @return \DateTime
     */
    public function getHoraInicial()
    {
        return $this->horaInicial;
    }

    /**
     * Set duracion
     *
     * @param \DateTime $duracion
     *
     * @return Turno
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

    /**
     * Get duracion
     *
     * @return \DateTime
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * Set servicio
     *
     * @param \GestionBundle\Entity\trafico\Servicio $servicio
     *
     * @return Turno
     */
    public function setServicio(\GestionBundle\Entity\trafico\Servicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \GestionBundle\Entity\trafico\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set turno
     *
     * @param \GestionBundle\Entity\trafico\opciones\TurnoCliente $turno
     *
     * @return Turno
     */
    public function setTurno(\GestionBundle\Entity\trafico\opciones\TurnoCliente $turno = null)
    {
        $this->turno = $turno;

        return $this;
    }

    /**
     * Get turno
     *
     * @return \GestionBundle\Entity\trafico\opciones\TurnoCliente
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Turno
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Turno
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
