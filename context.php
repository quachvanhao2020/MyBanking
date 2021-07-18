<?php
use Omnipay\PayPalv2\PayContext;
require_once __DIR__."/index.php";
$context = isset($_POST['context']) ? $_POST['context'] : null;
if(!is_array($context)) return;
release(PayContext::fromIpContext($context));