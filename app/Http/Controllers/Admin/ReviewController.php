<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

class ReviewController extends Controller
{
    private $responseFactory;

    private $title = 'Review';
    private $titleMany = 'Reviews';

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = $this->title;
        $titleMany = $this->titleMany;

        $reviews = Review::paginate(20);

        return $this->responseFactory->view(
            'pages.admin.review.index',
            compact('reviews', 'titleMany', 'title')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $titleMany = $this->titleMany;

        $users = User::all();

        return $this->responseFactory->view(
            'pages.admin.review.create',
            compact('title', 'titleMany', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $review = Review::create([
            'user_id' => $request->user_id,
            'text' => $request->text,
            'moderated' => $request->moderated
        ]);

        return redirect()->route('review.index')->withSuccess('Review successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @return Response
     */
    public function show(Review $review)
    {
        return redirect()->route('review.edit', compact('review'))->withSuccess('Edit review');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Review $review
     * @return Response
     */
    public function edit(Review $review)
    {
        $title = $this->title;
        $titleMany = $this->titleMany;

        $users = User::all();

        return $this->responseFactory->view(
            'pages.admin.review.edit',
            compact('title', 'titleMany', 'users', 'review')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Review $review
     * @return Response
     */
    public function update(Request $request, Review $review)
    {
        $review->update([
            'user_id' => $request->user_id,
            'text' => $request->text,
            'moderated' => $request->moderated
        ]);

        return redirect()->route('review.index')->withSuccess('Review successfully changed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Review $review
     * @return Response
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->back()->withSuccess('Review deleted!');
    }
}
