<?php

namespace Posts\Model;

use Setup\SetupManager;

/**
 * Given postsData, set the additional infos on the arrays...
 * @author Andrea fiori
 * @since  05 January 2014
 */
class PostsRecordsHelper {

	private $postsRecords, $postsRecordsCount;
	
	private $setupManager;
	
	private $partialLayoutTemplate;

	public function __construct(array $postsRecords)
	{
		$this->postsRecords = $postsRecords;
		$this->postsRecordsCount = count($postsRecords);
	}
	
	public function getSetupManager()
	{
		return $this->setupManager;
	}
	
	public function setSetupManager(SetupManager $setupManager)
	{
		$this->setupManager = $setupManager;
	}

	public function setAdditionalArrayElements()
	{
		if (!$this->getSetupManager() or !$this->getPostsRecords() ) {
			return false;
		}
		
		$postsRecords = array();
		foreach($this->getPostsRecords() as $record)
		{
			$record['linkDetails'] = $this->getLinkDetails($record);
			$postsRecords[] = $record;
		}
		$this->postsRecords = $postsRecords;
		
		$this->assignLayout($record['typeofpost']);
	}
	
		private function getLinkDetails($record)
		{
			if ($record['name'] == $record['title']) {
				unset($record['seoUrl']);
			} else {
				$record['seoUrl'] = $record['seoUrl'].'/';
			}
			return $this->getSetupManager()->getSetupRecord('remotelinkWeb').'it/'. \Setup\StringRequestDecoder::slugify($record['name']).'/'.$record['seoUrl'];
		}
	
	public function assignLayout($typeOfPost)
	{
		if (!$typeOfPost) return false;
		
		if ($this->postsRecordsCount == 1) {
			$this->partialLayoutTemplate = $typeOfPost.'/detail.php';
		} elseif ($this->postsRecordsCount > 1) {
			$this->partialLayoutTemplate = $typeOfPost.'/list.php';
		}
		
		return $this->partialLayoutTemplate;
	}
	
	public function setPartialLayoutTemplate($layout)
	{
		$this->partialLayoutTemplate = $layout;
		
		return $this->partialLayoutTemplate;
	}

	public function getPartialLayoutTemplate()
	{
		return $this->partialLayoutTemplate;
	}
	
	public function getPostsRecords()
	{
		return $this->postsRecords;
	}

	public function sortPostsByAlias()
	{
		$postsAlias = array();
		foreach($this->getPostsRecords() as $posts)
		{
			if (isset($posts['alias'])) {
				$postsAlias[ $posts['alias'] ] = $posts;
			}
		}
		$this->postsRecords = $postsAlias;
	
		return $this->postsRecords;
	}
}