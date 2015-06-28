<?php

namespace Crous\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssistanceElement
 *
 * @ORM\Table("assistance_elements")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\AssistanceElementRepository")
 */
class AssistanceElement
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
     * @ORM\ManyToOne(targetEntity="Assistance")
     * @ORM\JoinColumn(name="assistance_id", referencedColumnName="id")
     */
    private $assistance;

    /**
     * @var string
     *
     * @ORM\Column(name="subTitle", type="string", length=512)
     */
    private $subTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=4096)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=2083)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="imageShortUrl", type="string", length=255)
     */
    private $imageShortUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnailUrl", type="string", length=2083)
     */
    private $thumbnailUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="sharingUrl", type="string", length=1024)
     */
    private $sharingUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="sharingShortUrl", type="string", length=1024)
     */
    private $sharingShortUrl;


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
     * Set subTitle
     *
     * @param string $subTitle
     * @return AssistanceElement
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string 
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return AssistanceElement
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
     * @return AssistanceElement
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
     * @return AssistanceElement
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
     * @return AssistanceElement
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
     * @return AssistanceElement
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
     * @return AssistanceElement
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
     * Set assistance
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Assistance $assistance
     * @return AssistanceElement
     */
    public function setAssistance(\Crous\Bundle\BackendBundle\Entity\Assistance $assistance = null)
    {
        $this->assistance = $assistance;

        return $this;
    }

    /**
     * Get assistance
     *
     * @return \Crous\Bundle\BackendBundle\Entity\Assistance 
     */
    public function getAssistance()
    {
        return $this->assistance;
    }
}
