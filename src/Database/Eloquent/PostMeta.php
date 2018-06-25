<?php

namespace Tanwencn\Blog\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Tanwencn\Blog\Database\Eloquent\Datas\Metas;

class PostMeta extends Model
{
    use Metas;

    protected $table = 'content_metas';
}