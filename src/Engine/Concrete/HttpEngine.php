<?php

namespace Itsmattch\NexusCore\Engine\Concrete;

use CurlHandle;
use Itsmattch\NexusCore\Common\Message;
use Itsmattch\NexusCore\Engine\Engine;
use Itsmattch\NexusCore\Engine\Enum\HttpMethod;

/**
 * The HttpEngine is a simple implementation of the Engine
 * using cURL functionality to manage HTTP requests.
 */
class HttpEngine extends Engine
{
    /**
     * Stores the cURL handle for HTTP communication.
     */
    private CurlHandle $handle;

    /**
     * A list of added HTTP headers.
     */
    private array $headers = [];

    public function initialize(): bool
    {
        $initializeCurlHandle = curl_init();
        $initializeCurlOptions = curl_setopt_array($initializeCurlHandle, [
            CURLOPT_URL => $this->address->getAddress(),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        if ($initializeCurlHandle === false || $initializeCurlOptions === false) {
            return false;
        }

        $this->handle = $initializeCurlHandle;
        return true;
    }

    public function execute(): ?Message
    {
        $this->setRequestHeaders();

        $responseBody = curl_exec($this->handle);
        $responseType = $this->getContentType();

        if ($responseBody === false) {
            return null;
        }

        return new Message(
            body: $responseBody,
            type: $responseType,
        );
    }

    public function close(): void
    {
        if (isset($this->handle)) {
            curl_close($this->handle);
        }
    }

    public function attach(Message $message): void
    {
        $this->setBody($message);
    }

    /**
     * Wraps curl_setopt on active handle.
     */
    public function setOpt(int $option, $value): bool
    {
        return curl_setopt($this->handle, $option, $value);
    }

    /**
     * Updates or inserts new headers into the current set
     * of headers.
     *
     * The provided array should be an associative array
     * where keys are the header names and values are the
     * corresponding header values.
     *
     * This method treats header names in a case-insensitive
     * manner. For instance, 'Content-Type' and
     * 'content-type' are considered the same header.
     *
     * @param array $headers A list of headers.
     */
    public function setHeaders(array $headers): void
    {
        foreach ($headers as $name => $value) {
            $this->headers[strtolower($name)] = $value;
        }
    }

    /**
     * Sets Authorization: Bearer header.
     *
     * @param string $token Authorization token.
     */
    public function setToken(string $token): void
    {
        $this->setHeaders(['Authorization' => 'Bearer ' . $token]);
    }

    /**
     * Sets HTTP method.
     *
     * @param HttpMethod $method Valid HTTP method.
     */
    public function setMethod(HttpMethod $method): void
    {
        curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, $method->name);
    }

    /**
     * Sets request body.
     *
     * @param Message $request Request message.
     */
    public function setBody(Message $request): void
    {
        curl_setopt($this->handle, CURLOPT_POSTFIELDS, $request->body);
        $this->setHeaders([
            'Content-Type' => $request->type,
            'Content-Length' => strlen($request->body),
        ]);
    }

    /**
     * Sets current state of $headers array.
     */
    private function setRequestHeaders(): void
    {
        curl_setopt($this->handle, CURLOPT_HTTPHEADER, array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($this->headers), array_values($this->headers)));
    }

    /**
     * Retrieves the content type of the HTTP response.
     *
     * @return string The content type of the HTTP response.
     */
    private function getContentType(): string
    {
        $contentType = curl_getinfo($this->handle, CURLINFO_CONTENT_TYPE);

        if ($contentType === null) {
            return '';
        }

        $endPosition = strpos($contentType, ';');

        if ($endPosition === false) {
            return $contentType;
        }

        return substr($contentType, 0, $endPosition) ?? '';
    }
}