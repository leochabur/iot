<?php

namespace GestionBundle\Entity\trafico;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Servicio
 *
 * @ORM\Table(name="trafico_servicios")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\ServicioRepository")
 */
class Servicio
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
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\ventas\Cliente")
     * @ORM\JoinColumn(name="id_cliente", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\ventas\Ciudad")
     * @ORM\JoinColumn(name="id_orgien", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $origen;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\ventas\Ciudad")
     * @ORM\JoinColumn(name="id_origen", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $destino;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", options={"default": true})
     */
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\trafico\opciones\SentidoServicio")
     * @ORM\JoinColumn(name="id_sentido", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $sentido;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\trafico\opciones\TipoServicio")
     * @ORM\JoinColumn(name="id_tipo_servicio", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $tipoServicio;

    /**
     * @ORM\OneToMany(targetEntity="Turno", mappedBy="servicio")
     * @ORM\OrderBy({"horaInicial" = "ASC"})
     */
    private $turnos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    private $empresa;
    
    /**
     * @var int
     *
     * @ORM\Column(name="kmRecorrido", type="integer")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $kmRecorrido;
    
    public function __toString()
    {
        return strtoupper($this->nombre);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->turnos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Servicio
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Servicio
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
     * Set cliente
     *
     * @param \GestionBundle\Entity\ventas\Cliente $cliente
     *
     * @return Servicio
     */
    public function setCliente(\GestionBundle\Entity\ventas\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \GestionBundle\Entity\ventas\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set origen
     *
     * @param \GestionBundle\Entity\ventas\Ciudad $origen
     *
     * @return Servicio
     */
    public function setOrigen(\GestionBundle\Entity\ventas\Ciudad $origen = null)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return \GestionBundle\Entity\ventas\Ciudad
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set destino
     *
     * @param \GestionBundle\Entity\ventas\Ciudad $destino
     *
     * @return Servicio
     */
    public function setDestino(\GestionBundle\Entity\ventas\Ciudad $destino = null)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return \GestionBundle\Entity\ventas\Ciudad
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set sentido
     *
     * @param \GestionBundle\Entity\trafico\opciones\SentidoServicio $sentido
     *
     * @return Servicio
     */
    public function setSentido(\GestionBundle\Entity\trafico\opciones\SentidoServicio $sentido = null)
    {
        $this->sentido = $sentido;

        return $this;
    }

    /**
     * Get sentido
     *
     * @return \GestionBundle\Entity\trafico\opciones\SentidoServicio
     */
    public function getSentido()
    {
        return $this->sentido;
    }

    /**
     * Set tipoServicio
     *
     * @param \GestionBundle\Entity\trafico\opciones\TipoServicio $tipoServicio
     *
     * @return Servicio
     */
    public function setTipoServicio(\GestionBundle\Entity\trafico\opciones\TipoServicio $tipoServicio = null)
    {
        $this->tipoServicio = $tipoServicio;

        return $this;
    }

    /**
     * Get tipoServicio
     *
     * @return \GestionBundle\Entity\trafico\opciones\TipoServicio
     */
    public function getTipoServicio()
    {
        return $this->tipoServicio;
    }

    /**
     * Add turno
     *
     * @param \GestionBundle\Entity\trafico\Turno $turno
     *
     * @return Servicio
     */
    public function addTurno(\GestionBundle\Entity\trafico\Turno $turno)
    {
        $this->turnos[] = $turno;

        return $this;
    }

    /**
     * Remove turno
     *
     * @param \GestionBundle\Entity\trafico\Turno $turno
     */
    public function removeTurno(\GestionBundle\Entity\trafico\Turno $turno)
    {
        $this->turnos->removeElement($turno);
    }

    /**
     * Get turnos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTurnos()
    {
        return $this->turnos;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Servicio
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set kmRecorrido
     *
     * @param integer $kmRecorrido
     *
     * @return Servicio
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
}
