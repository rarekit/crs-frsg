<?php

namespace Crous\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScholarshipElement
 *
 * @ORM\Table("scholarship_elements")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\ScholarshipElementRepository")
 */
class ScholarshipElement
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
     * @ORM\ManyToOne(targetEntity="Scholarship")
     * @ORM\JoinColumn(name="scholarship_id", referencedColumnName="id")
     */
    private $scholarship;

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
     * @return ScholarshipElement
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
     * @return ScholarshipElement
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
     * @return ScholarshipElement
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
     * @return ScholarshipElement
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
     * @return ScholarshipElement
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
     * @return ScholarshipElement
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
     * @return ScholarshipElement
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
     * Set scholarship
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Scholarship $scholarship
     * @return ScholarshipElement
     */
    public function setScholarship(\Crous\Bundle\BackendBundle\Entity\Scholarship $scholarship = null)
    {
        $this->scholarship = $scholarship;

        return $this;
    }

    /**
     * Get scholarship
     *
     * @return \Crous\Bundle\BackendBundle\Entity\Scholarship 
     */
    public function getScholarship()
    {
        return $this->scholarship;
    }
}
