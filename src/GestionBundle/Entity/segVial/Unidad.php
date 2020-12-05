<?php

namespace GestionBundle\Entity\segVial;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unidad
 *
 * @ORM\Table(name="seg_vial_unidades")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\segVial\UnidadRepository")
 */
class Unidad
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
     * @var int
     *
     * @ORM\Column(name="interno", type="integer")
     */
    private $interno;

    /**
     * @var string
     *
     * @ORM\Column(name="chasisMarca", type="string", length=255)
     */
    private $chasisMarca;

    /**
     * @var string
     *
     * @ORM\Column(name="chasisModelo", type="string", length=255)
     */
    private $chasisModelo;

    /**
     * @var string
     *
     * @ORM\Column(name="carroceriaMarca", type="string", length=255)
     */
    private $carroceriaMarca;

    /**
     * @var string
     *
     * @ORM\Column(name="carroceriaModelo", type="string", length=255)
     */
    private $carroceriaModelo;

    /**
     * @var int
     *
     * @ORM\Column(name="capacidadReal", type="integer")
     */
    private $capacidadReal;

    /**
     * @var string
     *
     * @ORM\Column(name="dominioAnterior", type="string", length=7)
     */
    private $dominioAnterior;

    /**
     * @var string
     *
     * @ORM\Column(name="dominioNuevo", type="string", length=9, nullable=true)
     */
    private $dominioNuevo;

    /**
     * @var int
     *
     * @ORM\Column(name="anioModelo", type="integer")
     */
    private $anioModelo;


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
     * Set interno
     *
     * @param integer $interno
     *
     * @return Unidad
     */
    public function setInterno($interno)
    {
        $this->interno = $interno;

        return $this;
    }

    /**
     * Get interno
     *
     * @return integer
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set chasisMarca
     *
     * @param string $chasisMarca
     *
     * @return Unidad
     */
    public function setChasisMarca($chasisMarca)
    {
        $this->chasisMarca = $chasisMarca;

        return $this;
    }

    /**
     * Get chasisMarca
     *
     * @return string
     */
    public function getChasisMarca()
    {
        return $this->chasisMarca;
    }

    /**
     * Set chasisModelo
     *
     * @param string $chasisModelo
     *
     * @return Unidad
     */
    public function setChasisModelo($chasisModelo)
    {
        $this->chasisModelo = $chasisModelo;

        return $this;
    }

    /**
     * Get chasisModelo
     *
     * @return string
     */
    public function getChasisModelo()
    {
        return $this->chasisModelo;
    }

    /**
     * Set carroceriaMarca
     *
     * @param string $carroceriaMarca
     *
     * @return Unidad
     */
    public function setCarroceriaMarca($carroceriaMarca)
    {
        $this->carroceriaMarca = $carroceriaMarca;

        return $this;
    }

    /**
     * Get carroceriaMarca
     *
     * @return string
     */
    public function getCarroceriaMarca()
    {
        return $this->carroceriaMarca;
    }

    /**
     * Set carroceriaModelo
     *
     * @param string $carroceriaModelo
     *
     * @return Unidad
     */
    public function setCarroceriaModelo($carroceriaModelo)
    {
        $this->carroceriaModelo = $carroceriaModelo;

        return $this;
    }

    /**
     * Get carroceriaModelo
     *
     * @return string
     */
    public function getCarroceriaModelo()
    {
        return $this->carroceriaModelo;
    }

    /**
     * Set capacidadReal
     *
     * @param integer $capacidadReal
     *
     * @return Unidad
     */
    public function setCapacidadReal($capacidadReal)
    {
        $this->capacidadReal = $capacidadReal;

        return $this;
    }

    /**
     * Get capacidadReal
     *
     * @return integer
     */
    public function getCapacidadReal()
    {
        return $this->capacidadReal;
    }

    /**
     * Set dominioAnterior
     *
     * @param string $dominioAnterior
     *
     * @return Unidad
     */
    public function setDominioAnterior($dominioAnterior)
    {
        $this->dominioAnterior = $dominioAnterior;

        return $this;
    }

    /**
     * Get dominioAnterior
     *
     * @return string
     */
    public function getDominioAnterior()
    {
        return $this->dominioAnterior;
    }

    /**
     * Set dominioNuevo
     *
     * @param string $dominioNuevo
     *
     * @return Unidad
     */
    public function setDominioNuevo($dominioNuevo)
    {
        $this->dominioNuevo = $dominioNuevo;

        return $this;
    }

    /**
     * Get dominioNuevo
     *
     * @return string
     */
    public function getDominioNuevo()
    {
        return $this->dominioNuevo;
    }

    /**
     * Set anioModelo
     *
     * @param integer $anioModelo
     *
     * @return Unidad
     */
    public function setAnioModelo($anioModelo)
    {
        $this->anioModelo = $anioModelo;

        return $this;
    }

    /**
     * Get anioModelo
     *
     * @return integer
     */
    public function getAnioModelo()
    {
        return $this->anioModelo;
    }
}
