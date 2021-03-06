.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Integrations with TypoScript
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This section gives you same examples which you can use when integrating EXT:finder into a website.

Add finder by TypoScript
"""""""""""""""""""""""""""""

If EXT:finder should be integrated by using TypoScript only, you can use this code snippet: ::

	lib.finder = USER
	lib.finder {
	  userFunc = tx_extbase_core_bootstrap->run
	  extensionName = Finder
	  pluginName = Pi1

	  switchableControllerActions {
		Finder {
		  1 = list
		}
	  }

	  settings < plugin.tx_finder.settings
	  settings {
		//categories = 49
		limit = 30
		detailPid = 31
		overrideFlexformSettingsIfEmpty := addToList(detailPid)
		startingpoint = 13
	  }
	}

Now you can use the object lib.finder.

List and detail on the same page using TypoScript
"""""""""""""""""""""""""""""""""""""""""""""""""""

This is the example of how to display list and detail view on the same page.

Base plugin settings: ::

	lib.finder = USER
	lib.finder {
			userFunc = tx_extbase_core_bootstrap->run
			pluginName = Pi1
			extensionName = Finder
			controller = Finder
			settings =< plugin.tx_finder.settings
			persistence =< plugin.tx_finder.persistence
			view =< plugin.tx_finder.view
	}

Configure list and detail actions: ::

	lib.finder_list < lib.finder
	lib.finder_list {
			action = list
			switchableControllerActions.Finder.1 = list
	}
	lib.finder_detail < lib.finder
	lib.finder_detail {
			action = detail
			switchableControllerActions.Finder.1 = detail
	}

Insert configured objects to wherever you want to use them, depending on the GET parameter of detail view: ::

	[globalVar = GP:tx_finder_pi1|finder > 0]
		page.10.marks.content < lib.finder_detail
	[else]
		page.10.marks.content < lib.finder_list
	[end]



Add finder to breadcrumb menu
"""""""""""""""""""""""""""""

If you want to show the finder title in the breadcrumb menu if the single view is currently selected, use a TypoScript like this: ::

    lib.navigation_breadcrumb = COA
    lib.navigation_breadcrumb {
        stdWrap.wrap = <ul class="breadcrumb">|</ul>

        10 = HMENU
        10 {
            special = rootline
            #special.range =  1

            1 = TMENU
            1 {
                noBlur = 1

                NO = 1
                NO {
                    wrapItemAndSub = <li>|</li>
                    ATagTitle.field = subtitle // title
                    stdWrap.htmlSpecialChars = 1
                }

                CUR <.NO
                CUR {
                    wrapItemAndSub = <li class="active">|</li>
                    doNotLinkIt = 1
                }
            }
        }

        # Add finder title if on single view
        20 = RECORDS
        20 {
            if.isTrue.data = GP:tx_finder_pi1|finder
            dontCheckPid = 1
            tables = tx_finder_domain_model_finder
            source.data = GP:tx_finder_pi1|finder
            source.intval = 1
            conf.tx_finder_domain_model_finder = TEXT
            conf.tx_finder_domain_model_finder {
                field = title
                htmlSpecialChars = 1
            }
            wrap =  <li>|</li>
        }
    }

The relevant part starts with *20 = RECORDS* as this cObject renders the title of the finder article. **Important:** Never forget the *source.intval = 1* to avoid SQL injections and the *htmlSpecialChars = 1* to avoid Cross-Site Scripting!

Add HTML to the header part in the detail view.
"""""""""""""""""""""""""""""""""""""""""""""""

There might be a use case where you need to add specific code to the header part when the detail view is rendered.
There are some possible ways to go.

Plain TypoScript
****************

You could use a code like the following one to render e.g. the title of a finder article inside a title-tag. ::

    [globalVar = TSFE:id = NEWS-DETAIL-PAGE-ID]

    config.noPageTitle = 2

    temp.finderTitle = RECORDS
    temp.finderTitle {
      dontCheckPid = 1
            tables = tx_finder_domain_model_finder
            source.data = GP:tx_finder_pi1|finder
            source.intval = 1
            conf.tx_finder_domain_model_finder = TEXT
            conf.tx_finder_domain_model_finder {
                field = title
                htmlSpecialChars = 1
            }
            wrap = <title>|</title>
    }
    page.headerData.1 >
    page.headerData.1 < temp.finderTitle

    [global]

Usage of a ViewHelper
**********************

Use a viewHelper of EXT:finder to write any code into the header part. The code could look like this
    <n:headerData><script>var finderId = {finderItem.uid};</n:headerData>

If you want to set the title tag, you can use a specific viewHelper: ::
    <n:titleTag>{finderItem.title}</n:titleTag>

