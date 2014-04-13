<?php

namespace Application\Setup;

use Application\Model\QueryBuilderSetterAbstract;
use Application\Model\NullException;

/**
 * Set main language properties
 * 
 * @author Andrea Fiori
 * @since  02 April 2014
 */
class LanguagesSetup extends QueryBuilderSetterAbstract
{
	private $allAvailableLanguages;
	private $languageId;
	private $languageAbbreviation;
	private $defaultLanguage;
	
	/**
	 * @param  number $channel
	 * @return array
	 */
	public function setAllAvailableLanguages($channel = 1)
	{
		$this->allAvailableLanguages = $this->getQueryBuilder()->add('select', 'l.id, l.nome, l.abbreviazione1, l.abbreviazione2, l.abbreviazione3 ')
															   ->add('from', 'Application\Entity\Lingue l ')
															   ->add('where', 'l.attivo = 1 AND l.canaleId IN ( :channel , 0 ) ')
															   ->setParameter('channel', $channel)
															   ->getQuery()->getResult();
	
		return $this->allAvailableLanguages;
	}
	
	/**
	 * 
	 * @param string $languageAbbreviation
	 */
	public function setDefaultLanguage($languageAbbreviation = null)
	{
		if (!$this->allAvailableLanguages) {
			throw new NullException('Available Languages are not set');
		}
		
		foreach($this->allAvailableLanguages as $availableLanguage) {
		
			if ($availableLanguage['abbreviation1'] == $languageAbbreviation) {
				$this->defaultLanguage = $availableLanguage;
				break;
			}

			if ($availableLanguage['isdefault']) {
				$this->defaultLanguage = $availableLanguage;
			}
		}
		
		return $this->defaultLanguage;
	}
	
	/**
	 * @return number $languageId
	 */
	public function setLanguageId()
	{
		if ( is_numeric($this->defaultLanguage['id']) ) {
			$this->languageId = $this->defaultLanguage['id'];
		}
		
		return $this->languageId;
	}
	
	public function getAllAvailableLanguages()
	{
		return $this->allAvailableLanguages;
	}
}