<?php

namespace GestionBundle\Entity\trafico\opciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * FrecuenciaTurno
 *
 * @ORM\Table(name="trafico_opciones_frecuencia_turno")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\opciones\FrecuenciaTurnoRepository")
 */
class FrecuenciaTurno
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="diaSemana", type="integer")
     */
    private $diaSemana;


    public function __toString()
    {
        return strtoupper($this->nombre);
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return FrecuenciaTurno
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
     * Set diaSemana
     *
     * @param integer $diaSemana
     *
     * @return FrecuenciaTurno
     */
    public function setDiaSemana($diaSemana)
    {
        $this->diaSemana = $diaSemana;

        return $this;
    }

    /**
     * Get diaSemana
     *
     * @return int
     */
    public function getDiaSemana()
    {
        return $this->diaSemana;
    }
}
