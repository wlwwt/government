.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Reference
^^^^^^^^^

This chapter describes the settings which are available in finder.
Except of setting the template paths and overriding labels of the
locallang-file, the settings are defined by using
plugin.tx\_finder.settings.<property>.

A simple way to get to know the default settings is to look at the
file EXT:finder/Configuration/TypoScript/setup.txt


General properties
""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:
         view.templateRootPath

   :Data type:
         string

   :Description:
         Path to the templates. The default setting is
         EXT:finder/Resources/Private/Templates/

   :Default:
         **Extbase default**


 - :Property:
         view.partialRootPath

   :Data type:
         string

   :Description:
         Path to the partials. The default setting is
         EXT:finder/Resources/Private/Templates/

   :Default:
         **Extbase default**


 - :Property:
         view.layoutRootPath

   :Data type:
         string

   :Description:
         Path to the layouts. The default setting is
         EXT:finder/Resources/Private/Templates/

   :Default:
         **Extbase default**


 - :Property:
         Settings.cssFile

   :Data type:
         string

   :Description:
         Path to the css file. The default setting is

         EXT:finder/Resources/Public/Css/finder-basic.css

   :Default:


 - :Property:
         format

   :Data type:
         string

   :Description:
         Set a different format for the output. Use e.g. “xml” for RSS feeds.

   :Default:
         html


 - :Property:
         displayDummyIfNoMedia

   :Data type:
         boolean

   :Description:
         If set, a dummy image is displayed if no preview image can be found

   :Default:
         1


 - :Property:
         overrideFlexformSettingsIfEmpty

   :Data type:
         string

   :Description:
         The default behaviour of finder and extbase is to override settings from
         TS by the one of the flexforms. This is even valid if the setting is
         left empty in the flexforms.

         Set a comma separated list of fields which get the value of the TS
         setting if the setting is not defined in the plugin configuration.

   :Default:
         cropLength


 - :Property:
         pidDetailFromCategories

   :Data type:
         boolean

   :Description:
         Enable selecting ID of the detail page from the related categories.
         This overrides the detail view setting which can be set with
         TypoScript/Plugin.

   :Default:
         1


 - :Property:
         link.hrDate

   :Data type:
         array

   :Description:
         The url to a single finder record contains only the uid of the record.
         Sometimes it is nice to have the date in url too (e.g.
         domain.tld/finder/2011/8/finder-title.html). If enabled, the date is added
         to the url.

         Each parameter (day, month, year) can be separately configured by using
         the full options of the `php function date()
         <http://at2.php.net/manual/en/function.date.php>`_ . This example will
         add the day as a number without leading zeros, the month with leading
         zeros and the year by using 4 digits. ::

            link {
                    hrDate = 1
                    hrDate {
                            day = j
                            month = m
                            year = Y
                    }
            }

   :Default:
         0

 - :Property:
         link.typesOpeningInNewWindow

   :Data type:
         string

   :Description:
         Comma separated list of finder types which open with target="_blank"
         Default is 2 which is the type "Link to external page"

   :Default:
         2


 - :Property:
         cropMaxCharacters

   :Data type:
         integer

   :Description:
         Length of the teaser in list view.

   :Default:
         150


 - :Property:
         orderBy

   :Data type:
         string

   :Description:
         Field which is used to sort finder records

   :Default:
         datetime


 - :Property:
         orderDirection

   :Data type:
         string

   :Description:
         Field which is used to set sorting direction. This can either be desc
         or asc.

   :Default:
         desc


 - :Property:
         topFinderFirst

   :Data type:
         boolean

   :Description:
         If set, finder records which are are flagged as “Top Finder” are shown
         before the others

   :Default:
         0


 - :Property:
         interfaces.media

   :Data type:
         string

   :Description:
         List of classes which are considered for rendering media elements

   :Default:


 - :Property:
         facebookLocale

   :Data type:
         string

   :Description:
         Facebook locale which is used to translate facebook texts. Examples
         de\_DE, fr\_FR, ...

   :Default:
         en\_US


[tsref:plugin.tx\_finder.settings]


Reference for list view
"""""""""""""""""""""""

The following table describes the settings concerning the list view.

**Important:** Those are set by using plugin.tx\_finder.settings.list!

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:
         paginate.

   :Data type:
         array

   :Description:
         finder uses a custom viewHelper to render the pagination as the default
         one from fluid is very limited.

         Following settings are available:

         **itemsPerPage**

         Define how many items are shown on one page.

         **insertAbove**

         Set it to TRUE or FALSE to either show or hide the pagination before
         the actual finder items.

         **insertBelow**

         Set it to TRUE or FALSE to either show or hide the pagination after
         the actual finder items.

         **lessPages**

         If set to TRUE, not all pages of the pagination are shown. Imagine
         1000 finder records and 10 items per page. This would result in 100
         links in the frontend.

         All the next options are only available when lessPages = TRUE:

         **forcedNumberOfLinks**

         Define the maximum number of pages shown in the pagination.

         **pagesBefore**

         If pages are skipped in the pagination you can define how many pages
         before the actual one should be still shown.

         **pagesAfter**

         If pages are skipped in the pagination you can define how many pages
         after the actual one should be still shown.

         **prevNextHeaderTags**

         Add additional header tags <link rel="prev" href"" /> and
         <link rel="next" href"" /> to tell google about the pagination.
         Read more at http://googlewebmastercentral.blogspot.co.at/2011/09/pagination-with-relnext-and-relprev.html

         **templatePath**

         Set a custom template file for the paginate widget.
         The path has to point to the template file, for example :code:`EXT:foobar/Resources/Private/Templates/ViewHelpers/Widget/Paginate/Index.html`

   :Default:
         itemsPerPage = 10

         insertAbove = TRUE

         insertBelow = TRUE

         lessPages = TRUE

         forcedNumberOfLinks = 5

         pagesBefore = 3

         pagesAfter = 3

         prevNextHeaderTags = 1


 - :Property:
         media.image.maxWidth

   :Data type:
         integer/string

   :Description:
         Maximum width of images. The cropping feature can also be used (e.g.
         30c)

   :Default:
         100


 - :Property:
         media.image.maxHeight

   :Data type:
         integer/string

   :Description:
         Maximum height of images. The cropping feature can also be used (e.g.
         30c)

   :Default:
         100


Reference for detail view
"""""""""""""""""""""""""

The following table describes the settings concerning the list view.

**Important:** Those are set by using plugin.tx\_finder.settings.detail!

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:


   :Data type:


   :Description:


   :Default:


Reference for searchform view
"""""""""""""""""""""""""""""

The following table describes the settings concerning the list view.

**Important:** Those are set by using
plugin.tx\_finder.settings.searchform!

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:


   :Data type:


   :Description:


   :Default:


Reference for Date Menu
"""""""""""""""""""""""

The following table describes the settings concerning the list view.

**Important:** Those are set by using plugin.tx\_finder.settings.list!

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:


   :Data type:


   :Description:


   :Default:


Reference for rendering content elements
"""""""""""""""""""""""""""""""""""""""""

If finder is configured to use relations to content elements, a basic
TypoScript configuration is used to render those. This look like this::

   lib.tx_finder.contentElementRendering = RECORDS
   lib.tx_finder.contentElementRendering {
           tables = tt_content
           source.current = 1
           dontCheckPid = 1
   }

If you need to extend this, you can either change the TypoScript (e.g.
using a UserFunc) or the maybe easier way would be to change it in the
template where the content elements are included by using the
cObjectViewHelper of Fluid::

   <f:if condition="{finderItem.contentElements">
           <f:cObject typoscriptObjectPath="lib.tx_finder.contentElementRendering">{finderItem.contentElements}</f:cObject>
   </f:if>

You could use your own ViewHelper to render those content elements as
you need it.
