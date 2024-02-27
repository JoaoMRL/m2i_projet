<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Uploader;

#[Route('/api/user')]
class UserController extends AbstractController{
    public function __construct(private UserRepository $repo){}

    #[Route(methods:'GET')]
    public function all():JsonResponse{
        return $this->json($this->repo->findAll());
    }

    #[Route('/{id}',methods:'GET')]
    public function one(int $id):JsonResponse{
        $user = $this->repo->findById($id);
        if ($user == null) {
            return $this->json('User not found',404);
        }
        return $this->json($user);
    }
    
    #[Route('/{id}',methods:'PATCH')]
    public function update(int $id,Request $request, SerializerInterface $serializer, ValidatorInterface $validator):JsonResponse{
        $user = $this->repo->findById($id);
        if ($user == null) {
            return $this->json('User Not Found',404);
        }
        try {
            $serializer->deserialize($request->getContent(), User::class,'json',[
                'object_to_populate'=>$user
            ]);
        } catch (\Exception $e) {
            return $this->json('Invalid body', 400);
        }
        $errors = $validator->validate($user);
        if ($errors->count()>0) {
            return $this->json(['errors'=>$errors],400);
        }
        $this->repo->update($user);

        return $this->json($user);
    }
}