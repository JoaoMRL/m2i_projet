<?php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface{
    // class User implements UserInterface, PasswordAuthenticatedUserInterface{
   
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\NoSuspiciousCharacters]
        #[Assert\Regex(
            pattern: '/\d/',
            match: false,
            message: 'Your name cannot contain a number',
        )]
        private string $name,
        #[Assert\NotBlank]
        #[Assert\NoSuspiciousCharacters]
        #[Assert\Regex(
            pattern: '/\d/',
            match: false,
            message: 'Your name cannot contain a number',
        )]
        private string $firstName,
        private ?string $address,
        #[Assert\Email]
        #[Assert\NotBlank]
        private string $email,
        #[Assert\NotBlank]
        #[Assert\Length(min: 4)]
        private string $password,
        private string $role='',
        private ?string $phoneNumber=null,
        private ?string $avatar=null,
        private ?int $id=null
    ){}


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
    public function getFirstName():string{
        return $this->firstName;
    }
    /**
     * @param string $firstName
     * @return self
     */
    public function setFirstNameName(string $firstName): self {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress():string{
        return $this->address;
    }
    /**
     * @param string $address
     * @return self
     */
    public function setAddress(string $address): self {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserIdentifier():string{
        return $this->email;
    }
    /**
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword():string{
        return $this->password;
    }
    /**
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole():string{
        return $this->role;
    }
    /**
     * @param string $role
     * @return self
     */
    public function setRole(string $role): self {
        $this->role = $role;
        return $this;
    }

    /**
     * @return 
     */
    public function getPhoneNumber():?string{
        return $this->phoneNumber;
    }
    /**
     * @param string $phoneNumber
     * @return self
     */
    public function setPhoneNumber(string $phoneNumber): self {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return 
     */
    public function getAvatar():?string{
        return $this->avatar;
    }
    /**
     * @param string $avatar
     * @return self
     */
    public function setAvatar(string $avatar): self {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return 
     */
    public function getId():?int{
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
    * @return array
    */
    public function getRoles():array{
        return [$this->role];
    }

    /**
     * Méthode qui sert à remettre à zéro les données sensibles dans l'entité pour ne pas les persistées
     * (par exemple si on avait un champ pour le mot de passe en clair différent du champ password)
     */
	public function eraseCredentials():void {
	}
}