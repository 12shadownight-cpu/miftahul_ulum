<?php
class ClassName {
    // Properties
    public $prop1;
    private $prop2;

    // Constructor
    public function __construct($param) {
        $this->prop1 = $param;
    }

    // Method
    public function doSomething() {
        // Code
    }

    // Getter
    public function getProp2() {
        return $this->prop2;
    }

    // Setter
    public function setProp2($value) {
        $this->prop2 = $value;
    }
}
?>