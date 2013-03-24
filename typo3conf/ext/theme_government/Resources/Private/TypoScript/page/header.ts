# **********************************************************
# header related stuff
# **********************************************************

page.headerData.5 = COA
page.headerData.5 {
	
	#Le HTML5 shim, for IE6-8 support of HTML5 elements
	20 = TEXT 
	20.value (
<!--[if lt IE 9]>
<script src="typo3conf/ext/theme_government/Resources/Public/Template/js/html5shiv.js"></script>
<![endif]-->

	)

	#Touch Icons for Ipad, etc
	50 = TEXT 
	50.value (
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="typo3conf/ext/theme_government/Resources/Public/Template/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="typo3conf/ext/theme_government/Resources/Public/Template/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="typo3conf/ext/theme_government/Resources/Public/Template/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="typo3conf/ext/theme_government/Resources/Public/Template/ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="typo3conf/ext/theme_government/Resources/Public/Template/ico/favicon.png">

	)

	#activate mobile ClearType technology for smoothing fonts for easy reading
	90 = TEXT
	90.value (
<meta http-equiv="cleartype" content="on">

	)

}


