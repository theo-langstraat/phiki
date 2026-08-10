function isDarkColor(rgbString) {
    // rgbString is bv. "rgb(255, 255, 255)" of "#ffffff"
    
    let r, g, b;

    if (rgbString.startsWith('#')) {
        const hex = rgbString.replace('#', '');
        r = parseInt(hex.substring(0, 2), 16);
        g = parseInt(hex.substring(2, 4), 16);
        b = parseInt(hex.substring(4, 6), 16);
    } else {
        const parts = rgbString.match(/\d+/g);
        r = parseInt(parts[0], 10);
        g = parseInt(parts[1], 10);
        b = parseInt(parts[2], 10);
    }

    // Bootstrap luminantie-formule
    const luminance = (0.299 * r + 0.587 * g + 0.114 * b);

    return luminance < 140; // onder 140 = donker
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.code-snippet-wrapper').forEach(wrapper => {
        const pre = wrapper.querySelector('pre');
        const body = wrapper.querySelector('.code-snippet-body');
        const header = wrapper.querySelector('.code-snippet-header');

        if (!pre) return;

        const bg = pre.style.backgroundColor;

        // Bepaal tekstkleur op basis van achtergrond
        const useDarkText = !isDarkColor(bg);
        const textColor = useDarkText ? '#000000' : '#ffffff';

        // Pas kleuren toe
        if (body) {
            body.style.backgroundColor = bg;
            body.style.color = textColor;
        }

        if (header) {
            header.style.backgroundColor = bg;
            header.style.color = textColor;
        }

        // Language badge
        const badge = header?.querySelector('.language-badge');
        if (badge) {
            badge.style.backgroundColor = bg;
            badge.style.color = textColor;
            badge.style.borderColor = textColor + '33';
        }
    });
});

document.addEventListener('click', function (e) {
    const expandBtn = e.target.closest('.expand-btn');
    if (!expandBtn) return;

    const wrapper = expandBtn.closest('.code-snippet-wrapper');
    const body = wrapper.querySelector('.code-snippet-body');

    if (!body) return;

    // Toggle state
    const collapsed = wrapper.classList.toggle('collapsed');

    if (collapsed) {
        // Collapse
        body.style.maxHeight = '100px';
    } else {
        // Expand: eerst auto-height meten
        body.style.maxHeight = body.scrollHeight + 'px';

        // Na animatie max-height resetten zodat resizing werkt
        setTimeout(() => {
            if (!wrapper.classList.contains('collapsed')) {
                body.style.maxHeight = 'none';
            }
        }, 250);
    }
});


