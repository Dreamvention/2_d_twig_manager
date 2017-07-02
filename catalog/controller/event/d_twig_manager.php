<?php
/*  DEPRECATED!!! DO NOT USE!!!
*   Please refresh your twig compatibility
*   location: catalog/controller
*/
require_once(DIR_APPLICATION.'controller/extension/module/d_twig_manager.php');
class ControllerEventDTwigManager extends ControllerExtensionModuleDTwigManager
{   
    public function __construct($registry)
    {
        parent::__construct($registry);
    }
}