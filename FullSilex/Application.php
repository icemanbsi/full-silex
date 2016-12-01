<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com)
 * Date: 7/15/16
 * Time: 10:31 AM
 */

namespace FullSilex;

use Silex\Application as SilexApplication;
use ActiveRecord\Config as ActiveRecordConfig;
use Silex\Application\UrlGeneratorTrait;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class Application extends SilexApplication
{
    use SilexApplication\TranslationTrait, UrlGeneratorTrait;

    protected static $_instance     = null;

    // OPTIONS
    protected $useDatabase          = true;
    protected $useMailer            = true;
    protected $useTranslator        = true;
    protected $useTemplateEngine    = true;
    protected $useSession           = true;

    // need to override
    protected function setControllerProviders(){
        // example
        // $this->mount('/', new DefaultControllerProvider());
    }

    protected function additionalTwigFilter(){
        //for more info please visit http://twig.sensiolabs.org/doc/advanced.html#filters
        return array(
            // new Twig_SimpleFilter('rot13', function ($string) {
            //     return str_rot13($string);
            // }),
            // new Twig_SimpleFilter('rot13', 'str_rot13'),
            // new Twig_SimpleFilter('rot13', array('SomeClass', 'rot13Filter'))
        );
    }

    protected function additionalTwigFunction(){
        //for more info please visit http://twig.sensiolabs.org/doc/advanced.html#functions
        return array(
            // new Twig_SimpleFunction('rot13', function ($string) {
            //     return str_rot13($string);
            // }),
            // new Twig_SimpleFunction('rot13', 'str_rot13'),
            // new Twig_SimpleFunction('rot13', array('SomeClass', 'rot13Function'))
        );
    }

    protected function getSMTPConfig(){
        return $this->config("smtp");
    }

    protected $env;
    protected $config = array();
    protected $repositories = array();

    public function __construct($env)
    {
        self::$_instance = $this;

        $this->env = $env;

        parent::__construct();

        $app = $this;

        $configFile = sprintf('%s/resources/config/%s.php', $this->getRootDir(), $env);
        if (!file_exists($configFile)) {
            throw new \RuntimeException(sprintf('The file "%s" does not exist.', $configFile));
        }
        $_config = array();
        require $configFile;

        $this->config = $_config;

        if($this->useDatabase) {
            $this->setupActiveRecord();
        }

        if($this->useSession) {
            $app->register(new SessionServiceProvider());
        }

//        $app->register(new HttpCacheServiceProvider());

//        $app->register(new ValidatorServiceProvider());
//        $app->register(new FormServiceProvider());
//        $app->register(new UrlGeneratorServiceProvider());
//        $app->register(new DoctrineServiceProvider());
//
//        $app->register(new SecurityServiceProvider(), array(
//            'security.firewalls' => array(
//                'admin' => array(
//                    'pattern' => '^/',
//                    'form' => array(
//                        'login_path' => '/login',
//                    ),
//                    'logout' => true,
//                    'anonymous' => true,
//                    'users' => $app['security.users'],
//                ),
//            ),
//        ));
//        $app['security.encoder.digest'] = $app->share(function ($app) {
//            return new PlaintextPasswordEncoder();
//        });
//        $app['security.utils'] = $app->share(function ($app) {
//            return new AuthenticationUtils($app['request_stack']);
//        });


        if ($this->useTranslator) {
            $app->register(new \Silex\Provider\LocaleServiceProvider());
            $app->register(new \Silex\Provider\TranslationServiceProvider(), array(
                'locale_fallbacks' => array($this->config("defaultLanguage")),
            ));
            $app->extend('translator', function ($translator, $app) {
                $translator->addLoader('yaml', new YamlFileLoader());
                return $translator;
            });
        }

        $app->register(new MonologServiceProvider(), array(
            'monolog.logfile' => $this->getRootDir() . '/logs/' . $this->getEnv() . '.log',
            'monolog.level' => $app["debug"] ? "DEBUG" : "ERROR"
        ));


        if($this->useTemplateEngine) {
            $app->register(new TwigServiceProvider(), array(
                'twig.path' => $this->setTemplateDirectories(),
            ));

            $app->extend('twig', function($twig, $app) {

                $twig->addFunction(new \Twig_SimpleFunction(
                    'baseUrl',
                    array('\FullSilex\Twig\Functions\UrlFunction', 'baseUrl'),
                    array(
                        "needs_context" => true
                    )
                ));
                $twig->addFunction(new \Twig_SimpleFunction(
                    'publicUrl',
                    array('\FullSilex\Twig\Functions\UrlFunction', 'publicUrl'),
                    array(
                        "needs_context" => true
                    )
                ));
                if($this->useTranslator) {
                    $twig->addFilter(new \Twig_SimpleFilter(
                        'modelTranslator',
                        array('\FullSilex\Twig\Filters\TranslatorFilter', 'modelTranslator'),
                        array(
                            "needs_context" => true
                        )
                    ));
                }

                foreach($this->additionalTwigFilter() as $filter){
                    $twig->addFilter($filter);
                }
                foreach($this->additionalTwigFunction() as $function){
                    $twig->addFunction($function);
                }


                return $twig;
            });
        }


        if ($this->useMailer) {
            $app->register(new SwiftmailerServiceProvider());
            $smtpConfig = $this->getSMTPConfig();
            $app['swiftmailer.options'] = array(
                'host' => $smtpConfig['host'],
                'port' => $smtpConfig['port'],
                'username' => $smtpConfig['username'],
                'password' => $smtpConfig['password'],
                'encryption' => $smtpConfig['encryption'],
                'auth_mode' => $smtpConfig['auth_mode']
            );
        }

        $this->setControllerProviders();
    }

    public function isUseDatabase(){
        return $this->useDatabase;
    }
    public function isUseMailer(){
        return $this->useMailer;
    }
    public function isUseTranslator(){
        return $this->useTranslator;
    }
    public function isUseTemplateEngine(){
        return $this->useTemplateEngine;
    }
    public function isUseSession(){
        return $this->useSession;
    }

    public static function getInstance(){
        return self::$_instance;
    }

    public function getRootDir()
    {
        return BASEPATH;
    }

    public function getPublicDirectory(){
        return 'public';
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function config($name){
        if(isset($this->config[$name])){
            return $this->config[$name];
        }
        else{
            return null;
        }
    }

    public function setTemplateDirectories(){
        return array($this->getRootDir() . '/resources/views');
    }

    protected function setupActiveRecord(){
        $cfg = ActiveRecordConfig::instance();
        $cfg->set_model_directory(__DIR__ . '/Models');
        switch(strtolower($this->getEnv())){
            case "test":
                $env = "test";
                break;
            case "prod":
                $env = "production";
                break;
            default :
                $env = "development";
        }
        $dbConfig = $this->config("dbConfig");
        if ($dbConfig["type"] == "mysql") {
            $cfg->set_connections(
                array(
                    $env => 'mysql://' . $dbConfig["username"] . ':' . $dbConfig["password"] . '@' . $dbConfig["host"] . ':' . $dbConfig["port"] . '/' . $dbConfig["dbName"]
                )
            );
        }
        else if ($dbConfig["type"] == "pgsql") {
            $cfg->set_connections(
                array(
                    $env => 'pgsql://' . $dbConfig["username"] . ':' . $dbConfig["password"] . '@' . $dbConfig["host"] . ':' . $dbConfig["port"] . '/' . $dbConfig["dbName"]
                )
            );
        }

        $cfg->set_default_connection($env);
        \ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
    }

    /**
     * @param $repositoryStr
     * @return \App\Models\Repositories\BaseRepository
     */
    public function getRepository($repositoryStr){
        $repository = null;
        if (!empty($this->repositories[$repositoryStr])) {
            /* @var $repository \App\Models\Repositories\BaseRepository */
            $repository = $this->repositories[$repositoryStr];
        }
        else {
            $completeRepositoryStr = 'App\Models\Repositories\\' . ucfirst($repositoryStr) . "Repository";
            $repository = new $completeRepositoryStr($this);
            $this->repositories[$repositoryStr] = $repository;
        }
        return $repository;
    }

    /**
     * @param String $modelName
     * @param Array $attributes
     * @return \App\Models\BaseModel
     */
    public function createModel($modelName, $attributes = array()){
        if(strpos($modelName, '\\') === false) {
            $completeModelName = 'App\Models\\' . ucfirst($modelName);
        }
        else {
            $completeModelName = $modelName;
        }
        /** @var \App\Models\BaseModel $model */
        $model = new $completeModelName($attributes);
        $model->setApp($this);
        return $model;
    }

    public function getTemplateEngine() {
        return $this['twig'];
    }

    public function getMailer() {
        return $this['mailer'];
    }

    public function getTranslator(){
        return $this['translator'];
    }

    public function log($message){
        $this['monolog']->addDebug($message);
    }

    public function getSession(){
        return $this["session"];
    }

    public function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function getLanguage(){
        if(empty($_SESSION["_lang"])){
            $_SESSION["_lang"] = $this->config("defaultLanguage");
        }

        return $_SESSION["_lang"];
    }

    public function setLanguage($lang){
        $this->getTranslator()->setLocale($lang);
        $_SESSION["_lang"] = $lang;
    }

    public function addLanguageFile($path, $lang){
        $filePath = $this->getRootDir() . '/resources/translations/' . $this->getLanguage() . '/'. $path . '.yml';
        if(file_exists($filePath)) {
            $this->getTranslator()->addResource('yaml', $filePath, $lang);
        }
    }

    public function getBasePath(){
        return BASEPATH . DIRECTORY_SEPARATOR;
    }

    public function getPublicBasePath(){
        return BASEPATH . DIRECTORY_SEPARATOR . $this->getPublicDirectory() . DIRECTORY_SEPARATOR;
    }

    public function getBaseUrl(){
        return $this->url("homepage") . "/";
    }

    public function getPublicBaseUrl(){
        return $this->url("homepage") . "/" . $this->getPublicDirectory() . "/";
    }
}