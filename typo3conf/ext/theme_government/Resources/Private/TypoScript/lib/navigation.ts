#-------------------------------------------------------------------------------
#	NAVIGATION: Navigation top right
#-------------------------------------------------------------------------------
lib.navigation.right = COA
lib.navigation.right {
	stdWrap.wrap = <ul class="nav pull-right">|</ul>

	10 = HMENU
	10 {
		special = directory
		special.value = {$plugin.theme_configuration.navigation.right}

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
				doNotLinkIt = 0
			}
		}
	}
}

#-------------------------------------------------------------------------------
#	NAVIGATION: Main
#-------------------------------------------------------------------------------
lib.navigation = COA
lib.navigation {
	stdWrap.wrap = <ul class="nav">|</ul>

	10 = HMENU
	10 {
		1 = TMENU
		1 {
			noBlur = 1
			expAll = 1

			NO = 1
			NO {
				wrapItemAndSub = <li>|</li>
				ATagTitle.field = subtitle // title
				stdWrap.htmlSpecialChars = 1
			}
				
			ACT < .NO
			ACT.wrapItemAndSub = <li class="active">|</li>

			CUR < .ACT
			
#			IFSUB = 1
#			IFSUB {
#				wrapItemAndSub = <li class="dropdown">| </li>
#				stdWrap.wrap = |&nbsp;<b class="caret"></b>
#				ATagParams = class="dropdown-toggle" data-toggle="dropdown"
#			}
#
#			ACTIFSUB < .IFSUB
#			ACTIFSUB {
#				wrapItemAndSub = <li class="dropdown active">|</li>
#			}
#			
#			CURIFSUB < .ACTIFSUB
#
#			SPC = 1
#			SPC {
#				wrapItemAndSub = <li class="divider-vertical">|</li>
#				doNotShowLink = 1
#			}
		}

#		2 < .1 
#		2 {
#			wrap = <ul class="dropdown-menu">|</ul>
#
#			IFSUB >
#			IFSUB = 1
#			IFSUB {
#				wrapItemAndSub = <li class="dropdown-submenu">|</li>
#				ATagParams = tabindex="-1"
#			}
#
#			ACTIFSUB >
#			ACTIFSUB < .IFSUB
#			ACTIFSUB.wrapItemAndSub = <li class="dropdown-submenu active">|</li>
#
#			CURIFSUB >
#			CURIFSUB < .ACTIFSUB
#
#			SPC >
#			SPC = 1
#			SPC {
#				wrapItemAndSub = <li class="divider"></li><li class="nav-header">|</li>
#			}
#
#		}
#		3 < .2
#		3 {
#			IFSUB >
#			ACTIFSUB >
#			CURIFSUB >
#		}

	}
}

#-------------------------------------------------------------------------------
#	NAVIGATION: Breadcrumb
#-------------------------------------------------------------------------------
lib.navigation.breadcrumb = COA
lib.navigation.breadcrumb {
	stdWrap.wrap = <ul class="breadcrumb">|</ul>

	10 = HMENU
	10 {
		special = rootline
		special.range = 0|-1

		1 = TMENU
		1 {
			//noBlur = 1

			NO = 1
			NO {
				linkWrap = <li>|<span class="divider">/</span></li>
				ATagTitle.field = subtitle // title
				stdWrap.htmlSpecialChars = 1
			}

			CUR = 1
			CUR {
				linkWrap = <li class="active">|</li>
				doNotLinkIt = 1
			}
		}
	}

	# Add news title if on single view
	20 = RECORDS
	20 {
		if.isTrue.data = GP:tx_news_pi1|news
		dontCheckPid = 1
		tables = tx_news_domain_model_news
		source.data = GP:tx_news_pi1|news
		source.intVal = 1
		conf.tx_news_domain_model_news = TEXT
		conf.tx_news_domain_model_news {
			field = title
			htmlSpecialChars = 1
		}
		wrap =  <li class="active">|</li>
	}
}

#-------------------------------------------------------------------------------
#	NAVIGATION: Subnavigation
#-------------------------------------------------------------------------------
lib.navigation.subnavigation = COA
lib.navigation.subnavigation {
	stdWrap.wrap = <ul class="nav nav-list bs-docs-sidenav">|</ul>

	10 = HMENU
	10 {
		entryLevel = 1
		1 = TMENU
		1 {
			noBlur = 1
			expAll = 1

			NO = 1
			NO {
				wrapItemAndSub = <li>|</li>
				ATagTitle.field = subtitle // title
				stdWrap.htmlSpecialChars = 1
			}
				
			ACT < .NO
			ACT.wrapItemAndSub = <li class="active">|</li>

			CUR < .ACT
			
#			IFSUB = 1
#			IFSUB {
#				wrapItemAndSub = <li class="dropdown">| </li>
#				stdWrap.wrap = |&nbsp;<b class="caret"></b>
#				ATagParams = class="dropdown-toggle" data-toggle="dropdown"
#			}
#
#			ACTIFSUB < .IFSUB
#			ACTIFSUB {
#				wrapItemAndSub = <li class="dropdown active">|</li>
#			}
#			
#			CURIFSUB < .ACTIFSUB
#
#			SPC = 1
#			SPC {
#				wrapItemAndSub = <li class="divider-vertical">|</li>
#				doNotShowLink = 1
#			}
		}

#		2 < .1 
#		2 {
#			wrap = <ul class="dropdown-menu">|</ul>
#
#			IFSUB >
#			IFSUB = 1
#			IFSUB {
#				wrapItemAndSub = <li class="dropdown-submenu">|</li>
#				ATagParams = tabindex="-1"
#			}
#
#			ACTIFSUB >
#			ACTIFSUB < .IFSUB
#			ACTIFSUB.wrapItemAndSub = <li class="dropdown-submenu active">|</li>
#
#			CURIFSUB >
#			CURIFSUB < .ACTIFSUB
#
#			SPC >
#			SPC = 1
#			SPC {
#				wrapItemAndSub = <li class="divider"></li><li class="nav-header">|</li>
#			}
#
#		}
#		3 < .2
#		3 {
#			IFSUB >
#			ACTIFSUB >
#			CURIFSUB >
#		}

	}
}


#-------------------------------------------------------------------------------
#	NAVIGATION: Language menu
#-------------------------------------------------------------------------------
lib.navigation.languageswitch = COA
lib.navigation.languageswitch {
	# Item to open language menu
	5 = TEXT
	5 {
		wrap = <a href="#" class="dropdown-toggle" data-toggle="dropdown">|<b class="caret"></b></a>
		data = LLL:EXT:theme_government/Resources/Private/Language/locallang.xml:language_switch-label
	}

	# Language menu
	10 = HMENU
	10 {
		special = language
		special.value = {$plugin.theme_configuration.navigation_languageswitch.languages}

		wrap = <ul class="dropdown-menu">|</ul>

		1 = TMENU
		1 {
			noBlur = 1

			NO = 1
			NO {
				wrapItemAndSub = <li>|</li>
				stdWrap.cObject = TEXT
				stdWrap.cObject.value = {$plugin.theme_configuration.navigation_languageswitch.labels}
			}
			ACT <.NO
			ACT {
				wrapItemAndSub = <li class="active">|</li>
			}
		}
	}
}


#-------------------------------------------------------------------------------
#	NAVIGATION: Footer
#-------------------------------------------------------------------------------
lib.navigation.footer = COA
lib.navigation.footer {
	stdWrap.wrap = |

	10 = HMENU
	10 {

		special = directory
		special.value = {$plugin.theme_configuration.navigation.footer}

		1 = TMENU
		1 {
			noBlur = 1
			expAll = 1

			NO = 1
			NO {
					wrapItemAndSub = <li>|</li><li class="muted">&middot;</li> |*| <li>|</li><li class="muted">&middot;</li> |*| <li>|</li>
					ATagTitle.field = subtitle // title
					stdWrap.htmlSpecialChars = 1
			}

			ACT < .NO
			ACT.wrapItemAndSub = <li class="active">|</li><li class="muted">&middot;</li> |*| <li class="active">|</li><li class="muted">&middot;</li> |*| <li class="active">|</li>

			CUR < .ACT
		}
	}
}

#-------------------------------------------------------------------------------
#	NAVIGATION: Footer (right)
#-------------------------------------------------------------------------------
lib.navigation.footer.top = TEXT
lib.navigation.footer.top {
	wrap = |
	data = LLL:EXT:theme_government/Resources/Private/Language/locallang.xml:toplink
	typolink {
		parameter.dataWrap = {getIndpEnv:TYPO3_REQUEST_URL}#top
	}
}