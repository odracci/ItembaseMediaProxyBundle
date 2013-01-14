<?php
namespace Itembase\Bundle\MediaProxyBundle\Controller;

use Itembase\Bundle\MediaProxyBundle\Exception\WrongHashException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @author Thomas Bretzke <tb@itembase.biz>, Bora Tunca <bt@itembase.biz>
 */
class ProxyController
{
    private $algorithm;
    private $secret;

    /**
     *
     * @param string $algorithm
     * @param string $secret
     */
    public function __construct($algorithm, $secret)
    {
        $this->algorithm = $algorithm;
        $this->secret = $secret;
    }

    /**
     * Action to receive proxied media
     *
     * @param string $hash
     * @param Request $request
     */
    public function proxyMedia($hash, Request $request)
    {
        $url = rawurldecode($request->query->get('path'));
        $checkHash = hash_hmac($this->algorithm, $url, $this->secret);

        if ($checkHash != rawurldecode($hash)) {
            throw new WrongHashException('Sorry!');
        }

        // Get file with curl
        $curlHandle = curl_init($url);

        // Don't return HTTP headers, just contents!
        curl_setopt($curlHandle, CURLOPT_HEADER, false);
        curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        // Make the call
        $response = curl_exec($curlHandle);

        $headers = array(
            'Content-Type' => curl_getinfo($curlHandle, CURLINFO_CONTENT_TYPE),
            'Cache-Control' => 'private'
        );

        curl_close($curlHandle);

        return new Response($response, 200, $headers);
    }
}