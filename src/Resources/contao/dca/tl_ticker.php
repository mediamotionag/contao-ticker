<?php

/**
 * @copyright  Softleister 2008-2019
 * @author     Softleister <info@softleister.de>
 * @package    contao-ticker
 * @license    MIT
 * @see           https://github.com/do-while/contao-ticker
 *
 */

use \Contao\DC_Table;
use \Contao\Backend;
use \Contao\Input;
use \Contao\System;
use \Contao\StringUtil;
use \Contao\CoreBundle\Security\ContaoCorePermissions;

/**
 * Table tl_ticker
 */
$GLOBALS['TL_DCA']['tl_ticker'] = array
(

    // Config
    'config' => array
    (
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_ticker_category',
        'enableVersioning' => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode' => 4,
            'filter' => true,
            'fields' => array('sorting'),
            'panelLayout' => 'filter;search,limit',
            'headerFields' => array('title', 'typ', 'tstamp'),
            'child_record_callback' => array('tl_ticker', 'listTexte'),
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_ticker']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.gif'
            ),
            'copy' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_ticker']['copy'],
                'href' => 'act=paste&mode=copy',
                'icon' => 'copy.gif'
            ),
            'cut' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_ticker']['cut'],
                'href' => 'act=paste&mode=cut',
                'icon' => 'cut.gif'
            ),
            'delete' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_ticker']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\')) return false; Backend.getScrollOffset();"'
            ),
            'toggle' => array
            (
                'href' => 'act=toggle&amp;field=published',
                'icon' => 'visible.svg',
                'button_callback' => array('tl_ticker', 'toggleIcon')
            ),
            'show'

//            'show',
//            'toggle' => array
//            (
//                'label'               => &$GLOBALS['TL_LANG']['tl_ticker']['toggle'],
//                'icon'                => 'visible.gif',
//                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
//            ),
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default' => '{ticker_legend},tickertext,color;'
            . '{link_legend:hide},url,target,linktitle;'
            . '{publish_legend},published,start,stop'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tickertext' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_ticker']['tickertext'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => true, 'tl_class' => 'long'),
            'sql' => "text NULL"
        ),
        'color' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_ticker']['color'],
            'default' => 'msg-white',
            'exclude' => true,
            'inputType' => 'select',
            'options' => array
            (
                'msg-white' => 'White',
                'msg-black' => 'Black',
                'msg-red' => 'Red',
                'msg-pink' => 'Pink',
                'msg-purple' => 'Purple',
                'msg-deeppurple' => 'Deep Purple',
                'msg-indigo' => 'Indigo',
                'msg-blue' => 'Blue',
                'msg-lightblue' => 'Light Blue',
                'msg-cyan' => 'Cyan',
                'msg-teal' => 'Teal',
                'msg-green' => 'Green',
                'msg-lightgreen' => 'Light Green',
                'msg-lime' => 'Lime',
                'msg-yellow' => 'Yellow',
                'msg-amber' => 'Amber',
                'msg-orange' => 'Orange',
                'msg-deeporange' => 'Deep Orange',
                'msg-brown' => 'Brown',
                'msg-grey' => 'Grey',
                'msg-bluegrey' => 'Blue Grey'
            ),
            'eval' => array('chosen' => true, 'tl_class' => 'w50'),
            'reference' => &$GLOBALS['TL_LANG']['tl_ticker_category'],
            'sql' => "varchar(32) NOT NULL default ''"
        ),
        'url' => array
        (
            'label' => &$GLOBALS['TL_LANG']['MSC']['url'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('rgxp' => 'url', 'decodeEntities' => true, 'dcaPicker' => true, 'tl_class' => 'w50 wizard'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'target' => array
        (
            'label' => &$GLOBALS['TL_LANG']['MSC']['target'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => array('tl_class' => 'w50 m12'),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'linktitle' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_ticker']['linktitle'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'published' => array
        (
            'toggle' => true,
            'label' => &$GLOBALS['TL_LANG']['tl_ticker']['published'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => array('doNotCopy' => true),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'start' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_ticker']['start'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
            'sql' => "varchar(10) NOT NULL default ''"
        ),
        'stop' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_ticker']['stop'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
            'sql' => "varchar(10) NOT NULL default ''"
        )
    )
);

/**
 * Class tl_ticker
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Softleister 2008-2014
 * @author     Softleister <info@softleister.de>
 * @package    Ticker
 */
class tl_ticker extends Backend
{
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        $security = System::getContainer()->get('security.helper');

        if (!$security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELD_OF_TABLE, 'tl_ticker::published')) {
            return '';
        }

        $href .= '&amp;id=' . $row['id'];

        if (!$row['published'])
        {
            $icon = 'invisible.svg';
        }


        return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.getScrollOffset();return AjaxRequest.toggleField(this,true)">' . \Contao\Image::getHtml($icon, $label, 'data-icon="visible.svg" data-icon-disabled="invisible.svg" data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
    }
    //-----------------------------------------------------------------
    //  Callback zum Anzeigen der Tickereinträge im Backend
    //
    //  $arrRow - aktueller Datensatz
    //-----------------------------------------------------------------
    public function listTexte($arrRow)
    {
        $key = $arrRow['published'] ? 'published' : 'unpublished';
        $date = date($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['tstamp']);

        return '
<div class="cte_type ' . $key . '">' . $date . '</div>
<div class="limit_height block">' . $arrRow['tickertext'] . '</div>' . "\n";
    }

    //-----------------------------------------------------------------
    // Return the link picker wizard
    // @param object
    // @return string
    //-----------------------------------------------------------------
    public function pagePicker(DC_Table $dc)
    {
        return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . \Contao\StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'' . \Contao\StringUtil::specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_' . $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . \Contao\Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
    }

}
