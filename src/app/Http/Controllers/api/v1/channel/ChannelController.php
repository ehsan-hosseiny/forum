<?php


namespace App\Http\Controllers\api\v1\channel;

use App\Models\Channel;
use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
//    protected $channel;
//
//    public function __construct()
//    {
//        $this->channel = resolve(ChannelRepository::class);
//    }

    public function getAllChannelsList()
    {
//        $all_channels = $this->channel->all();
        $all_channels = resolve(ChannelRepository::class)->all();
        return response()->json($all_channels, Response::HTTP_OK);
    }

    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        // Insert Channel Into Database
        resolve(ChannelRepository::class)->create($request->name);

        return response()->json(['message' => 'channel created successfully'],Response::HTTP_CREATED);
    }

    /**
     * Update Channel
     * @param Request $request
     * @return JsonResponse
     */
    public function updateChannel(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        // Update Channel In Database
        resolve(ChannelRepository::class)->update($request->id,$request->name);
        return response()->json(['message'=>'channel edited successfully'],Response::HTTP_OK);
    }

    /**
     * Delete Channel{s}
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteChannel(Request $request)
    {
        $request->validate([
            'id'=>'required'
        ]);

        // Delete Channel In Database
        resolve(ChannelRepository::class)->delete($request->id);
        return response()->json([
            'message'=>'channel deleted successfully'
        ],Response::HTTP_OK);

    }

}
