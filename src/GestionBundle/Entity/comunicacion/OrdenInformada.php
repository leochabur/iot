<?php

namespace GestionBundle\Entity\comunicacion;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdenInformada
 *
 * @ORM\Table(name="comunicacion_orden_informada")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\comunicacion\OrdenInformadaRepository")
 */
class OrdenInformada
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
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="request", type="text")
     */
    private $request;

    /**
     * @var string
     *
     * @ORM\Column(name="respuestaJson", type="text")
     */
    private $respuestaJson;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="mensajeRespuesta", type="text")
     */
    private $mensajeRespuesta;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\trafico\OrdenServicio", inversedBy="informadas")
     * @ORM\JoinColumn(name="id_orden", referencedColumnName="id")
     */
    private $orden;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return OrdenInformada
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
     * Set request
     *
     * @param string $request
     *
     * @return OrdenInformada
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set respuestaJson
     *
     * @param string $respuestaJson
     *
     * @return OrdenInformada
     */
    public function setRespuestaJson($respuestaJson)
    {
        $this->respuestaJson = $respuestaJson;

        return $this;
    }

    /**
     * Get respuestaJson
     *
     * @return string
     */
    public function getRespuestaJson()
    {
        return $this->respuestaJson;
    }

    /**
     * Set mensajeRespuesta
     *
     * @param string $mensajeRespuesta
     *
     * @return OrdenInformada
     */
    public function setMensajeRespuesta($mensajeRespuesta)
    {
        $this->mensajeRespuesta = $mensajeRespuesta;

        return $this;
    }

    /**
     * Get mensajeRespuesta
     *
     * @return string
     */
    public function getMensajeRespuesta()
    {
        return $this->mensajeRespuesta;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return OrdenInformada
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set orden
     *
     * @param \GestionBundle\Entity\trafico\OrdenServicio $orden
     *
     * @return OrdenInformada
     */
    public function setOrden(\GestionBundle\Entity\trafico\OrdenServicio $orden = null)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return \GestionBundle\Entity\trafico\OrdenServicio
     */
    public function getOrden()
    {
        return $this->orden;
    }
}
