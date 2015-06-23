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
 * Event
 *
 * @ORM\Table("event")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\EventRepository")
 */
class Event implements EntityInterface
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
     *
     * @ORM\Column(name="title", type="string",  length=512)
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $title;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="eventDate", type="datetime", nullable=true)
     */
    private $eventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;
    
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
     * @ORM\Column(name="categories", type="string", length=1024, nullable=true)
     */
    private $categories;
    
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
     * @return Event
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
     * @return Event
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
     * Set text
     *
     * @param string $text
     * @return Event
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set sharingUrl
     *
     * @param string $sharingUrl
     * @return Event
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
     * @return Event
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
     * Set imageUrl
     *
     * @param string $imageUrl
     * @return Event
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
     * @return Event
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
     * Set categories
     *
     * @param string $categories
     * @return Event
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return string 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }
}
