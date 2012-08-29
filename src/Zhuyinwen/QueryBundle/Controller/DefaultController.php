<?php

namespace Zhuyinwen\QueryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zhuyinwen\QueryBundle\Entity\Term;

class DefaultController extends Controller
{
    /**
     * @Route("/query/{zhuyin}")
     */
    public function indexAction($zhuyin)
    {
    	$result = Term::query($zhuyin);
    	$retval = '';
    	if (is_null($result)) {
    		$retval .= '查無資料';
    	}
    	else {
    		foreach($result as $result_element) {
    			$retval .= $result_element . '<br/>';
    		}
    	}
        return new Response('<html><body>' . $retval . '</body></html>');
    }
}
