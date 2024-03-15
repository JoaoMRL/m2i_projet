<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Repository\ObjetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/objets')]
class ObjetsController extends AbstractController{
    public function __construct(private ObjetsRepository $repo){}

    #[Route('/{id}', methods:'GET')]
    public function oneById(int $id):JsonResponse{
        $objets = $this->repo->findById($id);
        if ($objets == null) {
            return $this->json('Objets Not Found !',404);
        }
        return $this->json($objets);
    }

    #[Route('/user/{id}', methods:'GET')]
    public function oneByUser(int $id):JsonResponse{
        $objets = $this->repo->findByUserId($id);
        if ($objets == null) {
            return $this->json('Objets Not Found !',404);
        }
        return $this->json($objets);
    }

    #[Route('/search/{term}', methods: 'GET')]
    public function search(string $term): JsonResponse
    {
        return $this->json($this->repo->search($term));
    }

    #[Route(methods:'POST')]
    public function persist(Request $request, SerializerInterface $serializer, ValidatorInterface $validator):JsonResponse{
        try {
            $objet = $serializer->deserialize($request->getContent(), Objet::class,'json');
        } catch (\Exception $e) {
            return $this->json('Invalid body',400);
        }
        $errors = $validator->validate($objet);
        if ($errors->count() >0) {
            return $this->json(['errors' => $errors],400);
        }

        $this->repo->persist($objet);

        return $this->json($objet, 201);
    }

    #[Route('/{id}', methods:'PATCH')]
    public function update(int $id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator ):JsonResponse{
        try {
            $objet = $serializer->deserialize($request->getContent(), Objet::class,'json');
        } catch (\Exception $e) {
            return $this->json('Invalid body',400);
        }
        $errors = $validator->validate($objet);
        if ($errors->count() >0) {
            return $this->json(['errors' => $errors],400);
        }

        $this->repo->update($objet);
        return $this->json($objet, 201);
    }

    #[Route('/{id}', methods:'DELETE')]
    public function delete(int $id):JsonResponse{
        $objets = $this->repo->findById($id);
        if ($objets == null) {
            return $this->json('Objets Not Found !',404);
        }
        $this->repo->delete($id);

        return $this->json(null,204);
    }
}