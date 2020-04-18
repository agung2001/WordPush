<?php

namespace Wordpush\Controller;

/**
 * Collection of database migration methods
 * @package wordpush
 */

use Wordpush\Model\Database;

class Migration
{

    /**
     * @access   protected
     * @var      array $config Main app config
     */
    protected $config;

    /**
     * @access   protected
     * @var      object $db Database object
     */
    protected $db;

    /**
     * @access   protected
     * @var      array $url Migration url
     */
    protected $url = [];

    /**
     * @access   protected
     * @var      string $status Migration run status
     */
    protected $status;

    /**
     * Migration constructor
     * @return void
     * @var    array $setting Config
     */
    public function __construct($setting)
    {
        $this->db = new Database($setting['database']);
        $this->config = $setting['config'];
    }

    /**
     * Find database information
     * @return void
     * @var    array $config Config
     */
    public function findDBInfo($config)
    {
        $this->db->setName($config['name']);
        $this->db->reconnect();
        $this->db->setPrefixFromDB();
        $this->setUrlFromDB();
    }

    /**
     * Grab url from selected database
     * @return void
     */
    public function setUrlFromDB()
    {
        try {
            $pdo = $this->db->getConn();
            $sql = "SELECT option_value FROM " . $this->db->getPrefix() . "_options WHERE option_name = 'siteurl' LIMIT 1;";
            $url = $pdo->prepare($sql);
            $url->execute();
            $url = $url->fetch($pdo::FETCH_ASSOC);
            $this->url['from'] = $url['option_value'];
        } catch(\Exception $e) {
            die('Oops, something when wrong!');
        }
    }

    /**
     * Build migration app, load view and setup logic
     * @return void
     */
    public function build()
    {
        $view = new View($this, $this->config);
        $view->setView('migration.build');
        $view->build();
    }

    /**
     * Run migration
     * @return void
     * @var    array $config Config
     */
    public function migrate($config)
    {
        try {
            if (!$config['prefix'] || !$config['url_from'] || !$config['url_to']) die("Can't migrate field incomplete!");
            $this->db->setName($config['name']);
            $this->db->setPrefix($config['prefix']);
            $this->db->reconnect();
            $pdo = $this->db->getConn();
            $sql = "UPDATE " . $this->db->getPrefix() . "_options SET option_value = replace(option_value, '" .
                $config['url_from'] . "', '" . $config['url_to'] . "') WHERE option_name = 'home' OR option_name = 'siteurl' ";
            $url = $pdo->prepare($sql);
            $url->execute();
            $this->url['from'] = $config['url_from'];
            $this->url['to'] = $config['url_to'];
            $this->status = 'SUCCESS!';
        } catch(\Exception $e){
            die('Oops, something when wrong!');
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return object
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param object $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return array
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param array $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}
