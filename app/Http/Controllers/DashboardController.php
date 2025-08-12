<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request, OrderRepository $orderRepo)
    {
        $guest = session('guest');
        $order = $orderRepo->getOrderDataFromSession();

        $totalHarga = $this->calculateOrderTotal($order);

        $category = $request->query('category');

        $products = Product::query()
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->where('is_available', true)
            ->latest()
            ->paginate(12);
        if (!$order) $order = [];
        $countOrder = count($order);
        return view('pages.index', compact('products', 'order', 'category', 'countOrder', 'totalHarga'));
    }

    private function calculateOrderTotal($order)
    {
        $total = 0;
        if (!$order) return [];
        foreach ($order as $item) {
            $productPrice = (float) $item['price'];
            $quantity = (int) $item['quantity'];
            $toppingsTotal = array_sum(array_column($item['toppings'], 'price'));
            $total += ($productPrice + $toppingsTotal) * $quantity;
        }
        return $total;
    }
}
