<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Entidade
 *
 * @ORM\Table(name="entidades")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntidadeRepository")
 * @UniqueEntity(
 *     fields="string",
 *     message="String já cadastrada"
 * )
 */
class Entidade
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(groups={"search"})
     * @Assert\Length(max=255, groups={"search"})
     */
    private $string;

    /**
     * @var int
     *
     * @ORM\Column(type="date")
     * @Assert\Date
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 99999999.99,
     *      minMessage = "Limite mínimo excedido",
     *      maxMessage = "Limite máximo excedido",
     *      invalidMessage = "Valor inválido",
     * )
     */
    private $valor;

    public function __construct()
    {
        $this->data = new \DateTime();
    }

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
     * Set string
     *
     * @param string $string
     *
     * @return Entidade
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Entidade
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return Entidade
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }
}
