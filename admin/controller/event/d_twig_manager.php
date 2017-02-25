<?php
class ControllerEventDTwigManager extends Controller {

    //this is added via OCMOD to avoid event sorting order conflict. added by system/mbooth/install/d_twig_manager.xml
    public function support($input){
    	//only to avoid error with ocmod inclusion. does nothing.
	}
}