<?php

namespace Fp\JsFormValidatorBundle\Twig\Extension;

use Fp\JsFormValidatorBundle\Factory\JsFormValidatorFactory;

/**
 * Class JsFormValidatorTwigExtension
 *
 * @package Fp\JsFormValidatorBundle\Twig\Extension
 */
class JsFormValidatorTwigExtension extends \Twig_Extension
{
    /** @var  \Twig_Environment */
    protected $env;

    /**
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->env = $environment;
    }

    /**
     * @var JsFormValidatorFactory
     */
    protected $factory;

    /**
     * @return JsFormValidatorFactory
     * @codeCoverageIgnore
     */
    protected function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param JsFormValidatorFactory $factory
     *
     * @codeCoverageIgnore
     */
    public function __construct(JsFormValidatorFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'fp_jsfv' => new \Twig_Function_Method($this, 'getJsValidator', array('is_safe' => array('html'))),
        );
    }

    /**
     * @return string
     */
    public function getJsValidator()
    {
        $models = $this->getFactory()->processQueue();

        $result = array();
        foreach ($models as $model) {
            $result[] = 'FpJsFormValidatorFactory.initNewModel(' . $model . ');';
        }

        return '<script type="text/javascript">' . implode("\n", $result) . '</script>';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     * @codeCoverageIgnore
     */
    public function getName()
    {
        return 'fp_js_form_validator';
    }
}
