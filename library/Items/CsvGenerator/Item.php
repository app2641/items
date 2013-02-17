<?php


namespace Items\CsvGenerator;

use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class Item extends AbstractCsvGenerator
{
    protected
        // csvのカラム
        $columns = array(
            'id',
            'name',
            'description',
            'class',
            'price',
            'exp',
            'experience',
            'is_active',
            'date',
            'last_date',
            'qty'
        );


    public function execute ()
    {
        try {
            $container = new Container(new UtilityFactory);
            $filesystem = $container->get('FileSystem');
            $filesystem->makeTmp();

            $container = new Container(new ModelFactory);
            $im_table = $container->get('ItemTable');
            $data = $im_table->fetchAll();

            $csv = $this->buildCsv($data);

            $this->generateFile('/tmp/items/item.csv', $csv);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
