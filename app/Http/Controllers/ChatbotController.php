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

        $productos = Product::all();

        // ==============================
        // 🟢 1. SALUDO → IA
        // ==============================
        if (
            str_contains($mensajeLower, 'hola') ||
            str_contains($mensajeLower, 'buenas')
        ) {
            return $this->respuestaIA($mensaje, $productos);
        }

        // ==============================
        // ☕ 2. VER PRODUCTOS
        // ==============================
        if (str_contains($mensajeLower, 'producto')) {

            $respuesta = "☕ Tenemos estos productos:\n\n";

            foreach ($productos->take(5) as $p) {
                $respuesta .= "👉 {$p->name} - S/ {$p->price}\n";
            }

            return response()->json(['reply' => $respuesta]);
        }

        // ==============================
        // 3. PRECIO INTELIGENTE (MEJORADO)
        // ==============================
        if (
            str_contains($mensajeLower, 'precio') ||
            str_contains($mensajeLower, 'cuesta')
        ) {

            $mejorProducto = null;
            $mejorScore = 0;

            foreach ($productos as $p) {

                $nombre = strtolower($p->name);

                similar_text($mensajeLower, $nombre, $porcentaje);

                if ($porcentaje > $mejorScore) {
                    $mejorScore = $porcentaje;
                    $mejorProducto = $p;
                }
            }

            if ($mejorProducto && $mejorScore > 30) {
                return response()->json([
                    'reply' => "💰 {$mejorProducto->name} cuesta S/ {$mejorProducto->price}"
                ]);
            }

            return response()->json([
                'reply' => "No encontré ese producto 😅 ¿Puedes escribirlo nuevamente?"
            ]);
        }

        // ==============================
        // 🔥 4. TOP VENDIDOS
        // ==============================
        if (
            str_contains($mensajeLower, 'top') ||
            str_contains($mensajeLower, 'más vendido')
        ) {

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
        // 🤖 5. DEFAULT → IA
        // ==============================
        return $this->respuestaIA($mensaje, $productos);
    }

    // ==============================
    // 🤖 FUNCIÓN IA (GROQ)
    // ==============================
    private function respuestaIA($mensaje, $productos)
    {
        $lista = "";
        foreach ($productos as $p) {
            $lista .= "{$p->name} - S/ {$p->price}\n";
        }

        $prompt = "
        Eres un asistente de PROCAFES.

        SOLO responde sobre cafetería, productos y pedidos.

        Productos:
        $lista

        Responde corto y amable.
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

        if (!$response->successful()) {
            return response()->json([
                'reply' => '⚠️ Error con IA'
            ]);
        }

        $reply = $response['choices'][0]['message']['content'] ?? 'No entendí 🤔';

        return response()->json(['reply' => $reply]);
    }
}