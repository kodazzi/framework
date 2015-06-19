<?php
 /**
 * This file is part of the Kodazzi Framework.
 *
 * (c) Jorge Gaitan <jgaitan@kodazzi.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kodazzi;

use DetectionMobile_Detect;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Kodazzi\Config\ConfigBuilder;
use Kodazzi\EventDispatcher\Event;
use Kodazzi\Orm\Db;
use Kodazzi\Session\SessionBuilder;
use Kodazzi\Translator\TranstalorBuilder;
use Kodazzi\View\ViewBuilder;
use Service;

Class Controller
{
    /**
     * @return Response
     */
    public function getResponse( $content = '', $status = 200, $headers = array() )
    {
        return new Response( $content, $status, $headers );
    }

    public function getParameters($key)
    {
        $attributes = Service::get('kernel.request')->attributes->all();

        if( array_key_exists($key, $attributes) )
        {
            return (string)$attributes[$key];
        }

        return null;
    }

   /**
    * @return SessionBuilder
    */
    public function getSession()
    {
        return Service::get('session');
    }

    /**
     * @return ViewBuilder
     */
    public function getView()
    {
        return Service::get('view');
    }


    /**
     * @return TranstalorBuilder
     */
    public function getTranstalor()
    {
        return Service::get('translation');
    }

    /**
     * @return ConfigBuilder
     */
    public function getConfig()
    {
        return Service::get('config');
    }

    /**
     * @return Db
     */
    public function getDB()
    {
        return Service::get('db');
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return Service::get('event');
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return Service::get('kernel.request');
    }

    public function getPOST()
    {
        return Service::get('kernel.request')->request->all();
    }

    public function getGET()
    {
        return Service::get('kernel.request')->query->all();
    }

    public function isAjax()
    {
        return Service::get('kernel.request')->isXmlHttpRequest();
    }

    /**
     * @return DetectionMobile_Detect
     */
    public function getMobileDetect()
    {
        return Service::get('mobile');
    }

    public function getRender($template, $data = array())
    {
        return $this->getView()->render($template, $data);
    }

    public function render($template, $data = array())
    {
        return new Response($this->getView()->render($template, $data));
    }

    public function buildUrl($route, $parameters = array())
    {
        return Service::get('kernel.url_generator')->generate( $route, $parameters);
    }

    public function jsonResponse($data)
    {
        $response = new JsonResponse();
        $response->setData( $data );

        return $response;
    }

    public function getBaseUrl($is_secure = false)
    {
        if( $is_secure )
        {
            return "https://{$_SERVER['HTTP_HOST']}";
        }

        return "http://{$_SERVER['HTTP_HOST']}";
    }

    public function slug($string)
    {
        $string = \Kodazzi\Tools\String::slug($string);

        return $string;
    }

    public function getTimestamp($string = 'Y-m-d H:i:s')
    {
        $DateTime = new \DateTime('NOW');
        return $DateTime->format( $string );
    }
}