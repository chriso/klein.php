<?php
/**
 * Klein (klein.php) - A lightning fast router for PHP
 *
 * @author      Chris O'Hara <cohara87@gmail.com>
 * @author      Trevor Suarez (Rican7) (contributor and v2 refactorer)
 * @copyright   (c) Chris O'Hara
 * @link        https://github.com/chriso/klein.php
 * @license     MIT
 */

namespace Klein;

/**
 * AbstractRouteFactory
 *
 * Abstract class for a factory for building new Route instances
 *
 * @abstract
 * @package     Klein
 */
abstract class AbstractRouteFactory
{
    /**
     * The namespace of which to collect the routes in
     * when matching, so you can define routes under a
     * common endpoint
     *
     * @var string
     * @access protected
     */
    protected $namespace;

    /**
     * Constructor
     *
     * @param string $namespace The initial namespace to set
     * @access public
     */
    public function __construct($namespace = null)
    {
        $this->namespace = $namespace;
    }

    /**
     * Gets the value of namespace
     *
     * @access public
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Sets the value of namespace
     *
     * @param string $namespace The namespace from which to collect the Routes under
     * @access public
     * @return AbstractRouteFactory
     */
    public function setNamespace($namespace)
    {
        $this->namespace = (string)$namespace;

        return $this;
    }

    /**
     * Append a namespace to the current namespace
     *
     * @param string $namespace The namespace from which to collect the Routes under
     * @access public
     * @return AbstractRouteFactory
     */
    public function appendNamespace($namespace)
    {
        $this->namespace .= (string)$namespace;

        return $this;
    }

    /**
     * Build factory method
     *
     * This method should be implemented to return a Route instance
     *
     * @param callable $callback Callable callback method to execute on route match
     * @param string $path Route URI path to match
     * @param string|array $method HTTP Method to match
     * @param boolean $count_match Whether or not to count the route as a match when counting total matches
     * @param string $name The name of the route
     * @abstract
     * @access public
     * @return Route
     */
    abstract public function build($callback, $path = null, $method = null, $count_match = true, $name = null);
}
