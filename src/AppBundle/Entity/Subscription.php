<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubscriptionRepository")
 */
class Subscription
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="beginDate", type="datetime")
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="subscriptions")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="products")
     * @ORM\JoinColumn(name="contact", referencedColumnName="id")
     */
    private $contact;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set beginDate
     *
     * @param \DateTime $beginDate
     *
     * @return Subscription
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Subscription
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }


    /**
     * Get contact
     */
     public function getContact(){
        return $this->contact;
     }

    /**
     * Get contact
     */
    public function setContact($contactInput){
        return $this->contact = $contactInput;
     }


    /**
     * Get products
     */
    public function getProducts(){
        return $this->product;
     }

    /**
     * Set product
     */
    public function setProduct($productInput){
        return $this->product = $productInput;
    }

    public function toString(){
        return 
            [
                "id" => $this->getId(),
                "beginDate" => $this->beginDate,
                "endDate" => $this->endDate,
                "contact" => $this->contact->getId(),
                "product" => $this->product->getId(),
            ];
    }
}