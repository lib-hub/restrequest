<?php

namespace RestRequest;

use Exception;
use stdClass;

class RestRequest
{
    private string $url;
    private int $timeout;
    private array $defaultHeaders;

    /**
     * HttpRequest constructor.
     *
     * @param string $url Base url for the RESTFul requests
     * @param integer $timeout Seconds after the http requests timeouts
     */
    public function __construct(string $url, int $timeout = 30)
    {
        $this->url = $url;
        $this->timeout = $timeout;

        // Headers sent on every http call
        $this->defaultHeaders = [
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Referer: " . $url
        ];
    }

    /**
     * Change default headers
     *
     * @param array $headers
     */
    public function setDefaultHeaders(array $headers)
    {
        $this->defaultHeaders = $headers;
    }

    /**
     * Add a header to the default headers
     *
     * @param string $header
     */
    public function addDefaultHeader(string $header)
    {
        $this->defaultHeaders[] = $header;
    }

    /**
     * HTTP POST
     *
     * @param string $postBody
     * @param array $headers
     * @param string $path
     * @return stdClass holding body, status, headers
     * @throws Exception
     */
    public function post(string $postBody, array $headers = [], string $path = ""): object
    {
        $ch = curl_init();
        if ($ch === false) throw new Exception("Curl initialization failed.");

        // Set default options
        $ch = $this->setCurl($ch);

        // Add URL path if it exists
        $url = ($path === "") ? $this->url : $this->addParamToUrl($path, $this->url);

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->defaultHeaders, $headers));

        // Set true for json data
        curl_setopt($ch, CURLOPT_POST, true);

        // Set request body
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);

        // Set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        // Execute the request.
        return $this->execute($ch);
    }

    /**
     * HTTP GET
     *
     * @param string $id
     * @param array $queryParams
     * @param array $headers
     * @return stdClass holding body, status, headers
     * @throws Exception
     */
    public function get(string $id = "", array $queryParams = [], array $headers = []): object
    {
        $ch = curl_init();
        if ($ch === false) throw new Exception("Curl initialization failed.");

        // Set default options
        $ch = $this->setCurl($ch);

        // Add URL path if it exists
        $url = ($id === "") ? $this->url : $this->addParamToUrl($id, $this->url);

        // Add URL query parameters if they exist
        if (count($queryParams) > 0) {
            $url = $this->addQueryToUrl($queryParams, $url);
        }

        // Set the URL that you want to call.
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->defaultHeaders, $headers));

        // Set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        // Execute the request.
        return $this->execute($ch);
    }

    /**
     * HTTP PUT
     *
     * @param string $id
     * @param string $dataString
     * @param array $headers
     * @return stdClass holding body, status, headers
     * @throws Exception
     */
    public function put(string $id, string $dataString, array $headers = []): object
    {
        $ch = curl_init();
        if ($ch === false) throw new Exception("Curl initialization failed.");

        // Set default options
        $ch = $this->setCurl($ch);

        // Add URL path
        $url = $this->addParamToUrl($id, $this->url);

        // Set the URL that you want to call.
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->defaultHeaders, $headers));

        // Set request body
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        // Set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        // Execute the request.
        return $this->execute($ch);
    }

    /**
     * HTTP PATCH
     *
     * @param string $id
     * @param string $dataString
     * @param array $headers
     * @return stdClass holding body, status, headers
     * @throws Exception
     */
    public function patch(string $id, string $dataString, array $headers = []): object
    {
        $ch = curl_init();
        if ($ch === false) throw new Exception("Curl initialization failed.");

        // Set default options
        $ch = $this->setCurl($ch);

        // Add URL path
        $url = $this->addParamToUrl($id, $this->url);

        // Set the URL that you want to call.
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->defaultHeaders, $headers));

        // Set request body
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        // Set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");

        // Execute the request.
        return $this->execute($ch);
    }

    /**
     * HTTP DELETE
     *
     * @param string $id
     * @param array $headers
     * @return stdClass holding body, status, headers
     * @throws Exception
     */
    public function delete(string $id, array $headers = []): object
    {
        $ch = curl_init();
        if ($ch === false) throw new Exception("Curl initialization failed.");

        // Set default options
        $ch = $this->setCurl($ch);

        // Add URL path
        $url = $this->addParamToUrl($id, $this->url);

        // Set the URL that you want to call.
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->defaultHeaders, $headers));

        // Set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        // Execute the request.
        return $this->execute($ch);
    }

    /**
     * Set cURL default options
     *
     * @param resource $ch
     * @return resource
     */
    private function setCurl($ch)
    {
        // Set to true so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        // Get headers in curl_exec
        curl_setopt($ch, CURLOPT_HEADER, true);

        // Set to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Set the request timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        return $ch;
    }

    /**
     * Execute the http request (cURL)
     *
     * @param mixed
     * @return stdClass holding properties: body, status, headers
     */
    private function execute($ch): object
    {
        $content = new stdClass();

        // Execute curl and get response
        $response = curl_exec($ch);

        // Get cURL error
        $error = curl_error($ch);

        //Get cURL error number, @link https://www.php.net/manual/en/function.curl-errno.php
        $errorNumber = curl_errno($ch);

        if ($errorNumber) {
            $content->body = $error;
            $content->headers = [];
            $content->status = -$errorNumber;
        } else {
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);
            $content->body = $body;
            $content->headers = $header;
            $content->status = intval($status);
        }
        curl_close($ch);
        return $content;
    }

    /**
     * Add parameter at the end of the url
     *
     * @param string $param
     * @param string $url
     * @return string
     * @throws Exception
     */
    private function addParamToUrl(string $param, string $url): string
    {
        $urlData = parse_url($url);

        if (!isset($urlData["scheme"]) || !isset($urlData["host"])) {
            throw new Exception("Provided bad URL string");
        }
        $param = ($param[0] === "/") ? $param : "/" . $param;
        $param = urlencode($param);
        $finalUrl = $urlData["scheme"] . $urlData["host"];
        $finalUrl .= (isset($urlData["path"])) ? $urlData["path"] . $param : $param;
        $finalUrl .= (isset($urlData["query"])) ? "?" . $urlData["query"] : "";
        $finalUrl .= (isset($urlData["fragment"])) ? "#" . $urlData["fragment"] : "";
        return $finalUrl;
    }

    /**
     * Convert data to a query string and add it to the url
     *
     * @param object|array $data
     * @param string $url
     * @return string
     * @throws Exception
     */
    private function addQueryToUrl($data, string $url): string
    {
        $urlData = parse_url($url);

        if (!isset($urlData["scheme"]) || !isset($urlData["host"])) {
            throw new Exception("Provided bad URL string");
        }
        $queryString = http_build_query($data);
        $finalQueryString = "?";
        $finalQueryString .= (isset($urlData["query"])) ? $urlData["query"] . $queryString : $queryString;
        $finalUrl = $urlData["scheme"] . $urlData["host"];
        $finalUrl .= (isset($urlData["path"])) ? $urlData["path"] . $finalQueryString : $finalQueryString;
        $finalUrl .= (isset($urlData["fragment"])) ? "#" . $urlData["fragment"] : "";
        return $finalUrl;
    }
}