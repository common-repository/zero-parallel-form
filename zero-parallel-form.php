<?php
/*
Plugin Name: Zero Parallel Form
Description: Loan form
Version: 1.0
Author: Alexey O. Sidora
Author URI: https://mekh.ppy0.com/
*/

// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }


define('ZERO_PARALLEL_FORM_DIR', plugin_dir_path(__FILE__));
define('ZERO_PARALLEL_FORM_URL', plugin_dir_url(__FILE__));


function zero_parallel_form_shortcode ($atts, $content = null){
    $a = shortcode_atts( array(
        'product' => '1',
        'mobile'  => '1',
        'user'    => '2',
        'tpl'     => 'simple',
        'extra'   => 'on'
    ), $atts );

    return "<script type='text/javascript'> var m = " . $a['mobile'] . "; var pp = " . $a['product'] . "; var zpFormParams = { mobileDevices: " . ($a['mobile'] ? "true" : "false") . ", parseDefaultValue: true, visitor: { referrer: (document.cookie.match(\"rfrrr[\r\n\t ]*=[\r\n\t ]*(.*?)(;$)\") [,''])[1], subaccount: (document.cookie.match(\"src[\r\n\t ]*=[\r\n\t ]*(.*?)(;$)\") [,''])[1], keyword: (document.cookie.match(\"kwrd[\r\n\t ]*=[\r\n\t ]*(.*?)(;$)\") [,''])[1], clickid: (document.cookie.match(\"clcid[\r\n\t ]*=[\r\n\t ]*(.*?)(;$)\") [,''])[1] },zpFormVarsSpec :[] };</script> <script type='text/javascript' src='https://lendyou.com/applicationforms/run.php?p=" . $a['product'] . "&u=" . $a['user'] . "&t=" . $a['tpl'] . "&m=0&extra_content=" . $a['extra'] . "'></script> ";
}

add_shortcode('zp_form', 'zero_parallel_form_shortcode');

function enqueue_plugin_scripts($plugin_array)
{
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["zero_parallel_form_plugin"] =  ZERO_PARALLEL_FORM_URL . "zero-parallel-form.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");

function register_buttons_editor($buttons)
{
    array_push($buttons, "zero_parallel_form");
    return $buttons;
}

add_filter("mce_buttons", "register_buttons_editor");

function zero_parallel_form_button_script() 
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">

                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton(
                    "zpform_shortcode",
                    "ZpForm",
                    callback
                );

                function callback()
                {
                    var selected_text = getSel();
                    QTags.insertContent("[zp_form extra='on' product='1' mobile='1' user='2' tpl='simple']");
                }
            </script>
        <?php
    }
}

add_action("admin_print_footer_scripts", "zero_parallel_form_button_script");