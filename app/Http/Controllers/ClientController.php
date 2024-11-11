<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function clients_page()
    {
        $reviews = ReviewModel::all();
        return view('admin.client_says', compact('reviews'));
    }
    public function add_clients_reivew(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'image' => 'required|file|mimes:jpeg,png,jpg,webp',
                "name" => "required",
                "heading" => "required",
                "review" => "required",
                "star" => "required",

            ]);


            $file = $request->file('image');


            $targetDirectory = 'uploads/Client Images/';


            $fileName = $file->getClientOriginalName();
            $file->move(public_path($targetDirectory), $file->getClientOriginalName());

            ReviewModel::create([
                'image' => $fileName,
                'name' => $request->name,
                'stars' => $request->star,
                'head' => $request->heading,
                'review' => $request->review,

            ]);

            return redirect()->back()->with('success', 'Review Added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }

    }

    public function adm_client_delete_review($id)
    {
        ReviewModel::find($id)->delete();
        return redirect()->back()->with('delete_success', 'Review deleted successfully.');
    }


    public function update_client_reiview_page($id)
    {
        $review = ReviewModel::findOrFail($id);
        return view('admin.client_says_update_page',compact('review'));
    }

    public function update_client_reiview(Request $request, $id)
{
    try {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg,webp',
        ]);

        // Find the existing review
        $review = ReviewModel::findOrFail($id);
        if (!$review) {
            // Handle the case where the review with the given ID does not exist
            return redirect()->back()->with("reviewNotFound", "Review not found.");
        }
        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $targetDirectory = 'uploads/Client Images/';
            $fileName = $file->getClientOriginalName();

            // Unlink existing image if it exists
            if (file_exists(public_path($targetDirectory . $review->image))) {
                unlink(public_path($targetDirectory . $review->image));
            }

            // Move and save the new image
            $file->move(public_path($targetDirectory), $fileName);
            $review->image = $fileName;
        }

        // Update review details
        $review->name = $request->name;
        $review->stars = $request->star;
        $review->head = $request->heading;
        $review->review = $request->review;
        $review->save();

        return redirect()->back()->with('success', 'Review updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with("error", $e->getMessage());
    }
}

}
