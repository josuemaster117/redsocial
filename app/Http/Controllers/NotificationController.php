<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(15);  ##user autenticado,accede a notificacioines,ordena por fecha y pagina
        return view('notifications.index', compact('notifications')); ###retorna la vista con las notificaciones
    }

    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead(); ###usuario autenticado,notificaciones no leidas,marcar como leidas
        return back()->with('success', 'Notificaciones marcadas como leídas ✅'); ###retorna con mensaje de exito
    }
}
  ##Version de Query Bilder
//   public function index(Request $request)
//     {
//         $userId = $request->user()->id; <<<<obtiene el id del usuario autenticado

//         $notifications = DB::table('notifications')          <<<<<consulta a la tabla de notificaciones
//             ->where('notifiable_id', $userId)                <<<<<<<filtra por el id del usuario
//             ->where('notifiable_type', 'App\\Models\\Usuario') // Ajusta si tu modelo es diferente
//             ->orderByDesc('created_at')                      <<<<<<<ordena por fecha de creación descendente
//             ->paginate(15);                                  <<<<paginación de 15 por página

//         return view('notifications.index', compact('notifications')); <<<<<retorna la vista con las notificaciones
//     }



// public function markAllRead(Request $request) 
//     {
//         $userId = $request->user()->id;

//         DB::table('notifications')               <<<<consulta a la tabla de notificaciones
//             ->where('notifiable_id', $userId)    <<<filtra por el id del usuario
//             ->where('notifiable_type', 'App\\Models\\Usuario') // Ajusta si tu modelo es diferente
//             ->whereNull('read_at')               <<<filtra solo las no leídas
//             ->update([                          <---actualiza el campo read_at
//                 'read_at' => now()               <<<establece la fecha y hora actual
//             ]);

//         return back()->with('success', 'Notificaciones marcadas como leídas ✅');
//     }
