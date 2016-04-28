<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: PPSMB-Enugu Website
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/12/2016
 * Time:    12:06 AM
 **/

$script_url = home_url('/Assets/js/tinymce/tinymce.min.js', false);
$styles_url = home_url('/Assets/css/html-editor.css', false);

$extra_footers = <<<EXTAR_FOOTERS
<script src="$script_url"></script>
    <script>
        tinymce.init({
        selector: 'textarea.html-editor',
        browser_spellcheck: true,
        menubar: false,
        toolbar: 'undo redo | styleselect | bold italic underline | bullist numlist outdent indent table | link image media | spellchecker code preview print',
        plugins : 'advlist autolink link image lists charmap media print preview spellchecker table code spellchecker',
        content_css: '$styles_url'
        });
    </script>
    
EXTAR_FOOTERS;
