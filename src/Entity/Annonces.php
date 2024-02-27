<?php 
namespace App\Entity;

class Annonces{

    private ?array $theObjet;
    private ?array $theOwner;
    public function __construct(
        private string $name,
        private string $type,
        private string $msg,
        private int $owner,
        private int $idObjet,
        private string $status,
        private ?int $id=null
    ){}

    /**
     * @return array
     */
    public function getTheObjet():array{
        return $this->theObjet;
    }

    /**
     * @param array $user
     * @return self
     */
    public function setTheObjet(array $user):self{
        $this->theObjet = $user;
        return $this;
    }

    /**
     * @return array
     */
    public function getTheOwner():array{
        return $this->theOwner;
    }

    /**
     * @param array $user
     * @return self
     */
    public function setTheOwner(array $user):self{
        $this->theOwner = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getName():string{
        return $this->name;
    }
    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType():string{
        return $this->type;
    }
    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getMsg():string{
        return $this->msg;
    }
    /**
     * @param string $msg
     * @return self
     */
    public function setMsg(string $msg): self {
        $this->msg = $msg;
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
    public function setStatus(string $status): self {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getOwner():int{
        return $this->owner;
    }
    /**
     * @param int $owner
     * @return self
     */
    public function setOwner(int $owner): self {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdObjet():int{
        return $this->idObjet;
    }
    /**
     * @param int $idObjet
     * @return self
     */
    public function setIdObjet(int $idObjet): self {
        $this->idObjet = $idObjet;
        return $this;
    }

    /**
     * @return 
     */
    public function getId(){
        return $this->id;
    }
    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }
}