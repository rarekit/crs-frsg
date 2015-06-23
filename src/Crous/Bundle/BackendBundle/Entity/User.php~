<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Crous\Bundle\BackendBundle\Entity\Base\EntityInterface;

/**
 * User
 *
 * @ORM\Table("user")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\UserRepository")
 */
class User implements UserInterface, AdvancedUserInterface, EntityInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=64)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=64)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64)
     */
    private $email;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * 
     * @return type
     */
    public function isEnabled()
    {
        return (boolean) $this->active;
    }

    /**
     * Get roles of user
     *  
     * @return type
     */ 
    public function getRoles() {
        $roles = array();
        if ($this->getRole() != null) {
            $roles[] = $this->getRole()->getRole();
        }
        
        return $roles;
    }


    /**
     * @return type
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

    public function eraseCredentials() 
    {
    }

    /**
     * @param AdvancedUserInterface $user
     * @return type
     */
    public function isEqualTo(AdvancedUserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    /**
     * @return boolean
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * getSalt
     *
     * @return string
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Set role
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Role $role
     * @return User
     */
    public function setRole(\Crous\Bundle\BackendBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Crous\Bundle\BackendBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set region
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Region $region
     * @return User
     */
    public function setRegion(\Crous\Bundle\BackendBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Crous\Bundle\BackendBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }
}
