<?php
declare(strict_types = 1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Theolangstraat\Phiki\Controller\CodeSnippetController;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
    'Phiki',
    // arbitrary, but unique plugin name (not visible in the backend)
    'Snippet',
    // all actions
    [
        CodeSnippetController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);
