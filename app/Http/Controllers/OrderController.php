<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    function show()
    {

        $cartSummary = $this->getCartSummary();

        if ($cartSummary->total_qty == 0) {
            return redirect()->route('index')->with('error', 'Seu carrinho está vazio, não é possível efetuar uma compra.');
        }

        return view("main.checkout", compact("cartSummary"));
    }

    function store(Request $request)
    {
        $request->validate([
            'card_number' => ['required', 'string', 'regex:/^\d{13,16}$/'],
            'card_name' => 'required|string|max:100',
            'cvv' => ['required', 'string', 'size:3'],
            'expiry_date' => 'required|string|date_format:m/y',
        ]);

        $addressData = $request->validate([
            'full_name' => 'required|string|max:255',
            'cep' => ['required', 'string', 'max:10', 'regex:/^\d{5}-?\d{3}$/'],
            'street' => 'required|string|max:255',
            'number' => ['required', 'int', 'regex:/[0-9]/'],
            'complement' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:2',
        ]);

        $userId = Session('user')['id'];
        $cartSummary = $this->getCartSummary();

        if ($cartSummary->total_qty == 0) {
            return redirect()->route('index')->with('error', 'Seu carrinho está vazio.');
        }

        $state = $addressData['state'];
        $configKey = 'shipping.rates.' . $state;
        $shippingCost = config($configKey, config('shipping.default_rate'));

        DB::beginTransaction();

        try {
            Order::create([
                'user_id' => $userId,
                'total_price' => $cartSummary->total_price + $shippingCost,
                'shipping_cost' => $shippingCost,
                'status' => 'Completo',

                'cep' => $addressData['cep'],
                'street' => $addressData['street'],
                'number' => $addressData['number'],
                'complement' => $addressData['complement'],
                'city' => $addressData['city'],
                'state' => $addressData['state'],
            ]);

            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('index')->with('success', 'Pedido finalizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro no checkout - Pedido Geral: " . $e->getMessage());

            return back()->withInput()->with('error', 'Ocorreu um erro ao finalizar o pedido. Detalhe: ' . $e->getMessage());
        }
    }

    private function getCartSummary()
    {
        $cartItems = Cart::where('user_id', Session('user')['id'])
            ->with('product')
            ->get();

        return (object) [
            'total_qty' => $cartItems->sum(fn($item) => $item->quantity),
            'total_price' => $cartItems->sum(fn($item) => $item->quantity * $item->product->price)
        ];
    }
}
