<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Show support tickets for customer.
     */
    public function index()
    {
        $user = auth()->user();
        $tickets = $user->supportTickets()->orderBy('created_at', 'desc')->paginate(20);
        
        return view('support.index', compact('tickets'));
    }

    /**
     * Show create ticket form.
     */
    public function create()
    {
        return view('support.create');
    }

    /**
     * Store new support ticket.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $user = auth()->user();
        
        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return redirect()->route('support.index')
            ->with('success', 'Support ticket created successfully.');
    }

    /**
     * Show ticket details.
     */
    public function show(SupportTicket $ticket)
    {
        // Check if user has access to this ticket
        if ($ticket->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('support.show', compact('ticket'));
    }

    /**
     * Admin: Show all support tickets.
     */
    public function adminIndex()
    {
        $tickets = SupportTicket::with('user.company')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.support.index', compact('tickets'));
    }

    /**
     * Admin: Update ticket status.
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,closed,awaiting_reply',
        ]);

        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Ticket status updated successfully.');
    }

    /**
     * Admin: Reply to ticket.
     */
    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'reply' => 'required|string|max:5000',
        ]);

        // In a real application, you would store replies in a separate table
        // For now, we'll just update the ticket status
        $ticket->update([
            'status' => 'awaiting_reply',
            'message' => $ticket->message . "\n\n--- Admin Reply ---\n" . $request->reply,
        ]);

        return back()->with('success', 'Reply sent successfully.');
    }
}
