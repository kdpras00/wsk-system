<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // If user is manager, show all instructions they created
        if ($user->role === 'manager') {
            $instructions = Instruction::where('user_id', $user->id)->latest()->get();
            return view('manager.instructions.index', compact('instructions'));
        }

        abort(403, 'Unlimited power is not yours to wield.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.instructions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_role' => 'required|in:admin,operator,supervisor,all',
        ]);

        Instruction::create([
            'title' => $request->title,
            'description' => $request->description,
            'target_role' => $request->target_role,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('instructions.index')->with('success', 'Instruksi berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instruction $instruction)
    {
        // Ensure only the creator can edit (or basic manager check)
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }
        
        return view('manager.instructions.edit', compact('instruction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instruction $instruction)
    {
         $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_role' => 'required|in:admin,operator,supervisor,all',
        ]);

        $instruction->update($request->all());

        return redirect()->route('instructions.index')->with('success', 'Instruksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instruction $instruction)
    {
         if (Auth::user()->role !== 'manager') {
            abort(403);
        }

        $instruction->delete();

        return redirect()->route('instructions.index')->with('success', 'Instruksi berhasil dihapus.');
    }
}
