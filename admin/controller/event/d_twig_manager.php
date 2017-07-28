<?php
/*  
*   Please refresh your twig compatibility
*   location: catalog/controller
*/

class ControllerEventDTwigManager extends Controller
{   
    //EVENT - this is added via OCMOD to avoid event sorting order conflict. added by system/library/d_shopunity/install/d_twig_manager.xml
    public function support($input){

        $output = false;
        $route = $input['route'];
        $data = $input['data'];
        $parts = explode('template/', $route); 
        $view = $route;
        if(isset($parts['1'])){
            $view = $parts['1'];
        }

        if (substr($view, -3) == 'tpl') {
            $view = substr($view, 0, -4);
        }

        if (substr($view, -4) == 'twig') {
            $view = substr($view, 0, -5);
        }

        // If there is a theme override we should get it                
        $render = false;
        if (is_file(DIR_TEMPLATE . $view . '.twig')) { 
            $view =  $view. '.twig';
            $render = true;
        }

        if($render){
            // include and register Twig auto-loader
            include_once DIR_SYSTEM . 'library/template/Twig/Autoloader.php';

            Twig_Autoloader::register();

            // specify where to look for templates
            $loader = new \Twig_Loader_Filesystem(DIR_TEMPLATE);

                // initialize Twig environment
            $twig = new \Twig_Environment($loader, array(
                'autoescape' => false,
                'debug' => true
                )); 
            $twig->addExtension(new Twig_Extension_DTwigManager($this->registry));
            $twig->addExtension(new Twig_Extension_Debug());

            $template = $twig->loadTemplate($view);
            $output = $template->render($data);

            if(!$output){
                return false;
            }
        }
        
        if($output){
            return $output;
        }
    }
}