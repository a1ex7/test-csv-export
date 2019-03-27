<?php
namespace App\Http\Transformers;

use Illuminate\Database\Eloquent\Model;

class StudentToCsvTransformer implements ModelToCsvTransformer
{

    public function getHeaders()
    {
        return [
            'id',
            'firstname',
            'surname',
            'email',
            'university',
            'course_name'
        ];
    }

    public function transform(Model $data)
    {
        return [
            $data['id'],
            $data['firstname'],
            $data['surname'],
            $data['email'],
            $data['course']['university'],
            $data['course']['course_name'],
        ];
    }
}