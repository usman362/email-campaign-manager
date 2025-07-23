<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $templates = EmailTemplate::where('user_id',Auth::id())->get();
        return view('templates.index', compact('templates'));
    }
    public function create()
    {
        return view('templates.create');
    }

    public function edit($id)
    {
        $template = EmailTemplate::find($id);
        return view('templates.edit', compact('template'));
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
        $template->user_id =  Auth::id();
        $template->save();
        return redirect(route('templates.index'))->with('success', 'Template Created Successfully');
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);
        $template = EmailTemplate::find($id);
        $template->name = $request->name;
        $template->subject = $request->subject;
        $template->body = $request->body;
        $template->user_id = Auth::id();
        $template->save();
        return redirect(route('templates.index'))->with('success', 'Template Updated Successfully');
    }

    public function destroy($id)
    {
        $template = EmailTemplate::find($id);
        if($template->delete()){
            return redirect(route('templates.index'))->with('success', 'Template Deleted Successfully');
        }else{
            return redirect(route('templates.index'))->with('error', 'Something Went Wrong!');
        }
    }
}
