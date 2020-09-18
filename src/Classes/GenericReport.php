<?php
declare(strict_types = 1);

namespace AdsSquared\Classes;

use \DateTime;
use \Exception;

use AdsSquared\Messages;

class GenericReport implements \AdsSquared\Interfaces\Report
{
    /**
     * @property string
     */
    protected $baseURI = 'https://reporting.adssquared.com/';

    /**
     * @property ?string
     */
    protected $jobID = null;

    /**
     * @property bool - Is our report complete?
     */
    protected $complete = false;

    /**
     * @property ?string - The finished report. Null until populated.
     */
    protected $csv = null;

    /**
     * @property string
     */
    protected $jobName;

    /**
     * @property string
     */
    protected $jobStatus;

    /**
     * @property int - Timeout in milliseconds 
     */
    protected $timeout = 3000;

    /**
     * @property \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @property string
     */
    protected $username;

    /**
     * @property string
     */
    protected $token;

    /**
     * @property array
     */
    protected $payload = [];

    /**
     * @param string $jobName
     * @param string $username
     * @param string $apiKey
     * @param int $timeout
     */
    public function __construct(
        string $jobName,
        string $username,
        string $apiKey,
        int $timeout = 3000
    ) {
        $this->jobName = $jobName;
        $this->username = $username;
        $this->token = base64_encode("{$username}:{$apiKey}");
        
        $this->timeout = $timeout;

        // Build the client and set up basic auth
        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->baseURI]);

        $this->startReport();
    }

    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * @param string $path - e.g. '/create/devicehourly'
     * @param string $method
     *
     * @return \GuzzleHttp\Response;
     */
    protected function makeRequest(string $path, bool $usePayload = true, string $method = 'GET')
    {
        $options = [
            'headers' => [
                'Authorization' => "Basic {$this->token}",
            ],
            'debug' => false,
            'verify' => true,
        ];

        if ($usePayload) {
            $options['query'] = $this->payload;
        }

        $response = $this->client->request($method, $path, $options);

        $code = $response->getStatusCode();

        if ($code !== 200) {
            // Cast to a string to force guzzle to give you the contents of the body rather than an object
            $body = (string)$response->getBody()->getContents();
            
            throw new Exception("Response Code {$code} returned. {$body}");
        }

        return $response;
    }

    /**
     * Ask the server to begin generating the report.
     *
     * @return void
     */
    public function startReport() {
        $response = $this->makeRequest("create/{$this->jobName}", false);
        $decoded = json_decode((string)$response->getBody()->getContents(), true);

        if (!is_array($decoded)) {
            throw new Exception(Messages::UNEXPECTED_RESPONSE . $response->getBody()->getContents());
        }

        $this->jobStatus = 'Requested';
        $this->jobID = $decoded['payload']['jobid'];
    }

    /**
     * Check the status of a previously-generated report
     *
     * @return string
     */
    public function status(): string {
        if (empty($this->jobID)) {
            throw new Exception(Messages::EMPTY_JOB_ID);
        }

        $response = $this->makeRequest("status/{$this->jobID}", false);
        $decoded = json_decode((string)$response->getBody()->getContents(), true);

        if (!is_array($decoded)) {
            throw new Exception(Messages::UNEXPECTED_RESPONSE . $response->getBody()->getContents());
        }

        $this->jobStatus = $decoded['message'];
        $this->complete = $decoded['message'] === 'Complete';
        return $decoded['message'];
    }

    /**
     * Retrieve a generated report from the server
     *
     * @return bool
     */
    public function fetchReport(): bool {
        $startTime = microtime(true);
        $elapsedTime = 0;
        // Check the status in a loop. Only fetch the report if it's complete.
        while ($elapsedTime < $this->timeout && !$this->complete) {
            if (!$this->complete) {
                $this->status();
            }

            // If it's not ready, wait 500ms and try again
            usleep(500000);
            $elapsedTime = round((microtime(true) - $startTime) * 1000);
        }

        if (!$this->complete) {
            return false;
        }

        $response = $this->makeRequest("fetch/{$this->jobID}", false);

        if ($response->getStatusCode() === 200) {
            $this->csv = $response->getBody()->getContents();    
            return true;
        } else {
            return false;
        }
    }
}
