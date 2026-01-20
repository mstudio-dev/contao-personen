<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

// Add person modules to modules
$GLOBALS['TL_LANG']['FMD']['person'] = 'Personen';
$GLOBALS['TL_LANG']['FMD']['person_list'] = ['Personenliste', 'Zeigt eine Liste von Personen an'];
$GLOBALS['TL_LANG']['FMD']['person_reader'] = ['Personen-Reader', 'Zeigt die Details einer Person an'];

// Add person modules to the module list
$GLOBALS['FE_MOD']['person'] = [
    'person_list' => 'Mstudio\ContaoPersonenBundle\Controller\FrontendModule\PersonListController',
    'person_reader' => 'Mstudio\ContaoPersonenBundle\Controller\FrontendModule\PersonReaderController',
];

// Add fields to tl_module
$GLOBALS['TL_DCA']['tl_module']['fields']['person_groups'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['person_groups'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'foreignKey' => 'tl_member_group.name',
    'eval' => ['multiple' => true, 'tl_class' => 'w50 clr'],
    'sql' => "blob NULL"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['person_template'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['person_template'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => function() {
        return \Contao\Controller::getTemplateGroup('mod_person_list');
    },
    'eval' => ['includeBlankOption' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['person_reader_template'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['person_reader_template'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => function() {
        return \Contao\Controller::getTemplateGroup('mod_person_reader');
    },
    'eval' => ['includeBlankOption' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['person_sortBy'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['person_sortBy'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['lastname_asc', 'lastname_desc', 'firstname_asc', 'firstname_desc', 'dateAdded_asc', 'dateAdded_desc'],
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['person_sortBy_options'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(32) NOT NULL default 'lastname_asc'"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['person_perPage'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['person_perPage'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'natural', 'tl_class' => 'w50'],
    'sql' => "smallint(5) unsigned NOT NULL default 0"
];

// Add palettes for person modules
$GLOBALS['TL_DCA']['tl_module']['palettes']['person_list'] = 
    '{title_legend},name,headline,type;' .
    '{person_legend},person_groups,person_sortBy,person_perPage;' .
    '{template_legend:hide},person_template;' .
    '{protected_legend:hide},protected;' .
    '{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['person_reader'] = 
    '{title_legend},name,headline,type;' .
    '{template_legend:hide},person_reader_template;' .
    '{protected_legend:hide},protected;' .
    '{expert_legend:hide},guests,cssID';
