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
 * OnlineService
 *
 * @ORM\Table("online_service")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\OnlineServiceRepository")
 */
class OnlineService implements EntityInterface
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
     * @ORM\Column(name="link", type="string", length=1024, nullable=true)
     * @Assert\Url(message="This value is not a valid URL.")
     */
    private $link;

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
     * @return OnlineService
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
     * @return OnlineService
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
     * Set shortDesc
     *
     * @param string $shortDesc
     * @return OnlineService
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

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     * @return OnlineService
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
     * @return OnlineService
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
     * Set link
     *
     * @param string $link
     * @return OnlineService
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set region
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Region $region
     * @return OnlineService
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
