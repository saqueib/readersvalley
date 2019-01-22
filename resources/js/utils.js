/**
 * Find a parent element by class
 *
 */
export function findAncestor(el, sel) {
    while ((el = el.parentElement) && !((el.matches || el.matchesSelector).call(el, sel))) ;
    return el;
}

/**
 * Convert string to slug.
 *
 * src: https://gist.github.com/mathewbyrne/1280286
 */
export function slugify(text) {
    if(!text) return '';

    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
}
