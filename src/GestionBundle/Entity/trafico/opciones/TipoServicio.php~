<?php

namespace GestionBundle\Entity\trafico\opciones;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * TipoServicio
 *
 * @ORM\Table(name="trafico_opciones_tipo_servicio")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\trafico\opciones\TipoServicioRepository")
 * @UniqueEntity(
 *     fields={"tipo", "empresa"},
 *     errorPath="tipo",
 *     message="Tipo de servicio existente en la Base de Datos"
 * )
 */

///Administrativo - Produccion - Over Time

class TipoServicio
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
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    private $empresa;
    

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

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return TipoServicio
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
