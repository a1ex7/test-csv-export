<?php
namespace App\Http\Transformers;

use Illuminate\Database\Eloquent\Model;

class CoursesToCsvTransformer implements ModelToCsvTransformer
{

    public function getHeaders()
    {
        return [
            'id',
            'course_name',
            'students_count'
        ];
    }

    /**
     * @param Model $data
     * @return array
     */
    public function transform(Model $data)
    {
        return [
            $data['id'],
            $data['course_name'],
            $data['students'],
        ];
    }
}