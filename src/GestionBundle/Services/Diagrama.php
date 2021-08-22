<?php
namespace GestionBundle\Services;
use GestionBundle\Entity\trafico\OrdenServicio;
 
class Diagrama {
 
    public function diagramarOrdenServicio(\GestionBundle\Entity\trafico\Turno $turno, \DateTime $fecha, \AppBundle\Entity\Empresa $empresa){
        $orden = new OrdenServicio($empresa);
        $orden->setFecha($fecha);
        $salida = \DateTime::createFromFormat('Y-m-dH:i:s', $fecha->format('Y-m-d').$turno->getHoraInicial()->format('H:i:s'));
        $llegada = clone $salida;
        $llegada->add(new \DateInterval('PT'.$turno->getDuracion()->format('H').'H'.$turno->getDuracion()->format('i').'M'));
        $orden->setSalida($salida);
        $orden->setLlegada($llegada);
        $orden->setTurno($turno);
        return $orden;
    }
     
}
