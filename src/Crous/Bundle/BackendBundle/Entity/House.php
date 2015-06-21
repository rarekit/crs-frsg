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

/**
 * House
 *
 * @ORM\Table("house")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\HouseRepository")
 */
class House implements EntityInterface
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
     * @ORM\Column(name="xml_id", type="string", length=64, nullable=true)
     */
    private $xmlId;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $region;

    /**
     * @var integer
     *
     * @ORM\Column(name="title", type="string",  length=512)
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="short_desc", type="string", length=1024, nullable=true)
     */
    private $shortDesc;
    
    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", nullable=true)
     */
    private $lat;
    
    /**
     * @var float
     *
     * @ORM\Column(name="lon", type="float", nullable=true)
     */
    private $lon;
    
    /**
     * @var string
     *
     * @ORM\Column(name="zone", type="string", length=128, nullable=true)
     */
    private $zone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="infos", type="text", nullable=true)
     */
    private $infos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="services", type="string", length=64, nullable=true)
     */
    private $services;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=1024, nullable=true)
     */
    private $contact;
    
    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=1024, nullable=true)
     */
    private $imageUrl;
    
    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail_url", type="string", length=1024, nullable=true)
     */
    private $thumbnailUrl;
    
   /**
     * @var string
     *
     * @ORM\Column(name="sharing_url", type="string", length=1024, nullable=true)
     * @Assert\Url(message="This value is not a valid URL.")
     */
    private $sharingUrl;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sharing_short_url", type="string", length=1024, nullable=true)
     */
    private $sharingShortUrl;
    
    /**
     * @var string
     */
    public $file;

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
     * Set xmlId
     *
     * @param string $xmlId
     * @return House
     */
    public function setXmlId($xmlId)
    {
        $this->xmlId = $xmlId;

        return $this;
    }

    /**
     * Get xmlId
     *
     * @return string 
     */
    public function getXmlId()
    {
        return $this->xmlId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return House
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return House
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param float $lon
     * @return House
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * Get lon
     *
     * @return float 
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Set zone
     *
     * @param string $zone
     * @return House
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string 
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set infos
     *
     * @param string $infos
     * @return House
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return string 
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Set services
     *
     * @param string $services
     * @return House
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return string 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return House
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     * @return House
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string 
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set thumbnailUrl
     *
     * @param string $thumbnailUrl
     * @return House
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    /**
     * Get thumbnailUrl
     *
     * @return string 
     */
    public function getThumbnailUrl()
    {
        return $this->thumbnailUrl;
    }

    /**
     * Set sharingUrl
     *
     * @param string $sharingUrl
     * @return House
     */
    public function setSharingUrl($sharingUrl)
    {
        $this->sharingUrl = $sharingUrl;

        return $this;
    }

    /**
     * Get sharingUrl
     *
     * @return string 
     */
    public function getSharingUrl()
    {
        return $this->sharingUrl;
    }

    /**
     * Set sharingShortUrl
     *
     * @param string $sharingShortUrl
     * @return House
     */
    public function setSharingShortUrl($sharingShortUrl)
    {
        $this->sharingShortUrl = $sharingShortUrl;

        return $this;
    }

    /**
     * Get sharingShortUrl
     *
     * @return string 
     */
    public function getSharingShortUrl()
    {
        return $this->sharingShortUrl;
    }

    /**
     * Set region
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Region $region
     * @return House
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
     * Set shortDesc
     *
     * @param string $shortDesc
     * @return House
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    /**
     * Get shortDesc
     *
     * @return string 
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }
}
