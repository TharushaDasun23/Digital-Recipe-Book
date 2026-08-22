<?php
/**
 * Shared helper functions used across the VeganFood app.
 */

/**
 * Resolve a recipe's stored image_url into a path/URL that can be used
 * directly in an <img src="..."> attribute.
 *
 * - Leaves full external URLs (https://...) untouched.
 * - Normalises any legacy "assets/..." prefixed paths (from an older
 *   folder layout) down to the current images/ folder.
 * - Falls back to prefixing bare filenames with "images/".
 */
function resolve_recipe_image(string $imgSrc): string {
    if ($imgSrc === '') {
        return '';
    }

    if (strpos($imgSrc, 'assets/') === 0) {
        $imgSrc = str_replace('assets/', '', $imgSrc);
    }

    if (!filter_var($imgSrc, FILTER_VALIDATE_URL)) {
        if (strpos($imgSrc, 'uploads/') === 0) {
            $imgSrc = 'images/' . $imgSrc;
        } elseif (strpos($imgSrc, 'images/') !== 0) {
            $imgSrc = 'images/' . $imgSrc;
        }
    }

    return $imgSrc;
}
