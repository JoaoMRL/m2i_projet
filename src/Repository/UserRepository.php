<?php
namespace App\Repository;
use App\Entity\User;

class UserRepository{
    /**
     * @return User[] La liste des users de la bdd
     */
    public function findAll():array{
        $list = [];
        $req = "SELECT * FROM users";
        $connect = Database::getCo();

        $query = $connect->prepare($req);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $user = new User($line['name'],$line['firstName'],$line['address'],$line['email'],$line['password'],$line['role'],$line['phoneNumber'],$line['avatar'], $line['id']);
            $list[]= $user;
        }
        return $list;
    }

    /**
     * @return User L'user avec id
     */
    public function findById(int $id):?User{
        $connect = Database::getCo();
        $req = "SELECT * FROM users WHERE id = :id";

        $query = $connect->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $user = new User($line['name'],$line['firstName'],$line['address'],$line['email'],$line['password'],$line['role'],$line['phoneNumber'],$line['avatar'], $line['id']);
            return $user;
        }
        return null;
    }

    /**
     * @return User L'user avec l'email
     */
    public function findByEmail(string $email):?User{
        $connect = Database::getCo();
        $req = "SELECT * FROM users WHERE email = :email";

        $query = $connect->prepare($req);
        $query->bindValue(":email", $email);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $user = new User($line['name'],$line['firstName'],$line['address'],$line['email'],$line['password'],$line['role'],$line['phoneNumber'],$line['avatar'], $line['id']);
            return $user;
        }
        return null;
    }

    /**
     * Ajoute un User dans la bdd
     * @return
     */
    public function persist(User $user):void{
        $connection = Database::getCo();
        $req = "INSERT INTO users (name,firstName,address,email,password,role,phoneNumber,avatar) VALUES (:name,:firstName,:address,:email,:password,:role,:phoneNumber,:avatar)";

        $query=$connection->prepare($req);
        $query->bindValue(":name",$user->getName());
        $query->bindValue(":firstName",$user->getFirstName());
        $query->bindValue(":address",$user->getAddress());
        $query->bindValue(":email",$user->getUserIdentifier());
        $query->bindValue(":password",$user->getPassword());
        $query->bindValue(":role",$user->getRole());
        $query->bindValue(":phoneNumber",$user->getPhoneNumber());
        $query->bindValue(":avatar",$user->getAvatar());
        $query->execute();

        $user->setId($connection->lastInsertId());
    }

    /**
     * Update l'User
     * @return
     */
    public function update(User $user):void{
        $connection = Database::getCo();
        $req = "UPDATE users SET name=:name, firstName=:firstName, address=:address, email=:email, password=:password, phoneNumber=:phoneNumber, avatar=:avatar WHERE id = :id";

        $query=$connection->prepare($req);
        $query->bindValue(":name",$user->getName());
        $query->bindValue(":firstName",$user->getFirstName());
        $query->bindValue(":address",$user->getAddress());
        $query->bindValue(":email",$user->getUserIdentifier());
        $query->bindValue(":password",$user->getPassword());
        $query->bindValue(":phoneNumber",$user->getPhoneNumber());
        $query->bindValue(":avatar",$user->getAvatar());
        $query->bindValue(":id",$user->getId());
        $query->execute();
    }

}