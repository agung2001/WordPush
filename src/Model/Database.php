<?php

namespace Wordpush\Model;

/**
 * Collection of database methods function
 * @package wordpush
 */

class Database {

	/**
	 * Used to connect to server
     * @access   protected
	 * @var      object    $pdo    PHP Database Object
	 */
	protected $pdo;

	/**
     * Used to connect to a specific database
	 * @access   protected
	 * @var      object    $conn    Database connection object
	 */
	protected $conn;

	/**
	 * @access   protected
	 * @var 	string 	$host    Database host
	 */
	protected $host;

	/**
	 * @access   protected
	 * @var 	string 	$name    Database name
	 */
	protected $name;

	/**
	 * @access   protected
	 * @var 	string 	$username    Database connection username
	 */
	protected $username;

	/**
	 * @access   protected
	 * @var 	string 	$username    Database connection username
	 */
	protected $password;

    /**
     * @access   protected
     * @var 	string 	$prefix    Database table prefix
     */
    protected $prefix;

	/**
	 * Databse constructor
	 * @return void
	 * @var    array   $config     Config
	 */
	public function __construct($config){
		$this->host			= $config['host'];
		$this->username 	= $config['username'];
		$this->password 	= $config['password'];
        $this->reconnect();
	}

	/**
	 * Connect to a database
	 * @return void
	 */
	public function reconnect(){
	    $connString = "mysql:host=" . $this->host;
	    try {
            $this->pdo = new \PDO( $connString, $this->username, $this->password );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            if($this->name){
                $this->conn = new \PDO( $connString . ";dbname=" . $this->name , $this->username, $this->password );
                $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        } catch(PDOException $e){
            die ('Connection failed: ' . $e->getMessage());
        }
	}

    /**
     * Show all databases in hosts
     * @return void
     */
    public function getDatabases(){
        $pdo = $this->pdo;
        $databases = $pdo->prepare("SHOW DATABASES;");
        $databases->execute();
        $databases = $databases->fetchAll($pdo::FETCH_NUM);
        foreach($databases as &$database)
            $database = $database[0];
        return $databases;
    }

    /**
     * Show all databases in hosts
     * @return void
     */
    public function getTables(){
        $pdo = $this->pdo;
        $statement = $pdo->prepare("SHOW TABLES FROM $this->name;");
        $statement->execute();
        $tables    = $statement->fetchAll($pdo::FETCH_NUM);
        foreach($tables as &$table)
            $table = $table[0];
        return $tables;
    }

    /**
     * Set database table prefix
     * @return string Database table prefix
     */
    public function setPrefixFromDB(){
        foreach($this->getTables() as $table){
            $prefix = explode('_', $table);
            if(isset($prefix[1])){
                if($this->prefix==$prefix[0]) break;
                else $this->prefix = $prefix[0];
            }
        }
    }

	/**
	 * Execute query to a dabatase
	 * @return void
	 * @var		string $sql		SQL Query String
	 */
	public function execute($sql){
		if ($this->conn->query($sql)) {
//			return $this->conn->query($sql)->fetch_assoc();
//			return $this->conn->insert_id;
//			return $this->conn->query($sql);
			return $this->conn;
		} else {
			die('Error: ' . $sql . '<br>' . $this->conn->error);
		}
	}

	/**
	 * @return object
	 */
	public function getPdo()
	{
		return $this->pdo;
	}

	/**
	 * @param object $pdo
	 */
	public function setPdo($pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * @return object
	 */
	public function getConn()
	{
		return $this->conn;
	}

	/**
	 * @param object $conn
	 */
	public function setConn($conn)
	{
		$this->conn = $conn;
	}

	/**
	 * @return string
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * @param string $host
	 */
	public function setHost($host)
	{
		$this->host = $host;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

}
