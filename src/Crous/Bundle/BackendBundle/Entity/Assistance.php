<?php

namespace Crous\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Crous\Bundle\BackendBundle\Entity\Base\EntityInterface;

/**
 * Assistance
 *
 * @ORM\Table("assistance")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\AssistanceRepository")
 */
class Assistance implements EntityInterface
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
     * @ORM\OneToMany(targetEntity="AssistanceElement", mappedBy="assistance")
     */
    private $elements;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=512)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="assistanceDate", type="datetime", nullable=true)
     */
    private $assistanceDate;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDesc", type="string", length=255, nullable=true)
     */
    private $shortDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=2083, nullable=true)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="imageShortUrl", type="string", length=255, nullable=true)
     */
    private $imageShortUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnailUrl", type="string", length=2083, nullable=true)
     */
    private $thumbnailUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="sharingUrl", type="string", length=1024, nullable=true)
     * @Assert\Url(message="This value is not a valid URL.")
     */
    private $sharingUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="sharingShortUrl", type="string", length=1024, nullable=true)
     */
    private $sharingShortUrl;

    /**
     * @var file 
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
     * Set title
     *
     * @param string $title
     * @return Assistance
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
     * Set assistanceDate
     *
     * @param \DateTime $assistanceDate
     * @return Assistance
     */
    public function setAssistanceDate($assistanceDate)
    {
        $this->assistanceDate = $assistanceDate;

        return $this;
    }

    /**
     * Get assistanceDate
     *
     * @return \DateTime 
     */
    public function getAssistanceDate()
    {
        return $this->assistanceDate;
    }

    /**
     * Set shortDesc
     *
     * @param string $shortDesc
     * @return Assistance
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
     * @return Assistance
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
     * Set imageShortUrl
     *
     * @param string $imageShortUrl
     * @return Assistance
     */
    public function setImageShortUrl($imageShortUrl)
    {
        $this->imageShortUrl = $imageShortUrl;

        return $this;
    }

    /**
     * Get imageShortUrl
     *
     * @return string 
     */
    public function getImageShortUrl()
    {
        return $this->imageShortUrl;
    }

    /**
     * Set thumbnailUrl
     *
     * @param string $thumbnailUrl
     * @return Assistance
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
     * @return Assistance
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
     * @return Assistance
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
     * Constructor
     */
    public function __construct()
    {
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add elements
     *
     * @param \Crous\Bundle\BackendBundle\Entity\AssistanceElement $elements
     * @return Assistance
     */
    public function addElement(\Crous\Bundle\BackendBundle\Entity\AssistanceElement $elements)
    {
        $this->elements[] = $elements;

        return $this;
    }

    /**
     * Remove elements
     *
     * @param \Crous\Bundle\BackendBundle\Entity\AssistanceElement $elements
     */
    public function removeElement(\Crous\Bundle\BackendBundle\Entity\AssistanceElement $elements)
    {
        $this->elements->removeElement($elements);
    }

    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElements()
    {
        return $this->elements;
    }
}
