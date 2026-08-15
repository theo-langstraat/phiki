<?php
declare(strict_types=1);

namespace Theolangstraat\Phiki\EventListeners;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureParsedEvent;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Theolangstraat\Phiki\Backend\FlexForm\GenerateFlexForm;

final class FlexFormDefaultsListener
{
    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration,
    ) {}

    public function __invoke(BeforeFlexFormDataStructureParsedEvent $event): void
    {
        $identifier = $event->getIdentifier();
        $haystack   = (string)($identifier['dataStructureKey'] ?? '');

        if (!str_contains($haystack, 'phiki_snippet')) {
            return;
        }

        $configuration = $this->extensionConfiguration->get('phiki');

        $fileIdentifier = 'phiki_snippet';
        $flexFormFile   = Environment::getVarPath() . '/phiki/flexforms/' . $fileIdentifier . '.xml';

        $generator = GeneralUtility::makeInstance(GenerateFlexForm::class);
        $generator->generate($fileIdentifier, $configuration);

        $event->setDataStructure('FILE:' . $flexFormFile);
    }
}
