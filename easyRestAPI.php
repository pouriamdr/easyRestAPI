<?php
class easyR {
    public $useFilter = FALSE;
    public $saveLogs = FALSE;
    public $defaultLogFile = 'easyR.log';
    public $responses = array(
        "OK" => array(
            "code" => 0,
            "message" => "Ok"
        ),
        "SUCCESS" => array(
            "code" => 1,
            "message" => "Operation successful"
        ),
        "ERROR" => array(
            "code" => 3,
            "message" => "An error occurred"
        ),
        "INTERNAL-ERROR" => array(
            "code" => 4,
            "message" => "Internal error, try again later"
        ),
        "AUTH-ERROR" => array(
            "code" => 5,
            "message" => "Authentication failed because of an uknown error, try again later"
        ),
        "ACCESS-DENIED" => array(
            "code" => 6,
            "message" => "Access denied"
        ),
        "FAILOR" => array(
            "code" => 7,
            "message" => "Operation failed"
        ),
        "AUTH-FAILOR" => array(
            "code" => 8,
            "message" => "Authentication failed"
        ),
        "BAD-REQUEST" => array(
            "code" => 9,
            "message" => "Bad request"
        )
    );
    private $inputs = array();
    public function __construct() {
        foreach ($_POST as $key => $value) {
            array_merge($inputs,
                array(
                    $this->filter($key) => array(
                        "value" => $this->filter($value),
                        "method" => "POST"
                    )
                )
            );
        }
        foreach ($_GET as $key => $value) {
            array_merge($inputs,
                array(
                    $this->filter($key) => array(
                        "value" => $this->filter($value),
                        "method" => "GET"
                    )
                )
            );
        }
        $this->saveLogs();
    }
    private function filter($inp) {
        if($this->useFilter === TRUE) return htmlspecialchars($inp);return $inp;
    }
    private function saveLogs() {
        if($this->saveLogs === FALSE)
            return FALSE;
        $method = 'Uknown';
        if( count($_POST) > 0 ) {
            $method = 'POST';
        }
        if( count($_GET) > 0 ) {
            if( $method == 'Uknow')
                $method = 'GET';
            else
                $method .= ' and GET';
        }
        $fp = fopen($this->defaultLogFile, 'a');
        fwrite($fp, 
            sprintf("Remote ip %s, %s , Method %s", 
                $_SERVER['REMOTE_ADDR'],
                date('Y-m-d H:i:s'),
                $method
            )
        );
        fwrite($file, PHP_EOL);
        fclose($fp);
    }
    public function response($res = '-', $type = 'text') {
        switch ($type) {
            case 'json':
                header("Content-type:application/json");
                break;
            default:
                header("Content-type:text/html; charset=UTF-8");
                break;
        }
        if($res == '-' || is_numeric($res)) {
            echo $res;
            return true;
        }
        if(is_array($res)) {
            echo json_decode($res);
            return true;
        }
        if(isset($this->responses[$res])) {
            echo json_decode($this->responses[$res]);
        } else {
            if($type == 'text')
                echo $res;
            else
                echo json_decode($this->responses['INTERNAL-ERROR']);
        }
        return true;
    } 
}
?>
