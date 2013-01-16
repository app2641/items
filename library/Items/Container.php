<?php


namespace Items;

use Items\Factory\AbstractFactory;

class Container
{
    protected
        $factory,
        $objects = array();

    public function __construct (AbstractFactory $factory)
    {
        $this->factory = $factory;
        $factory->accept($this);
    }


    // インスタンスを取得するメソッド
    // 取得するインスタンスは指定したFactoryのbuild{$name}メソッドで定義をする
    public function get ($name)
    {
        if (! isset($this->objects[$name])) {
            $this->objects[$name] = $this->factory->get($name);
        }

        return $this->objects[$name];
    }
}

