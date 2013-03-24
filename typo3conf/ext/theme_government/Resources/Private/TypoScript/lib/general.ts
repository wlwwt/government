#-------------------------------------------------------------------------------
#	GENERAL: Header Logo
#-------------------------------------------------------------------------------

lib.general.header.logo = COA
lib.general.header.logo {
	10 = TEXT
	10.value = <img src="{$plugin.theme_configuration.general.header.logo.image}" />
	10.typolink {
		parameter = {$plugin.theme_configuration.general.header.logo.link}
		wrap = |
	}
}

lib.copyright_information = COA
lib.copyright_information {
	10 = TEXT
	10 {
		data = date:U
		strftime = %Y
		noTrimWrap = || {LLL:EXT:theme_government/Resources/Private/Language/locallang.xml:copyright}|
		noTrimWrap.insertData = 1
		typolink.parameter = {$plugin.theme_configuration.general.copyright_information.link}
	}
}

#-------------------------------------------------------------------------------
#	GENERAL: Header slogan
#-------------------------------------------------------------------------------
lib.header_slogan = COA
lib.header_slogan {
	10 = TEXT
	10 {
		value = III Modern <div>package</div>
	}
}

#-------------------------------------------------------------------------------
#	GENERAL: Footer image
#-------------------------------------------------------------------------------
lib.footer_logo = COA
lib.footer_logo {
	10 = IMAGE
	10 {
		file = EXT:theme_government/Resources/Public/Template/img/logo-government-package-footer.png
	}
}
