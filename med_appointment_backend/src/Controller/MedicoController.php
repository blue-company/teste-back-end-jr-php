<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Entity\Hospital;
use App\Repository\MedicoRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MedicoController extends AbstractController
{
    #[Route('/medico', methods:['GET'])]
    public function index(MedicoRepository $repository): JsonResponse
    {
        $medicos = $repository->findAll();

        foreach ($medicos as $medico) {
            $result[] = [
                'id' => $medico->getId(),
                'nome' => $medico->getNome(),
                'especialidade' => $medico->getEspecialidade(),
                'hospital' => $medico->getHospital()->getNome(),
            ];
        }
        return new JsonResponse($result);
    }

    #[Route('/medico', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $hospital = $entityManager->getRepository(Hospital::class)->find($data['hospital_id']);

        $medico = new Medico();
        $medico->setNome($data['nome']);
        $medico->setEspecialidade($data['especialidade']);
        $medico->setHospital($hospital);

        $entityManager->persist($medico);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Medico criado'],201);
    }

    #[Route('/medico/{id}', methods:['PUT'])]
    public function update(int $id, Request $request, MedicoRepository $repository, EntityManagerInterface $entityManager):JsonResponse
    {
        $medico = $repository->find($id);
        if (!$medico) {
            return new JsonResponse(['error' => 'Medico não existe'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $hospital = $entityManager->getRepository(Hospital::class)->find($data['hospital_id']);

        $medico->setNome($data['nome']);
        $medico->setEspecialidade($data['especialidade']);
        $medico->setHospital($hospital);

        $entityManager->flush();

        return new JsonResponse(['status' => 'Medico atualizado']);
    }

    #[Route('/medico/{id}', methods: ['DELETE'])]
    public function delete(int $id, MedicoRepository $repository, EntityManagerInterface $entityManager):JsonResponse
    {
        $result = $repository->find($id);
        if(!$result){
            return new JsonResponse(['error'=>'Medico não existe'], 404);
        }

        $entityManager->remove($result);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Medico excluido com sucesso'], 201);

    }
}
