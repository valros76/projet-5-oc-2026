<?php
class Router
{
	private $listRoutes;

	public function __construct()
	{
		if (!file_exists("routes/routes.json")) {
			exit;
		}
		$stringRoutes = file_get_contents("routes/routes.json");
		$this->listRoutes = json_decode($stringRoutes);
	}

	public function findRoute($httpRequest, $basepath)
	{
		$url = str_replace($basepath, "", parse_url($httpRequest->getUrl(), PHP_URL_PATH));
		$method = $httpRequest->getMethod();
		$routeFound = array_filter($this->listRoutes, function ($route) use ($url,$method) {
			return preg_match("#^{$route->path}$#", $url) && $route->method == $method;
		});
		$numberRoute = count($routeFound);
		if ($numberRoute > 1) {
			throw new Exception("Multiple Route Found");
		} else if ($numberRoute == 0) {
			throw new NoRouteFoundException($httpRequest);
		} else {
			return new Route(array_shift($routeFound));
		}
	}
}
