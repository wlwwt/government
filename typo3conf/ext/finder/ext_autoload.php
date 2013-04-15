<?php
$extensionClassesPath = t3lib_extMgm::extPath('finder') . 'Classes/';
require_once(t3lib_extMgm::extPath('finder') . 'Classes/Cache/ClassCacheBuilder.php');

$default = array(
	'tx_finder_domain_model_dto_emconfiguration' => $extensionClassesPath . 'Domain/Model/Dto/EmConfiguration.php',
	'tx_finder_hooks_suggestreceiver' => $extensionClassesPath . 'Hooks/SuggestReceiver.php',
	'tx_finder_hooks_suggestreceivercall' => $extensionClassesPath . 'Hooks/SuggestReceiverCall.php',
	'tx_finder_utility_compatibility' => $extensionClassesPath . 'Utility/Compatibility.php',
	'tx_finder_utility_importjob' => $extensionClassesPath . 'Utility/ImportJob.php',
	'tx_finder_utility_emconfiguration' => $extensionClassesPath . 'Utility/EmConfiguration.php',
	'tx_finder_service_cacheservice' => $extensionClassesPath . 'Service/CacheService.php',
);

$classCacheBuilder = t3lib_div::makeInstance('Tx_Finder_Cache_ClassCacheBuilder');
$mergedClasses = array_merge($default, $classCacheBuilder->build());
return $mergedClasses;

?>