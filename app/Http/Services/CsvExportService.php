<?php

namespace App\Http\Services;

use App\Http\Transformers\ModelToCsvTransformer;
use Illuminate\Support\Collection;
use League\Csv\Writer;

class CsvExportService
{

    /**
     * A function to generate a CSV for a given model collection.
     *
     * @param Collection $modelCollection
     * @param $tableName
     * @param ModelToCsvTransformer $transformer
     * @return string
     * @throws \League\Csv\CannotInsertRecord
     */
    public function createCsv(Collection $modelCollection, $tableName, ModelToCsvTransformer $transformer){

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(
            $transformer->getHeaders()
        );
        foreach ($modelCollection as $data){
            $csv->insertOne(
                $transformer->transform($data)
            );
        }

        $csv->output($tableName . '.csv');
    }
}