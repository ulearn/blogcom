<?php
/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.

 *
 * Uber simple/fast template for TubePress. Idea from here: http://seanhess.net/posts/simple_templating_system_in_php
 * Sure, maybe your templating system of choice looks prettier but I'll bet it's not faster :)
 */
?>
<form accept-charset="utf-8">
	<fieldset class="tubepress_search">

		<input type="text" id="tubepress_search_<?php echo ${tubepress_api_const_template_Variable::GALLERY_ID}; ?>"
               name="tubepress_search_<?php echo ${tubepress_api_const_template_Variable::GALLERY_ID}; ?>" class="tubepress_text_input" />

		<button class="tubepress_button" title="Submit Search"><?php echo htmlspecialchars(${tubepress_api_const_template_Variable::SEARCH_BUTTON}); ?></button>

	</fieldset>
</form>
<script type="text/javascript">
    (function () {
        var textBox = jQuery('#tubepress_search_<?php echo ${tubepress_api_const_template_Variable::GALLERY_ID}; ?>'),
            clickHandler = function (event) {

                window.tubePressBeacon.push(['publish',

                    'tubepress.search.ajax',
                    [
                        <?php echo ${tubepress_plugins_procore_api_const_template_Variable::NVP_AS_JSON}; ?>,
                        textBox.val(),
                        '<?php echo ${tubepress_api_const_template_Variable::GALLERY_ID}; ?>'
                    ]
                ]);

                event.preventDefault();
                return false;
            };

        textBox.siblings('button').click(clickHandler);
        window.tubePressDomInjector.push(['loadAjaxSearchJs']);
    }());
</script>