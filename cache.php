<?php
require_once __DIR__."/vendor/autoload.php";
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\Cache\Adapter\TraceableAdapterEvent;
use Symfony\Component\Cache\CacheItem;

global $_CACHE;
register_shutdown_function(function(){
    if(isset($_GET['cacheId'])){
        clear_cache($_GET['cacheId'],isset($_GET['cacheParent']) ? $_GET['cacheParent'] : "default");
    }
});
function clear_cache(string $id,string $parent = "default"){
    global $_CACHE;
    foreach ($_CACHE as $key => $value) {
        if($key == $parent){
            $value->delete($id);
        }
    }
}
/**
 * @return AdapterInterface
 */
function get_cache(string $key = 'default'){
    global $_CACHE;
    return isset($_CACHE[$key]) ? $_CACHE[$key] : $_CACHE['default'];
}

class HostTraceableAdapter extends TraceableAdapter{
    const HOST = "HOST";

    /**
     * @var CacheItem
     */
    private $hostItem;

    /**
     * @var mixed
     */
    private $cItem;

    public function __construct(AdapterInterface $pool,array $data = [],callable $cItem = null)
    {
        $this->pool = $pool;
        $item = $this->getItem(self::HOST);
        if (!$item->isHit()) {
            $item->set($data);
            $item->expiresAfter(new DateInterval('P1Y'));
            $this->save($item);
        }
        $this->hostItem = $item;
        $this->cItem = $cItem;
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->update();
        parent::reset();
    }

    /**
     * {@inheritdoc}
     */
    protected function update()
    {
        $calls = $this->getCalls();
        $data = $this->hostItem->get();
        foreach ($calls as $event) {
            if($event instanceof TraceableAdapterEvent){
                $result = $event->result;
                $k = array_key_first($result);
                if($k == self::HOST) continue;
                if($event->name == "save"){
                    $c = $this->cItem;
                    if(is_callable($c)){
                        $data[$k] = $c($this,$k);
                    }else{
                        $data[$k] = [];
                    }
                }
                if($event->name == "deleteItem" || $event->name == "delete"){
                    unset($data[$k]);
                }
                if($event->name == "prune"){
                    unset($data[$k]);
                }
            }
        }
        $this->hostItem->set($data);
        return $this->hostItem;
    }

    public function __destruct()
    {
        $this->pool->save($this->update());
    }

    /**
     * Get the value of hostItem
     *
     * @return  CacheItem
     */ 
    public function getHostItem()
    {
        return $this->hostItem;
    }

    /**
     * Set the value of hostItem
     *
     * @param  CacheItem  $hostItem
     *
     * @return  self
     */ 
    public function setHostItem(CacheItem $hostItem)
    {
        $this->hostItem = $hostItem;

        return $this;
    }
}