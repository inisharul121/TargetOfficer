import Alpine from 'alpinejs';
import katex from 'katex';
import confetti from 'canvas-confetti';
import 'katex/dist/katex.min.css';

window.Alpine = Alpine;
window.katex = katex;
window.confetti = confetti;

// Helper to render LaTeX math formulas in DOM elements
window.renderMathInElement = function(elem) {
    if (!elem) return;
    const text = elem.innerHTML;
    // Regex for $...$ inline and $$...$$ display math
    const displayRegex = /\$\$([\s\S]+?)\$\$/g;
    const inlineRegex = /\$([^\$]+?)\$/g;

    let processed = text.replace(displayRegex, function(match, math) {
        try {
            return katex.renderToString(math, { displayMode: true, throwOnError: false });
        } catch (e) {
            return match;
        }
    });

    processed = processed.replace(inlineRegex, function(match, math) {
        try {
            return katex.renderToString(math, { displayMode: false, throwOnError: false });
        } catch (e) {
            return match;
        }
    });

    elem.innerHTML = processed;
};

// Global helper for triggers
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.math-tex').forEach(el => {
        window.renderMathInElement(el);
    });
});

Alpine.start();
