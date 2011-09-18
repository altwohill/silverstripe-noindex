<?php

Director::addRules(10, array(
	'robots.txt' => 'Robots',
));

Object::add_extension('SiteTree', 'NoIndexDecorator');
Object::add_extension('Folder', 'NoIndexDecorator');