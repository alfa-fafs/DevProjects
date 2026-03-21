<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    // Show payment methods page
    public function index()
    {
        $methods = PaymentMethod::where('user_id', auth()->id())
            ->orderBy('is_default', 'desc')
            ->get();

        // Create default cash option if user has no methods
        if ($methods->isEmpty()) {
            PaymentMethod::create([
                'user_id'    => auth()->id(),
                'type'       => 'cash',
                'label'      => 'Cash',
                'icon'       => '💵',
                'is_default' => true,
            ]);
            $methods = PaymentMethod::where('user_id', auth()->id())->get();
        }

        return view('payment.index', compact('methods'));
    }

    // Set default payment method
    public function setDefault($id)
    {
        // Remove default from all
        PaymentMethod::where('user_id', auth()->id())
            ->update(['is_default' => false]);

        // Set new default
        PaymentMethod::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_default' => true]);

        return back()->with('success', 'Default payment method updated!');
    }

    // Add new payment method
    public function store(Request $request)
    {
        $request->validate([
            'type'  => 'required|in:visa,mastercard,mobile_money,cash',
            'label' => 'required|string|max:50',
        ]);

        $icons = [
            'visa'         => '💳',
            'mastercard'   => '💳',
            'mobile_money' => '📱',
            'cash'         => '💵',
        ];

        PaymentMethod::create([
            'user_id'    => auth()->id(),
            'type'       => $request->type,
            'label'      => $request->label,
            'icon'       => $icons[$request->type],
            'is_default' => false,
        ]);

        return back()->with('success', 'Payment method added!');
    }

    // Delete payment method
    public function destroy($id)
    {
        PaymentMethod::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Payment method removed!');
    }
}