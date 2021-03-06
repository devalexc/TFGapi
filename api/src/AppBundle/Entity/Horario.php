<?php
/**
 * Created by PhpStorm.
 * User: er_al
 * Date: 15/04/2018
 * Time: 1:26
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Medico
 *
 * @ORM\Table("horarios")
 * @ORM\Entity
 */
class Horario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="id_medico")
     * @ORM\ManyToOne(targetEntity="Medico")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $idMedico;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')")
     */
    protected $dia;
    /**
     * @ORM\Column(type="time", name="hora_inicio")
     */
    protected $horaInicio;
    /**
     * @ORM\Column(type="time", name="hora_fin")
     */
    protected $horaFin;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdMedico()
    {
        return $this->idMedico;
    }

    /**
     * @param mixed $idMedico
     */
    public function setIdMedico($idMedico)
    {
        $this->idMedico = $idMedico;
    }

    /**
     * @return mixed
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param mixed $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @return mixed
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * @param mixed $horaInicio
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;
    }

    /**
     * @return mixed
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * @param mixed $horaFin
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;
    }


}
