<?php
namespace App\Repository;
use App\Entity\Annonces;

class AnnoncesRepository{
    /**
     * @return Annonces[]
     */
    public function findAll():array{
        $list = [];
        $req = "SELECT annonces.*, annonces.id AS annonce_id, users.id AS user_id,
        objets.id AS objet_id,  annonces.name AS annonce_name,users.name AS user_name,
        objets.name AS objet_name, annonces.owner AS annonce_owner, objets.owner AS objet_owner,
        users.firstName,users.address, users.email, users.phoneNumber, users.avatar,
        objets.description, objets.image
        FROM annonces LEFT JOIN users ON annonces.owner = users.id 
        LEFT JOIN objets ON annonces.idObjet = objets.id";
        $connect = Database::getCo();

        $query = $connect->prepare($req);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $annonce = new Annonces($line['name'],$line['type'],$line['msg'],$line['owner'],$line['idObjet'],$line['status'],$line['id']);
            $annonce->setTheOwner(["ownerName"=>$line['user_name'],"ownerFirstName"=>$line['firstName'],"ownerAddress"=>$line['address'],"ownerEmail"=>$line['email'], "ownerPhoneNumber"=>$line['phoneNumber'],"ownerAvatar"=>$line["avatar"]]);
            $annonce->setTheObjet(["objetName"=>$line['objet_name'],"objetDescription"=>$line['description'],"objetImg"=>$line['image']]);
            $list[]= $annonce;
        }
        return $list;
    }

    /**
     * @return Annonces
     */
    public function findById(int $id):?Annonces{
        $connect = Database::getCo();
        $req = "SELECT annonces.*, annonces.id AS annonce_id, users.id AS user_id,
        objets.id AS objet_id,  annonces.name AS annonce_name,users.name AS user_name,
        objets.name AS objet_name, annonces.owner AS annonce_owner, objets.owner AS objet_owner,
        users.firstName,users.address, users.email, users.phoneNumber, users.avatar,
        objets.description, objets.image 
        FROM annonces LEFT JOIN users ON annonces.owner = users.id 
        LEFT JOIN objets ON annonces.idObjet = objets.id 
        WHERE annonces.id = :id";

        $query = $connect->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $annonce = new Annonces($line['name'],$line['type'],$line['msg'],$line['owner'],$line['idObjet'],$line['status'],$line['id']);
            $annonce->setTheOwner(["ownerName"=>$line['user_name'],"ownerFirstName"=>$line['firstName'],"ownerAddress"=>$line['address'],"ownerEmail"=>$line['email'], "ownerPhoneNumber"=>$line['phoneNumber'],"ownerAvatar"=>$line["avatar"]]);
            $annonce->setTheObjet(["objetName"=>$line['objet_name'],"objetDescription"=>$line['description'],"objetImg"=>$line['image']]);
            return $annonce;
        }
        return null;
    }

    /**
     * @return Annonces[] Tableau d'objets de l'user 
     */
    public function findByUserId(int $id):array{
        $list=[];
        $connect = Database::getCo();
        $req= "SELECT annonces.*, annonces.id AS annonce_id, users.id AS user_id,
        objets.id AS objet_id,  annonces.name AS annonce_name,users.name AS user_name,
        objets.name AS objet_name, annonces.owner AS annonce_owner, objets.owner AS objet_owner,
        users.firstName,users.address, users.email, users.phoneNumber, users.avatar,
        objets.description, objets.image 
        FROM annonces LEFT JOIN users ON annonces.owner = users.id 
        WHERE annonces.owner = :id";

        $query = $connect->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $annonce = new Annonces($line['name'],$line['type'],$line['msg'],$line['owner'],$line['idObjet'],$line['status'],$line['id']);
            $annonce->setTheOwner(["ownerName"=>$line['user_name'],"ownerFirstName"=>$line['firstName'],"ownerAddress"=>$line['address'],"ownerEmail"=>$line['email'], "ownerPhoneNumber"=>$line['phoneNumber'],"ownerAvatar"=>$line["avatar"]]);
            $annonce->setTheObjet(["objetName"=>$line['objet_name'],"objetDescription"=>$line['description'],"objetImg"=>$line['image']]);
            $list[]= $annonce;
        }
        return $list;
    }

    /**
     * Search Annonce
    */
    public function search(string $term):array{
        $list = [];
        $connect = Database::getCo();
        $req = "SELECT * FROM annonces WHERE name LIKE :term";

        $query = $connect->prepare($req);
        $query->bindValue(":term", $term);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $annonce = new Annonces($line['name'],$line['type'],$line['msg'],$line['owner'],$line['idObjet'],$line['status'],$line['id']);
            $list[]= $annonce;
        }
        return $list;
    }

    /**
     * Ajoute une Annonce
     */
    public function persist(Annonces $annonces):void{
        $connection = Database::getCo();
        $req = "INSERT INTO annonces (name, type, msg, owner, idObjet, status) VALUES (:name, :type, :msg, :owner, :idObjet, :status)";
        
        $query=$connection->prepare($req);
        $query->bindValue(":name", $annonces->getName());
        $query->bindValue(":type", $annonces->getType());
        $query->bindValue(":msg", $annonces->getMsg());
        $query->bindValue(":owner", $annonces->getOwner());
        $query->bindValue(":idObjet", $annonces->getIdObjet());
        $query->bindValue(":status", $annonces->getStatus());
        $query->execute();

        $annonces->setId($connection->lastInsertId());
    }

    /**
     * Update une annonce
     */
    public function update(Annonces $annonces):void{
        $connection = Database::getCo();
        $req = "UPDATE annonces SET name=:name, type=:type, msg=:msg, owner=:owner, idObjet=:idObjet, status=:status WHERE id=:id";

        $query=$connection->prepare($req);
        $query->bindValue(":name", $annonces->getName());
        $query->bindValue(":type", $annonces->getType());
        $query->bindValue(":msg", $annonces->getMsg());
        $query->bindValue(":owner", $annonces->getOwner());
        $query->bindValue(":idObjet", $annonces->getIdObjet());
        $query->bindValue(":status", $annonces->getStatus());
        $query->bindValue(":id", $annonces->getId());
        $query->execute();
    }

    /**
     * Supprime l'annonce
     */
    public function delete(int $id):void{
        $connection = Database::getCo();
        $req = "DELETE FROM annonces WHERE id=:id";

        $query = $connection->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();
    }
}