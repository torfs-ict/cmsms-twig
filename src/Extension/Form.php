<?php

namespace CMSMS\Twig\Extension;

class Form extends \Twig_Extension {
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form_start', [$this, 'formStart']),
            new \Twig_SimpleFunction('form_end', [$this, 'formEnd'])
        ];
    }

    public function formStart(
        $module = null, $action = null, $mid = null, $returnid = null, $inline = null, $method = 'POST', $url = NULL,
        $enctype = 'multipart/form-data', $id = null, $class = null, $extraparms = null
    ) {
        require_once(\CmsApp::get_instance()->GetConfig()->offsetGet('root_path') . '/plugins/function.form_start.php');
        $params = [];
        $smarty = \CmsApp::get_instance()->GetSmarty();
        foreach(['module', 'action', 'mid', 'returnid', 'inline', 'method', 'url',
            'enctype', 'id', 'class', 'extraparms'] as $param) {
            if (is_null($$param)) continue;
            $params[$param] = $$param;
        }
        return smarty_function_form_start($params, $smarty);
    }

    public function formEnd() {
        require_once(\CmsApp::get_instance()->GetConfig()->offsetGet('root_path') . '/plugins/function.form_end.php');
        $smarty = \CmsApp::get_instance()->GetSmarty();
        return smarty_function_form_end([], $smarty);
    }
}