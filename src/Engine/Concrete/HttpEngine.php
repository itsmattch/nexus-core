<?php

namespace Itsmattch\Nexus\Engine\Concrete;

use CurlHandle;
use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Engine\Engine;
use Itsmattch\Nexus\Engine\Enum\HttpMethod;

/**
 * The HttpEngine is a very simple implementation of the
 * Engine using cURL functionality to manage HTTP requests.
 */
class HttpEngine extends Engine
{
    /** Stores the cURL handle for HTTP communication. */
    private CurlHandle $handle;

    /** A list of added HTTP headers. */
    private array $headers = [];

    public function getHandle(): CurlHandle
    {
        return $this->handle;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    public function setMethod(HttpMethod $method): void
    {
        curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, $method->name);
    }

    public function setBody(Message $request): void
    {
        curl_setopt($this->handle, CURLOPT_POSTFIELDS, $request->getBody());
        $this->setHeaders([
            'Content-Type: ' . $request->getType(),
            'Content-Length: ' . strlen($request->getBody())
        ]);
    }

    /**
     * Initializes the cURL session and sets the necessary options.
     *
     * @return bool Returns true if the cURL handle is successfully initialized, false otherwise.
     */
    public function init(): bool
    {
        $options = [
            CURLOPT_URL => $this->address(),
            CURLOPT_RETURNTRANSFER => true,
        ];

        $initializeCurlHandle = curl_init();
        $initializeCurlOptions = curl_setopt_array($initializeCurlHandle, $options);

        if ($initializeCurlHandle === false || $initializeCurlOptions === false) {
            return false;
        }

        $this->handle = $initializeCurlHandle;
        return true;
    }

    /**
     *
     * Executes the HTTP request and populates the response object.
     *
     * @return bool Returns true if the request is successfully executed, false otherwise.
     */
    public function execute(): bool
    {
        curl_setopt($this->handle, CURLOPT_HTTPHEADER, array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($this->headers), array_values($this->headers)));

        $responseBody = curl_exec($this->handle);
        $responseType = $this->getContentType();

        if ($responseBody === false) {
            return false;
        }

        $this->getResponse()->setBody($responseBody);
        $this->getResponse()->setType($responseType);

        return true;
    }

    /**
     * Retrieves the content type of the HTTP response. If
     * the content type is not available, the method will
     * return null.
     *
     * @return ?string The content type of the HTTP response.
     */
    private function getContentType(): ?string
    {
        $contentType = curl_getinfo($this->handle, CURLINFO_CONTENT_TYPE);

        if ($contentType === null) {
            return null;
        }

        $endPosition = strpos($contentType, ';');

        if ($endPosition === false) {
            return $contentType;
        }

        return substr($contentType, 0, $endPosition);
    }

    /**
     * Closes the cURL handle to release resources.
     */
    public function close(): void
    {
        curl_close($this->handle);
    }
}