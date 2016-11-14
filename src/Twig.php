<?php

namespace CMSMS\Twig;

use CMSMS\Twig\Extension\Form;

trait Twig {
    /** @var \Twig_Environment */
    private $twig;
    public function twigInit() {
        /** @var \CMSModule $this */
        $paths = [
            cms_join_path($this->config->offsetGet('root_path'), 'module_custom', $this->GetName(), 'templates'),
            cms_join_path($this->GetModulePath(), 'templates')
        ];
        $loader = new \Twig_Loader_Filesystem();
        foreach($paths as $path) {
            if (is_dir($path)) $loader->addPath($path);
        }
        $this->twig = new \Twig_Environment($loader, [
            'cache' => $this->config->offsetGet('tmp_templates_c_location'),
            'debug' => true,
            'auto_reload' => true
        ]);
        $this->twig->addExtension(new \Twig_Extension_Debug());
        $this->twig->addExtension(new Form());
    }
    public function twigRender($twigFile, $context = [], \Twig_Template &$template = null) {
        $template = $this->twig->loadTemplate($twigFile);
        foreach(\CmsApp::get_instance()->GetSmarty()->getTemplateVars() as $var => $val) {
            $this->twig->addGlobal($var, $val);
        }
        return $template->render($context);
    }
}