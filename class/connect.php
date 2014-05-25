<?
    class connect
    {
        public $conn;
        public $errormsg;
        public $succeed;
        
       public function __construct()
       {
            try 
            {
                $this->conn= new PDO("mysql:host=localhost;dbname=dynamictree","root","");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("SET NAMES cp1256");
                $this->succeed=true;
                return $this->conn;
                
            }
            catch(PDOException $e)
            {
               $this->errormsg=$e->getMessage();
               $this->succeed=false;
               die("Could not Connect to Database!");
               return false;
                
            }
        
        
       } 
        
      
        
        
    }
    
    $db= new connect();
?>