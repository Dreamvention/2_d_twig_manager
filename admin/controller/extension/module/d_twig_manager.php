<?php
/*
 *    location: admin/controller
 */

class ControllerExtensionModuleDTwigManager extends Controller {

    private $codename = 'd_twig_manager';
    private $route = 'extension/module/d_twig_manager';
    private $extension = array();
    private $store_id = 0;
    private $error = array();


    public function __construct($registry) {
        parent::__construct($registry);

        $this->d_shopunity = (file_exists(DIR_SYSTEM.'library/d_shopunity/extension/d_shopunity.json'));
        $this->extension = json_decode(file_get_contents(DIR_SYSTEM.'library/d_shopunity/extension/'.$this->codename.'.json'), true);
        $this->store_id = (isset($this->request->get['store_id'])) ? $this->request->get['store_id'] : 0;
        
    }

    public function index() {

        if($this->d_shopunity){
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->validateDependencies($this->codename);
        }

        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        
        $this->load->model('extension/module/d_twig_manager');
        $this->load->language('extension/module/d_twig_manager');

        // styles and scripts
        $this->document->addStyle('view/stylesheet/d_bootstrap_extra/bootstrap.css');

        $this->document->addScript('view/javascript/d_bootstrap_switch/js/bootstrap-switch.min.js');
        $this->document->addStyle('view/javascript/d_bootstrap_switch/css/bootstrap-switch.min.css');

        $this->document->addScript('view/javascript/d_codemirror/lib/codemirror.js');
        $this->document->addScript('view/javascript/d_codemirror/lib/xml.js');
        $this->document->addScript('view/javascript/d_codemirror/lib/formatting.js');
        $this->document->addStyle('view/javascript/d_codemirror/lib/codemirror.css');
        $this->document->addStyle('view/javascript/d_codemirror/theme/monokai.css');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->link('common/dashboard')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->model_extension_d_opencart_patch_url->link('marketplace/extension','type=module')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->model_extension_d_opencart_patch_url->link($this->route)
        );

        $data['id'] = $this->codename;
        $data['route'] = $this->route;
        $data['version'] = $this->extension['version'];
        $data['user_token'] =  $this->session->data['user_token'];
        $data['d_shopunity'] = $this->d_shopunity;

        $data['heading_title'] = $this->language->get('heading_title_main');

        $data['tab_editor'] = $this->language->get('tab_editor');
        $data['tab_setting'] = $this->language->get('tab_setting');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_store'] = $this->language->get('text_store');
        $data['text_template'] = $this->language->get('text_template');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_history'] = $this->language->get('text_history');
        $data['text_twig'] = $this->language->get('text_twig');

        $data['text_warning'] = $this->language->get('text_warning');
        $data['text_access'] = $this->language->get('text_access');
        $data['text_permission'] = $this->language->get('text_permission');

        $data['text_begin'] = $this->language->get('text_begin');

        $data['entry_compatibility'] = $this->language->get('entry_compatibility');
        $data['help_compatibility'] = $this->language->get('help_compatibility');
        $data['help_event_support'] = $this->language->get('help_event_support');

        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_reset'] = $this->language->get('button_reset');
        $data['install_compatibility'] = $this->model_extension_d_opencart_patch_url->ajax($this->route.'/install_compatibility');
        $data['uninstall_compatibility'] = $this->model_extension_d_opencart_patch_url->ajax($this->route.'/uninstall_compatibility');
        

        $data['user_token'] = $this->session->data['user_token'];
        
        $data['cancel'] = $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module');

        $data['stores'] = array();
        
        $this->load->model('setting/store');
                    
        $results = $this->model_setting_store->getStores();
        
        foreach ($results as $result) {
            $data['stores'][] = array(
                'store_id' => $result['store_id'],
                'name'     => $result['name']
            );
        }
    
        $data['event_support'] = true; //turned off for now.
        $this->load->model('extension/d_opencart_patch/modification');
        $data['compatibility'] = $this->model_extension_d_opencart_patch_modification->getModificationByName('d_twig_manager');
        
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view('extension/module/d_twig_manager', $data));
    }
    
    public function history() {
        $this->load->language('extension/module/d_twig_manager');
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['column_store'] = $this->language->get('column_store');
        $data['column_route'] = $this->language->get('column_route');
        $data['column_theme'] = $this->language->get('column_theme');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['histories'] = array();
        
        $this->load->model('extension/module/d_twig_manager');
        $this->load->model('setting/store');
        
        $history_total = $this->model_extension_module_d_twig_manager->getTotalThemes();
        
        $results = $this->model_extension_module_d_twig_manager->getThemes(($page - 1) * 10, 10);
                    
        foreach ($results as $result) {
            $store_info = $this->model_setting_store->getStore($result['store_id']);
            
            if ($store_info) {
                $store = $store_info['name'];
            } else {
                $store = '';
            }
            
            $data['histories'][] = array(
                'store_id'   => $result['store_id'],
                'store'      => ($result['store_id'] ? $store : $this->language->get('text_default')),
                'route'      => $result['route'],
                'theme'      => $result['theme'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'edit'       => $this->model_extension_d_opencart_patch_url->link($this->route.'/template'),
                'delete'     => $this->model_extension_d_opencart_patch_url->link($this->route.'/delete', 'theme_id=' . $result['theme_id'])
            );            
        }

        $pagination = new Pagination();
        $pagination->total = $history_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->model_extension_d_opencart_patch_url->link($this->route.'/history', 'page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view('extension/module/d_twig_manager/theme_history', $data));
    }
        
    public function path() {
        $this->load->language('design/theme');
        
        $json = array();
        
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];            
        } else {
            $store_id = 0;
        }    
        
        $this->load->model('extension/module/d_twig_manager');
            
            
        $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_theme', $store_id);

        // This is only here for compatibility with old themes.
        if ($theme == 'theme_default') {
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('theme_default_directory', $store_id);            
        }

        if(!$theme){
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_template', $store_id);
        }
        
        if (isset($this->request->get['path'])) {
            $path = $this->request->get['path'];
        } else {
            $path = '';
        }
        
        if (substr(str_replace('\\', '/', realpath(DIR_CATALOG . 'view/theme/' . $theme . '/template/' . $path)), 0, strlen(DIR_CATALOG . 'view')) == DIR_CATALOG . 'view') {
            $path_data = array();
            
            // We grab the files from the default theme directory first as the custom themes drops back to the default theme if selected theme files can not be found.
            $files = glob(rtrim(DIR_CATALOG . 'view/theme/{default,' . $theme . '}/template/' . $path, '/') . '/*', GLOB_BRACE);
            
            if ($files) {
                foreach($files as $file) {
                    if (!in_array(basename($file), $path_data))  {
                        if (is_dir($file)) {
                            $json['directory'][] = array(
                                'name' => basename($file),
                                'path' => trim($path . '/' . basename($file), '/')
                            );
                        }
                        
                        if (is_file($file)) {
                            if(strpos(basename($file), '.twig')){
                                $json['file'][] = array(
                                    'name' => basename($file),
                                    'path' => trim($path . '/' . basename($file), '/')
                                );
                            }
                        }
                        
                        $path_data[] = basename($file);
                    }
                }
            }
        }

        if (!empty($this->request->get['path'])) {
            $json['back'] = array(
                'name' => $this->language->get('button_back'),
                'path' => urlencode(substr($path, 0, strrpos($path, '/'))),
            );
        }        
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));        
    }
    
    public function template() {
        $this->load->language('design/theme');
        
        $json = array();
        
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];            
        } else {
            $store_id = 0;
        }    
        
        $this->load->model('extension/module/d_twig_manager');
            
        $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_theme', $store_id);
        
        // This is only here for compatibility with old themes.
        if ($theme == 'theme_default') {
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('theme_default_directory', $store_id);            
        }

        if(!$theme){
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_template', $store_id);
        }
        
        if (isset($this->request->get['path'])) {
            $path = $this->request->get['path'];
        } else {
            $path = '';
        }

        $this->load->model('extension/module/d_twig_manager');
        
        $theme_info = $this->model_extension_module_d_twig_manager->getTheme($store_id, $theme, $path);

        if ($theme_info) {
            $json['code'] = html_entity_decode($theme_info['code']);
        } elseif (is_file(DIR_CATALOG . 'view/theme/' . $theme . '/template/' . $path) && (substr(str_replace('\\', '/', realpath(DIR_CATALOG . 'view/theme/' . $theme . '/template/' . $path)), 0, strlen(DIR_CATALOG . 'view')) == DIR_CATALOG . 'view')) {
            $json['code'] = file_get_contents(DIR_CATALOG . 'view/theme/' . $theme . '/template/' . $path);
        } elseif (is_file(DIR_CATALOG . 'view/theme/default/template/' . $path) && (substr(str_replace('\\', '/', realpath(DIR_CATALOG . 'view/theme/default/template/' . $path)), 0, strlen(DIR_CATALOG . 'view')) == DIR_CATALOG . 'view')) {
            $json['code'] = file_get_contents(DIR_CATALOG . 'view/theme/default/template/' . $path);
        }  

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function save() {
        $this->load->language('design/theme');
        
        $json = array();
        
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];            
        } else {
            $store_id = 0;
        }    
        
        $this->load->model('extension/module/d_twig_manager');
            
        $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_theme', $store_id);
        
        // This is only here for compatibility with old themes.
        if ($theme == 'theme_default') {
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('theme_default_directory', $store_id);            
        }

        if(!$theme){
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_template', $store_id);
        }
        
        if (isset($this->request->get['path'])) {
            $path = $this->request->get['path'];
        } else {
            $path = '';
        }        
            
        // Check user has permission
        if (!$this->user->hasPermission('modify', 'design/theme')) {
            $json['error'] = $this->language->get('error_permission');
        } 

        if (substr($path, -5) != '.twig') {
            $json['error'] = $this->language->get('error_twig');
        } 
                
        if (!$json) {
            $this->load->model('extension/module/d_twig_manager');
            
            $pos = strpos($path, '.');
            
            $this->model_extension_module_d_twig_manager->editTheme($store_id, $theme, ($pos !== false) ? substr($path, 0, $pos) : $path, $this->request->post['code']);
            
            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function reset() {
        $this->load->language('design/theme');
        
        $json = array();
        
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];            
        } else {
            $store_id = 0;
        }    
        
        $this->load->model('extension/module/d_twig_manager');
            
        $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_theme', $store_id);
        
        // This is only here for compatibility with old themes.
        if ($theme == 'theme_default') {
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('theme_default_directory', $store_id);            
        }

        if(!$theme){
            $theme = $this->model_extension_module_d_twig_manager->getSettingValue('config_template', $store_id);
        }
                
        if (isset($this->request->get['path'])) {
            $path = $this->request->get['path'];
        } else {
            $path = '';
        }        
                
        if (is_file(DIR_CATALOG . 'view/theme/' . $theme . '/template/' . $path) && (substr(str_replace('\\', '/', realpath(DIR_CATALOG . 'view/theme/' . $theme . '/template/' . $path)), 0, strlen(DIR_CATALOG . 'view')) == DIR_CATALOG . 'view')) {
            $json['code'] = file_get_contents(DIR_CATALOG . 'view/theme/' . $theme . '/template/' . $path);
        }        

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function delete() {
        $this->load->language('design/theme');
        
        $json = array();
        
        if (isset($this->request->get['theme_id'])) {
            $theme_id = $this->request->get['theme_id'];            
        } else {
            $theme_id = 0;
        }    
    
        // Check user has permission
        if (!$this->user->hasPermission('modify', 'design/theme')) {
            $json['error'] = $this->language->get('error_permission');
        } 
        
        if (!$json) {         
            $this->load->model('extension/module/d_twig_manager');
        
            $this->model_extension_module_d_twig_manager->deleteTheme($theme_id);

            $json['success'] = $this->language->get('text_success');
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function install_compatibility(){

        $this->load->model('extension/d_opencart_patch/url');

        if(!$this->validate()){
            $this->session->data['error'] = $this->language->get('error_permission');
            $this->response->redirect($this->model_extension_d_opencart_patch_url->link($this->route));
        }

        //$this->load->model('module/d_event_manager');
        // $this->model_module_d_event_manager->deleteEvent($this->codename);
        // $this->model_module_d_event_manager->addEvent($this->codename, 'catalog/view/*/*/before', 'event/d_twig_manager/view_before');
        // $this->model_module_d_event_manager->addEvent($this->codename, 'catalog/view/*/*/after', 'event/d_twig_manager/view_after');

        $this->load->model('extension/module/d_twig_manager');
        $this->model_extension_module_d_twig_manager->installCompatibility();

        $this->session->data['success'] = $this->language->get('text_success');
        $this->response->redirect($this->model_extension_d_opencart_patch_url->link($this->route));
        
    }

    public function uninstall_compatibility(){
        $this->load->model('extension/d_opencart_patch/url');

        if(!$this->validate()){
            $this->session->data['error'] = $this->language->get('error_permission');
            $this->response->redirect($this->model_extension_d_opencart_patch_url->link($this->route));
        }

        // $this->load->model('module/d_event_manager');
        // $this->model_module_d_event_manager->deleteEvent($this->codename);

        $this->load->model('extension/module/d_twig_manager');
        $this->model_extension_module_d_twig_manager->uninstallCompatibility();

        $this->response->redirect($this->model_extension_d_opencart_patch_url->link($this->route));
    }


    public function install() {

        if($this->d_shopunity){
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->installDependencies($this->codename);  
        }

        $this->load->model('extension/module/d_twig_manager');
        $this->model_extension_module_d_twig_manager->installDatabase();
    }

    public function uninstall() {
        if(!$this->validate()){
            return false;
        }
        
        // if($this->d_shopunity){
        //     $this->load->model('module/d_event_manager');
        //     $this->model_module_d_event_manager->deleteEvent($this->codename);
        // }
    }

    public function update(){
        $this->load->model('extension/module/d_twig_manager');
        $this->model_extension_module_d_twig_manager->installCompatibility();
    }

    private function validate($permission = 'modify') {

        if (isset($this->request->post['config'])) {
            return false;
        }

        $this->load->language($this->route);
        
        if (!$this->user->hasPermission($permission, $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
            return false;
        }

        return true;
    }

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
