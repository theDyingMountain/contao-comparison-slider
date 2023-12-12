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
use Contao\Message;
use Contao\FilesModel;
use Contao\BackendUser;
use Contao\DataContainer;

/*
 * Config
 */

$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = function ($dc) {
	if ($_POST || Input::get('act') != 'edit')
		return;

	$objUser = BackendUser::getInstance();

	if (!$objUser->hasAccess('themes', 'modules') ||  !$objUser->hasAccess('layout', 'themes'))
		return;

	// $objCte = ContentModel::findByPk($dc->id);

	// if ($objCte === null)
	// 	return;

	// switch ($objCte->type)
	// {
	// 	case 'juiTabStart':
	// 	case 'juiTabSeparator':
	// 	case 'juiTabStop':
	// 		Message::addInfo(sprintf($GLOBALS['TL_LANG']['tl_content']['includeTemplate'], 'j_ui_tabs'));
	// 		break;
	// }
};


/*
 * Palettes
 */
//$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'juiTabShowDropdown';

array_insert($GLOBALS['TL_DCA']['tl_content']['palettes'], 0, array(

	'Einzelelement'		=> '{type_legend},type;{Slider Einstellungen}, pictureLeftSRC,pictureRightSRC,size, textLeft, textLeftPosition	,textRight, textRightPosition;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop',

));

$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('tl_comparison_slider', 'checkFileSize');


/*
 * Subpalettes
 */
//$GLOBALS['TL_DCA']['tl_content']['subpalettes']['juiTabShowDropdown'] = 'juiTabDropdownLabel';


/*
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_content']['fields'], 0, array(

	// 'pictureInfoField' => array(
	// 	'input_field_callback' => array(
	// 		'tl_comparison_slider', 'pictureInfoField'
	// 	)
	// ),

	'pictureLeftSRC' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['pictureLeftSRC'],
		'inputType'		=> 'fileTree',
		'eval'          => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => ''),
		// 'save_callback' => array
		// 			(
		// 				array('tl_comparison_slider', 'checkFileSize')
		// 			),
		'sql'			=> 'binary(16) NULL'
	),

	'pictureRightSRC' => array(
		'label'			=> &$GLOBALS['TL_LANG']['tl_content']['pictureRightSRC'],
		'inputType'		=> 'fileTree',
		'eval'          => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => ''),
		// 'save_callback' => array
		// 					(
		// 						array('tl_comparison_slider', 'checkFileSize')
		// 					),
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

	// public function pictureInfoField() {
	// 	return "<div><p class=\"tl_help tl_tip\" style=\"margin:1em 0 1em; padding-bottom:0.5em; border-bottom: solid 1px #ddd;\">Hinweis: Beide Bilder müssen in Breite und Höhe übereinstimmen.</p></div>";
	// }

	public function checkFileSize(DataContainer $dc) {
		$pictureLeft = FilesModel::findByUuid($dc->activeRecord->pictureLeftSRC);
		$pictureRight = FilesModel::findByUuid($dc->activeRecord->pictureRightSRC);

		if (!empty($pictureLeft) && !empty($pictureRight)) {
			list($pictureLeftWidth, $pictureLeftHeight) = getimagesize("../" . $pictureLeft->path);
			list($pictureRightWidth, $pictureRightHeight) = getimagesize("../" . $pictureRight->path);


			if ($pictureLeftWidth !== $pictureRightWidth || $pictureLeftHeight !== $pictureRightHeight) {
				Message::addError("Die Dimensionen (Breite, Höhe) der Bilder stimmen nicht überein!");
				$dc->activeRecord->pictureLeftSRC = null;
				$dc->activeRecord->pictureRightSRC = null;

				$this->Database->query("UPDATE tl_content SET pictureLeftSRC=null, pictureRightSRC=null WHERE id=" . $dc->activeRecord->id);

				unset($_POST['saveNclose']);
				unset($_POST['saveNback']);
				unset($_POST['saveNcreate']);
				unset($_POST['saveNedit']);
			}
		}
	}

	public function getTextPositionOptions() {
		return array(
			"top-left" => "Top Left",
			"top-right" => "Top Right",
			"bottom-left" => "Bottom Left",
			"bottom-right" => "Bottom Right"
		);
	}
}
