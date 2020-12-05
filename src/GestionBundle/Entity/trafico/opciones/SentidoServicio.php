<?php

namespace GestionBundle\Entity\trafico\opciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * SentidoServicio
 *
 * @ORM\Table(name="trafico_opciones_sentido_servicio")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\opciones\SentidoServicioRepository")
 */
//////////Entrada - Salida - Rondin - BackUp

class SentidoServicio
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
     * @ORM\Column(name="tipo", type="string", length=255, unique=true)
     */
    private $tipo;

    public function __toString()
    {
        return strtoupper($this->tipo);
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return TipoServicio
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
