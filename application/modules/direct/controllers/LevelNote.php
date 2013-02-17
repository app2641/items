<?php


use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class LevelNote
{
    protected
        $container;

    public function __construct ()
    {
        $this->container = new Container(new ModelFactory);
    }


    /**
     * csvを生成する
     *
     * @author app2641
     **/
    public function generateCsv ()
    {
        $container = new Container(new UtilityFactory);
        $generator = $container->get('LevelNoteCsvGenerator');
        $generator->execute();

        return array('success' => true, 'name' => 'level_note');
    }
}
