<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Entity\Medico;
use App\Entity\Beneficiario;
use App\Entity\Hospital;
use App\Repository\ConsultaRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ConsultaController extends AbstractController
{
    #[Route('/consulta', methods: ['GET'])]
    public function index(ConsultaRepository $repository):JsonResponse
    {
        $consultas = $repository->findAll();
        $result = [];

        foreach ($consultas as $consulta) {
            $result[] = [
                'id' => $consulta->getId(),
                'data' => $consulta->getData(),
                'status' => $consulta->getStatus(),
                'beneficiario' => $consulta->getBeneficiario()->getNome(),
                'medico' => $consulta->getMedico()->getNome(),
                'hospital' => $consulta->getHospital()->getNome(),
            ];
        }

        return new JsonResponse($result);

    }

    #[Route('/consulta', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $beneficiario = $entityManager->getRepository(Beneficiario::class)->find($data['beneficiario_id']);
        if (!$beneficiario) {
            return new JsonResponse(['error' => 'Beneficiário não encontrado'], 404);
        }

        $medico = $entityManager->getRepository(Medico::class)->find($data['medico_id']);
        if (!$medico) {
            return new JsonResponse(['error' => 'Médico não encontrado'], 404);
        }

        $hospital = $entityManager->getRepository(Hospital::class)->find($data['hospital_id']);
        if (!$hospital) {
            return new JsonResponse(['error' => 'Hospital não encontrado'], 404);
        }

        $consulta = new Consulta();
        $consulta->setData(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($beneficiario);
        $consulta->setMedico($medico);
        $consulta->setHospital($hospital);

        $entityManager->persist($consulta);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Consulta criada'], 201);
    }

    #[Route('/consulta/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, ConsultaRepository $repository, EntityManagerInterface $entityManager): JsonResponse
    {
        $consulta = $repository->find($id);
        if (!$consulta) {
            return new JsonResponse(['error' => 'Consulta nao encontrada'], 404);
        }

        if($consulta->getStatus() === 'Concluída'){
            return new JsonResponse(['error'=>'Nao e possivel alterar a consulta'], 400);
        }

        $data = json_decode($request->getContent(), true);
        
        $beneficiario = $entityManager->getRepository(Beneficiario::class)->find($data['beneficiario_id']);
        if (!$beneficiario) {
            return new JsonResponse(['error' => 'Beneficiario nao encontrado'], 404);
        }

        $medico = $entityManager->getRepository(Medico::class)->find($data['medico_id']);
        if (!$medico) {
            return new JsonResponse(['error' => 'Medico nao encontrado'], 404);
        }

        $hospital = $entityManager->getRepository(Hospital::class)->find($data['hospital_id']);
        if (!$hospital) {
            return new JsonResponse(['error' => 'Hospital nao encontrado'], 404);
        }

        $consulta->setData(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($beneficiario);
        $consulta->setMedico($medico);
        $consulta->setHospital($hospital);

        $entityManager->flush();

        return new JsonResponse(['status' => 'Consulta atualizada']);
    }

    #[Route('/consulta/{id}', methods: ['DELETE'])]
    public function delete(int $id, ConsultaRepository $repository, EntityManagerInterface $entityManager):JsonResponse
    {
        $result = $repository->find($id);
        if(!$result){
            return new JsonResponse(['error'=>'Consulta nao encontrada'], 404);
        }

        if($result->getStatus() === 'Concluída'){
            return new JsonResponse(['error'=>'Nao e possivel excluir a consulta'], 400);
        }

        $entityManager->remove($result);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Consulta excluida']);

    }
}
