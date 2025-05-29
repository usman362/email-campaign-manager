<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = EmailTemplate::all();
        return view('templates.index',compact('templates'));
    }
    public function create()
    {
        return view('templates.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);
        $template = new EmailTemplate();
        $template->name = $request->name;
        $template->subject = $request->subject;
        $template->body = $request->body;
        $template->save();
        return redirect()->back()->with('success', 'Template Created Successfully');
    }
}
