<?php
/**
 * No Index Decorator
 * 
 */
class NoIndexDecorator extends DataObjectDecorator {
	
	public function extraStatics() {
		return array(
			'db' => array(
				'BlockFromSearchEngines' => 'boolean',
			)
		);
	}
	
	public function updateCMSFields(&$fields) {
		if ($this->owner instanceof SiteTree) {
			$tab = $fields->findOrMakeTab('Root.Content.Metadata');
			$tab->push($block = new CheckboxField('BlockFromSearchEngines', "Tell search engines not to index this page"));
		} else if ($this->owner instanceof Folder) {
			$tab = $fields->findOrMakeTab('Root.Files');
			$tab->insertAfter($block = new CheckboxField('BlockFromSearchEngines', "Tell search engines not to index this folder"), 'Title');
		}

		if (Robots::$block_entire_site) {
			$block->setTitle("Entire site is not indexed");
			$block->performReadonlyTransformation();
			$block->setDisabled(true);
		}
		
	}
	
	public function MetaTags(&$tags) {
		if (Robots::$block_entire_site || $this->owner->BlockFromSearchEngines) {
			$tags .= "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
		}
	}
}