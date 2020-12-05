<?php

namespace GestionBundle\Entity\ventas;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Ciudad
 *
 * @ORM\Table(name="ventas_ciudad")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\ventas\CiudadRepository")
 * @UniqueEntity(
 *     fields={"nombre", "empresa"},
 *     errorPath="nombre",
 *     message="Ciudad existente en la Base de Datos"
 * )
 */
class Ciudad
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
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumn(name="id_provincia", referencedColumnName="id")
     * @Assert\NotNull(message="El campo no puede permanecer en blanco")
     */
    private $provincia;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    private $empresa;
    

    public function __toString()
    {
        return $this->nombre;
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
     * @return Ciudad
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
     * Set provincia
     *
     * @param \GestionBundle\Entity\ventas\Provincia $provincia
     *
     * @return Ciudad
     */
    public function setProvincia(\GestionBundle\Entity\ventas\Provincia $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \GestionBundle\Entity\ventas\Provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Ciudad
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
