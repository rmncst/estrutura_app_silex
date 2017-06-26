<?php
namespace Data\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Comentario
 *
 * @ORM\Table(name="comentario", indexes={@ORM\Index(name="pk_comentario_post", columns={"id_post"})})
 * @ORM\Entity(repositoryClass="Data\Repository\ComentarioRepository")
 */
class Comentario
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
     * @ORM\Column(name="autor", type="string", length=220, nullable=false)
     */
    private $autor;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="string", length=800, nullable=true)
     */
    private $texto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_comentario", type="datetime", nullable=true)
     */
    private $dataComentario;

    /**
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="Data\Entity\Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_post", referencedColumnName="id")
     * })
     */
    private $idPost;



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
     * Set autor
     *
     * @param string $autor
     * @return Comentario
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

    /**
     * Set dataComentario
     *
     * @param \DateTime $dataComentario
     * @return Comentario
     */
    public function setDataComentario($dataComentario)
    {
        $this->dataComentario = $dataComentario;

        return $this;
    }

    /**
     * Get dataComentario
     *
     * @return \DateTime 
     */
    public function getDataComentario()
    {
        return $this->dataComentario;
    }

    /**
     * Set idPost
     *
     * @param \Post $idPost
     * @return Comentario
     */
    public function setIdPost(Post $idPost = null)
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * Get idPost
     *
     * @return \Post 
     */
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Comentario
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
}
