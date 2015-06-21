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
 * DTD
 *
 * @ORM\Table("dtd")
 * @ORM\Entity(repositoryClass="Crous\Bundle\BackendBundle\Repository\DTDRepository")
 */
class DTD implements EntityInterface
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
     * @ORM\Column(name="xml_id", type="string", length=255)
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $dtd;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string",  length=64)
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sync_period", type="string",  length=64)
     * @Assert\NotBlank(message="This value must not be empty.")
     */
    private $syncPeriod;

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
     * Set dtd
     *
     * @param string $dtd
     * @return DTD
     */
    public function setDtd($dtd)
    {
        $this->dtd = $dtd;

        return $this;
    }

    /**
     * Get dtd
     *
     * @return string 
     */
    public function getDtd()
    {
        return $this->dtd;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return DTD
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set syncPeriod
     *
     * @param string $syncPeriod
     * @return DTD
     */
    public function setSyncPeriod($syncPeriod)
    {
        $this->syncPeriod = $syncPeriod;

        return $this;
    }

    /**
     * Get syncPeriod
     *
     * @return string 
     */
    public function getSyncPeriod()
    {
        return $this->syncPeriod;
    }
}
