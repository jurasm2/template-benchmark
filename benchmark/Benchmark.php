<?php

/**
 * Benchmark for template engines
 */
class Benchmark {

    const TWIG = 'twig';
    const LATTE = 'latte';
    const SMARTY = 'smarty';


    /**
     * @var string
     */
    protected static $appDir;

    /**
     * @var string
     */
    protected static $cacheDir;

    /**
     * @var string
     */
    protected static $templateDir;

    /**
     * Constructor
     * @param string $appDir
     */
    public function __construct($appDir) {
        self::$appDir = $appDir;
        self::$cacheDir = $appDir . '/cache';
        self::$templateDir = $appDir . '/templates';
    }

    /**
     * Init TWIG template engine
     * @return Twig_Environment
     */
    protected function initTwig() {
        $loader = new Twig_Loader_Filesystem(self::$templateDir . '/twig/');
        $twig = new Twig_Environment($loader, array(
            'debug' => true,    // invalidate compiled template on modify the source
            'cache' => self::$cacheDir . '/twig/',
        ));
        return $twig;
    }

    /**
     * Init Smarty template engine
     * @return Smarty
     */
    protected function initSmarty() {
        $smarty = new Smarty();
        $smarty->setTemplateDir(self::$templateDir . '/smarty/');
        $smarty->setCompileDir(self::$cacheDir . '/smarty/');
        // enable default escaping
        $smarty->default_modifiers = array('escape:"htmlall"');
        return $smarty;
    }

    /**
     * Init Nette template with Latte filter
     * @return Nette\Templating\FileTemplate
     */
    protected function initLatte() {
        $template = new Nette\Templating\FileTemplate;
        $template->setCacheStorage(new Nette\Caching\Storages\PhpFileStorage(self::$cacheDir . '/latte/'));
        $template->registerHelperLoader('Nette\Templating\Helpers::loader');
        $template->onPrepareFilters[] = function ($template) {
            $template->registerFilter(new Nette\Latte\Engine);
        };
        return $template;
    }


    public function renderTitlePage() {
        $template = $this->initLatte();
        $template->setFile(self::$templateDir . '/latte/titlePage.latte');
        $engines = array(
            self::TWIG,
            self::LATTE,
            self::SMARTY,
        );
        $template->engines = $engines;
        echo $template;
    }

    /**
     * @param string $templateEngine
     */
    public function run($templateEngine) {

        $dangerousString = '--<Dangerous String -- >! = \'"';

        $data = array(
            'engine' => $templateEngine,
            'title' => 'Template benchmark',
            'content'  => file_get_contents(self::$appDir . '/lipsum'),
            'xssContent' => '<script>document.write(\'<h1 style="color: red;">XSS Attack!!!!\');</script>',

            'desc' => $dangerousString,
            'message' => $dangerousString,
            'userId' => $dangerousString,
            'color' => $dangerousString,
            'time' => $dangerousString,
            'attrib' => $dangerousString,
        );

        switch ($templateEngine) {
            case self::TWIG:
                $twig = $this->initTwig();
                echo $twig->render('test.twig', $data);
                break;
            case self::SMARTY:
                $smarty = $this->initSmarty();
                foreach ($data as $key => $value) {
                    $smarty->assign($key, $value);
                }
                echo $smarty->display('test.tpl');
                break;
            case self::LATTE:
                $template = $this->initLatte();
                $template->setFile(self::$templateDir . '/latte/test.latte');
                foreach ($data as $key => $value) {
                    $template->$key = $value;
                }
                echo $template;
                break;
            default:
                echo "No engine specified";
        }
    }

}


