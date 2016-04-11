<?php

/**
 * Comparison Slider Widget for Contao Open Source CMS
 *
 * @copyright Postyou 2016
 * @author Mario Gienapp
 * @link https://postyou.de
 * @license http://creativecommons.org/licenses/by-sa/4.0/ CC BY-SA 4.0
 */


/*
 * Content elements
 */
array_insert($GLOBALS['TL_CTE'], 1, array
(
	'Comparison Slider' => array(
		'Einzelelement'		=> 'ComparisonSlider\ContentComparisonSlider'
	),
));
