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
    private $turnoCliente;

    /**
     * @ORM\ManyToMany(targetEntity="GestionBundle\Entity\trafico\opciones\FrecuenciaTurno")
     * @ORM\JoinTable(name="trafico_frecuencia_turnos",
     *      joinColumns={@ORM\JoinColumn(name="id_turno", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_frecuencia", referencedColumnName="id")}
     *      )
     */
    private $frecuencias;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaInicial", type="time")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $horaInicial;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="horaFinal", type="time")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $horaFinal;

    /**
     * @var int
     *
     * @ORM\Column(name="kmRecorrido", type="integer")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $kmRecorrido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duracion", type="time")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $duracion;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->frecuencias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set horaFinal
     *
     * @param \DateTime $horaFinal
     *
     * @return Turno
     */
    public function setHoraFinal($horaFinal)
    {
        $this->horaFinal = $horaFinal;

        return $this;
    }

    /**
     * Get horaFinal
     *
     * @return \DateTime
     */
    public function getHoraFinal()
    {
        return $this->horaFinal;
    }

    /**
     * Set kmRecorrido
     *
     * @param integer $kmRecorrido
     *
     * @return Turno
     */
    public function setKmRecorrido($kmRecorrido)
    {
        $this->kmRecorrido = $kmRecorrido;

        return $this;
    }

    /**
     * Get kmRecorrido
     *
     * @return integer
     */
    public function getKmRecorrido()
    {
        return $this->kmRecorrido;
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
     * Set turnoCliente
     *
     * @param \GestionBundle\Entity\trafico\opciones\TurnoCliente $turnoCliente
     *
     * @return Turno
     */
    public function setTurnoCliente(\GestionBundle\Entity\trafico\opciones\TurnoCliente $turnoCliente = null)
    {
        $this->turnoCliente = $turnoCliente;

        return $this;
    }

    /**
     * Get turnoCliente
     *
     * @return \GestionBundle\Entity\trafico\opciones\TurnoCliente
     */
    public function getTurnoCliente()
    {
        return $this->turnoCliente;
    }

    /**
     * Add frecuencia
     *
     * @param \GestionBundle\Entity\trafico\opciones\FrecuenciaTurno $frecuencia
     *
     * @return Turno
     */
    public function addFrecuencia(\GestionBundle\Entity\trafico\opciones\FrecuenciaTurno $frecuencia)
    {
        $this->frecuencias[] = $frecuencia;

        return $this;
    }

    /**
     * Remove frecuencia
     *
     * @param \GestionBundle\Entity\trafico\opciones\FrecuenciaTurno $frecuencia
     */
    public function removeFrecuencia(\GestionBundle\Entity\trafico\opciones\FrecuenciaTurno $frecuencia)
    {
        $this->frecuencias->removeElement($frecuencia);
    }

    /**
     * Get frecuencias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFrecuencias()
    {
        return $this->frecuencias;
    }
}
