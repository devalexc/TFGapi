<?php
/**
 * Created by PhpStorm.
 * User: er_al
 * Date: 15/04/2018
 * Time: 14:00
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Cita
 *
 * @ORM\Table("citas")
 * @ORM\Entity
 */
class Cita
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
     * @var integer
     *
     * @ORM\Column(name="id_medico")
     * @ORM\ManyToOne(targetEntity="Medico")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $idMedico;
    /**
     * @var integer
     *
     * @ORM\Column(name="id_paciente")
     * @ORM\ManyToOne(targetEntity="Paciente")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $idPaciente;
    /**
     * @ORM\Column(type="date")
     */
    protected $dia;
    /**
     * @ORM\Column(type="time")
     */
    protected $hora;

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
     * @return int
     */
    public function getIdMedico()
    {
        return $this->idMedico;
    }

    /**
     * @param int $idMedico
     */
    public function setIdMedico($idMedico)
    {
        $this->idMedico = $idMedico;
    }

    /**
     * @return int
     */
    public function getIdPaciente()
    {
        return $this->idPaciente;
    }

    /**
     * @param int $idPaciente
     */
    public function setIdPaciente($idPaciente)
    {
        $this->idPaciente = $idPaciente;
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
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param mixed $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }



}