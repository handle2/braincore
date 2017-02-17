<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2017.02.17.
 * Time: 21:38
 */

namespace Modules\Frontend\Controllers;


use Modules\BusinessLogic\Search\ContentSearch;

class ContentController extends ControllerBase
{
    public function listAction(){
        $labels = $this->request->getJsonRawBody();
        $search = ContentSearch::createContentSearch();
        $search->labels = $labels;
        $contents = $search->find();
        return $this->api(200,json_encode($contents));
    }

    public function getAction($url){
        $search = ContentSearch::createContentSearch();
        $search->url = $url;
        $content = $search->findFirst();
        return $this->api(200,json_encode($content));
    }
}