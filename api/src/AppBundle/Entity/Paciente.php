<?php
/**
 * Created by PhpStorm.
 * User: er_al
 * Date: 15/04/2018
 * Time: 2:58
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Paciente
 *
 * @ORM\Table("pacientes")
 * @ORM\Entity
 */
class Paciente
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id_usuario")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $id;
    /**
     * @var integer
     *
     * @ORM\Column(name="id_medico")
     * @ORM\OneToOne(targetEntity="Medico")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $idMedico;

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


}