<?php

namespace App\Traits;

trait HandleClientResponses
{
    /**
     * Decode correspondingly the response
     * @param $response
     * @return mixed
     */
    public function decodeResponse($response)
    {
        $decodedResponse = json_decode($response);

        return $decodedResponse->data ?? $decodedResponse;
    }

    /**
     * Resolve when the request failed
     * @return void
     * @throws \Exception
     */
    public function checkIfErrorResponse($response)
    {
        if (isset($response->error)) {
            throw new \Exception("Something failed: {$response->error}");
        }
    }
}
