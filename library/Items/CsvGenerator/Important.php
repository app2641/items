<?php


namespace Items\CsvGenerator;

use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class Important extends AbstractCsvGenerator
{
    protected
        $columns = array(
            'id',
            'name',
            'description',
            'experience'
        );


    public function execute ()
    {
        try {
            $container = new Container(new UtilityFactory);
            $filesystem = $container->get('FileSystem');
            $filesystem->makeTmp();

            $container = new Container(new ModelFactory);
            $im_table = $container->get('ImportantTable');
            $data = $im_table->fetchAll();

            $csv = $this->buildCsv($data);

            $this->generateFile('/tmp/items/important.csv', $csv);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
