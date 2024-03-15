<?php 

namespace App\Controller;

use App\Entity\Emprunts;
use App\Repository\EmpruntsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/emprunts')]
class EmpruntsController extends AbstractController{
    public function __construct(private EmpruntsRepository $repo){}

    #[Route(methods: 'GET')]
    public function all(): JsonResponse
    {
        return $this->json($this->repo->findAll());
    }

    #[Route('/{id}', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $emprunt = $this->repo->findById($id);
        if ($emprunt == null) {
            return $this->json('Emprunt Not found', 404);
        }

        return $this->json($emprunt);
    }

    #[Route('/user/{id}', methods:'GET')]
    public function oneByUser(int $id):JsonResponse{
        $emprunt = $this->repo->findByUserId($id);
        if ($emprunt == null) {
            return $this->json('Emprunts Not Found !',404);
        }
        return $this->json($emprunt);
    }
    #[Route('/search/{term}', methods: 'GET')]
    public function search(string $term): JsonResponse
    {
        return $this->json($this->repo->search($term));
    }

    #[Route(methods: 'POST')]
    public function persist(Request $request, SerializerInterface $serializer, ValidatorInterface $validator):JsonResponse{
        try {
            $emprunt = $serializer->deserialize($request->getContent(), Emprunts::class,'json');
        } catch (\Exception $e) {
            return $this->json('Invalid body',400);
        }
        $errors = $validator->validate($emprunt);
        if ($errors->count() >0) {
            return $this->json(['errors' => $errors],400);
        }

        $this->repo->persist($emprunt);

        return $this->json($emprunt, 201);
    }

    #[Route('/{id}', methods:'PATCH')]
    public function update(int $id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator ):JsonResponse{
        try {
            $emprunt = $serializer->deserialize($request->getContent(), Emprunts::class,'json');
        } catch (\Exception $e) {
            return $this->json('Invalid body',400);
        }
        $errors = $validator->validate($emprunt);
        if ($errors->count() >0) {
            return $this->json(['errors' => $errors],400);
        }

        $this->repo->update($emprunt);
        return $this->json($emprunt, 201);
    }

    #[Route('/{id}', methods:'DELETE')]
    public function delete(int $id):JsonResponse{
        $emprunt = $this->repo->findById($id);
        if ($emprunt == null) {
            return $this->json('Emprunt Not Found !',404);
        }
        $this->repo->delete($id);

        return $this->json(null,204);
    }
}