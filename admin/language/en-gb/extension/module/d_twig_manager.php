<?php
/*
 *  location: admin/language
 */

//heading
$_['heading_title']             = '<span style="color:#449DD0; font-weight:bold">Twig Manager</span><span style="font-size:12px; color:#999"> by <a href="http://www.opencart.com/index.php?route=extension/extension&filter_username=Dreamvention" style="font-size:1em; color:#999" target="_blank">Dreamvention</a></span>';
$_['heading_title_main']        = 'Twig Manager';
$_['text_edit']                 = 'Edit Twig Manager settings';
$_['text_module']               = 'Modules';

$_['text_success']              = 'Success: You have modified themes!';
$_['text_edit']                 = 'Edit twig files';
$_['text_store']                = 'Choose your store';
$_['text_template']             = 'Choose a template';
$_['text_default']              = 'Default';
$_['text_history']              = 'Theme History';
$_['text_twig']                 = 'The theme editor uses the template language Twig. You can read about <a href="http://twig.sensiolabs.org/documentation" target="_blank" class="alert-link">Twig syntax here</a>.';
$_['text_yes']                  = 'Yes';
$_['text_no']                   = 'No';
$_['text_begin']                = 'Select a theme file from the left side to begin editing.';

// Column
$_['column_store']              = 'Store';
$_['column_route']              = 'Route';
$_['column_theme']              = 'Theme';
$_['column_date_added']         = 'Date Added';
$_['column_action']             = 'Action';


//field
$_['entry_compatibility']       = 'Activate Twig support';
$_['help_compatibility']        = '<h4>Twig files</h4><p>When Activated, opencart twig library gets extra methods such as template(). Use it to speedup your development and make it more flexible.</p>';
$_['entry_test_toggle']         = 'Test the status of events';
$_['help_event_support']        = '<h4>Important! Event Support required</h4> <p>Before you can use twig templates, you must first install and activate event manager. Inside Event Manager tab settings activate Compatibility support. Because you are using opencart v'.VERSION.' your opencart does not support the latest event features. When installing Event manager and activating compatibility in tab Settings, you will be able to activate twig here.</p>';

//button
$_['button_save_and_stay']      = 'Save and stay';

//success
$_['success_modifed']           = 'Success: You have modified module eBay featured!';

// Error
$_['error_permission']          = 'Warning: You do not have permission to modify the twig manager!';
$_['error_twig']                = 'Warning: You can only save .twig files!';

//setting
$_['tab_editor']                = 'Editor';
$_['tab_setting']               = 'Settings';

$_['text_success']              = 'You have successfuly modifive event manager';
$_['error_failed_test_install'] = 'Oops! Before you can run tests you must turn on the compatiblity for opencart version 2.2.0.0 and below.';


//instruction
$_['tab_instruction']           = 'Instructions';
$_['text_instruction']          = '';
$_['text_instruction_old']          = '<div class="row">
    <div class="col-md-6">
    <h2>Lorem Ipsum is simply</h2>
    <p><img src="'.HTTPS_SERVER.'view/image/d_twig_manager/d_twig_manager_1.png" class="img-thumbnail img-responsive" /></p>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    <div class="bs-callout bs-callout-warning"><h4>Attention!</h4><p>If you get an error from google, or a white screen- please check that you compleated all the steps.</p></div>
    <ol>
        <li>Lorem ipsum dolor sit amet</li>
        <li>Consectetur adipiscing elit</li>
        <li>Integer molestie lorem at massa</li>
        <li>Facilisis in pretium nisl aliquet</li>
        <li>Nulla volutpat aliquam velit</li>
    </ol>
    </div>
    <div class="col-md-6">
    <h2>Lorem Ipsum is simply</h2>
    <p><img src="'.HTTPS_SERVER.'view/image/d_twig_manager/d_twig_manager_1.png" class="img-thumbnail img-responsive"/></p>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    <blockquote>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
        <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer>
    </blockquote>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#google_plus"  data-toggle="tab"><i class="fa fa-google-plus"></i> Google+</a></li>
            <li><a href="#facebook"  data-toggle="tab"><i class="fa fa-facebook"></i> Facebook</a></li>
            <li><a href="#twitter"  data-toggle="tab"><i class="fa fa-twitter"></i> Twitter</a></li>
        </ul>
        <div class="tab-content">
            <div id="google_plus" class="tab-pane active">
                <div class="tab-body">
                    <h3>google+</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer</p>
                </div>
            </div>
            <div id="facebook" class="tab-pane">
                <div class="tab-body">
                    <h3>facebook</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer</p>
                </div>
            </div>
            <div id="twitter" class="tab-pane">
                <div class="tab-body">
                    <h3>twitter</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer</p>
                </div>
            </div>
        </div>
    </div>
</div>
';

$_['text_not_found'] = '<div class="jumbotron">
          <h1>Please install Shopunity</h1>
          <p>Before you can use this module you will need to install Shopunity. Simply download the archive for your version of opencart and install it view Extension Installer or unzip the archive and upload all the files into your root folder from the UPLOAD folder.</p>
          <p><a class="btn btn-primary btn-lg" href="https://shopunity.net/download" target="_blank">Download</a></p>
        </div>';