<?php namespace Autumn\Api\Traits;

trait AdditionalRoutes
{
    /**
     * Extra routes.
     *
     * @var array
     */
    private $additionalRoutes = [];

    /**
     * Add additional routes to a resource endpoints.
     *
     * @param string $handler
     * @param string $url
     * @param string $verb
     * @param string|null $name
     */
    public function addAdditionalRoute($handler, $url, $verb = 'get', $name = null)
    {
        if (method_exists($this, $handler)) {
            $this->additionalRoutes[$url] = [
                'handler' => $handler,
                'verb' => $verb,
                'name' => $name
            ];
        }
    }

    /**
     * Get all additional routes.
     *
     * @return array
     */
    public function getAdditionalRoutes()
    {
        return $this->additionalRoutes;
    }
}