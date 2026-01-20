<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;


// Add fields

$GLOBALS['TL_DCA']['tl_member']['fields']['qualification'] = [
'label' => ['Qualifikation', 'Nennen Sie die Qualifikation(en) der Person'],
'inputType' => 'text',
'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_member']['fields']['position'] = [
'label' => ['Position', 'Position oder Funktion der Person'],
'inputType' => 'text',
'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_member']['fields']['academicTitle'] = [
'label' => ['Akademischer Titel', 'Akademischer Titel der Person'],
'inputType' => 'text',
'eval' => ['maxlength' => 64, 'tl_class' => 'w25'],
'sql' => "varchar(64) NOT NULL default ''"
];


$GLOBALS['TL_DCA']['tl_member']['fields']['profileImage'] = [
'label' => ['Profilbild','Profilbild des Mitglieds'],
'inputType' => 'fileTree',
'eval' => [
'filesOnly' => true,
'extensions' => 'jpg,jpeg,png,webp',
'fieldType' => 'radio',
'tl_class' => 'clr',
],
'sql' => "binary(16) NULL"
];


$GLOBALS['TL_DCA']['tl_member']['fields']['heroImage'] = [
'label' => ['Hero-Bild','Großes Bild für Profilseite'],
'inputType' => 'fileTree',
'eval' => [
'filesOnly' => true,
'extensions' => 'jpg,jpeg,png,webp',
'fieldType' => 'radio',
'tl_class' => 'clr',
],
'sql' => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_member']['fields']['intro'] = [
'label' => ['Intro','Einleitender Text oder Zitat'],
'inputType' => 'textarea',
'eval' => [
'rte' => 'tinyMCE',
'tl_class' => 'clr long'
],
'sql' => "mediumtext NULL"
];


$GLOBALS['TL_DCA']['tl_member']['fields']['vita'] = [
'label' => ['Vita','Lebenslauf der Person'],
'inputType' => 'textarea',
'eval' => [
'rte' => 'tinyMCE',
'tl_class' => 'clr long'
],
'sql' => "mediumtext NULL"
];

// E-Mail-Adresse im Backend optional machen
$GLOBALS['TL_DCA']['tl_member']['fields']['email']['eval']['mandatory'] = false;


// Add legend and adjust palettes using modern method PaletteManipulator

PaletteManipulator::create()
->addLegend('extra_legend', 'personal_legend', PaletteManipulator::POSITION_AFTER)
->addField(['academicTitle'], 'personal_legend', PaletteManipulator::POSITION_PREPEND)
->addField(['qualification', 'position'], 'gender', PaletteManipulator::POSITION_AFTER)
->addField(['profileImage', 'heroImage', 'intro'], 'extra_legend', PaletteManipulator::POSITION_APPEND)
->addField('vita', 'intro', PaletteManipulator::POSITION_AFTER) // <--- HIER KORRIGIERT: 'vita' nach 'intro' verschoben
->applyToPalette('default', 'tl_member');

// Adjust existing core fields
$GLOBALS['TL_DCA']['tl_member']['fields']['firstname']['eval']['tl_class'] = 'w25';
$GLOBALS['TL_DCA']['tl_member']['fields']['lastname']['eval']['tl_class'] = 'w25';
$GLOBALS['TL_DCA']['tl_member']['fields']['language']['eval']['tl_class'] = 'w25';

// Members list view: show qualification, position and academic title
$GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'][] = 'qualification';
$GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'][] = 'position';
$GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'][] = 'academicTitle';

// Members list view: unset country, language and login fields
unset($GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'][array_search('username', $GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'])]);
unset($GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'][array_search('dateAdded', $GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'])]); 

