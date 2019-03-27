<?php

namespace App\Http\Transformers;


use Illuminate\Database\Eloquent\Model;

interface ModelToCsvTransformer
{
    public function getHeaders();

    public function transform(Model $model);
}