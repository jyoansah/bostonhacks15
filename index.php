<!DOCTYPE html>
<head>
	<title>
		I hate queues!
	</title>
</head>
<body>
<?php
class Database
{
    private static $dbName = 'deeque' ;
    private static $dbHost = 'c3185u2dmj.database.windows.net' ;
    private static $dbUsername = 'deeque';
    private static $dbUserPassword = 'ASdf1234!';

    private static $cont  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if ( null == self::$cont )
        {
            try
            {
                self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }

        echo("connected");

        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
</body>
</html>