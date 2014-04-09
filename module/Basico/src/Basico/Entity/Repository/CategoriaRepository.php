<?php

/**
 * Classe responsável por conter os métodos
 * de consulta no banco
 * 
 * @author Jonathan Fernando <jonathan.fvb@hotmail.com>
 * @since 2014-03-10
 */
namespace Basico\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CategoriaRepository extends AbstractEntityRepository
{    
    
    public function dataToHtmlTable ($data)
    {
        throw new \Exception('Método não implementado.');
    }

	/**
     * Retorna um array com os registros da tabela
     *
     * @return array
     */
    public function fetchPairs(array $whereParams = array(), array $orderBy = array()){
        $entities = $this->findBy($whereParams, $orderBy);
         
        $arrayRetorno = array();
        foreach($entities as $entity){
            $arrayRetorno[$entity->getId()] = $entity->getCategoria();
        }
        return $arrayRetorno;
    }
    
    /**
     * Retorna um array com os UF's da tabela
     *
     * @return array
     * @example
     * 		array('pr' => 'pr', 'sp' => 'sp')
     */
    public function fetchPairsUF(array $whereParams = null, array $orderBy = null){
        /*
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c.UF')
	        ->from($this->getEntityName(), 'c')
        	->groupBy('c.UF');
        $result = $qb->getQuery()->getResult();
         
        $arrayRetorno = array();
        foreach($result as $reg){
            $arrayRetorno[$reg['UF']] = $reg['UF'];
        }
        return $arrayRetorno;
        */
        
        return array();
    }
}

?>