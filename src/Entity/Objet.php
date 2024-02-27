<?php
namespace App\Entity;

class Objet{
    private ?array $theOwner;
    public function __construct(
        private string $name,
        private string $description,
        private int $owner,
        private ?int $id=null,
        private ?string $img=null
    ){}

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
    public function getDescription():string{
        return $this->description;
    }
    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self {
        $this->description = $description;
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

    /**
     * @return 
     */
    public function getImg(){
        return $this->img;
    }
    /**
     * @param string $img
     * @return self
     */
    public function setImg(string $img): self {
        $this->img = $img;
        return $this;
    }
}