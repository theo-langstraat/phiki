<?php
declare(strict_types = 1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Theolangstraat\Phiki\Backend\Preview;

use TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use Theolangstraat\Phiki\Service\PhikiGrammarResolver;
use Theolangstraat\Phiki\Service\PhikiThemeResolver;

final class CodeSnippetPreviewRenderer
{
    protected ?PhikiGrammarResolver $phikiGrammarResolver = null;

    public function injectPhikiGrammarResolver(PhikiGrammarResolver $resolver): void
    {
        $this->phikiGrammarResolver = $resolver;
    }
     protected ?PhikiThemeResolver $phikiThemeResolver = null;

    public function injectPhikiThemeResolver(PhikiThemeResolver $resolver): void
    {
        $this->phikiThemeResolver = $resolver;
    }

    public function __invoke(PageContentPreviewRenderingEvent $event): void
    {
        $record = $event->getRecord();

        if ($record->getFullType() !== 'tt_content.phiki_snippet') {
            return;
        }

        $raw = $record->getRawRecord();

        $flexXml = $raw->get('pi_flexform') ?? '';
        $flexFormTools = GeneralUtility::makeInstance(FlexFormTools::class);
        $flex = $flexFormTools->convertFlexFormContentToArray($flexXml);

        // Taal uit FlexForm
        $language = $flex['settings']['language'] ?? 'php';
        $theme = $flex['settings']['theme'] ?? 'GithubLightDefault';
        $lineNumbers = $flex['settings']['lineNumbers'] ?? '0';
        
        $snippet = $record->get('bodytext') ?? '';

        // Code uit bodytext
        $code = $raw->get('bodytext');

        // Eerste 15 regels tonen
        $lines = explode("\n", $code);
        $previewLines = array_slice($lines, 0, 16);
        $previewString = implode("\n", $previewLines);

        $grammar = $this->phikiGrammarResolver->resolve($language);
        $themeObj = $this->phikiThemeResolver->resolve($theme);
 
        $phiki = new \Phiki\Phiki();
        $snippet = $phiki->codeToHtml(
            $previewString,
            $grammar,
            $themeObj
        );
        // Line numbers → Phiki noemt dit "gutter"
        if ($lineNumbers) {
            $snippet = $snippet->withGutter();
        }

        $snippet = $snippet->toString();

        $css = <<<HTML
        <style>
            span.line-number {
                padding-right: 10px;
            }
            .snippet-preview-language, .snippet-preview-theme {
                display: inline-block; 
                padding: 2px 6px; 
                font-size: 11px; 
                font-weight: 600; 
                border-radius: 4px;
                background: #e0e0e0;
                color: #333; 
                border: 1px solid #c0c0c0; 
                margin-right: 10px;}
            .snippet-preview-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 6px;
                font-size: 12px;
                color: #555;
            }
            .phiki {
                margin: 0px !important;
                padding:10px !important;
                border: 1px solid #d0d0d0;
                border-radius: 4px;
                font-family: monospace;
                }
            /* ⭐ Belangrijk: voorkomt overflow van code */
            .snippet-preview-body {
                overflow: hidden;        /* ⭐ knipt alles buiten de div */
                max-width: 100%;         /* extra zekerheid */
            }
        </style>
        HTML;  
        
        $content = <<<HTML
            <div class="snippet-preview">
                <div class="snippet-preview-header"> 
                    <span class="snippet-preview-language">$language</span>
                    <span class="snippet-preview-theme">$theme</span>
                </div>
                <div class="snippet-preview-body">
                $snippet
                </div>
            </div>
        HTML;

        $event->setPreviewContent(
            '<iframe class="phiki-frame" sandbox="allow-same-origin" style="width:100%;border:0;height: 350px" srcdoc="' .
            htmlspecialchars($css . $content, ENT_QUOTES | ENT_HTML5) .
            '"></iframe>'
        );
    }
}
