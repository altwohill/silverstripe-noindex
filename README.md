No-Index Module for Silverstripe
================================

*Author: Al Twohill <[firstname]@hol.net.nz>*  
*Copyright: 2011 Al Twohill*

This module allows you to remove specific pages and folders from search engines such as Google, as well as prevent your entire site from being indexed.

This might be useful e.g. if you have an online development site that is publicly accessible but you'd rather wasn't showing up in search results.

Note that this won't prevent nasty crawlers from ignoring the rules and indexing them, and this is **not** a security mechanism!

How To Use
----------

Save this module into a folder called `noindex` and do a `/dev/build`. You can now block individual files and folders from within the CMS by ticking the box "Tell search engines not to index this page". You will find this option:

*	For Pages, under Content->Metadata
*	For Folders, under Files

Or you can block the entire site by adding

`Robots::$block_entire_site = $true;` 

into your `/mysite/_config.php` file.

What This Module Does
---------------------

The module creates a url handler for /robots.txt which contains all the urls not allowed. For example, if `Robots::$block_entire_site` is set to **true**, it will generate the following:

		User-agent: *
		Disallow: /
		
For pages, it also inserts a header `<meta name="robots" content="noindex, nofollow">`.

Todo
----

*	Think of a way to block different User-agents
*	Allow for generic rules through SiteConfig or similar
*	?

Caveats
-------

*	If you have a file called robots.txt the file will take precedence
*	Disallowing robot access to "/secret-folder/" makes it more likely to be found by nefarious crawlers 
