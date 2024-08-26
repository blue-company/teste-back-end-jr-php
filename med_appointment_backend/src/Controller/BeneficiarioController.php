<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Beneficiario;
use App\Repository\BeneficiarioRepository;
use Doctrine\ORM\EntityManagerInterface;

class BeneficiarioController extends AbstractController
{
    #[Route('/beneficiario', methods: ['GET'])]
    public function index(BeneficiarioRepository $repository): JsonResponse
    {
        $beneficiarios = $repository->findAll();

        foreach ($beneficiarios as $beneficiario) {
            $result[] = [
                'id' => $beneficiario->getId(),
                'nome' => $beneficiario->getNome(),
                'email' => $beneficiario->getEmail(),
                'data_nascimento' => $beneficiario->getDataNascimento()->format('Y-m-d'),
            ];
        }

        return new JsonResponse($result);
    }

    #[Route('/beneficiario', methods:['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $beneficiario = new Beneficiario();
        $beneficiario->setNome($data['nome']);
        $beneficiario->setEmail($data['email']);
        $beneficiario->setDataNascimento(new \DateTime($data['data_nascimento']));
    
        $hoje = new \DateTime();
        $idade = $hoje->diff($beneficiario->getDataNascimento())->y;

        if($idade < 18){
            return new JsonResponse(['error' => 'Beneficiario precisa ter pelo menos 18 anos'], 404);
        }

        $entityManager->persist($beneficiario);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Beneficiário criado'], 201);
    }

    #[Route('/beneficiario/{id}', methods:['PUT'])]
    public function update(int $id, Request $request, BeneficiarioRepository $repository, EntityManagerInterface $entityManager):JsonResponse
    {
        $beneficiario = $repository->find($id);
        if (!$beneficiario) {
            return new JsonResponse(['error' => 'Beneficiário não existe'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $beneficiario->setNome($data['nome']);
        $beneficiario->setEmail($data['email']);
        $beneficiario->setDataNascimento(new \DateTime($data['data_nascimento']));

        $entityManager->flush();

        return new JsonResponse(['status' => 'Beneficiário atualizado']);

    }

    #[Route('/beneficiario/{id}', methods: ['DELETE'])]
    public function delete(int $id, BeneficiarioRepository $repository, EntityManagerInterface $entityManager): JsonResponse
    {
        $beneficiario = $repository->find($id);
        if(!$beneficiario){
            return new JsonResponse('error', 'Beneficiário não existe', 404);
        }

        $entityManager->remove($beneficiario);
        $entityManager->flush();

        return new JsonResponse(['status'=>'Beneficiário excluído com sucesso']);
    }
}
