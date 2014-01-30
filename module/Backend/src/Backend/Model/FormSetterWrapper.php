<?php

namespace Backend\Model;

/**
 * FormSetterWrapper
 * @author Andrea Fiori
 * @since  26 January 2014
 */
class FormSetterWrapper extends FormSetterWrapperAbstract
{
	public function setFormSetterClassName($className)
	{
		$this->formSetterClassName = $this->getBackendFormSetterNamespacePrefix().$className;
		
		return $this->formSetterClassName;
	}

	/**
	 * @return FormSetterAbstract
	 */
	public function setFormSetterInstance()
	{
		$className = $this->getFormSetterClassName();
		if ( !class_exists($className) ) {
			return false;
		}
		
		$instance = new $className( $this->getSetupManager() );
		if ($instance instanceof FormSetterAbstract) {
			$this->formSetterInstance = $instance;
		}
		
		return $this->formSetterInstance;
	}
	
	/**
	 * @param int $id
	 * @return array
	 */
	public function setFormSetterRecord($id)
	{
		if ( $this->checkFormSetterInstance() ) {
			return $this->getFormSetterInstance()->setRecord($id);
		}
	}

	public function setFormSetterTitle()
	{
		if ( $this->checkFormSetterInstance() ) {
			return $this->getFormSetterInstance()->setTitle();
		}
	}
	
	public function setFormSetterDescription()
	{
		if ( $this->checkFormSetterInstance() ) {
			return $this->getFormSetterInstance()->setDescription();
		}		
	}
	
		private function checkFormSetterInstance()
		{
			$formSetter = $this->getFormSetterInstance();
			if ($formSetter) {
				return true;
			}
		
			return false;
		}
	

	
	public function setZendFormClassName()
	{
		if ( $this->checkFormSetterInstance() ) {
			$this->zendFormClassName = $this->getZendFormObjectNamespacePrefix().$this->getFormSetterInstance()->getZendFormClassName();
		}
		
		return $this->zendFormClassName;
	}
	
	public function setZendFormInstance()
	{
		$className = $this->zendFormClassName;
		if ( class_exists($className) ) {
			$this->zendFormInstance = new $className($this->getSetupManager());
		}

		return $this->zendFormInstance;
	}
	
	public function initializeForm()
	{
		if ( !$this->getZendFormInstance() ) {
			return false;
		}
		
		$this->getZendFormInstance()->setAttribute('method', 'post');
		$this->getZendFormInstance()->setAttribute('enctype', 'multipart/form-data');
		$this->getZendFormInstance()->setAttribute('class', 'form-horizontal');
		$this->getZendFormInstance()->setAttribute('role', 'form');
	}
	
	public function setFormAction($action)
	{
		if ( $this->getZendFormInstance() ) {
			$this->getZendFormInstance()->setAttribute('action', $action);
		}
	}
	
	public function setFormRecord()
	{
		$record = $this->getFormSetterInstance()->getRecord();
		if ($record) {
			$this->getZendFormInstance()->setData($record[0]);
		}
	}

}