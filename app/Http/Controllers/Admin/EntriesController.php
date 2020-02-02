<?php

namespace App\Http\Controllers\Admin;

use App\Entry;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('entries.index', [
            'entries' => Entry::orderBy('created_at', 'desc')->paginate(3),
        ]);
    }

    /**
     * Display a listing of the resource per user.
     *
     * @param User $user
     * @return Response
     */
    public function profile(User $user)
    {
        return view('entries.index', [
            'entries' => Entry::where('created_by', Auth::id())->orderBy('created_at', 'desc')->paginate(3),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Entry $entry
     * @return Response
     */
    public function create(Entry $entry)
    {
        return view('admin.entries.create', compact('entry'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = array_merge($request->except('_token'), [
            'created_by' => Auth::id(),
            'friendly_url_hash' => hash('md5', $request->input('entry_url')),
        ]);

        $entry = Entry::create($data);

        return redirect()->route('entries.show', compact('entry'))->with([
            'success' => __('entries.messages.created'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Entry $entry
     * @return Response
     */
    public function show(Entry $entry)
    {
        return view('entries.show', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Entry $entry
     * @return Response
     */
    public function edit(Entry $entry)
    {
        return view('admin.entries.edit', compact('entry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Entry $entry
     * @return Response
     */
    public function update(Request $request, Entry $entry)
    {
        $data = array_merge($request->except('_token'), [
            'friendly_url_hash' => hash('md5', $request->input('entry_url')),
        ]);

        $entry->update($data);

        return redirect()->route('entries.show', compact('entry'))->with([
            'success' => __('entries.messages.updated'),
        ]);
    }
}
