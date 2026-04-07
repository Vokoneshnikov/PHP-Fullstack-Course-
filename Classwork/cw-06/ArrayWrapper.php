<?php

class ArrayWrapper{
    public function __construct(private array $array) {}

    public function __get(string $name): mixed {
        return $this->array[$name] ?? null;
    }
    public function __set(string $name, mixed $value) : void{
        $this->array[$name] = $value;
    }
    public function __isset(string $name) : bool {
        return isset($this->array[$name]);
    }
    public function __unset(string $name) : void {
        unset($this->array[$name]);
    }
    public function __tostring() : string{
        return json_encode($this->array);
    }
    public function __invoke(?string $name = null) : mixed {
        if ($name === null) {
            return $this->array;
        }
        return $this->array[$name];
    }
    public function __clone() {
        $newArray = [];
        foreach ($this->array as $key => $item) {
            if (is_object($item)) {
                $newArray[$key] = clone $item;
            } else {
                $newArray[$key] = $item;
            }
        }
        $this->array = $newArray;
    }
}
