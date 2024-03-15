<?php 

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/annonces')]
class AnnoncesController extends AbstractController{
    public function __construct(private AnnoncesRepository $repo){}

    #[Route(methods: 'GET')]
    public function all(): JsonResponse
    {
        return $this->json($this->repo->findAll());
    }

    #[Route('/{id}', methods: 'GET')]
    public function one(int $id):JsonResponse{
        $annonce =$this->repo->findById($id);
        if ($annonce == null) {
            return $this->json('Annonce Not found', 404);
        }
        return $this->json($annonce);
    }
    #[Route('/user/{id}', methods:'GET')]
    public function oneByUser(int $id):JsonResponse{
        $annonce = $this->repo->findByUserId($id);
        if ($annonce == null) {
            return $this->json('Annonce Not Found !',404);
        }
        return $this->json($annonce);
    }

    #[Route('/search/{term}', methods: 'GET')]
    public function search(string $term): JsonResponse
    {
        return $this->json($this->repo->search($term));
    }

    #[Route(methods: 'POST')]
    public function persist(Request $request, SerializerInterface $serializer, ValidatorInterface $validator):JsonResponse{
        try {
            $annonce = $serializer->deserialize($request->getContent(), Annonces::class,'json');
        } catch (\Exception $e) {
            return $this->json('Invalid body',400);
        }
        $errors = $validator->validate($annonce);
        if ($errors->count() >0) {
            return $this->json(['errors' => $errors],400);
        }

        $this->repo->persist($annonce);

        return $this->json($annonce, 201);
    }

    #[Route('/{id}', methods: 'PATCH')]
    public function update(int $id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator ):JsonResponse{
        try {
            $annonce = $serializer->deserialize($request->getContent(), Annonces::class,'json');
        } catch (\Exception $e) {
            return $this->json('Invalid body',400);
        }
        $errors = $validator->validate($annonce);
        if ($errors->count() >0) {
            return $this->json(['errors' => $errors],400);
        }

        $this->repo->update($annonce);
        return $this->json($annonce, 201);
    }

    #[Route('/{id}', methods:'DELETE')]
    public function delete(int $id):JsonResponse{
        $annonce = $this->repo->findById($id);
        if ($annonce == null) {
            return $this->json('Annonce Not Found !',404);
        }
        $this->repo->delete($id);

        return $this->json(null,204);
    }
}