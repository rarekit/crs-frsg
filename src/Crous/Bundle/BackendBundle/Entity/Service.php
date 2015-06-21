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
 * Service
 *
 * @ORM\Table("service")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\ServiceRepository")
 */
class Service implements EntityInterface
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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;
   
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
     * @return Service
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
     * @return Service
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
     * @return Service
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
     * @return Service
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
     * @return Service
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
     * Set content
     *
     * @param string $content
     * @return Service
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     * @return Service
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
     * @return Service
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
     * Set region
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Region $region
     * @return Service
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
     * @return Service
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
