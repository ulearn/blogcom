<?php
/**
 * Copyright 2012 Eric D. Hough (http://ehough.com)
 *
 * This file is part of shortstop (https://github.com/ehough/shortstop)
 *
 * shortstop is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * shortstop is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with shortstop.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * Lifted from http://core.trac.wordpress.org/browser/tags/3.0.4/wp-includes/class-http.php
 *
 * HTTP request method uses HTTP extension to retrieve the url.
 *
 * Requires the HTTP extension to be installed. This would be the preferred transport since it can
 * handle a lot of the problems that forces the others to use the HTTP version 1.0. Even if PHP 5.2+
 * is being used, it doesn't mean that the HTTP extension will be enabled.
 *
 */
class ehough_shortstop_impl_transports_ExtHttpTransport extends ehough_shortstop_impl_transports_AbstractHttpTransport
{
    private static $_option_timeout        = 'timeout';
    private static $_option_connecttimeout = 'connecttimeout';
    private static $_option_useragent      = 'useragent';
    private static $_option_headers        = 'headers';
    private static $_option_redirect       = 'redirect';

    private static $_info_error        = 'error';
    private static $_info_responsecode = 'response_code';

    private $_info;

    /** @var ehough_epilog_api_ILogger */
    private $_logger;

    public function __construct(ehough_shortstop_spi_HttpMessageParser $messageParser)
    {
        parent::__construct($messageParser);

        $this->_logger = ehough_epilog_api_LoggerFactory::getLogger('HTTP extension Transport');
    }

    /**
     * Determines whether or not this transport is available on the system.
     *
     * @return bool True if this transport is available on the system. False otherwise.
     */
    public function isAvailable()
    {
        if (! function_exists('http_request')) {

            if ($this->_logger->isDebugEnabled()) {

                $this->_logger->debug('http_request() does not exist');
            }

            return false;
        }

        return true;
    }

    /**
     * Determines if this transport can handle the given request.
     *
     * @param ehough_shortstop_api_HttpRequest $request The request to handle.
     *
     * @return bool True if this transport can handle the given request. False otherwise.
     */
    public function canHandle(ehough_shortstop_api_HttpRequest $request)
    {
        return true;
    }

    /**
     * Perform optional setup to handle a new HTTP request.
     *
     * @param ehough_shortstop_api_HttpRequest $request The HTTP request to handle.
     *
     * @return void
     */
    protected function prepareToHandleNewRequest(ehough_shortstop_api_HttpRequest $request)
    {
        $this->_info = array();
    }

    /**
     * Perform handling of the given request.
     *
     * @param ehough_shortstop_api_HttpRequest $request The HTTP request.
     *
     * @return string The raw response for this request. May be empty or null.
     */
    protected function handleRequest(ehough_shortstop_api_HttpRequest $request)
    {
        $method  = self::_getMethod($request);
        $url     = $request->getUrl()->toString();
        $body    = $request->getEntity() === null ? null : $request->getEntity()->getContent();
        $options = self::_buildOptionsArray($request);

        $rawResponse = @http_request($method, $url, $body, $options, $this->_info);

        if ($rawResponse === false || ! empty($this->_info[self::$_info_error])) {

            throw new Exception($this->_info[self::$_info_responsecode] . ': ' . $this->_info[self::$_info_error]);
        }

        return $rawResponse;
    }

    /**
     * Get the name of this transport.
     *
     * @return string The name of this transport.
     */
    protected function getTransportName()
    {
        return 'HTTP Extension';
    }

    /**
     * Get the response code.
     *
     * @return int the HTTP response code.
     */
    protected function getResponseCode()
    {
        return $this->_info[self::$_info_responsecode];
    }

    /**
     * Perform optional tear down after handling a request.
     *
     * @return void
     */
    protected function tearDown()
    {
        unset($this->_info);
    }

    private static function _buildOptionsArray(ehough_shortstop_api_HttpRequest $request)
    {
        return array(
            self::$_option_timeout => 5,
            self::$_option_connecttimeout => 5,
            self::$_option_redirect => 5,
            self::$_option_useragent => $request->getHeaderValue(ehough_shortstop_api_HttpRequest::HTTP_HEADER_USER_AGENT),
            self::$_option_headers => $request->getAllHeaders()
        );
    }

    private static function _getMethod(ehough_shortstop_api_HttpRequest $request)
    {
        switch ($request->getMethod()) {

            case ehough_shortstop_api_HttpRequest::HTTP_METHOD_POST:

                return HTTP_METH_POST;

            case ehough_shortstop_api_HttpRequest::HTTP_METHOD_PUT:

                return HTTP_METH_PUT;

            case ehough_shortstop_api_HttpRequest::HTTP_METHOD_GET:
            default:

                return HTTP_METH_GET;
        }
    }

    /**
     * @return ehough_epilog_api_ILogger
     */
    protected function getLogger()
    {
        return $this->_logger;
    }
}