<?php
/*  
*   Please refresh your twig compatibility
*   location: catalog/controller
*/

class ControllerEventDTwigManager extends Controller
{   
    //this is added via OCMOD to avoid event sorting order conflict. 
    //added by system/library/d_shopunity/install/d_twig_manager.xml
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

        // If the default theme is selected we need to know which directory its pointing to         
        if ($this->config->get('config_theme') == 'theme_default') {
            $theme = $this->config->get('theme_default_directory');
        } else {
            $theme = $this->config->get('config_theme');
        }

        if(!$theme){
            $theme = $this->config->get('config_template');
        }


        // If there is a theme override we should get it                
        $this->load->model('extension/module/d_twig_manager');

        $theme_info = $this->model_extension_module_d_twig_manager->getTheme($view, $theme);

        if ($theme_info) {
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

            $template = $twig->createTemplate(html_entity_decode($theme_info['code'], ENT_QUOTES, 'UTF-8'));
            $output = $template->render($data);
        } else {
            $render = false;
            if (is_file(DIR_TEMPLATE . $theme . '/template/' . $view . '.twig')) { 
                $view = $theme . '/template/' . $view. '.twig';
                $render = true;
            } elseif (is_file(DIR_TEMPLATE . 'default/template/' . $view . '.twig')) {
                $view = 'default/template/' . $view. '.twig';
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
        }
        
        if($output){
            return $output;
        }
    }
}