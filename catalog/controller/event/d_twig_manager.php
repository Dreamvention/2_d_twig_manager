<?php
class ControllerEventDTwigManager extends Controller {

	public function view_before(&$route, &$data, &$output){

		$parts = explode('template/', $route); 
		$view = $route;
		if(isset($parts['1'])){
			$view = $parts['1'];
		}
		
		if (substr($view, -3) == 'tpl') {
			$view = substr($view, 0, -3);
		}

		if (substr($view, -4) == 'twig') {
			$view = substr($view, 0, -4);
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
		$this->load->model('module/d_twig_manager');

		$theme_info = $this->model_module_d_twig_manager->getTheme($view, $theme);
		
		if ($theme_info) {
			// include and register Twig auto-loader
			include_once DIR_SYSTEM . 'library/template/Twig/Autoloader.php';
			
			Twig_Autoloader::register();	

			// specify where to look for templates
			$loader = new \Twig_Loader_Filesystem(DIR_TEMPLATE);	
			
			// initialize Twig environment
			$twig = new \Twig_Environment($loader, array('autoescape' => false));	

			$template = $twig->createTemplate(html_entity_decode($theme_info['code'], ENT_QUOTES, 'UTF-8'));
			
			$output = $template->render($data);
		} else {

			if (is_file(DIR_TEMPLATE . $theme . '/template/' . $view . '.twig')) { 
				$view = $theme . '/template/' . $view. '.twig';
				
				$this->config->set('template_type', 'twig');
			} elseif (is_file(DIR_TEMPLATE . 'default/template/' . $view . '.twig')) {
				$view = 'default/template/' . $view. '.twig';
				
				$this->config->set('template_type', 'twig');
			} elseif (is_file(DIR_TEMPLATE . $theme . '/template/' . $view . '.tpl')) {
				$view = $theme . '/template/' . $view. '.tpl';
				
				$this->config->set('template_type', 'php');
			} elseif (is_file(DIR_TEMPLATE . 'default/template/' . $view . '.tpl')) {
				$view = 'default/template/' . $view. '.tpl';
				
				$this->config->set('template_type', 'php');
			}		
		
			if(VERSION > '2.0.0.0' || $this->config->get('template_type') == 'twig'){

				$template = new Template($this->config->get('template_type'));

				foreach ($data as $key => $value) {
					$template->set($key, $value);
				}

				if(VERSION <= '2.0.0.0'){
					if (substr($view, -4) == 'twig') {
						$view = substr($view, 0, -5);
					}
				}

				$output = $template->render($view);
			}
		}

		if(!$output){
			
			$output = 'do_not_render_empty_tpl';
			
		}else{

			//Trigger the post events
			//$result = $this->registry->get('event')->trigger('view/' . $route . '/after', array(&$route, &$data, &$output));
			
			// if ($result) {
			// 	return $result;
			// }

			return $output;
		}
	
		
		
		
	}

	public function view_after(&$route, &$data, &$output){
		//required to avoid the return empty bug. 
		if($output == 'do_not_render_empty_tpl'){
			$output = '';
		}


	}

}
if (!class_exists('MyClass')) {
	class Template {
		private $adaptor;

	  	public function __construct($adaptor) {
		    $class = 'Template\\' . $adaptor;

			if (class_exists($class)) {
				$this->adaptor = new $class();
			} else {
				throw new \Exception('Error: Could not load template adaptor ' . $adaptor . '!');
			}
		}

		public function set($key, $value) {
			$this->adaptor->set($key, $value);
		}

		public function render($template) {
			return $this->adaptor->render($template);
		}
	}
}
