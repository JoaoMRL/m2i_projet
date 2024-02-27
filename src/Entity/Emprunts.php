<?php 
namespace App\Entity;

use DateTime;

class Emprunts{
    private ?array $theBorrower;
    private ?array $theAnnonce;

    private ?array $theAnnonceOwner;

    public function __construct(
        private string $status,
        private DateTime $dateDebut,
        private DateTime $dateFin,
        private string $msgEmprunts,
        private int $idAnnonces,
        private int $borrower,
        private ?int $id
    ){}

    /**
     * @return array
     */
    public function getTheAnnonce():array{
        return $this->theAnnonce;
    }

    /**
     * @param array $user
     * @return self
     */
    public function setTheAnnonce(array $user):self{
        $this->theAnnonce = $user;
        return $this;
    }

    /**
     * @return array
     */
    public function getTheAnnonceOwner():array{
        return $this->theAnnonceOwner;
    }

    /**
     * @param array $user
     * @return self
     */
    public function setTheAnnonceOwner(array $user):self{
        $this->theAnnonceOwner = $user;
        return $this;
    }

    /**
     * @return array
     */
    public function getTheBorrower():array{
        return $this->theBorrower;
    }

    /**
     * @param array $user
     * @return self
     */
    public function setTheBorrower(array $user):self{
        $this->theBorrower = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getId():int{
        return $this->id;
    }
    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id):self{
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus():string{
        return $this->status;
    }
    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status):self{
        $this->status = $status;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateDebut():DateTime{
        return $this->dateDebut;
    }
    /**
     * @param DateTime $dateDebut
     * @return self
     */
    public function setDateDebut(DateTime $dateDebut):self{
        $this->dateDebut = $dateDebut;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateFin():DateTime{
        return $this->dateFin;
    }
    /**
     * @param DateTime $dateFin
     * @return self
     */
    public function setDateFin(DateTime $dateFin):self{
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * @return string
     */
    public function getMsgEmprunt():string{
        return $this->msgEmprunts;
    }
    /**
     * @param string $msgEmprunts
     * @return self
     */
    public function setMsgEmprunt(string $msgEmprunts):self{
        $this->msgEmprunts = $msgEmprunts;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdAnnonces():int{
        return $this->idAnnonces;
    }
    /**
     * @param int $idAnnonces
     * @return self
     */
    public function setIdAnnonces(int $idAnnonces):self{
        $this->idAnnonces = $idAnnonces;
        return $this;
    }

    /**
     * @return int
     */
    public function getBorrower():int{
        return $this->borrower;
    }
    /**
     * @param int $borrower
     * @return self
     */
    public function setBorrower(int $borrower):self{
        $this->borrower = $borrower;
        return $this;
    }
}