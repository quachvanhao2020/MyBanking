<?php
require_once __DIR__."/../vendor/autoload.php";
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
global $_IP;

define("POLICE_THE_TIMER",getenv('POLICE_THE_TIMER', true) ? intval(getenv('POLICE_THE_TIMER')) : 5);
define("POLICE_LIMIT_REQUEST",getenv('POLICE_LIMIT_REQUEST', true) ? intval(getenv('POLICE_LIMIT_REQUEST')) : 10);
define("POLICE_TIME_RELEASE",getenv('POLICE_TIME_RELEASE', true) ? intval(getenv('POLICE_TIME_RELEASE')) : 120);
!defined("POLICE_AWAKE") && define("POLICE_AWAKE",getenv('POLICE_AWAKE', true) ? intval(getenv('POLICE_AWAKE')) : true);
define("POLICE_TOKEN",getenv('POLICE_TOKEN', true) ? getenv('POLICE_TOKEN') : "ngan");

(function(){if(POLICE_AWAKE){
    guard();
}})();

function guard(callable $callable = null){
    global $_IP;
    if(!$callable){
        $callable = function($data){
            if(isset($data['reason'])){
                echo $data['reason']."\n\r";
            }
            echo "Limited!";
            die();
        };
    }
    $cache = guard_cache();
    $ip = get_client_ip();
    $_IP = $ip;
    guard_range($ip);
    $ipHash = base64_encode($ip);
    $item = $cache->getItem($ipHash);
    $value = $item->get();
    if(!is_array($value)) $value = [
        'index' => 0,
        'status' => "",
    ];
    if($value['index'] >= POLICE_LIMIT_REQUEST){
        $value['status'] = "block";
        $item->set($value);
        $item->expiresAfter(new \DateInterval(sprintf('PT%dM',POLICE_TIME_RELEASE)));
        $cache->save($item);
        return $callable($value);
    };
    if($value['status'] == "block"){
        $item->expiresAfter(new DateInterval('P1Y'));
        $cache->save($item);
        return $callable($value);
    }
    $value['index'] = $value['index']+1;
    $value['ip'] = $ip;
    $item->set($value);
    $cache->save($item);
}

function guard_range($ip){
    $cache = guard_sys_cache();
    $item = $cache->getItem("ranges");
    $data = $item->get();
    if(is_array($data)){
        foreach ($data as $value) {
            if(ip_in_range($ip,$value)) return true;
        }
    }else{
        return;
    }
    echo "Block!";
    die();
}

function guard_cache(){
    $cache = new HostTraceableAdapter(new FilesystemAdapter('',POLICE_THE_TIMER,__CACHE__),[],function(HostTraceableAdapter $cache,$k){
        $i = $cache->getItem($k);
        $data = $i->get();
        return [
            'ip' => $data['ip'],
            'status' => $data['status'],
        ];
    });
    return $cache;
}

function guard_sys_cache(){
    $cache = new FilesystemAdapter('sys',0,__CACHE__);
    return $cache;
}

function open_guard(){
    if(isset($_GET['token'])){
        if($_GET['token'] == POLICE_TOKEN){
            if(isset($_GET['action'])){
                $action = $_GET['action'];
                if($action == "view"){
                    $cache = guard_cache();
                    $item = $cache->getHostItem();
                    $ips = $item->get();
                    render_ips($ips);
                    return;
                }
                if($action == "set"){
                    $cache = guard_sys_cache();
                    $item = $cache->getItem("ranges");
                    if (!$item->isHit()) {
                        $item->set(["0.0.0.0/0"]);
                        $item->expiresAfter(new DateInterval('P1Y'));
                        $cache->save($item);
                    }
                    $ranges = $item->get();
                    if(isset($_POST['ranges'])){
                        $_ranges = $_POST['ranges'];
                        $ranges = explode(",",$_ranges);
                        $item->set($ranges);
                        $cache->save($item);
                    }                    
                    render_ranges($ranges);
                    return;
                }
                $ip = isset($_GET['ip']) ? $_GET['ip'] : null;
                if($ip){
                    $message = isset($_GET['message']) ? $_GET['message'] : "";
                    $ipHash = base64_encode($ip);
                    $cache = guard_cache();
                    $item = $cache->getItem($ipHash);
                    switch ($action) {
                        case 'block':
                            $item->set([
                                'ip' => $ip,
                                'index' => 0,
                                'status' => "block",
                                'reason' => $message,
                            ]);
                            echo "Blocked {$ip}";
                            break;
                            case 'release':
                                $cache->delete($ipHash);
                                echo "Released {$ip}";
                                return;
                                break;
                        default:
                            break;
                    }
                    $cache->save($item);
                }
            }
        }
    }
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

/**
 * Check if a given ip is in a network
 * @param  string $ip    IP to check in IPV4 format eg. 127.0.0.1
 * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
 * @return boolean true if the ip is in this range / false if not.
 */
function ip_in_range( $ip, $range ) {
    if ( strpos( $range, '/' ) === false ) {
        $range .= '/32';
    }
    // $range is in IP/CIDR format eg 127.0.0.1/24
    list( $range, $netmask ) = explode( '/', $range, 2 );
    $range_decimal = ip2long( $range );
    $ip_decimal = ip2long( $ip );
    $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
    $netmask_decimal = ~ $wildcard_decimal;
    return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
}

function get_location(){
    $ip = get_client_ip();
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    return $details;
}

function render_ranges($ranges){
?>
<!DOCTYPE html>
<html>
<head>
<style>
body {
    text-align: center;
}
form {
    display: inline-block;
}
</style>
</head>
<body>
<h2>HTML Table</h2>
<form action="" method="POST" >
  <label>Ranges:</label><br>
  <input style="width: 320px;"  type="text" name="ranges" value="<?= implode(",",$ranges) ?>"><br>
  <input type="submit" value="Submit">
</form>
</body>
</html>
<?php
}

function render_ips(array $ips){
?>
<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>HTML Form</h2>
<table>
  <tr>
    <th>Ip</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  <?php foreach ($ips as $key => $value) { $ip = $value['ip']; $status = $value['status']; ?>
  <tr>
    <td><?= $value['ip'] ?></td>
    <td><?= $status ?></td>
    <?php if($status == "block"){ ?>
    <td><a href="?token=<?= POLICE_TOKEN ?>&action=release&ip=<?=$ip?>">Release</a></td>
    <?php };?>
    <?php if($status == ""){ ?>
    <td><a href="?token=<?= POLICE_TOKEN ?>&action=block&ip=<?=$ip?>">Block</a></td>
    <?php };?>
  </tr>
  <?php };?>
</table>
</body>
</html>
<?php
}