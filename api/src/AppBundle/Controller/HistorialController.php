<?php
/**
 * Created by PhpStorm.
 * User: er_al
 * Date: 19/05/2018
 * Time: 17:26
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Adjunto;
use AppBundle\Entity\AdjuntoConsulta;
use AppBundle\Entity\AdjuntoPaciente;
use AppBundle\Entity\Cita;
use AppBundle\Entity\Consulta;
use AppBundle\Entity\ConsultaEspecialidad;
use AppBundle\Entity\ConsultaMedico;
use AppBundle\Entity\EnfermedadesCronicas;
use AppBundle\Entity\Especialidad;
use AppBundle\Entity\Historial;
use AppBundle\Entity\Medico;
use AppBundle\Entity\Paciente;
use AppBundle\Entity\Respuesta;
use AppBundle\Entity\RespuestaPacienteConsulta;
use AppBundle\Entity\User;
use DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Date;


class HistorialController extends FOSRestController
{
    /**
     * @Route("/api/patient/historical/{id}", name="show_historical")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getHistorical($id)
    {
        $conn = $this->getDoctrine()->getConnection();

        $sql = 'SELECT h.id,h.causa,h.diagnostico,h.notas,h.fecha,CONCAT(u.nombre," " ,u.apellido)as nombre_medico FROM historial h inner join pacientes p on h.id_paciente=p.id_usuario inner join usuarios u on h.id_medico=u.id WHERE p.id_usuario=:id and h.id=:idhistorical';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $this->get('security.token_storage')->getToken()->getUser()->getId(), 'idhistorical' => $id]);
        return $this->handleView($this->view(array("status" => 200, "message" => "", "type" => 1, "data" => $stmt->fetch())));

    }

    /**
     * @Route("/api/patient/historical")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getHistoricals(Request $request)
    {

        $offset = (int)$request->get("offset");
        $conn = $this->getDoctrine()->getConnection();
        $sql2 = 'SELECT COUNT(*) as c FROM historial h inner join pacientes p on h.id_paciente=p.id_usuario inner join usuarios u on h.id_medico=u.id inner join medicos m on m.id_usuario=u.id inner join centros c on c.id=m.id_centro WHERE p.id_usuario=:id ';
        $count = $conn->prepare($sql2);
        $count->execute(['id' => $this->get('security.token_storage')->getToken()->getUser()->getId()]);
        $number = (int)$count->fetch()['c'];
        if ($number == 0) {
            return $this->templateJson(200, "", 1, array("count" => $number, "rows" => []));
        }


        $sql = 'SELECT h.id,h.causa,h.diagnostico,h.notas,h.fecha,CONCAT(u.nombre," " ,u.apellido)as nombre_medico, c.nombre as centro_salud,c.ciudad as direccion_centro FROM historial h inner join pacientes p on h.id_paciente=p.id_usuario inner join usuarios u on h.id_medico=u.id inner join medicos m on m.id_usuario=u.id inner join centros c on c.id=m.id_centro WHERE p.id_usuario=:id limit 20 offset ' . $offset;
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $this->get('security.token_storage')->getToken()->getUser()->getId()]);
        return $this->templateJson(200, "", 1, array("count" => $number, "rows" => $stmt->fetchAll()));


    }

    /**
     * @Route("/api/medic/user/{user}/historical/{id}", name="show_historical")
     * @param $id
     * @param $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getHistoricalMedic($id, $user)
    {
        $conn = $this->getDoctrine()->getConnection();

        $sql = 'SELECT h.id,h.causa,h.diagnostico,h.notas,h.fecha,CONCAT(u.nombre," " ,u.apellido)as nombre_medico FROM historial h inner join pacientes p on h.id_paciente=p.id_usuario inner join usuarios u on h.id_medico=u.id WHERE p.id_usuario=:id and h.id=:idhistorical';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $user, 'idhistorical' => $id]);
        return $this->handleView($this->view(array("status" => 200, "message" => "", "type" => 1, "data" => $stmt->fetch())));

    }

    /**
     * @Route("/api/medic/user/{user}/historical")
     * @param $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getHistoricalsMedic($user, Request $request)
    {
        $offset = (int)$request->get("offset");
        $conn = $this->getDoctrine()->getConnection();
        $sql2 = 'SELECT COUNT(*) as c FROM historial h inner join pacientes p on h.id_paciente=p.id_usuario inner join usuarios u on h.id_medico=u.id inner join medicos m on m.id_usuario=u.id inner join centros c on c.id=m.id_centro WHERE p.id_usuario=:id limit 20 offset ' . $offset;
        $count = $conn->prepare($sql2);
        $count->execute(['id' => $user]);
        $number = (int)$count->fetch()['c'];
        if ($number == 0) {
            return $this->templateJson(200, "", 1, array("count" => $number, "rows" => []));
        }


        $sql = 'SELECT h.id,h.causa,h.diagnostico,h.notas,h.fecha,CONCAT(u.nombre," " ,u.apellido)as nombre_medico, c.nombre as centro_salud,c.ciudad as direccion_centro FROM historial h inner join pacientes p on h.id_paciente=p.id_usuario inner join usuarios u on h.id_medico=u.id inner join medicos m on m.id_usuario=u.id inner join centros c on c.id=m.id_centro WHERE p.id_usuario=:id limit 20 offset ' . $offset;
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $user]);
        return $this->templateJson(200, "", 1, array("count" => $number, "rows" => $stmt->fetchAll()));
    }

    /**
     * @param $status
     * @param $message
     * @param $type
     * @param $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function templateJson($status, $message, $type, $data)
    {
        return $this->handleView($this->view(array("status" => $status, "message" => $message, "type" => $type, "data" => $data)));
    }
}