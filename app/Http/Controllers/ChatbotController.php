<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $mensaje = $request->message;
        $mensajeLower = strtolower($mensaje);

        // 🔥 traer productos
        $productos = Product::select('id','name','price')->get();

        // 🔹 lista para IA
        $lista = "";
        foreach ($productos as $p) {
            $lista .= "{$p->name} - S/ {$p->price}\n";
        }

        // ==============================
        // 🟢 1. VER PRODUCTOS
        // ==============================
        if (str_contains($mensajeLower, 'producto') || str_contains($mensajeLower, 'café')) {

            $topProductos = Product::take(5)->get();

            $respuesta = "☕ Nuestros productos:\n\n";

            foreach ($topProductos as $p) {
                $respuesta .= "👉 {$p->name} - S/ {$p->price}\n";
            }

            return response()->json(['reply' => $respuesta]);
        }

        // ==============================
        // 💰 2. CONSULTAR PRECIO
        // ==============================
        if (str_contains($mensajeLower, 'precio')) {

            foreach ($productos as $p) {
                if (str_contains($mensajeLower, strtolower($p->name))) {
                    return response()->json([
                        'reply' => "💰 {$p->name} cuesta S/ {$p->price}"
                    ]);
                }
            }

            return response()->json([
                'reply' => "¿De qué producto deseas saber el precio? 😊"
            ]);
        }

        // ==============================
        // 🔥 3. TOP VENDIDOS (IMPORTANTE)
        // ==============================
        if (str_contains($mensajeLower, 'top') || str_contains($mensajeLower, 'más vendido')) {

            // 👉 ajusta 'order_items' si tu tabla es otra
            $top = DB::table('order_items')
                ->select('product_id', DB::raw('COUNT(*) as total'))
                ->groupBy('product_id')
                ->orderByDesc('total')
                ->take(5)
                ->get();

            if ($top->isEmpty()) {
                return response()->json([
                    'reply' => "Aún no hay productos más vendidos 😅"
                ]);
            }

            $respuesta = "🔥 Productos más vendidos:\n\n";

            foreach ($top as $item) {
                $producto = Product::find($item->product_id);
                if ($producto) {
                    $respuesta .= "⭐ {$producto->name}\n";
                }
            }

            return response()->json(['reply' => $respuesta]);
        }

        // ==============================
        // 🤖 4. IA (SOLO SI NO ENTRA ARRIBA)
        // ==============================
        $prompt = "
        Eres un asistente de una cafetería llamada PROCAFES.

        SOLO responde sobre productos, precios y pedidos.

        Productos:
        $lista

        Si no sabes algo di: 'Te ayudamos en tienda 😊'
        ";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json'
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama3-8b-8192',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $mensaje],
            ],
        ]);

        $reply = $response['choices'][0]['message']['content'] ?? 'Error';

        return response()->json(['reply' => $reply]);
    }
}