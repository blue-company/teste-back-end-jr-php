<?php

namespace App\Controller;

use App\Entity\Hospital;
use App\Repository\HospitalRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HospitalController extends AbstractController
{
    #[Route('/hospital', methods:['GET'])]
    public function index(HospitalRepository $repository): JsonResponse
    {
        $hospitais = $repository->findAll();

        foreach ($hospitais as $hospital) {
            $result = [
                'id' => $hospital->getId(),
                'nome' => $hospital->getNome(),
                'endereco' => $hospital->getEndereco(),
            ];
        }
        return new JsonResponse($result);
    }

    #[Route('/hospital', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $hospital = new Hospital();

        $hospital->setNome($data['nome']);
        $hospital->setEndereco($data['endereco']);

        $entityManager->persist($hospital);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Hospital criado'],201);
    }

    #[Route('/hospital/{id}', methods:['PUT'])]
    public function update(int $id, Request $request, HospitalRepository $repository, EntityManagerInterface $entityManager):JsonResponse
    {
        $hospital = $repository->find($id);
        if (!$hospital) {
            return new JsonResponse(['error' => 'Hospital não existe'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $hospital->setNome($data['nome']);
        $hospital->setEndereco($data['endereco']);

        $entityManager->flush();

        return new JsonResponse(['status' => 'Hospital atualizado']);
    }

    #[Route('/hospital/{id}', methods: ['DELETE'])]
    public function delete(int $id, HospitalRepository $repository, EntityManagerInterface $entityManager):JsonResponse
    {
        $result = $repository->find($id);
        if(!$result){
            return new JsonResponse(['error'=>'Hospital não existe'], 404);
        }

        $entityManager->remove($result);
        $entityManager->flush();

        return JsonResponse(['status' => 'Hospital excluido com sucesso'], 201);
    
    }
}
