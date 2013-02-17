<?php


namespace Items\CsvGenerator;

use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class Material extends AbstractCsvGenerator
{
    protected
        $columns = array(
            'id',
            'name',
            'description',
            'class',
            'price',
            'rarity',
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
            $im_table = $container->get('MaterialTable');
            $data = $im_table->fetchAll();

            $csv = $this->buildCsv($data);

            $this->generateFile('/tmp/items/material.csv', $csv);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
