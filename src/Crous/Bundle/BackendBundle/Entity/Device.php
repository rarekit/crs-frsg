<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Crous\Bundle\BackendBundle\Entity\Base\EntityInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Device
 *
 * @ORM\Table("device")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\DeviceRepository")
 */
class Device implements EntityInterface
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
     * @var integer
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=64)
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $token;
    
    /**
     * @var string
     *
     * @ORM\Column(name="options", type="string", length=255)
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $options;
    
    /**
     * @var datetime
     * @ORM\Column(name="date_registration", type="time", nullable=true)
     */
    private $dateRegistration;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="last_attempt", type="datetime", nullable=true)
     */
    private $lastAttempt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="last_state", type="string", length=64, nullable=true)
     */
    private $lastState;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sync_timestamp", type="integer", nullable=true)
     */
    private $syncTimestamp;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sync_period", type="integer", nullable=true)
     */
    private $syncPeriod;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", options={"default":1})
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
     * Set url
     *
     * @param string $url
     * @return Feed
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Feed
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Feed
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
     * Set lastAttempt
     *
     * @param \DateTime $lastAttempt
     * @return Feed
     */
    public function setLastAttempt($lastAttempt)
    {
        $this->lastAttempt = $lastAttempt;

        return $this;
    }

    /**
     * Get lastAttempt
     *
     * @return \DateTime 
     */
    public function getLastAttempt()
    {
        return $this->lastAttempt;
    }

    /**
     * Set lastState
     *
     * @param string $lastState
     * @return Feed
     */
    public function setLastState($lastState)
    {
        $this->lastState = $lastState;

        return $this;
    }

    /**
     * Get lastState
     *
     * @return string 
     */
    public function getLastState()
    {
        return $this->lastState;
    }

    /**
     * Set syncTimestamp
     *
     * @param integer $syncTimestamp
     * @return Feed
     */
    public function setSyncTimestamp($syncTimestamp)
    {
        $this->syncTimestamp = $syncTimestamp;

        return $this;
    }

    /**
     * Get syncTimestamp
     *
     * @return integer 
     */
    public function getSyncTimestamp()
    {
        return $this->syncTimestamp;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Feed
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
     * Set dtd
     *
     * @param \Crous\Bundle\BackendBundle\Entity\DTD $dtd
     * @return Feed
     */
    public function setDtd(\Crous\Bundle\BackendBundle\Entity\DTD $dtd = null)
    {
        $this->dtd = $dtd;

        return $this;
    }

    /**
     * Get dtd
     *
     * @return \Crous\Bundle\BackendBundle\Entity\DTD 
     */
    public function getDtd()
    {
        return $this->dtd;
    }

    /**
     * Set region
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Region $region
     * @return Feed
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

    /**
     * Set token
     *
     * @param string $token
     * @return Device
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set options
     *
     * @param string $options
     * @return Device
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string 
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set dateRegistration
     *
     * @param  $dateRegistration
     * @return Device
     */
    public function setDateRegistration($dateRegistration)
    {
        $this->dateRegistration = $dateRegistration;

        return $this;
    }

    /**
     * Get dateRegistration
     *
     * @return \timestamp 
     */
    public function getDateRegistration()
    {
        return $this->dateRegistration;
    }

    /**
     * Set syncPeriod
     *
     * @param integer $syncPeriod
     * @return Device
     */
    public function setSyncPeriod($syncPeriod)
    {
        $this->syncPeriod = $syncPeriod;

        return $this;
    }

    /**
     * Get syncPeriod
     *
     * @return integer 
     */
    public function getSyncPeriod()
    {
        return $this->syncPeriod;
    }
}
