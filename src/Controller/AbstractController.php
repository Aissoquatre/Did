<?php

namespace Did\Controller;

use Did\Kernel\Environment;
use ReflectionClass;
use Twig\Environment as TwigEnvironment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Class AbstractController
 *
 * @package Did\Controller
 * @author Julien Bernard <hello@julien-bernard.com>
 */
abstract class AbstractController
{
    /**
     * @var TwigEnvironment
     */
    private $twig;

    /**
     * @var ReflectionClass
     */
    private $reflectionClass;

    /**
     * @var array
     */
    private $templateParams;

    /**
     * @var string
     */
    protected $bundleName;

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        $this->reflectionClass = new ReflectionClass($this);
        $this->bundleName      = substr(
            strstr(
                substr($this->reflectionClass->getNamespaceName(), 0, -12),
                '\\'
            ),
            1
        );
        $this->twig            = new TwigEnvironment(
            new FilesystemLoader(Environment::get()->findVar('TWIG_TEMPLATES_DIR')), [
                'cache' => (Environment::get()->findVar('APP_ENV') === 'prod') ? Environment::get()->findVar('TWIG_CACHE') : false,
                'debug' => (Environment::get()->findVar('APP_ENV') === 'prod') ? false : true,
            ]
        );

        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('_session', $_SESSION);
        $this->twig->addGlobal('_post', $_POST);
        $this->twig->addGlobal('_get', $_GET);
    }

    /**
     * @param string $templateName
     * @param array $vars
     * @return AbstractController
     */
    public function _load(string $templateName, $vars = []): AbstractController
    {
        $this->templateParams = [
            'templateName' => $this->bundleName . '/Views/' . $templateName . '.twig',
            'vars' => $vars
        ];
        return $this;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return $this->twig->render($this->templateParams['templateName'], $this->templateParams['vars']);
    }

    /**
     * Display html in page
     */
    public function display()
    {
        echo $this->twig->render($this->templateParams['templateName'], $this->templateParams['vars']);
    }
}