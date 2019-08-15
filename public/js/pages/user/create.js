var FormLayouts = function() {

    //
    // Setup module components
    //

    // filePicker
    var _componentFilePicker = function() {
        $('#lfm').filemanager('file');
    };

    // Uniform
    var _componentUniform = function() {
        if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-pink-400'
        });
        $('.form-control-uniform').uniform();
        $('.form-check-input-styled').uniform();
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentUniform();
            _componentFilePicker();
        }
    }
}();

// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormLayouts.init();
});
