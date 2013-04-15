.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Migration from tt_finder to finder
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This tutorial will help you to migrate records from tt_finder to finder.

**Important:** The implementation of the importer is rather basic, please look at the `Bugtracker <http://forge.typo3.org/projects/extension-finder/issues>`_ for open issues with the category "*Importer*".

Requirements
"""""""""""""

* Installed extension tt_finder
* Installed extension finder (at least version 2.0.0)

Migration
""""""""""

To be able to migrate records, you need to activate the import module.
This needs to be done in the configuration of EXT:finder inside the extension manager.

#. Activate the checkbox "Show importer", save and reload the backend. Now you should see the backend module "Finder Import".

#. Switch to the backend module.

#. Select "Import tt_finder category records" from the select box and start the import of categories.

#. Select "Import tt_finder finder records" from the select box and start the import of finder records.

Not migrated
************

The following things are not migrated:

* Plugins
* TypoScript configuration
* Fields of records which are added by 3rd party extensions
