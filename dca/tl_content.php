<?php

/**
 * Comparison Slider Widget for Contao Open Source CMS
 *
 * @copyright Postyou 2016
 * @author Mario Gienapp
 * @link https://postyou.de
 * @license http://creativecommons.org/licenses/by-sa/4.0/ CC BY-SA 4.0
 */

use Contao\Input;
use Contao\Backend;
use Contao\ArrayUtil;
use Contao\BackendUser;

/*
 * Config
 */

$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = function ($dc) {
	if ($_POST || Input::get('act') != 'edit')
		return;

	$objUser = BackendUser::getInstance();

	if (!$objUser->hasAccess('themes', 'modules') ||  !$objUser->hasAccess('layout', 'themes'))
		return;
};

/*
 * Palettes
 */

ArrayUtil::arrayInsert($GLOBALS['TL_DCA']['tl_content']['palettes'], 0, array(

	'Einzelelement'		=> '{type_legend},type;{Slider Einstellungen}, pictureLeftSRC,pictureRightSRC,size, textLeft, textLeftPosition	,textRight, textRightPosition;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop',

));

/*
 * Fields
 */
ArrayUtil::arrayInsert($GLOBALS['TL_DCA']['tl_content']['fields'], 0, array(

	'pictureLeftSRC' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['pictureLeftSRC'],
		'inputType'		=> 'fileTree',
		'eval'          => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => ''),
		'sql'			=> 'binary(16) NULL'
	),

	'pictureRightSRC' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['pictureRightSRC'],
		'inputType'		=> 'fileTree',
		'eval'          => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => ''),
		'sql'			=> 'binary(16) NULL'
	),

	'textLeft' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['textLeft'],
		'inputType'		=> 'text',
		'eval'          => array('maxlength' => 256, 'tl_class' => 'w50 clr'),
		'sql'			=> "varchar(256) NOT NULL default ''"
	),

	'textLeftPosition' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['textLeftPosition'],
		'inputType'		=> 'select',
		'eval'          => array('maxlength' => 256, 'tl_class' => 'w50'),
		'options_callback' => array('tl_comparison_slider', 'getTextPositionOptions'),
		'sql'			=> "varchar(256) NOT NULL default ''"
	),

	'textRight' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['textRight'],
		'inputType'		=> 'text',
		'eval'          => array('maxlength' => 256, 'tl_class' => 'w50'),
		'sql'			=> "varchar(256) NOT NULL default ''"
	),

	'textRightPosition' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['textRightPosition'],
		'inputType'		=> 'select',
		'eval'          => array('maxlength' => 256, 'tl_class' => 'w50'),
		'options_callback' => array('tl_comparison_slider', 'getTextPositionOptions'),
		'sql'			=> "varchar(256) NOT NULL default ''"
	)
));

class tl_comparison_slider extends Backend {

	public function getTextPositionOptions() {
		return array(
			"top-left" => "Top Left",
			"top-right" => "Top Right",
			"bottom-left" => "Bottom Left",
			"bottom-right" => "Bottom Right"
		);
	}
}
