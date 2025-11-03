<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property; // <-- Import your model
use Illuminate\Support\Facades\Auth; // <-- Import Auth

class PropertyController extends Controller
{
    /**
     * Display a listing of the user's properties.
     */
    public function index()
    {
        // Get all properties owned by the logged-in user
        $properties = Property::all();

        // Pass the $properties variable to your view
        return view('users.admin.owner.property', ['properties' => $properties]);
    }

    /**
     * Show the form for creating a new property.
     * For now, it just redirects to your "Add Unit" page.
     */
    public function create() {
        // You can change this later to point to a new "Add Property" form
        // For now, let's assume 'addunit' is the route name for your form
        return redirect()->route('landlord.property.add-unit');
    }
}
