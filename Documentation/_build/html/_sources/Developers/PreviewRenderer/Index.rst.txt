Backend Preview Renderer
========================

Overview
--------

The ``CodeSnippetPreviewRenderer`` provides the backend preview for the
``phiki_snippet`` content element. TYPO3’s backend does not execute arbitrary
JavaScript inside preview frames, and CSS isolation can vary depending on the
context. To guarantee a consistent, pixel‑perfect preview, the renderer embeds
the highlighted snippet inside an ``iframe`` using ``srcdoc``. This ensures that
the preview looks identical to the frontend output.


Responsibilities
----------------

The preview renderer performs the following tasks:

- Detect whether the current record is a ``tt_content.phiki_snippet`` element.
- Read FlexForm settings such as language, theme, and line number configuration.
- Extract the raw code from ``bodytext``.
- Limit the preview to the first 15 lines for readability.
- Resolve grammar and theme objects using the resolver services.
- Render the snippet using Phiki’s ``codeToHtml()`` method.
- Apply optional features such as line numbers (Phiki “gutter”).
- Wrap the rendered snippet in a styled preview container.
- Embed the preview inside an ``iframe`` to ensure layout isolation.


Rendering Workflow
------------------

1. The raw ``pi_flexform`` XML is converted into an array using
   ``FlexFormTools``.
2. The selected language, theme, and line number settings are extracted.
3. The code snippet is retrieved from the record and truncated to 15 lines.
4. Grammar and theme objects are resolved via:
   - ``PhikiGrammarResolver``
   - ``PhikiThemeResolver``
5. A ``Phiki`` instance renders the snippet to HTML.
6. Line numbers are added when enabled via ``withGutter()``.
7. Custom CSS is injected to style the preview header and snippet container.
8. The final HTML is embedded into an ``iframe`` using ``srcdoc``.


Why an Iframe?
--------------

TYPO3’s backend preview area is influenced by global backend styles and
JavaScript restrictions. Using an ``iframe`` provides:

- **CSS isolation**  
  The snippet’s theme and layout are not affected by backend styles.

- **Pixel‑perfect rendering**  
  The preview matches the frontend output exactly.

- **Safe sandboxing**  
  The ``sandbox="allow-same-origin"`` attribute prevents unwanted script
  execution while still allowing internal styling.

- **Overflow control**  
  Long lines or wide code blocks cannot break the backend layout.


Developer Notes
---------------

- The preview intentionally shows only the first 15 lines to keep the backend
  interface compact.
- UI elements such as language and theme labels are rendered manually in the
  preview header.
- The preview uses minimal CSS to avoid conflicts and ensure readability.
- The renderer is invoked via the ``PageContentPreviewRenderingEvent`` and can
  be extended or replaced using TYPO3’s event system.


Extending the Preview
---------------------

Developers may extend the preview renderer to:

- Add additional metadata (e.g., file name, tab size).
- Provide custom styling or branding.
- Render more or fewer lines depending on project needs.
- Introduce interactive preview elements (within sandbox limitations).

The renderer is intentionally simple, making it easy to adapt for custom
requirements.
