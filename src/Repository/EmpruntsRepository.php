<?php
namespace App\Repository;
use App\Entity\Emprunts;
use DateTime;

class EmpruntsRepository{
    /**
     * @return Emprunts[]
     */
    public function findAll():array{
        $list = [];
        $req = "SELECT emprunts.*,annonces.id AS annonce_id, users.id AS user_id,
        objets.id AS objet_id, emprunts.id AS emprunt_id,annonces.name AS annonce_name,users.name AS user_name,
        objets.name AS objet_name,annonces.status AS annonce_status, emprunts.status AS emprunt_status,annonces.owner AS annonce_owner,
        users.firstName,users.address, users.email, users.phoneNumber, users.avatar,
        objets.description, objets.image, annonces.type, annonces.msg,
        annonces.type,annonces.msg,
        annonce_owner_user.name AS annonce_owner_name,annonce_owner_user.id AS annonce_owner_id,
        annonce_owner_user.address AS annonce_owner_address,annonce_owner_user.firstName AS annonce_owner_firstName,
        annonce_owner_user.email AS annonce_owner_email,annonce_owner_user.phoneNumber AS annonce_owner_phoneNumber,
        annonce_owner_user.avatar AS annonce_owner_avatar   
        FROM emprunts
        LEFT JOIN annonces ON emprunts.idAnnonces = annonces.id
        LEFT JOIN users ON emprunts.borrower = users.id
        LEFT JOIN objets ON objets.id = annonces.idObjet
        LEFT JOIN users AS annonce_owner_user ON annonce_owner_user.id = annonces.owner";
        $connect = Database::getCo();

        $query = $connect->prepare($req);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $emprunt= new Emprunts($line['status'],new DateTime($line['dateDebut']),new DateTime($line['dateFin']),$line['msgEmprunts'],$line['idAnnonces'],$line['borrower'],$line['id']);
            $emprunt->setTheBorrower(["borrowerName"=>$line['user_name'],"borrowerFirstName"=>$line['firstName'],"borrowerAddress"=>$line['address'],"borrowerEmail"=>$line['email'], "borrowerPhoneNumber"=>$line['phoneNumber'],"borrowerAvatar"=>$line["avatar"]]);
            $emprunt->setTheAnnonce([["annonceName"=>$line["annonce_name"],"annonceType"=>$line["type"],"annonceMessage"=>$line["msg"],"annonceStatus"=>$line["annonce_status"]],
            ["objetName"=>$line['objet_name'],"objetDescription"=>$line['description'],"objetImg"=>$line['image'], "type"=>$line["type"],"objetId"=>$line["objet_id"]], 
            ["ownerName"=>$line['annonce_owner_name'],"ownerFirstName"=>$line['annonce_owner_firstName'],"ownerAddress"=>$line['annonce_owner_address'],"ownerEmail"=>$line['annonce_owner_email'],"ownerPhoneNumber"=>$line['annonce_owner_phoneNumber'],"ownerAvatar"=>$line["annonce_owner_avatar"],"ownerId"=>$line["annonce_owner_id"]]]);
            $list[]= $emprunt;
        }
        return $list;
    }

    /**
     * @return Emprunts[] Tableau d'objets de l'user 
     */
    public function findByUserId(int $id):array{
        $list=[];
        $connect = Database::getCo();
        $req= "SELECT emprunts.*,annonces.id AS annonce_id, users.id AS user_id,
        objets.id AS objet_id, emprunts.id AS emprunt_id,annonces.name AS annonce_name,users.name AS user_name,
        objets.name AS objet_name,annonces.status AS annonce_status, emprunts.status AS emprunt_status,annonces.owner AS annonce_owner,
        users.firstName,users.address, users.email, users.phoneNumber, users.avatar,
        objets.description, objets.image, annonces.type, annonces.msg,
        annonces.type,annonces.msg,
        annonce_owner_user.name AS annonce_owner_name,annonce_owner_user.id AS annonce_owner_id,
        annonce_owner_user.address AS annonce_owner_address,annonce_owner_user.firstName AS annonce_owner_firstName,
        annonce_owner_user.email AS annonce_owner_email,annonce_owner_user.phoneNumber AS annonce_owner_phoneNumber,
        annonce_owner_user.avatar AS annonce_owner_avatar 
        FROM emprunts 
        LEFT JOIN annonces ON emprunts.idAnnonces = annonces.id
        LEFT JOIN users ON emprunts.borrower = users.id
        LEFT JOIN objets ON objets.id = annonces.idObjet
        LEFT JOIN users AS annonce_owner_user ON annonce_owner_user.id = annonces.owner
        WHERE annonce_owner_user.id = :id";

        $query = $connect->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();

        foreach($query->fetchAll() as $line){
            $emprunt= new Emprunts($line['status'],new DateTime($line['dateDebut']),new DateTime($line['dateFin']),$line['msgEmprunts'],$line['idAnnonces'],$line['borrower'],$line['id']);
            $emprunt->setTheBorrower(["borrowerName"=>$line['user_name'],"borrowerFirstName"=>$line['firstName'],"borrowerAddress"=>$line['address'],"borrowerEmail"=>$line['email'], "borrowerPhoneNumber"=>$line['phoneNumber'],"borrowerAvatar"=>$line["avatar"]]);
            $emprunt->setTheAnnonce([["annonceName"=>$line["annonce_name"],"annonceType"=>$line["type"],"annonceMessage"=>$line["msg"],"annonceStatus"=>$line["annonce_status"]],
            ["objetName"=>$line['objet_name'],"objetDescription"=>$line['description'],"objetImg"=>$line['image'], "type"=>$line["type"],"objetId"=>$line["objet_id"]], 
            ["ownerName"=>$line['annonce_owner_name'],"ownerFirstName"=>$line['annonce_owner_firstName'],"ownerAddress"=>$line['annonce_owner_address'],"ownerEmail"=>$line['annonce_owner_email'],"ownerPhoneNumber"=>$line['annonce_owner_phoneNumber'],"ownerAvatar"=>$line["annonce_owner_avatar"],"ownerId"=>$line["annonce_owner_id"]]]);
            $list[]= $emprunt;
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
            $emprunt= new Emprunts($line['status'],new DateTime($line['dateDebut']),new DateTime($line['dateFin']),$line['msgEmprunts'],$line['idAnnonces'],$line['borrower'],$line['id']);
            $emprunt->setTheBorrower(["borrowerName"=>$line['user_name'],"borrowerFirstName"=>$line['firstName'],"borrowerAddress"=>$line['address'],"borrowerEmail"=>$line['email'], "borrowerPhoneNumber"=>$line['phoneNumber'],"borrowerAvatar"=>$line["avatar"]]);
            $emprunt->setTheAnnonce([["annonceName"=>$line["annonce_name"],"annonceType"=>$line["type"],"annonceMessage"=>$line["msg"],"annonceStatus"=>$line["annonce_status"]],
            ["objetName"=>$line['objet_name'],"objetDescription"=>$line['description'],"objetImg"=>$line['image'], "type"=>$line["type"],"objetId"=>$line["objet_id"]], 
            ["ownerName"=>$line['annonce_owner_name'],"ownerFirstName"=>$line['annonce_owner_firstName'],"ownerAddress"=>$line['annonce_owner_address'],"ownerEmail"=>$line['annonce_owner_email'],"ownerPhoneNumber"=>$line['annonce_owner_phoneNumber'],"ownerAvatar"=>$line["annonce_owner_avatar"],"ownerId"=>$line["annonce_owner_id"]]]);
            $list[]= $emprunt;
        }
        return $list;
    }

    /**
     * @return Emprunts
     */
    public function findById(int $id):?Emprunts{
        $connect = Database::getCo();
        $req = "SELECT emprunts.*,annonces.id AS annonce_id, users.id AS user_id,
        objets.id AS objet_id, emprunts.id AS emprunt_id,annonces.name AS annonce_name,users.name AS user_name,
        objets.name AS objet_name,annonces.status AS annonce_status, emprunts.status AS emprunt_status,annonces.owner AS annonce_owner,
        users.firstName,users.address, users.email, users.phoneNumber, users.avatar,
        objets.description, objets.image, annonces.type, annonces.msg,
        annonces.type,annonces.msg,
        annonce_owner_user.name AS annonce_owner_name,annonce_owner_user.id AS annonce_owner_id,
        annonce_owner_user.address AS annonce_owner_address,annonce_owner_user.firstName AS annonce_owner_firstName,
        annonce_owner_user.email AS annonce_owner_email,annonce_owner_user.phoneNumber AS annonce_owner_phoneNumber,
        annonce_owner_user.avatar AS annonce_owner_avatar 
        FROM emprunts 
        LEFT JOIN annonces ON emprunts.idAnnonces = annonces.id
        LEFT JOIN users ON emprunts.borrower = users.id
        LEFT JOIN objets ON objets.id = annonces.idObjet
        LEFT JOIN users AS annonce_owner_user ON annonce_owner_user.id = annonces.owner
        WHERE emprunts.id = :id";

        $query = $connect->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();
        foreach($query->fetchAll() as $line){
            $emprunt= new Emprunts($line['status'],new DateTime($line['dateDebut']),new DateTime($line['dateFin']),$line['msgEmprunts'],$line['idAnnonces'],$line['borrower'],$line['id']);
            $emprunt->setTheBorrower(["borrowerName"=>$line['user_name'],"borrowerFirstName"=>$line['firstName'],"borrowerAddress"=>$line['address'],"borrowerEmail"=>$line['email'], "borrowerPhoneNumber"=>$line['phoneNumber'],"borrowerAvatar"=>$line["avatar"]]);
            $emprunt->setTheAnnonce([["annonceName"=>$line["annonce_name"],"annonceType"=>$line["type"],"annonceMessage"=>$line["msg"],"annonceStatus"=>$line["annonce_status"]],
            ["objetName"=>$line['objet_name'],"objetDescription"=>$line['description'],"objetImg"=>$line['image'], "type"=>$line["type"],"objetId"=>$line["objet_id"]], 
            ["ownerName"=>$line['annonce_owner_name'],"ownerFirstName"=>$line['annonce_owner_firstName'],"ownerAddress"=>$line['annonce_owner_address'],"ownerEmail"=>$line['annonce_owner_email'],"ownerPhoneNumber"=>$line['annonce_owner_phoneNumber'],"ownerAvatar"=>$line["annonce_owner_avatar"],"ownerId"=>$line["annonce_owner_id"]]]);
            return $emprunt;
        }
        return null;
    }

    /**
     * Ajoute un Emprunts
     */
    public function persist(Emprunts $emprunts):void{
        $connection = Database::getCo();
        $req = "INSERT INTO emprunts (status,dateDebut,dateFin,msgEmprunts,idAnnonces,borrower) VALUES (:status,:dateDebut,:dateFin,:msgEmprunts,:idAnnonces,:borrower)";

        $query=$connection->prepare($req);
        $query->bindValue(":status",$emprunts->getStatus());
        $query->bindValue(":dateDebut",$emprunts->getDateDebut()->format('Y-m-d'));
        $query->bindValue(":dateFin",$emprunts->getDateFin()->format('Y-m-d'));
        $query->bindValue(":msgEmprunts",$emprunts->getMsgEmprunt());
        $query->bindValue(":idAnnonces",$emprunts->getIdAnnonces());
        $query->bindValue(":borrower",$emprunts->getBorrower());
        $query->execute();
        
        $emprunts->setId($connection->lastInsertId());
    }

    /**
     * Update Emprunt
     */
    public function update(Emprunts $emprunts):void{
        $connection = Database::getCo();
        $req = "UPDATE emprunts SET status=:status, dateDebut=:dateDebut, dateFin=:dateFin, msgEmprunts=:msgEmprunts, idAnnonces=:idAnnonces, borrower=:borrower WHERE id = :id";

        $query=$connection->prepare($req);
        $query->bindValue(":status",$emprunts->getStatus());
        $query->bindValue(":dateDebut",$emprunts->getDateDebut()->format('Y-m-d'));
        $query->bindValue(":dateFin",$emprunts->getDateFin()->format('Y-m-d'));
        $query->bindValue(":msgEmprunts",$emprunts->getMsgEmprunt());
        $query->bindValue(":idAnnonces",$emprunts->getIdAnnonces());
        $query->bindValue(":borrower",$emprunts->getBorrower());
        $query->bindValue(":id",$emprunts->getId());
        $query->execute();
    }

    /**
     * Supprime l'emprunt
     */
    public function delete(int $id):void{
        $connection = Database::getCo();
        $req = "DELETE FROM emprunts WHERE id=:id";

        $query = $connection->prepare($req);
        $query->bindValue(":id", $id);
        $query->execute();
    }
}