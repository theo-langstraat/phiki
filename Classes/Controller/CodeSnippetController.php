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

namespace Theolangstraat\Phiki\Controller;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Theolangstraat\Phiki\Service\PhikiGrammarResolver;
use Theolangstraat\Phiki\Service\PhikiThemeResolver;
use Phiki\Phiki;

final class CodeSnippetController extends ActionController
{

    //protected PrismAssetService $prismAssetService;
    public function __construct(
        //private readonly PrismAssetService $prismAssetService,
        private readonly PhikiGrammarResolver $phikiGrammarResolver
    ) {}

    protected ?PhikiThemeResolver $phikiThemeResolver = null;

    public function injectPhikiThemeResolver(PhikiThemeResolver $resolver): void
    {
        $this->phikiThemeResolver = $resolver;
    }

    public function showAction(): ResponseInterface
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

        $pageRenderer->addJsFile('EXT:phiki/Resources/Public/JavaScript/copy.js');
        $pageRenderer->addJsFile('EXT:phiki/Resources/Public/JavaScript/snippet-ui.js');
        $pageRenderer->addCssFile('EXT:phiki/Resources/Public/Css/codehighlight.css');
        
        $flex = $this->settings ?? [];

        $theme = $flex['theme'] ?? 'default';
        $language = $flex['language'] ?? 'php';
        $lineNumbers = !empty($flex['lineNumbers']);
        $copyButton = !empty($flex['copyButton']);
        $showLanguage = !empty($flex['showLanguage']);
        $normalizeWhitespace = !empty($flex['normalizeWhitespace']);
        $tabSize = isset($flex['tabSize']) ? (int)$flex['tabSize'] : 0;

        $data = $this->request->getAttribute('currentContentObject')->data ?? [];
        $snippet = $data['bodytext'] ?? '';

        $phiki = new Phiki();

        // Basis highlight
        $grammar = $this->phikiGrammarResolver->resolve($language);
        $themeObj = $this->phikiThemeResolver->resolve($theme);
        
        $snippet = $phiki->codeToHtml($snippet, $grammar, $themeObj);

        // Line numbers → Phiki noemt dit "gutter"
        if ($lineNumbers) {
            $snippet = $snippet->withGutter();
        }

        // Startregel
        $snippet = $snippet->startingLine(1);

        // Copy button → Phiki heeft geen copy‑button, dus dit doe je in Fluid
        // Show language → idem, doe je in Fluid

        // Uiteindelijk HTML genereren
        $snippet = $snippet->toString();

        $this->view->assignMultiple([
            'snippet' => $snippet,
            'language'=> $language,
            'uid'     => (int)($data['uid'] ?? 0),
        ]);

        return $this->htmlResponse();

    }
}
