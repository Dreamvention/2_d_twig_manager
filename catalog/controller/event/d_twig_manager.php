<?php
class ControllerEventDTwigManager extends Controller {

	public function view_before(&$route, &$data, &$output){

		$parts = explode('template/', $route); 
		$view = $parts['1'];

		// If the default theme is selected we need to know which directory its pointing to			
		if ($this->config->get('config_theme') == 'theme_default') {
			$theme = $this->config->get('theme_default_directory');
		} else {
			$theme = $this->config->get('config_theme');
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
	

			$template = new Template($this->config->get('template_type'));

			foreach ($data as $key => $value) {
				$template->set($key, $value);
			}

			$output = $template->render($view);
		}

		if(!$output){
			$output = 'do_not_render_empty_tpl';
		}else{

			//Trigger the post events
			$result = $this->registry->get('event')->trigger('view/' . $route . '/after', array(&$route, &$data, &$output));
			
			if ($result) {
				return $result;
			}

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