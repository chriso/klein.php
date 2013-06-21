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

namespace Klein\Tests\DataCollection;

use \Klein\Tests\AbstractKleinTest;
use \Klein\DataCollection\RouteCollection;
use \Klein\Route;

/**
 * RouteCollectionTest
 *
 * @uses AbstractKleinTest
 * @package Klein\Tests\DataCollection
 */
class RouteCollectionTest extends AbstractKleinTest
{

    /*
     * Data Providers and Methods
     */

    /**
     * Sample data provider
     *
     * @access public
     * @return array
     */
    public function sampleDataProvider()
    {
        $sample_route = new Route(
            function () {
                echo 'woot!';
            },
            '/test/path',
            'PUT',
            true
        );

        $sample_other_route = new Route(
            function () {
                echo 'huh?';
            },
            '/test/dafuq',
            'HEAD',
            false
        );

        return array(
            array($sample_route, $sample_other_route),
        );
    }


    /*
     * Tests
     */

    /**
     * @dataProvider sampleDataProvider
     */
    public function testSet($sample_route, $sample_other_route)
    {
        // Create our collection with NO data
        $routes = new RouteCollection();

        // Set our data from our test data
        $routes->set('first', $sample_route);

        $this->assertSame($sample_route, $routes->get('first'));
        $this->assertTrue($routes->get('first') instanceof Route);
    }

    public function testSetCallableConvertsToRoute()
    {
        // Create our collection with NO data
        $routes = new RouteCollection();

        // Set our data
        $routes->set(
            'first',
            function () {
            }
        );

        $this->assertNotSame('value', $routes->get('first'));
        $this->assertTrue($routes->get('first') instanceof Route);
    }

    /**
     * @dataProvider sampleDataProvider
     */
    public function testConstructorRoutesThroughSet($sample_route, $sample_other_route)
    {
        $array_of_route_instances = array(
            $sample_route,
            $sample_other_route,
            new Route(
                function () {
                }
            ),
        );

        // Create our collection
        $routes = new RouteCollection($array_of_route_instances);
        $this->assertSame($array_of_route_instances, $routes->all());

        foreach ($routes as $route) {
            $this->assertTrue($route instanceof Route);
        }
    }

    /**
     * @dataProvider sampleDataProvider
     */
    public function testAddRoute($sample_route, $sample_other_route)
    {
        $array_of_routes = array(
            $sample_route,
            $sample_other_route,
        );

        // Create our collection
        $routes = new RouteCollection();

        foreach ($array_of_routes as $route) {
            $routes->addRoute($route);
        }

        $this->assertSame($array_of_routes, array_values($routes->all()));
    }

    public function testAddCallableConvertsToRoute()
    {
        // Create our collection with NO data
        $routes = new RouteCollection();

        $callable = function () {
        };

        // Add our data
        $routes->add($callable);

        $this->assertNotSame($callable, current($routes->all()));
        $this->assertTrue(current($routes->all()) instanceof Route);
    }
}
