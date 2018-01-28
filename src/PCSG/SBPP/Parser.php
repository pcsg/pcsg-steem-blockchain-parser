<?php

namespace PCSG\SBPP;

/**
 * Class Parser
 *
 * @package PCSG\SBPP
 */
class Parser
{

    protected $RPCClient;

    /** @var Database */
    protected static $Database = null;
    
    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $this->RPCClient = new RPCClient();

        // TODO Test DB connectivity
    }

    public function parseSingleBlock($blockID)
    {
        $Block = new Block($blockID);
        $Block->parse();

    }

    public function parseBlockRange($startBlock, $endBlock)
    {
    }

    /**
     * Returns the database handler
     * @return Database
     */
    public static function getDatabase()
    {
        if(!is_null(self::$Database)){
            return self::$Database;
        }
        
        self::$Database = new Database();
        
        return self::$Database;
    }
}