.. include:: /Includes.rst.txt

CodeSnippetController
======================================

The ``CodeSnippetController`` is responsible for rendering highlighted code
snippets in both the TYPO3 frontend and backend. It acts as a lightweight
integration layer between TYPO3 Extbase, the Phiki highlighter, and the
extension’s grammar and theme resolver services.

The controller reads configuration from the content element’s FlexForm,
resolves the correct grammar and theme, processes the snippet through Phiki,
and finally assigns the rendered HTML to the Fluid template.


Controller Responsibilities
---------------------------

- Load required JavaScript and CSS assets using ``PageRenderer``.
- Read FlexForm settings such as language, theme, line numbers, and UI options.
- Retrieve the raw code snippet from the content element (``bodytext``).
- Resolve grammar and theme objects via dedicated resolver services.
- Convert the snippet to HTML using Phiki’s ``codeToHtml()`` method.
- Apply optional features such as line numbers (Phiki “gutter”).
- Provide the final HTML output to the Fluid template.


Grammar and Theme Resolution
----------------------------

Two services are used to resolve the correct syntax grammar and theme:

- ``PhikiGrammarResolver``  
  Maps the selected programming language to the appropriate Phiki grammar.

- ``PhikiThemeResolver``  
  Maps the selected theme to a Phiki theme object.

This separation keeps the controller small and makes it easy for developers to
extend or override grammar or theme resolution without modifying the controller
itself.


Rendering Workflow
------------------

The rendering process follows these steps:

1. FlexForm settings are read from ``$this->settings``.
2. The raw snippet is retrieved from the current content object.
3. A new ``Phiki`` instance is created.
4. Grammar and theme objects are resolved.
5. The snippet is converted to HTML using ``codeToHtml()``.
6. Optional features are applied:
   - Line numbers → ``withGutter()``
   - Starting line → ``startingLine(1)``
7. The final HTML is generated via ``toString()``.
8. Variables are assigned to the Fluid template for rendering.


Notes for Developers
--------------------

- Phiki does not provide UI elements such as a copy button or language label.
  These are implemented in Fluid templates using custom JavaScript and CSS.
- The controller avoids JavaScript-based syntax highlighting entirely to ensure
  compatibility with the TYPO3 backend, where JavaScript execution is restricted.
- Developers may override the controller or extend the resolver services to add
  custom grammars, themes, or additional rendering logic.


Extending the Controller
------------------------

Developers can extend or replace the controller using standard TYPO3
Extbase mechanisms. Common extension points include:

- Adding custom snippet preprocessing.
- Introducing additional FlexForm options.
- Overriding grammar or theme resolution logic.
- Injecting additional services for advanced rendering features.

``CodeSnippetController`` is intentionally minimal, making it easy to adapt
for project-specific needs.
