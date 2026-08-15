<?php
declare(strict_types = 1);

namespace Theolangstraat\Phiki\Controller;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Theolangstraat\Phiki\Service\PhikiGrammarResolver;
use Theolangstraat\Phiki\Service\PhikiThemeResolver;
use Phiki\Phiki;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

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

        // FlexForm settings
        $settings = $this->settings;

        // Voeg global settings toe die naar Fluid worden gestuurd
        $extConfig = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('phiki');
        $settings['useDefaultFeaturesGlobally'] = (bool)$extConfig['useDefaultFeaturesGlobally'];
        $settings['useDefaultThemeGlobally'] = (bool)$extConfig['useDefaultThemeGlobally'];
        $settings['defLanguage'] = $extConfig['language'];
        $settings['defTheme'] = $extConfig['theme'];
        $settings['defLineNumbers'] = (bool)$extConfig['lineNumbers'];
        $settings['defShowLanguage'] = (bool)$extConfig['showLanguage'];
        $settings['defCopyButton'] = (bool)$extConfig['copyButton'];

        // Maak beschikbaar in de template
        $this->view->assign('settings', $settings);

        if ($extConfig['useDefaultFeaturesGlobally'] === '1') {

            $lineNumbers = (bool)$extConfig['lineNumbers']; 
            $copyButton = (bool)$extConfig['copyButton'];
            $showLanguage = (bool)$extConfig['showLanguage'];

        } else {

            $lineNumbers = (bool)($flex['lineNumbers']);
            $copyButton = (bool)($flex['copyButton']);
            $showLanguage = (bool)($flex['showLanguage']);
    
        } 

        if ($extConfig['useDefaultThemeGlobally'] === '1') {

            $theme = $extConfig['theme'];

        } else {

            $theme = $flex['theme'] ?? 'default';
    
        } 

        $language = $flex['language'];

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

