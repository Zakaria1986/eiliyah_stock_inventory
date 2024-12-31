// Admin custom JavaScript for enhanced functionality

document.addEventListener('DOMContentLoaded', function () {
    // Reset Filters Button
    const resetButton = document.getElementById('reset_filters');
    if (resetButton) {
        resetButton.addEventListener('click', function () {
            // Clear the filter parameters in the URL
            const url = new URL(window.location.href);
            url.searchParams.delete('filter_product_category');
            url.searchParams.delete('filter_product_color');
            url.searchParams.delete('filter_product_size');

            // Redirect to the updated URL
            window.location.href = url.toString();
        });
    }
});
