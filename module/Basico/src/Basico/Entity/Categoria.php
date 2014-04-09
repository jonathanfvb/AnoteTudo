<?php
/**
 * Entidade da tabela "Categoria"
 * @author Jonathan Fernando <jonathan.fvb@hotmail.com>
 * @since 2014-03-10
 */
namespace Basico\Entity;

use Doctrine\ORM\Mapping As ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Categoria")
 * @ORM\Entity(repositoryClass="Basico\Entity\Repository\CategoriaRepository")
 */
class Categoria
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $Nivel;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $Categoria;
        
    /**
     * Configura automaticamente os getters e setters
     * @param string $options
     */
    public function __construct($options = null){
        Configurator::configure($this, $options);
    }
    
    public function __toString(){
        return $this->getCategoria();
    }
    
    /**
     * Getters e Setters
     */
	public function getId ()
    {
        return $this->id;
    }

	public function getNivel ()
    {
        return $this->Nivel;
    }

	public function getCategoria ()
    {
        return $this->Categoria;
    }

	public function setId ($id)
    {
        $this->id = $id;
    }

	public function setNivel ($Nivel)
    {
        $this->Nivel = $Nivel;
    }

	public function setCategoria ($Categoria)
    {
        $this->Categoria = $Categoria;
    }

	
}

?>