#-------------------------------------------------------------------------------
#	GENERAL: Header Logo
#-------------------------------------------------------------------------------

lib.general.header.logo = COA
lib.general.header.logo {
	10 = TEXT
	10.value = <img src="{$plugin.theme_configuration.general.header.logo.image}" alt="{$plugin.theme_configuration.general.header.name}" title="{$plugin.theme_configuration.general.header.name}" />
	10.typolink {
		parameter = {$plugin.theme_configuration.general.header.logo.link}
	}
}

#-------------------------------------------------------------------------------
#	GENERAL: Header Navigation Pagename
#-------------------------------------------------------------------------------
lib.general.header.name = COA
lib.general.header.name {
	10 = TEXT
	10.value = {$plugin.theme_configuration.general.header.name}
	10.typolink {
		parameter = {$plugin.theme_configuration.general.header.logo.link}
		ATagParams = class=brand
	}
}

#-------------------------------------------------------------------------------
#	GENERAL: Footer address
#-------------------------------------------------------------------------------
lib.general.footer.address = COA
lib.general.footer.address {
	wrap = <p>|</p>
	10 = TEXT
	10 {
		value = {$plugin.theme_configuration.general.footer.address}&nbsp;
	}
	50 = TEXT
	50 {
		value = {$plugin.theme_configuration.general.footer.email}
		typolink.parameter = {$plugin.theme_configuration.general.footer.email}
	}
}
