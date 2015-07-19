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
 * ExportStatus
 *
 * @ORM\Table("export_status")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\ExportStatusRepository")
 */
class ExportStatus implements EntityInterface
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
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $region;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=64)
     */
    private $type;


    /**
     * @var string
     * @ORM\Column(name="last_state", type="string", length=64, nullable=true)
     */
    private $lastState;

    /**
     * @var datetime
     * @ORM\Column(name="last_attempt", type="datetime", nullable=true)
     */
    private $lastAttempt;


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
     * Set type
     *
     * @param string $type
     * @return ExportStatus
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set lastState
     *
     * @param string $lastState
     * @return ExportStatus
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
     * Set lastAttempt
     *
     * @param \DateTime $lastAttempt
     * @return ExportStatus
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
     * Set region
     *
     * @param \Crous\Bundle\BackendBundle\Entity\Region $region
     * @return ExportStatus
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
