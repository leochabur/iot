<?php

namespace GestionBundle\Entity\trafico;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrdenServicio
 *
 * @ORM\Table(name="trafico_orden_servicio")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\OrdenServicioRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\rrhh\Conductor")
     * @ORM\JoinColumn(name="id_conductor_1", referencedColumnName="id", nullable=true)
     */
    private $conductor1;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\rrhh\Conductor")
     * @ORM\JoinColumn(name="id_conductor_2", referencedColumnName="id", nullable=true)
     */
    private $conductor2;

    /**
     * @ORM\OneToMany(targetEntity="GestionBundle\Entity\comunicacion\OrdenInformada", mappedBy="orden")
     * @ORM\OrderBy({"fecha" = "ASC"})
     */
    private $informadas;

    /**
     * @var bool
     *
     * @ORM\Column(name="finalizada", type="boolean", options={"default": false})
     */
    private $finalizada = false;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="id_usuario_alta", referencedColumnName="id", nullable=true)
     */
    private $userAlta;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="id_usuario_baja", referencedColumnName="id", nullable=true)
     */
    private $userBaja;

    /**
     *
     * @ORM\Column(name="stampAlta", type="integer", nullable=true)
     */
    private $stampAlta;

    /**
     *
     * @ORM\Column(name="stampBaja", type="integer", nullable=true)
     */
    private $stampBaja;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    private $empresa;


    public function updateCreate()
    {
        $fecha = new \DateTime();
        $this->stampAlta = $fecha->getTimestamp();
    }

    public function getUltimaComunicacion()
    {
        return $this->informadas->last();
    }

    public function getOrdenAsArray()
    {
      return array('idServicio' => $this->getTurno()->getId(),
                   'idOrden' =>  $this->id,
                   'idCronograma' => $this->getTurno()->getServicio()->getId(),
                   'Cronograma' => $this->getTurno()->getServicio()->getNombre(),
                   'idCliente' => $this->getTurno()->getServicio()->getCliente()->getId(),
                   'Cliente' => $this->getTurno()->getServicio()->getCliente().'',
                   'Origen' => $this->getTurno()->getServicio()->getOrigen().'',
                   'Destino' => $this->getTurno()->getServicio()->getDestino().'',
                   'Fecha_Servicio' => $this->fecha->format('Y-m-d'),
                   'interno' => $this->getUnidad()->getInterno(),
                   'Horario_Cabecera' => $this->salida->format('H:i:s'),
                   'Horario_Llegada' => $this->salida->format('H:i:s'),
                   'type' => $this->turno->getTipo(),
                   'direction' => $this->turno->getServicio()->getSentido()->getCodigo()
                  );
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

    /**
     * @Assert\IsTrue(message="La hora de salida no puede ser posterior a la hora de llegada del servicio!")
     */
    public function isHorariosValidos()
    {
        return $this->salida < $this->llegada;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setFechaServicio()
    {
        $this->fecha = $this->salida;
    }

    /**
     * Set conductor1
     *
     * @param \GestionBundle\Entity\rrhh\Conductor $conductor1
     *
     * @return OrdenServicio
     */
    public function setConductor1(\GestionBundle\Entity\rrhh\Conductor $conductor1 = null)
    {
        $this->conductor1 = $conductor1;

        return $this;
    }

    /**
     * Get conductor1
     *
     * @return \GestionBundle\Entity\rrhh\Conductor
     */
    public function getConductor1()
    {
        return $this->conductor1;
    }

    /**
     * Set conductor2
     *
     * @param \GestionBundle\Entity\rrhh\Conductor $conductor2
     *
     * @return OrdenServicio
     */
    public function setConductor2(\GestionBundle\Entity\rrhh\Conductor $conductor2 = null)
    {
        $this->conductor2 = $conductor2;

        return $this;
    }

    /**
     * Get conductor2
     *
     * @return \GestionBundle\Entity\rrhh\Conductor
     */
    public function getConductor2()
    {
        return $this->conductor2;
    }
    /**
     * Constructor
     */
    public function __construct(\AppBundle\Entity\Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->informadas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add informada
     *
     * @param \GestionBundle\Entity\comunicacion\OrdenInformada $informada
     *
     * @return OrdenServicio
     */
    public function addInformada(\GestionBundle\Entity\comunicacion\OrdenInformada $informada)
    {
        $this->informadas[] = $informada;

        return $this;
    }

    /**
     * Remove informada
     *
     * @param \GestionBundle\Entity\comunicacion\OrdenInformada $informada
     */
    public function removeInformada(\GestionBundle\Entity\comunicacion\OrdenInformada $informada)
    {
        $this->informadas->removeElement($informada);
    }

    /**
     * Get informadas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInformadas()
    {
        return $this->informadas;
    }

    /**
     * Set finalizada
     *
     * @param boolean $finalizada
     *
     * @return OrdenServicio
     */
    public function setFinalizada($finalizada)
    {
        $this->finalizada = $finalizada;

        return $this;
    }

    /**
     * Get finalizada
     *
     * @return boolean
     */
    public function getFinalizada()
    {
        return $this->finalizada;
    }

    /**
     * Set stampAlta
     *
     * @param integer $stampAlta
     *
     * @return OrdenServicio
     */
    public function setStampAlta($stampAlta)
    {
        $this->stampAlta = $stampAlta;

        return $this;
    }

    /**
     * Get stampAlta
     *
     * @return integer
     */
    public function getStampAlta()
    {
        return $this->stampAlta;
    }

    /**
     * Set userAlta
     *
     * @param \AppBundle\Entity\Usuario $userAlta
     *
     * @return OrdenServicio
     */
    public function setUserAlta(\AppBundle\Entity\Usuario $userAlta = null)
    {
        $this->userAlta = $userAlta;

        return $this;
    }

    /**
     * Get userAlta
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUserAlta()
    {
        return $this->userAlta;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return OrdenServicio
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
     * Set stampBaja
     *
     * @param integer $stampBaja
     *
     * @return OrdenServicio
     */
    public function setStampBaja($stampBaja)
    {
        $this->stampBaja = $stampBaja;

        return $this;
    }

    /**
     * Get stampBaja
     *
     * @return integer
     */
    public function getStampBaja()
    {
        return $this->stampBaja;
    }

    /**
     * Set userBaja
     *
     * @param \AppBundle\Entity\Usuario $userBaja
     *
     * @return OrdenServicio
     */
    public function setUserBaja(\AppBundle\Entity\Usuario $userBaja = null)
    {
        $this->userBaja = $userBaja;

        return $this;
    }

    /**
     * Get userBaja
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUserBaja()
    {
        return $this->userBaja;
    }
}
