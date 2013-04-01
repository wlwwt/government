# ******************************************************************************
#	(c) 2012 Georg Ringer <typo3@ringerge.org>
#
#	You can redistribute it and/or modify it under the terms of the
#	GNU General Public License as published by the Free Software Foundation;
#	either version 2 of the License, or (at your option) any later version.
# ******************************************************************************

# **********************************************************
# General PAGE setup
#
# including template, CSS + JS files
# **********************************************************

page = PAGE
page {

	# Page template
	10 = FLUIDTEMPLATE
	10 {
		file.stdWrap.cObject = CASE
		file.stdWrap.cObject {
			key.data = levelfield:-1, backend_layout_next_level, slide
			key.override.field = backend_layout

			default = TEXT
			default.value = EXT:theme_government/Resources/Private/Templates/default.html
			2 = TEXT
			2.value = EXT:theme_government/Resources/Private/Templates/gov_1col.html
		}
		#partialRootPath = EXT:theme_government/Resources/Private/Templates/
		layoutRootPath = EXT:theme_government/Resources/Private/Templates/Layouts/
		variables {

		}
	}

	# CSS files to be included
	includeCSS {
		file1 = EXT:theme_government/Resources/Public/Template/css/government.min.css
		file1.media = screen,print
		file2 = EXT:theme_government/Resources/Public/Template/css/government-responsive.min.css
		file2.media = screen,print
	}

	# JS files to be included
	includeJSFooter {
		file1 = EXT:theme_government/Resources/Public/Template/js/jquery.min.1.9.1.js
		file2 = EXT:theme_government/Resources/Public/Template/js/government.min.js
		file3 = EXT:theme_government/Resources/Public/Template/js/application.js
	}

	includeJSFooterlibs {
	#jQuery = EXT:theme_government/Resources/Public/Template/js/jquery.js
	}


	# Add some good classes to the bodytag to make a styling of special pages easier
	bodyTagCObject = COA
	bodyTagCObject   {
		stdWrap.wrap = <body class="|">

		# Add page UID
		10 = TEXT
		10 {
			value = page-{field:uid}
			insertData = 1
			noTrimWrap = || |
		}

		# Add uid of the backend-layout
		20 = TEXT
		20 {
			wrap = template-|
			data = levelfield:-1, backend_layout_next_level, slide
			override.field = backend_layout
			noTrimWrap = || |
		}

		# Add uid of FE-layout
		30 = TEXT
		30 {
			fieldRequired = layout
			value = layout-{field:layout}
			insertData = 1
		}
	}

}