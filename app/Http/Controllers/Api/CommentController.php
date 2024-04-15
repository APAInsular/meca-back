    <?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Api\CommentControllerStoreRequest;
    use App\Models\Comment;
    use Illuminate\Http\Request;


    class CommentController extends Controller
    {
        public function index(Request $request)
        {
            $comments = Comment::all();

            return response()->noContent(200);
        }

        public function store(CommentStoreRequest $request)
        {
            $comment = Comment::create($request->validated());

            return response()->noContent(201);
        }

        public function show(Request $request, Comment $comment)
        {
            return response()->noContent(200);
        }

        public function update(Request $request, Comment $comment)
        {
            $comment->update([]);

            return response()->noContent(200);
        }

        public function destroy(Request $request, Comment $comment)
        {
            $comment->delete();

            return response()->noContent();
        }

        public function error(Request $request)
        {
            return response()->noContent(400);
        }
    }
