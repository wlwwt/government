.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Extending EXT:finder
^^^^^^^^^^^^^^^^^^^^^^

This tutorial will help you to extend the extension "finder".

Custom ViewHelpers
""""""""""""""""""""
It is very easy to adopt the output of EXT:finder by using custom ViewHelpers. There you can use the full power of PHP to
add stuff you need.

All you need is a new extension with a structure like: ::

	Classes\
		ViewHelpers\
			YourNewViewHelper.php
	ext_emconf.php

and you can then use your ViewHelper in the template like this: ::

	{namespace y=Tx_NameOfYourExtension_ViewHelpers}
    <y:yourNew>test</y:yourNew>

To get to know how a ViewHelper needs to look like, check the ViewHelpers of EXT:finder,
the core (typo3/sysext/fluid/Classes/ViewHelpers) or any other extbase based extension.


Extend the classes
""""""""""""""""""""

Extending a model is a typical usecase when dealing with customer's projects. This tutorial will show how to extend
the finder record with one text field.

Extend the database table
**************************

Use extension kickstarter or extension_builder to extend the finder record with one field.
In this tutorial the extension will be called workshop and the field will therefore be *tx_workshop_title*.
You are finished with this step if you can add content to the new field in the backend.

**Create the model**

Create a model for your additional field.
Important: the structure needs to match the one of EXT:finder. If you wanna extend *Tx_Finder_Domain_Model_Finder*,
your class needs to be *Tx_Workshop_Domain_Model_Finder*, which means having the file *Finder.php* in *EXT:workshop/Classes/Domain/Model/*.

The content looks like: ::

	<?php

		class Tx_Workshop_Domain_Model_Finder extends Tx_Finder_Domain_Model_Finder {

			/**
			* @var string
			*/
			protected $txWorkshopTitle;

			public function getTxWorkshopTitle() {
				return $this->txWorkshopTitle;
			}
			public function getWorkshopTitle() {
				return $this->txWorkshopTitle;
			}
		}

	?>

The property $txWorkshopTitle needs to match the database field (underscores in the field name need to be transferred to camelcase).

**Tell EXT:finder about it.**

EXT:finder still doesn't now anything about the extension workshop.
Therefore create the file *EXT:workshop/Resources/Private/extend-finder.txt* with the content ::

	Domain/Model/Finder

As explanation: Add per line the path to the file you want to extend


Clear Cache
***************

clear the cache and you are done. EXT:finder will fetch the content of all files which extend the ones from EXT:finder and will create some proxy classes in
*typo3temp/Cache/Code/cache_phpcode/*, in this example the file Domain_Model_Finder.php


Use the new field in the template
*********************************

You can now use the new field in the template by using ::

	{finderItem.txWorkshopTitle}

or ::

	{finderItem.workshopTitle}


Extend the sorting properties in the plugin settings
""""""""""""""""""""""""""""""""""""""""""""""""""""""

Default values in "Sort by" are: **tstamp,datetime,crdate,title**.

Add a new value (e.g. starttime in the below example): ::

	$GLOBALS['TYPO3_CONF_VARS']['EXT']['finder']['orderByFinder'] .= ',starttime';

Add this in ext_tables.php of a custom extension.

