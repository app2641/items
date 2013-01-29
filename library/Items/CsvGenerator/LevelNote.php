<?php


namespace Items\CsvGenerator;

use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class LevelNote extends AbstractCsvGenerator
{
    protected
        $columns = array(
            'id',
            'level',
            'note'
        );


    public function execute ()
    {
        try {
            $container = new Container(new UtilityFactory);
            $filesystem = $container->get('FileSystem');
            $filesystem->makeTmp();

            $container = new Container(new ModelFactory);
            $im_table = $container->get('LevelNoteTable');
            $data = $im_table->fetchAll();

            $csv = $this->buildCsv($data);

            $this->generateFile('/tmp/items/levelnote.csv', $csv);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
