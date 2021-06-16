<?php
require_once __DIR__."/vendor/autoload.php";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TelegramBotHandler;
use Monolog\Formatter\LineFormatter;
error_reporting(E_ALL);
ini_set('display_errors', '1');
global $log;
$formatter = new LineFormatter(LineFormatter::SIMPLE_FORMAT, LineFormatter::SIMPLE_DATE);
$formatter->includeStacktraces(true);
$handle = new TelegramBotHandler('1748527134:AAFX6J8l08_xt_DEm5kuxnxEw4hVKP9vGZ0','-534245921',Logger::ERROR);
$handle->setFormatter($formatter);
$log = new Logger(APP_NAME);
$log->pushHandler(new StreamHandler('log.log', Logger::WARNING));
$log->pushHandler($handle);

class PHPErrorException extends Exception
{
    private $context = null;
    public function __construct
        ($code, $message, $file, $line, $context = null)
    {
        parent::__construct($message, $code);
        $this->file = $file;
        $this->line = $line;
        $this->context = $context;
    }
};

function error_handler($code, $message, $file, $line) {
    throw new PHPErrorException($code, $message, $file, $line);
}

function exception_handler(Throwable $e)
{   
    global $log;
    $log->error($e);
}
set_error_handler('error_handler');
set_exception_handler('exception_handler');
