<?php
namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use App\Topics;
use App\Messages;
use Webpatser\Uuid\Uuid;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class TopicsController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function getTopics(Request $request)
    {
        // if ($this->isTokenExpired()) {
        //     return response()->json([
        //         'token_expired' => 'token is expired'
        //     ]); 
        // }

        $token = $request->get('token'); 
        
        if (!$user = $this->getUser($token)) {
            return response()->json(['message' => 'Invalid request']);
        }

        return response()->json([
            'data' => Topics::all()
        ]);
    }

    public function postTopic(Request $request)
    {
        
        $token = $request->get('token');  
        
        if (!$user = $this->getUser($token)) {
            return response()->json(['message' => 'Invalid request']);
        }

        $this->validate($request, [
            'subject'    => 'required|max:255'
        ]);

        $subject = $request->get('subject');
        $description = $request->get('description');

        $uuid = Uuid::generate()->string;
        $topic = new Topics;
        $topic->id = $uuid;
        $topic->subject = $subject;
        $topic->description = $description;
        $topic->created_by = $user->id;
        $topic->updated_by = $user->id;

        $topic->save();

        return response()->json([
            'id' => $topic->id,
            'subject' => $topic->subject,
            'description' => $topic->description,
            'created_by' => $topic->created_by,
            'updated_by' => $topic->updated_by,
            'created_at' => date('c', strtotime($topic->created_at)),
            'updated_at' => date('c', strtotime($topic->updated_at))
        ]);

    }

    public function updateTopic(Request $request, $id)
    {
        $token = $request->get('token');
        
        if (!$user = $this->getUser($token)) {
            return response()->json(['error' => 'Invalid request'], 401);
        }

        $subject = $request->get('subject');
        $description = $request->get('description');

        $this->validate($request, [
            'subject'    => 'required|max:255'
        ]);

        $topic = Topics::where('id', $id)->first();

        if (!$topic) {
            return response()->json(['error' => 'Topic not found']);
        }

        $topic->subject = $subject;
        $topic->description = $description;
        $topic->updated_by = $user->id;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->save();

        return response()->json([
            'id' => $topic->id,
            'subject' => $topic->subject,
            'description' => $topic->description,
            'created_by' => $topic->created_by,
            'updated_by' => $topic->updated_by,
            'created_at' => date('c', strtotime($topic->created_at)),
            'updated_at' => date('c', strtotime($topic->updated_at))
        ]);
    }

    public function deleteTopic(Request $request, $id)
    {
        $token = $request->get('token');
        
        if (!$user = $this->getUser($token)) {
            return response()->json(['error' => 'Invalid request'], 401);
        }

        $topic = Topics::where('id', $id)->first();
        if (!$topic) {
            return response()->json(['error' => 'Topic not found']);
        }

        $topic->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function addMessageToTopic(Request $request, $id)
    {
        $token = $request->get('token');
        $messageParam = $request->get('message');
        
        if (!$user = $this->getUser($token)) {
            return response()->json(['error' => 'Invalid request'], 401);
        }

        $message = new Messages;
        $message->id = Uuid::generate()->string;
        $message->topics_id = $id;
        $message->message = $messageParam;
        $message->updated_by = $user->id;
        $message->created_by = $user->id;
        $message->save();

        return response()->json([
            'id' => $message->id,
            'topic_id' => $message->topics_id,
            'message' => $message->message,
            'created_by' => $message->created_by,
            'updated_by' => $message->updated_by,
            'created_at' => date('c', strtotime($message->created_at)),
            'updated_at' => date('c', strtotime($message->updated_at))
        ]);
    }

    public function getMessages(Request $request)
    {
        $token = $request->get('token');
        $messageParam = $request->get('message');
        
        if (!$user = $this->getUser($token)) {
            return response()->json(['error' => 'Invalid request'], 401);
        }

        return response()->json([
            'data' => Messages::all()
        ]);
    }

    private function getUser($token)
    {
        if (!$token) {
            return false;
        }
        
        $this->jwt->setToken($token);
        return $this->jwt->toUser();
    }

    private function isTokenExpired()
    {
        return !$this->jwt->check();
    }
}