<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace Application\Controllers;

use Application\Models\Form;
use Application\Models\Link;
use System\Request\RequestContext;


/**
 * Class Default_Controller
 * @package Application\Controllers
 */
class Default_Controller extends A_Controller
{
    /**
     * @param RequestContext $requestContext
     */
    protected function doExecute(RequestContext $requestContext)
    {
        $data = array('page-title'=>"Search");
        $requestContext->setResponseData($data);
        $requestContext->setView('index.php');

        if($requestContext->fieldIsSet('search', INPUT_GET))
        {
            $this->doSearch($requestContext);
        }
    }

    protected function doSearch(RequestContext $requestContext)
    {
        $data = array();
        $search_string = $requestContext->getField('search', INPUT_GET);
        $result_set = array();

        //ini_set('memory_limit', '65M');
        $search_terms = $this->stemSearchTerms(explode(" ", $search_string));
        $matching_forms = Form::getMapper('Form')->searchByTerm(implode(" ", $search_terms));
        if(is_object($matching_forms) and $matching_forms->size())
        {
            foreach ($matching_forms as $form)
            {
                if(!isset($result_set[$form->getId()]))
                {
                    $result_group = array();
                    $form_link = $form->getLink();
                    $result_group['main-link'] = $form_link;
                    $result_group['rel-links'] = $this->getRelatedLinks($form_link);
                    $result_set[$form->getId()] = $result_group;
                } //if form had been previously retrieved
            }//foreach of matching forms
        }//if there are matching forms

        $data['page-title'] = "Search Results> ".$search_string;
        $data['search-string'] = $search_string;
        $data['result-set'] = $result_set;
        $requestContext->setResponseData($data);
        $requestContext->setView('search-results.php');
    }

    private function getRelatedLinks(Link $link)
    {
        $rel_links = null;
        $parent = $link->getParentLink();
        if(is_object($parent))
        {
            $rel_links = $link->mapper()->findByParentLink($parent->getId());
        }
        return $rel_links;
    }

    private function stemSearchTerms(array $terms_arr)
    {
        $stop_words = array(' ','in','out','to','from','with','without');
        $stemmed_terms = array();
        foreach ($terms_arr as $term){
            if(! in_array($term, $stop_words)) $stemmed_terms[] = $term;
        }
        return $stemmed_terms;
    }
}