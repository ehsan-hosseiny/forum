<?php


namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelRepository
{

    /**
     * All Channel list
     */
    public function all()
    {
        return Channel::all();
    }

    /**
     * Create New Channel
     * @param $name
     */
    public function create($name):void
    {
        Channel::create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

    /**
     * Update Channel
     * @param $name
     * @param $id
     */
    public function update($id,$name)
    {
        Channel::find($id)->update([
            'name'=>$name,
            'slug'=>Str::slug($name),
        ]);
    }

    /**
     * Delete Channel
     * @param $id
     */
    public function delete($id):void
    {
        Channel::destroy($id);
    }

}
