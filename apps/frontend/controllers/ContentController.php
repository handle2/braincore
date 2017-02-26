<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2017.02.17.
 * Time: 21:38
 */

namespace Modules\Frontend\Controllers;


use Modules\BusinessLogic\ContentSettings\Content;
use Modules\BusinessLogic\Search\ContentSearch;

class ContentController extends ControllerBase
{
    public function listAction(){
        $labels = $this->request->getJsonRawBody();
        $search = ContentSearch::createContentSearch();
        $search->labels = $labels;
        $contents = $search->find();
        return $this->api(200,$contents);
    }

    public function getAction($url){
        $search = ContentSearch::createContentSearch();
        $search->url = $url;
        /** @var Content $content */
        $content = $search->findFirst();
        $children = $content->getChildren();
        if($children){
            $content->children = $children;
        }
        return $this->api(200,$content);
    }
}