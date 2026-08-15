<?php
declare(strict_types=1);

namespace Theolangstraat\Phiki\Backend\FlexForm;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

final class GenerateFlexForm
{
    public function generate(string $identifier, array $configuration): void
    {
        $xml = $this->buildFlexFormXml($configuration);

        $file = Environment::getVarPath() . '/phiki/flexforms/' . $identifier . '.xml';
        GeneralUtility::mkdir_deep(dirname($file));
        GeneralUtility::writeFile($file, $xml);

        //file_put_contents($file, $xml);
    }

    private function buildFlexFormXml(array $configuration): string
    {
        $extConfig = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('phiki');

        $useDefaultFeaturesGlobally = (int)$extConfig['useDefaultFeaturesGlobally'];
        $useDefaultThemeGlobally    = (int)$extConfig['useDefaultThemeGlobally'];

        $language    = $configuration['language'] ?? 'pascal';
        $theme       = $configuration['theme'] ?? 'github-dark-default';
        $lineNumbers = (int)($configuration['lineNumbers'] ?? 1);
        $showLanguage= (int)($configuration['showLanguage'] ?? 1);
        $copyButton  = (int)($configuration['copyButton'] ?? 1);

        return <<<XML
<?xml version="1.0" encoding="utf-8"?>
<T3DataStructure>
    <sheets type="array">
        <sDEF type="array">
            <ROOT type="array">
                <sheetTitle>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:sheet.general</sheetTitle>
                <type>array</type>
                <el type="array">

                    <settings.language>
						<label>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:language</label>
                        <config>
                            <type>select</type>
                            <renderType>selectSingle</renderType>
                            <itemsProcFunc>Theolangstraat\Phiki\Backend\Items\LanguageItemsProvider->addLanguageItems</itemsProcFunc>
                            <default>{$language}</default>
                        </config>
                    </settings.language>

                    <settings.theme>
						<label>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:theme</label>
                        <displayCond>FIELD:useDefaultThemeGlobally:=:0</displayCond>
                        <config>
                            <type>select</type>
                            <renderType>selectSingle</renderType>
                            <itemsProcFunc>Theolangstraat\Phiki\Backend\Items\ThemeItemsProvider->addThemeItems</itemsProcFunc>
                            <default>{$theme}</default>
                        </config>
                    </settings.theme>

                    <settings.lineNumbers>
						<label>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:lineNumbers</label>
                        <displayCond>FIELD:useDefaultFeaturesGlobally:=:0</displayCond>
                        <config>
                            <type>check</type>
                            <default>{$lineNumbers}</default>
                        </config>
                    </settings.lineNumbers>

                    <settings.showLanguage>
						<label>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:showLanguage</label>
                        <displayCond>FIELD:useDefaultFeaturesGlobally:=:0</displayCond>
                        <config>
                            <type>check</type>
                            <default>{$showLanguage}</default>
                        </config>
                    </settings.showLanguage>

                    <settings.copyButton>
						<label>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:copyButton</label>
                        <displayCond>FIELD:useDefaultFeaturesGlobally:=:0</displayCond>
                        <config>
                            <type>check</type>
                            <default>{$copyButton}</default>
                        </config>
                    </settings.copyButton>

                    <useDefaultFeaturesGlobally>
                        <label>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:useDefaultFeaturesGlobally</label>
                        <config>
                            <type>check</type>
                            <readOnly>TRUE</readOnly>
                            <default>{$useDefaultFeaturesGlobally}</default>
                        </config>
                    </useDefaultFeaturesGlobally>

                    <useDefaultThemeGlobally>
                        <label>LLL:EXT:phiki/Resources/Private/Language/locallang_flexform.xlf:useDefaultThemeGlobally</label>
                        <config>
                            <type>check</type>
                            <readOnly>TRUE</readOnly>
                            <default>{$useDefaultThemeGlobally}</default>
                        </config>
                    </useDefaultThemeGlobally>

                </el>
            </ROOT>
        </sDEF>
    </sheets>
</T3DataStructure>
XML;
}
}
