<?php

/**
 * Comparison Slider Widget for Contao Open Source CMS
 *
 * @copyright Postyou 2016
 * @author Mario Gienapp
 * @link https://postyou.de
 * @license http://creativecommons.org/licenses/by-sa/4.0/ CC BY-SA 4.0
 */

namespace ComparisonSlider;

use Contao\System;
use Contao\ContentElement;
use Contao\BackendTemplate;

class ContentComparisonSlider extends ContentElement {
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_comparison_slider';

    public function __construct($objModule, $strColumn = 'main') {
        $GLOBALS['TL_CSS']['comparisonSlider'] = 'system/modules/contao-comparison-slider/assets/css/comparison_slider.css';
        $GLOBALS['TL_JAVASCRIPT']['comparisonSlider'] = 'system/modules/contao-comparison-slider/assets/js/comparison_slider.js';
        parent::__construct($objModule, $strColumn);
    }

    public function generate() {

        //Backend Ausgabe
        if (TL_MODE == 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . mb_strtoupper("Comparison Slider") . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    protected function compile() {
        $this->Template->classNames .= "ce_comparison-slider";

        if (!empty($this->Template->cssID[1])) {
            $this->Template->classNames .= " " . $this->Template->cssID[1];
        }

        if (isset($this->pictureLeftSRC) && isset($this->pictureRightSRC)) {
            $figure = System::getContainer()
                ->get('contao.image.studio')
                ->createFigureBuilder()
                ->from($this->pictureLeftSRC)
                ->setOptions(["caption" => $this->textLeft, "floatClass" => " " . $this->textPositionClass($this->textLeftPosition)])
                ->setSize($this->size)
                ->buildIfResourceExists();

            $figure2 = System::getContainer()
                ->get('contao.image.studio')
                ->createFigureBuilder()
                ->from($this->pictureRightSRC)
                ->setOptions(["caption" => $this->textRight, "floatClass" => " " . $this->textPositionClass($this->textRightPosition)])
                ->setSize($this->size)
                ->buildIfResourceExists();


            $this->Template->picture_one = $figure->getLegacyTemplateData();
            $this->Template->picture_two = $figure2->getLegacyTemplateData();
        }
    }

    private function textPositionClass($textPosition) {
        return match ($textPosition) {
            'top-left' => "comparison-slider-top-left",
            'top-right' => "comparison-slider-top-right",
            'bottom-left' => "comparison-slider-bottom-left",
            'bottom-right' => "comparison-slider-bottom-right",
            default => ""
        };
    }
}
