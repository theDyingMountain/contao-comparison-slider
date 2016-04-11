<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'ComparisonSlider',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'ComparisonSlider\ContentComparisonSlider' => 'system/modules/contao-comparison-slider/elements/ContentComparisonSlider.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_comparison_slider' => 'system/modules/contao-comparison-slider/templates',
));
