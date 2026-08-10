Service Configuration
=====================

Overview
--------

The extension uses TYPO3’s Symfony-based service container for dependency
injection. All classes under ``Classes/`` are automatically registered as
services, except those explicitly excluded. This allows controllers, preview
renderers, and backend item providers to receive their dependencies cleanly
and consistently.


Autowiring and Autoconfiguration
--------------------------------

The service configuration enables TYPO3’s autowiring and autoconfiguration:

.. code-block:: yaml

   _defaults:
     autowire: true
     autoconfigure: true
     public: false

This means:

- Dependencies are injected automatically based on type hints.
- Common TYPO3 service tags (e.g. event listeners) are applied automatically.
- Services remain private unless explicitly marked otherwise.

This keeps the configuration minimal while still allowing fine‑grained control
when needed.


Service Namespace Registration
------------------------------

The following block registers all classes in the extension as services:

.. code-block:: yaml

   Theolangstraat\Phiki\:
     resource: '../Classes/*'
     exclude: '../Classes/Phiki/'

The ``exclude`` directive prevents the internal Phiki library classes from being
treated as TYPO3 services. Only the extension’s own classes are autowired.


Resolver Services
-----------------

Two resolver services are defined explicitly:

.. code-block:: yaml

   Theolangstraat\Phiki\Service\PhikiGrammarResolver: ~
   Theolangstraat\Phiki\Service\PhikiThemeResolver: ~

These services map FlexForm selections (language and theme) to the correct
Phiki grammar and theme objects. They are injected into both the frontend
controller and the backend preview renderer.

Developers may extend or override these resolvers to introduce:

- Custom grammars
- Additional themes
- Project‑specific mapping logic


Backend Item Providers
----------------------

The extension registers two item providers:

.. code-block:: yaml

   Theolangstraat\Phiki\Backend\Items\ThemeItemsProvider: ~
   Theolangstraat\Phiki\Backend\Items\LanguageItemsProvider: ~

These providers populate FlexForm dropdowns with the full list of supported
languages and themes. They ensure that editors always see up‑to‑date options
without hardcoding values in the FlexForm XML.


Backend Preview Renderer
------------------------

The backend preview renderer is registered as an event listener:

.. code-block:: yaml

   Theolangstraat\Phiki\Backend\Preview\CodeSnippetPreviewRenderer:
     tags:
       - name: event.listener
         identifier: 'phiki-backend-preview'
         event: TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent

This connects the renderer to TYPO3’s backend preview system. Whenever a
``PageContentPreviewRenderingEvent`` occurs, TYPO3 invokes the renderer, which
then checks whether the record is a ``phiki_snippet`` element and generates the
iframe-based preview.

Developers can override this listener or add additional listeners if they want
to customize backend rendering behavior.


Extending or Overriding Services
--------------------------------

TYPO3 allows developers to override any service using ``services.yaml`` in their
own sitepackage or extension. Common extension points include:

- Replacing the grammar resolver with a custom implementation.
- Adding new theme providers.
- Overriding the preview renderer for custom backend styling.
- Injecting additional services into the controller for advanced features.

Because autowiring is enabled, custom services only need correct type hints to
be injected automatically.


Summary
-------

The service configuration ensures that the Phiki extension integrates cleanly
with TYPO3’s dependency injection system. Resolver services, item providers,
and the preview renderer are all registered in a predictable and extensible
way, making it straightforward for developers to customize or extend the
extension’s behavior.
