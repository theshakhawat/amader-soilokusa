<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::orderBy('id', 'desc');

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::where('is_read', false)->count();
        $totalCount = ContactMessage::count();

        return view('admin.contact-messages.index', compact('messages', 'unreadCount', 'totalCount'));
    }

    /**
     * Display the specified message and mark as read.
     */
    public function show(ContactMessage $contactMessage)
    {
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Mark message as read/unread via AJAX.
     */
    public function toggleRead(ContactMessage $contactMessage)
    {
        $contactMessage->is_read = !$contactMessage->is_read;
        $contactMessage->save();

        return response()->json([
            'success' => true,
            'is_read' => $contactMessage->is_read,
            'message' => 'মেসেজের রিড স্ট্যাটাস পরিবর্তিত হয়েছে।',
        ]);
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'বার্তাটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}

