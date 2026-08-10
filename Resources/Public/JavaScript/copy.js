document.addEventListener('click', function (e) {
    const button = e.target.closest('.copy-btn');
    if (!button) return;

    const wrapper = button.closest('.code-snippet-wrapper');
    const targetId = button.getAttribute('data-target');
    const codeElement = document.querySelector('#' + targetId + ' pre code');

    if (!codeElement || !wrapper) return;

    // Clone zodat line-numbers verwijderd kunnen worden
    const clone = codeElement.cloneNode(true);
    clone.querySelectorAll('.line-number').forEach(el => el.remove());
    const text = clone.innerText;

    navigator.clipboard.writeText(text).then(() => {

        // Tooltip element maken (in wrapper!)
        let tooltip = wrapper.querySelector('.copy-tooltip');
        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.className = 'copy-tooltip';
            tooltip.textContent = 'Gekopieerd!';
            wrapper.appendChild(tooltip);
        }

        // Positie bepalen via offsetTop/offsetLeft (stabiel!)
        const btnX = button.offsetLeft + button.offsetWidth / 2;
        const btnY = button.offsetTop;

        tooltip.style.left = btnX + 'px';
        tooltip.style.top = (btnY - 8) + 'px';
        tooltip.style.transform = 'translateX(-50%) translateY(-100%)';

        tooltip.classList.add('show');
        setTimeout(() => tooltip.classList.remove('show'), 1200);
    });
});
