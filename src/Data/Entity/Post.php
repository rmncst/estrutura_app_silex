<?php
namespace Data\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Data\Repository\PostRepository")
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=220, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="string", length=400, nullable=true)
     */
    private $texto;

    /**
     * @var string
     *
     * @ORM\Column(name="autor", type="string", length=220, nullable=true)
     */
    private $autor;



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
     * Set titulo
     *
     * @param string $titulo
     * @return Post
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Post
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set autor
     *
     * @param string $autor
     * @return Post
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    public function jsonSerialize() {
        return [
          'id' => $this->id ,
          'titulo' => $this->titulo,
          'texto' => $this->texto,
          'autor' => $this->autor
        ];
    }

}
