<?php


namespace Items\CsvGenerator;

use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class Mixin extends AbstractCsvGenerator
{
    protected
        $columns = array(
            'material1_id',
            'material2_id',
            'item_id'
        );


    public function execute ()
    {
        try {
            $container = new Container(new UtilityFactory);
            $filesystem = $container->get('FileSystem');
            $filesystem->makeTmp();

            $container = new Container(new ModelFactory);
            $im_table = $container->get('MixinTable');
            $data = $im_table->fetchAll();

            $csv = $this->buildCsv($data);

            $this->generateFile('/tmp/items/mixin.csv', $csv);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
