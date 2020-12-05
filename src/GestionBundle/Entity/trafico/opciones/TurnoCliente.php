<?php

namespace GestionBundle\Entity\trafico\opciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * TurnoCliente
 *
 * @ORM\Table(name="trafico_opciones_turno_cliente")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\opciones\TurnoClienteRepository")
 */
class TurnoCliente
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
     * @ORM\Column(name="turno", type="string", length=255, unique=true)
     */
    private $turno;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    private $empresa;

    public function __toString()
    {
        return strtoupper($this->turno);
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
     * Set turno
     *
     * @param string $turno
     *
     * @return TurnoCliente
     */
    public function setTurno($turno)
    {
        $this->turno = $turno;

        return $this;
    }

    /**
     * Get turno
     *
     * @return string
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return TurnoCliente
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
}
