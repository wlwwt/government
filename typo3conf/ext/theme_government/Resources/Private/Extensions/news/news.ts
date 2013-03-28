# ******************************************************************************
#	(c) 2012 Georg Ringer <typo3@ringerge.org>
#
#	You can redistribute it and/or modify it under the terms of the
#	GNU General Public License as published by the Free Software Foundation;
#	either version 2 of the License, or (at your option) any later version.
# ******************************************************************************


# **********************************************************
# Changes to EXT:news
# **********************************************************

plugin.tx_news {
	view {
		templateRootPath = EXT:theme_government/Resources/Private/Extensions/news/Templates/
		partialRootPath = EXT:theme_government/Resources/Private/Extensions/news/Partials/
		layoutRootPath = EXT:theme_government/Resources/Private/Extensions/news/Layouts/
        widget.Tx_News_ViewHelpers_Widget_PaginateViewHelper.templateRootPath = EXT:theme_government/Resources/Private/Extensions/news/
	}

	settings.list.paginate.insertAbove = 0
	
	settings.cropMaxCharacters = 220

	settings.list.media.image.maxWidth = 250
	settings.list.media.image.maxHeight = 250
	
	settings.list.paginate {
		itemsPerPage = 3
		insertAbove = 0
		insertBelow = 1
		lessPages = 1
		forcedNumberOfLinks = 5
		pagesBefore = 3
		pagesAfter = 3
		templatePath =
		prevNextHeaderTags = 1
	}
}


#-------------------------------------------------------------------------------
#	EXT:news Latest news
#-------------------------------------------------------------------------------

lib.extensions.news_latest = USER
lib.extensions.news_latest {
	userFunc = tx_extbase_core_bootstrap->run
	extensionName = News
	pluginName = Pi1

	switchableControllerActions {
		News {
			1 = list
		}
	}
	settings < plugin.tx_news.settings
	settings {
		hidePagination = 1
		cropMaxCharacters = {$plugin.theme_configuration.extensions.news.latest.cropMaxCharacters}
		detailPid = {$plugin.theme_configuration.extensions.news.latest.detailPid}
		limit = {$plugin.theme_configuration.extensions.news.latest.limit}
		startingpoint = {$plugin.theme_configuration.extensions.news.latest.startingpoint}

		isLatest = 1
	}
}