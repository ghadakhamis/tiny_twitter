<?php namespace App\Http\Repositories;

use App\Http\Models\Tweet;
use Czim\Repository\BaseRepository;

class TweetRepository extends BaseRepository {

    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Tweet::class;
    }
}