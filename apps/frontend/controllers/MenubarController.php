<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2016.10.09.
 * Time: 13:37
 */

namespace Modules\Frontend\Controllers;

use Modules\BusinessLogic\ContentSettings\Content;

class MenubarController extends ControllerBase
{
    public function indexAction(){
        die('why');
        $content = Content::getContent($param);
        if($content->type == 'menu'){

            $this->view->content = $content;
            $this->view->children = $content->getChildren();
            $this->view->setMainView('cms/list');

        }elseif ($content->type == 'content'){

            $this->view->content = $content;
            $this->view->setMainView('cms/page');

        }

        if(!$content){

            $this->view->setMainView('404');

        }

    }

    public function kriszAction(){
        dd('krisz');
    }
}