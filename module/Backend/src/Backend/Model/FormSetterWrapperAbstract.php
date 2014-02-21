<?php

namespace Backend\Model;

use Setup\SetupManager;

/**
 * FormSetterWrapperAbstract
 * @author Andrea Fiori
 * @since  28 January 2014
 */
abstract class FormSetterWrapperAbstract
{
	protected $setupManager;

	protected $formSetterClassName, $formSetterInstance;

	protected $backendFormSetterNamespacePrefix = "Backend\\Form\\Setter\\";
	
	protected $zendFormClassName;
	
	protected $zendFormInstance;

	public function __construct(SetupManager $setupManager)
	{
		$this->setupManager = $setupManager;
	}
	
	/**
	 * @return FormSetterAbstract
	 */
	public function getFormSetterClassName()
	{
		return $this->formSetterClassName;
	}
	
	/**
	 * @return FormSetterAbstract
	 */
	public function getFormSetterInstance()
	{
		return $this->formSetterInstance;
	}

	/**
	 * @return SetupManager
	 */
	public function getSetupManager()
	{
		return $this->setupManager;
	}

	protected function getBackendFormSetterNamespacePrefix()
	{
		return $this->backendFormSetterNamespacePrefix;
	}
	
	public function getZendFormClassName()
	{
		return $this->zendFormClassName;
	}
	
	/**
	 * @return \Zend\Form\Form
	 */
	public function getZendFormInstance()
	{
		return $this->zendFormInstance;
	}
}