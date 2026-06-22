<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class ContactController extends Controller
{
    private const CONTACT_RECEIVER = 'haohuynh090805@gmail.com';

    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ], [
            'name.required' => 'Vui long nhap ho va ten.',
            'phone.required' => 'Vui long nhap so dien thoai.',
            'email.required' => 'Vui long nhap dia chi email.',
            'email.email' => 'Dia chi email khong dung dinh dang.',
        ]);

        $contactData = [
            'fullname' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'status' => 0,
            'created_at' => now(),
        ];

        if (Schema::hasColumn('contacts', 'updated_at')) {
            $contactData['updated_at'] = now();
        }

        DB::table('contacts')->insert($contactData);

        Mail::send('emails.contact-notification', [
            'contact' => $contactData,
        ], function ($message) use ($request) {
            $message->to(self::CONTACT_RECEIVER)
                ->replyTo($request->input('email'), $request->input('name'))
                ->subject('Blue Wave Travel - Yeu cau lien he moi');
        });

        return redirect()->back()->with('success', 'Gui yeu cau lien he thanh cong! Blue Wave se som phan hoi ban.');
    }
}
