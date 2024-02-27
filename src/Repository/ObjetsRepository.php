<?php 
namespace App\Repository;

use App\Entity\Objet;
use App\Entity\User;

class ObjetsRepository{

    /**
     * @return Objet[] La liste des objets par rapport a l'id 
     */
    public function findById(int $id):?Objet{
        $connect = Database::getCo();
        $req = "SELECT objets.*, objets.name AS objet_name, users.name AS user_name, objets.id AS objet_id, users.id AS user_id,
        users.firstName,users.address, users.email, users.phoneNumber, users.avatar
        FROM objets LEFT JOIN users ON users.id = objets.owner  
        WHERE objets.id = :id";

        $query = $connect->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $objet= new Objet($line['objet_name'],$line['description'],$line['owner'],$line['objet_id'],$line['image']);
            $objet->setTheOwner(["ownerName"=>$line['user_name'],"ownerFirstName"=>$line['firstName'],"ownerAddress"=>$line['address'],"ownerEmail"=>$line['email'], "ownerPhoneNumber"=>$line['phoneNumber'],"ownerAvatar"=>$line["avatar"]]);
            return $objet;
        }
        return null;
    }

    /**
     * @return Objet[] Tableau d'objets de l'user 
     */
    public function findByUserId(int $id):array{
        $list=[];
        $connect = Database::getCo();
        $req= "SELECT *, objets.name AS objet_name, users.name AS user_name, objets.id AS objet_id, users.id AS user_id, 
        users.firstName,users.address, users.email 
        FROM objets LEFT JOIN users ON users.id = objets.owner
        WHERE objets.owner = :id";

        $query = $connect->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();

        foreach ($query->fetchAll() as $line) {
            $objet= new Objet($line['objet_name'],$line['description'],$line['owner'],$line['objet_id'],$line['image'],);
            $objet->setTheOwner(["ownerName"=>$line['user_name'],"ownerFirstName"=>$line['firstName'],"ownerAddress"=>$line['address'],"ownerEmail"=>$line['email']]);
            $list[]=$objet;
        }

        return $list;
    }

    /**
     * Ajoute un Objet
     * @return
     */
    public function persist(Objet $objet):void{
        $connection = Database::getCo();
        $req = "INSERT INTO objets (name, description, owner, image) VALUES (:name, :description, :owner, :image)";

        $query=$connection->prepare($req);
        $query->bindValue(":name",$objet->getName());
        $query->bindValue(":description",$objet->getDescription());
        $query->bindValue(":owner",$objet->getOwner());
        $query->bindValue(":image",$objet->getImg());
        $query->execute();

        $objet->setId($connection->lastInsertId());
    }

    /**
     * Update l'objet
     * @return
     */
    public function update(Objet $objet):void{
        $connection = Database::getCo();
        $req = "UPDATE objets SET name=:name,description=:description,owner=:owner,image=:image WHERE id=:id";
        
        $query=$connection->prepare($req);
        $query->bindValue(":name",$objet->getName());
        $query->bindValue(":description",$objet->getDescription());
        $query->bindValue(":owner",$objet->getOwner());
        $query->bindValue(":image",$objet->getImg());
        $query->bindValue(":id",$objet->getId());
        $query->execute();
    }

    /**
     * Supprime l'objet
     * @return
     */
    public function delete(int $id):void{
        $connection = Database::getCo();
        $req = "DELETE FROM objets WHERE id=:id";

        $query = $connection->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();
    }
}