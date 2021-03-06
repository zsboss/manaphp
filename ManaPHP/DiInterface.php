<?php

namespace ManaPHP;

/**
 * Interface ManaPHP\DiInterface
 *
 * @package di
 */
interface DiInterface
{
    /**
     * Registers a component in the component container
     *
     * @param string $name
     * @param mixed  $definition
     *
     * @return static
     */
    public function set($name, $definition);

    /**
     * Registers an "always shared" component in the components container
     *
     * @param string $name
     * @param mixed  $definition
     *
     * @return static
     */
    public function setShared($name, $definition);

    /**
     * @param string       $pattern
     * @param string|array $namespaces
     *
     * @return static
     */
    public function setPattern($pattern, $namespaces);

    /**
     * @param string $name
     *
     * @return string|array|callable|null
     */
    public function getDefinition($name);

    /**
     * Removes a component from the components container
     *
     * @param string $name
     *
     * @return static
     */
    public function remove($name);

    /**
     * @param mixed  $definition
     * @param array  $parameters
     * @param string $name
     *
     * @return mixed
     */
    public function getInstance($definition, $parameters = null, $name = null);

    /**
     * Resolves the component based on its configuration
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return mixed
     */
    public function get($name, $parameters = null);

    /**
     * Resolves a shared component based on their configuration
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getShared($name);

    /**
     * Check whether the DI contains a component by a name
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name);

    /**
     *Return the First DI created
     *
     * @return static
     */
    public static function getDefault();
}
