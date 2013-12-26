<?php

namespace Language\Model;

use Setup\Model\EntityRepositoryAbstract;
use Application\Entity\Languages;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

class LanguagesLabelsRepository extends EntityRepositoryAbstract {
	
	protected $repository = 'Application\Entity\LanguagesLabels';
	
	private $languageEntity;
	
	/**
	 * 
	 * @param Languages $languageEntity
	 */
	public function setLanguagesEntity(Languages $languageEntity)
	{
		$this->languageEntity = $languageEntity;
	}
	
	/**
	 * get the label with name -> key value format
	 * @param array $arraySearch
	 * @throws InvalidArgumentException
	 * @return array
	 */
	public function getLabels($arraySearch)
	{
		if ( !is_array($arraySearch) ) 
			throw new InvalidArgumentException("ArraySearch is not an array");
		
		$labelsObject = $this->getFindFromRepository($arraySearch);
		
		$labels = array();
		foreach($labelsObject as &$labelsObject)
		{
			$labels[$labelsObject['label_name']] = $labelsObject['label_value'];
		}
		
		return $labels;
	}
}