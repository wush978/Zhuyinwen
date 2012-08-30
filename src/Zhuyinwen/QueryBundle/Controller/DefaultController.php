<?php

namespace Zhuyinwen\QueryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Zhuyinwen\QueryBundle\Entity\Term;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="_welcome")
	 */
	public function indexAction() 
	{
		return $this->render('ZhuyinwenQueryBundle:Default:index.html.twig');
	}
	
    /**
     * @Route("/query", name="_query")
     * @Method({"POST"})
     */
    public function queryAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('query');
    	if ($query != "") {
    		$query_result = Term::query($query);
    		$retval = array(
    				"responseCode" => 200,
    				"message" => $query_result
    				);
    	} else {
    		$retval = array(
    				"responseCode" => 400,
    				"message" => "錯誤的查詢值"
    				);
    	}
    	$retval = json_encode($retval);
    	return new Response($retval, 200, array('Content-Type'=>'application/json'));
    }
}
