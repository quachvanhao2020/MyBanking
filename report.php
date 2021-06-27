<?php
require_once __DIR__."/vendor/autoload.php";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TelegramBotHandler;
use Monolog\Formatter\LineFormatter;
error_reporting(E_ALL);
ini_set('display_errors', '1');
define("TELEGRAM_REPORT_TOKEN",getenv('TELEGRAM_REPORT_TOKEN', true) ? getenv('TELEGRAM_REPORT_TOKEN') : "1780671851:AAGHb7XAlagNVjf5EhaKt4eeK8qBdFB-63s");
define("TELEGRAM_REPORT_CHAT_ID",getenv('TELEGRAM_REPORT_CHAT_ID', true) ? getenv('TELEGRAM_REPORT_CHAT_ID') : "-534245921");
global $log;
$formatter = new LineFormatter(LineFormatter::SIMPLE_FORMAT, LineFormatter::SIMPLE_DATE);
$formatter->includeStacktraces(true);
$handle = new TelegramBotHandler(TELEGRAM_REPORT_TOKEN,TELEGRAM_REPORT_CHAT_ID,Logger::ERROR);
$handle->setFormatter($formatter);
$log = new Logger(APP_NAME);
$log->pushHandler(new StreamHandler(__DIR__.'/log.log', Logger::WARNING));
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
